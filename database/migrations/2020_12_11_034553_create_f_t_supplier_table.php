<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFTSupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('f_TSupplier', function (Blueprint $table) {
            $table->id('id');
            $table->string('Kode')->nullable();
            $table->string('Nama')->nullable();
            $table->string('KodeNamaAcc')->nullable();
            $table->string('NamaAcc')->nullable();
            $table->string('AlamatKantor')->nullable();
            $table->string('KotaKantor')->nullable();
            $table->string('TelpKantor')->nullable();
            $table->string('FaxKantor')->nullable();
            $table->string('PIC')->nullable();
            $table->string('TelpPIC')->nullable();
            $table->float('Plafond',20,2);
            $table->integer('WaktuBayar')->nullable();
            $table->string('JenisBayar')->nullable();
            $table->string('Area')->nullable();
            $table->string('NPWP')->nullable();
            $table->string('NPPKP')->nullable();
            $table->string('Bank')->nullable();
            $table->string('NoAcc')->nullable();
            $table->string('NamaRek')->nullable();
            $table->datetime('created_at')->default(now());
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('f_TSupplier');
    }
}
