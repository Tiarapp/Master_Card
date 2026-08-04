<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class FinishGoodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = Permission::updateOrCreate(
            ['slug' => 'reports.finish_goods'],
            [
                'name' => 'Finish Goods',
                'description' => 'Menu Finish Goods pada Reports',
                'parent_slug' => 'reports',
            ]
        );

        $logistikRole = Role::where('slug', 'logistik-role')->first();

        if ($logistikRole) {
            $logistikRole->permissions()->syncWithoutDetaching([$permission->id]);
        }
    }
}
