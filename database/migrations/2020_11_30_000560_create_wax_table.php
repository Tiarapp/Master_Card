<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wax', function (Blueprint $table) {
            $table->id('id');
            $table->string('kode')->unique()->index();       //AUTO NUMBER SEQUENCE
            $table->string('nama')->nullable()->index();     //AUTO inOut + luas + gramWax
            $table->integer('luas')->nullable();             //AUTO box.lebarSheetBox * box.panjangSheetBox
            $table->enum('inOut',['INSIDE','OUTSIDE','IN & OUT'])->nullable()->index();  //INPUT MARKETING
            $table->foreignId('satuanLuas')->nullable();     //AUTO  =box.satuanUkSheetBox_id
            $table->float('gramWax',20,2)->nullable();       //INPUT PPIC
            $table->foreignId('satuanGramWax')->nullable();  //AUTO ='GRAM'
            $table->float('avgPrice',20,2)->nullable();      //INPUT ACC
            $table->foreignId('mataUang')->nullable();       //INPUT ACC
            //RELATION
            $table->foreign('satuanLuas')->references('id')->on('satuan')->cascadeOnDelete();
            $table->foreign('satuanGramWax')->references('id')->on('satuan')->cascadeOnDelete();
            $table->foreign('mataUang')->references('id')->on('mata_uang')->cascadeOnDelete();
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
        Schema::dropIfExists('wax');
    }
}
