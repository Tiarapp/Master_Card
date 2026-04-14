<?php

if (!function_exists('hasMenuAccess')) {
    /**
     * Check if current user has access to specific menu key
     */
    function hasMenuAccess($menuKey)
    {
        $user = Auth::user();
        
        if (!$user || !$user->company_id || !$user->divisi_id) {
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
     * Check if current user has access to any of the menu keys
     */
    function hasAnyMenuAccess($menuKeys)
    {
        $user = Auth::user();
        
        if (!$user || !$user->company_id || !$user->divisi_id) {
            return false;
        }

        return \App\Models\MenuPermission::where('company_id', $user->company_id)
                                        ->where('divisi_id', $user->divisi_id)
                                        ->whereIn('menu_key', $menuKeys)
                                        ->where('is_active', true)
                                        ->exists();
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