<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanConvMTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_conv_m', function (Blueprint $table) {
            $table->id('id');
            $table->integer('kode');
            $table->integer('shift')->unsigned();
            $table->date('tanggal');
            $table->string('revisi');
            $table->integer('total_pcs');
            $table->double('total_kg');
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
        Schema::dropIfExists('plan_conv_m');
    }
}
