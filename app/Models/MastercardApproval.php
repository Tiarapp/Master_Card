<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MastercardApproval extends Model
{
    protected $fillable = ['original_name', 'path', 'mime_type'];
}
