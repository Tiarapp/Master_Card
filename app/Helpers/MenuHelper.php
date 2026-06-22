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
        /** @var \App\Models\User|null $user */
        $user = auth()->user();

        if (!$user) {
            return false;
        }

        static $permissionCacheByUser = [];
        static $legacyMenuCacheByUser = [];

        if (!isset($permissionCacheByUser[$user->id])) {
            $roles = $user->roles()->with('permissions:id,slug')->get();
            $permissionSlugs = $roles
                ->pluck('permissions')
                ->flatten()
                ->pluck('slug')
                ->unique()
                ->values()
                ->all();

            $permissionLookup = array_fill_keys($permissionSlugs, true);
            $permissionParents = [];

            foreach ($permissionSlugs as $slug) {
                if (str_contains($slug, '.')) {
                    $permissionParents[explode('.', $slug)[0]] = true;
                }
            }

            $permissionCacheByUser[$user->id] = [
                'has_roles' => $roles->isNotEmpty(),
                'lookup' => $permissionLookup,
                'parents' => $permissionParents,
            ];
        }

        $permissionCache = $permissionCacheByUser[$user->id];

        // 1. Role-based check (cached per request)
        if ($permissionCache['has_roles']) {
            if (str_contains($menuKey, '.')) {
                $parentSlug = explode('.', $menuKey)[0];
                return isset($permissionCache['lookup'][$parentSlug]) || isset($permissionCache['lookup'][$menuKey]);
            }

            return isset($permissionCache['lookup'][$menuKey]) || isset($permissionCache['parents'][$menuKey]);
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

        if (!isset($legacyMenuCacheByUser[$user->id])) {
            $legacyMenuCacheByUser[$user->id] = \App\Models\MenuPermission::where('company_id', $user->company_id)
                ->where('divisi_id', $user->divisi_id)
                ->where('is_active', true)
                ->pluck('menu_key')
                ->flip()
                ->all();
        }

        return isset($legacyMenuCacheByUser[$user->id][$lookupKey]);
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
        /** @var \App\Models\User|null $user */
        $user = auth()->user();

        if (!$user || !$user->company_id) {
            return 'PT. SPA';
        }

        static $companyNameCacheByUser = [];

        if (!isset($companyNameCacheByUser[$user->id])) {
            $companyNameCacheByUser[$user->id] = optional($user->company)->name ?? 'PT. SPA';
        }

        return $companyNameCacheByUser[$user->id];
    }
}

if (!function_exists('getDivisiMenuAccess')) {
    /**
     * Check if user has access based on divisi_id (fallback for existing logic)
     */
    function getDivisiMenuAccess($divisiIds)
    {
        $user = auth()->user();

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
        /** @var \App\Models\User|null $user */
        $user = auth()->user();
        return $user ? $user->hasRole($slug) : false;
    }
}
