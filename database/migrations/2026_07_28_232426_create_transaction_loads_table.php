<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionLoadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_loads', function (Blueprint $table) {
            $table->id();
            $table->string('driver_name');
            $table->string('vehicle_number');
            $table->unsignedBigInteger('masterdata_id');
            $table->enum('type', ['customer', 'supplier']);
            $table->enum('status', ['load', 'unload']);
            $table->date('date_in');
            $table->date('date_out')->nullable();
            $table->string('destination')->nullable();
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
        Schema::dropIfExists('transaction_loads');
    }
}
