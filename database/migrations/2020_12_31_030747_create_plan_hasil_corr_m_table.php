<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanHasilCorrMTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_hasil_corr_m', function (Blueprint $table) {
            $table->id('id');
            $table->integer('shift')->index();      //INPUT PPIC
            $table->string('regu')->index();        //INPUT PPIC
            $table->foreignId('mesin_id')->index(); //INPUT PPIC
            $table->foreignId('dt_id')->index();    //INPUT PPIC
            $table->string('kode')->index();        //AUTO NUMBER SEQ
            $table->dateTime('tglPlan')->index();   //AUTO EDITABLE
            $table->dateTime('tglHasil')->index();  //AUTO EDITABLE
            $table->integer('qtySetting')->nullable();        //AUTO COUNT(GANTI UKURAN ROLL)
            $table->integer('qtyGantiKertas')->nullable();    //AUTO COUNT(QTY ROLL YG DIBUTUHKAN) - QTY_SETTING
            $table->integer('pcsKebutuhanRoll')->nullable();  //AUTO COUNT STOCK
            $table->integer('kgKebutuhanRoll')->nullable();   //AUTO RUMUS
            $table->integer('pcsPlan')->index();     //INPUT PPIC
            $table->integer('kgPlan')->nullable();   //AUTO
            $table->integer('rmPlan')->nullable();   //AUTO
            $table->integer('pcsHasil')->nullable(); //INPUT PPIC
            $table->integer('kgHasil')->nullable();  //AUTO
            $table->integer('rmHasil')->nullable();  //INPUT PPIC
            $table->integer('kgWaste')->nullable();  //INPUT PPIC
            //RELATION
            $table->foreign('dt_id')->references('id')->on('dt')->cascadeOnDelete();
            $table->foreign('mesin_id')->references('id')->on('mesin')->cascadeOnDelete();
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
        Schema::dropIfExists('plan_hasil_corr_m');
    }
}
