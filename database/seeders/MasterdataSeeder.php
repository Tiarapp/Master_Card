<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MasterdataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $masterdata = [
            [
            'name' => 'PT. Sun Paper Source',
            'type' => 'supplier',
            'city' => 'Jakarta',
            ],
            [
            'name' => 'PT. Indah Kiat Pulp & Paper',
            'type' => 'supplier',
            'city' => 'Jakarta',
            ],
            [
            'name' => 'PT. Pindo Deli Pulp & Paper Mills',
            'type' => 'supplier',
            'city' => 'Jakarta',
            ],
            [
            'name' => 'PT. Tjiwi Kimia',
            'type' => 'supplier',
            'city' => 'Jakarta',
            ],
            [
            'name' => 'PT. Kertas Kraft Aceh',
            'type' => 'supplier',
            'city' => 'Jakarta',
            ],
            [
            'name' => 'PT. Kertas Leces',
            'type' => 'supplier',
            'city' => 'Jakarta',
            ],
            [
            'name' => 'Sukarno',
            'type' => 'customer',
            'city' => 'Surabaya',
            ],
            [
            'name' => 'Bambang',
            'type' => 'customer',
            'city' => 'Surabaya',
            ],
            [
            'name' => 'Joko',
            'type' => 'customer',
            'city' => 'Surabaya',
            ],
            [
            'name' => 'Siti',
            'type' => 'customer',
            'city' => 'Surabaya',
            ],
        ];

        foreach ($masterdata as $data) {
            \App\Models\Masterdata::create($data);
        }
    }
}
