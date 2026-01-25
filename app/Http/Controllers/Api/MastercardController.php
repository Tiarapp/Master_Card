<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mastercard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MastercardController extends Controller
{
    /**
     * Get mastercards with search functionality
     */
    public function index(Request $request)
    {
        try {
            // Debug: Log the request
            Log::info('Mastercard API called with search: ' . ($request->search ?? 'no search'));
            
            // Get pagination parameters
            $page = $request->get('page', 1);
            $perPage = $request->get('per_page', 10);
            $offset = ($page - 1) * $perPage;
            
            // Try using Mastercard model first
            $query = Mastercard::query();

            if ($request->has('search') && !empty($request->search)) {
                $search = trim($request->search);
                $query = $query->where(function($q) use ($search) {
                    $q->where('namaBarang', 'LIKE', '%'.$search.'%')
                      ->orWhere('customer', 'LIKE', '%'.$search.'%')
                      ->orWhere('kodeBarang', 'LIKE', '%'.$search.'%')
                      ->orWhere('kode', 'LIKE', '%'.$search.'%');
                });
            }

            // Get total count
            $totalCount = $query->count();
            
            // Get paginated results
            $mastercards = $query->orderBy('namaBarang', 'asc')
                              ->skip($offset)
                              ->take($perPage)
                              ->get();
            
            // Debug: Log the count
            Log::info('Mastercard count from model: ' . $mastercards->count());

            // Transform the data to consistent format
            $transformedMastercards = $mastercards->map(function($mastercard) {
                return [
                    'id' => $mastercard->id,
                    'kode' => $mastercard->kode,
                    'nama' => $mastercard->namaBarang,
                    'name' => $mastercard->namaBarang, // alias for compatibility
                    'customer' => $mastercard->customer,
                    'kode_barang' => $mastercard->kodeBarang,
                    'tipebox' => $mastercard->tipebox,
                    'revisi' => $mastercard->revisi,
                ];
            });

            // Calculate pagination info
            $totalPages = ceil($totalCount / $perPage);

            return response()->json([
                'success' => true,
                'data' => $transformedMastercards,
                'pagination' => [
                    'current_page' => (int) $page,
                    'per_page' => (int) $perPage,
                    'total' => (int) $totalCount,
                    'total_pages' => (int) $totalPages,
                    'from' => $offset + 1,
                    'to' => min($offset + $perPage, $totalCount),
                ],
                'message' => 'Data mastercard berhasil diambil'
            ]);

        } catch (\Exception $e) {
            Log::error('Mastercard API error (Model): ' . $e->getMessage());
            Log::error('Mastercard API stack trace: ' . $e->getTraceAsString());
            
            // Fallback to DB facade
            try {
                Log::info('Trying DB facade fallback for mastercards...');
                
                // Get pagination parameters
                $page = $request->get('page', 1);
                $perPage = $request->get('per_page', 10);
                $offset = ($page - 1) * $perPage;
                
                $query = DB::table('mc');
                
                if ($request->has('search') && !empty($request->search)) {
                    $search = trim($request->search);
                    $query = $query->where(function($q) use ($search) {
                        $q->where('namaBarang', 'LIKE', '%'.$search.'%')
                          ->orWhere('customer', 'LIKE', '%'.$search.'%')
                          ->orWhere('kodeBarang', 'LIKE', '%'.$search.'%')
                          ->orWhere('kode', 'LIKE', '%'.$search.'%');
                    });
                }

                // Get total count
                $totalCount = $query->count();
                
                // Get paginated results
                $mastercards = $query->orderBy('namaBarang', 'asc')
                                  ->skip($offset)
                                  ->take($perPage)
                                  ->get();
                
                // Debug: Log the count from DB
                Log::info('Mastercard count from DB: ' . count($mastercards));
                
                // Transform the data to consistent format
                $transformedMastercards = collect($mastercards)->map(function($mastercard) {
                    return [
                        'id' => $mastercard->id,
                        'kode' => $mastercard->kode,
                        'nama' => $mastercard->namaBarang,
                        'name' => $mastercard->namaBarang, // alias for compatibility
                        'customer' => $mastercard->customer,
                        'kode_barang' => $mastercard->kodeBarang,
                        'tipebox' => $mastercard->tipebox,
                        'revisi' => $mastercard->revisi,
                    ];
                });

                // Calculate pagination info
                $totalPages = ceil($totalCount / $perPage);

                return response()->json([
                    'success' => true,
                    'data' => $transformedMastercards,
                    'pagination' => [
                        'current_page' => (int) $page,
                        'per_page' => (int) $perPage,
                        'total' => (int) $totalCount,
                        'total_pages' => (int) $totalPages,
                        'from' => $offset + 1,
                        'to' => min($offset + $perPage, $totalCount),
                    ],
                    'message' => 'Data mastercard berhasil diambil (fallback)'
                ]);
                
            } catch (\Exception $e2) {
                Log::error('Mastercard API error (DB): ' . $e2->getMessage());
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
                    'message' => 'Gagal mengambil data mastercard: ' . $e2->getMessage(),
                    'error' => $e2->getMessage()
                ], 500);
            }
        }
    }

    /**
     * Get specific mastercard by ID
     */
    public function show($id)
    {
        try {
            $mastercard = Mastercard::find($id);
            
            if (!$mastercard) {
                return response()->json([
                    'success' => false,
                    'data' => null,
                    'message' => 'Mastercard tidak ditemukan'
                ], 404);
            }

            $transformedMastercard = [
                'id' => $mastercard->id,
                'kode' => $mastercard->kode,
                'nama' => $mastercard->namaBarang,
                'name' => $mastercard->namaBarang,
                'customer' => $mastercard->customer,
                'part_number' => $mastercard->part_number ?? '',
                'ukuran' => $mastercard->ukuran ?? '',
                'bahan' => $mastercard->bahan ?? '',
            ];

            return response()->json([
                'success' => true,
                'data' => $transformedMastercard,
                'message' => 'Data mastercard ditemukan'
            ]);

        } catch (\Exception $e) {
            Log::error('Mastercard show API error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'Gagal mengambil data mastercard: ' . $e->getMessage()
            ], 500);
        }
    }
}