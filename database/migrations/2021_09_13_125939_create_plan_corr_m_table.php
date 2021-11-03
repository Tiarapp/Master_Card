<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanCorrMTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_corr_m', function (Blueprint $table) {
            $table->id();
            $table->string('kode_plan');
            $table->date('tanggal');
            $table->string('shift');
            $table->string('revisi');
            $table->integer('total_RM');
            $table->float('total_Berat');
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
        Schema::dropIfExists('plan_corr_m');
    }
}
