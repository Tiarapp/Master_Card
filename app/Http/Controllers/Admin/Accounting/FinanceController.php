<?php

namespace App\Http\Controllers\Admin\Accounting;

use App\Http\Controllers\Controller;
use App\Imports\JurnalImport;
use App\Models\Accounting\Piutang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class FinanceController extends Controller
{
    public function index()
    {
        // dd(Piutang::get());
        return view('admin.acc.import_ju');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        $file = $request->file('file');
        $import = new JurnalImport();

        Excel::import($import, $file);

        return back()->with('success', 'File imported successfully!');

    }
}
