<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Masterdata;

class MasterdataController extends Controller
{
    public function get_masterdata_by_type($type)
    {
        $masterdata = Masterdata::where('type', $type)->get();

        return response()->json([
            'success' => true,
            'data' => $masterdata,
        ]);
    }

    public function get_masterdata_by_id($id)
    {
        $masterdata = Masterdata::find($id);

        if (!$masterdata) {
            return response()->json([
                'success' => false,
                'message' => 'Masterdata not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $masterdata,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'type' => 'required|in:customer,supplier',
        ]);

        $masterdata = Masterdata::create([
            'name' => $request->input('name'),
            'city' => $request->input('city'),
            'type' => $request->input('type'),
        ]);

        return response()->json([
            'success' => true,
            'data' => $masterdata,
        ]);
    }
}
