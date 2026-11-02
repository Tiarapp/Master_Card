<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanKirimTables extends Migration
{
    public function up()
    {
        Schema::create('plan_kirim', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150);
            $table->date('tgl_plan')->nullable();
            $table->text('catatan')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('plan_kirim_item', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plan_kirim_id');
            $table->unsignedBigInteger('opi_id')->index();
            $table->unsignedInteger('urutan');
            $table->timestamps();

            $table->foreign('plan_kirim_id')->references('id')->on('plan_kirim')->onDelete('cascade');
            $table->unique(['plan_kirim_id', 'opi_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('plan_kirim_item');
        Schema::dropIfExists('plan_kirim');
    }
}
