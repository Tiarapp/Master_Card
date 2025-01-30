<?php

namespace App\Http\Controllers\Admin\Navbar;

use App\Http\Controllers\Controller;
use App\Models\Kontrak;
use App\Models\Kontrak_M;
use App\Models\Navbar\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class NavbarController extends Controller
{
    public function getNotifOpenKontrak()
    {
        if (Auth::user()->divisi_id == 2) {
            $notif = Notification::where('status', '=', "Proses")->get();
        } else if (Auth::user()->divisi_id == 13) {
            $notif = Kontrak_M::where('status', '=', 2)->get();
        }

        return response()->json($notif);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $notif = Notification::query();
            return DataTables::of($notif)
                ->addColumn('action', function($notif){
                    return "<button><a href='../jobs/action/" .trim($notif->id). "' title='Done' ><span class='btn btn-success glyphicon glyphicon-list'>Done</span></a></button>";
                })
                ->make(true);
        }

        return view('admin.notif.index');
    }

    public function create()
    {
        $kontrak = Kontrak_M::get();

        return view('admin.notif.create', compact('kontrak'));
    }

    public function store(Request $request)
    {

        $id = array_merge($request->idkontrak);
        for ($i=0; $i < count($id) ; $i++) { 
            $kontrak = Kontrak_M::find($id[$i]);

            Notification::create([
                'kode' => $kontrak->kode,
                'alasan' => $request->alasan,
                'tanggal' => $request->tanggal,
                'status' => 'Proses',
                'pemohon' => Auth::user()->name
            ]);

        }

        return redirect('admin/kontrak')->with('success', 'Berhasil melakukan request buka Blok, tunggu Respon dari IT');
    }

    public function update($id)
    {
        $notif = Notification::findOrFail($id);
        $notif->pic = Auth::user()->name;
        $notif->status = 'Done';

        $notif->save();

        return redirect()->back()->with('success', 'Berhasil update !');
    }
}
