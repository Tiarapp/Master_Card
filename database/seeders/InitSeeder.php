<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class InitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //SEEDER DIVISI
        DB::table('divisi')->insert([
        	'kode' => 'ACC',
        	'nama' => 'ACCOUNTING',
        	'createdBy' => 'SEEDER'
        ]);

        DB::table('divisi')->insert([
        	'kode' => 'IT',
        	'nama' => 'INFORMATION TECHNOLOGY',
        	'createdBy' => 'SEEDER'
        ]);

        DB::table('divisi')->insert([
        	'kode' => 'MARK',
        	'nama' => 'MARKETING',
        	'createdBy' => 'SEEDER'
        ]);
    }
}
