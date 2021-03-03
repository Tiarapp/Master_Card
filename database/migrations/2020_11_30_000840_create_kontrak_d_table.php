<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKontrakDTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kontrak_d', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('kontrak_m_id')->index();    //Input Marketing pilih dari master item_bj_converting
            $table->foreignId('mc_id')->index();         //Auto ambil mid(item_bj_id,15,4)
            $table->float('pctToleransiPelengkapKontrak',5,2)->nullable();  //Input Marketing
            $table->integer('pcsToleransiPelengkapKontrak')->nullable();    //Input Marketing AUTO JIKA PCT DI INPUT (PCS KONTRAK*PCT TOLERANSI)
            $table->integer('kgPelengkapKontrak')->nullable();              //AUTO pcsKontrak * gramKontrak
            $table->integer('kgToleransiPelengkapKontrak')->nullable();     //AUTO (kontrak_d.pcsToleransiKontrak * kontrak_d.gramKontrak)
            $table->boolean('mcPelengkap')->default(FALSE)->index()->comment('TRUE (ADA PELENGKAP), FALSE (TDK ADA PELENGKAP)')->nullable();

            //RELATION
            $table->foreign('kontrak_m_id')->references('id')->on('kontrak_m')->cascadeOnDelete();
            $table->foreign('item_bj_id')->references('id')->on('item_bj')->cascadeOnDelete();
            $table->foreign('mc_id')->references('id')->on('mc')->cascadeOnDelete();
            // TRACKING
            $table->string('createdBy');                    //Auto ambil dari login
            $table->string('lastUpdatedBy')->nullable();    //Auto ambil dari login
            $table->dateTime('deletedAt')->nullable();      //Auto ambil dari today()
            $table->string('deletedBy')->nullable();        //Auto ambil dari login
            $table->integer('printedKe')->nullable();       //Auto ambil dari login
            $table->dateTime('printedAt')->nullable();      //Auto ambil dari login
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
        Schema::dropIfExists('kontrak_d');
    }
}
