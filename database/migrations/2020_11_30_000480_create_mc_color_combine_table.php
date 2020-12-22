<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMcColorCombineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mc_color_combine', function (Blueprint $table) {
            $table->id('id');
            $table->string('kode');                 //AUTO NUMBER SEQUENCE
            $table->foreignId('mc_id');             //Auto waktu Create/Update MC
            $table->foreignId('color_combine_id');  //Auto waktu Create/Update MC
            //RELATION
            $table->foreign('mc_id')->references('id')->on('mc')->cascadeOnDelete();
            $table->foreign('color_combine_id')->references('id')->on('color_combine')->cascadeOnDelete();
            // TRACKING
            $table->string('createdBy');        //Auto ambil dari login
            $table->string('lastUpdatedBy')->nullable();    //Auto ambil dari login
            $table->boolean('deleted')->nullable();         //Update ketika di hapus (default false)
            $table->dateTime('deletedAt')->nullable();      //Auto ambil dari today()
            $table->string('deletedBy')->nullable();        //Auto ambil dari login
            $table->string('branch');           //Auto ambil dari login awal
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
        Schema::dropIfExists('mc_color_combine');
    }
}
