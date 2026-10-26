<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQualityFieldsToPaletMutasiTable extends Migration
{
    public function up()
    {
        Schema::table('palet_mutasi', function (Blueprint $table) {
            $table->string('jenisPalet', 20)->nullable()->after('namaCustomer');
            $table->unsignedInteger('qty_bagus')->nullable()->after('qty');
            $table->unsignedInteger('qty_jelek')->nullable()->after('qty_bagus');
        });
    }

    public function down()
    {
        Schema::table('palet_mutasi', function (Blueprint $table) {
            $table->dropColumn(['jenisPalet', 'qty_bagus', 'qty_jelek']);
        });
    }
}
