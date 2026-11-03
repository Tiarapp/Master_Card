<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInternalFieldsToPaletMutasiTable extends Migration
{
    public function up()
    {
        Schema::table('palet_mutasi', function (Blueprint $table) {
            $table->string('kategori', 20)->default('customer')->after('jenis')->index();
            $table->string('sumber', 40)->nullable()->after('kategori');
        });
    }

    public function down()
    {
        Schema::table('palet_mutasi', function (Blueprint $table) {
            $table->dropColumn(['kategori', 'sumber']);
        });
    }
}
