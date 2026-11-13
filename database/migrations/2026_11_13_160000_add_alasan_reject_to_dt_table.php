<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAlasanRejectToDtTable extends Migration
{
    public function up()
    {
        Schema::table('dt', function (Blueprint $table) {
            $table->text('alasan_reject')->nullable();
        });
    }

    public function down()
    {
        Schema::table('dt', function (Blueprint $table) {
            $table->dropColumn('alasan_reject');
        });
    }
}
