<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanHasilCorrDTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_hasil_corr_d', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('plan_hasil_corr_m_id')->index();     //AUTO
            $table->foreignId('opi_m_id')->index();     //AUTO
            $table->foreignId('opi_d_id')->index();     //AUTO
            $table->foreignId('kontrak_m_id')->index();     //AUTO
            $table->foreignId('kontrak_d_id')->index();     //AUTO
            $table->foreignId('mc_id')->index();        //AUTO
            $table->foreignId('item_bj_id')->index();   //AUTO
            $table->foreignId('customer_id')->index();  //AUTO
            $table->foreignId('flute_id')->index();     //AUTO
            $table->integer('outCorr')->index();        //INPUT
            $table->string('keterangan')->index();        //INPUT

            // PLAN
            $table->integer('supplierRollLinerAtasPlan')->index();     //AUTO
            $table->integer('supplierRollBfPlan')->index();            //AUTO
            $table->integer('supplierRollLinerTengahPlan')->index();   //AUTO
            $table->integer('supplierRollCfPlan')->index();            //AUTO
            $table->integer('supplierRollLinerBawahPlan')->index();    //AUTO
            $table->integer('jenisGramRollLinerAtasPlan')->index();     //AUTO
            $table->integer('jenisGramRollBfPlan')->index();            //AUTO
            $table->integer('jenisGramRollLinerTengahPlan')->index();   //AUTO
            $table->integer('jenisGramRollCfPlan')->index();            //AUTO
            $table->integer('jenisGramRollLinerBawahPlan')->index();    //AUTO
            $table->integer('lebarRollLinerAtasPlan')->index();     //INPUT
            $table->integer('lebarRollBfPlan')->index();            //INPUT
            $table->integer('lebarRollLinerTengahPlan')->index();   //INPUT
            $table->integer('lebarRollCfPlan')->index();            //INPUT
            $table->integer('lebarRollLinerBawahPlan')->index();    //INPUT
            $table->integer('rmPlan')->nullable();          //AUTO pcsPlan
            $table->integer('pcsCopPlan')->nullable();      //AUTO pcsPlan
            $table->integer('pcsToleransi')->nullable();    //INPUT
            $table->integer('pctToleransi')->nullable();    //INPUT
            $table->integer('pcsPLan')->nullable();         //INPUT
            $table->integer('kgBbLinerAtasPlan')->nullable();      //AUTO
            $table->integer('kgBbBfPlan')->nullable();             //AUTO
            $table->integer('kgBbLinerTengahPlan')->nullable();    //AUTO
            $table->integer('kgBbCfPlan')->nullable();             //AUTO
            $table->integer('kgBbLinerBawahPlan')->nullable();     //AUTO
            $table->integer('lebarTrimPlan')->nullable();     //AUTO
            $table->integer('pctTrimPlan')->nullable();     //AUTO
            
            // Real
            $table->integer('supplierRollPakaiLinerAtasReal')->nullable();     //INPUT
            $table->integer('supplierRollPakaiBfReal')->nullable();            //INPUT
            $table->integer('supplierRollPakaiLinerTengahReal')->nullable();   //INPUT
            $table->integer('supplierRollPakaiCfReal')->nullable();            //INPUT
            $table->integer('supplierRollPakaiLinerBawahReal')->nullable();    //INPUT
            $table->integer('jenisGramRollPakaiLinerAtasReal')->nullable();     //INPUT
            $table->integer('jenisGramRollPakaiBfReal')->nullable();            //INPUT
            $table->integer('jenisGramRollPakaiLinerTengahReal')->nullable();   //INPUT
            $table->integer('jenisGramRollPakaiCfReal')->nullable();            //INPUT
            $table->integer('jenisGramRollPakaiLinerBawahReal')->nullable();    //INPUT
            $table->integer('lebarRollPakaiLinerAtasReal')->nullable();     //INPUT
            $table->integer('lebarRollPakaiBfReal')->nullable();            //INPUT
            $table->integer('lebarRollPakaiLinerTengahReal')->nullable();   //INPUT
            $table->integer('lebarRollPakaiCfReal')->nullable();            //INPUT
            $table->integer('lebarRollPakaiLinerBawahReal')->nullable();    //INPUT
            $table->integer('kgBbLinerAtasReal')->nullable();       //AUTO
            $table->integer('kgBbBfReal')->nullable();              //AUTO
            $table->integer('kgBbLinerTengahReal')->nullable();     //AUTO
            $table->integer('kgBbCfReal')->nullable();              //AUTO
            $table->integer('kgBbLinerBawahReal')->nullable();      //AUTO
            $table->integer('lebarTrimReal')->nullable();           //AUTO
            $table->integer('pctTrimReal')->nullable();             //AUTO
            
            // HASIL
            $table->integer('rmHasil')->nullable();     //INPUT
            $table->integer('pcsCopHasil')->nullable(); //INPUT
            $table->integer('pcsHasil')->nullable();    //INPUT
            $table->integer('kgHasil')->nullable();     //INPUT
            $table->integer('kgWaste')->nullable();     //INPUT

            $table->dateTime('produksiStart');      //AUTO
            $table->dateTime('produksiFinish');     //AUTO
            $table->integer('produksiDurasi');      //AUTO
            $table->integer('produksiDownTime');    //AUTO

            //RELATION
            $table->foreign('plan_hasil_corr_m_id')->references('id')->on('plan_hasil_corr_m')->cascadeOnDelete();
            $table->foreign('opi_m_id')->references('id')->on('opi_m')->cascadeOnDelete();
            $table->foreign('opi_d_id')->references('id')->on('opi_d')->cascadeOnDelete();
            $table->foreign('kontrak_m_id')->references('id')->on('kontrak_m')->cascadeOnDelete();
            $table->foreign('kontrak_d_id')->references('id')->on('kontrak_d')->cascadeOnDelete();
            $table->foreign('mc_id')->references('id')->on('mc')->cascadeOnDelete();
            $table->foreign('item_bj_id')->references('id')->on('item_bj')->cascadeOnDelete();
            $table->foreign('customer_id')->references('id')->on('customer')->cascadeOnDelete();
            $table->foreign('flute_id')->references('id')->on('flute')->cascadeOnDelete();
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
        Schema::dropIfExists('plan_hasil_corr_d');
    }
}
