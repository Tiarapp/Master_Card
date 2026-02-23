<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAlokasiStatusToKontrakMTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kontrak_m', function (Blueprint $table) {
            $table->string('alokasi_status')->default('Belum Alokasi');
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
            $table->dropColumn('alokasi_status');
        });
    }
}
