<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->id('id');
            $table->string('kode')->unique()->index();           //AUTO NUMBER SEQUENCE
            $table->string('nama')->index();                     //INPUT MARKETING
            $table->string('alias')->nullable()->index();        //INPUT MARKETING
            $table->string('nickName')->nullable()->index();     //INPUT MARKETING
            $table->string('KodeNamaAcc')->nullable()->index();  //INPUT MARKETING
            $table->string('NamaAcc')->nullable()->index();      //INPUT MARKETING
            $table->string('kodeAO')->nullable();       //INPUT MARKETING
            $table->string('npwp')->nullable();         //INPUT MARKETING
            $table->string('nppkp')->nullable();        //INPUT MARKETING
            $table->foreignId('alamatKantor_id')->nullable();       //INPUT MARKETING
            $table->foreignId('alamatKirim_id')->nullable();        //INPUT MARKETING
            $table->foreignId('alamatTagihan_id')->nullable();      //INPUT MARKETING
            $table->foreignId('sales_m_id')->nullable()->index();              //INPUT MARKETING
            $table->float('plafondReceivable',20,2)->nullable();    //INPUT ACC
            $table->float('plafondFinishGood',20,2)->nullable();    //INPUT MARKETING
            $table->integer('omsetMonth')->nullable()->comment('Omset Per Bulan')->index(); //INPUT MARKETING
            $table->integer('LeadTimePaymentDueDate')->nullable()->comment('average (Tgl BM - Tgl JT)')->index();           //AUTO
            $table->text('keterangan')->nullable()->comment('Keterangan Ttg Customer');           //INPUT MARKETING
            $table->date('firstKontrak')->nullable()->comment('Kontrak pertama');      //AUTO
            $table->date('lastKontrak')->nullable()->comment('Kontrak terakhir');      //AUTO
            $table->date('lastSj')->nullable()->comment('SJ terakhir');                //AUTO
            $table->date('lastPayment')->nullable()->comment('Pembayaran terakhir');   //AUTO
            $table->integer('avgRpKg')->nullable()->comment('Avg Rp/Kg')->index();               //INPUT MARKETING
            $table->integer('avgPaymentDay')->nullable()->comment('Avg Payment after Due Date(day)')->index();  //INPUT MARKETING
            $table->string('status')->default('Aktif')->comment('Aktif/No/Blokir Plafon/Blokir BJ')->index();                     //INPUT MARKETING
            $table->integer('top');                     //INPUT MARKETING
            //RELATION
            $table->foreign('alamatKantor_id')->references('id')->on('alamat')->cascadeOnDelete();
            $table->foreign('alamatKirim_id')->references('id')->on('alamat')->cascadeOnDelete();
            $table->foreign('alamatTagihan_id')->references('id')->on('alamat')->cascadeOnDelete();
            $table->foreign('sales_m_id')->references('id')->on('sales_m')->cascadeOnDelete();
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
        Schema::dropIfExists('customer');
    }
}
