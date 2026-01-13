<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKaretsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('karets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mc_id');
            $table->string('customer')->nullable();
            $table->string('sales_name')->nullable();
            $table->string('kode_barang')->nullable();
            $table->string('nama_karet');
            $table->string('no_po');
            $table->double('gsm');
            $table->integer('harga_per_kg');
            $table->string('lokasi_kirim')->nullable();
            $table->date('tanggal_masuk');
            $table->double('harga');
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
        Schema::dropIfExists('karets');
    }
}
