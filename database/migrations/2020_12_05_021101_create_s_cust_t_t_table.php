<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSCustTTTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_CustTT', function (Blueprint $table) {
            $table->id('id'); //Not Finish
            // $table->string('NomorTT')->nullable();
            // $table->dateTime('Tanggal')->nullable();
            // $table->string('CustCode')->nullable();
            // $table->string('CustPIC')->nullable();
            // $table->string('user_entry')->nullable();
            // $table->dateTime('date_entry')->nullable();
            // $table->string('CustName')->nullable();
            // $table->string('NoResi')->nullable();
            // $table->string('Ekspedisi')->nullable();
            $table->datetime('created_at')->default(now());
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s_CustTT');
    }
}
