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
            $table->string('noOpi');
            $table->string('mesin');
            $table->string('prod_start');
            $table->string('prod_end');
            $table->integer('jml_Order');
            $table->integer('hasil_baik');
            $table->integer('hasil_jelek');
            $table->string('keterangan');
            $table->enum('next_mesin',['FLEXO A', 'FLEXO B', 'FLEXO C', 'TOKAI', 'STITCH', 'GLUE MANUAL', 'WAX', 'STB']);

            $table->foreign('plan_conv_m_id')->references('id')->on('plan_conv_m')->cascadeOnDelete();
            $table->foreign('plan_conv_d_id')->references('id')->on('plan_conv_d')->cascadeOnDelete();
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
