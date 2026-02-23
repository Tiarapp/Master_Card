<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAsumsiHargaToKontrakMTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kontrak_m', function (Blueprint $table) {
            $table->double('harga_expedisi')->default(0)->after('biaya_wax')->comment('Asumsi harga expedisi per kg');
            $table->double('harga_karet')->default(0)->after('harga_expedisi')->comment('Asumsi harga packing per kg');
            $table->double('harga_pisau')->default(0)->after('harga_karet')->comment('Asumsi harga packing per kg');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kontrak_m', function (Blueprint $table) {
            $table->dropColumn('harga_expedisi');
            $table->dropColumn('harga_karet');
            $table->dropColumn('harga_pisau');
        });
    }
}
