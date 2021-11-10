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
        
		DB::table('divisi')->insert(['id' => 1,'kode' => 'ACC','nama' => 'ACCOUNTING','createdBy' => 'SEEDER']);
        DB::table('divisi')->insert(['id' => 2, 'kode' => 'IT','nama' => 'INFORMATION TECHNOLOGY','createdBy' => 'SEEDER']);
        DB::table('divisi')->insert(['id' => 3, 'kode' => 'MARK','nama' => 'MARKETING','createdBy' => 'SEEDER']);
        DB::table('divisi')->insert(['id' => 4, 'kode' => 'PURCH','nama' => 'PURCHASING','createdBy' => 'SEEDER']);
        DB::table('divisi')->insert(['id' => 5, 'kode' => 'PPIC','nama' => 'PRODUCTION PLANNING AND INVENTORY CONTROL','createdBy' => 'SEEDER']);
        DB::table('divisi')->insert(['id' => 6, 'kode' => 'LOG','nama' => 'LOGISTIK','createdBy' => 'SEEDER']);
        DB::table('divisi')->insert(['id' => 7, 'kode' => 'PROD','nama' => 'PRODUKSI','createdBy' => 'SEEDER']);
        DB::table('divisi')->insert(['id' => 8, 'kode' => 'MTC','nama' => 'MAINTENANCE','createdBy' => 'SEEDER']);
        DB::table('divisi')->insert(['id' => 9, 'kode' => 'HRD','nama' => 'HUMAN RESOURCE DEVELOPMENT & GENERAL AFFAIR','createdBy' => 'SEEDER']);
        DB::table('divisi')->insert(['id' => 10, 'kode' => 'EXP','nama' => 'EKSPEDISI','createdBy' => 'SEEDER']);
        DB::table('divisi')->insert(['id' => 11, 'kode' => 'DSN','nama' => 'DESAIN','createdBy' => 'SEEDER']);
		
		// //MATA UANG
        // DB::table('mata_uang')->delete();
        // DB::table('mata_uang')->insert(['kode' => 'IDR','nama' => 'RUPIAH','createdBy' => 'SEEDER'	]);
		// DB::table('mata_uang')->insert(['kode' => 'USD','nama' => 'US DOLLAR','createdBy' => 'SEEDER']);
        // DB::table('mata_uang')->insert(['kode' => 'EUR','nama' => 'EURO DOLLAR','createdBy' => 'SEEDER']);

		//TIPE BOX
		DB::table('tipe_box')->delete();
        DB::table('tipe_box')->insert(['id' => 1,'kode' => 'B1','nama' => 'BOX B1','createdBy' => 'SEEDER']);
        DB::table('tipe_box')->insert(['id' => 2,'kode' => 'DC','nama' => 'DIE CUT','createdBy' => 'SEEDER']);

		// TOP
		DB::table('top')->delete();
        DB::table('top')->insert(['id'=>'1','nama'=>'10 Hari','hari'=>'10','createdBy'=>'SEEDER']);
        DB::table('top')->insert(['id'=>'2','nama'=>'14 Hari','hari'=>'14','createdBy'=>'SEEDER']);
        DB::table('top')->insert(['id'=>'3','nama'=>'30 Hari','hari'=>'30','createdBy'=>'SEEDER']);
        DB::table('top')->insert(['id'=>'4','nama'=>'45 Hari','hari'=>'45','createdBy'=>'SEEDER']);
        DB::table('top')->insert(['id'=>'5','nama'=>'60 Hari','hari'=>'60','createdBy'=>'SEEDER']);
        DB::table('top')->insert(['id'=>'6','nama'=>'75 Hari','hari'=>'75','createdBy'=>'SEEDER']);
        DB::table('top')->insert(['id'=>'7','nama'=>'90 Hari','hari'=>'90','createdBy'=>'SEEDER']);
        DB::table('top')->insert(['id'=>'8','nama'=>'0 Hari','hari'=>'0','createdBy'=>'SEEDER']);
        DB::table('top')->insert(['id'=>'9','nama'=>'5 Hari','hari'=>'5','createdBy'=>'SEEDER']);
        DB::table('top')->insert(['id'=>'10','nama'=>'7 Hari','hari'=>'7','createdBy'=>'SEEDER']);

		// //SATUAN
		DB::table('satuan')->delete();
		DB::table('satuan')->insert(['id' => 1,'kode' => 'KG','nama' => 'KILOGRAM','createdBy' => 'SEEDER']);
        DB::table('satuan')->insert(['id' => 2,'kode' => 'GR','nama' => 'GRAM','createdBy' => 'SEEDER']);
        DB::table('satuan')->insert(['id' => 3,'kode' => 'PCS','nama' => 'PIECES','createdBy' => 'SEEDER']);
        DB::table('satuan')->insert(['id' => 4,'kode' => 'L','nama' => 'LITER','createdBy' => 'SEEDER']);
        DB::table('satuan')->insert(['id' => 5,'kode' => 'RIM','nama' => 'RIM','createdBy' => 'SEEDER']);
        DB::table('satuan')->insert(['id' => 6,'kode' => 'M','nama' => 'METER','createdBy' => 'SEEDER']);
        DB::table('satuan')->insert(['id' => 7,'kode' => 'MM','nama' => 'MILIMETER','createdBy' => 'SEEDER']);
        DB::table('satuan')->insert(['id' => 8,'kode' => 'CM','nama' => 'CENTIMETER','createdBy' => 'SEEDER']);
        DB::table('satuan')->insert(['id' => 9,'kode' => 'TON','nama' => 'TON','createdBy' => 'SEEDER']);
        DB::table('satuan')->insert(['id' => 10,'kode' => 'M2','nama' => 'METER PERSEGI','createdBy' => 'SEEDER']);
        DB::table('satuan')->insert(['id' => 11,'kode' => 'M3','nama' => 'METER KUBIK','createdBy' => 'SEEDER']);

		//FLUTE
        DB::table('flute')->delete();
        DB::table('flute')->insert(['id' => 1,'kode' => 'BF','nama' => 'B FLUTE','tur1' => 1.36,'tur2' => 0,'createdBy' => 'SEEDER']);
        DB::table('flute')->insert(['id' => 2,'kode' => 'CF','nama' => 'C FLUTE','tur1' => 1.46,'tur2' => 0,'createdBy' => 'SEEDER']);
        DB::table('flute')->insert(['id' => 3,'kode' => 'BCF','nama' => 'BC FLUTE','tur1' => 1.36,'tur2' => 1.46,'createdBy' => 'SEEDER']);
        DB::table('flute')->insert(['id' => 4,'kode' => 'EF','nama' => 'E FLUTE','tur1' => 0,'tur2' => 0,'createdBy' => 'SEEDER']);

        //MESIN
        // DB::table('mesin')->delete();
        // DB::table('mesin')->insert(['kode' => 'CORR 1','nama' => 'CORR 1','ip' => '192.168.0.10','kapasitasPlan' => 0,'kapasitasProduksi' => 0,'satuanKapasitas' => 9,'keterangan' => '','hint' => '','createdBy' => 'SEEDER']);
        // DB::table('mesin')->insert(['kode' => 'FLEXO A','nama' => 'FLEXO A','ip' => '192.168.0.5','kapasitasPlan' => 0,'kapasitasProduksi' => 0,'satuanKapasitas' => 9,'keterangan' => '','hint' => '','createdBy' => 'SEEDER']);
        // DB::table('mesin')->insert(['kode' => 'FLEXO B','nama' => 'FLEXO B','ip' => '192.168.0.6','kapasitasPlan' => 0,'kapasitasProduksi' => 0,'satuanKapasitas' => 9,'keterangan' => '','hint' => '','createdBy' => 'SEEDER']);
        // DB::table('mesin')->insert(['kode' => 'FLEXO C','nama' => 'FLEXO C','ip' => '192.168.0.7','kapasitasPlan' => 0,'kapasitasProduksi' => 0,'satuanKapasitas' => 9,'keterangan' => '','hint' => '','createdBy' => 'SEEDER']);
        // DB::table('mesin')->insert(['kode' => 'GLUE TOKAI','nama' => 'GLUE TOKAI','ip' => '','kapasitasPlan' => 0,'kapasitasProduksi' => 0,'satuanKapasitas' => 9,'keterangan' => '','hint' => '','createdBy' => 'SEEDER']);
        // DB::table('mesin')->insert(['kode' => 'SLITTER','nama' => 'SLITTER','ip' => '','kapasitasPlan' => 0,'kapasitasProduksi' => 0,'satuanKapasitas' => 9,'keterangan' => '','hint' => '','createdBy' => 'SEEDER']);
        // DB::table('mesin')->insert(['kode' => 'STITCHING 1','nama' => 'STITCHING 1','ip' => '','kapasitasPlan' => 0,'kapasitasProduksi' => 0,'satuanKapasitas' => 9,'keterangan' => '','hint' => '','createdBy' => 'SEEDER']);
        // DB::table('mesin')->insert(['kode' => 'STITCHING 2','nama' => 'STITCHING 2','ip' => '','kapasitasPlan' => 0,'kapasitasProduksi' => 0,'satuanKapasitas' => 9,'keterangan' => '','hint' => '','createdBy' => 'SEEDER']);
        // DB::table('mesin')->insert(['kode' => 'STITCHING 3','nama' => 'STITCHING 3','ip' => '','kapasitasPlan' => 0,'kapasitasProduksi' => 0,'satuanKapasitas' => 9,'keterangan' => '','hint' => '','createdBy' => 'SEEDER']);

        //NUMBER SEQUENCE
        DB::table('number_sequence')->delete();
        DB::table('number_sequence')->insert(['noBukti' => 'sj_palet.store', 'divisi_id' => 10, 'format' => 'P.~YY~~MM~.~999~', 'reset' => 'Month', 'createdBy' => 'Seeder']);
        DB::table('number_sequence')->insert(['noBukti' => 'kontrak.store', 'divisi_id' => 3, 'format' => 'SPA/~999~/~MM~/~YYYY~', 'reset' => 'Month', 'createdBy' => 'Seeder']);
        DB::table('number_sequence')->insert(['noBukti' => 'box.store', 'divisi_id' => 3, 'format' => 'Box.~MM~~YY~.~999~', 'reset' => 'Month', 'createdBy' => 'Seeder']);
        DB::table('number_sequence')->insert(['noBukti' => 'mastercard.store', 'divisi_id' => 3, 'format' => 'MC~9999~', 'reset' => 'Month', 'createdBy' => 'Seeder']);

        //JENIS DOWNTIME
        //CORR
        // DB::table('mesin')->insert(['mesin_id' => '1','downtime' => 'PUTUS','pic' => 'CORR','allowedMinute' => 0,'createdBy' => 'SEEDER','branch' => 'LAMONGAN']);
        // DB::table('mesin')->insert(['mesin_id' => '1','downtime' => 'GAGAL SAMBUNG','pic' => 'CORR','allowedMinute' => 0,'createdBy' => 'SEEDER','branch' => 'LAMONGAN']);
        // DB::table('mesin')->insert(['mesin_id' => '1','downtime' => 'SETTING OUT 5','pic' => 'CORR','allowedMinute' => 0,'createdBy' => 'SEEDER','branch' => 'LAMONGAN']);
        // DB::table('mesin')->insert(['mesin_id' => '1','downtime' => 'CLEANING HOT PLATE','pic' => 'CORR','allowedMinute' => 0,'createdBy' => 'SEEDER','branch' => 'LAMONGAN']);
        // DB::table('mesin')->insert(['mesin_id' => '1','downtime' => 'MESIN RUSAK','pic' => 'MEKANIK','allowedMinute' => 0,'createdBy' => 'SEEDER','branch' => 'LAMONGAN']);
        // DB::table('mesin')->insert(['mesin_id' => '1','downtime' => 'MESIN RUSAK','pic' => 'ELEKTRIK','allowedMinute' => 0,'createdBy' => 'SEEDER','branch' => 'LAMONGAN']);
        // //PRINTING
        // DB::table('mesin')->insert(['mesin_id' => '2','downtime' => 'SETTING','pic' => 'PRINTING','allowedMinute' => 0,'createdBy' => 'SEEDER','branch' => 'LAMONGAN']);
        // DB::table('mesin')->insert(['mesin_id' => '2','downtime' => 'CUCI KARET','pic' => 'PRINTING','allowedMinute' => 0,'createdBy' => 'SEEDER','branch' => 'LAMONGAN']);
        // DB::table('mesin')->insert(['mesin_id' => '2','downtime' => 'ADJUST WARNA','pic' => 'PRINTING','allowedMinute' => 0,'createdBy' => 'SEEDER','branch' => 'LAMONGAN']);
        // DB::table('mesin')->insert(['mesin_id' => '2','downtime' => 'BACKING KARET','pic' => 'PRINTING','allowedMinute' => 0,'createdBy' => 'SEEDER','branch' => 'LAMONGAN']);
        // DB::table('mesin')->insert(['mesin_id' => '2','downtime' => 'MESIN RUSAK','pic' => 'MEKANIK','allowedMinute' => 0,'createdBy' => 'SEEDER','branch' => 'LAMONGAN']);
        // DB::table('mesin')->insert(['mesin_id' => '2','downtime' => 'MESIN RUSAK','pic' => 'ELEKTRIK','allowedMinute' => 0,'createdBy' => 'SEEDER','branch' => 'LAMONGAN']);
        // DB::table('mesin')->insert(['mesin_id' => '3','downtime' => 'SETTING','pic' => 'PRINTING','allowedMinute' => 0,'createdBy' => 'SEEDER','branch' => 'LAMONGAN']);
        // DB::table('mesin')->insert(['mesin_id' => '3','downtime' => 'CUCI KARET','pic' => 'PRINTING','allowedMinute' => 0,'createdBy' => 'SEEDER','branch' => 'LAMONGAN']);
        // DB::table('mesin')->insert(['mesin_id' => '3','downtime' => 'ADJUST WARNA','pic' => 'PRINTING','allowedMinute' => 0,'createdBy' => 'SEEDER','branch' => 'LAMONGAN']);
        // DB::table('mesin')->insert(['mesin_id' => '3','downtime' => 'BACKING KARET','pic' => 'PRINTING','allowedMinute' => 0,'createdBy' => 'SEEDER','branch' => 'LAMONGAN']);
        // DB::table('mesin')->insert(['mesin_id' => '3','downtime' => 'MESIN RUSAK','pic' => 'MEKANIK','allowedMinute' => 0,'createdBy' => 'SEEDER','branch' => 'LAMONGAN']);
        // DB::table('mesin')->insert(['mesin_id' => '3','downtime' => 'MESIN RUSAK','pic' => 'ELEKTRIK','allowedMinute' => 0,'createdBy' => 'SEEDER','branch' => 'LAMONGAN']);
        // DB::table('mesin')->insert(['mesin_id' => '4','downtime' => 'SETTING','pic' => 'PRINTING','allowedMinute' => 0,'createdBy' => 'SEEDER','branch' => 'LAMONGAN']);
        // DB::table('mesin')->insert(['mesin_id' => '4','downtime' => 'CUCI KARET','pic' => 'PRINTING','allowedMinute' => 0,'createdBy' => 'SEEDER','branch' => 'LAMONGAN']);
        // DB::table('mesin')->insert(['mesin_id' => '4','downtime' => 'ADJUST WARNA','pic' => 'PRINTING','allowedMinute' => 0,'createdBy' => 'SEEDER','branch' => 'LAMONGAN']);
        // DB::table('mesin')->insert(['mesin_id' => '4','downtime' => 'BACKING KARET','pic' => 'PRINTING','allowedMinute' => 0,'createdBy' => 'SEEDER','branch' => 'LAMONGAN']);
        // DB::table('mesin')->insert(['mesin_id' => '4','downtime' => 'MESIN RUSAK','pic' => 'MEKANIK','allowedMinute' => 0,'createdBy' => 'SEEDER','branch' => 'LAMONGAN']);
        // DB::table('mesin')->insert(['mesin_id' => '4','downtime' => 'MESIN RUSAK','pic' => 'ELEKTRIK','allowedMinute' => 0,'createdBy' => 'SEEDER','branch' => 'LAMONGAN']);
        // //FINISHING
        // DB::table('mesin')->insert(['mesin_id' => '5','downtime' => 'SETTING','pic' => 'FINISHING','allowedMinute' => 0,'createdBy' => 'SEEDER','branch' => 'LAMONGAN']);

    }
}