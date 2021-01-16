<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('box', function (Blueprint $table) {
            $table->id('id');
            $table->string('kode')->unique()->index();      //AUTO NUMBER SEQUENCE
            $table->string('nama')->nullable()->index();      //AUTO SHEET : lebarSheetBox x panjangSheetBox x tinggiSheetBox satuanSizeSheetBox | luasSheetBox satuanLuasSheetBox
            //     BOX   : panjangDalamBox x lebarDalamBox x tinggiDalamBox satuanSizeDalamBox
            //     CREASING CORR : sizeCreasCorr satuanCreas
            //     CREASING CONV : sizeCreasConv satuanCreas
            $table->foreignId('tipebox_id')->unsigned();
            $table->enum('tipeCreasCorr', ['MALE-FLAT', 'MALE-MALE', 'MALE-FEMALE', 'TANPA CREASE']);   //INPUT MARKETING
            // SHEET BOX
            $table->integer('lebarSheetBox');           //INPUT MARKETING
            $table->integer('panjangSheetBox');         //INPUT MARKETING
            $table->integer('tinggiSheetBox');          //INPUT MARKETING
            $table->foreignId('satuanSizeSheetBox')->nullable();    //INPUT MARKETING
            $table->integer('luasSheetBox');            //INPUT MARKETING
            $table->foreignId('satuanLuasSheetBox')->nullable();    //INPUT MARKETING
            $table->float('gramSheetBox', 8, 2);            //INPUT MARKETING
            // DALAM BOX
            $table->integer('panjangDalamBox');         //INPUT MARKETING
            $table->integer('lebarDalamBox');           //INPUT MARKETING
            $table->integer('tinggiDalamBox');          //INPUT MARKETING
            $table->foreignId('satuanSizeDalamBox')->nullable();    //INPUT MARKETING
            $table->integer('sizeCreasCorr');           //INPUT MARKETING
            $table->integer('sizeCreasConv');           //INPUT MARKETING
            $table->foreignId('satuanCreas');           //INPUT MARKETING
            //RELATION
            $table->foreign('tipebox_id')->references('id')->on('tipe_box')->cascadeOnDelete();
            $table->foreign('satuanSizeSheetBox')->references('id')->on('satuan')->cascadeOnDelete();
            $table->foreign('satuanLuasSheetBox')->references('id')->on('satuan')->cascadeOnDelete();
            $table->foreign('satuanSizeDalamBox')->references('id')->on('satuan')->cascadeOnDelete();
            $table->foreign('satuanCreas')->references('id')->on('satuan')->cascadeOnDelete();
            // TRACKING
            $table->string('createdBy');        //Auto ambil dari login
            $table->string('lastUpdatedBy')->nullable();    //Auto ambil dari login
            $table->boolean('deleted')->default(0);         //Update ketika di hapus (default false)
            $table->dateTime('deletedAt')->nullable();      //Auto ambil dari today()
            $table->string('deletedBy')->nullable();        //Auto ambil dari login
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
        Schema::dropIfExists('box');
    }
}
