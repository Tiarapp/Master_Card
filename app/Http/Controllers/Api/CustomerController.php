<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    /**
     * Get customers with search functionality
     */
    public function index(Request $request)
    {
        try {
            // Debug: Log the request
            Log::info('Customer API called with search: ' . ($request->search ?? 'no search'));
            
            // Get pagination parameters
            $page = $request->get('page', 1);
            $perPage = $request->get('per_page', 10);
            $offset = ($page - 1) * $perPage;
            
            // Try using Customer model first
            $query = Customer::query();

            if ($request->has('search') && !empty($request->search)) {
                $search = trim($request->search);
                $query = $query->where(function($q) use ($search) {
                    $q->where('Nama', 'LIKE', '%'.$search.'%')
                      ->orWhere('Kode', 'LIKE', '%'.$search.'%')
                      ->orWhere('AlamatKirim', 'LIKE', '%'.$search.'%');
                });
            }

            // Get total count
            $totalCount = $query->count();
            
            // Get paginated results
            $customers = $query->orderBy('Kode', 'asc')
                              ->skip($offset)
                              ->take($perPage)
                              ->get();
            
            // Debug: Log the count
            Log::info('Customer count from model: ' . $customers->count());

            // Transform the data to consistent format
            $transformedCustomers = $customers->map(function($customer) {
                return [
                    'id' => $customer->Kode,
                    'kode' => $customer->Kode,
                    'nama' => $customer->Nama,
                    'name' => $customer->Nama, // alias for compatibility
                    'alamat' => $customer->AlamatKirim,
                    'address' => $customer->AlamatKirim, // alias for compatibility
                    'telepon' => $customer->Telepon ?? null,
                    'email' => $customer->Email ?? null,
                ];
            });

            // Calculate pagination info
            $totalPages = ceil($totalCount / $perPage);

            return response()->json([
                'success' => true,
                'data' => $transformedCustomers,
                'pagination' => [
                    'current_page' => (int) $page,
                    'per_page' => (int) $perPage,
                    'total' => (int) $totalCount,
                    'total_pages' => (int) $totalPages,
                    'from' => $offset + 1,
                    'to' => min($offset + $perPage, $totalCount),
                ],
                'message' => 'Data customer berhasil diambil'
            ]);

        } catch (\Exception $e) {
            Log::error('Customer API error (Model): ' . $e->getMessage());
            Log::error('Customer API stack trace: ' . $e->getTraceAsString());
            
            // Fallback to DB facade
            try {
                Log::info('Trying DB facade fallback...');
                $query = DB::connection('firebird')->table('TCustomer');
                
                if ($request->has('search') && !empty($request->search)) {
                    $search = trim($request->search);
                    $query = $query->where(function($q) use ($search) {
                        $q->where('Nama', 'LIKE', '%'.$search.'%')
                          ->orWhere('Kode', 'LIKE', '%'.$search.'%')
                          ->orWhere('AlamatKirim', 'LIKE', '%'.$search.'%');
                    });
                }

                $customers = $query->orderBy('Nama', 'asc')->limit(50)->get();
                
                // Debug: Log the count from DB
                Log::info('Customer count from DB: ' . count($customers));
                
                // Transform the data to consistent format
                $transformedCustomers = collect($customers)->map(function($customer) {
                    return [
                        'id' => $customer->Kode,
                        'kode' => $customer->Kode,
                        'nama' => $customer->Nama,
                        'name' => $customer->Nama, // alias for compatibility
                        'alamat' => $customer->AlamatKirim,
                        'address' => $customer->AlamatKirim, // alias for compatibility
                        'telepon' => $customer->Telepon ?? null,
                        'email' => $customer->Email ?? null,
                    ];
                });

                return response()->json([
                    'success' => true,
                    'data' => $transformedCustomers,
                    'total' => $transformedCustomers->count(),
                    'message' => 'Data customer berhasil diambil (fallback)'
                ]);
                
            } catch (\Exception $e2) {
                Log::error('Customer API error (DB): ' . $e2->getMessage());
                Log::error('DB error stack trace: ' . $e2->getTraceAsString());
                
                return response()->json([
                    'success' => false,
                    'data' => [],
                    'total' => 0,
                    'message' => 'Gagal mengambil data customer: ' . $e2->getMessage(),
                    'error' => $e2->getMessage()
                ], 500);
            }
        }
    }

    /**
     * Get specific customer by ID/Code
     */
    public function show($id)
    {
        try {
            $customer = Customer::where('Kode', $id)->first();
            
            if (!$customer) {
                return response()->json([
                    'success' => false,
                    'data' => null,
                    'message' => 'Customer tidak ditemukan'
                ], 404);
            }

            $transformedCustomer = [
                'id' => $customer->Kode,
                'kode' => $customer->Kode,
                'nama' => $customer->Nama,
                'name' => $customer->Nama,
                'alamat' => $customer->AlamatKirim,
                'address' => $customer->AlamatKirim,
                'telepon' => $customer->Telepon ?? null,
                'email' => $customer->Email ?? null,
            ];

            return response()->json([
                'success' => true,
                'data' => $transformedCustomer,
                'message' => 'Data customer ditemukan'
            ]);

        } catch (\Exception $e) {
            Log::error('Customer show API error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'Gagal mengambil data customer: ' . $e->getMessage()
            ], 500);
        }
    }
}