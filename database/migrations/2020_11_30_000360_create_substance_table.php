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
            $table->string('namaMc')->index();                                    //AUTO jenis+...
            $table->string('namaLog')->index();                                    //AUTO jenis+...
            $table->string('flute')->index();                                   //Dropdown Marketing
            $table->foreignId('jenisGramLinerAtas_id')->index();                //Input Marketing
            $table->foreignId('jenisGramFlute1_id')->nullable()->index();           //Input Marketing
            $table->foreignId('jenisGramLinerTengah_id')->nullable()->index();  //Input Marketing
            $table->foreignId('jenisGramFlute2_id')->nullable()->index();           //Input Marketing
            $table->foreignId('jenisGramLinerBawah_id')->index();               //Input Marketing
            //RELATION
            $table->foreign('jenisGramLinerAtas_id')->references('id')->on('jenis_gram')->cascadeOnDelete();
            $table->foreign('jenisGramFlute1_id')->references('id')->on('jenis_gram')->cascadeOnDelete();
            $table->foreign('jenisGramLinerTengah_id')->references('id')->on('jenis_gram')->cascadeOnDelete();
            $table->foreign('jenisGramFlute2_id')->references('id')->on('jenis_gram')->cascadeOnDelete();
            $table->foreign('jenisGramLinerBawah_id')->references('id')->on('jenis_gram')->cascadeOnDelete();
            // TRACKING
            $table->string('createdBy');                    //Auto ambil dari login
            $table->string('lastUpdatedBy')->nullable();    //Auto ambil dari login
            $table->dateTime('deletedAt')->nullable();      //Auto ambil dari today()
            $table->string('deletedBy')->nullable();        //Auto ambil dari login
            $table->integer('printedKe')->nullable();       //Auto ambil dari login
            $table->dateTime('printedAt')->nullable();      //Auto ambil dari login
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
