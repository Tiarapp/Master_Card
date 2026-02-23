<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuPermission;
use Carbon\Carbon;

class MenuPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createCorrugatedBoxMenus();
        $this->createTissueMenus();
    }

    /**
     * Create menu permissions for Corrugated Box Company (Company ID 1)
     */
    private function createCorrugatedBoxMenus()
    {
        $companyId = 1;
        $menus = [
            // Shared Menus
            ['company_id' => $companyId, 'divisi_id' => 2, 'menu_key' => 'barang', 'menu_name' => 'Data Barang', 'route_name' => 'barang.indexnew', 'icon' => 'fa-solid fa-boxes-stacked', 'order' => 1],
            ['company_id' => $companyId, 'divisi_id' => 3, 'menu_key' => 'barang', 'menu_name' => 'Data Barang', 'route_name' => 'barang.indexnew', 'icon' => 'fa-solid fa-boxes-stacked', 'order' => 1],
            ['company_id' => $companyId, 'divisi_id' => 5, 'menu_key' => 'barang', 'menu_name' => 'Data Barang', 'route_name' => 'barang.indexnew', 'icon' => 'fa-solid fa-boxes-stacked', 'order' => 1],
            ['company_id' => $companyId, 'divisi_id' => 6, 'menu_key' => 'barang', 'menu_name' => 'Data Barang', 'route_name' => 'barang.indexnew', 'icon' => 'fa-solid fa-boxes-stacked', 'order' => 1],
            ['company_id' => $companyId, 'divisi_id' => 13, 'menu_key' => 'barang', 'menu_name' => 'Data Barang', 'route_name' => 'barang.indexnew', 'icon' => 'fa-solid fa-boxes-stacked', 'order' => 1],

            ['company_id' => $companyId, 'divisi_id' => 2, 'menu_key' => 'opi', 'menu_name' => 'OPI', 'route_name' => 'opinew', 'icon' => 'fa-solid fa-clipboard-check', 'order' => 2],
            ['company_id' => $companyId, 'divisi_id' => 3, 'menu_key' => 'opi', 'menu_name' => 'OPI', 'route_name' => 'opinew', 'icon' => 'fa-solid fa-clipboard-check', 'order' => 2],
            ['company_id' => $companyId, 'divisi_id' => 5, 'menu_key' => 'opi', 'menu_name' => 'OPI', 'route_name' => 'opinew', 'icon' => 'fa-solid fa-clipboard-check', 'order' => 2],
            ['company_id' => $companyId, 'divisi_id' => 9, 'menu_key' => 'opi', 'menu_name' => 'OPI', 'route_name' => 'opinew', 'icon' => 'fa-solid fa-clipboard-check', 'order' => 2],
            ['company_id' => $companyId, 'divisi_id' => 13, 'menu_key' => 'opi', 'menu_name' => 'OPI', 'route_name' => 'opinew', 'icon' => 'fa-solid fa-clipboard-check', 'order' => 2],

            ['company_id' => $companyId, 'divisi_id' => 2, 'menu_key' => 'mastercard', 'menu_name' => 'Master Card', 'route_name' => 'mastercard.b1', 'icon' => 'fa-solid fa-file-invoice', 'order' => 3],
            ['company_id' => $companyId, 'divisi_id' => 3, 'menu_key' => 'mastercard', 'menu_name' => 'Master Card', 'route_name' => 'mastercard.b1', 'icon' => 'fa-solid fa-file-invoice', 'order' => 3],
            ['company_id' => $companyId, 'divisi_id' => 5, 'menu_key' => 'mastercard', 'menu_name' => 'Master Card', 'route_name' => 'mastercard.b1', 'icon' => 'fa-solid fa-file-invoice', 'order' => 3],
            ['company_id' => $companyId, 'divisi_id' => 13, 'menu_key' => 'mastercard', 'menu_name' => 'Master Card', 'route_name' => 'mastercard.b1', 'icon' => 'fa-solid fa-file-invoice', 'order' => 3],

            // Accounting Menu
            ['company_id' => $companyId, 'divisi_id' => 1, 'menu_key' => 'accounting', 'menu_name' => 'Accounting', 'route_name' => null, 'icon' => 'fa-solid fa-calculator', 'order' => 4],
            ['company_id' => $companyId, 'divisi_id' => 2, 'menu_key' => 'accounting', 'menu_name' => 'Accounting', 'route_name' => null, 'icon' => 'fa-solid fa-calculator', 'order' => 4],

            // Logistik Menu  
            ['company_id' => $companyId, 'divisi_id' => 2, 'menu_key' => 'logistik', 'menu_name' => 'Logistik', 'route_name' => null, 'icon' => 'fa-solid fa-warehouse', 'order' => 5],
            ['company_id' => $companyId, 'divisi_id' => 6, 'menu_key' => 'logistik', 'menu_name' => 'Logistik', 'route_name' => null, 'icon' => 'fa-solid fa-warehouse', 'order' => 5],

            // Inventory Management
            ['company_id' => $companyId, 'divisi_id' => 2, 'menu_key' => 'inventory', 'menu_name' => 'Inventory Management', 'route_name' => null, 'icon' => 'fa-solid fa-warehouse', 'order' => 6],
            ['company_id' => $companyId, 'divisi_id' => 6, 'menu_key' => 'inventory', 'menu_name' => 'Inventory Management', 'route_name' => null, 'icon' => 'fa-solid fa-warehouse', 'order' => 6],

            // Master Menu
            ['company_id' => $companyId, 'divisi_id' => 2, 'menu_key' => 'master', 'menu_name' => 'Master', 'route_name' => null, 'icon' => 'fas fa-tachometer-alt', 'order' => 7],
            ['company_id' => $companyId, 'divisi_id' => 3, 'menu_key' => 'master', 'menu_name' => 'Master', 'route_name' => null, 'icon' => 'fas fa-tachometer-alt', 'order' => 7],
            ['company_id' => $companyId, 'divisi_id' => 13, 'menu_key' => 'master', 'menu_name' => 'Master', 'route_name' => null, 'icon' => 'fas fa-tachometer-alt', 'order' => 7],

            // Marketing Menu
            ['company_id' => $companyId, 'divisi_id' => 2, 'menu_key' => 'marketing', 'menu_name' => 'Marketing', 'route_name' => null, 'icon' => 'fa-solid fa-comment-dollar', 'order' => 8],
            ['company_id' => $companyId, 'divisi_id' => 3, 'menu_key' => 'marketing', 'menu_name' => 'Marketing', 'route_name' => null, 'icon' => 'fa-solid fa-comment-dollar', 'order' => 8],
            ['company_id' => $companyId, 'divisi_id' => 13, 'menu_key' => 'marketing', 'menu_name' => 'Marketing', 'route_name' => null, 'icon' => 'fa-solid fa-comment-dollar', 'order' => 8],

            // Corrugated Box specific menus (different from Tissue)
            ['company_id' => $companyId, 'divisi_id' => 2, 'menu_key' => 'corrugated_production', 'menu_name' => 'Corrugated Production', 'route_name' => null, 'icon' => 'fa-solid fa-industry', 'order' => 10],
            ['company_id' => $companyId, 'divisi_id' => 9, 'menu_key' => 'corrugated_production', 'menu_name' => 'Corrugated Production', 'route_name' => null, 'icon' => 'fa-solid fa-industry', 'order' => 10],

            // PPIC Menu
            ['company_id' => $companyId, 'divisi_id' => 2, 'menu_key' => 'ppic', 'menu_name' => 'PPIC', 'route_name' => null, 'icon' => 'fa-solid fa-users-gear', 'order' => 11],
            ['company_id' => $companyId, 'divisi_id' => 5, 'menu_key' => 'ppic', 'menu_name' => 'PPIC', 'route_name' => null, 'icon' => 'fa-solid fa-users-gear', 'order' => 11],

            // Produksi Menu
            ['company_id' => $companyId, 'divisi_id' => 2, 'menu_key' => 'produksi', 'menu_name' => 'Produksi', 'route_name' => null, 'icon' => 'fa-solid fa-screwdriver-wrench', 'order' => 12],
            ['company_id' => $companyId, 'divisi_id' => 5, 'menu_key' => 'produksi', 'menu_name' => 'Produksi', 'route_name' => null, 'icon' => 'fa-solid fa-screwdriver-wrench', 'order' => 12],

            // Palet Menu
            ['company_id' => $companyId, 'divisi_id' => 2, 'menu_key' => 'palet', 'menu_name' => 'Palet', 'route_name' => null, 'icon' => 'fa-solid fa-chess-board', 'order' => 13],
            ['company_id' => $companyId, 'divisi_id' => 10, 'menu_key' => 'palet', 'menu_name' => 'Palet', 'route_name' => null, 'icon' => 'fa-solid fa-chess-board', 'order' => 13],

            // QC Menu  
            ['company_id' => $companyId, 'divisi_id' => 2, 'menu_key' => 'qc', 'menu_name' => 'QC', 'route_name' => null, 'icon' => 'fa-solid fa-medal', 'order' => 14],
            ['company_id' => $companyId, 'divisi_id' => 12, 'menu_key' => 'qc', 'menu_name' => 'QC', 'route_name' => null, 'icon' => 'fa-solid fa-medal', 'order' => 14],

            // Teknik Menu  
            ['company_id' => $companyId, 'divisi_id' => 2, 'menu_key' => 'teknik', 'menu_name' => 'Teknik', 'route_name' => null, 'icon' => 'fa-solid fa-wrench', 'order' => 15],
            ['company_id' => $companyId, 'divisi_id' => 8, 'menu_key' => 'teknik', 'menu_name' => 'Teknik', 'route_name' => null, 'icon' => 'fa-solid fa-wrench', 'order' => 15],

            // HRD/GA Menu  
            ['company_id' => $companyId, 'divisi_id' => 2, 'menu_key' => 'hrd_ga', 'menu_name' => 'HRD/GA', 'route_name' => null, 'icon' => 'fa-solid fa-user-pen', 'order' => 16],
            ['company_id' => $companyId, 'divisi_id' => 9, 'menu_key' => 'hrd_ga', 'menu_name' => 'HRD/GA', 'route_name' => null, 'icon' => 'fa-solid fa-user-pen', 'order' => 16],

            // Reports Menu  
            ['company_id' => $companyId, 'divisi_id' => 2, 'menu_key' => 'reports', 'menu_name' => 'Reports', 'route_name' => null, 'icon' => 'fas fa-chart-bar', 'order' => 17],
            ['company_id' => $companyId, 'divisi_id' => 14, 'menu_key' => 'reports', 'menu_name' => 'Reports', 'route_name' => null, 'icon' => 'fas fa-chart-bar', 'order' => 17],

            // Feedback Management - IT Only
            ['company_id' => $companyId, 'divisi_id' => 2, 'menu_key' => 'feedback_manage', 'menu_name' => 'Feedback Management', 'route_name' => null, 'icon' => 'fas fa-list', 'order' => 18],

            // IT Admin Menu - IT Only
            ['company_id' => $companyId, 'divisi_id' => 2, 'menu_key' => 'it_admin', 'menu_name' => 'IT Administration', 'route_name' => null, 'icon' => 'fas fa-desktop', 'order' => 19],
        ];

        foreach ($menus as $menu) {
            MenuPermission::updateOrCreate(
                [
                    'company_id' => $menu['company_id'],
                    'divisi_id' => $menu['divisi_id'],
                    'menu_key' => $menu['menu_key']
                ],
                $menu
            );
        }
    }

    /**
     * Create menu permissions for Tissue Manufacturing Company (Company ID 2)
     */
    private function createTissueMenus()
    {
        $companyId = 2;
        $menus = [
            // Basic menus for Tissue Manufacturing - different configuration
            ['company_id' => $companyId, 'divisi_id' => 2, 'menu_key' => 'stellar', 'menu_name' => 'Bahan Pembantu', 'route_name' => 'stellar.bp.index', 'icon' => 'fa-solid fa-toilet-paper', 'order' => 1],
            ['company_id' => $companyId, 'divisi_id' => 9, 'menu_key' => 'stellar', 'menu_name' => 'Bahan Pembantu', 'route_name' => 'stellar.bp.index', 'icon' => 'fa-solid fa-toilet-paper', 'order' => 1],
        ];

        foreach ($menus as $menu) {
            MenuPermission::updateOrCreate(
                [
                    'company_id' => $menu['company_id'],
                    'divisi_id' => $menu['divisi_id'],
                    'menu_key' => $menu['menu_key']
                ],
                $menu
            );
        }
    }
}
