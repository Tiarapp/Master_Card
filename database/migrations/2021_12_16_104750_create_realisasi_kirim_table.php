<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRealisasiKirimTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('realisasi_kirim', function (Blueprint $table) {
            $table->id();
            $table->foreignId("kontrak_m_id")->unsigned();
            $table->date('tanggal_kirim');
            $table->integer("qty_kirim");
            $table->double('kg_kirim')->nullable();
            $table->string('createdBy');   
            
            $table->foreign('kontrak_m_id')->references('id')->on('kontrak_m')->cascadeOnDelete();
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
        Schema::dropIfExists('realisasi_kirim');
    }
}
