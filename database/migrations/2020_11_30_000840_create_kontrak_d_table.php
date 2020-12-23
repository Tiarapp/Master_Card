<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKontrakDTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kontrak_d', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('kontrak_m_id');  //Auto
            $table->foreignId('item_bj_id');    //Input Marketing pilih dari master item_bj_converting
            $table->foreignId('mc_id');         //Auto ambil mid(item_bj_id,15,4)
            $table->integer('pcsKontrak');      //Input Marketing
            $table->integer('kgKontrak');       //AUTO pcsKontrak * gramKontrak
            $table->float('pctToleransiKontrak',5,2);   //Input Marketing
            $table->integer('pcsToleransiKontrak');     //Input Marketing AUTO JIKA PCT DI INPUT (PCS KONTRAK*PCT TOLERANSI)
            $table->integer('kgToleransiKontrak');      //AUTO (kontrak_d.pcsToleransiKontrak * kontrak_d.gramKontrak)
            $table->enum('tipe_harga',['PCS','KG'])->default('PCS')->comment('PCS/KG');
            $table->integer('harga');           //pcsKontrak || kgKontrak * mc.substance_sheet_id.(substance_sheet.gramSheetCorr)
            $table->foreignId('mataUang');           //INPUT MARKETING
            $table->foreignId('mesin_id');                  //INPUT MARKETING
            $table->enum('inExTax',['Include','Exclude']);  //Input Marketing
            $table->float('rpKg',20,2);                     //Auto (price Excl)/(gram_kontrak)
            $table->enum('tipeOrder',['OB','OU','OUP'])->comment('OB=Order Baru, OU=Order Ulang, OUP=Order Ulang Perubahan ');
            $table->boolean('mcPelengkap')->default(FALSE)->comment('TRUE (ADA PELENGKAP), FALSE (TDK ADA PELENGKAP)');
            
            //RELATION
            $table->foreign('kontrak_m_id')->references('id')->on('kontrak_m')->cascadeOnDelete();
            $table->foreign('item_bj_id')->references('id')->on('item_bj')->cascadeOnDelete();
            $table->foreign('mc_id')->references('id')->on('mc')->cascadeOnDelete();
            $table->foreign('mesin_id')->references('id')->on('mesin')->cascadeOnDelete();
            $table->foreign('mataUang')->references('id')->on('mata_uang')->cascadeOnDelete();
            // TRACKING
            $table->string('createdBy');        //Auto ambil dari login
            $table->string('lastUpdatedBy')->nullable();    //Auto ambil dari login
            $table->boolean('deleted')->default(0);         //Update ketika di hapus (default false)
            $table->dateTime('deletedAt')->nullable();      //Auto ambil dari today()
            $table->string('deletedBy')->nullable();        //Auto ambil dari login
            $table->string('branch');           //Auto ambil dari login awal
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
        Schema::dropIfExists('kontrak_d');
    }
}
