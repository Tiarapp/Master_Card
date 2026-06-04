<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'parent_slug'];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }

    /**
     * Parent permission (null if this is a top-level permission)
     */
    public function parent()
    {
        return $this->belongsTo(Permission::class, 'parent_slug', 'slug');
    }

    /**
     * Child sub-menu permissions
     */
    public function children()
    {
        return $this->hasMany(Permission::class, 'parent_slug', 'slug');
    }

    public function isParent(): bool
    {
        return is_null($this->parent_slug);
    }

    public function isChild(): bool
    {
        return !is_null($this->parent_slug);
    }
}
