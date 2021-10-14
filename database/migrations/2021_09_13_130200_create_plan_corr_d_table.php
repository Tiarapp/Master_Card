<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanCorrDTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_corr_d', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('plan_corr_m_id')->unsigned();
            $table->foreignId('opi_id')->unsigned();
            $table->string('kode_plan_d');
            $table->integer('sheet_p');
            $table->integer('sheet_l');
            $table->string('flute');
            $table->string('bentuk');
            $table->integer('out_corr');
            $table->integer('out_flexo');
            $table->integer('qtyOrder');
            $table->integer('sisa');
            $table->integer('ukuran_roll');
            $table->integer('cop');
            $table->double('trim_waste',25);
            $table->integer('rm_order');
            $table->double('tonase',25);
            $table->integer('kebutuhan_kertasAtas')->nullable();
            $table->integer('kebutuhan_kertasdFlute1')->nullable();
            $table->integer('kebutuhan_kertasTengah')->nullable();
            $table->integer('kebutuhan_kertasFlute2')->nullable();
            $table->integer('kebutuhan_kertasBawah')->nullable();
            $table->string('keterangan');
            $table->string('status');
            $table->boolean('lock');
            //RELATION
            $table->foreign('plan_corr_m_id')->references('id')->on('plan_corr_m')->cascadeOnDelete();
            $table->foreign('opi_id')->references('id')->on('opi_m')->cascadeOnDelete();

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
        Schema::dropIfExists('plan_corr_d');
    }
}
