<?php

namespace App\Http\Controllers;

use App\Models\ForecastCust;
use App\Models\Sales;
use App\Imports\ForecastCustImport;
use App\Exports\ForecastCustTemplateExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ForecastCustController extends Controller
{
    public function index(Request $request)
    {
        $startTime = microtime(true);
        
        $currentYear = $request->get('year', date('Y'));
        
        // Get available years from database
        $availableYears = ForecastCust::selectRaw('DISTINCT tahun')
            ->orderBy('tahun', 'desc')
            ->pluck('tahun')
            ->toArray();
            
        // Add current year if not in database
        if (!in_array(date('Y'), $availableYears)) {
            $availableYears[] = date('Y');
            rsort($availableYears);
        }
        
        // Optimized single query approach for better performance
        $allForecasts = ForecastCust::with('sales')
            ->where('tahun', $currentYear)
            ->orderBy('customer_name')
            ->get()
            ->groupBy(function($item) {
                return $item->customer_name . '|' . ($item->sales->nama ?? 'No Sales');
            });
            
        // Simple pagination by chunking the grouped data
        $perPage = 20;
        $currentPage = $request->get('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        
        $paginatedForecasts = $allForecasts->slice($offset, $perPage);
        $total = $allForecasts->count();
        
        // Create pagination manually
        $customerSalesCombinations = new \Illuminate\Pagination\LengthAwarePaginator(
            $paginatedForecasts,
            $total,
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'pageName' => 'page']
        );

        $endTime = microtime(true);
        $executionTime = round(($endTime - $startTime) * 1000, 2); // Convert to milliseconds
        
        // Add timing to view data for display
        $timingInfo = [
            'execution_time' => $executionTime,
            'total_records' => $total,
            'query_count' => 2 // 1 for years + 1 for forecasts
        ];

        return view('admin.marketing.forecast_cust.index', compact('paginatedForecasts', 'currentYear', 'availableYears', 'customerSalesCombinations', 'timingInfo'));
    }

    public function create(Request $request)
    {
        $sales = Sales::where('aktif', '!=', 2)
                     ->get();

        // Get pre-filled data from query parameters
        $preCustomer = $request->get('customer', '');
        $preSalesName = $request->get('sales', '');
        
        // Find sales ID if sales name is provided
        $preSalesId = null;
        if ($preSalesName && $preSalesName !== 'No Sales') {
            $salesRecord = $sales->where('nama', $preSalesName)->first();
            $preSalesId = $salesRecord ? $salesRecord->id : null;
        }

        return view('admin.marketing.forecast_cust.create', compact('sales', 'preCustomer', 'preSalesId'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'sales_id' => 'required|exists:sales_m,id',
            'bulan' => 'required|integer|between:1,12',
            'tahun' => 'required|integer|min:2020',
            'target_tonase' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:1000'
        ], [
            'customer_name.required' => 'Nama customer harus diisi',
            'sales_id.required' => 'Sales harus dipilih',
            'sales_id.exists' => 'Sales yang dipilih tidak valid',
            'bulan.required' => 'Bulan harus dipilih',
            'bulan.between' => 'Bulan harus antara 1-12',
            'tahun.required' => 'Tahun harus dipilih',
            'tahun.min' => 'Tahun minimal 2020',
            'target_tonase.required' => 'Target tonase harus diisi',
            'target_tonase.numeric' => 'Target tonase harus berupa angka',
            'target_tonase.min' => 'Target tonase harus lebih dari 0',
            'keterangan.max' => 'Keterangan maksimal 1000 karakter'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Check if forecast already exists for this customer, month, and year
            $existing = ForecastCust::where('customer_name', $request->customer_name)
                ->where('bulan', $request->bulan)
                ->where('tahun', $request->tahun)
                ->first();

            if ($existing) {
                return redirect()->back()
                    ->withErrors(['duplicate' => 'Forecast untuk customer ini pada bulan dan tahun yang sama sudah ada.'])
                    ->withInput();
            }

            // Create new forecast
            $forecast = ForecastCust::create([
                'customer_name' => $request->customer_name,
                'sales_id' => $request->sales_id,
                'bulan' => $request->bulan,
                'tahun' => $request->tahun,
                'target_tonase' => $request->target_tonase,
                'keterangan' => $request->keterangan,
                'created_by' => Auth::user()->name ?? 'System',
                'updated_by' => Auth::user()->name ?? 'System'
            ]);

            return redirect()->route('forecast.tonase.index')
                ->with('success', 'Forecast tonase berhasil ditambahkan.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function edit($id)
    {
        return view('admin.marketing.forecast_cust.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // Validate and update the forecast customer data
    }

    public function destroy($id)
    {
        // Delete the forecast customer data
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ], [
            'file.required' => 'File harus dipilih',
            'file.mimes' => 'File harus berformat Excel (.xlsx, .xls) atau CSV',
            'file.max' => 'Ukuran file maksimal 2MB'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            Excel::import(new ForecastCustImport, $request->file('file'));

            return redirect()->route('forecast.tonase.index')
                ->with('success', 'Data forecast berhasil diimpor!');

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            
            foreach ($failures as $failure) {
                $errorMessages[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
            }
            
            return redirect()->back()
                ->withErrors(['import_error' => 'Import gagal: ' . implode(' | ', $errorMessages)])
                ->withInput();
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['import_error' => 'Terjadi kesalahan saat import: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function downloadTemplate()
    {
        $filename = 'Template_Forecast_Tonase_' . date('Y-m-d_His') . '.xlsx';
        
        return Excel::download(new ForecastCustTemplateExport, $filename);
    }

    public function showImport()
    {
        return view('admin.marketing.forecast_cust.import');
    }


}
