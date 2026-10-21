<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaletMutasiTable extends Migration
{
    public function up()
    {
        Schema::create('palet_mutasi', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->index();
            $table->enum('jenis', ['keluar', 'masuk'])->index(); // keluar = ke customer, masuk = kembali dari customer
            $table->string('namaCustomer')->index();
            $table->foreignId('item_palet_id');
            $table->unsignedInteger('qty');
            $table->string('noDokumen')->nullable();
            $table->string('noPolisi')->nullable();
            $table->text('keterangan')->nullable();

            $table->foreign('item_palet_id')->references('id')->on('item_palet');

            $table->string('createdBy');
            $table->string('lastUpdatedBy')->nullable();
            $table->dateTime('deletedAt')->nullable();
            $table->string('deletedBy')->nullable();
            $table->string('branch')->default('Lamongan')->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('palet_mutasi');
    }
}
