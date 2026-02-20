<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * Display companies list for switching
     */
    public function index()
    {
        $companies = Company::all();
        $currentUser = Auth::user();
        
        return view('admin.company.switch', compact('companies', 'currentUser'));
    }

    /**
     * Switch user company for testing purposes
     * This is for demo purposes only
     */
    public function switchCompany(Request $request, $companyId)
    {
        $company = Company::findOrFail($companyId);
        $user = Auth::user();
        
        $user->update(['company_id' => $companyId]);
        
        return redirect()->back()->with('success', 'Company switched to ' . $company->name);
    }

    /**
     * Get company info and menu structure
     */
    public function getCompanyInfo()
    {
        $user = Auth::user();
        
        if (!$user->company_id) {
            return response()->json(['error' => 'No company assigned']);
        }

        $company = $user->company;
        $menuStructure = app(\App\Services\MenuService::class)->getMenuStructure();
        
        return response()->json([
            'company' => $company,
            'menu_structure' => $menuStructure
        ]);
    }
}