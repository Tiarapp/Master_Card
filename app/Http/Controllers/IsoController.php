<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IsoController extends Controller
{
    public function index_it()
    {
        return view('admin.iso.it.index');
    }

    public function prosedureOne()
    {
        return view('admin.iso.it.prosedure-one');
    }
}
