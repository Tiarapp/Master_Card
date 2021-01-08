<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMcTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mc', function (Blueprint $table) {
            $table->id('id');
            $table->string('kode')->unique()->index();              //AUTO NUMBER SEQUENCE
            $table->integer('revisi');                              //AUTO REVISI KE
            $table->foreignId('bj_id')->index();                    //INPUT MARKETING
            $table->foreignId('tipeBox_id')->index();               //INPUT MARKETING
            $table->foreignId('sheet_id')->index();                 //INPUT MARKETING
            $table->foreignId('satuanSizeSheet')->nullable()->index();   //COLOR ID INPUT MARKETING
            $table->foreignId('satuanLuasSheet')->nullable()->index();   //COLOR ID INPUT MARKETING
            $table->foreignId('wax_id')->nullable();                //INPUT MARKETING
            $table->foreignId('joint_id')->index();                 //INPUT MARKETING
            $table->foreignId('flute_id')->index();                 //INPUT MARKETING
            $table->string('mesin')->index();                       //AUTO RUMUS MASIH DIPIKIR
            $table->integer('outConv')->index();                    //AUTO RUMUS MASIH DIPIKIR
            $table->foreignId('koli_id')->index();                  //INPUT MARKETING
            $table->boolean('bungkus')->default(FALSE)->nullable(); //INPUT MARKETING
            $table->text('keterangan')->nullable();                 //INPUT MARKETING
            $table->boolean('lock')->default(TRUE);                 //AUTO
            $table->string('gambar');                               //UPLOAD BY DESAIN
            $table->foreignId('substanceKontrak_id')->index();      //SUBSTANCE KONTRAK INPUT MARKETING
            $table->foreignId('substanceProduksi_id')->index();     //SUBSTANCE PRODUKSI INPUT MARKETING
            $table->integer('gramSheetCorrKontrak');                //AUTO RUMUS MASIH DIPIKIR
            $table->integer('gramSheetCorrProduksi');               //AUTO RUMUS MASIH DIPIKIR
            $table->foreignId('bom_m_id')->index();                 //BOM INPUT MARKETING
            $table->foreignId('box_id')->index();                   //SHEET BOX INPUT MARKETING
            $table->foreignId('satuanSizeSheetBox')->nullable()->index();   //COLOR ID INPUT MARKETING
            $table->foreignId('satuanLuasSheetBox')->nullable()->index();   //COLOR ID INPUT MARKETING
            $table->foreignId('satuanSizeDalamBox')->nullable()->index();   //COLOR ID INPUT MARKETING
            $table->foreignId('colorCombine_id')->nullable()->index();   //COLOR ID INPUT MARKETING
            $table->foreignId('satuanCreas')->nullable()->index();   //COLOR ID INPUT MARKETING
            //RELATION
            $table->foreign('bj_id')->references('id')->on('item_bj')->cascadeOnDelete();
            $table->foreign('tipeBox_id')->references('id')->on('tipe_box')->cascadeOnDelete();
            $table->foreign('sheet_id')->references('id')->on('sheet')->cascadeOnDelete();
            $table->foreign('wax_id')->references('id')->on('wax')->cascadeOnDelete();
            $table->foreign('joint_id')->references('id')->on('joint')->cascadeOnDelete();
            $table->foreign('koli_id')->references('id')->on('koli')->cascadeOnDelete();
            $table->foreign('flute_id')->references('id')->on('flute')->cascadeOnDelete();
            $table->foreign('substanceKontrak_id')->references('id')->on('substance')->cascadeOnDelete();
            $table->foreign('substanceProduksi_id')->references('id')->on('substance')->cascadeOnDelete();
            $table->foreign('bom_m_id')->references('id')->on('bom_m')->cascadeOnDelete();
            $table->foreign('box_id')->references('id')->on('box')->cascadeOnDelete();
            $table->foreign('colorCombine_id')->references('id')->on('color_combine')->cascadeOnDelete();
            $table->foreign('satuanSizeSheet')->references('id')->on('satuan')->cascadeOnDelete();
            $table->foreign('satuanLuasSheet')->references('id')->on('satuan')->cascadeOnDelete();
            $table->foreign('satuanSizeDalamBox')->references('id')->on('satuan')->cascadeOnDelete();
            $table->foreign('satuanCreas')->references('id')->on('satuan')->cascadeOnDelete();
            $table->foreign('satuanSizeSheetBox')->references('id')->on('satuan')->cascadeOnDelete();
            $table->foreign('satuanLuasSheetBox')->references('id')->on('satuan')->cascadeOnDelete();
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
        Schema::dropIfExists('mc');
    }
}
