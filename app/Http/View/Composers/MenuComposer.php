<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Services\MenuService;

class MenuComposer
{
    protected $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    public function compose(View $view)
    {
        $menuStructure = $this->menuService->getMenuStructure();
        $companyName = $this->menuService->getCurrentCompanyName();
        
        $view->with([
            'menuStructure' => $menuStructure,
            'currentCompanyName' => $companyName,
            'menuService' => $this->menuService
        ]);
    }
}