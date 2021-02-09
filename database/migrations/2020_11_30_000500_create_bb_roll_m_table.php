<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBBRollMTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bb_roll_m', function (Blueprint $table) {
            $table->id('id');
            $table->string('kode')->unique()->index();   //AUTO NUMBER SEQUENCE
            $table->foreignId('supplier_id')->index();   //INPUT LOG
            $table->foreignId('jenisGram_id')->index();  //INPUT LOG
            $table->foreignId('lebarRoll_id')->index();  //INPUT LOG
            $table->integer('qtyPcsAll');       //Auto count(where bb_roll_d.supplier.id, bb_roll_d.jenis_GramSpa.id, bb_roll_d.lebarRollSpa.id)
            $table->integer('qtyKgAll');        //Auto sum(bb_roll_d.qtyKgSisa)
            $table->integer('qtyPcsFree');      //Auto (All-Picked-Reserved)
            $table->integer('qtyKgFree');       //Auto (All-Picked-Reserved)
            $table->integer('qtyPcsPicked');    //Auto Picked ketika ada Kontrak
            $table->integer('qtyKgPicked');     //Auto Picked ketika ada Kontrak
            $table->integer('qtyPcsReserved');  //Auto Reserved ketika ada Plan Produksi
            $table->integer('qtyKgReserved');   //Auto Reserved ketika ada Plan Produksi
            $table->integer('avgPrice');        //Auto/input by Acc
            $table->foreignId('mataUang');   //Auto/input by Acc
            //RELATION
            $table->foreign('supplier_id')->references('id')->on('supplier')->cascadeOnDelete();
            $table->foreign('jenisGram_id')->references('id')->on('jenis_gram')->cascadeOnDelete();
            $table->foreign('lebarRoll_id')->references('id')->on('lebar_roll')->cascadeOnDelete();
            $table->foreign('mataUang')->references('id')->on('mata_uang')->cascadeOnDelete();
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
        Schema::dropIfExists('bb_roll_m');
    }
}
