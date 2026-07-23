<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class SuratJalanPermissionSeeder extends Seeder
{
    public function run()
    {
        $permission = Permission::updateOrCreate(
            ['slug' => 'reports.surat_jalan'],
            [
                'name' => 'Surat Jalan',
                'description' => 'Menu Surat Jalan pada Reports',
                'parent_slug' => 'reports',
            ]
        );

        $logistikRole = Role::where('slug', 'logistik-role')->first();

        if ($logistikRole) {
            $logistikRole->permissions()->syncWithoutDetaching([$permission->id]);
        }
    }
}
