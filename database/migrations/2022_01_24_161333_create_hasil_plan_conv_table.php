<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHasilPlanConvTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hasil_plan_conv', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('plan_conv_m_id')->unsigned();
            $table->foreignId('plan_conv_d_id')->unsigned();
            $table->foreignId('opi_id')->unsigned();
            $table->string('noOpi');
            $table->string('mesin1')->nullable();
            $table->string('mesin2')->nullable();
            $table->string('mesin3')->nullable();
            $table->string('mesin4')->nullable();
            $table->string('mesin5')->nullable();
            $table->string('mesin6')->nullable();
            $table->integer('jml_Order')->nullable();
            $table->date('tgl_mesin1')->nullable();
            $table->integer('hasil_baik_mesin1')->nullable();
            $table->integer('hasil_jelek_mesin1')->nullable();
            $table->date('tgl_mesin2')->nullable();
            $table->integer('hasil_baik_mesin2')->nullable();
            $table->integer('hasil_jelek_mesin2')->nullable();
            $table->date('tgl_mesin3')->nullable();
            $table->integer('hasil_baik_mesin3')->nullable();
            $table->integer('hasil_jelek_mesin3')->nullable();
            $table->date('tgl_mesin4')->nullable();
            $table->integer('hasil_baik_mesin4')->nullable();
            $table->integer('hasil_jelek_mesin4')->nullable();
            $table->date('tgl_mesin5')->nullable();
            $table->integer('hasil_baik_mesin5')->nullable();
            $table->integer('hasil_jelek_mesin5')->nullable();
            $table->date('tgl_mesin6')->nullable();
            $table->integer('hasil_baik_mesin6')->nullable();
            $table->integer('hasil_jelek_mesin6')->nullable();
            $table->string('keterangan')->nullable();

            $table->foreign('plan_conv_m_id')->references('id')->on('plan_conv_m')->cascadeOnDelete();
            $table->foreign('plan_conv_d_id')->references('id')->on('plan_conv_d')->cascadeOnDelete();
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
        Schema::dropIfExists('hasil_plan_conv');
    }
}
