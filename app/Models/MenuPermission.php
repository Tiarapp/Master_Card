<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'divisi_id', 
        'menu_key',
        'menu_name',
        'route_name',
        'icon',
        'parent_menu',
        'is_active',
        'order'
    ];

    protected $casts = [
        'is_active' => 'boolean'
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
     * Scope to get active menus
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get menus for specific company and divisi
     */
    public function scopeForCompanyAndDivisi($query, $companyId, $divisiId)
    {
        return $query->where('company_id', $companyId)
                    ->where('divisi_id', $divisiId)
                    ->active()
                    ->orderBy('order');
    }

    /**
     * Scope to get main menus (no parent)
     */
    public function scopeMainMenus($query)
    {
        return $query->whereNull('parent_menu');
    }

    /**
     * Scope to get submenus
     */
    public function scopeSubMenus($query, $parentMenu)
    {
        return $query->where('parent_menu', $parentMenu);
    }
}
