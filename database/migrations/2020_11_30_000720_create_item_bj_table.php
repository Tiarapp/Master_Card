<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemBjTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_bj', function (Blueprint $table) {
            $table->id('id');
            $table->string('kode')->unique()->index();  //Import Firebird
            $table->string('nama')->index();            //Import Firebird
            $table->string('alias')->nullable()->index();           //Input (pilihan cetaknya 2 macam bisa nama atau alias)
            $table->string('mc_id')->index();           //Auto dari kode Barang Firebird
            $table->float('gram',8,2)->nullable();        //Auto Stock
            $table->integer('pcs')->nullable();         //Auto Stock
            $table->integer('kg')->nullable();          //Auto Stock
            $table->string('lokasi')->nullable()->index();          //Input Logistik BJ
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
        Schema::dropIfExists('item_bj');
    }
}
