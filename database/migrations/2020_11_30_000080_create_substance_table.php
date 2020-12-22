<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubstanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('substance', function (Blueprint $table) {
            $table->id('id');
            $table->string('kode')->unique();                           //AUTO NUMBER SEQUENCE
            $table->string('nama');                                     //AUTO jenis+...
            $table->foreignId('jenisGramLinerAtas_id');                 //Input Marketing
            $table->foreignId('jenisGramBF_id');                        //Input Marketing
            $table->foreignId('jenisGramLinerTengah_id')->nullable();   //Input Marketing
            $table->foreignId('jenisGramCF_id')->nullable();            //Input Marketing
            $table->foreignId('jenisGramLinerBawah_id');                //Input Marketing
            //RELATION
            $table->foreign('jenisGramLinerAtas_id')->references('id')->on('jenis_gram')->cascadeOnDelete();
            $table->foreign('jenisGramBF_id')->references('id')->on('jenis_gram')->cascadeOnDelete();
            $table->foreign('jenisGramLinerTengah_id')->references('id')->on('jenis_gram')->cascadeOnDelete();
            $table->foreign('jenisGramCF_id')->references('id')->on('jenis_gram')->cascadeOnDelete();
            $table->foreign('jenisGramLinerBawah_id')->references('id')->on('jenis_gram')->cascadeOnDelete();
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
        Schema::dropIfExists('substance');
    }
}
