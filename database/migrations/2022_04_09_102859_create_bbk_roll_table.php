<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBbkRollTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bbk_roll', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('roll_d_id')->unsigned();
            $table->date('tgl_bbk');
            $table->string('No_OPI');
            $table->string('subs'); 
            $table->double('bbk');
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
        Schema::dropIfExists('bbk_roll');
    }
}
