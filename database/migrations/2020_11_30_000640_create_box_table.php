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
            $table->text('nama')->nullable()->index();      //AUTO SHEET : lebarSheetBox x panjangSheetBox x tinggiSheetBox satuanSizeSheetBox | luasSheetBox satuanLuasSheetBox
                                                            //     BOX   : panjangDalamBox x lebarDalamBox x tinggiDalamBox satuanSizeDalamBox
                                                            //     CREASING CORR : sizeCreasCorr satuanCreas
                                                            //     CREASING CONV : sizeCreasConv satuanCreas
            $table->enum('tipeCreasCorr',['MALE-FLAT','MALE-MALE','MALE-FEMALE','TANPA CREASE']);   //INPUT MARKETING
            // SHEET BOX
            $table->integer('lebarSheetBox');           //INPUT MARKETING
            $table->integer('panjangSheetBox');         //INPUT MARKETING
            $table->integer('tinggiSheetBox');          //INPUT MARKETING
            $table->foreignId('satuanSizeSheetBox');    //INPUT MARKETING
            $table->integer('luasSheetBox');            //INPUT MARKETING
            $table->foreignId('satuanLuasSheetBox');    //INPUT MARKETING
            $table->integer('gramSheetBox');            //INPUT MARKETING
            // DALAM BOX
            $table->integer('panjangDalamBox');         //INPUT MARKETING
            $table->integer('lebarDalamBox');           //INPUT MARKETING
            $table->integer('tinggiDalamBox');          //INPUT MARKETING
            $table->foreignId('satuanSizeDalamBox');    //INPUT MARKETING
            $table->integer('sizeCreasCorr');           //INPUT MARKETING
            $table->integer('sizeCreasConv');           //INPUT MARKETING
            $table->foreignId('satuanCreas');           //INPUT MARKETING
            //RELATION
            $table->foreign('satuanSizeSheetBox')->references('id')->on('satuan')->cascadeOnDelete();
            $table->foreign('satuanLuasSheetBox')->references('id')->on('satuan')->cascadeOnDelete();
            $table->foreign('satuanCreas')->references('id')->on('satuan')->cascadeOnDelete();
            // TRACKING
            $table->string('createdBy');        //Auto ambil dari login
            $table->string('lastUpdatedBy')->nullable();    //Auto ambil dari login
            $table->boolean('deleted')->default(0);         //Update ketika di hapus (default false)
            $table->dateTime('deletedAt')->nullable();      //Auto ambil dari today()
            $table->string('deletedBy')->nullable();        //Auto ambil dari login
            $table->string('branch')->index();              //Auto ambil dari login awal
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
