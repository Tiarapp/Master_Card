<?php

namespace App\Http\Controllers;

use App\Models\Mastercard;
use App\Services\MastercardApprovalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MastercardApprovalController extends Controller
{
    public function index($id)
    {
        $mastercard = Mastercard::with('approvals')->findOrFail($id);

        return view('admin.mastercard.approvals', compact('mastercard'));
    }

    public function store(Request $request, $id, MastercardApprovalService $approvalService)
    {
        $mastercard = Mastercard::findOrFail($id);
        $approvalService->validate($request, true);
        $approvalService->transaction(function () use ($approvalService, $mastercard, $request) {
            $approvalService->save($mastercard, $request);
        });

        return redirect()->route('mastercard.approvals', $mastercard->id)
            ->with('success', 'File approval berhasil disimpan.');
    }

    public function show($id, $approvalId)
    {
        $mastercard = Mastercard::findOrFail($id);
        $approval = $mastercard->approvals()->findOrFail($approvalId);

        return view('admin.mastercard.approval-print', compact('mastercard', 'approval'));
    }

    public function file($id, $approvalId)
    {
        $mastercard = Mastercard::findOrFail($id);
        $approval = $mastercard->approvals()->findOrFail($approvalId);
        abort_unless(Storage::disk('local')->exists($approval->path), 404, 'File approval tidak ditemukan.');

        return response()->file(Storage::disk('local')->path($approval->path), [
            'Content-Type' => $approval->mime_type,
            'X-Content-Type-Options' => 'nosniff',
            'Content-Disposition' => 'inline',
        ]);
    }
}
