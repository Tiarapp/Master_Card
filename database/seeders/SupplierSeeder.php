<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['kode' => 'SPS', 'nama' => 'STAR PAPER SUPPLY'],
            ['kode' => 'MIT', 'nama' => 'MEKABOX INTERNATIONAL'],
            ['kode' => 'SMB', 'nama' => 'SURABAYA MEKABOX'],
            ['kode' => 'IKT', 'nama' => 'INDAH KIAT'],
            ['kode' => 'SIK', 'nama' => 'SINAR INDAH KERTAS'],
            ['kode' => 'CMI', 'nama' => 'CAKRAWALA MEGA INDAH'],
            ['kode' => 'ADP', 'nama' => 'ADIPRIMA SURAPRINTA'],
            ['kode' => 'ECP', 'nama' => 'ECO PAPER'],
            ['kode' => 'DAP', 'nama' => 'DAYASA ARI PRIMA'],
            ['kode' => 'SPM', 'nama' => 'SUPREME PAPER SOLUTION'],
            ['kode' => 'PKI', 'nama' => 'PABRIK KERTAS INDONESIA'],
            ['kode' => 'ASP', 'nama' => 'ASPEX KUMBONG'],
            ['kode' => 'EGL', 'nama' => 'ENGGAL SUBUR KERTAS'],
            ['kode' => 'LOY', 'nama' => 'LOHDJINAWI WIDJAYA'],
            ['kode' => 'PPI', 'nama' => 'PRIMA PAPER INDONESIA'],
        ];

        // Make sure the table 'suppliers' exists and columns 'kode' and 'nama' are correct
        DB::table('suppliers')->insert($data);
    }
}
