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
            $table->string('kode')->unique()->index();                       //AUTO = QTYBOX
            $table->string('nama')->index();                                 //AUTO = QTYBOX
            $table->integer('qtyBox')->index();                              //Input Mark
            $table->string('satuanBox')->nullable();                                 //Input Mark
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
        Schema::dropIfExists('koli');
    }
}
