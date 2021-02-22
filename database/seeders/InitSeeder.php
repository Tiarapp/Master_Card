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
        DB::table('divisi')->delete();
        
		DB::table('divisi')->insert(['kode' => 'ACC','nama' => 'ACCOUNTING','createdBy' => 'SEEDER']);
        DB::table('divisi')->insert(['kode' => 'IT','nama' => 'INFORMATION TECHNOLOGY','createdBy' => 'SEEDER']);
        DB::table('divisi')->insert(['kode' => 'MARK','nama' => 'MARKETING','createdBy' => 'SEEDER']);
        DB::table('divisi')->insert(['kode' => 'PURCH','nama' => 'PURCHASING','createdBy' => 'SEEDER']);
        DB::table('divisi')->insert(['kode' => 'PPIC','nama' => 'PRODUCTION PLANNING AND INVENTORY CONTROL','createdBy' => 'SEEDER']);
        DB::table('divisi')->insert(['kode' => 'LOG','nama' => 'LOGISTIK','createdBy' => 'SEEDER']);
        DB::table('divisi')->insert(['kode' => 'PROD','nama' => 'PRODUKSI','createdBy' => 'SEEDER']);
        DB::table('divisi')->insert(['kode' => 'MTC','nama' => 'MAINTENANCE','createdBy' => 'SEEDER']);
        DB::table('divisi')->insert(['kode' => 'HRD','nama' => 'HUMAN RESOURCE DEVELOPMENT & GENERAL AFFAIR','createdBy' => 'SEEDER']);
        DB::table('divisi')->insert(['kode' => 'EXP','nama' => 'EKSPEDISI','createdBy' => 'SEEDER']);
        DB::table('divisi')->insert(['kode' => 'DSN','nama' => 'DESAIN','createdBy' => 'SEEDER']);
		
		//MATA UANG
        DB::table('mata_uang')->delete();
        DB::table('mata_uang')->insert(['kode' => 'IDR','nama' => 'RUPIAH','createdBy' => 'SEEDER'	]);
		DB::table('mata_uang')->insert(['kode' => 'USD','nama' => 'US DOLLAR','createdBy' => 'SEEDER']);
        DB::table('mata_uang')->insert(['kode' => 'EUR','nama' => 'EURO DOLLAR','createdBy' => 'SEEDER']);

		//TIPE BOX
		DB::table('tipe_box')->delete();
        DB::table('tipe_box')->insert(['kode' => 'B1','nama' => 'BOX B1','createdBy' => 'SEEDER']);
        DB::table('tipe_box')->insert(['kode' => 'DC','nama' => 'DIE CUT','createdBy' => 'SEEDER']);

		//TOP
		DB::table('top')->delete();
        DB::table('top')->insert(['nama' => 'CASH','hari' => '0','createdBy' => 'SEEDER']);
        DB::table('top')->insert(['nama' => '30 HARI','hari' => '30','createdBy' => 'SEEDER']);
        DB::table('top')->insert(['nama' => '60 HARI','hari' => '60','createdBy' => 'SEEDER']);

		//SATUAN
		DB::table('satuan')->delete();
		DB::table('satuan')->insert(['kode' => 'KG','nama' => 'KILOGRAM','createdBy' => 'SEEDER']);
        DB::table('satuan')->insert(['kode' => 'GR','nama' => 'GRAM','createdBy' => 'SEEDER']);
        DB::table('satuan')->insert(['kode' => 'PCS','nama' => 'PIECES','createdBy' => 'SEEDER']);
        DB::table('satuan')->insert(['kode' => 'L','nama' => 'LITER','createdBy' => 'SEEDER']);
        DB::table('satuan')->insert(['kode' => 'RIM','nama' => 'RIM','createdBy' => 'SEEDER']);
        DB::table('satuan')->insert(['kode' => 'M','nama' => 'METER','createdBy' => 'SEEDER']);
        DB::table('satuan')->insert(['kode' => 'MM','nama' => 'MILIMETER','createdBy' => 'SEEDER']);
        DB::table('satuan')->insert(['kode' => 'CM','nama' => 'CENTIMETER','createdBy' => 'SEEDER']);
        DB::table('satuan')->insert(['kode' => 'TON','nama' => 'TON','createdBy' => 'SEEDER']);
        DB::table('satuan')->insert(['kode' => 'M2','nama' => 'METER PERSEGI','createdBy' => 'SEEDER']);
        DB::table('satuan')->insert(['kode' => 'M3','nama' => 'METER KUBIK','createdBy' => 'SEEDER']);

		//FLUTE
        DB::table('flute')->delete();
        DB::table('flute')->insert(['kode' => 'BF','nama' => 'B FLUTE','tur1' => 1.36,'tur2' => 0,'createdBy' => 'SEEDER']);
        DB::table('flute')->insert(['kode' => 'CF','nama' => 'C FLUTE','tur1' => 1.46,'tur2' => 0,'createdBy' => 'SEEDER']);
        DB::table('flute')->insert(['kode' => 'BCF','nama' => 'BC FLUTE','tur1' => 1.36,'tur2' => 1.46,'createdBy' => 'SEEDER']);
    }
}