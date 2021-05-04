<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBomDTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bom_d', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('bom_m_id')->index();         //AUTO
            $table->foreignId('bomComponent_id')->index();  //INPUT PPIC
            $table->float('qty',20,8);                      //INPUT PPIC
            $table->foreignId('satuan');                    //INPUT PPIC
            $table->integer('avg_price');                   //INPUT ACC
            $table->foreignId('mataUang')->nullable();      //INPUT ACC
            //RELATION
            $table->foreign('bom_m_id')->references('id')->on('bom_m')->cascadeOnDelete();
            $table->foreign('bomComponent_id')->references('id')->on('bom_component')->cascadeOnDelete();
            $table->foreign('satuan')->references('id')->on('satuan')->cascadeOnDelete();
            $table->foreign('mataUang')->references('id')->on('mata_uang')->cascadeOnDelete();
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
        Schema::dropIfExists('bom_d');
    }
}
