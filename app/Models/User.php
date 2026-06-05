<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'divisi_id',
        'company_id',
        'email',
        'password',
        'password_changed_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password_changed_at' => 'datetime',
    ];

    /**
     * Relationship with company
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Relationship with divisi
     */
    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }

    /**
     * Relationship with roles (many-to-many)
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    /**
     * Check if user has a specific role (by slug)
     */
    public function hasRole($slug)
    {
        return $this->roles()->where('slug', $slug)->exists();
    }

    /**
     * Check if user has a specific permission (by slug) via any of their roles
     */
    public function hasPermission($slug)
    {
        foreach ($this->roles as $role) {
            if ($role->hasPermission($slug)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get all permission slugs for this user across all roles
     */
    public function getAllPermissions()
    {
        return $this->roles()
            ->with('permissions')
            ->get()
            ->pluck('permissions')
            ->flatten()
            ->pluck('slug')
            ->unique()
            ->values();
    }
}
