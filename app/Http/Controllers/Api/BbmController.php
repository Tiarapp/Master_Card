<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BbmTeknik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class BbmController extends Controller
{
    /**
     * Get paginated BBM data with search functionality
     */
    public function index(Request $request)
    {
        try {
            Log::info('BBM API called with params:', $request->all());

            // Get pagination parameters
            $page = $request->get('page', 1);
            $perPage = $request->get('per_page', 10);
            
            $query = BbmTeknik::with(['po_teknik', 'barang_teknik'])
                ->whereHas('po_teknik', function($subQuery) {
                    $subQuery->where('NoLC', 'like', '%KARET%')
                             ->orWhere('NoLC', 'like', '%PISAU%');
                })
                ->where(function($subQuery) {
                    $subQuery->where('ESTIMASI', '!=', 1);
                }); // Exclude records where ESTIMASI is 1

            // Add search functionality
            if ($request->has('search') && !empty($request->search)) {
                $search = trim($request->search);
                $query = $query->where(function($q) use ($search) {
                    $q->where('NoBukti', 'LIKE', '%'.$search.'%')
                      ->orWhere('KodeBrg', 'LIKE', '%'.$search.'%')
                      ->orWhere('NoOP', 'LIKE', '%'.$search.'%')
                      ->orWhereHas('barang_teknik', function($subQuery) use ($search) {
                          $subQuery->where('NamaBrg', 'LIKE', '%'.$search.'%')
                                ->orWhere('Spesifikasi', 'LIKE', '%'.$search.'%');
                      })
                      ->orWhereHas('po_teknik', function($subQuery) use ($search) {
                          $subQuery->where('NoLC', 'LIKE', '%'.$search.'%');
                      });
                });
            }


            // Get paginated results with relationships
            $bbmData = $query->orderBy('NoBukti', 'desc')
                           ->paginate($perPage, ['*'], 'page', $page);

            // Debug: Log the count
            Log::info('BBM count: ' . $bbmData->count());

            // Transform the data to consistent format
            $transformedBbm = $bbmData->getCollection()->map(function($bbm) {
                $cleanNoBukti = trim($bbm->NoBukti ?? '');
                $cleanKodeBrg = trim($bbm->KodeBrg ?? '');
                return [
                    'id' => $bbm->NoUrut ?? ($cleanNoBukti . '_' . $cleanKodeBrg), // Use primary key or create unique ID
                    'NoBukti' => $cleanNoBukti,
                    'KodeBrg' => $cleanKodeBrg,
                    'NamaBrg' => trim($bbm->barang_teknik->NamaBrg ?? '') . ' ' . trim($bbm->barang_teknik->Spesifikasi ?? ''),
                    'NoOP' => trim($bbm->NoOP ?? ''),
                    'NoLC' => trim($bbm->po_teknik->NoLC ?? '-'),
                    'SubTotal' => round(floatval($bbm->SubTotal ?? 0), 2),
                ];
            });

            // Prepare pagination info
            $pagination = [
                'current_page' => $bbmData->currentPage(),
                'per_page' => $bbmData->perPage(),
                'total' => $bbmData->total(),
                'total_pages' => $bbmData->lastPage(),
                'from' => $bbmData->firstItem() ?: 0,
                'to' => $bbmData->lastItem() ?: 0,
            ];

            return response()->json([
                'success' => true,
                'data' => $transformedBbm,
                'pagination' => $pagination,
                'message' => 'Data BBM berhasil diambil'
            ]);

        } catch (\Exception $e) {
            Log::error('BBM API error (Model): ' . $e->getMessage());
            Log::error('BBM API stack trace: ' . $e->getTraceAsString());
            
            // Fallback to DB facade
            try {
                Log::info('Trying DB facade fallback for BBM...');
                
                // Get pagination parameters
                $page = $request->get('page', 1);
                $perPage = $request->get('per_page', 10);
                $offset = ($page - 1) * $perPage;
                
                $query = DB::connection('fbteknik')
                          ->table('TDetBBMTK as bbm')
                          ->leftJoin('TDetOPTK as po', 'bbm.NoOP', '=', 'po.NoOP')
                          ->leftJoin('TBarang as brg', 'bbm.KodeBrg', '=', 'brg.KodeBrg')
                          ->select([
                              'bbm.NoBukti',
                              'bbm.KodeBrg', 
                              'brg.NamaBrg',
                              'bbm.NoOP',
                              'bbm.SubTotal',
                              'po.NoLC'
                          ])
                          ->where(function($subQuery) {
                              $subQuery->where('bbm.ESTIMASI', '!=', 1)
                                       ->orWhereNull('bbm.ESTIMASI');
                          })
                          ->where(function($subQuery) {
                              $subQuery->where('po.NoLC', 'like', '%KARET%')
                                       ->orWhere('po.NoLC', 'like', '%PISAU%');
                          });
                
                if ($request->has('search') && !empty($request->search)) {
                    $search = trim($request->search);
                    $query = $query->where(function($q) use ($search) {
                        $q->where('bbm.NoBukti', 'LIKE', '%'.$search.'%')
                          ->orWhere('bbm.KodeBrg', 'LIKE', '%'.$search.'%')
                          ->orWhere('bbm.NoOP', 'LIKE', '%'.$search.'%')
                          ->orWhere('brg.NamaBrg', 'LIKE', '%'.$search.'%')
                          ->orWhere('po.NoLC', 'LIKE', '%'.$search.'%');
                    });
                }

                // Get total count
                $totalCount = $query->count();
                
                // Get paginated results
                $bbmItems = $query->orderBy('bbm.NoBukti', 'desc')
                                 ->skip($offset)
                                 ->take($perPage)
                                 ->get();
                
                // Debug: Log the count from DB
                Log::info('BBM count from DB: ' . count($bbmItems));
                
                // Transform the data to consistent format
                $transformedBbm = collect($bbmItems)->map(function($bbm) {
                    $cleanNoBukti = trim($bbm->NoBukti ?? '');
                    $cleanKodeBrg = trim($bbm->KodeBrg ?? '');
                    return [
                        'id' => $cleanNoBukti . '_' . $cleanKodeBrg, // Create a unique ID
                        'NoBukti' => $cleanNoBukti,
                        'KodeBrg' => $cleanKodeBrg,
                        'NamaBrg' => trim($bbm->NamaBrg ?? ''),
                        'NoOP' => trim($bbm->NoOP ?? ''),
                        'NoLC' => trim($bbm->NoLC ?? '-'),
                        'SubTotal' => round(floatval($bbm->SubTotal ?? 0), 2),
                    ];
                });

                // Calculate pagination info
                $totalPages = ceil($totalCount / $perPage);

                return response()->json([
                    'success' => true,
                    'data' => $transformedBbm,
                    'pagination' => [
                        'current_page' => (int) $page,
                        'per_page' => (int) $perPage,
                        'total' => (int) $totalCount,
                        'total_pages' => (int) $totalPages,
                        'from' => $offset + 1,
                        'to' => min($offset + $perPage, $totalCount),
                    ],
                    'message' => 'Data BBM berhasil diambil (fallback)'
                ]);
                
            } catch (\Exception $e2) {
                Log::error('BBM API error (DB): ' . $e2->getMessage());
                Log::error('DB error stack trace: ' . $e2->getTraceAsString());
                
                return response()->json([
                    'success' => false,
                    'data' => [],
                    'pagination' => [
                        'current_page' => 1,
                        'per_page' => 10,
                        'total' => 0,
                        'total_pages' => 0,
                        'from' => 0,
                        'to' => 0,
                    ],
                    'message' => 'Gagal mengambil data BBM: ' . $e2->getMessage()
                ], 500);
            }
        }
    }

    /**
     * Get specific BBM by ID
     */
    public function show($id)
    {
        try {
            $bbm = BbmTeknik::with(['po_teknik', 'barang_teknik'])
                ->whereHas('po_teknik', function($subQuery) {
                    $subQuery->where('NoLC', 'like', '%KARET%')
                             ->orWhere('NoLC', 'like', '%PISAU%');
                })
                ->where(function($subQuery) {
                    $subQuery->where('ESTIMASI', '!=', 1)
                             ->orWhereNull('ESTIMASI');
                })
                ->find($id);
            
            if (!$bbm) {
                return response()->json([
                    'success' => false,
                    'data' => null,
                    'message' => 'Data BBM tidak ditemukan'
                ], 404);
            }

            $cleanNoBukti = trim($bbm->NoBukti ?? '');
            $cleanKodeBrg = trim($bbm->KodeBrg ?? '');
            $transformedBbm = [
                'id' => $bbm->id ?? ($cleanNoBukti . '_' . $cleanKodeBrg),
                'NoBukti' => $cleanNoBukti,
                'KodeBrg' => $cleanKodeBrg,
                'NamaBrg' => trim($bbm->barang_teknik->NamaBrg ?? ''),
                'NoOP' => trim($bbm->NoOP ?? ''),
                'NoLC' => trim($bbm->po_teknik->NoLC ?? '-'),
                'SubTotal' => round(floatval($bbm->SubTotal ?? 0), 2),
            ];

            return response()->json([
                'success' => true,
                'data' => $transformedBbm,
                'message' => 'Data BBM ditemukan'
            ]);

        } catch (\Exception $e) {
            Log::error('BBM show API error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'Gagal mengambil data BBM: ' . $e->getMessage()
            ], 500);
        }
    }
}