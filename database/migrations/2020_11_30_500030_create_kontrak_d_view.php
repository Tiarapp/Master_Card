<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateKontrakDView extends Migration 
{
    public function up()
    {
        DB::statement("CREATE VIEW kontrak_d_view AS SELECT 
                       kd.id,
                       km.tgl_kontrak,
                       km.no_kontrak,
                       kd.item_bj_id as kode_item,
                       bj.nama as nama_item,
                       kd.tipeOrder as tipe_order,
                       mc.id as mc_id,
                       mc.lebar_sheet_box,
                       mc.panjang_sheet_box,
                       mc.tinggi_sheet_box,
                       mc.flute,
                       mc.tipe_box,
                       mc.tipe_creas_corr,
                       mc.substance_kontrak,
                       mc.substance_produksi,
                       mc.warna,
                       mc.wax,
                       mc.joint,
                       mc.koli,
                       mc.bungkus,
                       mc.keterangan,
                       kd.inExTax as include_exclude_tax,
                       kd.harga,
                       mu.nama as mata_uang,
                       kd.pcsKontrak as pcs_kontrak,
                       mc.gram_sheet_box,
                       kd.kgKontrak as kg_kontrak,
                       kd.pctToleransiKontrak as persen_tol_kontrak,
                       kd.pcsToleransiKontrak as pcs_tol_kontrak,
                       kd.mcPelengkap
                       FROM kontrak_d as kd
                       LEFT JOIN kontrak_m_view as km ON kd.kontrak_m_id = km.id
                       LEFT JOIN item_bj as bj ON kd.item_bj_id = bj.id
                       LEFT JOIN mc_view as mc ON kd.mc_id = mc.id
                       LEFT JOIN mata_uang as mu ON kd.mataUang = mu.id
                    ");
    }
    public function down()
    {
        DB::statement("DROP VIEW kontrak_d_view");
    }  
}