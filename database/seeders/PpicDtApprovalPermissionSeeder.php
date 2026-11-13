<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PpicDtApprovalPermissionSeeder extends Seeder
{
    public function run()
    {
        Permission::updateOrCreate(
            ['slug' => 'ppic.dt_approval'],
            [
                'name' => 'Approval Perubahan DT',
                'description' => 'Persetujuan perubahan Delivery Time',
                'parent_slug' => 'ppic',
            ]
        );
    }
}
