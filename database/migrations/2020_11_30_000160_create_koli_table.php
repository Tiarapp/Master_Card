<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKoliTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koli', function (Blueprint $table) {
            $table->id('id');
            $table->string('kode')->unique();                       //AUTO = QTYBOX
            $table->string('nama');                                 //AUTO = QTYBOX
            $table->integer('qtyBox');                              //Input Mark
            $table->foreignId('satuanBox');                      //Input Mark
            $table->integer('qtyStrapping')->nullable();            //Input PPIC
            $table->foreignId('satuanStrapping')->nullable();    //Input PPIC
            $table->float('avgPrice',20,2);         //Auto/input by Acc
            $table->foreignId('mataUang');       //Auto/input by Acc
            //RELATION
            $table->foreign('satuanBox')->references('id')->on('satuan')->cascadeOnDelete();
            $table->foreign('satuanStrapping')->references('id')->on('satuan')->cascadeOnDelete();
            $table->foreign('mataUang')->references('id')->on('mata_uang')->cascadeOnDelete();
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
        Schema::dropIfExists('koli');
    }
}
