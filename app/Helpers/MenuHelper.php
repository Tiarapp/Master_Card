<?php

if (!function_exists('hasMenuAccess')) {
    /**
     * Check if current user has access to a menu key (parent or sub-menu).
     *
     * Rules:
     *  1. If user has roles → role-based check:
     *     - For a PARENT slug (e.g. 'accounting'):
     *       visible if user has 'accounting' OR any 'accounting.*' child permission.
     *     - For a CHILD slug (e.g. 'accounting.cust'):
     *       visible if user has 'accounting' (parent) OR 'accounting.cust' specifically.
     *  2. No roles + no company_id → legacy IT admin (allow all).
     *  3. No roles + has company_id → use legacy MenuPermission table (parent slug only).
     */
    function hasMenuAccess($menuKey)
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        // 1. Role-based check
        if ($user->roles()->exists()) {
            $userPerms = $user->getAllPermissions();

            if (str_contains($menuKey, '.')) {
                // Child slug: allow if user has the parent OR the specific child
                $parentSlug = explode('.', $menuKey)[0];
                return $userPerms->contains($parentSlug) || $userPerms->contains($menuKey);
            }

            // Parent slug: allow if user has exact slug OR any child permission of this parent
            return $userPerms->contains($menuKey)
                || $userPerms->filter(fn($s) => str_starts_with($s, $menuKey . '.'))->isNotEmpty();
        }

        // 2. Legacy: no roles, no company → full access (IT admin)
        if (!$user->company_id) {
            return false;
        }

        // 3. Legacy MenuPermission table (supports parent slugs only)
        if (!$user->divisi_id) {
            return false;
        }

        $lookupKey = str_contains($menuKey, '.') ? explode('.', $menuKey)[0] : $menuKey;

        return \App\Models\MenuPermission::where('company_id', $user->company_id)
                                        ->where('divisi_id', $user->divisi_id)
                                        ->where('menu_key', $lookupKey)
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
