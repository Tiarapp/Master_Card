<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait Userstamps
{
    /**
     * Boot the userstamps trait for a model.
     *
     * @return void
     */
    public static function bootUserstamps()
    {
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::id();
                $model->updated_by = Auth::id();
            }
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::id();
            }
        });
    }

    /**
     * Get the user that created the model.
     */
    public function creator()
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'created_by');
    }

    /**
     * Get the user that last updated the model.
     */
    public function updater()
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'updated_by');
    }
}
