<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // -------------------------------------------------------
        // 1. Define all menu-based permissions
        // -------------------------------------------------------
        $permissions = [
            ['slug' => 'barang',    'name' => 'Data Barang',          'description' => 'Akses menu Data Barang'],
            ['slug' => 'opi',       'name' => 'OPI',                  'description' => 'Akses menu OPI'],
            ['slug' => 'mastercard','name' => 'Master Card',          'description' => 'Akses menu Master Card'],
            ['slug' => 'accounting','name' => 'Accounting',           'description' => 'Akses menu Accounting'],
            ['slug' => 'logistik',  'name' => 'Logistik',             'description' => 'Akses menu Logistik'],
            ['slug' => 'inventory', 'name' => 'Inventory Management', 'description' => 'Akses menu Inventory Management'],
            ['slug' => 'master',    'name' => 'Master',               'description' => 'Akses menu Master'],
            ['slug' => 'marketing', 'name' => 'Marketing',            'description' => 'Akses menu Marketing'],
            ['slug' => 'ppic',      'name' => 'PPIC',                 'description' => 'Akses menu PPIC'],
            ['slug' => 'produksi',  'name' => 'Produksi',             'description' => 'Akses menu Produksi'],
            ['slug' => 'palet',     'name' => 'Palet',                'description' => 'Akses menu Palet'],
            ['slug' => 'qc',        'name' => 'QC',                   'description' => 'Akses menu QC'],
            ['slug' => 'teknik',    'name' => 'Teknik',               'description' => 'Akses menu Teknik'],
            ['slug' => 'hrd_ga',    'name' => 'HRD/GA',               'description' => 'Akses menu HRD/GA'],
            ['slug' => 'reports',   'name' => 'Reports',              'description' => 'Akses menu Reports'],
            ['slug' => 'it_admin',  'name' => 'IT Admin',             'description' => 'Akses menu IT Admin (Activity Tracking, Feedback, Hardware, Company)'],
            ['slug' => 'stellar',   'name' => 'Bahan Pembantu',       'description' => 'Akses menu Bahan Pembantu (Stellar)'],
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['slug' => $perm['slug']], [
                'name'        => $perm['name'],
                'description' => $perm['description'],
            ]);
        }

        // -------------------------------------------------------
        // 2. Define default roles and their permissions
        // -------------------------------------------------------

        // Reload all permissions AFTER creating them above so Super Admin gets all
        $allPermissionSlugs = Permission::pluck('slug')->toArray();

        $roles = [
            [
                'name'        => 'Super Admin',
                'slug'        => 'super-admin',
                'description' => 'Akses ke semua menu',
                'permissions' => $allPermissionSlugs,
            ],
            [
                'name'        => 'IT',
                'slug'        => 'it',
                'description' => 'Divisi IT — akses penuh termasuk admin panel',
                'permissions' => [
                    'barang', 'opi', 'mastercard', 'accounting', 'logistik',
                    'inventory', 'master', 'marketing', 'ppic', 'produksi',
                    'palet', 'qc', 'teknik', 'hrd_ga', 'reports', 'it_admin', 'stellar',
                ],
            ],
            [
                'name'        => 'Marketing',
                'slug'        => 'marketing',
                'description' => 'Divisi Marketing',
                'permissions' => ['barang', 'opi', 'mastercard', 'master', 'marketing'],
            ],
            [
                'name'        => 'Accounting',
                'slug'        => 'accounting',
                'description' => 'Divisi Accounting',
                'permissions' => ['barang', 'accounting'],
            ],
            [
                'name'        => 'PPIC',
                'slug'        => 'ppic',
                'description' => 'Divisi PPIC',
                'permissions' => ['barang', 'opi', 'mastercard', 'ppic', 'produksi'],
            ],
            [
                'name'        => 'Logistik',
                'slug'        => 'logistik',
                'description' => 'Divisi Logistik / Gudang',
                'permissions' => ['barang', 'logistik', 'inventory', 'reports'],
            ],
            [
                'name'        => 'QC',
                'slug'        => 'qc',
                'description' => 'Divisi Quality Control',
                'permissions' => ['qc'],
            ],
            [
                'name'        => 'Teknik',
                'slug'        => 'teknik',
                'description' => 'Divisi Teknik',
                'permissions' => ['teknik'],
            ],
            [
                'name'        => 'HRD/GA',
                'slug'        => 'hrd-ga',
                'description' => 'Divisi HRD/GA',
                'permissions' => ['hrd_ga'],
            ],
            [
                'name'        => 'Palet',
                'slug'        => 'palet',
                'description' => 'Divisi Palet',
                'permissions' => ['palet'],
            ],
        ];

        foreach ($roles as $roleData) {
            $role = Role::firstOrCreate(['slug' => $roleData['slug']], [
                'name'        => $roleData['name'],
                'description' => $roleData['description'],
            ]);

            $permissionIds = Permission::whereIn('slug', $roleData['permissions'])->pluck('id');
            $role->permissions()->sync($permissionIds);
        }
    }
}
