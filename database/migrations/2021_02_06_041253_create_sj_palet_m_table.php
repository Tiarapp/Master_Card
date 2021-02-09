<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSjPaletMTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sj_palet_m', function (Blueprint $table) {
            $table->id('id');
            $table->string('noSuratJalan');               //INPUT EXP
            $table->date('tanggal');                      //INPUT EXP
            $table->string('noPolisi');                   //INPUT EXP
            $table->string('noPoCustomer')->nullable();   //INPUT EXP
            $table->string('namaCustomer')->nullable();   //INPUT EXP
            $table->string('alamatCustomer')->nullable(); //INPUT EXP
            $table->text('catatan')->nullable();          //INPUT EXP
            // TRACKING
            $table->string('createdBy');                    //Auto ambil dari login
            $table->string('lastUpdatedBy')->nullable();    //Auto ambil dari login
            $table->boolean('deleted')->default(0);         //Update ketika di hapus (default false)
            $table->dateTime('deletedAt')->nullable();      //Auto ambil dari today()
            $table->string('deletedBy')->nullable();        //Auto ambil dari login
            $table->integer('printedKe')->nullable();       //Auto ambil dari login
            $table->string('ip')->nullable();               //Auto ambil dari login
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
        Schema::dropIfExists('sj_palet_m');
    }
}
