<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExportRequest extends Model
{
    public const PENDING = 'pending';
    public const PROCESSING = 'processing';
    public const DONE = 'done';
    public const FAILED = 'failed';

    protected $table = 'export_requests';

    protected $fillable = [
        'user_id',
        'type',
        'filters',
        'status',
        'file_name',
        'file_path',
        'error',
    ];

    protected $casts = [
        'filters' => 'array',
    ];

    public function isActive(): bool
    {
        return in_array($this->status, [self::PENDING, self::PROCESSING], true);
    }
}
