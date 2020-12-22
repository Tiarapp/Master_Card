<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dt', function (Blueprint $table) {
            $table->id('id');
            $table->date('tglKirim');               //INPUT MARKETING
            $table->string('hariKirim')->nullable();   //INPUT MARKETING NEXT AUTO
            $table->string('no_mod')->nullable();   //INPUT MARKETING NEXT AUTO
            $table->foreignId('kontrak_d_id');      //INPUT MARKETING
            $table->foreignId('mc_id');             //INPUT MARKETING
            $table->integer('pcsDt');               //INPUT MARKETING
            $table->integer('kgDt');                //INPUT MARKETING
            $table->string('opi')->nullable();      //AUTO UPDATE KETIKA SIMPAN/UPDATE DIPLANNING PPIC
            $table->boolean('lock');                //INPUT MARKETING
            //RELATION
            $table->foreign('kontrak_d_id')->references('id')->on('kontrak_d')->cascadeOnDelete();
            $table->foreign('mc_id')->references('id')->on('mc')->cascadeOnDelete();
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
        Schema::dropIfExists('dt');
    }
}
