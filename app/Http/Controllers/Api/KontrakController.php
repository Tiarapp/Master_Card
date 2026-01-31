<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kontrak_D;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Kontrak_M;

class KontrakController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Get parameters
            $search = $request->get('search', '');
            $page = (int) $request->get('page', 1);
            $perPage = (int) $request->get('per_page', 10);
            
            // Start building query using Kontrak_M model
            $query = Kontrak_D::query()->with([
                'kontrakm' => function($q) {
                    $q->select('id', 'kode as KodeKontrak', 'customer_name', 'tglKontrak', 'harga_pisau', 'harga_karet', 'Status');
                },
                'mc' => function($q) {
                    $q->select('id', 'kode', 'revisi', 'namaBarang', 'kodeBarang');
                }
            ]);

            // Add search functionality
            if (!empty($search)) {
                $query->where(function($q) use ($search) {
                    $q->whereHas('kontrakm', function($subQuery) use ($search) {
                        $subQuery->where('kode', 'LIKE', '%' . $search . '%')
                                 ->orWhere('customer_name', 'LIKE', '%' . $search . '%');
                    })
                    ->orWhereHas('mc', function($subQuery) use ($search) {
                        $subQuery->where('kode', 'LIKE', '%' . $search . '%')
                                 ->orWhere('namaBarang', 'LIKE', '%' . $search . '%');
                    });
                });
            }

            // Get total count for pagination
            $total = $query->count();
            
            // Calculate pagination
            $totalPages = ceil($total / $perPage);
            $offset = ($page - 1) * $perPage;
            
            // Get paginated data
            $kontraks = $query->skip($offset)
                ->take($perPage)
                ->orderBy('id', 'desc')
                ->get()
                ->map(function($kontrak) {

                    if ($kontrak->mc->revisi == '' || $kontrak->mc->revisi == 'R0') {
                        $mc = $kontrak->mc->kode;
                    } else {
                        $mc = $kontrak->mc->kode . ' - ' . $kontrak->mc->revisi;
                    };

                    return [
                        'id' => $kontrak->id,
                        'NoKontrak' => $kontrak->kontrakm->KodeKontrak,
                        'Customer' => $kontrak->kontrakm->customer_name,
                        'TglKontrak' => $kontrak->kontrakm->tglKontrak ? date('Y-m-d', strtotime($kontrak->kontrakm->tglKontrak)) : null,
                        'HargaPisau' => (float) $kontrak->kontrakm->harga_pisau,
                        'HargaKaret' => (float) $kontrak->kontrakm->harga_karet,
                        'mcKode' => $mc,
                        'mc_id' => $kontrak->mc->id,
                        'namaBarang' => $kontrak->mc->namaBarang,
                        'Status' => $kontrak->kontrakm->Status ?: 'AKTIF'
                    ];
                });

            $response = [
                'success' => true,
                'data' => $kontraks,
                'pagination' => [
                    'current_page' => $page,
                    'per_page' => $perPage,
                    'total' => $total,
                    'total_pages' => $totalPages,
                    'from' => $offset + 1,
                    'to' => min($offset + $perPage, $total)
                ],
                'message' => 'Data kontrak berhasil diambil'
            ];

            return response()->json($response);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'data' => [],
                'pagination' => null
            ], 500);
        }
    }
}
