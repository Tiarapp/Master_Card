<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FluteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('flute')->insert([
        	'kode' => '4',
        	'nama' => 'KF',
        	'tur1' => 1.33,
        	'createdBy' => 'Seeder'
        ]);
    }
}
