<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateOpiDView extends Migration 
{
    public function up()
    {
        DB::statement("CREATE VIEW opi_d_view AS SELECT 
                        opi_d.id,
                        opi_d.opi_m_id,
                        opi_d.noBukti as no_bukti,
                        opi_m.kode_item,
                        opi_m.nama_item,
                        opi_d.pcs,
                        opi_m.gram_sheet_box as gram_pcs,
                        opi_d.kg,
                        opi_d.keterangan
                       FROM opi_d
                       LEFT JOIN opi_m_view as opi_m ON opi_d.opi_m_id = opi_m.id
                   ");
    }
    public function down()
    {
        DB::statement("DROP VIEW opi_d_view");
    }
}