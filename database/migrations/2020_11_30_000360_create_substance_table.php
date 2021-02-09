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
            $table->string('kode')->unique()->index();                          //AUTO NUMBER SEQUENCE
            $table->string('nama')->index();                                    //AUTO jenis+...
            $table->foreignId('jenisGramLinerAtas_id')->index();                //Input Marketing
            $table->foreignId('jenisGramBf_id')->nullable()->index();           //Input Marketing
            $table->foreignId('jenisGramLinerTengah_id')->nullable()->index();  //Input Marketing
            $table->foreignId('jenisGramCf_id')->nullable()->index();           //Input Marketing
            $table->foreignId('jenisGramLinerBawah_id')->index();               //Input Marketing
            //RELATION
            $table->foreign('jenisGramLinerAtas_id')->references('id')->on('jenis_gram')->cascadeOnDelete();
            $table->foreign('jenisGramBf_id')->references('id')->on('jenis_gram')->cascadeOnDelete();
            $table->foreign('jenisGramLinerTengah_id')->references('id')->on('jenis_gram')->cascadeOnDelete();
            $table->foreign('jenisGramCf_id')->references('id')->on('jenis_gram')->cascadeOnDelete();
            $table->foreign('jenisGramLinerBawah_id')->references('id')->on('jenis_gram')->cascadeOnDelete();
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
        Schema::dropIfExists('substance');
    }
}
