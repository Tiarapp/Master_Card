<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

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

        // jenis_gram
        DB::table('jenis_gram')->insert([
        	'kode' => 'BK125',
        	'nama' => 'BK125',
        	'jenisKertas' => 'BK',
        	'gramKertas' => '125',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'MF125',
        	'nama' => 'MF125',
        	'jenisKertas' => 'MF',
        	'gramKertas' => '125',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'TL125',
        	'nama' => 'TL125',
        	'jenisKertas' => 'TL',
        	'gramKertas' => '125',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'ML127',
        	'nama' => 'ML127',
        	'jenisKertas' => 'ML',
        	'gramKertas' => '127',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'ML120',
        	'nama' => 'ML120',
        	'jenisKertas' => 'ML',
        	'gramKertas' => '120',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'ML125',
        	'nama' => 'ML125',
        	'jenisKertas' => 'ML',
        	'gramKertas' => '125',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'MF127',
        	'nama' => 'MF127',
        	'jenisKertas' => 'MF',
        	'gramKertas' => '127',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'ML110',
        	'nama' => 'ML110',
        	'jenisKertas' => 'ML',
        	'gramKertas' => '110',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'MF150',
        	'nama' => 'MF150',
        	'jenisKertas' => 'MF',
        	'gramKertas' => '150',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'TL150',
        	'nama' => 'TL150',
        	'jenisKertas' => 'TL',
        	'gramKertas' => '150',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'TL200',
        	'nama' => 'TL200',
        	'jenisKertas' => 'TL',
        	'gramKertas' => '200',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'BK100',
        	'nama' => 'BK100',
        	'jenisKertas' => 'BK',
        	'gramKertas' => '100',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'MF140',
        	'nama' => 'MF140',
        	'jenisKertas' => 'MF',
        	'gramKertas' => '140',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'ML100',
        	'nama' => 'ML100',
        	'jenisKertas' => 'ML',
        	'gramKertas' => '100',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'BK140',
        	'nama' => 'BK140',
        	'jenisKertas' => 'BK',
        	'gramKertas' => '140',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'MF110',
        	'nama' => 'MF110',
        	'jenisKertas' => 'MF',
        	'gramKertas' => '110',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'BK150',
        	'nama' => 'BK150',
        	'jenisKertas' => 'BK',
        	'gramKertas' => '150',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'ML140',
        	'nama' => 'ML140',
        	'jenisKertas' => 'ML',
        	'gramKertas' => '140',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'MF145',
        	'nama' => 'MF145',
        	'jenisKertas' => 'MF',
        	'gramKertas' => '145',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'TL140',
        	'nama' => 'TL140',
        	'jenisKertas' => 'TL',
        	'gramKertas' => '140',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'BK135',
        	'nama' => 'BK135',
        	'jenisKertas' => 'BK',
        	'gramKertas' => '135',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'BK160',
        	'nama' => 'BK160',
        	'jenisKertas' => 'BK',
        	'gramKertas' => '160',
        	'createdBy' => 'SEEDER'
        ]);
    }
}

ML130
ML135
BK200
TL145
ML160
WK140
WK200
WK150
MF135
MF122
TL190
TL185
WTL180
TL170
TL180
TL175
MF200
TL275
MF105
MF180
TL160
TL115
TLA150
TL230
ML145
MF190
BK145
MF160
TL135