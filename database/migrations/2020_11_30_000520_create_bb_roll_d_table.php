<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBbRollDTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bb_roll_d', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('bb_roll_m_id');          //AUTO NUMBER SEQUENCE
            $table->foreignId('jenisGramSj_id')->index();        //Input Log
            $table->foreignId('jenisGramSpa_id')->index();       //Input QC
            $table->foreignId('lebarRollSj_id')->index();        //Input Log
            $table->foreignId('lebarRollSpa_id')->index();       //Input Log
            $table->string('kodeRollSupplier')->index();         //Input Log
            $table->string('kodeRollIntern')->index();           //Input Log, next Auto
            $table->integer('diameter')->nullable()->index();    //Input Log
            $table->float('kadarAir',10,2)->nullable()->index(); //Input QC
            $table->float('cobbSize',10,2)->nullable()->index(); //Input QC
            $table->float('rct',10,2)->nullable()->index();      //Input QC
            $table->integer('qtyKgSj');                 //Input Log
            $table->integer('qtyKgSpa');                //Input Log
            $table->integer('qtyKgPakai');              //Auto qtyKgSpa-qtyKgSisa
            $table->integer('qtyKgSisa');               //Input Log
            $table->integer('avgPrice')->nullable();    //Auto / Input Acc
            $table->foreignId('mataUang')->nullable();  //Auto / Input Acc
            //RELATION
            $table->foreign('bb_roll_m_id')->references('id')->on('bb_roll_m')->cascadeOnDelete();
            $table->foreign('jenisGramSj_id')->references('id')->on('jenis_gram')->cascadeOnDelete();
            $table->foreign('jenisGramSpa_id')->references('id')->on('jenis_gram')->cascadeOnDelete();
            $table->foreign('lebarRollSj_id')->references('id')->on('lebar_roll')->cascadeOnDelete();
            $table->foreign('lebarRollSpa_id')->references('id')->on('lebar_roll')->cascadeOnDelete();
            $table->foreign('mataUang')->references('id')->on('mata_uang')->cascadeOnDelete();
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
        Schema::dropIfExists('bb_roll_d');
    }
}
