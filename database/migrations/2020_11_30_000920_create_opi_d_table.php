<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpiDTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opi_d', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('opi_m_id')->index(); //AUTO
            $table->foreignId('mesin_id')->index(); //AUTO
            $table->string('noBukti')->index();     //INPUT PRODUKSI
            $table->dateTime('tgl_produksi')->index();     //INPUT PRODUKSI
            $table->integer('pcs');                 //INPUT PRODUKSI
            $table->integer('kg')->nullable();      //AUTO
            $table->integer('avgRp')->nullable();   //AUTO
            $table->string('keterangan')->nullable();  //INPUT PRODUKSI
            //RELATION
            $table->foreign('opi_m_id')->references('id')->on('opi_m')->cascadeOnDelete();
            $table->foreign('mesin_id')->references('id')->on('mesin')->cascadeOnDelete();
            // TRACKING
            $table->string('createdBy');                    //Auto ambil dari login
            $table->string('lastUpdatedBy')->nullable();    //Auto ambil dari login
            $table->boolean('deleted')->default(0);         //Update ketika di hapus (default false)
            $table->dateTime('deletedAt')->nullable();      //Auto ambil dari today()
            $table->string('deletedBy')->nullable();        //Auto ambil dari login
            $table->integer('printedKe')->nullable();       //Auto ambil dari login
            $table->timestamps('printedAt')->default('current_timestamp')->nullable();        //Auto ambil dari login
            $table->string('branch')->default('Lamongan')->index();              //Auto ambil dari login awal
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
        Schema::dropIfExists('opi_d');
    }
}
