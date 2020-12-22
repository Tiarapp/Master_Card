<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubstanceSheetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('substance_sheet', function (Blueprint $table) {
            $table->id('id');
            $table->string('kode')->unique();               //AUTO NUMBER SEQUENCE
            $table->string('nama')->unique();               //AUTO sheet.nama + substance.nama
            $table->foreignId('sheet_id');                  //Input PPIC
            $table->foreignId('substance_id');              //Input PPIC
            $table->integer('gramSheetCorr');               //AUTO 
                                                            //(substance.(jenisGramLinerAtas_id.(jenis_gram.gramKertas)))+
                                                            //(substance.(jenisGramBF_id.(jenis_gram.gramKertas))+
                                                            //(substance.(jenisGramLinerTengah_id.(jenis_gram.gramKertas)))+
                                                            //(substance.(jenisGramCF_id.(jenis_gram.gramKertas)))+
                                                            //(substance.(jenisGramLinerBawah_id.(jenis_gram.gramKertas)))) * sheet.luasSheet
            $table->foreignId('satuanGramSheetCorr');    //Input PPIC

            //RELATION
            $table->foreign('sheet_id')->references('id')->on('sheet')->cascadeOnDelete();
            $table->foreign('substance_id')->references('id')->on('substance')->cascadeOnDelete();
            $table->foreign('satuanGramSheetCorr')->references('id')->on('satuan')->cascadeOnDelete();

            // TRACKING
            $table->string('createdBy');        //Auto ambil dari login
            $table->string('lastUpdatedBy')->nullable();    //Auto ambil dari login
            $table->boolean('deleted')->nullable();         //Update ketika di hapus (default false)
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
        Schema::dropIfExists('substance_sheet');
    }
}
