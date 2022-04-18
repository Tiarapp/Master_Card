<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRollDTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roll_d', function (Blueprint $table) {
            $table->id('id');
            $table->string("kode_roll", 30)->unique();
            $table->foreignId('roll_m_id')->unsigned();
            $table->foreignId('supp_id')->unsigned();
            $table->string("kode_internal");
            $table->double("gsm_actual")->nullable();
            $table->double("cobsize_top")->nullable();
            $table->double("cobsize_back")->nullable();
            $table->double("stok"); //satuan Kilogram
            $table->string('created_by');

            $table->foreign('roll_m_id')->references('id')->on('roll_m')->cascadeOnDelete();
            $table->foreign('supp_id')->references('id')->on('master_supp')->cascadeOnDelete();

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
        Schema::dropIfExists('roll_d');
    }
}
