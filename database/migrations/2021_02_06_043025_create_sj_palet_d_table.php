<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSjPaletDTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sj_palet_d', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('sj_palet_m_id'); //INPUT EXP
            $table->foreignId('item_palet_id'); //INPUT EXP
            $table->integer('qty');             //INPUT EXP
            $table->string('namaBarang');       //INPUT EXP
            $table->string('ukuran');           //INPUT EXP
            $table->string('noKontrak')->nullable();        //INPUT EXP
            $table->string('keterangan')->nullable();       //INPUT EXP
            //RELATION
            $table->foreign('sj_palet_m_id')->references('id')->on('sj_palet_m')->cascadeOnDelete();
            $table->foreign('item_palet_id')->references('id')->on('item_palet')->cascadeOnDelete();
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
        Schema::dropIfExists('sj_palet_d');
    }
}
