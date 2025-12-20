<?php

namespace App\Http\Controllers;

use App\Models\CorrMaster;
use App\Models\CorrDetail;
use App\Models\Opi_M;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\FacadesLog;

class CorrugatedController extends Controller
{
    public function index(Request $request)
    {
        $query = CorrMaster::query()->with(['user_create', 'user_update']);

        // Apply search filter
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('kode_corr', 'like', '%' . $request->search . '%')
                  ->orWhere('notes', 'like', '%' . $request->search . '%');
            });
        }

        // Apply date filter
        if($request->tanggal){
            $query->whereDate('tanggal_produksi', $request->tanggal);
        }

        // Apply shift filter
        if($request->shift){
            $query->where('shift', $request->shift);
        }

        $plans = $query->orderBy('tanggal_produksi', 'desc')
                      ->orderBy('created_at', 'desc')
                      ->paginate(20)
                      ->appends($request->all());

        return view('admin.plan.corr.index', compact('plans', 'request'));
    }

    public function create()
    {
        return view('admin.plan.corr.create');
        
    }

    public function store(Request $request)
    {
        // Debug: Log incoming request data
        Log::info('Corrugated store request data:', [
            'opi_id' => $request->opi_id,
            'order' => $request->order,
            'outCorr' => $request->outCorr,
            'total_items' => count($request->opi_id ?? [])
        ]);
        
        $request->validate([
            'tgl' => 'required|date',
            'shift' => 'required|in:A,B,C',
            'notes' => 'nullable|string|max:500',
            'opi_id' => 'required|array|min:1',
            'order' => 'required|array',
            'outCorr' => 'required|array',
            'outFlexo' => 'required|array',
            'sheetp' => 'nullable|array',
            'sheetl' => 'nullable|array',
            'tipebox' => 'nullable|array',
            'flute' => 'nullable|array',
            'toleransi' => 'nullable|array',
            'beratSheet' => 'nullable|array',
            'roll' => 'nullable|array',
            'trim' => 'nullable|array',
            'cop' => 'nullable|array',
            'jenisAtas' => 'nullable|array',
            'gramAtas' => 'nullable|array',
            'kebutuhanAtas' => 'nullable|array',
            'jenisFlute1' => 'nullable|array',
            'gramFlute1' => 'nullable|array',
            'kebutuhanFlute1' => 'nullable|array',
            'jenisTengah' => 'nullable|array',
            'gramTengah' => 'nullable|array',
            'kebutuhanTengah' => 'nullable|array', 
            'jenisFlute2' => 'nullable|array',
            'gramFlute2' => 'nullable|array',
            'kebutuhanFlute2' => 'nullable|array',
            'jenisBawah' => 'nullable|array',
            'gramBawah' => 'nullable|array',
            'kebutuhanBawah' => 'nullable|array',
            'keterangan' => 'nullable|array',
            'urutan' => 'nullable|array',
            'plan' => 'nullable|array',
            'mc_id' => 'nullable|array',
        ], [
            'tgl.required' => 'Tanggal produksi harus diisi',
            'shift.required' => 'Shift harus dipilih',
            'opi_id.required' => 'Minimal harus ada 1 item OPI',
            'opi_id.min' => 'Minimal harus ada 1 item OPI',
        ]);

        try {
            DB::beginTransaction();

            // Generate kode planning
            $tanggal = date('Ymd', strtotime($request->tgl));
            $shift = $request->shift;
            $lastPlan = CorrMaster::where('tanggal_produksi', $request->tgl)
                                  ->where('shift', $shift)
                                  ->orderBy('kode_corr', 'desc')
                                  ->first();
            
            if ($lastPlan) {
                $lastNumber = intval(substr($lastPlan->kode_corr, -3));
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }
            
            $kodeCorr = "CORR{$tanggal}{$shift}" . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

            // Calculate totals - use same filtering logic
            $totalRm = 0;
            $totalKg = 0;
            $opiIds = array_filter($request->opi_id ?? []);
            
            foreach ($opiIds as $index => $opiId) {
                // Skip incomplete records
                if (empty($opiId) || empty($request->outCorr[$index] ?? null)) {
                    continue;
                }
                
                // Calculate RM total for this item
                $rmTotalItem = floatval($request->kebutuhanAtas[$index] ?? 0) +
                              floatval($request->kebutuhanFlute1[$index] ?? 0) +
                              floatval($request->kebutuhanTengah[$index] ?? 0) +
                              floatval($request->kebutuhanFlute2[$index] ?? 0) +
                              floatval($request->kebutuhanBawah[$index] ?? 0);
                              
                // Calculate KG total for this item (order qty * berat sheet / 1000)
                $kgTotalItem = floatval($request->order[$index] ?? 0) * floatval($request->beratSheet[$index] ?? 0);
                           
                $totalRm += $rmTotalItem;
                $totalKg += $kgTotalItem;
            }

            // Create master record
            $corrMaster = CorrMaster::create([
                'kode_corr' => $kodeCorr,
                'tanggal_produksi' => $request->tgl,
                'shift' => $request->shift,
                'revisi' => 0,
                'notes' => $request->notes,
                'total_rm' => $totalRm,
                'total_kg' => $totalKg,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id()
            ]);

            // Create detail records - filter out empty OPI IDs and ensure data consistency
            $opiIds = array_filter($request->opi_id ?? []);
            Log::info('Creating detail records', ['filtered_opi_ids' => $opiIds, 'count' => count($opiIds)]);
            
            $detailsCreated = 0;
            foreach ($opiIds as $index => $opiId) {
                // Validate that we have the minimum required data for this index
                if (empty($opiId) || empty($request->outCorr[$index] ?? null)) {
                    Log::info('Skipping incomplete record', ['index' => $index, 'opi_id' => $opiId]);
                    continue; // Skip incomplete records
                }
                
                Log::info('Creating detail record', ['index' => $index, 'opi_id' => $opiId]);
                // Get mc_id from form data
                $mcId = $request->mc_id[$index] ?? null;
                
                // Calculate totals for this item
                $rmTotalItem = floatval($request->kebutuhanAtas[$index] ?? 0) +
                              floatval($request->kebutuhanFlute1[$index] ?? 0) +
                              floatval($request->kebutuhanTengah[$index] ?? 0) +
                              floatval($request->kebutuhanFlute2[$index] ?? 0) +
                              floatval($request->kebutuhanBawah[$index] ?? 0);
                              
                $kgTotalItem = floatval($request->order[$index] ?? 0) * floatval($request->beratSheet[$index] ?? 0);
                
                // Plan calculations
                $planPlus = floatval($request->plan[$index] ?? 0);
                $planMin = floatval($request->order[$index] ?? 0); // Same as plan_plus for now, can be adjusted
                
                CorrDetail::create([
                    'corr_master_id' => $corrMaster->id,
                    'opi_id' => $opiId,
                    'mc_id' => $mcId,
                    'urutan' => intval($request->urutan[$index] ?? ($index + 1)),
                    'sheet_p' => intval($request->sheetp[$index] ?? 0),
                    'sheet_l' => intval($request->sheetl[$index] ?? 0),
                    'order_qty' => intval($request->order[$index] ?? 0),
                    'out_corr' => intval($request->outCorr[$index] ?? 0),
                    'out_flx' => intval($request->outFlexo[$index] ?? 0),
                    'plan_plus' => intval($planPlus),
                    'plan_min' => intval($planMin),
                    'lebar_roll' => intval($request->roll[$index] ?? 0),
                    'trim_waste' => intval($request->trim[$index] ?? 0),
                    'cop_plus' => intval($request->cop[$index] ?? 0),
                    'jenis_kertas1' => $request->jenisAtas[$index] ?? '',
                    'gram_kertas1' => intval($request->gramAtas[$index] ?? 0),
                    'kebutuhan_kertas1' => intval($request->kebutuhanAtas[$index] ?? 0),
                    'jenis_kertas2' => $request->jenisFlute1[$index] ?? '',
                    'gram_kertas2' => intval($request->gramFlute1[$index] ?? 0),
                    'kebutuhan_kertas2' => intval($request->kebutuhanFlute1[$index] ?? 0),
                    'jenis_kertas3' => $request->jenisTengah[$index] ?? '',
                    'gram_kertas3' => intval($request->gramTengah[$index] ?? 0),
                    'kebutuhan_kertas3' => intval($request->kebutuhanTengah[$index] ?? 0),
                    'jenis_kertas4' => $request->jenisFlute2[$index] ?? '',
                    'gram_kertas4' => intval($request->gramFlute2[$index] ?? 0),
                    'kebutuhan_kertas4' => intval($request->kebutuhanFlute2[$index] ?? 0),
                    'jenis_kertas5' => $request->jenisBawah[$index] ?? '',
                    'gram_kertas5' => intval($request->gramBawah[$index] ?? 0),
                    'kebutuhan_kertas5' => intval($request->kebutuhanBawah[$index] ?? 0),
                    'rm_total' => $rmTotalItem,
                    'kg_total' => $kgTotalItem,
                    'keterangan' => $request->keterangan[$index] ?? ''
                ]);
                $detailsCreated++;
                
                // Update OPI status and os_corr
                $orderQty = intval($request->order[$index] ?? 0);
                if ($orderQty > 0) {
                    try {
                        $opi = Opi_M::find($opiId);
                        if ($opi) {
                            // Reduce os_corr by order quantity
                            $currentOsCorr = $opi->os_corr ?? 0;
                            $newOsCorr = max(0, $currentOsCorr - $orderQty); // Ensure not negative
                            $opi->os_corr = $newOsCorr;
                            if ($opi->os_corr <= 0) {
                                $opi->plan_corr = true;
                            } 
                            
                            $opi->save();
                            
                            Log::info('Updated OPI status', [
                                'opi_id' => $opiId,
                                'plan_corr' => true,
                                'old_os_corr' => $currentOsCorr,
                                'order_qty' => $orderQty,
                                'new_os_corr' => $newOsCorr
                            ]);
                        } else {
                            Log::warning('OPI not found for update', ['opi_id' => $opiId]);
                        }
                    } catch (\Exception $updateException) {
                        Log::error('Failed to update OPI', [
                            'opi_id' => $opiId,
                            'error' => $updateException->getMessage()
                        ]);
                        // Don't throw, just log the error and continue
                    }
                }
            }
            
            Log::info('Detail records creation completed', ['total_created' => $detailsCreated]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Planning corrugating berhasil disimpan',
                'data' => [
                    'kode_corr' => $kodeCorr,
                    'id' => $corrMaster->id
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . implode(', ', $e->validator->errors()->all()),
                'errors' => $e->validator->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan planning corrugating: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $corrMaster = CorrMaster::with(['details.opi.mc.substanceproduksi.lineratas', 
                                       'details.opi.mc.substanceproduksi.flute1',
                                       'details.opi.mc.substanceproduksi.linertengah',
                                       'details.opi.mc.substanceproduksi.flute2', 
                                       'details.opi.mc.substanceproduksi.linerbawah',
                                       'details.opi.kontrakm',
                                       'details.opi.dt'])
                                ->findOrFail($id);
        
        return view('admin.plan.corr.edit', compact('corrMaster'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tgl' => 'required|date',
            'shift' => 'required|in:A,B,C',
            'notes' => 'nullable|string|max:500',
            'opi_id' => 'required|array|min:1',
            'order' => 'required|array',
            'outCorr' => 'required|array',
            'outFlexo' => 'required|array',
            'sheetp' => 'nullable|array',
            'sheetl' => 'nullable|array',
            'tipebox' => 'nullable|array',
            'flute' => 'nullable|array',
            'toleransi' => 'nullable|array',
            'beratSheet' => 'nullable|array',
            'roll' => 'nullable|array',
            'trim' => 'nullable|array',
            'cop' => 'nullable|array',
            'jenisAtas' => 'nullable|array',
            'gramAtas' => 'nullable|array',
            'kebutuhanAtas' => 'nullable|array',
            'jenisFlute1' => 'nullable|array',
            'gramFlute1' => 'nullable|array',
            'kebutuhanFlute1' => 'nullable|array',
            'jenisTengah' => 'nullable|array',
            'gramTengah' => 'nullable|array',
            'kebutuhanTengah' => 'nullable|array', 
            'jenisFlute2' => 'nullable|array',
            'gramFlute2' => 'nullable|array',
            'kebutuhanFlute2' => 'nullable|array',
            'jenisBawah' => 'nullable|array',
            'gramBawah' => 'nullable|array',
            'kebutuhanBawah' => 'nullable|array',
            'keterangan' => 'nullable|array',
            'urutan' => 'nullable|array',
            'plan' => 'nullable|array',
            'mc_id' => 'nullable|array',
        ], [
            'tgl.required' => 'Tanggal produksi harus diisi',
            'shift.required' => 'Shift harus dipilih',
            'opi_id.required' => 'Minimal harus ada 1 item OPI',
            'opi_id.min' => 'Minimal harus ada 1 item OPI',
        ]);

        try {
            DB::beginTransaction();

            $corrMaster = CorrMaster::findOrFail($id);

            // Calculate totals - use same filtering logic
            $totalRm = 0;
            $totalKg = 0;
            $opiIds = array_filter($request->opi_id ?? []);
            
            foreach ($opiIds as $index => $opiId) {
                // Skip incomplete records
                if (empty($opiId) || empty($request->outCorr[$index] ?? null)) {
                    continue;
                }
                
                // Calculate RM total for this item
                $rmTotalItem = floatval($request->kebutuhanAtas[$index] ?? 0) +
                              floatval($request->kebutuhanFlute1[$index] ?? 0) +
                              floatval($request->kebutuhanTengah[$index] ?? 0) +
                              floatval($request->kebutuhanFlute2[$index] ?? 0) +
                              floatval($request->kebutuhanBawah[$index] ?? 0);
                              
                // Calculate KG total for this item (order qty * berat sheet / 1000)
                $kgTotalItem = floatval($request->order[$index] ?? 0) * floatval($request->beratSheet[$index] ?? 0) / 1000;
                           
                $totalRm += $rmTotalItem;
                $totalKg += $kgTotalItem;
            }

            // Update master record
            $corrMaster->update([
                'tanggal_produksi' => $request->tgl,
                'shift' => $request->shift,
                'revisi' => $corrMaster->revisi + 1, // Increment revision
                'notes' => $request->notes,
                'total_rm' => $totalRm,
                'total_kg' => $totalKg,
                'updated_by' => Auth::id()
            ]);

            // Delete old details and revert OPI updates
            $oldDetails = CorrDetail::where('corr_master_id', $corrMaster->id)->get();
            foreach ($oldDetails as $detail) {
                // Revert OPI changes
                $opi = Opi_M::find($detail->opi_id);
                if ($opi) {
                    $opi->plan_corr = false;
                    $opi->os_corr = ($opi->os_corr ?? 0) + $detail->order_qty;
                    $opi->save();
                }
            }
            CorrDetail::where('corr_master_id', $corrMaster->id)->delete();

            // Create new detail records
            $detailsCreated = 0;
            foreach ($opiIds as $index => $opiId) {
                // Validate that we have the minimum required data for this index
                if (empty($opiId) || empty($request->outCorr[$index] ?? null)) {
                    continue; // Skip incomplete records
                }
                
                // Get mc_id from form data
                $mcId = $request->mc_id[$index] ?? null;
                
                // Calculate totals for this item
                $rmTotalItem = floatval($request->kebutuhanAtas[$index] ?? 0) +
                              floatval($request->kebutuhanFlute1[$index] ?? 0) +
                              floatval($request->kebutuhanTengah[$index] ?? 0) +
                              floatval($request->kebutuhanFlute2[$index] ?? 0) +
                              floatval($request->kebutuhanBawah[$index] ?? 0);
                              
                $kgTotalItem = floatval($request->order[$index] ?? 0) * floatval($request->beratSheet[$index] ?? 0) / 1000;
                
                // Plan calculations
                $planPlus = floatval($request->plan[$index] ?? 0);
                $planMin = $planPlus; // Same as plan_plus for now, can be adjusted
                
                CorrDetail::create([
                    'corr_master_id' => $corrMaster->id,
                    'opi_id' => $opiId,
                    'mc_id' => $mcId,
                    'urutan' => intval($request->urutan[$index] ?? ($index + 1)),
                    'sheet_p' => intval($request->sheetp[$index] ?? 0),
                    'sheet_l' => intval($request->sheetl[$index] ?? 0),
                    'order_qty' => intval($request->order[$index] ?? 0),
                    'out_corr' => intval($request->outCorr[$index] ?? 0),
                    'out_flx' => intval($request->outFlexo[$index] ?? 0),
                    'plan_plus' => intval($planPlus),
                    'plan_min' => intval($planMin),
                    'lebar_roll' => intval($request->roll[$index] ?? 0),
                    'trim_waste' => intval($request->trim[$index] ?? 0),
                    'cop_plus' => intval($request->cop[$index] ?? 0),
                    'jenis_kertas1' => $request->jenisAtas[$index] ?? '',
                    'gram_kertas1' => intval($request->gramAtas[$index] ?? 0),
                    'kebutuhan_kertas1' => intval($request->kebutuhanAtas[$index] ?? 0),
                    'jenis_kertas2' => $request->jenisFlute1[$index] ?? '',
                    'gram_kertas2' => intval($request->gramFlute1[$index] ?? 0),
                    'kebutuhan_kertas2' => intval($request->kebutuhanFlute1[$index] ?? 0),
                    'jenis_kertas3' => $request->jenisTengah[$index] ?? '',
                    'gram_kertas3' => intval($request->gramTengah[$index] ?? 0),
                    'kebutuhan_kertas3' => intval($request->kebutuhanTengah[$index] ?? 0),
                    'jenis_kertas4' => $request->jenisFlute2[$index] ?? '',
                    'gram_kertas4' => intval($request->gramFlute2[$index] ?? 0),
                    'kebutuhan_kertas4' => intval($request->kebutuhanFlute2[$index] ?? 0),
                    'jenis_kertas5' => $request->jenisBawah[$index] ?? '',
                    'gram_kertas5' => intval($request->gramBawah[$index] ?? 0),
                    'kebutuhan_kertas5' => intval($request->kebutuhanBawah[$index] ?? 0),
                    'rm_total' => $rmTotalItem,
                    'kg_total' => $kgTotalItem,
                    'keterangan' => $request->keterangan[$index] ?? ''
                ]);
                $detailsCreated++;
                
                // Update OPI status and os_corr
                $orderQty = intval($request->order[$index] ?? 0);
                if ($orderQty > 0) {
                    try {
                        $opi = Opi_M::find($opiId);
                        if ($opi) {
                            // Set plan_corr to true
                            $opi->plan_corr = true;
                            
                            // Reduce os_corr by order quantity
                            $currentOsCorr = $opi->os_corr ?? 0;
                            $newOsCorr = max(0, $currentOsCorr - $orderQty); // Ensure not negative
                            $opi->os_corr = $newOsCorr;
                            
                            $opi->save();
                        }
                    } catch (\Exception $updateException) {
                        // Don't throw, just continue
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Planning corrugating berhasil diupdate',
                'data' => [
                    'kode_corr' => $corrMaster->kode_corr,
                    'id' => $corrMaster->id
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . implode(', ', $e->validator->errors()->all()),
                'errors' => $e->validator->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate planning corrugating: ' . $e->getMessage()
            ], 500);
        }
    }
}
