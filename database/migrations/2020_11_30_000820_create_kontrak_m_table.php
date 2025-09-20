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
            $table->string('kode')->index();                     //AUTO NUMBER SEQUENCE
            $table->foreignId('mc_id')->index();                 //Auto ambil mid(item_bj_id,15,4)
            $table->date('tglKontrak')->index();                 //AUTO NUMBER SEQUENCE
            $table->string('customer_name')->index();            //Ambil dari TBLCustomer
            $table->string('custTelp')->index()->nullable();     //Input Marketing
            $table->string('poCustomer')->index()->nullable();               //Input Marketing
            $table->string('top')->index();                //Input Marketing
            $table->enum('caraKirim',['Kirim','Ambil Sendiri'])->nullable();    //Input Marketing
            $table->text('alamatKirim');                         //Input Marketing
            $table->text('alamatKantor')->nullable();            //Input Marketing
            $table->text('alamatTagihan')->nullable();           //Input Marketing
            // $table->integer('pcsKontrak');                       //AUTO SUM(kontrak_d.pcsKontrak)
            // $table->integer('pcsSisaKontrak')->nullable();             //Next Auto Sisa Kontrak yg belum di OPI/DT
            // $table->float('kgSisaKontrak', 10,2)->nullable();             //Next Auto Sisa Kontrak yg belum di OPI/DT
            // $table->float('kgKontrak',10,2)->nullable();               //AUTO SUM(kontrak_d.kgKontrak)
            $table->integer('amountBeforeTax')->nullable();         //AUTO DPP Auto harga * pcsKontrak
            $table->integer('tax')->nullable();                     //AUTO amountBeforeTax / 10
            $table->integer('amountTotal')->nullable();             //Auto amountBeforeTax + Tax
            // $table->float('rpKg',20,2)->nullable();                 //Auto sum(kontrak_d.amountBeforeTax) / sum(kontrak_d.kgKontrak)
            // $table->integer('sisaPlafon')->nullable();              //Next Auto Sisa Plafon per customer - amount
            // $table->string('status')->nullable()->index();          //Auto (Finish/Kurang xxx pcs)
            $table->boolean('lock')->default(FALSE);                //AUTO
            $table->string('sales')->nullable()->index();   //INPUT MARKETING
            $table->foreignId('mataUang')->nullable();                          //INPUT MARKETING
            $table->enum('tipe_harga',['PCS','KG'])->default('PCS')->index()->comment('PCS/KG');
            $table->enum('inExTax',['Include','Exclude'])->index()->nullable(); //Input Marketing
            $table->enum('tipeOrder',['Order Baru','Order Ulang','Order Ulang Perubahan'])->index();
            $table->string('status')->nullable();              //Input Marketing

            //RELATION
            $table->foreign('mataUang')->references('id')->on('mata_uang')->cascadeOnDelete();
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
        Schema::dropIfExists('kontrak_m');
    }
}
