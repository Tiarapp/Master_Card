<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJointTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('joint', function (Blueprint $table) {
            $table->id('id');
            $table->string('kode')->unique();                   //AUTO NUMBER SEQUENCE
            $table->string('nama');                             //Input Mark
            $table->integer('qtyJoint')->nullable();            //Input Mark
            $table->foreignId('satuanJoint')->nullable();    //Input Mark
            $table->float('avgPrice',20,2);                     //Auto/input by Acc
            $table->foreignId('mataUang');                   //Auto/input by Acc
            //RELATION
            $table->foreign('satuanJoint')->references('id')->on('satuan')->cascadeOnDelete();
            $table->foreign('mataUang')->references('id')->on('mata_uang')->cascadeOnDelete();
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
        Schema::dropIfExists('joint');
    }
}
