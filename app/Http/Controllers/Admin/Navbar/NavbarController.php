<?php

namespace App\Http\Controllers\Admin\Navbar;

use App\Http\Controllers\Controller;
use App\Models\Kontrak_M;
use App\Models\Navbar\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NavbarController extends Controller
{
    public function getNotifOpenKontrak()
    {
        if (Auth::user()->divisi_id == 2 || Auth::user()->divisi_id == 13) {
            $notif = Notification::where('status', '=', "Proses")->get();
        } else {
            $notif = Notification::where('status', '=', "Proses")
                ->where('user_id', Auth::user()->id)
                ->get();
        }

        return response()->json($notif);
    }

    public function index(Request $request)
    {
        $notificationsQuery = Notification::with('kontrak');

        $user = Auth::user()->id;
        
        if (Auth::user()->divisi_id == 2 || Auth::user()->divisi_id == 13) {
            if ($request->search) {
                $notificationsQuery->where(function($query) use ($request) {
                    $query->where('pemohon', 'like', '%'.$request->search.'%')
                        ->orWhere('tanggal', 'like', '%'.$request->search.'%')
                        ->orWhere('alasan', 'like', '%'.$request->search.'%')
                        ->orWhere('status', 'like', '%'.$request->search.'%')
                        ->orWhere('pic', 'like', '%'.$request->search.'%');
                })
                ->orWhereHas('kontrak', function($query) use ($request) {
                    $query->where('kode', 'like', '%'.$request->search.'%');
                });
            }
        } else {
            $notificationsQuery->where('user_id', $user);

            if ($request->search) {
                $notificationsQuery->where(function($query) use ($request) {
                    $query->where('tanggal', 'like', '%'.$request->search.'%')
                        ->orWhere('alasan', 'like', '%'.$request->search.'%')
                        ->orWhere('status', 'like', '%'.$request->search.'%')
                        ->orWhere('pic', 'like', '%'.$request->search.'%');
                })
                ->orWhereHas('kontrak', function($query) use ($request) {
                    $query->where('kode', 'like', '%'.$request->search.'%');
                });
            }
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
                'user_id' => Auth::user()->id,
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
