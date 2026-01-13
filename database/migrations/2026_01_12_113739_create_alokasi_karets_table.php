<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlokasiKaretsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alokasi_karets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('karet_id');
            $table->unsignedBigInteger('mc_id');
            $table->date('tanggal_kirim');
            $table->integer('pcs');
            $table->double('alokasi_harga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alokasi_karets');
    }
}
