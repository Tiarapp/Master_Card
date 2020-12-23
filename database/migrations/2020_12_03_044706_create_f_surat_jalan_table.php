<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFSuratJalanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('f_TSuratJalan', function (Blueprint $table) {
            $table->id('id');
            $table->string('NomerSJ')->nullable();
            $table->string('Periode')->nullable();
            $table->string('Tujuan')->nullable();
            $table->date('TglSJ')->nullable();
            $table->date('TglPrint')->nullable();
            $table->string('KodePerk')->nullable();
            $table->string('NomerMOD')->nullable();
            $table->string('KodeCust')->nullable();
            $table->string('NamaCust')->nullable();
            $table->string('ShortName')->nullable();
            $table->string('Coverage')->nullable();
            $table->string('GlobalArea')->nullable();
            $table->string('AreaAcc')->nullable();
            $table->string('KodeAO')->nullable();
            $table->string('KirimKe')->nullable();
            $table->string('Expedisi')->nullable();
            $table->string('NoSeal')->nullable();
            $table->string('NoContainer')->nullable();
            $table->string('NoKend')->nullable();
            $table->string('CaraAngkut')->nullable();
            $table->decimal('TotJualCrt',18,4)->nullable();
            $table->decimal('TotJualEcr',18,4)->nullable();
            $table->string('NoFakturPajak')->nullable();
            $table->string('Print')->nullable();
            $table->string('Aktif')->nullable();
            $table->string('Blocked')->nullable();
            $table->float('TotalAwal',18,4)->nullable();
            $table->float('Potongan',18,4)->nullable();
            $table->float('SebelumPPN',18,4)->nullable();
            $table->float('PPN',18,4)->nullable();
            $table->float('TotalAkhir',18,4)->nullable();
            $table->float('PPH22',18,4)->nullable();
            $table->float('PPHSign')->nullable();
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
        Schema::dropIfExists('f_surat_jalan');
    }
}
