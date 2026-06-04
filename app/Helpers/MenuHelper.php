<?php

if (!function_exists('hasMenuAccess')) {
    /**
     * Check if current user has access to specific menu key.
     *
     * Priority:
     *  1. If the user has any roles assigned → use role-based permission check.
     *  2. If the user has no roles and no company_id → legacy IT admin (allow all).
     *  3. If the user has no roles but has company_id → use legacy MenuPermission table.
     */
    function hasMenuAccess($menuKey)
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        // 1. Role-based check (new system)
        if ($user->roles()->exists()) {
            return $user->hasPermission($menuKey);
        }

        // 2. No roles assigned yet — legacy behaviour
        // Users without a company are considered IT/admin (full access)
        if (!$user->company_id) {
            return true;
        }

        // 3. Company user without roles → use MenuPermission table
        if (!$user->divisi_id) {
            return false;
        }

        return \App\Models\MenuPermission::where('company_id', $user->company_id)
                                        ->where('divisi_id', $user->divisi_id)
                                        ->where('menu_key', $menuKey)
                                        ->where('is_active', true)
                                        ->exists();
    }
}

if (!function_exists('hasAnyMenuAccess')) {
    /**
     * Check if current user has access to any of the menu keys.
     */
    function hasAnyMenuAccess($menuKeys)
    {
        foreach ((array) $menuKeys as $key) {
            if (hasMenuAccess($key)) {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('getCurrentCompanyName')) {
    /**
     * Get current user's company name
     */
    function getCurrentCompanyName()
    {
        $user = Auth::user();

        if (!$user || !$user->company_id) {
            return 'PT. SPA';
        }

        $company = \App\Models\Company::find($user->company_id);
        return $company ? $company->name : 'PT. SPA';
    }
}

if (!function_exists('getDivisiMenuAccess')) {
    /**
     * Check if user has access based on divisi_id (fallback for existing logic)
     */
    function getDivisiMenuAccess($divisiIds)
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

if (!function_exists('hasRole')) {
    /**
     * Check if current authenticated user has a given role (by slug).
     */
    function hasRole($slug)
    {
        $user = Auth::user();
        return $user ? $user->hasRole($slug) : false;
    }
}
