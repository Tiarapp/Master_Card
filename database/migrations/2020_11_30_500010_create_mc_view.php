<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateMcView extends Migration 
{
    public function up()
    {
        DB::statement("CREATE VIEW mc_view AS SELECT 
                        mc.id,
                        mc.created_at as tgl_mc,
                        mc.kode as no_mc,
                        mc.bj_id as kode_item,
                        bj.nama as nama_item,
                        sh.lebarSheet as lebar_sheet_corr,
                        sh.panjangSheet as panjang_sheet_corr,
                        stnSizeSheetCorr.nama as satuan_size_sheet_corr,
                        sh.luasSheet as luas_sheet_corr,
                        stnLuasSheetCorr.nama as satuan_luas_sheet_corr,
                        mc.gramSheetCorrKontrak as gram_sheet_corr_kontrak,
                        mc.gramSheetCorrProduksi as gram_sheet_corr_produksi,
                        sk.nama as substance_kontrak,
                        sp.nama as substance_produksi,
                        fl.nama as flute,
                        tb.nama as tipe_box,
                        bx.panjangDalamBox as panjang_dalam_box,
                        bx.lebarDalamBox as lebar_dalam_box,
                        bx.tinggiDalamBox as tinggi_dalam_box,
                        stnSizeDalamBox.nama as satuan_Size_dalam_box,
                        bx.sizeCreasCorr as size_creas_corr,
                        bx.sizeCreasConv as size_creas_conv,
                        stnCreas.nama as satuan_creas,
                        bx.lebarSheetBox as lebar_sheet_box,
                        bx.panjangSheetBox as panjang_sheet_box,
                        bx.tinggiSheetBox as tinggi_sheet_box,
                        stnSizeSheetBox.nama as satuan_size_sheet_box,
                        bx.luasSheetBox as luas_sheet_box,
                        stnLuasSheetBox.nama as satuan_luas_sheet_box,
                        bx.gramSheetBox as gram_sheet_box,
                        bx.nama as nama_box,
                        bx.tipeCreasCorr as tipe_creas_corr,
                        mc.outConv as out_conv,
                        mc.gambar,
                        cc.nama as warna,
                        mc.mesin,
                        jt.nama as joint,
                        wax.nama as wax,
                        ko.nama as koli,
                        mc.bungkus,
                        mc.keterangan,
                        bx.id as box_id,
                        mc.sheet_id
                        FROM mc
                        LEFT JOIN item_bj as bj ON mc.bj_id = bj.id
                        LEFT JOIN tipe_box as tb ON mc.tipeBox_id = tb.id
                        LEFT JOIN sheet as sh ON mc.sheet_id = sh.id
                        LEFT JOIN satuan as stnSizeSheetCorr ON sh.satuanSizeSheet = stnSizeSheetCorr.id
                        LEFT JOIN satuan as stnLuasSheetCorr ON sh.satuanLuasSheet = stnLuasSheetCorr.id
                        LEFT JOIN box as bx ON mc.box_id = bx.id
                        LEFT JOIN satuan as stnSizeDalamBox ON bx.satuanSizeDalamBox = stnSizeDalamBox.id
                        LEFT JOIN satuan as stnCreas ON bx.satuanCreas = stnCreas.id
                        LEFT JOIN satuan as stnSizeSheetBox ON bx.satuanSizeSheetBox = stnSizeSheetBox.id
                        LEFT JOIN satuan as stnLuasSheetBox ON bx.satuanLuasSheetBox = stnLuasSheetBox.id
                        LEFT JOIN joint as jt ON mc.joint_id = jt.id
                        LEFT JOIN wax ON mc.wax_id = wax.id
                        LEFT JOIN koli as ko ON mc.koli_id = ko.id
                        LEFT JOIN flute as fl ON mc.flute_id = fl.id
                        LEFT JOIN substance as sk ON mc.substanceKontrak_id = sk.id
                        LEFT JOIN substance as sp ON mc.substanceProduksi_id = sp.id
                        LEFT JOIN bom_m as bom ON mc.bom_m_id = bom.id
                        LEFT JOIN color_combine as cc ON mc.colorCombine_id = cc.id
                    ");
    }
    public function down()
    {
        DB::statement("DROP VIEW mc_view");
    }  
}