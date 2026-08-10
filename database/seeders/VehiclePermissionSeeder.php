<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class VehiclePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $parent = Permission::updateOrCreate(
        //     ['slug' => 'vehicle'],
        //     [
        //         'name' => 'Vehicle',
        //         'description' => 'Grup menu Vehicle',
        //         'parent_slug' => null,
        //     ]
        // );

        $child = Permission::updateOrCreate(
            ['slug' => 'vehicle.list'],
            [
                'name' => 'Vehicle List',
                'description' => 'Menu Vehicle List pada Vehicle',
                'parent_slug' => 'hrd_ga',
            ]
        );

        $logistikRole = Role::where('slug', 'logistik-role')->first();

        if ($logistikRole) {
            $logistikRole->permissions()->syncWithoutDetaching([$child->id]);
        }
    }
}
