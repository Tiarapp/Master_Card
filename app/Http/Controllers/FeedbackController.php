<?php

namespace App\Http\Controllers;

use App\Models\UserFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
    /**
     * Display a listing of feedback for admin
     */
    public function index(Request $request)
    {
        $query = UserFeedback::with(['user', 'respondedBy']);

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('subject', 'LIKE', "%{$search}%")
                  ->orWhere('message', 'LIKE', "%{$search}%")
                  ->orWhere('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $feedbacks = $query->orderBy('created_at', 'desc')->paginate(20);

        // Get filter options
        $types = [
            UserFeedback::TYPE_SUGGESTION => 'Saran',
            UserFeedback::TYPE_BUG_REPORT => 'Laporan Bug',
            UserFeedback::TYPE_FEATURE_REQUEST => 'Permintaan Fitur',
            UserFeedback::TYPE_COMPLAINT => 'Keluhan'
        ];

        $categories = [
            UserFeedback::CATEGORY_INVENTORY => 'Inventory',
            UserFeedback::CATEGORY_REPORTS => 'Laporan',
            UserFeedback::CATEGORY_SYSTEM => 'Sistem',
            UserFeedback::CATEGORY_UI_UX => 'UI/UX'
        ];

        $priorities = [
            UserFeedback::PRIORITY_LOW => 'Rendah',
            UserFeedback::PRIORITY_MEDIUM => 'Sedang',
            UserFeedback::PRIORITY_HIGH => 'Tinggi',
            UserFeedback::PRIORITY_URGENT => 'Mendesak'
        ];

        $statuses = [
            UserFeedback::STATUS_OPEN => 'Terbuka',
            UserFeedback::STATUS_IN_PROGRESS => 'Sedang Diproses',
            UserFeedback::STATUS_RESOLVED => 'Selesai',
            UserFeedback::STATUS_CLOSED => 'Ditutup'
        ];

        return view('admin.feedback.index', compact('feedbacks', 'types', 'categories', 'priorities', 'statuses'));
    }

    /**
     * Show feedback form
     */
    public function create()
    {
        return view('admin.feedback.create');
    }

    /**
     * Store new feedback
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'type' => 'required|in:suggestion,bug_report,feature_request,complaint',
            'category' => 'nullable|in:inventory,reports,system,ui_ux',
            'priority' => 'required|in:low,medium,high,urgent',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Collect browser info for bug reports
        $browserInfo = null;
        if ($request->type === 'bug_report') {
            $browserInfo = [
                'user_agent' => $request->header('User-Agent'),
                'ip_address' => $request->ip(),
                'referer' => $request->header('Referer'),
                'timestamp' => now()->toISOString()
            ];
        }

        $feedback = UserFeedback::create([
            'name' => $request->name ?? (Auth::user() ? Auth::user()->name : 'Guest'),
            'email' => $request->email,
            'type' => $request->type,
            'category' => $request->category,
            'priority' => $request->priority,
            'subject' => $request->subject,
            'message' => $request->message,
            'page_url' => $request->page_url,
            'browser_info' => $browserInfo,
            'user_id' => Auth::id(),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Feedback berhasil dikirim! Terima kasih atas masukan Anda.',
                'feedback_id' => $feedback->id
            ]);
        }

        return redirect()->back()->with('success', 'Feedback berhasil dikirim! Terima kasih atas masukan Anda.');
    }

    /**
     * Show specific feedback detail
     */
    public function show($id)
    {
        $feedback = UserFeedback::with(['user', 'respondedBy'])->findOrFail($id);
        return view('admin.feedback.show', compact('feedback'));
    }

    /**
     * Update feedback status and response
     */
    public function update(Request $request, $id)
    {
        $feedback = UserFeedback::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:open,in_progress,resolved,closed',
            'admin_response' => 'nullable|string',
            'priority' => 'nullable|in:low,medium,high,urgent'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $updateData = [
            'status' => $request->status,
        ];

        if ($request->filled('priority')) {
            $updateData['priority'] = $request->priority;
        }

        if ($request->filled('admin_response')) {
            $updateData['admin_response'] = $request->admin_response;
            $updateData['responded_at'] = now();
            $updateData['responded_by'] = Auth::id();
        }

        $feedback->update($updateData);

        return redirect()->back()->with('success', 'Feedback berhasil diperbarui!');
    }

    /**
     * Get feedback statistics
     */
    public function statistics()
    {
        $stats = [
            'total' => UserFeedback::count(),
            'open' => UserFeedback::where('status', 'open')->count(),
            'in_progress' => UserFeedback::where('status', 'in_progress')->count(),
            'resolved' => UserFeedback::where('status', 'resolved')->count(),
            'by_type' => UserFeedback::selectRaw('type, count(*) as count')
                ->groupBy('type')
                ->pluck('count', 'type'),
            'by_priority' => UserFeedback::selectRaw('priority, count(*) as count')
                ->groupBy('priority')
                ->pluck('count', 'priority'),
            'recent' => UserFeedback::with('user')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get()
        ];

        return response()->json($stats);
    }

    /**
     * Quick feedback submission (for floating button)
     */
    public function quickSubmit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:suggestion,bug_report,feature_request,complaint',
            'category' => 'required|in:system,ui_ux,inventory,reports,other',
            'priority' => 'required|in:urgent,high,medium,low',
            'message' => 'required|string|min:10',
            'email' => 'nullable|email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $feedback = UserFeedback::create([
            'type' => $request->type,
            'category' => $request->category,
            'priority' => $request->priority,
            'subject' => 'Quick Feedback - ' . ucfirst(str_replace('_', ' ', $request->type)),
            'message' => $request->message,
            'email' => $request->email,
            'page_url' => $request->page_url ?: $request->header('Referer'),
            'user_id' => Auth::id(),
            'name' => Auth::user() ? Auth::user()->name : 'Guest'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Terima kasih! Feedback Anda telah dikirim.',
            'feedback_id' => $feedback->id
        ]);
    }
}
