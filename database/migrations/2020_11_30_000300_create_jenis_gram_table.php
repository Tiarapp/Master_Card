<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJenisGramTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jenis_gram', function (Blueprint $table) {
            $table->id('id');
            $table->string('kode')->unique()->index();       //AUTO NUMBER SEQUENCE
            $table->string('nama')->nullable()->index();     //INPUT MARKETING
            $table->string('jenisKertas')->index();          //INPUT MARKETING
            $table->string('gramKertas')->index();           //INPUT MARKETING
            // TRACKING
            $table->string('createdBy');        //Auto ambil dari login
            $table->string('lastUpdatedBy')->nullable();    //Auto ambil dari login
            $table->boolean('deleted')->default(0);         //Update ketika di hapus (default false)
            $table->dateTime('deletedAt')->nullable();      //Auto ambil dari today()
            $table->string('deletedBy')->nullable();        //Auto ambil dari login
            $table->string('branch')->default('Lamongan')->index();           //Auto ambil dari login awal
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
        Schema::dropIfExists('jenis_gram');
    }
}
