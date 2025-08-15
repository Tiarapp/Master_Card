<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log', function (Blueprint $table) {
            $table->id('id');
            $table->string('username')->comment('Nama User');
            $table->dateTime('login');
            $table->dateTime('logout')->nullable();
            $table->dateTime('dateTimeTransaksi')->nullable();
            $table->string('transaksi')->nullable()->comment('Transaksi yang dilakukan');
            $table->string('ip')->nullable();
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
        Schema::dropIfExists('log');
    }
}
