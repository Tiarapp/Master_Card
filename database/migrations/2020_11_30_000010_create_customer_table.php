<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->id('id');
            $table->string('kode');                     //AUTO NUMBER SEQUENCE
            $table->string('nama');                     //INPUT MARKETING
            $table->string('alias')->nullable();        //INPUT MARKETING
            $table->string('shortName')->nullable();    //INPUT MARKETING
            $table->string('nickName')->nullable();     //INPUT MARKETING
            $table->string('KodeNamaAcc')->nullable();  //INPUT MARKETING
            $table->string('NamaAcc')->nullable();      //INPUT MARKETING
            $table->string('kodeAO')->nullable();       //INPUT MARKETING
            $table->string('npwp')->nullable();         //INPUT MARKETING
            $table->string('nppkp')->nullable();        //INPUT MARKETING
            $table->foreignId('alamatKantor_id')->nullable();       //INPUT MARKETING
            $table->foreignId('alamatKirim_id')->nullable();        //INPUT MARKETING
            $table->foreignId('alamatTagihan_id')->nullable();      //INPUT MARKETING
            $table->float('Plafond',20,2)->nullable();              //INPUT MARKETING
            $table->integer('top');                     //INPUT MARKETING
            //RELATION
            $table->foreign('alamatKantor_id')->references('id')->on('alamat')->cascadeOnDelete();
            $table->foreign('alamatKirim_id')->references('id')->on('alamat')->cascadeOnDelete();
            $table->foreign('alamatTagihan_id')->references('id')->on('alamat')->cascadeOnDelete();
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
        Schema::dropIfExists('customer');
    }
}
