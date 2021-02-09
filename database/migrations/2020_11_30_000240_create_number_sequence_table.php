<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNumberSequenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('number_sequence', function (Blueprint $table) {
            $table->id('id');
            $table->string('noBukti')->unique()->index();   //INPUT IT
            $table->foreignId('divisi_id')->index();        //INPUT IT
            $table->string('format');                       //INPUT IT
            $table->enum('reset',['Date','Month','Year'])->default('Month')->comment('Jika Month, butuh (Month & Year), Jika Date, butuh (Date, Month & Year)');   //INPUT IT
            //RELATION
            $table->foreign('divisi_id')->references('id')->on('divisi')->cascadeOnDelete();
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
        Schema::dropIfExists('number_sequence');
    }
}
