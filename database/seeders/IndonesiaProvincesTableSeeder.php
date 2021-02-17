<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class IndonesiaProvincesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('indonesia_provinces')->delete();
        
        \DB::table('indonesia_provinces')->insert(array (
            0 => 
            array (
                'id' => '11',
                'name' => 'ACEH',
                'meta' => '{"lat":"4.695135","long":"96.7493993"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            1 => 
            array (
                'id' => '12',
                'name' => 'SUMATERA UTARA',
                'meta' => '{"lat":"2.1153547","long":"99.5450974"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            2 => 
            array (
                'id' => '13',
                'name' => 'SUMATERA BARAT',
                'meta' => '{"lat":"-0.7399397","long":"100.8000051"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            3 => 
            array (
                'id' => '14',
                'name' => 'RIAU',
                'meta' => '{"lat":"0.2933469","long":"101.7068294"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            4 => 
            array (
                'id' => '15',
                'name' => 'JAMBI',
                'meta' => '{"lat":"-1.6101229","long":"103.6131203"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            5 => 
            array (
                'id' => '16',
                'name' => 'SUMATERA SELATAN',
                'meta' => '{"lat":"-3.3194374","long":"103.914399"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            6 => 
            array (
                'id' => '17',
                'name' => 'BENGKULU',
                'meta' => '{"lat":"-3.7928451","long":"102.2607641"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            7 => 
            array (
                'id' => '18',
                'name' => 'LAMPUNG',
                'meta' => '{"lat":"-4.5585849","long":"105.4068079"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            8 => 
            array (
                'id' => '19',
                'name' => 'KEPULAUAN BANGKA BELITUNG',
                'meta' => '{"lat":"-2.7410513","long":"106.4405872"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            9 => 
            array (
                'id' => '21',
                'name' => 'KEPULAUAN RIAU',
                'meta' => '{"lat":"3.9456514","long":"108.1428669"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            10 => 
            array (
                'id' => '31',
                'name' => 'DKI JAKARTA',
                'meta' => '{"lat":"-6.2087634","long":"106.845599"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            11 => 
            array (
                'id' => '32',
                'name' => 'JAWA BARAT',
                'meta' => '{"lat":"-7.090911","long":"107.668887"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            12 => 
            array (
                'id' => '33',
                'name' => 'JAWA TENGAH',
                'meta' => '{"lat":"-7.150975","long":"110.1402594"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            13 => 
            array (
                'id' => '34',
                'name' => 'DI YOGYAKARTA',
                'meta' => '{"lat":"-7.8753849","long":"110.4262088"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            14 => 
            array (
                'id' => '35',
                'name' => 'JAWA TIMUR',
                'meta' => '{"lat":"-7.5360639","long":"112.2384017"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            15 => 
            array (
                'id' => '36',
                'name' => 'BANTEN',
                'meta' => '{"lat":"-6.4058172","long":"106.0640179"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            16 => 
            array (
                'id' => '51',
                'name' => 'BALI',
                'meta' => '{"lat":"-8.3405389","long":"115.0919509"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            17 => 
            array (
                'id' => '52',
                'name' => 'NUSA TENGGARA BARAT',
                'meta' => '{"lat":"-8.6529334","long":"117.3616476"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            18 => 
            array (
                'id' => '53',
                'name' => 'NUSA TENGGARA TIMUR',
                'meta' => '{"lat":"-8.6573819","long":"121.0793705"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            19 => 
            array (
                'id' => '61',
                'name' => 'KALIMANTAN BARAT',
                'meta' => '{"lat":"-0.2787808","long":"111.4752851"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            20 => 
            array (
                'id' => '62',
                'name' => 'KALIMANTAN TENGAH',
                'meta' => '{"lat":"-1.6814878","long":"113.3823545"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            21 => 
            array (
                'id' => '63',
                'name' => 'KALIMANTAN SELATAN',
                'meta' => '{"lat":"-3.0926415","long":"115.2837585"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            22 => 
            array (
                'id' => '64',
                'name' => 'KALIMANTAN TIMUR',
                'meta' => '{"lat":"0.5386586","long":"116.419389"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            23 => 
            array (
                'id' => '65',
                'name' => 'KALIMANTAN UTARA',
                'meta' => '{"lat":"3.0730929","long":"116.0413889"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            24 => 
            array (
                'id' => '71',
                'name' => 'SULAWESI UTARA',
                'meta' => '{"lat":"0.6246932","long":"123.9750018"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            25 => 
            array (
                'id' => '72',
                'name' => 'SULAWESI TENGAH',
                'meta' => '{"lat":"-1.4300254","long":"121.4456179"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            26 => 
            array (
                'id' => '73',
                'name' => 'SULAWESI SELATAN',
                'meta' => '{"lat":"-3.6687994","long":"119.9740534"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            27 => 
            array (
                'id' => '74',
                'name' => 'SULAWESI TENGGARA',
                'meta' => '{"lat":"-4.14491","long":"122.174605"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            28 => 
            array (
                'id' => '75',
                'name' => 'GORONTALO',
                'meta' => '{"lat":"0.5435442","long":"123.0567693"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            29 => 
            array (
                'id' => '76',
                'name' => 'SULAWESI BARAT',
                'meta' => '{"lat":"-2.8441371","long":"119.2320784"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            30 => 
            array (
                'id' => '81',
                'name' => 'MALUKU',
                'meta' => '{"lat":"-2.8646166","long":"129.5765974"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            31 => 
            array (
                'id' => '82',
                'name' => 'MALUKU UTARA',
                'meta' => '{"lat":"1.5709993","long":"127.8087693"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            32 => 
            array (
                'id' => '91',
                'name' => 'PAPUA BARAT',
                'meta' => '{"lat":"-1.3361154","long":"133.1747162"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
            33 => 
            array (
                'id' => '94',
                'name' => 'PAPUA',
                'meta' => '{"lat":"-4.269928","long":"138.0803529"}',
                'created_at' => '2021-02-16 02:03:57',
                'updated_at' => '2021-02-16 02:03:57',
            ),
        ));
        
        
    }
}