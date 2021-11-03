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
            $table->foreignId('kontrak_m_id')->index();    //Input Marketing pilih dari master item_bj_converting
            $table->foreignId('mc_id')->index();         //Auto ambil mid(item_bj_id,15,4)
            $table->enum('tipe',['BOX', 'PARTISI', 'LAYER', 'SHEET', 'BOX TUMBU', 'BOX TUTUP'])->index();
            $table->integer('pcsKontrak');                       //AUTO SUM(kontrak_d.pcsKontrak)
            $table->float('kgKontrak', 10,2)->nullable();              //AUTO pcsKontrak * gramKontrak
            $table->integer('pcsSisaKontrak')->nullable();             //Next Auto Sisa Kontrak yg belum di OPI/DT
            $table->float('kgSisaKontrak', 10,2)->nullable();             //Next Auto Sisa Kontrak yg belum di OPI/DT
            $table->float('pctToleransiLebihKontrak',10,2)->nullable();   //AUTO AVERAGE(kontrak_d.pctToleransiKontrak)
            $table->float('pctToleransiKurangKontrak',10,2)->nullable();   //AUTO AVERAGE(kontrak_d.pctToleransiKontrak)
            $table->integer('pcsKurangToleransiKontrak')->nullable();     //AUTO SUM(kontrak_d.pcsToleransiKontrak)
            $table->integer('pcsLebihToleransiKontrak')->nullable();     //AUTO SUM(kontrak_d.pcsToleransiKontrak)
            $table->float('kgKurangToleransiKontrak', 10,2)->nullable();      //AUTO SUM(kontrak_d.pcsToleransiKontrak * kontrak_d.gramKontrak)
            $table->float('kgLebihToleransiKontrak', 10,2)->nullable();      //AUTO SUM(kontrak_d.pcsToleransiKontrak * kontrak_d.gramKontrak)
            $table->float('harga_pcs', 20,2);    
            $table->float('amountBeforeTax', 20,2)->nullable();         //AUTO DPP Auto harga * pcsKontrak
            $table->float('ppn', 20,2)->nullable();         //AUTO DPP Auto harga * pcsKontrak
            $table->float('tax', 20,2)->nullable();                     //AUTO amountBeforeTax / 10
            $table->float('amountTotal', 20,2)->nullable();             //Auto amountBeforeTax + Tax
            $table->float('harga_kg',20,2)->nullable();

            //RELATION
            $table->foreign('kontrak_m_id')->references('id')->on('kontrak_m')->cascadeOnDelete();
            $table->foreign('mc_id')->references('id')->on('mc')->cascadeOnDelete();
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
        Schema::dropIfExists('kontrak_d');
    }
}
