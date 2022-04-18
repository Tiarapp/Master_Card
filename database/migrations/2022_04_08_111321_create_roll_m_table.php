<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRollMTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roll_m', function (Blueprint $table) {
            $table->id('id');
            $table->string('nama')->unique();
            $table->string('jenis');
            $table->integer('gram');
            $table->integer('lebar');
            $table->string('created_by');
            $table->string('lastUpdatedBy')->nullable();
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
        Schema::dropIfExists('roll_m');
    }
}
