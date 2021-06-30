<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHasilProduksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hasil_produksi', function (Blueprint $table) {
            $table->id('id');
            $table->string('regu')->index();
            $table->string('shift')->index();
            $table->foreignId('mesin_id')->index();
            $table->string('opi')->index();
            $table->dateTime('jamStart')->index();
            $table->dateTime('jamFinish')->index();
            $table->dateTime('durasi')->index();
            $table->string('kodeBarang')->index();
            $table->string('namaBarang')->index();
            $table->integer('outFlexo')->index();
            $table->integer('rm')->index();
            $table->integer('hasilBaikPcsSheet')->index();  //Hasil Baik Lembar Besar (DC)
            $table->integer('hasilBaikPcsBox')->index();    //Hasil Baik Lembar Kecil
            $table->integer('hasilBaikKg')->index();        //Hasil Baik Lembar Kecil * beratStandart
            $table->integer('wastePcs')->index();
            $table->integer('wasteKg')->index();            //wastePcs * beratStandart
            $table->integer('wasteCorrPcs')->index();
            $table->integer('wasteCorrKg')->index();        //wasteCorrPcs * beratStandart
            $table->integer('wasteFlexoPcs')->index();
            $table->integer('wasteFlexoKg')->index();       //wasteFlexoPcs * beratStandart
            // Waste Khusus Mesin Corr
            $table->integer('wastePaperCoreKg')->index();
            $table->integer('wasteTrimKg')->index();
            $table->integer('wasteSobekanKg')->index();
            $table->integer('wasteSingleFaceKg')->index();
            $table->integer('wasteNcKg')->index();
            $table->integer('wasteRotariKg')->index();
            // TRACKING
            $table->string('createdBy');                    //Auto ambil dari login
            $table->string('lastUpdatedBy')->nullable();    //Auto ambil dari login
            $table->dateTime('deletedAt')->nullable();      //Auto ambil dari today()
            $table->string('deletedBy')->nullable();        //Auto ambil dari login
            $table->integer('printedKe')->nullable();       //Auto ambil dari login
            $table->dateTime('printedAt')->nullable();      //Auto ambil dari login
            $table->string('branch')->default('Lamongan')->index();              //Auto ambil dari login awal
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
        Schema::dropIfExists('hasil_produksi');
    }
}
