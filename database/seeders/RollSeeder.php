<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $supplier = [
            ['code' => 'SPS', 'name' => 'STAR PAPER SUPPLY'],
            ['code' => 'MIT', 'name' => 'MEKABOX INTERNATIONAL'],
            ['code' => 'SMB', 'name' => 'SURABAYA MEKABOX'],
            ['code' => 'PBT', 'name' => 'PURA BARUTAMA'],
            ['code' => 'IKT', 'name' => 'INDAH KIAT'],
            ['code' => 'SIK', 'name' => 'SINAR INDAH KERTAS'],
            ['code' => 'CMI', 'name' => 'CAKRAWALA MEGA INDAH'],
            ['code' => 'ADP', 'name' => 'ADIPRIMA SURAPRINTA'],
            ['code' => 'ECP', 'name' => 'ECO PAPER'],
            ['code' => 'FJP', 'name' => 'FAJAR PAPER'],
            ['code' => 'DAP', 'name' => 'DAYASA ARIA PRIMA'],
            ['code' => 'SPM', 'name' => 'SUPREME PAPER SOLUTION'],
            ['code' => 'PKI', 'name' => 'PABRIK KERTAS INDONESIA'],
            ['code' => 'ASP', 'name' => 'ASPEX KUMBONG'],
            ['code' => 'EGL', 'name' => 'ENGGAL SUBUR KERTAS'],
            ['code' => 'LOY', 'name' => 'LOHDJINAWI WIDJAYA'],
            ['code' => 'TJK', 'name' => 'TJIWI KIMIA'],
            ['code' => 'PND', 'name' => 'PINDODELI'],
            ['code' => 'PPI', 'name' => 'PRIMA PAPER INDONESIA'],
            ['code' => 'PNP', 'name' => 'PURA NUSA PERSADA'],
        ];

        DB::table('supplier_rolls')->insert($supplier);

        $status = [
            ['name' => 'Waiting', 'warna' => 'light-warning'],
            ['name' => 'Ready', 'warna' => 'light-success'],
            ['name' => 'Out of Stock', 'warna' => 'light-danger'],
        ];

        DB::table('status_rolls')->insert($status);
    }
}
