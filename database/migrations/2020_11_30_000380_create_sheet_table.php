<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSheetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sheet', function (Blueprint $table) {
            $table->id('id');
            $table->string('kode')->unique();           //AUTO NUMBER SEQUENCE
            $table->string('nama');                     //Input MARKETING
            $table->integer('lebarSheet');              //Input MARKETING
            $table->integer('panjangSheet');            //Input MARKETING
            $table->foreignId('satuanSizeSheet');    //Input MARKETING
            $table->integer('luasSheet');               //Auto lebarSheet * panjangSheet
            $table->foreignId('satuanLuasSheet');    //Input MARKETING
            //RELATION
            $table->foreign('satuanSizeSheet')->references('id')->on('satuan')->cascadeOnDelete();
            $table->foreign('satuanLuasSheet')->references('id')->on('satuan')->cascadeOnDelete();
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
        Schema::dropIfExists('sheet');
    }
}
