<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WarnaRollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['nama' => 'blue'],
            ['nama' => 'red'],
            ['nama' => 'yellow'],
            ['nama' => 'green'],
            ['nama' => 'gray'],
            ['nama' => 'brown'],
            ['nama' => 'purple'],
            ['nama' => 'orange'],
            ['nama' => 'pink'],
            ['nama' => 'cyan'],
            ['nama' => 'magenta'],
            ['nama' => 'lime'],
            ['nama' => 'teal'],
            ['nama' => 'navy'],
            ['nama' => 'maroon'],
            ['nama' => 'olive'],
            ['nama' => 'silver'],
            ['nama' => 'gold'],
        ];

        DB::table('warna_rolls')->insert($data);
    }
}
