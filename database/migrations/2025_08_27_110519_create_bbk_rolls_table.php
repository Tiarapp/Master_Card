<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBbkRollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bbk_rolls', function (Blueprint $table) {
            $table->id();
            $table->string('bbk_number')->nullable();
            $table->unsignedBigInteger('inventory_id');
            $table->date('tanggal_bbk');
            $table->integer('keluar');
            $table->integer('kembali')->default(0);
            $table->string('opi')->nullable();
            $table->string('keterangan')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('bbk_rolls');
    }
}
