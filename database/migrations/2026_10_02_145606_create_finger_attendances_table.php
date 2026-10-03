<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFingerAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finger_attendances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('source_user_id', 50);
            $table->dateTime('check_time');
            $table->string('check_type', 2)->nullable();
            $table->char('source_key', 64)->unique();
            $table->timestamps();

            $table->index(['source_user_id', 'check_time']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finger_attendances');
    }
}
