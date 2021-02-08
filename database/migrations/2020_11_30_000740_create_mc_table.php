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
            $table->string('tipebox')->index();               //INPUT MARKETING
            $table->string('CreasCorrP');                           
            $table->string('CreasCorrL');
            $table->foreignId('satuanSizeSheet')->nullable()->index();   //COLOR ID INPUT MARKETING
            $table->foreignId('satuanLuasSheet')->nullable()->index();   //COLOR ID INPUT MARKETING
            $table->string('joint')->index();                 //INPUT MARKETING
            $table->string('flute')->index();                 //INPUT MARKETING
            $table->integer('lebarSheet');              //Input MARKETING
            $table->integer('panjangSheet');            //Input MARKETING
            $table->integer('lebarSheetBox');              //Input MARKETING
            $table->integer('panjangSheetBox');            //Input MARKETING
            $table->float('luasSheet');               //Auto lebarSheet * panjangSheet
            $table->float('luasSheetBox');               //Auto lebarSheet * panjangSheet
            $table->string('mesin')->index();                       //AUTO RUMUS MASIH DIPIKIR
            $table->integer('outConv')->index();                    //AUTO RUMUS MASIH DIPIKIR
            $table->string('koli')->index();                  //INPUT MARKETING
            $table->enum('bungkus',['Kertas'])->nullable(); //INPUT MARKETING
            $table->text('keterangan')->nullable();                 //INPUT MARKETING
            $table->boolean('lock')->default(TRUE);                 //AUTO
            $table->string('gambar');                 //AUTO
            $table->enum('wax',['INSIDE', 'OUTSIDE', 'IN & OUT']);
            $table->enum('tipemc',['BOX', 'BOX TUMBU', 'BOX TUTUP', 'PARTISI', 'LAYER']);
            $table->foreignId('substanceKontrak_id')->index();      //SUBSTANCE KONTRAK INPUT MARKETING
            $table->foreignId('substanceProduksi_id')->index();     //SUBSTANCE PRODUKSI INPUT MARKETING
            $table->float('gramSheetBox', 8, 2);            //INPUT MARKETING
            $table->float('gramSheetCorrKontrak',8,2);                //AUTO RUMUS MASIH DIPIKIR
            $table->float('gramSheetCorrProduksi',8,2);               //AUTO RUMUS MASIH DIPIKIR
            $table->foreignId('bom_m_id')->nullable()->index();                 //BOM INPUT MARKETING
            $table->foreignId('box_id')->index();                   //SHEET BOX INPUT MARKETING
            $table->foreignId('satuanSizeSheetBox')->nullable()->index();   //COLOR ID INPUT MARKETING
            $table->foreignId('satuanLuasSheetBox')->nullable()->index();   //COLOR ID INPUT MARKETING
            $table->foreignId('satuanSizeDalamBox')->nullable()->index();   //COLOR ID INPUT MARKETING
            $table->foreignId('colorCombine_id')->nullable()->index();   //COLOR ID INPUT MARKETING
            $table->foreignId('satuanCreas')->nullable()->index();   //COLOR ID INPUT MARKETING
            //RELATION
            $table->foreign('bj_id')->references('id')->on('item_bj')->cascadeOnDelete();
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
            $table->string('createdBy');                    //Auto ambil dari login
            $table->string('lastUpdatedBy')->nullable();    //Auto ambil dari login
            $table->boolean('deleted')->default(0);         //Update ketika di hapus (default false)
            $table->dateTime('deletedAt')->nullable();      //Auto ambil dari today()
            $table->string('deletedBy')->nullable();        //Auto ambil dari login
            $table->integer('printedKe')->nullable();       //Auto ambil dari login
            $table->timestamps('printedAt')->default('current_timestamp')->nullable();        //Auto ambil dari login
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
