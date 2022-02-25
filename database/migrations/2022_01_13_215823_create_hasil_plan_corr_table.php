<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHasilPlanCorrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hasil_plan_corr', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_corr_m_id')->unsigned();
            $table->foreignId('plan_corr_d_id')->unsigned();
            $table->foreignId('opi_id')->unsigned();
            $table->string('no_opi');
            $table->string('hasil_baik');
            $table->string('hasil_jelek');
            $table->integer('sisa');
            $table->dateTime('start_prod');
            $table->dateTime('end_prod');
            $table->dateTime('prod_time');
            $table->string('prod_meter');
            $table->string('m2');
            $table->string('jml_palet');
            $table->enum('status', ['Proses', 'Belum Selesai', 'Selesai']);
            // $table->enum('next_mesin',['FLEXO A', 'FLEXO B', 'FLEXO C', 'TOKAI', 'STITCH', 'GLUE MANUAL', 'WAX', 'STB']);

            $table->foreign('plan_corr_m_id')->references('id')->on('plan_corr_m')->cascadeOnDelete();
            $table->foreign('plan_corr_d_id')->references('id')->on('plan_corr_d')->cascadeOnDelete();
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
        Schema::dropIfExists('hasil_plan_corr');
    }
}
