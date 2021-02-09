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
            $table->string('kode')->unique()->index();  //AUTO NUMBER SEQUENCE
            $table->string('nama')->index();            //AUTO SHEET flute lebarSheet x panjang substance produksi
            $table->integer('lebarSheet');              //AUTO DARI MC
            $table->integer('panjangSheet');            //AUTO DARI MC
            $table->foreignId('satuanSizeSheet');       //AUTO DARI MC
            $table->integer('luasSheet');               //AUTO DARI MC
            $table->string('flute');                    //AUTO DARI MC
            $table->foreignId('substanceId');           //AUTO DARI MC
            $table->string('namaSubstance');            //AUTO DARI MC
            $table->integer('beratSheet');              //AUTO DARI MC
            $table->foreignId('satuanLuasSheet');       //AUTO DARI MC
            //RELATION
            $table->foreign('satuanSizeSheet')->references('id')->on('satuan')->cascadeOnDelete();
            $table->foreign('satuanLuasSheet')->references('id')->on('satuan')->cascadeOnDelete();
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
        Schema::dropIfExists('sheet');
    }
}
