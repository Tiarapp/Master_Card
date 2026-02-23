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
        $notificationsQuery = Notification::with('kontrak');
        
        if ($request->search) {
            $notificationsQuery->where(function($query) use ($request) {
                $query->where('tanggal', 'like', '%'.$request->search.'%')
                    ->orWhere('pemohon', 'like', '%'.$request->search.'%')
                    ->orWhere('alasan', 'like', '%'.$request->search.'%')
                    ->orWhere('status', 'like', '%'.$request->search.'%')
                    ->orWhere('pic', 'like', '%'.$request->search.'%');
            })
            ->orWhereHas('kontrak', function($query) use ($request) {
                $query->where('kode', 'like', '%'.$request->search.'%');
            });
        }

        $notifications = $notificationsQuery->orderBy('created_at', 'desc')->paginate(20);

        $data = [
            'notifications' => $notifications,
        ];
        
        return view('admin.notif.index', $data);
    }

    public function create()
    {
        $kontrak = Kontrak_M::get();

        return view('admin.notif.create', compact('kontrak'));
    }

    public function store(Request $request)
    {
        // dd($request->all());

        for ($i=0; $i < count($request->kontrak_id) ; $i++) { 
            Notification::create([
                'kontrak_id' => $request->kontrak_id[$i],
                'alasan' => $request->alasan,
                'tanggal' => $request->tanggal,
                'status' => 'Proses',
                'pemohon' => Auth::user()->name,
                'created_at' => now(),
                'updated_at' => null
            ]);

        }

        return redirect('admin/kontraknew')->with('success', 'Berhasil melakukan request buka Blok, tunggu Respon dari IT');
    }

    public function update($id)
    {
        $notif = Notification::findOrFail($id);
        $notif->pic = Auth::user()->name;
        $notif->status = 'Done';
        $notif->touch(); // Force update updated_at

        $notif->save();

        return redirect()->back()->with('success', 'Berhasil update !');
    }
}
