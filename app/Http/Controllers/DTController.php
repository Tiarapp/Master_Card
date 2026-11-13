<?php

namespace App\Http\Controllers;

use App\Models\DeliveryTime;
use App\Models\Opi_M;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DTController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $dt = $this->processOpiQuery($search)
            ->orderBy('created_at', 'desc')->orderBy('id', 'desc')->paginate(10);

        $dt->appends($request->query());

        return view('admin.dt.index', compact('dt', 'search'));
    }

    private function processOpiQuery($search)
    {
        $dt = Opi_M::with(['dt', 'kontrakm'])->where('status_opi', 'Proses');
        if ($search !== null && $search !== '') {
            $dt->where(function($query) use ($search) {
                $query->where('kontrak_m_id', 'like', "%{$search}%")
                      ->orWhere('NoOPI', 'like', "%{$search}%")
                      ->orWhere('nama', 'like', "%{$search}%")
                      ->orWhereHas('dt', function ($query) use ($search) {
                          $query->where('kodeKontrak', 'like', "%{$search}%")
                                ->orWhere('kontrak_m_id', 'like', "%{$search}%")
                                ->orWhere('opi', 'like', "%{$search}%");
                      })
                      ->orWhereHas('kontrakm', function ($query) use ($search) {
                          $query->where('kode', 'like', "%{$search}%");
                      });
            });
        }

        return $dt;
    }

    public function pendingPpic(Request $request)
    {
        abort_unless(in_array(Auth::user()->divisi_id, [2, 5]) && hasMenuAccess('ppic.dt_approval'), 403);
        $search = $request->input('search');
        $dt = $this->processOpiQuery($search)
            ->whereHas('dt', function ($query) {
                $query->whereNotNull('dt_perubahan')->where('approve_ppic', 0);
            })
            ->orderBy('created_at', 'desc')->orderBy('id', 'desc')->paginate(10);
        $dt->appends($request->query());

        return view('admin.dt.ppic-approval', compact('dt', 'search'));
    }

    public function approvePpic(Request $request, $id)
    {
        abort_unless(in_array(Auth::user()->divisi_id, [2, 5]) && hasMenuAccess('ppic.dt_approval'), 403);
        $validated = $request->validate([
            'dt_perubahan' => 'required|date_format:Y-m-d',
            'updated_at' => 'present|nullable|date_format:Y-m-d H:i:s',
            'pcsDt' => 'present|nullable|numeric',
        ]);
        $opi = Opi_M::where('status_opi', 'Proses')->findOrFail($id);
        $query = DeliveryTime::where('id', $opi->dt_id)
            ->where('approve_ppic', 0)
            ->where('dt_perubahan', $validated['dt_perubahan'])
            ->whereExists(function ($query) use ($id) {
                $query->selectRaw('1')->from('opi_m')
                    ->whereColumn('opi_m.dt_id', 'dt.id')
                    ->where('opi_m.id', $id)
                    ->where('opi_m.status_opi', 'Proses');
            });
        if ($validated['updated_at'] === null) {
            $query->whereNull('updated_at');
        } else {
            $query->where('updated_at', $validated['updated_at']);
        }
        if ($validated['pcsDt'] === null) {
            $query->whereNull('pcsDt');
        } else {
            $query->where('pcsDt', $validated['pcsDt']);
        }
        $updated = $query->update(['approve_ppic' => 1]);

        if (!$updated) {
            return redirect()->back()->with('error', 'Data DT sudah berubah atau telah disetujui. Muat ulang halaman sebelum mencoba lagi.');
        }

        return redirect()->back()->with('success', 'Perubahan DT berhasil disetujui oleh PPIC.');
    }

    public function edit($id)
    {
        $dt = DeliveryTime::findOrFail($id);

        return view('admin.dt.edit', ['dt' => $dt]);
    }

    public function update(Request $request,$id)
    {
        $dt = DeliveryTime::findOrFail($id);

        $changed = $dt->dt_perubahan != $request->dt_perubahan || $dt->pcsDt != $request->pcsDt;
        $dt->dt_perubahan = $request->dt_perubahan;
        $dt->pcsDt = $request->pcsDt;

        if (Auth::user()->divisi_id == 5) {
            $dt->approve_ppic = 1;
        } else {
            if ($changed) {
                $dt->approve_ppic = 0;
            }
        }

        $dt->save();

        $redirect = $request->input('from_dt_list') === '1' ? redirect()->back() : redirect('admin/dt');

        return $redirect->with('success', "Data Berhasil di Update dengan kode Kontrak = ". $request->kontrak." dan tanggal kirim ". $request->dt_perubahan ." dan Qty = ". $request->pcsDt);
    }

    public function approve($id)
    {
        abort_unless(in_array(Auth::user()->divisi_id, [2, 5]) && hasMenuAccess('ppic.dt_approval'), 403);
        DeliveryTime::findOrFail($id);

        return redirect()->route('ppic.dt.approval');
    }

    public function destroy($id)
    {
        $dt = DeliveryTime::find($id);
        $dt->delete();

        return redirect('admin/dt')->with('success', "Data Berhasil dihapus");


    }
}
