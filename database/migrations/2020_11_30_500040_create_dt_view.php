<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateDtView extends Migration 
{
    public function up()
    {
        DB::statement("CREATE VIEW dt_view AS SELECT 
                        dt.id,
                        dt.kontrak_d_id,
                        km.tgl_kontrak,
                        km.no_kontrak,
                        kd.mc_id,
                        dt.created_at as tgl_input,
                        dt.tglKirimDt as tgl_kirim_dt,
                        dt.hariKirimDt as hari_kirim_dt,
                        dt.pcsDt as pcs_dt,
                        kd.gram_sheet_box,
                        dt.kgDt as kg_dt,
                        dt.noMod,
                        km.nama_customer,
                        kd.kode_item,
                        dt.noPhp as no_php,
                        dt.tglPhp as tgl_php,
                        dt.hariPhp as hari_php,
                        dt.pcsPhp as pcs_php,
                        dt.kgPhp as kg_php,
                        dt.noSj as no_sj,
                        dt.tglSj as tgl_sj,
                        dt.hariSj as hari_sj,
                        dt.pcsSj as pcs_sj,
                        dt.kgSj as kg_sj,
                        dt.noSjRetur as no_sj_retur,
                        dt.tglSjRetur as tgl_sj_retur,
                        dt.hariSjRetur as hari_sj_retur,
                        dt.pcsRetur as pcs_retur,
                        dt.kgRetur as kgRetur,
                        dt.piutang,
                        dt.outstandingPiutang as outstanding_piutang,
                        kd.nama_item,
                        kd.pcs_kontrak,
                        kd.kg_kontrak,
                        dt.opi,
                        mc.keterangan,
                        km.po_customer,
                        mc.flute,
                        mc.tipe_box,
                        mc.lebar_sheet_corr,
                        mc.panjang_sheet_corr,
                        mc.satuan_size_sheet_corr,
                        mc.lebar_sheet_box,
                        mc.panjang_sheet_box,
                        mc.tinggi_sheet_box,
                        mc.tipe_creas_corr,
                        mc.out_conv,
                        kd.tipe_order,
                        mc.warna,
                        mc.mesin,
                        mc.substance_kontrak,
                        mc.substance_produksi,
                        mc.wax,
                        mc.joint,
                        mc.koli,
                        mc.bungkus,
                        kd.mcPelengkap,
                        dt.lock
                       FROM dt
                       LEFT JOIN kontrak_d_view as kd ON dt.kontrak_d_id = kd.id
                       LEFT JOIN kontrak_m_view as km ON kd.no_kontrak = km.id
                       LEFT JOIN mc_view as mc ON kd.mc_id = mc.id
                   ");
    }
    public function down()
    {
        DB::statement("DROP VIEW dt_view");
    }
}