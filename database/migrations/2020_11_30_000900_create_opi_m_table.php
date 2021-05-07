<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpiMTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opi_m', function (Blueprint $table) {
            $table->id('id');
            $table->string('NoOPI')->index();     //AUTO OPI
            $table->string('nama')->index();     //AUTO
            $table->foreignId('dt_id')->nullable()->index();        //INPUT PPIC
            $table->string('noMod')->nullable()->index();   //INPUT MARKETING NEXT AUTO
            $table->foreignId('mc_id')->nullable()->index();        //AUTO
            $table->foreignId('kontrak_m_id')->nullable()->index(); //AUTO
            $table->foreignId('kontrak_d_id')->nullable()->index(); //AUTO
            $table->text('keterangan')->nullable(); //INPUT PPIC
            // TRACKING
            $table->string('createdBy');                    //Auto ambil dari login
            $table->string('lastUpdatedBy')->nullable();    //Auto ambil dari login
            $table->dateTime('deletedAt')->nullable();      //Auto ambil dari today()
            $table->string('deletedBy')->nullable();        //Auto ambil dari login
            $table->integer('printedKe')->nullable();       //Auto ambil dari login
            $table->dateTime('printedAt')->nullable();      //Auto ambil dari login
            $table->string('branch')->default('Lamongan')->index();              //Auto ambil dari login awal
            $table->timestamps();

            $table->date('tglKirimDt')->index();            //INPUT MARKETING
            $table->string('hariKirimDt');                  //AUTO
            $table->integer('pcsDt')->nullable();           //INPUT MARKETING
            $table->integer('kgDt');                        //AUTO FAKTUR
            $table->boolean('lock')->default(0);        //AUTO WHEN PPIC INSERT/UPDATE PLANNING
            //RELATION
            $table->foreign('kontrak_m_id')->references('id')->on('kontrak_m')->cascadeOnDelete();
            $table->foreign('kontrak_d_id')->references('id')->on('kontrak_d')->cascadeOnDelete();
            $table->foreign('mc_id')->references('id')->on('mc')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('opi_m');
    }
}
