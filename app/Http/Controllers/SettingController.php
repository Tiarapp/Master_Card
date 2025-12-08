<?php

namespace App\Http\Controllers;

use App\Models\Number_Sequence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    public function get_opi()
    {
        try {
            // Get the OPI number sequence record
            $opi = Number_Sequence::where('noBukti', 'nomer_opi')->first();

            if ($opi) {
                // Increment the number
                $opi->nomer = $opi->nomer + 1;
                $opi->save();

                // Generate the formatted OPI number
                // Format: OPI-YYYY-NNNN (where YYYY is year and NNNN is padded number)
                $paddedNumber = str_pad($opi->nomer, 4, '0', STR_PAD_LEFT);
                $numb_opi = "{$paddedNumber}{$opi->format}";

                return response()->json([
                    'status' => true,
                    'nomer' => $numb_opi,
                    'message' => 'OPI number generated successfully'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'OPI number sequence not found',
                    'nomer' => 'OPI-' . date('Y') . '-' . str_pad(1, 4, '0', STR_PAD_LEFT)
                ], 404);
            }
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error generating OPI number: ' . $e->getMessage());
            
            return response()->json([
                'status' => false,
                'message' => 'Error generating OPI number',
                'nomer' => 'OPI-' . date('Y') . '-' . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT)
            ], 500);
        }
    }
}
