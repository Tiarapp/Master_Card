<?php

namespace App\Http\Controllers;

use App\Models\CorrMaster;
use App\Models\Opi_M;
use Illuminate\Http\Request;

class CorrugatedController extends Controller
{
    public function index(Request $request)
    {
        $query = CorrMaster::query()->with(['user_create', 'user_update']);

        // Apply search filter
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('kode_corr', 'like', '%' . $request->search . '%')
                  ->orWhere('notes', 'like', '%' . $request->search . '%');
            });
        }

        // Apply date filter
        if($request->tanggal){
            $query->whereDate('tanggal_produksi', $request->tanggal);
        }

        // Apply shift filter
        if($request->shift){
            $query->where('shift', $request->shift);
        }

        $plans = $query->orderBy('tanggal_produksi', 'desc')
                      ->orderBy('created_at', 'desc')
                      ->paginate(20)
                      ->appends($request->all());

        return view('admin.plan.corr.index', compact('plans', 'request'));
    }

    public function create()
    {
        return view('admin.plan.corr.create');
    }
}
