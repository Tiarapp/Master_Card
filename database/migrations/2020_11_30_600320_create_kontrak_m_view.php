<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateKontrakMView extends Migration 
{
    public function up()
    {
        DB::statement("CREATE VIEW kontrak_m_view AS SELECT 
                       km.id,
                       km.created_at as tgl_kontrak,
                       km.kode as no_kontrak,
                       top.nama as top,
                       km.poCustomer as po_customer,
                       cst.nama as nama_customer,
                       akm.alamatLengkap as alamat_kirim,
                       akm.pic as pic_kirim,
                       akm.telpPic as telp_pic_kirim,
                       km.caraKirim as cara_kirim,
                       km.pcsKontrak as pcs_kontrak,
                       km.pctToleransiKontrak as pct_tol_kontrak,
                       km.pcsToleransiKontrak as pcs_tol_kontrak,
                       km.kgKontrak as kg_kontrak,
                       km.kgToleransiKontrak as kg_tol_kontrak,
                       km.amountBeforeTax as amount_before_tax,
                       km.tax,
                       km.amountTotal as amount_total,
                       km.rpKg as rp_kg,
                       mu.nama,
                       km.sisaPlafon as sisa_plafon,
                       km.status as status_kontrak,
                       sls.nama as nama_sales
                       FROM kontrak_m as km
                       LEFT JOIN top ON km.top_id = top.id
                       LEFT JOIN alamat as akm ON km.alamatKirim_id = akm.id
                       LEFT JOIN customer as cst ON km.customer_id = cst.id
                       LEFT JOIN sales as sls ON km.sales_id = sls.id
                       LEFT JOIN mata_uang as mu ON km.mataUang = mu.id
                    ");
    }
    public function down()
    {
        DB::statement("DROP VIEW kontrak_m_view");
    }  
}