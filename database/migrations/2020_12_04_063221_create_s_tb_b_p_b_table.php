<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSTbBPBTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_tbBPB', function (Blueprint $table) {
            $table->id('id');
            $table->string('Ex_In')->nullable();
            $table->string('Nomor')->nullable();
            $table->dateTime('Tanggal')->nullable();
            $table->dateTime('DueDate')->nullable();
            $table->string('YourRef')->nullable();
            $table->string('SupplierCode')->nullable();
            $table->string('Nama')->nullable();
            $table->string('Ext')->nullable();
            $table->string('Alamat')->nullable();
            $table->string('Kota')->nullable();
            $table->string('SJSupplier')->nullable();
            $table->string('NoPol')->nullable();
            $table->string('Expedisi')->nullable();
            $table->string('ShipmentName')->nullable();
            $table->string('ShipmentAddress')->nullable();
            $table->string('ShipmentCity')->nullable();
            $table->string('Sopir')->nullable();
            $table->string('Catatan')->nullable();
            $table->string('Printed')->nullable();
            $table->dateTime('PostingDate')->nullable();
            $table->string('KodeAktiva')->nullable();
            $table->string('Tick')->nullable();
            $table->integer('BBKCount')->nullable();
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
        Schema::dropIfExists('s_tbBPB');
    }
}
