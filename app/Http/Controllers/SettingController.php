<?php

namespace App\Http\Controllers;

use App\Models\Number_Sequence;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function get_opi()
    {
        $opi = Number_Sequence::where('noBukti', 'nomer_opi')->first();

        if ($opi) {
            $opi->nomer = $opi->nomer + 1;
            $opi->save();

            $numb_opi = str_pad($opi->nomer,4, '0', STR_PAD_LEFT).$opi->format;

            return response()->json([
            'status' => true,
            'nomer' => $numb_opi,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Nomor not found',
            ]);
        }
    }
}
