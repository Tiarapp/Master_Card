<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFTMASTKIRIMTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('f_TMASTKIRIM', function (Blueprint $table) {
            $table->id('id');
            $table->string('KDCUST')->nullable();
            $table->integer('EXT')->nullable();
            $table->string('NAMAKIRIM')->nullable();
            $table->string('ALAMATKIRIM')->nullable();
            $table->string('KOTAKIRIM')->nullable();
            $table->string('NEGARAKIRIM')->nullable();
            $table->string('TELPKIRIM')->nullable();
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
        Schema::dropIfExists('f_TMASTKIRIM');
    }
}
