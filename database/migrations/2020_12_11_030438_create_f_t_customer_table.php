<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFTCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('f_TCustomer', function (Blueprint $table) {
            $table->id('id');
            $table->string('Kode')->nullable();
            $table->string('Nama')->nullable();
            $table->string('ShortName')->nullable();
            $table->string('NickName')->nullable();
            $table->string('KodeAO')->nullable();
            $table->string('KodeArea')->nullable();
            $table->string('NPWP')->nullable();
            $table->string('NPPKP')->nullable();
            $table->string('AlamatKantor')->nullable();
            $table->string('NegaraKantor')->nullable();
            $table->string('TelpKantor')->nullable();
            $table->string('FaxKantor')->nullable();
            $table->string('KotaKantor')->nullable();
            $table->string('PIC')->nullable();
            $table->string('AlamatKirim')->nullable();
            $table->string('NegaraKirim')->nullable();
            $table->string('TelpKirim')->nullable();
            $table->string('KotaKirim')->nullable();
            $table->string('AreaJual')->nullable();
            $table->string('ProdukJual')->nullable();
            $table->string('Coverage')->nullable();
            $table->float('Plafond',18,2)->nullable();
            $table->string('KodeNamaAcc')->nullable();
            $table->string('NamaAcc')->nullable();
            $table->string('AlamatAcc')->nullable();
            $table->string('KotaAcc')->nullable();
            $table->string('KodeGroupAcc')->nullable();
            $table->string('GroupAcc')->nullable();
            $table->float('Plafond2',18,2)->nullable();
            $table->integer('WAKTUBAYAR')->nullable();
            $table->integer('DILIMIT')->nullable();
            $table->integer('TRBANK')->nullable();
            $table->datetime('created_at')->default(now());
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('f_TCustomer');
    }
}
