<?php

namespace App\Http\Controllers;

use App\Models\ColorCombine;
use App\Models\Tracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ColorCombineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $combine = DB::table('color_combine')
            ->leftJoin('color AS color1', 'idColor1', '=', 'color1.id')
            ->leftJoin('color AS color2', 'idColor2', '=', 'color2.id')
            ->leftJoin('color AS color3', 'idColor3', '=', 'color3.id')
            ->leftJoin('color AS color4', 'idColor4', '=', 'color4.id')
            ->select('color_combine.*', 'color1.nama AS warna1', 'color2.nama AS warna2', 'color3.nama AS warna3', 'color4.nama AS warna4',)
            ->get();

        return view('admin.colorcombine.index', ['combine' => $combine]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $color = DB::table('color')->get();

        // dd($color->id);
        return view('admin.colorcombine.create', compact('color'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'idColor1' => 'nullable',
            'idColor2' => 'nullable',
            'idColor3' => 'nullable',
            'idColor4' => 'nullable',
            'createdBy' => 'required'
        ]);

        $color = ColorCombine::create($request->all());

        Tracking::create([
            'user' => Auth::user()->name,
            'event' => "Tambah CC ".$color->nama
        ]);

        return redirect('admin/colorcombine');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ColorCombine  $colorCombine
     * @return \Illuminate\Http\Response
     */
    public function show(ColorCombine $colorCombine)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ColorCombine  $colorCombine
     * @return \Illuminate\Http\Response
     */
    public function edit(ColorCombine $colorCombine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ColorCombine  $colorCombine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ColorCombine $colorCombine)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ColorCombine  $colorCombine
     * @return \Illuminate\Http\Response
     */
    public function destroy(ColorCombine $colorCombine)
    {
        //
    }
}
