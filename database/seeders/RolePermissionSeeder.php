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
        // 1. Define all permissions (parent + children)
        //    parent_slug = null  → top-level menu group
        //    parent_slug = '...' → sub-menu item
        // -------------------------------------------------------
        $permissions = [
            // ── Standalone top-level menus (no submenu) ─────────────────────
            ['slug' => 'barang',     'name' => 'Data Barang',   'parent_slug' => null, 'description' => 'Menu Data Barang'],
            ['slug' => 'opi',        'name' => 'OPI',           'parent_slug' => null, 'description' => 'Menu OPI'],
            ['slug' => 'mastercard', 'name' => 'Master Card',   'parent_slug' => null, 'description' => 'Menu Master Card'],

            // ── Accounting ───────────────────────────────────────────────────
            ['slug' => 'accounting',         'name' => 'Accounting',       'parent_slug' => null, 'description' => 'Grup menu Accounting'],
            ['slug' => 'accounting.cust',    'name' => 'Data Customer',    'parent_slug' => 'accounting', 'description' => null],
            ['slug' => 'accounting.vendortt','name' => 'Data Vendor TT',   'parent_slug' => 'accounting', 'description' => null],
            ['slug' => 'accounting.piutang', 'name' => 'Data Piutang',     'parent_slug' => 'accounting', 'description' => null],
            ['slug' => 'accounting.kontrak', 'name' => 'Export Kontrak',   'parent_slug' => 'accounting', 'description' => null],
            ['slug' => 'accounting.alamat',  'name' => 'Print Alamat',     'parent_slug' => 'accounting', 'description' => null],
            ['slug' => 'accounting.finance', 'name' => 'Import JU',        'parent_slug' => 'accounting', 'description' => null],
            ['slug' => 'accounting.mod',     'name' => 'Approve MOD',      'parent_slug' => 'accounting', 'description' => null],
            ['slug' => 'accounting.opi',     'name' => 'Approve OPI',      'parent_slug' => 'accounting', 'description' => null],

            // ── Logistik ─────────────────────────────────────────────────────
            ['slug' => 'logistik',           'name' => 'Logistik',         'parent_slug' => null, 'description' => 'Grup menu Logistik'],
            ['slug' => 'logistik.retur',     'name' => 'Retur Penjualan',  'parent_slug' => 'logistik', 'description' => null],
            ['slug' => 'logistik.bp_baru',   'name' => 'BP Baru',          'parent_slug' => 'logistik', 'description' => null],
            ['slug' => 'logistik.bp_lama',   'name' => 'BP Lama',          'parent_slug' => 'logistik', 'description' => null],

            // ── Inventory Management ─────────────────────────────────────────
            ['slug' => 'inventory',          'name' => 'Inventory Management', 'parent_slug' => null, 'description' => 'Grup menu Inventory'],
            ['slug' => 'inventory.supplier', 'name' => 'Supplier',         'parent_slug' => 'inventory', 'description' => null],
            ['slug' => 'inventory.inventory','name' => 'Inventory',        'parent_slug' => 'inventory', 'description' => null],
            ['slug' => 'inventory.bbk_roll', 'name' => 'BBK Roll',         'parent_slug' => 'inventory', 'description' => null],

            // ── Master ───────────────────────────────────────────────────────
            ['slug' => 'master',             'name' => 'Master',           'parent_slug' => null, 'description' => 'Grup menu Master'],
            ['slug' => 'master.divisi',      'name' => 'Divisi',           'parent_slug' => 'master', 'description' => null],
            ['slug' => 'master.flute',       'name' => 'Flute',            'parent_slug' => 'master', 'description' => null],
            ['slug' => 'master.jenisgram',   'name' => 'Jenis Gram',       'parent_slug' => 'master', 'description' => null],
            ['slug' => 'master.joint',       'name' => 'Joint',            'parent_slug' => 'master', 'description' => null],
            ['slug' => 'master.koli',        'name' => 'Koli',             'parent_slug' => 'master', 'description' => null],
            ['slug' => 'master.matauang',    'name' => 'Mata Uang',        'parent_slug' => 'master', 'description' => null],
            ['slug' => 'master.sales',       'name' => 'Sales',            'parent_slug' => 'master', 'description' => null],
            ['slug' => 'master.satuan',      'name' => 'Satuan',           'parent_slug' => 'master', 'description' => null],
            ['slug' => 'master.sheet',       'name' => 'Sheet',            'parent_slug' => 'master', 'description' => null],
            ['slug' => 'master.supplier',    'name' => 'Supplier',         'parent_slug' => 'master', 'description' => null],

            // ── Marketing ────────────────────────────────────────────────────
            ['slug' => 'marketing',                 'name' => 'Marketing',          'parent_slug' => null, 'description' => 'Grup menu Marketing'],
            ['slug' => 'marketing.boxtype',         'name' => 'Tipe Box',           'parent_slug' => 'marketing', 'description' => null],
            ['slug' => 'marketing.substance',       'name' => 'Substance',          'parent_slug' => 'marketing', 'description' => null],
            ['slug' => 'marketing.box',             'name' => 'Box',                'parent_slug' => 'marketing', 'description' => null],
            ['slug' => 'marketing.warna',           'name' => 'Warna',              'parent_slug' => 'marketing', 'description' => null],
            ['slug' => 'marketing.colorcombine',    'name' => 'Color Combine',      'parent_slug' => 'marketing', 'description' => null],
            ['slug' => 'marketing.kontrak',         'name' => 'Kontrak',            'parent_slug' => 'marketing', 'description' => null],
            ['slug' => 'marketing.dt',              'name' => 'Delivery Time',      'parent_slug' => 'marketing', 'description' => null],
            ['slug' => 'marketing.plan_kirim',      'name' => 'Plan Kirim',         'parent_slug' => 'marketing', 'description' => null],
            ['slug' => 'marketing.intake',          'name' => 'Export Intake',      'parent_slug' => 'marketing', 'description' => null],
            ['slug' => 'marketing.karet',           'name' => 'Alokasi Karet',      'parent_slug' => 'marketing', 'description' => null],
            ['slug' => 'marketing.forecast',        'name' => 'Target Customer',    'parent_slug' => 'marketing', 'description' => null],
            ['slug' => 'marketing.formpermintaan',  'name' => 'Form Permintaan',    'parent_slug' => 'marketing', 'description' => null],
            ['slug' => 'marketing.formmc',          'name' => 'Form Mastercard',    'parent_slug' => 'marketing', 'description' => null],
            ['slug' => 'marketing.mod',             'name' => 'MOD',                'parent_slug' => 'marketing', 'description' => null],
            ['slug' => 'marketing.mod_tanggal',     'name' => 'List MOD by Tanggal','parent_slug' => 'marketing', 'description' => null],

            // ── PPIC ─────────────────────────────────────────────────────────
            ['slug' => 'ppic',               'name' => 'PPIC',             'parent_slug' => null, 'description' => 'Grup menu PPIC'],
            ['slug' => 'ppic.roll',          'name' => 'Persediaan Roll',  'parent_slug' => 'ppic', 'description' => null],
            ['slug' => 'ppic.bbm_roll',      'name' => 'BBM Roll',         'parent_slug' => 'ppic', 'description' => null],
            ['slug' => 'ppic.bbk_roll',      'name' => 'BBK Roll',         'parent_slug' => 'ppic', 'description' => null],
            ['slug' => 'ppic.retur_roll',    'name' => 'Retur Roll',       'parent_slug' => 'ppic', 'description' => null],
            ['slug' => 'ppic.warna',         'name' => 'Warna',            'parent_slug' => 'ppic', 'description' => null],
            ['slug' => 'ppic.corrplan',      'name' => 'Plan Corrugating', 'parent_slug' => 'ppic', 'description' => null],
            ['slug' => 'ppic.conv',          'name' => 'Plan Converting',  'parent_slug' => 'ppic', 'description' => null],
            ['slug' => 'ppic.karet',         'name' => 'Karet',            'parent_slug' => 'ppic', 'description' => null],

            // ── Produksi ─────────────────────────────────────────────────────
            ['slug' => 'produksi',           'name' => 'Produksi',         'parent_slug' => null, 'description' => 'Grup menu Produksi'],
            ['slug' => 'produksi.hasil',     'name' => 'Hasil Produksi',   'parent_slug' => 'produksi', 'description' => null],
            ['slug' => 'produksi.laporan',   'name' => 'Laporan Produksi', 'parent_slug' => 'produksi', 'description' => null],

            // ── Palet ────────────────────────────────────────────────────────
            ['slug' => 'palet',              'name' => 'Palet',            'parent_slug' => null, 'description' => 'Grup menu Palet'],
            ['slug' => 'palet.sj',           'name' => 'Surat Jalan Palet','parent_slug' => 'palet', 'description' => null],
            ['slug' => 'palet.palet',        'name' => 'Palet',            'parent_slug' => 'palet', 'description' => null],

            // ── QC ───────────────────────────────────────────────────────────
            ['slug' => 'qc',                 'name' => 'QC',               'parent_slug' => null, 'description' => 'Grup menu QC'],
            ['slug' => 'qc.coa',             'name' => 'COA',              'parent_slug' => 'qc', 'description' => null],

            // ── Teknik ───────────────────────────────────────────────────────
            ['slug' => 'teknik',             'name' => 'Teknik',           'parent_slug' => null, 'description' => 'Grup menu Teknik'],
            ['slug' => 'teknik.barang',      'name' => 'List Barang',      'parent_slug' => 'teknik', 'description' => null],

            // ── HRD/GA ───────────────────────────────────────────────────────
            ['slug' => 'hrd_ga',             'name' => 'HRD/GA',           'parent_slug' => null, 'description' => 'Grup menu HRD/GA'],
            ['slug' => 'hrd_ga.stationary',  'name' => 'Stationary',       'parent_slug' => 'hrd_ga', 'description' => null],

            // ── Reports ──────────────────────────────────────────────────────
            ['slug' => 'reports',            'name' => 'Reports',          'parent_slug' => null, 'description' => 'Grup menu Reports'],
            ['slug' => 'reports.deadstock',  'name' => 'Deadstock Report', 'parent_slug' => 'reports', 'description' => null],
            ['slug' => 'reports.kapasitas',  'name' => 'Kapasitas Gudang', 'parent_slug' => 'reports', 'description' => null],
            ['slug' => 'reports.in_out_bound','name'=> 'In/Out Bound',     'parent_slug' => 'reports', 'description' => null],

            // ── IT Admin ─────────────────────────────────────────────────────
            ['slug' => 'it_admin',           'name' => 'IT Admin',         'parent_slug' => null, 'description' => 'Grup menu IT Admin'],
            ['slug' => 'it_admin.tracking',  'name' => 'Activity Tracking','parent_slug' => 'it_admin', 'description' => null],
            ['slug' => 'it_admin.feedback',  'name' => 'Feedback',         'parent_slug' => 'it_admin', 'description' => null],
            ['slug' => 'it_admin.hardware',  'name' => 'Hardware Management','parent_slug' => 'it_admin', 'description' => null],
            ['slug' => 'it_admin.company',   'name' => 'Company Management','parent_slug' => 'it_admin', 'description' => null],
            ['slug' => 'it_admin.roles',     'name' => 'Roles & Permissions','parent_slug' => 'it_admin', 'description' => null],

            // ── Stellar / Bahan Pembantu ──────────────────────────────────────
            ['slug' => 'stellar',            'name' => 'Bahan Pembantu',   'parent_slug' => null, 'description' => 'Grup menu Bahan Pembantu'],
            ['slug' => 'stellar.php',        'name' => 'PHP',              'parent_slug' => 'stellar', 'description' => null],
        ];

        foreach ($permissions as $perm) {
            Permission::updateOrCreate(
                ['slug' => $perm['slug']],
                [
                    'name'        => $perm['name'],
                    'description' => $perm['description'],
                    'parent_slug' => $perm['parent_slug'],
                ]
            );
        }

        // -------------------------------------------------------
        // 2. Define default roles and their permissions
        //    Assign parent slug → gives access to ALL sub-menus.
        //    Assign child slug  → gives access to ONLY that sub-menu.
        // -------------------------------------------------------
        $allSlugs = Permission::pluck('slug')->toArray();

        $roles = [
            [
                'name' => 'Super Admin', 'slug' => 'super-admin',
                'description' => 'Akses ke semua menu',
                'permissions' => $allSlugs,
            ],
            [
                'name' => 'IT', 'slug' => 'it',
                'description' => 'Divisi IT — akses penuh',
                'permissions' => $allSlugs,
            ],
            [
                'name' => 'Marketing', 'slug' => 'marketing-role',
                'description' => 'Divisi Marketing',
                'permissions' => [
                    'barang', 'opi', 'mastercard',
                    'master', // semua sub-master
                    'marketing', // semua sub-marketing
                ],
            ],
            [
                'name' => 'Accounting', 'slug' => 'accounting-role',
                'description' => 'Divisi Accounting',
                'permissions' => [
                    'barang',
                    'accounting', // semua sub-accounting
                ],
            ],
            [
                'name' => 'PPIC', 'slug' => 'ppic-role',
                'description' => 'Divisi PPIC',
                'permissions' => [
                    'barang', 'opi', 'mastercard',
                    'ppic',     // semua sub-ppic
                    'produksi', // semua sub-produksi
                ],
            ],
            [
                'name' => 'Logistik', 'slug' => 'logistik-role',
                'description' => 'Divisi Logistik / Gudang',
                'permissions' => [
                    'barang',
                    'logistik',  // semua sub-logistik
                    'inventory', // semua sub-inventory
                    'reports',   // semua sub-reports
                ],
            ],
            [
                'name' => 'QC', 'slug' => 'qc-role',
                'description' => 'Divisi Quality Control',
                'permissions' => ['qc', 'qc.coa'],
            ],
            [
                'name' => 'Teknik', 'slug' => 'teknik-role',
                'description' => 'Divisi Teknik',
                'permissions' => ['teknik', 'teknik.barang'],
            ],
            [
                'name' => 'HRD/GA', 'slug' => 'hrd-ga-role',
                'description' => 'Divisi HRD/GA',
                'permissions' => ['hrd_ga', 'hrd_ga.stationary'],
            ],
            [
                'name' => 'Palet', 'slug' => 'palet-role',
                'description' => 'Divisi Palet',
                'permissions' => ['palet', 'palet.sj', 'palet.palet'],
            ],
        ];

        foreach ($roles as $roleData) {
            $role = Role::updateOrCreate(
                ['slug' => $roleData['slug']],
                ['name' => $roleData['name'], 'description' => $roleData['description']]
            );

            $permissionIds = Permission::whereIn('slug', $roleData['permissions'])->pluck('id');
            $role->permissions()->sync($permissionIds);
        }
    }
}

