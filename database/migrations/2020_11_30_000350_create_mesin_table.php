<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMesinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mesin', function (Blueprint $table) {
            $table->id('id');
            $table->string('kode');                 //INPUT PPIC
            $table->string('nama');                 //INPUT PPIC
            $table->string('ip');                   //INPUT PPIC
            $table->integer('kapasitas');           //INPUT PPIC
            $table->foreignId('satuanKapasitas');   //INPUT PPIC
            $table->string('keterangan');           //INPUT PPIC
            $table->string('hint');                 //INPUT PPIC
            //RELATION
            $table->foreign('satuanKapasitas')->references('id')->on('satuan')->cascadeOnDelete();
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
        Schema::dropIfExists('mesin');
    }
}
