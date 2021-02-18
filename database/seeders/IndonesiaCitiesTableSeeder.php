<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IndonesiaCitiesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('indonesia_cities')->delete();
        
        DB::table('indonesia_cities')->insert(array (
            0 => 
            array (
                'id' => '1101',
                'province_id' => '11',
                'name' => 'KABUPATEN SIMEULUE',
                'meta' => '{"lat":"2.6439724","long":"96.0255738"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            1 => 
            array (
                'id' => '1102',
                'province_id' => '11',
                'name' => 'KABUPATEN ACEH SINGKIL',
                'meta' => '{"lat":"2.3589459","long":"97.87216"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            2 => 
            array (
                'id' => '1103',
                'province_id' => '11',
                'name' => 'KABUPATEN ACEH SELATAN',
                'meta' => '{"lat":"3.3115056","long":"97.3516558"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            3 => 
            array (
                'id' => '1104',
                'province_id' => '11',
                'name' => 'KABUPATEN ACEH TENGGARA',
                'meta' => '{"lat":"3.3088666","long":"97.6982272"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            4 => 
            array (
                'id' => '1105',
                'province_id' => '11',
                'name' => 'KABUPATEN ACEH TIMUR',
                'meta' => '{"lat":"4.5224111","long":"97.6114217"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            5 => 
            array (
                'id' => '1106',
                'province_id' => '11',
                'name' => 'KABUPATEN ACEH TENGAH',
                'meta' => '{"lat":"4.4482641","long":"96.8350999"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            6 => 
            array (
                'id' => '1107',
                'province_id' => '11',
                'name' => 'KABUPATEN ACEH BARAT',
                'meta' => '{"lat":"4.4542745","long":"96.1526985"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            7 => 
            array (
                'id' => '1108',
                'province_id' => '11',
                'name' => 'KABUPATEN ACEH BESAR',
                'meta' => '{"lat":"5.4529168","long":"95.4777811"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            8 => 
            array (
                'id' => '1109',
                'province_id' => '11',
                'name' => 'KABUPATEN PIDIE',
                'meta' => '{"lat":"5.0742659","long":"95.940971"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            9 => 
            array (
                'id' => '1110',
                'province_id' => '11',
                'name' => 'KABUPATEN BIREUEN',
                'meta' => '{"lat":"5.1086446","long":"96.663812"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            10 => 
            array (
                'id' => '1111',
                'province_id' => '11',
                'name' => 'KABUPATEN ACEH UTARA',
                'meta' => '{"lat":"4.9786331","long":"97.2221421"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            11 => 
            array (
                'id' => '1112',
                'province_id' => '11',
                'name' => 'KABUPATEN ACEH BARAT DAYA',
                'meta' => '{"lat":"3.7963426","long":"97.0068393"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            12 => 
            array (
                'id' => '1113',
                'province_id' => '11',
                'name' => 'KABUPATEN GAYO LUES',
                'meta' => '{"lat":"3.955165","long":"97.3516558"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            13 => 
            array (
                'id' => '1114',
                'province_id' => '11',
                'name' => 'KABUPATEN ACEH TAMIANG',
                'meta' => '{"lat":"4.2328871","long":"98.0028892"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            14 => 
            array (
                'id' => '1115',
                'province_id' => '11',
                'name' => 'KABUPATEN NAGAN RAYA',
                'meta' => '{"lat":"4.1248406","long":"96.4929797"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            15 => 
            array (
                'id' => '1116',
                'province_id' => '11',
                'name' => 'KABUPATEN ACEH JAYA',
                'meta' => '{"lat":"4.7873684","long":"95.6457951"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            16 => 
            array (
                'id' => '1117',
                'province_id' => '11',
                'name' => 'KABUPATEN BENER MERIAH',
                'meta' => '{"lat":"4.7513606","long":"96.9525224"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            17 => 
            array (
                'id' => '1118',
                'province_id' => '11',
                'name' => 'KABUPATEN PIDIE JAYA',
                'meta' => '{"lat":"5.1548063","long":"96.195132"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            18 => 
            array (
                'id' => '1171',
                'province_id' => '11',
                'name' => 'KOTA BANDA ACEH',
                'meta' => '{"lat":"5.5482904","long":"95.3237559"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            19 => 
            array (
                'id' => '1172',
                'province_id' => '11',
                'name' => 'KOTA SABANG',
                'meta' => '{"lat":"5.8926053","long":"95.3237608"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            20 => 
            array (
                'id' => '1173',
                'province_id' => '11',
                'name' => 'KOTA LANGSA',
                'meta' => '{"lat":"4.4725348","long":"97.9756343"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            21 => 
            array (
                'id' => '1174',
                'province_id' => '11',
                'name' => 'KOTA LHOKSEUMAWE',
                'meta' => '{"lat":"5.1811638","long":"97.1413222"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            22 => 
            array (
                'id' => '1175',
                'province_id' => '11',
                'name' => 'KOTA SUBULUSSALAM',
                'meta' => '{"lat":"2.7121164","long":"97.9157099"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            23 => 
            array (
                'id' => '1201',
                'province_id' => '12',
                'name' => 'KABUPATEN NIAS',
                'meta' => '{"lat":"1.0869444","long":"97.7416703"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            24 => 
            array (
                'id' => '1202',
                'province_id' => '12',
                'name' => 'KABUPATEN MANDAILING NATAL',
                'meta' => '{"lat":"0.7432372","long":"99.3673084"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            25 => 
            array (
                'id' => '1203',
                'province_id' => '12',
                'name' => 'KABUPATEN TAPANULI SELATAN',
                'meta' => '{"lat":"1.5774933","long":"99.2785583"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            26 => 
            array (
                'id' => '1204',
                'province_id' => '12',
                'name' => 'KABUPATEN TAPANULI TENGAH',
                'meta' => '{"lat":"1.8493299","long":"98.704075"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            27 => 
            array (
                'id' => '1205',
                'province_id' => '12',
                'name' => 'KABUPATEN TAPANULI UTARA',
                'meta' => '{"lat":"2.0405246","long":"99.1013498"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            28 => 
            array (
                'id' => '1206',
                'province_id' => '12',
                'name' => 'KABUPATEN TOBA SAMOSIR',
                'meta' => '{"lat":"2.3502398","long":"99.2785583"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            29 => 
            array (
                'id' => '1207',
                'province_id' => '12',
                'name' => 'KABUPATEN LABUHAN BATU',
                'meta' => '{"lat":"2.3439863","long":"100.1703257"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            30 => 
            array (
                'id' => '1208',
                'province_id' => '12',
                'name' => 'KABUPATEN ASAHAN',
                'meta' => '{"lat":"2.8174722","long":"99.634135"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            31 => 
            array (
                'id' => '1209',
                'province_id' => '12',
                'name' => 'KABUPATEN SIMALUNGUN',
                'meta' => '{"lat":"2.9781612","long":"99.2785583"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            32 => 
            array (
                'id' => '1210',
                'province_id' => '12',
                'name' => 'KABUPATEN DAIRI',
                'meta' => '{"lat":"2.8675801","long":"98.265058"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            33 => 
            array (
                'id' => '1211',
                'province_id' => '12',
                'name' => 'KABUPATEN KARO',
                'meta' => '{"lat":"3.1052909","long":"98.265058"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            34 => 
            array (
                'id' => '1212',
                'province_id' => '12',
                'name' => 'KABUPATEN DELI SERDANG',
                'meta' => '{"lat":"3.4201802","long":"98.704075"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            35 => 
            array (
                'id' => '1213',
                'province_id' => '12',
                'name' => 'KABUPATEN LANGKAT',
                'meta' => '{"lat":"3.8653916","long":"98.3088441"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            36 => 
            array (
                'id' => '1214',
                'province_id' => '12',
                'name' => 'KABUPATEN NIAS SELATAN',
                'meta' => '{"lat":"0.7086091","long":"97.8286368"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            37 => 
            array (
                'id' => '1215',
                'province_id' => '12',
                'name' => 'KABUPATEN HUMBANG HASUNDUTAN',
                'meta' => '{"lat":"2.1988508","long":"98.5721016"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            38 => 
            array (
                'id' => '1216',
                'province_id' => '12',
                'name' => 'KABUPATEN PAKPAK BHARAT',
                'meta' => '{"lat":"2.5135376","long":"98.2212979"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            39 => 
            array (
                'id' => '1217',
                'province_id' => '12',
                'name' => 'KABUPATEN SAMOSIR',
                'meta' => '{"lat":"2.6274431","long":"98.7921836"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            40 => 
            array (
                'id' => '1218',
                'province_id' => '12',
                'name' => 'KABUPATEN SERDANG BEDAGAI',
                'meta' => '{"lat":"3.3371694","long":"99.0571089"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            41 => 
            array (
                'id' => '1219',
                'province_id' => '12',
                'name' => 'KABUPATEN BATU BARA',
                'meta' => '{"lat":"3.1740979","long":"99.5006143"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            42 => 
            array (
                'id' => '1220',
                'province_id' => '12',
                'name' => 'KABUPATEN PADANG LAWAS UTARA',
                'meta' => '{"lat":"1.5758644","long":"99.634135"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            43 => 
            array (
                'id' => '1221',
                'province_id' => '12',
                'name' => 'KABUPATEN PADANG LAWAS',
                'meta' => '{"lat":"1.1186977","long":"99.8124935"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            44 => 
            array (
                'id' => '1222',
                'province_id' => '12',
                'name' => 'KABUPATEN LABUHAN BATU SELATAN',
                'meta' => '{"lat":"1.8799353","long":"100.1703257"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            45 => 
            array (
                'id' => '1223',
                'province_id' => '12',
                'name' => 'KABUPATEN LABUHAN BATU UTARA',
                'meta' => '{"lat":"2.3465638","long":"99.8124935"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            46 => 
            array (
                'id' => '1224',
                'province_id' => '12',
                'name' => 'KABUPATEN NIAS UTARA',
                'meta' => '{"lat":"1.3166036","long":"97.394882"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            47 => 
            array (
                'id' => '1225',
                'province_id' => '12',
                'name' => 'KABUPATEN NIAS BARAT',
                'meta' => '{"lat":"1.0116383","long":"97.4814163"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            48 => 
            array (
                'id' => '1271',
                'province_id' => '12',
                'name' => 'KOTA SIBOLGA',
                'meta' => '{"lat":"1.7368371","long":"98.7851121"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            49 => 
            array (
                'id' => '1272',
                'province_id' => '12',
                'name' => 'KOTA TANJUNG BALAI',
                'meta' => '{"lat":"2.9659488","long":"99.7983506"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            50 => 
            array (
                'id' => '1273',
                'province_id' => '12',
                'name' => 'KOTA PEMATANG SIANTAR',
                'meta' => '{"lat":"2.970042","long":"99.0681668"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            51 => 
            array (
                'id' => '1274',
                'province_id' => '12',
                'name' => 'KOTA TEBING TINGGI',
                'meta' => '{"lat":"3.3262879","long":"99.1566855"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            52 => 
            array (
                'id' => '1275',
                'province_id' => '12',
                'name' => 'KOTA MEDAN',
                'meta' => '{"lat":"3.5951956","long":"98.6722227"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            53 => 
            array (
                'id' => '1276',
                'province_id' => '12',
                'name' => 'KOTA BINJAI',
                'meta' => '{"lat":"3.6135482","long":"98.5025286"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            54 => 
            array (
                'id' => '1277',
                'province_id' => '12',
                'name' => 'KOTA PADANGSIDIMPUAN',
                'meta' => '{"lat":"1.4437644","long":"99.2563859"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            55 => 
            array (
                'id' => '1278',
                'province_id' => '12',
                'name' => 'KOTA GUNUNGSITOLI',
                'meta' => '{"lat":"1.2804692","long":"97.6146757"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            56 => 
            array (
                'id' => '1301',
                'province_id' => '13',
                'name' => 'KABUPATEN KEPULAUAN MENTAWAI',
                'meta' => '{"lat":"-1.426001","long":"98.9245343"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            57 => 
            array (
                'id' => '1302',
                'province_id' => '13',
                'name' => 'KABUPATEN PESISIR SELATAN',
                'meta' => '{"lat":"-1.7223147","long":"100.8903099"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            58 => 
            array (
                'id' => '1303',
                'province_id' => '13',
                'name' => 'KABUPATEN SOLOK',
                'meta' => '{"lat":"-0.9643838","long":"100.8903099"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            59 => 
            array (
                'id' => '1304',
                'province_id' => '13',
                'name' => 'KABUPATEN SIJUNJUNG',
                'meta' => '{"lat":"-0.6647007","long":"101.0711758"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            60 => 
            array (
                'id' => '1305',
                'province_id' => '13',
                'name' => 'KABUPATEN TANAH DATAR',
                'meta' => '{"lat":"-0.4797043","long":"100.5746224"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            61 => 
            array (
                'id' => '1306',
                'province_id' => '13',
                'name' => 'KABUPATEN PADANG PARIAMAN',
                'meta' => '{"lat":"-0.5546757","long":"100.2151578"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            62 => 
            array (
                'id' => '1307',
                'province_id' => '13',
                'name' => 'KABUPATEN AGAM',
                'meta' => '{"lat":"-0.2209392","long":"100.1703257"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            63 => 
            array (
                'id' => '1308',
                'province_id' => '13',
                'name' => 'KABUPATEN LIMA PULUH KOTA',
                'meta' => '{"lat":"0.0734192","long":"100.5296115"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            64 => 
            array (
                'id' => '1309',
                'province_id' => '13',
                'name' => 'KABUPATEN PASAMAN',
                'meta' => '{"lat":"0.2209392","long":"100.1703257"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            65 => 
            array (
                'id' => '1310',
                'province_id' => '13',
                'name' => 'KABUPATEN SOLOK SELATAN',
                'meta' => '{"lat":"-1.4157329","long":"101.2523792"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            66 => 
            array (
                'id' => '1311',
                'province_id' => '13',
                'name' => 'KABUPATEN DHARMASRAYA',
                'meta' => '{"lat":"-1.1120568","long":"101.6157773"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            67 => 
            array (
                'id' => '1312',
                'province_id' => '13',
                'name' => 'KABUPATEN PASAMAN BARAT',
                'meta' => '{"lat":"0.2213005","long":"99.634135"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            68 => 
            array (
                'id' => '1371',
                'province_id' => '13',
                'name' => 'KOTA PADANG',
                'meta' => '{"lat":"-0.9470832","long":"100.417181"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            69 => 
            array (
                'id' => '1372',
                'province_id' => '13',
                'name' => 'KOTA SOLOK',
                'meta' => '{"lat":"-0.7885335","long":"100.6549823"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            70 => 
            array (
                'id' => '1373',
                'province_id' => '13',
                'name' => 'KOTA SAWAH LUNTO',
                'meta' => '{"lat":"-0.6841069","long":"100.7323332"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            71 => 
            array (
                'id' => '1374',
                'province_id' => '13',
                'name' => 'KOTA PADANG PANJANG',
                'meta' => '{"lat":"-0.4660955","long":"100.3984148"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            72 => 
            array (
                'id' => '1375',
                'province_id' => '13',
                'name' => 'KOTA BUKITTINGGI',
                'meta' => '{"lat":"-0.3039178","long":"100.383479"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            73 => 
            array (
                'id' => '1376',
                'province_id' => '13',
                'name' => 'KOTA PAYAKUMBUH',
                'meta' => '{"lat":"-0.2246548","long":"100.6318006"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            74 => 
            array (
                'id' => '1377',
                'province_id' => '13',
                'name' => 'KOTA PARIAMAN',
                'meta' => '{"lat":"-0.6256517","long":"100.1233396"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            75 => 
            array (
                'id' => '1401',
                'province_id' => '14',
                'name' => 'KABUPATEN KUANTAN SINGINGI',
                'meta' => '{"lat":"-0.4411596","long":"101.5248055"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            76 => 
            array (
                'id' => '1402',
                'province_id' => '14',
                'name' => 'KABUPATEN INDRAGIRI HULU',
                'meta' => '{"lat":"-0.7361181","long":"102.2547919"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            77 => 
            array (
                'id' => '1403',
                'province_id' => '14',
                'name' => 'KABUPATEN INDRAGIRI HILIR',
                'meta' => '{"lat":"-0.1456733","long":"102.989615"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            78 => 
            array (
                'id' => '1404',
                'province_id' => '14',
                'name' => 'KABUPATEN PELALAWAN',
                'meta' => '{"lat":"0.1460923","long":"102.2547919"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            79 => 
            array (
                'id' => '1405',
                'province_id' => '14',
                'name' => 'KABUPATEN S I A K',
                'meta' => '{"lat":"0.8118812","long":"101.7979613"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            80 => 
            array (
                'id' => '1406',
                'province_id' => '14',
                'name' => 'KABUPATEN KAMPAR',
                'meta' => '{"lat":"0.146671","long":"101.1617356"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            81 => 
            array (
                'id' => '1407',
                'province_id' => '14',
                'name' => 'KABUPATEN ROKAN HULU',
                'meta' => '{"lat":"1.0410934","long":"100.439656"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            82 => 
            array (
                'id' => '1408',
                'province_id' => '14',
                'name' => 'KABUPATEN BENGKALIS',
                'meta' => '{"lat":"1.4139187","long":"101.6157773"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            83 => 
            array (
                'id' => '1409',
                'province_id' => '14',
                'name' => 'KABUPATEN ROKAN HILIR',
                'meta' => '{"lat":"1.6463978","long":"100.8000051"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            84 => 
            array (
                'id' => '1410',
                'province_id' => '14',
                'name' => 'KABUPATEN KEPULAUAN MERANTI',
                'meta' => '{"lat":"0.9208765","long":"102.6675575"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            85 => 
            array (
                'id' => '1471',
                'province_id' => '14',
                'name' => 'KOTA PEKANBARU',
                'meta' => '{"lat":"0.5070677","long":"101.4477793"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            86 => 
            array (
                'id' => '1473',
                'province_id' => '14',
                'name' => 'KOTA D U M A I',
                'meta' => '{"lat":"1.6666349","long":"101.4001855"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            87 => 
            array (
                'id' => '1501',
                'province_id' => '15',
                'name' => 'KABUPATEN KERINCI',
                'meta' => '{"lat":"-1.8720467","long":"101.4339148"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            88 => 
            array (
                'id' => '1502',
                'province_id' => '15',
                'name' => 'KABUPATEN MERANGIN',
                'meta' => '{"lat":"-2.1752789","long":"101.9804613"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            89 => 
            array (
                'id' => '1503',
                'province_id' => '15',
                'name' => 'KABUPATEN SAROLANGUN',
                'meta' => '{"lat":"-2.3230422","long":"102.7135121"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            90 => 
            array (
                'id' => '1504',
                'province_id' => '15',
                'name' => 'KABUPATEN BATANG HARI',
                'meta' => '{"lat":"-1.7083922","long":"103.0817903"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            91 => 
            array (
                'id' => '1505',
                'province_id' => '15',
                'name' => 'KABUPATEN MUARO JAMBI',
                'meta' => '{"lat":"-1.552136","long":"103.8216261"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            92 => 
            array (
                'id' => '1506',
                'province_id' => '15',
                'name' => 'KABUPATEN TANJUNG JABUNG TIMUR',
                'meta' => '{"lat":"-1.1024367","long":"103.8216261"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            93 => 
            array (
                'id' => '1507',
                'province_id' => '15',
                'name' => 'KABUPATEN TANJUNG JABUNG BARAT',
                'meta' => '{"lat":"-1.105846","long":"103.0817903"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            94 => 
            array (
                'id' => '1508',
                'province_id' => '15',
                'name' => 'KABUPATEN TEBO',
                'meta' => '{"lat":"-1.2592999","long":"102.3463875"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            95 => 
            array (
                'id' => '1509',
                'province_id' => '15',
                'name' => 'KABUPATEN BUNGO',
                'meta' => '{"lat":"-1.6401338","long":"101.8891721"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            96 => 
            array (
                'id' => '1571',
                'province_id' => '15',
                'name' => 'KOTA JAMBI',
                'meta' => '{"lat":"-1.6101229","long":"103.6131203"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            97 => 
            array (
                'id' => '1572',
                'province_id' => '15',
                'name' => 'KOTA SUNGAI PENUH',
                'meta' => '{"lat":"-2.0634335","long":"101.3947481"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            98 => 
            array (
                'id' => '1601',
                'province_id' => '16',
                'name' => 'KABUPATEN OGAN KOMERING ULU',
                'meta' => '{"lat":"-4.0283486","long":"104.0072348"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            99 => 
            array (
                'id' => '1602',
                'province_id' => '16',
                'name' => 'KABUPATEN OGAN KOMERING ILIR',
                'meta' => '{"lat":"-3.4559744","long":"105.2194808"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            100 => 
            array (
                'id' => '1603',
                'province_id' => '16',
                'name' => 'KABUPATEN MUARA ENIM',
                'meta' => '{"lat":"-3.7114163","long":"104.0072348"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            101 => 
            array (
                'id' => '1604',
                'province_id' => '16',
                'name' => 'KABUPATEN LAHAT',
                'meta' => '{"lat":"-3.8008893","long":"103.3587288"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            102 => 
            array (
                'id' => '1605',
                'province_id' => '16',
                'name' => 'KABUPATEN MUSI RAWAS',
                'meta' => '{"lat":"-3.0956537","long":"103.0817903"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            103 => 
            array (
                'id' => '1606',
                'province_id' => '16',
                'name' => 'KABUPATEN MUSI BANYUASIN',
                'meta' => '{"lat":"-2.5442029","long":"103.7289167"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            104 => 
            array (
                'id' => '1607',
                'province_id' => '16',
                'name' => 'KABUPATEN BANYU ASIN',
                'meta' => '{"lat":"-2.6095639","long":"104.7520939"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            105 => 
            array (
                'id' => '1608',
                'province_id' => '16',
                'name' => 'KABUPATEN OGAN KOMERING ULU SELATAN',
                'meta' => '{"lat":"-4.6681951","long":"104.0072348"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            106 => 
            array (
                'id' => '1609',
                'province_id' => '16',
                'name' => 'KABUPATEN OGAN KOMERING ULU TIMUR',
                'meta' => '{"lat":"-3.8567934","long":"104.7520939"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            107 => 
            array (
                'id' => '1610',
                'province_id' => '16',
                'name' => 'KABUPATEN OGAN ILIR',
                'meta' => '{"lat":"-3.426544","long":"104.6121475"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            108 => 
            array (
                'id' => '1611',
                'province_id' => '16',
                'name' => 'KABUPATEN EMPAT LAWANG',
                'meta' => '{"lat":"-3.7286029","long":"102.8975098"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            109 => 
            array (
                'id' => '1612',
                'province_id' => '16',
                'name' => 'KABUPATEN PENUKAL ABAB LEMATANG ILIR',
                'meta' => '{"lat":"-3.239825","long":"104.0072348"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            110 => 
            array (
                'id' => '1613',
                'province_id' => '16',
                'name' => 'KABUPATEN MUSI RAWAS UTARA',
                'meta' => '{"lat":"-2.787759","long":"102.7135121"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            111 => 
            array (
                'id' => '1671',
                'province_id' => '16',
                'name' => 'KOTA PALEMBANG',
                'meta' => '{"lat":"-2.9760735","long":"104.7754307"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            112 => 
            array (
                'id' => '1672',
                'province_id' => '16',
                'name' => 'KOTA PRABUMULIH',
                'meta' => '{"lat":"-3.4213707","long":"104.2436833"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            113 => 
            array (
                'id' => '1673',
                'province_id' => '16',
                'name' => 'KOTA PAGAR ALAM',
                'meta' => '{"lat":"-4.0419617","long":"103.2278845"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            114 => 
            array (
                'id' => '1674',
                'province_id' => '16',
                'name' => 'KOTA LUBUKLINGGAU',
                'meta' => '{"lat":"-3.2995858","long":"102.857236"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            115 => 
            array (
                'id' => '1701',
                'province_id' => '17',
                'name' => 'KABUPATEN BENGKULU SELATAN',
                'meta' => '{"lat":"-4.3248409","long":"103.035694"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            116 => 
            array (
                'id' => '1702',
                'province_id' => '17',
                'name' => 'KABUPATEN REJANG LEBONG',
                'meta' => '{"lat":"-3.4548154","long":"102.6675575"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            117 => 
            array (
                'id' => '1703',
                'province_id' => '17',
                'name' => 'KABUPATEN BENGKULU UTARA',
                'meta' => '{"lat":"-3.2663246","long":"101.9804613"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            118 => 
            array (
                'id' => '1704',
                'province_id' => '17',
                'name' => 'KABUPATEN KAUR',
                'meta' => '{"lat":"-4.5215978","long":"103.2663479"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            119 => 
            array (
                'id' => '1705',
                'province_id' => '17',
                'name' => 'KABUPATEN SELUMA',
                'meta' => '{"lat":"-4.0499387","long":"102.7135121"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            120 => 
            array (
                'id' => '1706',
                'province_id' => '17',
                'name' => 'KABUPATEN MUKOMUKO',
                'meta' => '{"lat":"-2.6449114","long":"101.4339148"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            121 => 
            array (
                'id' => '1707',
                'province_id' => '17',
                'name' => 'KABUPATEN LEBONG',
                'meta' => '{"lat":"-3.1455094","long":"102.2090224"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            122 => 
            array (
                'id' => '1708',
                'province_id' => '17',
                'name' => 'KABUPATEN KEPAHIANG',
                'meta' => '{"lat":"-3.6130091","long":"102.6675575"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            123 => 
            array (
                'id' => '1709',
                'province_id' => '17',
                'name' => 'KABUPATEN BENGKULU TENGAH',
                'meta' => '{"lat":"-3.6962324","long":"102.3922135"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            124 => 
            array (
                'id' => '1771',
                'province_id' => '17',
                'name' => 'KOTA BENGKULU',
                'meta' => '{"lat":"-3.7928451","long":"102.2607641"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            125 => 
            array (
                'id' => '1801',
                'province_id' => '18',
                'name' => 'KABUPATEN LAMPUNG BARAT',
                'meta' => '{"lat":"-5.1095293","long":"104.1466046"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            126 => 
            array (
                'id' => '1802',
                'province_id' => '18',
                'name' => 'KABUPATEN TANGGAMUS',
                'meta' => '{"lat":"-5.3027489","long":"104.5655273"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            127 => 
            array (
                'id' => '1803',
                'province_id' => '18',
                'name' => 'KABUPATEN LAMPUNG SELATAN',
                'meta' => '{"lat":"-5.5622614","long":"105.5474373"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            128 => 
            array (
                'id' => '1804',
                'province_id' => '18',
                'name' => 'KABUPATEN LAMPUNG TIMUR',
                'meta' => '{"lat":"-5.1134995","long":"105.6881788"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            129 => 
            array (
                'id' => '1805',
                'province_id' => '18',
                'name' => 'KABUPATEN LAMPUNG TENGAH',
                'meta' => '{"lat":"-4.8008086","long":"105.3131185"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            130 => 
            array (
                'id' => '1806',
                'province_id' => '18',
                'name' => 'KABUPATEN LAMPUNG UTARA',
                'meta' => '{"lat":"-4.8133905","long":"104.7520939"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            131 => 
            array (
                'id' => '1807',
                'province_id' => '18',
                'name' => 'KABUPATEN WAY KANAN',
                'meta' => '{"lat":"-4.4963689","long":"104.5655273"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            132 => 
            array (
                'id' => '1808',
                'province_id' => '18',
                'name' => 'KABUPATEN TULANGBAWANG',
                'meta' => '{"lat":"-4.3176576","long":"105.5005483"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            133 => 
            array (
                'id' => '1809',
                'province_id' => '18',
                'name' => 'KABUPATEN PESAWARAN',
                'meta' => '{"lat":"-5.493245","long":"105.0791228"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            134 => 
            array (
                'id' => '1810',
                'province_id' => '18',
                'name' => 'KABUPATEN PRINGSEWU',
                'meta' => '{"lat":"-5.3331186","long":"104.9856176"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            135 => 
            array (
                'id' => '1811',
                'province_id' => '18',
                'name' => 'KABUPATEN MESUJI',
                'meta' => '{"lat":"-4.0044783","long":"105.3131185"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            136 => 
            array (
                'id' => '1812',
                'province_id' => '18',
                'name' => 'KABUPATEN TULANG BAWANG BARAT',
                'meta' => '{"lat":"-4.5256967","long":"105.0791228"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            137 => 
            array (
                'id' => '1813',
                'province_id' => '18',
                'name' => 'KABUPATEN PESISIR BARAT',
                'meta' => '{"lat":"-5.2928191","long":"104.1233667"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            138 => 
            array (
                'id' => '1871',
                'province_id' => '18',
                'name' => 'KOTA BANDAR LAMPUNG',
                'meta' => '{"lat":"-5.3971396","long":"105.2667887"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            139 => 
            array (
                'id' => '1872',
                'province_id' => '18',
                'name' => 'KOTA METRO',
                'meta' => '{"lat":"-5.1178394","long":"105.3072646"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            140 => 
            array (
                'id' => '1901',
                'province_id' => '19',
                'name' => 'KABUPATEN BANGKA',
                'meta' => '{"lat":"-1.874294","long":"105.92299"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            141 => 
            array (
                'id' => '1902',
                'province_id' => '19',
                'name' => 'KABUPATEN BELITUNG',
                'meta' => '{"lat":"-2.7216743","long":"107.763621"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            142 => 
            array (
                'id' => '1903',
                'province_id' => '19',
                'name' => 'KABUPATEN BANGKA BARAT',
                'meta' => '{"lat":"-1.8405046","long":"105.5005483"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            143 => 
            array (
                'id' => '1904',
                'province_id' => '19',
                'name' => 'KABUPATEN BANGKA TENGAH',
                'meta' => '{"lat":"-2.4007823","long":"106.2051484"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            144 => 
            array (
                'id' => '1905',
                'province_id' => '19',
                'name' => 'KABUPATEN BANGKA SELATAN',
                'meta' => '{"lat":"-2.7410513","long":"106.4405872"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            145 => 
            array (
                'id' => '1906',
                'province_id' => '19',
                'name' => 'KABUPATEN BELITUNG TIMUR',
                'meta' => '{"lat":"-2.8678037","long":"108.1428669"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            146 => 
            array (
                'id' => '1971',
                'province_id' => '19',
                'name' => 'KOTA PANGKAL PINANG',
                'meta' => '{"lat":"-2.1316266","long":"106.1169299"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            147 => 
            array (
                'id' => '2101',
                'province_id' => '21',
                'name' => 'KABUPATEN KARIMUN',
                'meta' => '{"lat":"0.7697665","long":"103.4049445"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            148 => 
            array (
                'id' => '2102',
                'province_id' => '21',
                'name' => 'KABUPATEN BINTAN',
                'meta' => '{"lat":"1.0619173","long":"104.5189214"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            149 => 
            array (
                'id' => '2103',
                'province_id' => '21',
                'name' => 'KABUPATEN NATUNA',
                'meta' => '{"lat":"4","long":"108.25"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            150 => 
            array (
                'id' => '2104',
                'province_id' => '21',
                'name' => 'KABUPATEN LINGGA',
                'meta' => '{"lat":"-0.4726065","long":"104.4257533"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            151 => 
            array (
                'id' => '2105',
                'province_id' => '21',
                'name' => 'KABUPATEN KEPULAUAN ANAMBAS',
                'meta' => '{"lat":"3.1055459","long":"105.6537231"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            152 => 
            array (
                'id' => '2171',
                'province_id' => '21',
                'name' => 'KOTA BATAM',
                'meta' => '{"lat":"1.1300779","long":"104.0529207"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            153 => 
            array (
                'id' => '2172',
                'province_id' => '21',
                'name' => 'KOTA TANJUNG PINANG',
                'meta' => '{"lat":"0.9185504","long":"104.4665072"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            154 => 
            array (
                'id' => '3101',
                'province_id' => '31',
                'name' => 'KABUPATEN KEPULAUAN SERIBU',
                'meta' => '{"lat":"-5.6122404","long":"106.6169964"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            155 => 
            array (
                'id' => '3171',
                'province_id' => '31',
                'name' => 'KOTA JAKARTA SELATAN',
                'meta' => '{"lat":"-6.2614927","long":"106.8105998"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            156 => 
            array (
                'id' => '3172',
                'province_id' => '31',
                'name' => 'KOTA JAKARTA TIMUR',
                'meta' => '{"lat":"-6.2250138","long":"106.9004472"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            157 => 
            array (
                'id' => '3173',
                'province_id' => '31',
                'name' => 'KOTA JAKARTA PUSAT',
                'meta' => '{"lat":"-6.1805113","long":"106.8283831"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            158 => 
            array (
                'id' => '3174',
                'province_id' => '31',
                'name' => 'KOTA JAKARTA BARAT',
                'meta' => '{"lat":"-6.1674309","long":"106.7637239"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            159 => 
            array (
                'id' => '3175',
                'province_id' => '31',
                'name' => 'KOTA JAKARTA UTARA',
                'meta' => '{"lat":"-6.1554057","long":"106.8926634"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            160 => 
            array (
                'id' => '3201',
                'province_id' => '32',
                'name' => 'KABUPATEN BOGOR',
                'meta' => '{"lat":"-6.5517758","long":"106.6291304"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            161 => 
            array (
                'id' => '3202',
                'province_id' => '32',
                'name' => 'KABUPATEN SUKABUMI',
                'meta' => '{"lat":"-6.8649236","long":"106.9535691"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            162 => 
            array (
                'id' => '3203',
                'province_id' => '32',
                'name' => 'KABUPATEN CIANJUR',
                'meta' => '{"lat":"-7.3579773","long":"107.1957203"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            163 => 
            array (
                'id' => '3204',
                'province_id' => '32',
                'name' => 'KABUPATEN BANDUNG',
                'meta' => '{"lat":"-7.1340702","long":"107.6215321"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            164 => 
            array (
                'id' => '3205',
                'province_id' => '32',
                'name' => 'KABUPATEN GARUT',
                'meta' => '{"lat":"-7.5012204","long":"107.763621"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            165 => 
            array (
                'id' => '3206',
                'province_id' => '32',
                'name' => 'KABUPATEN TASIKMALAYA',
                'meta' => '{"lat":"-7.6513306","long":"108.1428669"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            166 => 
            array (
                'id' => '3207',
                'province_id' => '32',
                'name' => 'KABUPATEN CIAMIS',
                'meta' => '{"lat":"-7.3320773","long":"108.3492543"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            167 => 
            array (
                'id' => '3208',
                'province_id' => '32',
                'name' => 'KABUPATEN KUNINGAN',
                'meta' => '{"lat":"-7.0138053","long":"108.5700636"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            168 => 
            array (
                'id' => '3209',
                'province_id' => '32',
                'name' => 'KABUPATEN CIREBON',
                'meta' => '{"lat":"-6.6898876","long":"108.4750846"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            169 => 
            array (
                'id' => '3210',
                'province_id' => '32',
                'name' => 'KABUPATEN MAJALENGKA',
                'meta' => '{"lat":"-6.7790605","long":"108.2852049"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            170 => 
            array (
                'id' => '3211',
                'province_id' => '32',
                'name' => 'KABUPATEN SUMEDANG',
                'meta' => '{"lat":"-6.832858","long":"107.9531836"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            171 => 
            array (
                'id' => '3212',
                'province_id' => '32',
                'name' => 'KABUPATEN INDRAMAYU',
                'meta' => '{"lat":"-6.33731","long":"108.3258329"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            172 => 
            array (
                'id' => '3213',
                'province_id' => '32',
                'name' => 'KABUPATEN SUBANG',
                'meta' => '{"lat":"-6.3487617","long":"107.763621"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            173 => 
            array (
                'id' => '3214',
                'province_id' => '32',
                'name' => 'KABUPATEN PURWAKARTA',
                'meta' => '{"lat":"-6.5649241","long":"107.4321959"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            174 => 
            array (
                'id' => '3215',
                'province_id' => '32',
                'name' => 'KABUPATEN KARAWANG',
                'meta' => '{"lat":"-6.3227303","long":"107.3375791"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            175 => 
            array (
                'id' => '3216',
                'province_id' => '32',
                'name' => 'KABUPATEN BEKASI',
                'meta' => '{"lat":"-6.366723","long":"107.1735638"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            176 => 
            array (
                'id' => '3217',
                'province_id' => '32',
                'name' => 'KABUPATEN BANDUNG BARAT',
                'meta' => '{"lat":"-6.8652214","long":"107.4919767"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            177 => 
            array (
                'id' => '3218',
                'province_id' => '32',
                'name' => 'KABUPATEN PANGANDARAN',
                'meta' => '{"lat":"-7.6150611","long":"108.4988269"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            178 => 
            array (
                'id' => '3271',
                'province_id' => '32',
                'name' => 'KOTA BOGOR',
                'meta' => '{"lat":"-6.5971469","long":"106.8060388"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            179 => 
            array (
                'id' => '3272',
                'province_id' => '32',
                'name' => 'KOTA SUKABUMI',
                'meta' => '{"lat":"-6.9277361","long":"106.9299579"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            180 => 
            array (
                'id' => '3273',
                'province_id' => '32',
                'name' => 'KOTA BANDUNG',
                'meta' => '{"lat":"-6.9174639","long":"107.6191228"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            181 => 
            array (
                'id' => '3274',
                'province_id' => '32',
                'name' => 'KOTA CIREBON',
                'meta' => '{"lat":"-6.7320229","long":"108.5523164"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            182 => 
            array (
                'id' => '3275',
                'province_id' => '32',
                'name' => 'KOTA BEKASI',
                'meta' => '{"lat":"-6.2382699","long":"106.9755726"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            183 => 
            array (
                'id' => '3276',
                'province_id' => '32',
                'name' => 'KOTA DEPOK',
                'meta' => '{"lat":"-6.4024844","long":"106.7942405"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            184 => 
            array (
                'id' => '3277',
                'province_id' => '32',
                'name' => 'KOTA CIMAHI',
                'meta' => '{"lat":"-6.8840816","long":"107.5413039"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            185 => 
            array (
                'id' => '3278',
                'province_id' => '32',
                'name' => 'KOTA TASIKMALAYA',
                'meta' => '{"lat":"-7.3505808","long":"108.2171633"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            186 => 
            array (
                'id' => '3279',
                'province_id' => '32',
                'name' => 'KOTA BANJAR',
                'meta' => '{"lat":"-7.3706874","long":"108.5342487"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            187 => 
            array (
                'id' => '3301',
                'province_id' => '33',
                'name' => 'KABUPATEN CILACAP',
                'meta' => '{"lat":"-7.6982991","long":"109.023521"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            188 => 
            array (
                'id' => '3302',
                'province_id' => '33',
                'name' => 'KABUPATEN BANYUMAS',
                'meta' => '{"lat":"-7.4832133","long":"109.140438"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            189 => 
            array (
                'id' => '3303',
                'province_id' => '33',
                'name' => 'KABUPATEN PURBALINGGA',
                'meta' => '{"lat":"-7.3058578","long":"109.4259114"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            190 => 
            array (
                'id' => '3304',
                'province_id' => '33',
                'name' => 'KABUPATEN BANJARNEGARA',
                'meta' => '{"lat":"-7.3794368","long":"109.6163185"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            191 => 
            array (
                'id' => '3305',
                'province_id' => '33',
                'name' => 'KABUPATEN KEBUMEN',
                'meta' => '{"lat":"-7.6680559","long":"109.6524575"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            192 => 
            array (
                'id' => '3306',
                'province_id' => '33',
                'name' => 'KABUPATEN PURWOREJO',
                'meta' => '{"lat":"-7.6964509","long":"109.9989416"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            193 => 
            array (
                'id' => '3307',
                'province_id' => '33',
                'name' => 'KABUPATEN WONOSOBO',
                'meta' => '{"lat":"-7.3632094","long":"109.9001796"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            194 => 
            array (
                'id' => '3308',
                'province_id' => '33',
                'name' => 'KABUPATEN MAGELANG',
                'meta' => '{"lat":"-7.4305237","long":"110.2832217"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            195 => 
            array (
                'id' => '3309',
                'province_id' => '33',
                'name' => 'KABUPATEN BOYOLALI',
                'meta' => '{"lat":"-7.4317773","long":"110.6883536"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            196 => 
            array (
                'id' => '3310',
                'province_id' => '33',
                'name' => 'KABUPATEN KLATEN',
                'meta' => '{"lat":"-7.657893","long":"110.6645683"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            197 => 
            array (
                'id' => '3311',
                'province_id' => '33',
                'name' => 'KABUPATEN SUKOHARJO',
                'meta' => '{"lat":"-7.6483506","long":"110.8552919"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            198 => 
            array (
                'id' => '3312',
                'province_id' => '33',
                'name' => 'KABUPATEN WONOGIRI',
                'meta' => '{"lat":"-7.8846484","long":"111.0460407"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            199 => 
            array (
                'id' => '3313',
                'province_id' => '33',
                'name' => 'KABUPATEN KARANGANYAR',
                'meta' => '{"lat":"-7.6387228","long":"111.0460407"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            200 => 
            array (
                'id' => '3314',
                'province_id' => '33',
                'name' => 'KABUPATEN SRAGEN',
                'meta' => '{"lat":"-7.43027","long":"111.0091855"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            201 => 
            array (
                'id' => '3315',
                'province_id' => '33',
                'name' => 'KABUPATEN GROBOGAN',
                'meta' => '{"lat":"-7.1541672","long":"110.9506636"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            202 => 
            array (
                'id' => '3316',
                'province_id' => '33',
                'name' => 'KABUPATEN BLORA',
                'meta' => '{"lat":"-7.012244","long":"111.3798928"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            203 => 
            array (
                'id' => '3317',
                'province_id' => '33',
                'name' => 'KABUPATEN REMBANG',
                'meta' => '{"lat":"-6.8082115","long":"111.4275888"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            204 => 
            array (
                'id' => '3318',
                'province_id' => '33',
                'name' => 'KABUPATEN PATI',
                'meta' => '{"lat":"-6.7449635","long":"111.0460407"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            205 => 
            array (
                'id' => '3319',
                'province_id' => '33',
                'name' => 'KABUPATEN KUDUS',
                'meta' => '{"lat":"-6.7726186","long":"110.8791343"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            206 => 
            array (
                'id' => '3320',
                'province_id' => '33',
                'name' => 'KABUPATEN JEPARA',
                'meta' => '{"lat":"-6.582711","long":"110.6786933"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            207 => 
            array (
                'id' => '3321',
                'province_id' => '33',
                'name' => 'KABUPATEN DEMAK',
                'meta' => '{"lat":"-6.9238879","long":"110.6645683"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            208 => 
            array (
                'id' => '3322',
                'province_id' => '33',
                'name' => 'KABUPATEN SEMARANG',
                'meta' => '{"lat":"-7.1764785","long":"110.4738762"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            209 => 
            array (
                'id' => '3323',
                'province_id' => '33',
                'name' => 'KABUPATEN TEMANGGUNG',
                'meta' => '{"lat":"-7.2748721","long":"110.0891894"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            210 => 
            array (
                'id' => '3324',
                'province_id' => '33',
                'name' => 'KABUPATEN KENDAL',
                'meta' => '{"lat":"-7.0265442","long":"110.1879106"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            211 => 
            array (
                'id' => '3325',
                'province_id' => '33',
                'name' => 'KABUPATEN BATANG',
                'meta' => '{"lat":"-7.0392183","long":"109.9020509"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            212 => 
            array (
                'id' => '3326',
                'province_id' => '33',
                'name' => 'KABUPATEN PEKALONGAN',
                'meta' => '{"lat":"-7.0517128","long":"109.6163185"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            213 => 
            array (
                'id' => '3327',
                'province_id' => '33',
                'name' => 'KABUPATEN PEMALANG',
                'meta' => '{"lat":"-7.0599422","long":"109.4259114"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            214 => 
            array (
                'id' => '3328',
                'province_id' => '33',
                'name' => 'KABUPATEN TEGAL',
                'meta' => '{"lat":"-6.8588473","long":"109.1047663"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            215 => 
            array (
                'id' => '3329',
                'province_id' => '33',
                'name' => 'KABUPATEN BREBES',
                'meta' => '{"lat":"-6.9591793","long":"108.902683"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            216 => 
            array (
                'id' => '3371',
                'province_id' => '33',
                'name' => 'KOTA MAGELANG',
                'meta' => '{"lat":"-7.4797342","long":"110.2176941"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            217 => 
            array (
                'id' => '3372',
                'province_id' => '33',
                'name' => 'KOTA SURAKARTA',
                'meta' => '{"lat":"-7.5754887","long":"110.8243272"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            218 => 
            array (
                'id' => '3373',
                'province_id' => '33',
                'name' => 'KOTA SALATIGA',
                'meta' => '{"lat":"-7.3305234","long":"110.5084366"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            219 => 
            array (
                'id' => '3374',
                'province_id' => '33',
                'name' => 'KOTA SEMARANG',
                'meta' => '{"lat":"-7.0051453","long":"110.4381254"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            220 => 
            array (
                'id' => '3375',
                'province_id' => '33',
                'name' => 'KOTA PEKALONGAN',
                'meta' => '{"lat":"-6.8898362","long":"109.6745916"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            221 => 
            array (
                'id' => '3376',
                'province_id' => '33',
                'name' => 'KOTA TEGAL',
                'meta' => '{"lat":"-6.8797041","long":"109.1255917"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            222 => 
            array (
                'id' => '3401',
                'province_id' => '34',
                'name' => 'KABUPATEN KULON PROGO',
                'meta' => '{"lat":"-7.8266798","long":"110.1640846"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            223 => 
            array (
                'id' => '3402',
                'province_id' => '34',
                'name' => 'KABUPATEN BANTUL',
                'meta' => '{"lat":"-7.9190169","long":"110.3785438"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            224 => 
            array (
                'id' => '3403',
                'province_id' => '34',
                'name' => 'KABUPATEN GUNUNG KIDUL',
                'meta' => '{"lat":"-8.0305091","long":"110.6168921"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            225 => 
            array (
                'id' => '3404',
                'province_id' => '34',
                'name' => 'KABUPATEN SLEMAN',
                'meta' => '{"lat":"-7.7325213","long":"110.402376"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            226 => 
            array (
                'id' => '3471',
                'province_id' => '34',
                'name' => 'KOTA YOGYAKARTA',
                'meta' => '{"lat":"-7.7955798","long":"110.3694896"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            227 => 
            array (
                'id' => '3501',
                'province_id' => '35',
                'name' => 'KABUPATEN PACITAN',
                'meta' => '{"lat":"-8.126331","long":"111.1414226"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            228 => 
            array (
                'id' => '3502',
                'province_id' => '35',
                'name' => 'KABUPATEN PONOROGO',
                'meta' => '{"lat":"-7.8650759","long":"111.4696322"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            229 => 
            array (
                'id' => '3503',
                'province_id' => '35',
                'name' => 'KABUPATEN TRENGGALEK',
                'meta' => '{"lat":"-8.1824112","long":"111.6183755"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            230 => 
            array (
                'id' => '3504',
                'province_id' => '35',
                'name' => 'KABUPATEN TULUNGAGUNG',
                'meta' => '{"lat":"-8.091221","long":"111.9641728"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            231 => 
            array (
                'id' => '3505',
                'province_id' => '35',
                'name' => 'KABUPATEN BLITAR',
                'meta' => '{"lat":"-8.0954627","long":"112.1609056"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            232 => 
            array (
                'id' => '3506',
                'province_id' => '35',
                'name' => 'KABUPATEN KEDIRI',
                'meta' => '{"lat":"-7.8232397","long":"112.1907122"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            233 => 
            array (
                'id' => '3507',
                'province_id' => '35',
                'name' => 'KABUPATEN MALANG',
                'meta' => '{"lat":"-8.242209","long":"112.7152125"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            234 => 
            array (
                'id' => '3508',
                'province_id' => '35',
                'name' => 'KABUPATEN LUMAJANG',
                'meta' => '{"lat":"-8.0943571","long":"113.1441558"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            235 => 
            array (
                'id' => '3509',
                'province_id' => '35',
                'name' => 'KABUPATEN JEMBER',
                'meta' => '{"lat":"-8.1844859","long":"113.6680747"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            236 => 
            array (
                'id' => '3510',
                'province_id' => '35',
                'name' => 'KABUPATEN BANYUWANGI',
                'meta' => '{"lat":"-8.2190944","long":"114.3691416"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            237 => 
            array (
                'id' => '3511',
                'province_id' => '35',
                'name' => 'KABUPATEN BONDOWOSO',
                'meta' => '{"lat":"-7.9673906","long":"113.9060624"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            238 => 
            array (
                'id' => '3512',
                'province_id' => '35',
                'name' => 'KABUPATEN SITUBONDO',
                'meta' => '{"lat":"-7.7888522","long":"114.1914951"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            239 => 
            array (
                'id' => '3513',
                'province_id' => '35',
                'name' => 'KABUPATEN PROBOLINGGO',
                'meta' => '{"lat":"-7.8717562","long":"113.4776098"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            240 => 
            array (
                'id' => '3514',
                'province_id' => '35',
                'name' => 'KABUPATEN PASURUAN',
                'meta' => '{"lat":"-7.7859961","long":"112.858217"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            241 => 
            array (
                'id' => '3515',
                'province_id' => '35',
                'name' => 'KABUPATEN SIDOARJO',
                'meta' => '{"lat":"-7.4726134","long":"112.6675398"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            242 => 
            array (
                'id' => '3516',
                'province_id' => '35',
                'name' => 'KABUPATEN MOJOKERTO',
                'meta' => '{"lat":"-7.4698914","long":"112.4351068"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            243 => 
            array (
                'id' => '3517',
                'province_id' => '35',
                'name' => 'KABUPATEN JOMBANG',
                'meta' => '{"lat":"-7.5740867","long":"112.28609"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            244 => 
            array (
                'id' => '3518',
                'province_id' => '35',
                'name' => 'KABUPATEN NGANJUK',
                'meta' => '{"lat":"-7.5943507","long":"111.9045541"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            245 => 
            array (
                'id' => '3519',
                'province_id' => '35',
                'name' => 'KABUPATEN MADIUN',
                'meta' => '{"lat":"-7.6093306","long":"111.6183755"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            246 => 
            array (
                'id' => '3520',
                'province_id' => '35',
                'name' => 'KABUPATEN MAGETAN',
                'meta' => '{"lat":"-7.6433138","long":"111.356045"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            247 => 
            array (
                'id' => '3521',
                'province_id' => '35',
                'name' => 'KABUPATEN NGAWI',
                'meta' => '{"lat":"-7.460987","long":"111.3321974"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            248 => 
            array (
                'id' => '3522',
                'province_id' => '35',
                'name' => 'KABUPATEN BOJONEGORO',
                'meta' => '{"lat":"-7.3174629","long":"111.7614661"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            249 => 
            array (
                'id' => '3523',
                'province_id' => '35',
                'name' => 'KABUPATEN TUBAN',
                'meta' => '{"lat":"-6.8949099","long":"112.0416754"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            250 => 
            array (
                'id' => '3524',
                'province_id' => '35',
                'name' => 'KABUPATEN LAMONGAN',
                'meta' => '{"lat":"-7.1269261","long":"112.3337769"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            251 => 
            array (
                'id' => '3525',
                'province_id' => '35',
                'name' => 'KABUPATEN GRESIK',
                'meta' => '{"lat":"-7.1550291","long":"112.5721881"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            252 => 
            array (
                'id' => '3526',
                'province_id' => '35',
                'name' => 'KABUPATEN BANGKALAN',
                'meta' => '{"lat":"-7.038375","long":"112.9136695"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            253 => 
            array (
                'id' => '3527',
                'province_id' => '35',
                'name' => 'KABUPATEN SAMPANG',
                'meta' => '{"lat":"-7.0402326","long":"113.2394452"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            254 => 
            array (
                'id' => '3528',
                'province_id' => '35',
                'name' => 'KABUPATEN PAMEKASAN',
                'meta' => '{"lat":"-7.1050857","long":"113.5252319"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            255 => 
            array (
                'id' => '3529',
                'province_id' => '35',
                'name' => 'KABUPATEN SUMENEP',
                'meta' => '{"lat":"-6.9253999","long":"113.9060624"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            256 => 
            array (
                'id' => '3571',
                'province_id' => '35',
                'name' => 'KOTA KEDIRI',
                'meta' => '{"lat":"-7.8480156","long":"112.0178286"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            257 => 
            array (
                'id' => '3572',
                'province_id' => '35',
                'name' => 'KOTA BLITAR',
                'meta' => '{"lat":"-8.0954627","long":"112.1609056"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            258 => 
            array (
                'id' => '3573',
                'province_id' => '35',
                'name' => 'KOTA MALANG',
                'meta' => '{"lat":"-7.9666204","long":"112.6326321"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            259 => 
            array (
                'id' => '3574',
                'province_id' => '35',
                'name' => 'KOTA PROBOLINGGO',
                'meta' => '{"lat":"-7.7764226","long":"113.2037131"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            260 => 
            array (
                'id' => '3575',
                'province_id' => '35',
                'name' => 'KOTA PASURUAN',
                'meta' => '{"lat":"-7.6469193","long":"112.8999225"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            261 => 
            array (
                'id' => '3576',
                'province_id' => '35',
                'name' => 'KOTA MOJOKERTO',
                'meta' => '{"lat":"-7.4704747","long":"112.4401329"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            262 => 
            array (
                'id' => '3577',
                'province_id' => '35',
                'name' => 'KOTA MADIUN',
                'meta' => '{"lat":"-7.6310587","long":"111.5300159"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            263 => 
            array (
                'id' => '3578',
                'province_id' => '35',
                'name' => 'KOTA SURABAYA',
                'meta' => '{"lat":"-7.2574719","long":"112.7520883"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            264 => 
            array (
                'id' => '3579',
                'province_id' => '35',
                'name' => 'KOTA BATU',
                'meta' => '{"lat":"-7.8830648","long":"112.5334492"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            265 => 
            array (
                'id' => '3601',
                'province_id' => '36',
                'name' => 'KABUPATEN PANDEGLANG',
                'meta' => '{"lat":"-6.7482706","long":"105.6881788"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            266 => 
            array (
                'id' => '3602',
                'province_id' => '36',
                'name' => 'KABUPATEN LEBAK',
                'meta' => '{"lat":"-6.5643956","long":"106.2522143"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            267 => 
            array (
                'id' => '3603',
                'province_id' => '36',
                'name' => 'KABUPATEN TANGERANG',
                'meta' => '{"lat":"-6.1870007","long":"106.487658"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            268 => 
            array (
                'id' => '3604',
                'province_id' => '36',
                'name' => 'KABUPATEN SERANG',
                'meta' => '{"lat":"-6.1397339","long":"106.040506"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            269 => 
            array (
                'id' => '3671',
                'province_id' => '36',
                'name' => 'KOTA TANGERANG',
                'meta' => '{"lat":"-6.1701796","long":"106.6403236"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            270 => 
            array (
                'id' => '3672',
                'province_id' => '36',
                'name' => 'KOTA CILEGON',
                'meta' => '{"lat":"-6.0186817","long":"106.0558218"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            271 => 
            array (
                'id' => '3673',
                'province_id' => '36',
                'name' => 'KOTA SERANG',
                'meta' => '{"lat":"-6.1169309","long":"106.1538519"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            272 => 
            array (
                'id' => '3674',
                'province_id' => '36',
                'name' => 'KOTA TANGERANG SELATAN',
                'meta' => '{"lat":"-6.2835218","long":"106.7112933"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            273 => 
            array (
                'id' => '5101',
                'province_id' => '51',
                'name' => 'KABUPATEN JEMBRANA',
                'meta' => '{"lat":"-8.3233438","long":"114.6667939"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            274 => 
            array (
                'id' => '5102',
                'province_id' => '51',
                'name' => 'KABUPATEN TABANAN',
                'meta' => '{"lat":"-8.4595561","long":"115.0465991"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            275 => 
            array (
                'id' => '5103',
                'province_id' => '51',
                'name' => 'KABUPATEN BADUNG',
                'meta' => '{"lat":"-8.5819296","long":"115.1770586"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            276 => 
            array (
                'id' => '5104',
                'province_id' => '51',
                'name' => 'KABUPATEN GIANYAR',
                'meta' => '{"lat":"-8.4248244","long":"115.2600506"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            277 => 
            array (
                'id' => '5105',
                'province_id' => '51',
                'name' => 'KABUPATEN KLUNGKUNG',
                'meta' => '{"lat":"-8.727807","long":"115.5444231"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            278 => 
            array (
                'id' => '5106',
                'province_id' => '51',
                'name' => 'KABUPATEN BANGLI',
                'meta' => '{"lat":"-8.2975884","long":"115.3548713"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            279 => 
            array (
                'id' => '5107',
                'province_id' => '51',
                'name' => 'KABUPATEN KARANG ASEM',
                'meta' => '{"lat":"-8.3465933","long":"115.5207358"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            280 => 
            array (
                'id' => '5108',
                'province_id' => '51',
                'name' => 'KABUPATEN BULELENG',
                'meta' => '{"lat":"-8.2238968","long":"114.9516869"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            281 => 
            array (
                'id' => '5171',
                'province_id' => '51',
                'name' => 'KOTA DENPASAR',
                'meta' => '{"lat":"-8.6704582","long":"115.2126293"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            282 => 
            array (
                'id' => '5201',
                'province_id' => '52',
                'name' => 'KABUPATEN LOMBOK BARAT',
                'meta' => '{"lat":"-8.6464599","long":"116.1123078"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            283 => 
            array (
                'id' => '5202',
                'province_id' => '52',
                'name' => 'KABUPATEN LOMBOK TENGAH',
                'meta' => '{"lat":"-8.694623","long":"116.2777073"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            284 => 
            array (
                'id' => '5203',
                'province_id' => '52',
                'name' => 'KABUPATEN LOMBOK TIMUR',
                'meta' => '{"lat":"-8.5134471","long":"116.5609857"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            285 => 
            array (
                'id' => '5204',
                'province_id' => '52',
                'name' => 'KABUPATEN SUMBAWA',
                'meta' => '{"lat":"-8.6529334","long":"117.3616476"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            286 => 
            array (
                'id' => '5205',
                'province_id' => '52',
                'name' => 'KABUPATEN DOMPU',
                'meta' => '{"lat":"-8.5363958","long":"118.3461948"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            287 => 
            array (
                'id' => '5206',
                'province_id' => '52',
                'name' => 'KABUPATEN BIMA',
                'meta' => '{"lat":"-8.4353962","long":"118.626479"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            288 => 
            array (
                'id' => '5207',
                'province_id' => '52',
                'name' => 'KABUPATEN SUMBAWA BARAT',
                'meta' => '{"lat":"-8.9292907","long":"116.8910342"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            289 => 
            array (
                'id' => '5208',
                'province_id' => '52',
                'name' => 'KABUPATEN LOMBOK UTARA',
                'meta' => '{"lat":"-8.3739076","long":"116.2777073"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            290 => 
            array (
                'id' => '5271',
                'province_id' => '52',
                'name' => 'KOTA MATARAM',
                'meta' => '{"lat":"-8.5970808","long":"116.1004894"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            291 => 
            array (
                'id' => '5272',
                'province_id' => '52',
                'name' => 'KOTA BIMA',
                'meta' => '{"lat":"-8.4642661","long":"118.7449028"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            292 => 
            array (
                'id' => '5301',
                'province_id' => '53',
                'name' => 'KABUPATEN SUMBA BARAT',
                'meta' => '{"lat":"-9.6548326","long":"119.3947135"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            293 => 
            array (
                'id' => '5302',
                'province_id' => '53',
                'name' => 'KABUPATEN SUMBA TIMUR',
                'meta' => '{"lat":"-9.9802103","long":"120.3435506"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            294 => 
            array (
                'id' => '5303',
                'province_id' => '53',
                'name' => 'KABUPATEN KUPANG',
                'meta' => '{"lat":"-9.9906166","long":"123.8857747"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            295 => 
            array (
                'id' => '5304',
                'province_id' => '53',
                'name' => 'KABUPATEN TIMOR TENGAH SELATAN',
                'meta' => '{"lat":"-9.7762816","long":"124.4198243"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            296 => 
            array (
                'id' => '5305',
                'province_id' => '53',
                'name' => 'KABUPATEN TIMOR TENGAH UTARA',
                'meta' => '{"lat":"-9.4522647","long":"124.597132"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            297 => 
            array (
                'id' => '5306',
                'province_id' => '53',
                'name' => 'KABUPATEN BELU',
                'meta' => '{"lat":"-9.1538978","long":"124.906551"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            298 => 
            array (
                'id' => '5307',
                'province_id' => '53',
                'name' => 'KABUPATEN ALOR',
                'meta' => '{"lat":"-8.2928427","long":"124.5528387"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            299 => 
            array (
                'id' => '5308',
                'province_id' => '53',
                'name' => 'KABUPATEN LEMBATA',
                'meta' => '{"lat":"-8.4719075","long":"123.4831906"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            300 => 
            array (
                'id' => '5309',
                'province_id' => '53',
                'name' => 'KABUPATEN FLORES TIMUR',
                'meta' => '{"lat":"-8.3130942","long":"122.9663018"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            301 => 
            array (
                'id' => '5310',
                'province_id' => '53',
                'name' => 'KABUPATEN SIKKA',
                'meta' => '{"lat":"-8.6766175","long":"122.1291843"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            302 => 
            array (
                'id' => '5311',
                'province_id' => '53',
                'name' => 'KABUPATEN ENDE',
                'meta' => '{"lat":"-8.6762912","long":"121.7195459"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            303 => 
            array (
                'id' => '5312',
                'province_id' => '53',
                'name' => 'KABUPATEN NGADA',
                'meta' => '{"lat":"-8.7430424","long":"120.9876321"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            304 => 
            array (
                'id' => '5313',
                'province_id' => '53',
                'name' => 'KABUPATEN MANGGARAI',
                'meta' => '{"lat":"-8.6796987","long":"120.3896651"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            305 => 
            array (
                'id' => '5314',
                'province_id' => '53',
                'name' => 'KABUPATEN ROTE NDAO',
                'meta' => '{"lat":"-10.7386421","long":"123.1239049"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            306 => 
            array (
                'id' => '5315',
                'province_id' => '53',
                'name' => 'KABUPATEN MANGGARAI BARAT',
                'meta' => '{"lat":"-8.6688149","long":"120.0665236"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            307 => 
            array (
                'id' => '5316',
                'province_id' => '53',
                'name' => 'KABUPATEN SUMBA TENGAH',
                'meta' => '{"lat":"-9.4879226","long":"119.6962677"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            308 => 
            array (
                'id' => '5317',
                'province_id' => '53',
                'name' => 'KABUPATEN SUMBA BARAT DAYA',
                'meta' => '{"lat":"-9.539139","long":"119.1390642"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            309 => 
            array (
                'id' => '5318',
                'province_id' => '53',
                'name' => 'KABUPATEN NAGEKEO',
                'meta' => '{"lat":"-8.6753545","long":"121.3084088"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            310 => 
            array (
                'id' => '5319',
                'province_id' => '53',
                'name' => 'KABUPATEN MANGGARAI TIMUR',
                'meta' => '{"lat":"-8.6206712","long":"120.6199895"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            311 => 
            array (
                'id' => '5320',
                'province_id' => '53',
                'name' => 'KABUPATEN SABU RAIJUA',
                'meta' => '{"lat":"-10.5541116","long":"121.8334868"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            312 => 
            array (
                'id' => '5321',
                'province_id' => '53',
                'name' => 'KABUPATEN MALAKA',
                'meta' => '{"lat":"-9.5308587","long":"124.906551"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            313 => 
            array (
                'id' => '5371',
                'province_id' => '53',
                'name' => 'KOTA KUPANG',
                'meta' => '{"lat":"-10.1771997","long":"123.6070329"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            314 => 
            array (
                'id' => '6101',
                'province_id' => '61',
                'name' => 'KABUPATEN SAMBAS',
                'meta' => '{"lat":"1.3625191","long":"109.2831531"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            315 => 
            array (
                'id' => '6102',
                'province_id' => '61',
                'name' => 'KABUPATEN BENGKAYANG',
                'meta' => '{"lat":"1.06911","long":"109.6639309"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            316 => 
            array (
                'id' => '6103',
                'province_id' => '61',
                'name' => 'KABUPATEN LANDAK',
                'meta' => '{"lat":"0.4237287","long":"109.7591675"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            317 => 
            array (
                'id' => '6104',
                'province_id' => '61',
                'name' => 'KABUPATEN MEMPAWAH',
                'meta' => '{"lat":"0.3897139","long":"109.140438"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            318 => 
            array (
                'id' => '6105',
                'province_id' => '61',
                'name' => 'KABUPATEN SANGGAU',
                'meta' => '{"lat":"0.1400117","long":"110.5215459"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            319 => 
            array (
                'id' => '6106',
                'province_id' => '61',
                'name' => 'KABUPATEN KETAPANG',
                'meta' => '{"lat":"-1.5697615","long":"110.5215459"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            320 => 
            array (
                'id' => '6107',
                'province_id' => '61',
                'name' => 'KABUPATEN SINTANG',
                'meta' => '{"lat":"-0.1378068","long":"112.8105512"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            321 => 
            array (
                'id' => '6108',
                'province_id' => '61',
                'name' => 'KABUPATEN KAPUAS HULU',
                'meta' => '{"lat":"0.8336697","long":"113.0011989"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            322 => 
            array (
                'id' => '6109',
                'province_id' => '61',
                'name' => 'KABUPATEN SEKADAU',
                'meta' => '{"lat":"-0.0697175","long":"110.9983515"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            323 => 
            array (
                'id' => '6110',
                'province_id' => '61',
                'name' => 'KABUPATEN MELAWI',
                'meta' => '{"lat":"-0.7000681","long":"111.6660725"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            324 => 
            array (
                'id' => '6111',
                'province_id' => '61',
                'name' => 'KABUPATEN KAYONG UTARA',
                'meta' => '{"lat":"-0.9225877","long":"110.0449662"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            325 => 
            array (
                'id' => '6112',
                'province_id' => '61',
                'name' => 'KABUPATEN KUBU RAYA',
                'meta' => '{"lat":"-0.3533938","long":"109.4735066"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            326 => 
            array (
                'id' => '6171',
                'province_id' => '61',
                'name' => 'KOTA PONTIANAK',
                'meta' => '{"lat":"-0.0263303","long":"109.3425039"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            327 => 
            array (
                'id' => '6172',
                'province_id' => '61',
                'name' => 'KOTA SINGKAWANG',
                'meta' => '{"lat":"0.9060204","long":"108.9872049"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            328 => 
            array (
                'id' => '6201',
                'province_id' => '62',
                'name' => 'KABUPATEN KOTAWARINGIN BARAT',
                'meta' => '{"lat":"-2.5063419","long":"111.7614661"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            329 => 
            array (
                'id' => '6202',
                'province_id' => '62',
                'name' => 'KABUPATEN KOTAWARINGIN TIMUR',
                'meta' => '{"lat":"-2.1225475","long":"112.8105512"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            330 => 
            array (
                'id' => '6203',
                'province_id' => '62',
                'name' => 'KABUPATEN KAPUAS',
                'meta' => '{"lat":"-1.8116445","long":"114.3341432"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            331 => 
            array (
                'id' => '6204',
                'province_id' => '62',
                'name' => 'KABUPATEN BARITO SELATAN',
                'meta' => '{"lat":"-1.875943","long":"114.8092691"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            332 => 
            array (
                'id' => '6205',
                'province_id' => '62',
                'name' => 'KABUPATEN BARITO UTARA',
                'meta' => '{"lat":"-0.9587136","long":"115.094045"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            333 => 
            array (
                'id' => '6206',
                'province_id' => '62',
                'name' => 'KABUPATEN SUKAMARA',
                'meta' => '{"lat":"-2.6267517","long":"111.2368084"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            334 => 
            array (
                'id' => '6207',
                'province_id' => '62',
                'name' => 'KABUPATEN LAMANDAU',
                'meta' => '{"lat":"-1.8526377","long":"111.2845025"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            335 => 
            array (
                'id' => '6208',
                'province_id' => '62',
                'name' => 'KABUPATEN SERUYAN',
                'meta' => '{"lat":"-3.0123467","long":"112.4291464"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            336 => 
            array (
                'id' => '6209',
                'province_id' => '62',
                'name' => 'KABUPATEN KATINGAN',
                'meta' => '{"lat":"-0.9758379","long":"112.8105512"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            337 => 
            array (
                'id' => '6210',
                'province_id' => '62',
                'name' => 'KABUPATEN PULANG PISAU',
                'meta' => '{"lat":"-2.6849607","long":"113.9536466"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            338 => 
            array (
                'id' => '6211',
                'province_id' => '62',
                'name' => 'KABUPATEN GUNUNG MAS',
                'meta' => '{"lat":"-1.2522464","long":"113.5728501"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            339 => 
            array (
                'id' => '6212',
                'province_id' => '62',
                'name' => 'KABUPATEN BARITO TIMUR',
                'meta' => '{"lat":"-2.0123999","long":"115.188916"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            340 => 
            array (
                'id' => '6213',
                'province_id' => '62',
                'name' => 'KABUPATEN MURUNG RAYA',
                'meta' => '{"lat":"-0.1362171","long":"114.3341432"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            341 => 
            array (
                'id' => '6271',
                'province_id' => '62',
                'name' => 'KOTA PALANGKA RAYA',
                'meta' => '{"lat":"-2.2161048","long":"113.913977"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            342 => 
            array (
                'id' => '6301',
                'province_id' => '63',
                'name' => 'KABUPATEN TANAH LAUT',
                'meta' => '{"lat":"-3.7694047","long":"114.8092691"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            343 => 
            array (
                'id' => '6302',
                'province_id' => '63',
                'name' => 'KABUPATEN KOTA BARU',
                'meta' => '{"lat":"-3.0029841","long":"115.9467997"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            344 => 
            array (
                'id' => '6303',
                'province_id' => '63',
                'name' => 'KABUPATEN BANJAR',
                'meta' => '{"lat":"-3.3200228","long":"114.9991464"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            345 => 
            array (
                'id' => '6304',
                'province_id' => '63',
                'name' => 'KABUPATEN BARITO KUALA',
                'meta' => '{"lat":"-3.0714738","long":"114.6667939"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            346 => 
            array (
                'id' => '6305',
                'province_id' => '63',
                'name' => 'KABUPATEN TAPIN',
                'meta' => '{"lat":"-2.9160746","long":"115.0465991"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            347 => 
            array (
                'id' => '6306',
                'province_id' => '63',
                'name' => 'KABUPATEN HULU SUNGAI SELATAN',
                'meta' => '{"lat":"-2.7662681","long":"115.2363408"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            348 => 
            array (
                'id' => '6307',
                'province_id' => '63',
                'name' => 'KABUPATEN HULU SUNGAI TENGAH',
                'meta' => '{"lat":"-2.6153162","long":"115.5207358"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            349 => 
            array (
                'id' => '6308',
                'province_id' => '63',
                'name' => 'KABUPATEN HULU SUNGAI UTARA',
                'meta' => '{"lat":"-2.4421225","long":"115.188916"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            350 => 
            array (
                'id' => '6309',
                'province_id' => '63',
                'name' => 'KABUPATEN TABALONG',
                'meta' => '{"lat":"-1.864302","long":"115.5681084"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            351 => 
            array (
                'id' => '6310',
                'province_id' => '63',
                'name' => 'KABUPATEN TANAH BUMBU',
                'meta' => '{"lat":"-3.4512244","long":"115.5681084"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            352 => 
            array (
                'id' => '6311',
                'province_id' => '63',
                'name' => 'KABUPATEN BALANGAN',
                'meta' => '{"lat":"-2.3260425","long":"115.6154732"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            353 => 
            array (
                'id' => '6371',
                'province_id' => '63',
                'name' => 'KOTA BANJARMASIN',
                'meta' => '{"lat":"-3.3186067","long":"114.5943784"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            354 => 
            array (
                'id' => '6372',
                'province_id' => '63',
                'name' => 'KOTA BANJAR BARU',
                'meta' => '{"lat":"-3.4572422","long":"114.8103181"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            355 => 
            array (
                'id' => '6401',
                'province_id' => '64',
                'name' => 'KABUPATEN PASER',
                'meta' => '{"lat":"-1.7175266","long":"115.9467997"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            356 => 
            array (
                'id' => '6402',
                'province_id' => '64',
                'name' => 'KABUPATEN KUTAI BARAT',
                'meta' => '{"lat":"-0.4051796","long":"115.8521764"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            357 => 
            array (
                'id' => '6403',
                'province_id' => '64',
                'name' => 'KABUPATEN KUTAI KARTANEGARA',
                'meta' => '{"lat":"-0.1336655","long":"116.6081653"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            358 => 
            array (
                'id' => '6404',
                'province_id' => '64',
                'name' => 'KABUPATEN KUTAI TIMUR',
                'meta' => '{"lat":"0.9433774","long":"116.9852422"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            359 => 
            array (
                'id' => '6405',
                'province_id' => '64',
                'name' => 'KABUPATEN BERAU',
                'meta' => '{"lat":"2.0450883","long":"117.3616476"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            360 => 
            array (
                'id' => '6409',
                'province_id' => '64',
                'name' => 'KABUPATEN PENAJAM PASER UTARA',
                'meta' => '{"lat":"-1.2917094","long":"116.5137964"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            361 => 
            array (
                'id' => '6411',
                'province_id' => '64',
                'name' => 'KABUPATEN MAHAKAM HULU',
                'meta' => '{"lat":"0.9616678","long":"114.7142918"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            362 => 
            array (
                'id' => '6471',
                'province_id' => '64',
                'name' => 'KOTA BALIKPAPAN',
                'meta' => '{"lat":"-1.2379274","long":"116.8528526"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            363 => 
            array (
                'id' => '6472',
                'province_id' => '64',
                'name' => 'KOTA SAMARINDA',
                'meta' => '{"lat":"-0.5016166","long":"117.1264753"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            364 => 
            array (
                'id' => '6474',
                'province_id' => '64',
                'name' => 'KOTA BONTANG',
                'meta' => '{"lat":"0.120863","long":"117.4800445"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            365 => 
            array (
                'id' => '6501',
                'province_id' => '65',
                'name' => 'KABUPATEN MALINAU',
                'meta' => '{"lat":"3.0730929","long":"116.0413889"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            366 => 
            array (
                'id' => '6502',
                'province_id' => '65',
                'name' => 'KABUPATEN BULUNGAN',
                'meta' => '{"lat":"2.9042476","long":"116.9852422"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            367 => 
            array (
                'id' => '6503',
                'province_id' => '65',
                'name' => 'KABUPATEN TANA TIDUNG',
                'meta' => '{"lat":"3.551869","long":"117.0794082"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            368 => 
            array (
                'id' => '6504',
                'province_id' => '65',
                'name' => 'KABUPATEN NUNUKAN',
                'meta' => '{"lat":"4.0809649","long":"116.6081653"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            369 => 
            array (
                'id' => '6571',
                'province_id' => '65',
                'name' => 'KOTA TARAKAN',
                'meta' => '{"lat":"3.3273599","long":"117.5785049"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            370 => 
            array (
                'id' => '7101',
                'province_id' => '71',
                'name' => 'KABUPATEN BOLAANG MONGONDOW',
                'meta' => '{"lat":"0.6870994","long":"124.0641419"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            371 => 
            array (
                'id' => '7102',
                'province_id' => '71',
                'name' => 'KABUPATEN MINAHASA',
                'meta' => '{"lat":"1.2168837","long":"124.8182593"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            372 => 
            array (
                'id' => '7103',
                'province_id' => '71',
                'name' => 'KABUPATEN KEPULAUAN SANGIHE',
                'meta' => '{"lat":"3.6329172","long":"125.5000999"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            373 => 
            array (
                'id' => '7104',
                'province_id' => '71',
                'name' => 'KABUPATEN KEPULAUAN TALAUD',
                'meta' => '{"lat":"4.3066741","long":"126.8034921"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            374 => 
            array (
                'id' => '7105',
                'province_id' => '71',
                'name' => 'KABUPATEN MINAHASA SELATAN',
                'meta' => '{"lat":"1.0946773","long":"124.4641848"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            375 => 
            array (
                'id' => '7106',
                'province_id' => '71',
                'name' => 'KABUPATEN MINAHASA UTARA',
                'meta' => '{"lat":"1.5327973","long":"124.994751"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            376 => 
            array (
                'id' => '7107',
                'province_id' => '71',
                'name' => 'KABUPATEN BOLAANG MONGONDOW UTARA',
                'meta' => '{"lat":"0.9070359","long":"123.2657311"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            377 => 
            array (
                'id' => '7108',
                'province_id' => '71',
                'name' => 'KABUPATEN SIAU TAGULANDANG BIARO',
                'meta' => '{"lat":"2.345964","long":"125.4124355"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            378 => 
            array (
                'id' => '7109',
                'province_id' => '71',
                'name' => 'KABUPATEN MINAHASA TENGGARA',
                'meta' => '{"lat":"1.0278551","long":"124.7298765"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            379 => 
            array (
                'id' => '7110',
                'province_id' => '71',
                'name' => 'KABUPATEN BOLAANG MONGONDOW SELATAN',
                'meta' => '{"lat":"0.4053215","long":"123.8411288"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            380 => 
            array (
                'id' => '7111',
                'province_id' => '71',
                'name' => 'KABUPATEN BOLAANG MONGONDOW TIMUR',
                'meta' => '{"lat":"0.7152651","long":"124.4641848"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            381 => 
            array (
                'id' => '7171',
                'province_id' => '71',
                'name' => 'KOTA MANADO',
                'meta' => '{"lat":"1.4748305","long":"124.8420794"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            382 => 
            array (
                'id' => '7172',
                'province_id' => '71',
                'name' => 'KOTA BITUNG',
                'meta' => '{"lat":"1.4403744","long":"125.1216524"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            383 => 
            array (
                'id' => '7173',
                'province_id' => '71',
                'name' => 'KOTA TOMOHON',
                'meta' => '{"lat":"1.3229337","long":"124.8405081"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            384 => 
            array (
                'id' => '7174',
                'province_id' => '71',
                'name' => 'KOTA KOTAMOBAGU',
                'meta' => '{"lat":"0.7243733","long":"124.3199316"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            385 => 
            array (
                'id' => '7201',
                'province_id' => '72',
                'name' => 'KABUPATEN BANGGAI KEPULAUAN',
                'meta' => '{"lat":"-1.3075939","long":"123.0338767"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            386 => 
            array (
                'id' => '7202',
                'province_id' => '72',
                'name' => 'KABUPATEN BANGGAI',
                'meta' => '{"lat":"-0.956178","long":"122.6277455"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            387 => 
            array (
                'id' => '7203',
                'province_id' => '72',
                'name' => 'KABUPATEN MOROWALI',
                'meta' => '{"lat":"-2.6987231","long":"121.9017954"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            388 => 
            array (
                'id' => '7204',
                'province_id' => '72',
                'name' => 'KABUPATEN POSO',
                'meta' => '{"lat":"-1.6468883","long":"120.4357631"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            389 => 
            array (
                'id' => '7205',
                'province_id' => '72',
                'name' => 'KABUPATEN DONGGALA',
                'meta' => '{"lat":"-0.4233155","long":"119.8352303"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            390 => 
            array (
                'id' => '7206',
                'province_id' => '72',
                'name' => 'KABUPATEN TOLI-TOLI',
                'meta' => '{"lat":"0.8768231","long":"120.7579834"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            391 => 
            array (
                'id' => '7207',
                'province_id' => '72',
                'name' => 'KABUPATEN BUOL',
                'meta' => '{"lat":"0.9695452","long":"121.3541631"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            392 => 
            array (
                'id' => '7208',
                'province_id' => '72',
                'name' => 'KABUPATEN PARIGI MOUTONG',
                'meta' => '{"lat":"0.5817607","long":"120.8039474"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            393 => 
            array (
                'id' => '7209',
                'province_id' => '72',
                'name' => 'KABUPATEN TOJO UNA-UNA',
                'meta' => '{"lat":"-1.098757","long":"121.5370003"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            394 => 
            array (
                'id' => '7210',
                'province_id' => '72',
                'name' => 'KABUPATEN SIGI',
                'meta' => '{"lat":"-1.3859904","long":"119.8815203"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            395 => 
            array (
                'id' => '7211',
                'province_id' => '72',
                'name' => 'KABUPATEN BANGGAI LAUT',
                'meta' => '{"lat":"-1.6734525","long":"123.5504076"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            396 => 
            array (
                'id' => '7212',
                'province_id' => '72',
                'name' => 'KABUPATEN MOROWALI UTARA',
                'meta' => '{"lat":"-1.6311761","long":"121.3541631"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            397 => 
            array (
                'id' => '7271',
                'province_id' => '72',
                'name' => 'KOTA PALU',
                'meta' => '{"lat":"-0.9002915","long":"119.8779987"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            398 => 
            array (
                'id' => '7301',
                'province_id' => '73',
                'name' => 'KABUPATEN KEPULAUAN SELAYAR',
                'meta' => '{"lat":"-6.2869786","long":"120.5048792"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            399 => 
            array (
                'id' => '7302',
                'province_id' => '73',
                'name' => 'KABUPATEN BULUKUMBA',
                'meta' => '{"lat":"-5.4329368","long":"120.2051096"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            400 => 
            array (
                'id' => '7303',
                'province_id' => '73',
                'name' => 'KABUPATEN BANTAENG',
                'meta' => '{"lat":"-5.5169316","long":"120.0202964"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            401 => 
            array (
                'id' => '7304',
                'province_id' => '73',
                'name' => 'KABUPATEN JENEPONTO',
                'meta' => '{"lat":"-5.554579","long":"119.6730939"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            402 => 
            array (
                'id' => '7305',
                'province_id' => '73',
                'name' => 'KABUPATEN TAKALAR',
                'meta' => '{"lat":"-5.4162493","long":"119.4875668"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            403 => 
            array (
                'id' => '7306',
                'province_id' => '73',
                'name' => 'KABUPATEN GOWA',
                'meta' => '{"lat":"-5.3102888","long":"119.742604"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            404 => 
            array (
                'id' => '7307',
                'province_id' => '73',
                'name' => 'KABUPATEN SINJAI',
                'meta' => '{"lat":"-5.2171961","long":"120.112735"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            405 => 
            array (
                'id' => '7308',
                'province_id' => '73',
                'name' => 'KABUPATEN MAROS',
                'meta' => '{"lat":"-5.0549145","long":"119.6962677"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            406 => 
            array (
                'id' => '7309',
                'province_id' => '73',
                'name' => 'KABUPATEN PANGKAJENE DAN KEPULAUAN',
                'meta' => '{"lat":"-4.805035","long":"119.5571677"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            407 => 
            array (
                'id' => '7310',
                'province_id' => '73',
                'name' => 'KABUPATEN BARRU',
                'meta' => '{"lat":"-4.436417","long":"119.6499162"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            408 => 
            array (
                'id' => '7311',
                'province_id' => '73',
                'name' => 'KABUPATEN BONE',
                'meta' => '{"lat":"-4.7443383","long":"120.0665236"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            409 => 
            array (
                'id' => '7312',
                'province_id' => '73',
                'name' => 'KABUPATEN SOPPENG',
                'meta' => '{"lat":"-4.3518541","long":"119.9277947"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            410 => 
            array (
                'id' => '7313',
                'province_id' => '73',
                'name' => 'KABUPATEN WAJO',
                'meta' => '{"lat":"-4.022229","long":"120.0665236"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            411 => 
            array (
                'id' => '7314',
                'province_id' => '73',
                'name' => 'KABUPATEN SIDENRENG RAPPANG',
                'meta' => '{"lat":"-3.7738981","long":"120.0202964"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            412 => 
            array (
                'id' => '7315',
                'province_id' => '73',
                'name' => 'KABUPATEN PINRANG',
                'meta' => '{"lat":"-3.6483486","long":"119.5571677"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            413 => 
            array (
                'id' => '7316',
                'province_id' => '73',
                'name' => 'KABUPATEN ENREKANG',
                'meta' => '{"lat":"-3.4590744","long":"119.8815203"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            414 => 
            array (
                'id' => '7317',
                'province_id' => '73',
                'name' => 'KABUPATEN LUWU',
                'meta' => '{"lat":"-3.3052214","long":"120.2512728"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            415 => 
            array (
                'id' => '7318',
                'province_id' => '73',
                'name' => 'KABUPATEN TANA TORAJA',
                'meta' => '{"lat":"-3.0753003","long":"119.742604"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            416 => 
            array (
                'id' => '7322',
                'province_id' => '73',
                'name' => 'KABUPATEN LUWU UTARA',
                'meta' => '{"lat":"-2.2690446","long":"119.9740534"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            417 => 
            array (
                'id' => '7325',
                'province_id' => '73',
                'name' => 'KABUPATEN LUWU TIMUR',
                'meta' => '{"lat":"-2.5825518","long":"121.1710389"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            418 => 
            array (
                'id' => '7326',
                'province_id' => '73',
                'name' => 'KABUPATEN TORAJA UTARA',
                'meta' => '{"lat":"-2.8621942","long":"119.8352303"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            419 => 
            array (
                'id' => '7371',
                'province_id' => '73',
                'name' => 'KOTA MAKASSAR',
                'meta' => '{"lat":"-5.1476651","long":"119.4327314"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            420 => 
            array (
                'id' => '7372',
                'province_id' => '73',
                'name' => 'KOTA PAREPARE',
                'meta' => '{"lat":"-4.0096221","long":"119.6290617"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            421 => 
            array (
                'id' => '7373',
                'province_id' => '73',
                'name' => 'KOTA PALOPO',
                'meta' => '{"lat":"-3.0016343","long":"120.1985141"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            422 => 
            array (
                'id' => '7401',
                'province_id' => '74',
                'name' => 'KABUPATEN BUTON',
                'meta' => '{"lat":"-5.3096355","long":"122.9888319"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            423 => 
            array (
                'id' => '7402',
                'province_id' => '74',
                'name' => 'KABUPATEN MUNA',
                'meta' => '{"lat":"-4.901629","long":"122.6277455"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            424 => 
            array (
                'id' => '7403',
                'province_id' => '74',
                'name' => 'KABUPATEN KONAWE',
                'meta' => '{"lat":"-3.9380432","long":"122.0837445"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            425 => 
            array (
                'id' => '7404',
                'province_id' => '74',
                'name' => 'KABUPATEN KOLAKA',
                'meta' => '{"lat":"-3.9946988","long":"121.5826642"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            426 => 
            array (
                'id' => '7405',
                'province_id' => '74',
                'name' => 'KABUPATEN KONAWE SELATAN',
                'meta' => '{"lat":"-4.2027915","long":"122.4467238"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            427 => 
            array (
                'id' => '7406',
                'province_id' => '74',
                'name' => 'KABUPATEN BOMBANA',
                'meta' => '{"lat":"-4.6543462","long":"121.9017954"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            428 => 
            array (
                'id' => '7407',
                'province_id' => '74',
                'name' => 'KABUPATEN WAKATOBI',
                'meta' => '{"lat":"-5.6326806","long":"123.8902463"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            429 => 
            array (
                'id' => '7408',
                'province_id' => '74',
                'name' => 'KABUPATEN KOLAKA UTARA',
                'meta' => '{"lat":"-3.1347227","long":"121.1710389"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            430 => 
            array (
                'id' => '7409',
                'province_id' => '74',
                'name' => 'KABUPATEN BUTON UTARA',
                'meta' => '{"lat":"-4.7023424","long":"123.0338767"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            431 => 
            array (
                'id' => '7410',
                'province_id' => '74',
                'name' => 'KABUPATEN KONAWE UTARA',
                'meta' => '{"lat":"-3.3803291","long":"122.0837445"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            432 => 
            array (
                'id' => '7411',
                'province_id' => '74',
                'name' => 'KABUPATEN KOLAKA TIMUR',
                'meta' => '{"lat":"-4.2279225","long":"121.9017954"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            433 => 
            array (
                'id' => '7412',
                'province_id' => '74',
                'name' => 'KABUPATEN KONAWE KEPULAUAN',
                'meta' => '{"lat":"-4.1361465","long":"123.1239049"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            434 => 
            array (
                'id' => '7413',
                'province_id' => '74',
                'name' => 'KABUPATEN MUNA BARAT',
                'meta' => '{"lat":"-4.901629","long":"122.6277455"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            435 => 
            array (
                'id' => '7414',
                'province_id' => '74',
                'name' => 'KABUPATEN BUTON TENGAH',
                'meta' => '{"lat":"-5.2891405","long":"122.424074"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            436 => 
            array (
                'id' => '7415',
                'province_id' => '74',
                'name' => 'KABUPATEN BUTON SELATAN',
                'meta' => '{"lat":"-5.3096355","long":"122.9888319"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            437 => 
            array (
                'id' => '7471',
                'province_id' => '74',
                'name' => 'KOTA KENDARI',
                'meta' => '{"lat":"-3.9984597","long":"122.5129742"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            438 => 
            array (
                'id' => '7472',
                'province_id' => '74',
                'name' => 'KOTA BAUBAU',
                'meta' => '{"lat":"-5.507078","long":"122.596901"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            439 => 
            array (
                'id' => '7501',
                'province_id' => '75',
                'name' => 'KABUPATEN BOALEMO',
                'meta' => '{"lat":"0.7013419","long":"122.2653887"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            440 => 
            array (
                'id' => '7502',
                'province_id' => '75',
                'name' => 'KABUPATEN GORONTALO',
                'meta' => '{"lat":"0.5692733","long":"122.8084496"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            441 => 
            array (
                'id' => '7503',
                'province_id' => '75',
                'name' => 'KABUPATEN POHUWATO',
                'meta' => '{"lat":"0.7055278","long":"121.7195459"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            442 => 
            array (
                'id' => '7504',
                'province_id' => '75',
                'name' => 'KABUPATEN BONE BOLANGO',
                'meta' => '{"lat":"0.5657885","long":"123.3486147"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            443 => 
            array (
                'id' => '7505',
                'province_id' => '75',
                'name' => 'KABUPATEN GORONTALO UTARA',
                'meta' => '{"lat":"0.9252647","long":"122.4920088"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            444 => 
            array (
                'id' => '7571',
                'province_id' => '75',
                'name' => 'KOTA GORONTALO',
                'meta' => '{"lat":"0.5435442","long":"123.0567693"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            445 => 
            array (
                'id' => '7601',
                'province_id' => '76',
                'name' => 'KABUPATEN MAJENE',
                'meta' => '{"lat":"-3.0297251","long":"118.9062794"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            446 => 
            array (
                'id' => '7602',
                'province_id' => '76',
                'name' => 'KABUPATEN POLEWALI MANDAR',
                'meta' => '{"lat":"-3.3419323","long":"119.1390642"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            447 => 
            array (
                'id' => '7603',
                'province_id' => '76',
                'name' => 'KABUPATEN MAMASA',
                'meta' => '{"lat":"-2.9118209","long":"119.3250347"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            448 => 
            array (
                'id' => '7604',
                'province_id' => '76',
                'name' => 'KABUPATEN MAMUJU',
                'meta' => '{"lat":"-2.4920057","long":"119.3250347"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            449 => 
            array (
                'id' => '7605',
                'province_id' => '76',
                'name' => 'KABUPATEN MAMUJU UTARA',
                'meta' => '{"lat":"-1.5264542","long":"119.5107708"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            450 => 
            array (
                'id' => '7606',
                'province_id' => '76',
                'name' => 'KABUPATEN MAMUJU TENGAH',
                'meta' => '{"lat":"-1.9354109","long":"119.5107708"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            451 => 
            array (
                'id' => '8101',
                'province_id' => '81',
                'name' => 'KABUPATEN MALUKU TENGGARA BARAT',
                'meta' => '{"lat":"-7.5322642","long":"131.3611121"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            452 => 
            array (
                'id' => '8102',
                'province_id' => '81',
                'name' => 'KABUPATEN MALUKU TENGGARA',
                'meta' => '{"lat":"-5.7512455","long":"132.7271587"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            453 => 
            array (
                'id' => '8103',
                'province_id' => '81',
                'name' => 'KABUPATEN MALUKU TENGAH',
                'meta' => '{"lat":"-3.0166501","long":"129.4864411"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            454 => 
            array (
                'id' => '8104',
                'province_id' => '81',
                'name' => 'KABUPATEN BURU',
                'meta' => '{"lat":"-3.3307379","long":"126.6957216"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            455 => 
            array (
                'id' => '8105',
                'province_id' => '81',
                'name' => 'KABUPATEN KEPULAUAN ARU',
                'meta' => '{"lat":"-6.2067294","long":"134.4718394"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            456 => 
            array (
                'id' => '8106',
                'province_id' => '81',
                'name' => 'KABUPATEN SERAM BAGIAN BARAT',
                'meta' => '{"lat":"-3.1271575","long":"128.4008357"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            457 => 
            array (
                'id' => '8107',
                'province_id' => '81',
                'name' => 'KABUPATEN SERAM BAGIAN TIMUR',
                'meta' => '{"lat":"-3.4233267","long":"130.2271243"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            458 => 
            array (
                'id' => '8108',
                'province_id' => '81',
                'name' => 'KABUPATEN MALUKU BARAT DAYA',
                'meta' => '{"lat":"-7.7851588","long":"126.3498097"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            459 => 
            array (
                'id' => '8109',
                'province_id' => '81',
                'name' => 'KABUPATEN BURU SELATAN',
                'meta' => '{"lat":"-3.7273972","long":"126.6957216"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            460 => 
            array (
                'id' => '8171',
                'province_id' => '81',
                'name' => 'KOTA AMBON',
                'meta' => '{"lat":"-3.6386665","long":"128.1688559"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            461 => 
            array (
                'id' => '8172',
                'province_id' => '81',
                'name' => 'KOTA TUAL',
                'meta' => '{"lat":"-5.626563","long":"132.7520867"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            462 => 
            array (
                'id' => '8201',
                'province_id' => '82',
                'name' => 'KABUPATEN HALMAHERA BARAT',
                'meta' => '{"lat":"1.3589663","long":"127.5960704"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            463 => 
            array (
                'id' => '8202',
                'province_id' => '82',
                'name' => 'KABUPATEN HALMAHERA TENGAH',
                'meta' => '{"lat":"0.4419543","long":"128.3587174"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            464 => 
            array (
                'id' => '8203',
                'province_id' => '82',
                'name' => 'KABUPATEN KEPULAUAN SULA',
                'meta' => '{"lat":"-1.8321222","long":"125.958777"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            465 => 
            array (
                'id' => '8204',
                'province_id' => '82',
                'name' => 'KABUPATEN HALMAHERA SELATAN',
                'meta' => '{"lat":"-1.5109015","long":"127.7237678"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            466 => 
            array (
                'id' => '8205',
                'province_id' => '82',
                'name' => 'KABUPATEN HALMAHERA UTARA',
                'meta' => '{"lat":"1.5074308","long":"127.8936663"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            467 => 
            array (
                'id' => '8206',
                'province_id' => '82',
                'name' => 'KABUPATEN HALMAHERA TIMUR',
                'meta' => '{"lat":"1.3121235","long":"128.4849923"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            468 => 
            array (
                'id' => '8207',
                'province_id' => '82',
                'name' => 'KABUPATEN PULAU MOROTAI',
                'meta' => '{"lat":"2.3656672","long":"128.4008357"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            469 => 
            array (
                'id' => '8208',
                'province_id' => '82',
                'name' => 'KABUPATEN PULAU TALIABU',
                'meta' => '{"lat":"-1.8268344","long":"124.7740793"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            470 => 
            array (
                'id' => '8271',
                'province_id' => '82',
                'name' => 'KOTA TERNATE',
                'meta' => '{"lat":"0.7957999","long":"127.3613533"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            471 => 
            array (
                'id' => '8272',
                'province_id' => '82',
                'name' => 'KOTA TIDORE KEPULAUAN',
                'meta' => '{"lat":"0.6740044","long":"127.4040871"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            472 => 
            array (
                'id' => '9101',
                'province_id' => '91',
                'name' => 'KABUPATEN FAKFAK',
                'meta' => '{"lat":"-3.097706","long":"133.0194897"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            473 => 
            array (
                'id' => '9102',
                'province_id' => '91',
                'name' => 'KABUPATEN KAIMANA',
                'meta' => '{"lat":"-3.288406","long":"133.9436788"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            474 => 
            array (
                'id' => '9103',
                'province_id' => '91',
                'name' => 'KABUPATEN TELUK WONDAMA',
                'meta' => '{"lat":"-2.8551699","long":"134.3236557"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            475 => 
            array (
                'id' => '9104',
                'province_id' => '91',
                'name' => 'KABUPATEN TELUK BINTUNI',
                'meta' => '{"lat":"-1.9056848","long":"133.329466"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            476 => 
            array (
                'id' => '9105',
                'province_id' => '91',
                'name' => 'KABUPATEN MANOKWARI',
                'meta' => '{"lat":"-0.8614531","long":"134.0620421"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            477 => 
            array (
                'id' => '9106',
                'province_id' => '91',
                'name' => 'KABUPATEN SORONG SELATAN',
                'meta' => '{"lat":"-1.7657744","long":"132.1572702"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            478 => 
            array (
                'id' => '9107',
                'province_id' => '91',
                'name' => 'KABUPATEN SORONG',
                'meta' => '{"lat":"-1.1223204","long":"131.4883373"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            479 => 
            array (
                'id' => '9108',
                'province_id' => '91',
                'name' => 'KABUPATEN RAJA AMPAT',
                'meta' => '{"lat":"-1.0915151","long":"130.8778586"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            480 => 
            array (
                'id' => '9109',
                'province_id' => '91',
                'name' => 'KABUPATEN TAMBRAUW',
                'meta' => '{"lat":"-0.781856","long":"132.3938375"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            481 => 
            array (
                'id' => '9110',
                'province_id' => '91',
                'name' => 'KABUPATEN MAYBRAT',
                'meta' => '{"lat":"-1.2970979","long":"132.3150993"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            482 => 
            array (
                'id' => '9111',
                'province_id' => '91',
                'name' => 'KABUPATEN MANOKWARI SELATAN',
                'meta' => '{"lat":"-0.9135107","long":"134.0008674"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            483 => 
            array (
                'id' => '9112',
                'province_id' => '91',
                'name' => 'KABUPATEN PEGUNUNGAN ARFAK',
                'meta' => '{"lat":"-1.1554562","long":"133.7142484"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            484 => 
            array (
                'id' => '9171',
                'province_id' => '91',
                'name' => 'KOTA SORONG',
                'meta' => '{"lat":"-0.8761629","long":"131.255828"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            485 => 
            array (
                'id' => '9401',
                'province_id' => '94',
                'name' => 'KABUPATEN MERAUKE',
                'meta' => '{"lat":"-7.7838334","long":"139.041312"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            486 => 
            array (
                'id' => '9402',
                'province_id' => '94',
                'name' => 'KABUPATEN JAYAWIJAYA',
                'meta' => '{"lat":"-4.0004481","long":"138.7995122"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            487 => 
            array (
                'id' => '9403',
                'province_id' => '94',
                'name' => 'KABUPATEN JAYAPURA',
                'meta' => '{"lat":"-2.987923","long":"139.8547266"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            488 => 
            array (
                'id' => '9404',
                'province_id' => '94',
                'name' => 'KABUPATEN NABIRE',
                'meta' => '{"lat":"-3.5095462","long":"135.7520985"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            489 => 
            array (
                'id' => '9408',
                'province_id' => '94',
                'name' => 'KABUPATEN KEPULAUAN YAPEN',
                'meta' => '{"lat":"-1.7469359","long":"136.1709012"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            490 => 
            array (
                'id' => '9409',
                'province_id' => '94',
                'name' => 'KABUPATEN BIAK NUMFOR',
                'meta' => '{"lat":"-1.0381022","long":"135.9800848"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            491 => 
            array (
                'id' => '9410',
                'province_id' => '94',
                'name' => 'KABUPATEN PANIAI',
                'meta' => '{"lat":"-3.7876441","long":"136.3624686"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            492 => 
            array (
                'id' => '9411',
                'province_id' => '94',
                'name' => 'KABUPATEN PUNCAK JAYA',
                'meta' => '{"lat":"-3.4467891","long":"137.8427298"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            493 => 
            array (
                'id' => '9412',
                'province_id' => '94',
                'name' => 'KABUPATEN MIMIKA',
                'meta' => '{"lat":"-4.4553223","long":"137.1362125"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            494 => 
            array (
                'id' => '9413',
                'province_id' => '94',
                'name' => 'KABUPATEN BOVEN DIGOEL',
                'meta' => '{"lat":"-5.7400018","long":"140.3481835"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            495 => 
            array (
                'id' => '9414',
                'province_id' => '94',
                'name' => 'KABUPATEN MAPPI',
                'meta' => '{"lat":"-6.7606468","long":"139.6911374"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            496 => 
            array (
                'id' => '9415',
                'province_id' => '94',
                'name' => 'KABUPATEN ASMAT',
                'meta' => '{"lat":"-5.0573958","long":"138.3988186"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            497 => 
            array (
                'id' => '9416',
                'province_id' => '94',
                'name' => 'KABUPATEN YAHUKIMO',
                'meta' => '{"lat":"-4.4939717","long":"139.5279996"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            498 => 
            array (
                'id' => '9417',
                'province_id' => '94',
                'name' => 'KABUPATEN PEGUNUNGAN BINTANG',
                'meta' => '{"lat":"-4.5589872","long":"140.5135589"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            499 => 
            array (
                'id' => '9418',
                'province_id' => '94',
                'name' => 'KABUPATEN TOLIKARA',
                'meta' => '{"lat":"-3.481132","long":"138.4787258"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
        ));
        DB::table('indonesia_cities')->insert(array (
            0 => 
            array (
                'id' => '9419',
                'province_id' => '94',
                'name' => 'KABUPATEN SARMI',
                'meta' => '{"lat":"-2.4678144","long":"139.2030851"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            1 => 
            array (
                'id' => '9420',
                'province_id' => '94',
                'name' => 'KABUPATEN KEEROM',
                'meta' => '{"lat":"-3.3449536","long":"140.7624493"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            2 => 
            array (
                'id' => '9426',
                'province_id' => '94',
                'name' => 'KABUPATEN WAROPEN',
                'meta' => '{"lat":"-2.8435717","long":"136.670534"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            3 => 
            array (
                'id' => '9427',
                'province_id' => '94',
                'name' => 'KABUPATEN SUPIORI',
                'meta' => '{"lat":"-0.7295099","long":"135.6385125"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            4 => 
            array (
                'id' => '9428',
                'province_id' => '94',
                'name' => 'KABUPATEN MAMBERAMO RAYA',
                'meta' => '{"lat":"-2.5331255","long":"137.7637565"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            5 => 
            array (
                'id' => '9429',
                'province_id' => '94',
                'name' => 'KABUPATEN NDUGA',
                'meta' => '{"lat":"-4.4069496","long":"138.2393528"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            6 => 
            array (
                'id' => '9430',
                'province_id' => '94',
                'name' => 'KABUPATEN LANNY JAYA',
                'meta' => '{"lat":"-3.971033","long":"138.3190276"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            7 => 
            array (
                'id' => '9431',
                'province_id' => '94',
                'name' => 'KABUPATEN MAMBERAMO TENGAH',
                'meta' => '{"lat":"-2.3745692","long":"138.3190276"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            8 => 
            array (
                'id' => '9432',
                'province_id' => '94',
                'name' => 'KABUPATEN YALIMO',
                'meta' => '{"lat":"-3.7852847","long":"139.4466005"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            9 => 
            array (
                'id' => '9433',
                'province_id' => '94',
                'name' => 'KABUPATEN PUNCAK',
                'meta' => '{"lat":"-3.8649098","long":"137.6061625"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            10 => 
            array (
                'id' => '9434',
                'province_id' => '94',
                'name' => 'KABUPATEN DOGIYAI',
                'meta' => '{"lat":"-4.0454139","long":"135.6763443"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            11 => 
            array (
                'id' => '9435',
                'province_id' => '94',
                'name' => 'KABUPATEN INTAN JAYA',
                'meta' => '{"lat":"-3.5076422","long":"136.7478493"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            12 => 
            array (
                'id' => '9436',
                'province_id' => '94',
                'name' => 'KABUPATEN DEIYAI',
                'meta' => '{"lat":"-4.0974893","long":"136.4393054"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            13 => 
            array (
                'id' => '9471',
                'province_id' => '94',
                'name' => 'KOTA JAYAPURA',
                'meta' => '{"lat":"-2.5916025","long":"140.6689995"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
        ));
        
        
    }
}