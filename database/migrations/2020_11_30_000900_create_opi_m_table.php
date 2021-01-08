<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpiMTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opi_m', function (Blueprint $table) {
            $table->id('id');
            $table->string('kode')->index();     //AUTO
            $table->string('nama')->index();     //AUTO
            $table->foreignId('dt_id')->nullable()->index();        //INPUT PPIC
            $table->foreignId('mc_id')->nullable()->index();        //AUTO
            $table->foreignId('kontrak_m_id')->nullable()->index(); //AUTO
            $table->foreignId('kontrak_d_id')->nullable()->index(); //AUTO
            $table->text('keterangan')->nullable(); //INPUT PPIC
            //RELATION
            $table->foreign('dt_id')->references('id')->on('dt')->cascadeOnDelete();
            $table->foreign('mc_id')->references('id')->on('mc')->cascadeOnDelete();
            $table->foreign('kontrak_m_id')->references('id')->on('kontrak_m')->cascadeOnDelete();
            $table->foreign('kontrak_d_id')->references('id')->on('kontrak_d')->cascadeOnDelete();
            // TRACKING
            $table->string('createdBy');        //Auto ambil dari login
            $table->string('lastUpdatedBy')->nullable();    //Auto ambil dari login
            $table->boolean('deleted')->default(0);         //Update ketika di hapus (default false)
            $table->dateTime('deletedAt')->nullable();      //Auto ambil dari today()
            $table->string('deletedBy')->nullable();        //Auto ambil dari login
            $table->string('branch')->default('Lamongan')->index();           //Auto ambil dari login awal
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
        Schema::dropIfExists('opi_m');
    }
}
