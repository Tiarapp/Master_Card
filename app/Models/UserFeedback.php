<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFeedback extends Model
{
    use HasFactory;

    protected $table = 'user_feedback';

    protected $fillable = [
        'name',
        'email',
        'type',
        'category',
        'priority',
        'subject',
        'message',
        'page_url',
        'browser_info',
        'status',
        'admin_response',
        'responded_at',
        'user_id',
        'responded_by'
    ];

    protected $casts = [
        'browser_info' => 'array',
        'responded_at' => 'datetime'
    ];

    // Feedback types
    const TYPE_SUGGESTION = 'suggestion';
    const TYPE_BUG_REPORT = 'bug_report';
    const TYPE_FEATURE_REQUEST = 'feature_request';
    const TYPE_COMPLAINT = 'complaint';

    // Categories
    const CATEGORY_INVENTORY = 'inventory';
    const CATEGORY_REPORTS = 'reports';
    const CATEGORY_SYSTEM = 'system';
    const CATEGORY_UI_UX = 'ui_ux';

    // Priorities
    const PRIORITY_LOW = 'low';
    const PRIORITY_MEDIUM = 'medium';
    const PRIORITY_HIGH = 'high';
    const PRIORITY_URGENT = 'urgent';

    // Status
    const STATUS_OPEN = 'open';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_RESOLVED = 'resolved';
    const STATUS_CLOSED = 'closed';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function respondedBy()
    {
        return $this->belongsTo(User::class, 'responded_by');
    }

    public function getTypeLabel()
    {
        $types = [
            self::TYPE_SUGGESTION => 'Saran',
            self::TYPE_BUG_REPORT => 'Laporan Bug',
            self::TYPE_FEATURE_REQUEST => 'Permintaan Fitur',
            self::TYPE_COMPLAINT => 'Keluhan'
        ];
        
        return $types[$this->type] ?? $this->type;
    }

    public function getCategoryLabel()
    {
        $categories = [
            self::CATEGORY_INVENTORY => 'Inventory',
            self::CATEGORY_REPORTS => 'Laporan',
            self::CATEGORY_SYSTEM => 'Sistem',
            self::CATEGORY_UI_UX => 'UI/UX'
        ];
        
        return $categories[$this->category] ?? $this->category;
    }

    public function getPriorityLabel()
    {
        $priorities = [
            self::PRIORITY_LOW => 'Rendah',
            self::PRIORITY_MEDIUM => 'Sedang',
            self::PRIORITY_HIGH => 'Tinggi',
            self::PRIORITY_URGENT => 'Mendesak'
        ];
        
        return $priorities[$this->priority] ?? $this->priority;
    }

    public function getStatusLabel()
    {
        $statuses = [
            self::STATUS_OPEN => 'Terbuka',
            self::STATUS_IN_PROGRESS => 'Sedang Diproses',
            self::STATUS_RESOLVED => 'Selesai',
            self::STATUS_CLOSED => 'Ditutup'
        ];
        
        return $statuses[$this->status] ?? $this->status;
    }

    public function getStatusColor()
    {
        $colors = [
            self::STATUS_OPEN => 'warning',
            self::STATUS_IN_PROGRESS => 'info',
            self::STATUS_RESOLVED => 'success',
            self::STATUS_CLOSED => 'secondary'
        ];
        
        return $colors[$this->status] ?? 'warning';
    }

    public function getPriorityColor()
    {
        $colors = [
            self::PRIORITY_LOW => 'success',
            self::PRIORITY_MEDIUM => 'warning',
            self::PRIORITY_HIGH => 'danger',
            self::PRIORITY_URGENT => 'dark'
        ];
        
        return $colors[$this->priority] ?? 'warning';
    }
}
