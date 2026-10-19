<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class OpiExportPermissionSeeder extends Seeder
{
    public function run()
    {
        $permission = Permission::updateOrCreate(
            ['slug' => 'reports.opi_export'],
            [
                'name' => 'Export OPI',
                'description' => 'Menu Export OPI pada Reports',
                'parent_slug' => 'reports',
            ]
        );

        $roles = Role::whereIn('slug', ['logistik-role', 'ppic-role'])->get();

        foreach ($roles as $role) {
            $role->permissions()->syncWithoutDetaching([$permission->id]);
        }
    }
}
