<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKontrakmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kontrak_m', function (Blueprint $table) {
            $table->id('id');
            $table->string('kode');                     //AUTO NUMBER SEQUENCE
            $table->foreignId('customer_id');           //Input Marketing
            $table->string('poCustomer');               //Input Marketing
            $table->foreignId('top_id');                //Input Marketing
            $table->enum('caraKirim',['Kirim','Ambil Sendiri']);    //Input Marketing
            $table->foreignId('alamatKirim_id');        //Input Marketing
            $table->foreignId('alamatKantor_id');       //Input Marketing
            $table->foreignId('alamatTagihan_id');      //Input Marketing
            $table->integer('pcsKontrak');              //AUTO SUM(kontrak_d.pcsKontrak)
            $table->float('pctToleransiKontrak',5,2);   //AUTO AVERAGE(kontrak_d.pctToleransiKontrak)
            $table->integer('pcsToleransiKontrak');     //AUTO SUM(kontrak_d.pcsToleransiKontrak)
            $table->integer('kgKontrak');               //AUTO SUM(kontrak_d.kgKontrak)
            $table->integer('kgToleransiKontrak');      //AUTO SUM(kontrak_d.pcsToleransiKontrak * kontrak_d.gramKontrak)
            $table->integer('amountBeforeTax');         //AUTO DPP Auto harga * pcsKontrak
            $table->integer('tax');                     //AUTO amountBeforeTax / 10
            $table->integer('amountTotal');             //Auto amountBeforeTax + Tax
            $table->float('rpKg',20,2);                 //Auto sum(kontrak_d.amountBeforeTax) / sum(kontrak_d.kgKontrak)
            $table->integer('sisaPlafon');              //Next Auto Sisa Plafon per customer - amount
            $table->string('status');                   //Auto (Finish/Kurang xxx pcs)
            $table->foreignId('sales_id');              //INPUT MARKETING
            $table->foreignId('mataUang');              //INPUT MARKETING
            
            //RELATION
            $table->foreign('customer_id')->references('id')->on('customer')->cascadeOnDelete();
            $table->foreign('top_id')->references('id')->on('top')->cascadeOnDelete();
            $table->foreign('alamatKirim_id')->references('id')->on('alamat')->cascadeOnDelete();
            $table->foreign('alamatKantor_id')->references('id')->on('alamat')->cascadeOnDelete();
            $table->foreign('alamatTagihan_id')->references('id')->on('alamat')->cascadeOnDelete();
            $table->foreign('sales_id')->references('id')->on('sales')->cascadeOnDelete();
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
        Schema::dropIfExists('kontrak_m');
    }
}
