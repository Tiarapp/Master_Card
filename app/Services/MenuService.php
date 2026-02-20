<?php

namespace App\Services;

use App\Models\MenuPermission;
use Illuminate\Support\Facades\Auth;

class MenuService
{
    /**
     * Get menus for current user based on company and divisi
     */
    public function getMenusForCurrentUser()
    {
        $user = Auth::user();
        
        if (!$user || !$user->company_id || !$user->divisi_id) {
            return collect();
        }

        return MenuPermission::forCompanyAndDivisi($user->company_id, $user->divisi_id)
                            ->mainMenus()
                            ->get();
    }

    /**
     * Get submenus for a specific parent menu
     */
    public function getSubMenus($parentMenu, $companyId = null, $divisiId = null)
    {
        $user = Auth::user();
        $companyId = $companyId ?? $user->company_id;
        $divisiId = $divisiId ?? $user->divisi_id;

        if (!$companyId || !$divisiId) {
            return collect();
        }

        return MenuPermission::forCompanyAndDivisi($companyId, $divisiId)
                            ->subMenus($parentMenu)
                            ->get();
    }

    /**
     * Check if user has access to specific menu
     */
    public function hasMenuAccess($menuKey, $companyId = null, $divisiId = null)
    {
        $user = Auth::user();
        $companyId = $companyId ?? $user->company_id;
        $divisiId = $divisiId ?? $user->divisi_id;

        if (!$user || !$companyId || !$divisiId) {
            return false;
        }

        return MenuPermission::where('company_id', $companyId)
                            ->where('divisi_id', $divisiId)
                            ->where('menu_key', $menuKey)
                            ->where('is_active', true)
                            ->exists();
    }

    /**
     * Check if user has access to multiple menus (OR condition)
     */
    public function hasAnyMenuAccess($menuKeys, $companyId = null, $divisiId = null)
    {
        $user = Auth::user();
        $companyId = $companyId ?? $user->company_id;
        $divisiId = $divisiId ?? $user->divisi_id;

        if (!$companyId || !$divisiId) {
            return false;
        }

        return MenuPermission::where('company_id', $companyId)
                            ->where('divisi_id', $divisiId)
                            ->whereIn('menu_key', $menuKeys)
                            ->where('is_active', true)
                            ->exists();
    }

    /**
     * Get menu structure for building dynamic sidebar
     */
    public function getMenuStructure()
    {
        $user = Auth::user();
        
        if (!$user || !$user->company_id || !$user->divisi_id) {
            return [];
        }

        $mainMenus = $this->getMenusForCurrentUser();
        $menuStructure = [];

        foreach ($mainMenus as $menu) {
            $menuData = [
                'key' => $menu->menu_key,
                'name' => $menu->menu_name,
                'route' => $menu->route_name,
                'icon' => $menu->icon,
                'submenus' => []
            ];

            // Get submenus
            $subMenus = $this->getSubMenus($menu->menu_key);
            foreach ($subMenus as $subMenu) {
                $menuData['submenus'][] = [
                    'key' => $subMenu->menu_key,
                    'name' => $subMenu->menu_name,
                    'route' => $subMenu->route_name,
                    'icon' => $subMenu->icon,
                ];
            }

            $menuStructure[] = $menuData;
        }

        return $menuStructure;
    }

    /**
     * Get current user's company name
     */
    public function getCurrentCompanyName()
    {
        $user = Auth::user();
        
        if (!$user || !$user->company_id) {
            return 'PT. SPA';
        }

        $company = \App\Models\Company::find($user->company_id);
        return $company ? $company->name : 'PT. SPA';
    }

    /**
     * Check if user has access based on divisi_id (fallback for existing logic)
     */
    public function getDivisiMenuAccess($divisiIds)
    {
        $user = Auth::user();
        
        if (!$user || !$user->divisi_id) {
            return false;
        }

        if (!is_array($divisiIds)) {
            $divisiIds = [$divisiIds];
        }

        return in_array($user->divisi_id, $divisiIds);
    }
}