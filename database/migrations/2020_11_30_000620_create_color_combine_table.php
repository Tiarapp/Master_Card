<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColorCombineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('color_combine', function (Blueprint $table) {
            $table->id('id');
            $table->string('kode')->unique();           //AUTO NUMBER SEQUENCE
            $table->string('nama')->nullable();         //CONCATENATE idColor1+....
            $table->foreignId('idColor1')->nullable();  //INPUT DESAIN
            $table->foreignId('idColor2')->nullable();  //INPUT DESAIN
            $table->foreignId('idColor3')->nullable();  //INPUT DESAIN
            $table->foreignId('idColor4')->nullable();  //INPUT DESAIN
            //RELATION
            $table->foreign('idColor1')->references('id')->on('color')->cascadeOnDelete();
            $table->foreign('idColor2')->references('id')->on('color')->cascadeOnDelete();
            $table->foreign('idColor3')->references('id')->on('color')->cascadeOnDelete();
            $table->foreign('idColor4')->references('id')->on('color')->cascadeOnDelete();
            // TRACKING
            $table->string('createdBy');        //Auto ambil dari login
            $table->string('lastUpdatedBy')->nullable();    //Auto ambil dari login
            $table->boolean('deleted')->default(0);         //Update ketika di hapus (default false)
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
        Schema::dropIfExists('color_combine');
    }
}
