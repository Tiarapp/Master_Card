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
        } else {
            $notif = [];
        }

        return response()->json($notif);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $notif = Notification::with('kontrak')->get();
            return DataTables::of($notif)
                ->addColumn('action', function($notif){
                    if ($notif->status == 'Proses') {
                        return "<button><a href='../admin/kontrak/open/" .trim($notif->kontrak_id). "' title='OPEN' ><span class='btn btn-success glyphicon glyphicon-list'>OPEN</span></a></button>";
                    } else {
                        return "<button disabled class='btn btn-success'>Done</button>";
                    }
                })
                ->addColumn('kontrak', function($notif){
                    return $notif->kontrak->kode;
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
            Notification::create([
                'kontrak_id' => $id[$i],
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
