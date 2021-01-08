<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBomMTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bom_m', function (Blueprint $table) {
            $table->id('id');
            $table->string('kode')->unique()->index();           //AUTO NUMBER SEQUENCE
            $table->string('nama')->nullable()->index();         //INPUT PPIC
            $table->foreignId('flute_id')->index();              //INPUT PPIC
            $table->foreignId('substance_id')->nullable();       //INPUT PPIC
            $table->integer('luas')->nullable();                 //INPUT PPIC
            $table->foreignId('satuanLuas')->nullable();         //INPUT PPIC
            $table->integer('beratPerLuas')->nullable();         //INPUT PPIC
            $table->foreignId('satuanBeratPerLuas')->nullable(); //INPUT PPIC
            $table->integer('avgPrice')->nullable();             //INPUT ACC
            $table->foreignId('mataUang')->nullable();           //INPUT ACC
            //RELATION
            $table->foreign('flute_id')->references('id')->on('flute')->cascadeOnDelete();
            $table->foreign('substance_id')->references('id')->on('substance')->cascadeOnDelete();
            $table->foreign('satuanLuas')->references('id')->on('satuan')->cascadeOnDelete();
            $table->foreign('satuanBeratPerLuas')->references('id')->on('satuan')->cascadeOnDelete();
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
        Schema::dropIfExists('bom_m');
    }
}
