<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier', function (Blueprint $table) {
            $table->id('id');
            $table->string('kode')->unique();           //AUTO NUMBER SEQUENCE
            $table->string('nama');                     //INPUT IT
            $table->string('KodeNamaAcc')->nullable();  //INPUT IT
            $table->string('NamaAcc')->nullable();      //INPUT IT
            $table->foreignId('alamatKantor_id');       //INPUT IT
            $table->foreignId('alamatToko_id');         //INPUT IT
            $table->string('npwp')->nullable();         //INPUT IT
            $table->string('nppkp')->nullable();         //INPUT IT
            $table->string('bank')->nullable();          //INPUT IT
            $table->string('noRekening')->nullable();    //INPUT IT
            $table->string('namaRekening')->nullable();  //INPUT IT
            $table->float('plafond',20,2);               //INPUT IT
            $table->integer('top');                      //INPUT IT
            $table->enum('jenisBayar',['TUNAI','HUTANG']);  //INPUT IT
            //RELATION
            $table->foreign('alamatKantor_id')->references('id')->on('alamat')->cascadeOnDelete();
            $table->foreign('alamatToko_id')->references('id')->on('alamat')->cascadeOnDelete();
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
        Schema::dropIfExists('supplier');
    }
}
