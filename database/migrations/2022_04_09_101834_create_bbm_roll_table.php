<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBbmRollTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bbm_roll', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('roll_d_id')->unsigned();
            $table->date('tgl_bbm');
            $table->double('berat_sj');
            $table->double('berat_timbang');
            $table->string('no_po');
            $table->string('created_by');

            $table->timestamps();
            $table->foreign('roll_d_id')->references('id')->on('roll_d')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bbm_roll');
    }
}
