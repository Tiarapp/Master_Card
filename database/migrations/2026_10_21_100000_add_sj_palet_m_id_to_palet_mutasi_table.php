<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSjPaletMIdToPaletMutasiTable extends Migration
{
    public function up()
    {
        Schema::table('palet_mutasi', function (Blueprint $table) {
            $table->unsignedBigInteger('sj_palet_m_id')->nullable()->after('item_palet_id')->index();
        });
    }

    public function down()
    {
        Schema::table('palet_mutasi', function (Blueprint $table) {
            $table->dropColumn('sj_palet_m_id');
        });
    }
}
