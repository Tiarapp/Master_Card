<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateOpiMView extends Migration 
{
    public function up()
    {
        DB::statement("CREATE VIEW opi_m_view AS SELECT 
                        opi_m.id,
                        opi_m.kode,
                        opi_m.nama,
                        opi_m.dt_id,
                        dt.tipe_order,
                        dt.tgl_kontrak,
                        dt.tgl_input as tgl_dt,
                        opi_m.created_at as tgl_opi,
                        dt.no_kontrak,
                        dt.mc_id,
                        dt.po_customer,
                        dt.nama_customer,
                        km.alamat_kirim,
                        dt.tgl_kirim_dt,
                        dt.hari_kirim_dt,
                        dt.keterangan as keterangan_mc,
                        opi_m.keterangan as keterangan_ppic,
                        dt.pcs_dt,
                        dt.gram_sheet_box,
                        dt.kg_dt,
                        kd.persen_tol_kontrak,
                        kd.pcs_tol_kontrak,
                        dt.kode_item,
                        dt.nama_item,
                        dt.lebar_sheet_box,
                        dt.panjang_sheet_box,
                        dt.tinggi_sheet_box,
                        dt.substance_produksi,
                        dt.flute,
                        dt.warna,
                        dt.out_conv,
                        dt.koli,
                        dt.joint,
                        dt.tipe_box,
                        dt.bungkus,
                        dt.kontrak_d_id
                       FROM opi_m
                       LEFT JOIN dt_view as dt ON opi_m.dt_id = dt.id
                       LEFT JOIN kontrak_d_view as kd ON dt.kontrak_d_id = kd.id
                       LEFT JOIN kontrak_m_view as km ON kd.no_kontrak = km.id
                   ");
    }
    public function down()
    {
        DB::statement("DROP VIEW opi_m_view");
    }
}