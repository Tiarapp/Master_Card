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
        	'kode' => 'K125',
        	'nama' => 'K125',
        	'jenisKertas' => 'K',
        	'gramKertas' => '125',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'M125',
        	'nama' => 'M125',
        	'jenisKertas' => 'M',
        	'gramKertas' => '125',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'K125',
        	'nama' => 'K125',
        	'jenisKertas' => 'K',
        	'gramKertas' => '125',
        	'createdBy' => 'SEEDER'
        ]);
    }
}

BK125
MF125
TL125
ML127
ML120
ML125
MF127
ML110
ML150
MF150
TL150
TL200
BK100
BK90
MF140
ML90
ML100
BK140
MF110
MF112
BK150
MF90
ML112
ML140
BK130
BK120
MF115
MF100
BK110
ML115
MF130
MF120
MF145
TL140
BK115
BK135
BK160
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