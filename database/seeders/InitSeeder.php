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
        DB::table('divisi')->insert([
        	'kode' => 'PURCH',
        	'nama' => 'PURCHASING',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('divisi')->insert([
        	'kode' => 'PPIC',
        	'nama' => 'PRODUCTION PLANNING AND INVENTORY CONTROL',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('divisi')->insert([
        	'kode' => 'LOG',
        	'nama' => 'LOGISTIK',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('divisi')->insert([
        	'kode' => 'PROD',
        	'nama' => 'PRODUKSI',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('divisi')->insert([
        	'kode' => 'MTC',
        	'nama' => 'MAINTENANCE',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('divisi')->insert([
        	'kode' => 'HRD',
        	'nama' => 'HUMAN RESOURCE DEVELOPMENT & GENERAL AFFAIR',
        	'createdBy' => 'SEEDER'
        ]);

        // jenis_gram
        DB::table('jenis_gram')->insert([
        	'kode' => 'MF100',
        	'nama' => 'MF100',
        	'jenisKertas' => 'MF',
        	'gramKertas' => '100',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'MF105',
        	'nama' => 'MF105',
        	'jenisKertas' => 'MF',
        	'gramKertas' => '105',
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
        	'kode' => 'MF112',
        	'nama' => 'MF112',
        	'jenisKertas' => 'MF',
        	'gramKertas' => '112',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'MF115',
        	'nama' => 'MF115',
        	'jenisKertas' => 'MF',
        	'gramKertas' => '115',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'MF120',
        	'nama' => 'MF120',
        	'jenisKertas' => 'MF',
        	'gramKertas' => '120',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'MF122',
        	'nama' => 'MF122',
        	'jenisKertas' => 'MF',
        	'gramKertas' => '122',
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
        	'kode' => 'MF130',
        	'nama' => 'MF130',
        	'jenisKertas' => 'MF',
        	'gramKertas' => '130',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'MF135',
        	'nama' => 'MF135',
        	'jenisKertas' => 'MF',
        	'gramKertas' => '135',
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
        	'kode' => 'MF145',
        	'nama' => 'MF145',
        	'jenisKertas' => 'MF',
        	'gramKertas' => '145',
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
        	'kode' => 'MF160',
        	'nama' => 'MF160',
        	'jenisKertas' => 'MF',
        	'gramKertas' => '160',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'MF180',
        	'nama' => 'MF180',
        	'jenisKertas' => 'MF',
        	'gramKertas' => '180',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'MF190',
        	'nama' => 'MF190',
        	'jenisKertas' => 'MF',
        	'gramKertas' => '190',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'MF200',
        	'nama' => 'MF200',
        	'jenisKertas' => 'MF',
        	'gramKertas' => '200',
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
        	'kode' => 'ML110',
        	'nama' => 'ML110',
        	'jenisKertas' => 'ML',
        	'gramKertas' => '110',
        	'createdBy' => 'SEEDER'
		]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'ML112',
        	'nama' => 'ML112',
        	'jenisKertas' => 'ML',
        	'gramKertas' => '112',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'ML115',
        	'nama' => 'ML115',
        	'jenisKertas' => 'ML',
        	'gramKertas' => '115',
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
        	'kode' => 'ML127',
        	'nama' => 'ML127',
        	'jenisKertas' => 'ML',
        	'gramKertas' => '127',
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
        	'kode' => 'ML145',
        	'nama' => 'ML145',
        	'jenisKertas' => 'ML',
        	'gramKertas' => '145',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'ML150',
        	'nama' => 'ML150',
        	'jenisKertas' => 'ML',
        	'gramKertas' => '150',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'TL100',
        	'nama' => 'TL100',
        	'jenisKertas' => 'TL',
        	'gramKertas' => '100',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'TL110',
        	'nama' => 'TL110',
        	'jenisKertas' => 'TL',
        	'gramKertas' => '110',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'TL115',
        	'nama' => 'TL115',
        	'jenisKertas' => 'TL',
        	'gramKertas' => '115',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'TL120',
        	'nama' => 'TL120',
        	'jenisKertas' => 'TL',
        	'gramKertas' => '120',
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
        	'kode' => 'TL135',
        	'nama' => 'TL135',
        	'jenisKertas' => 'TL',
        	'gramKertas' => '135',
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
        	'kode' => 'TL145',
        	'nama' => 'TL145',
        	'jenisKertas' => 'TL',
        	'gramKertas' => '145',
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
        	'kode' => 'TL160',
        	'nama' => 'TL160',
        	'jenisKertas' => 'TL',
        	'gramKertas' => '160',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'TL170',
        	'nama' => 'TL170',
        	'jenisKertas' => 'TL',
        	'gramKertas' => '170',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'TL175',
        	'nama' => 'TL175',
        	'jenisKertas' => 'TL',
        	'gramKertas' => '175',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'TL190',
        	'nama' => 'TL190',
        	'jenisKertas' => 'TL',
        	'gramKertas' => '190',
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
        	'kode' => 'TL230',
        	'nama' => 'TL230',
        	'jenisKertas' => 'TL',
        	'gramKertas' => '230',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'TL275',
        	'nama' => 'TL275',
        	'jenisKertas' => 'TL',
        	'gramKertas' => '275',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'WK140',
        	'nama' => 'WK140',
        	'jenisKertas' => 'WK',
        	'gramKertas' => '140',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'WK150',
        	'nama' => 'WK150',
        	'jenisKertas' => 'WK',
        	'gramKertas' => '150',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('jenis_gram')->insert([
        	'kode' => 'WK200',
        	'nama' => 'WK200',
        	'jenisKertas' => 'WK',
        	'gramKertas' => '200',
        	'createdBy' => 'SEEDER'
        ]);
        DB::table('mata_uang')->insert([
        	'kode' => 'IDR',
        	'nama' => 'Rupiah'
        ]);
        DB::table('mata_uang')->insert([
        	'kode' => 'USD',
        	'nama' => 'US Dollar'
        ]);
        DB::table('mata_uang')->insert([
        	'kode' => 'EUR',
        	'nama' => 'Euro Dollar'
        ]);
        DB::table('tipe_box')->insert([
        	'kode' => 'B1',
			'nama' => 'BOX B1',
			'createdBy' => 'SEEDER'
        ]);
        DB::table('tipe_box')->insert([
        	'kode' => 'DC',
        	'nama' => 'Die Cut',
        	'createdBy' => 'SEEDER'
		]);
        DB::table('top')->insert([
			'nama' => '30 Hari',
			'hari' => '30',
        	'createdBy' => 'SEEDER'
		]);
        DB::table('top')->insert([
			'nama' => 'Cash',
			'hari' => '0',
        	'createdBy' => 'SEEDER'
		]);
        DB::table('top')->insert([
			'nama' => '30 Hari',
			'hari' => '30',
        	'createdBy' => 'SEEDER'
		]);
        DB::table('top')->insert([
			'nama' => '60 Hari',
			'hari' => '60',
        	'createdBy' => 'SEEDER'
		]);
        DB::table('satuan')->insert([
			'kode' => 'KG',
			'nama' => 'KILOGRAM',
        	'createdBy' => 'SEEDER'
		]);
        DB::table('satuan')->insert([
			'kode' => 'GR',
			'nama' => 'GRAM',
        	'createdBy' => 'SEEDER'
		]);
        DB::table('satuan')->insert([
			'kode' => 'PCS',
			'nama' => 'PIECES',
        	'createdBy' => 'SEEDER'
		]);
        DB::table('satuan')->insert([
			'kode' => 'L',
			'nama' => 'LITER',
        	'createdBy' => 'SEEDER'
		]);
        DB::table('satuan')->insert([
			'kode' => 'RIM',
			'nama' => 'RIM',
        	'createdBy' => 'SEEDER'
		]);
        DB::table('satuan')->insert([
			'kode' => 'M',
			'nama' => 'METER',
        	'createdBy' => 'SEEDER'
		]);
        DB::table('satuan')->insert([
			'kode' => 'MM',
			'nama' => 'MILIMETER',
        	'createdBy' => 'SEEDER'
		]);
        DB::table('satuan')->insert([
			'kode' => 'CM',
			'nama' => 'CENTIMETER',
        	'createdBy' => 'SEEDER'
		]);
        DB::table('mesin')->insert([
			'kode' => 'CM',
			'nama' => 'CENTIMETER',
			'ip' => 'CENTIMETER',
			'kapasitas' => 'CENTIMETER',
			'satuanKapasitas' => 'CENTIMETER',
			'keterangan' => 'CENTIMETER',
			'hint' => 'CENTIMETER',
        	'createdBy' => 'SEEDER'
		]);
    }
}