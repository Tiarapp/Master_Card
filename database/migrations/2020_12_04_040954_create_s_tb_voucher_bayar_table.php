<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSTbVoucherBayarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_tbVoucherBayar', function (Blueprint $table) {
            $table->id('id');
            $table->string('Ex_In')->nullable();
            $table->string('Nomor')->nullable();
            $table->dateTime('Tanggal')->nullable();
            $table->dateTime('DueDate')->nullable();
            $table->string('COA_Lawan')->nullable();
            $table->string('SupplierCode')->nullable();
            $table->string('Pay_to')->nullable();
            $table->string('SupplierExt')->nullable();
            $table->string('Pay_Through')->nullable();
            $table->string('Jenis_Transaksi')->nullable();
            $table->string('General_Desc')->nullable();
            $table->string('Kd_Posting')->nullable();
            $table->string('Tgl_Posting')->nullable();
            $table->string('Keterangan')->nullable();
            $table->string('SupAccount_Name')->nullable();
            $table->string('SupAccount_No')->nullable();
            $table->string('SupAccount_Curr')->nullable();
            $table->string('SupAccount_Bank')->nullable();
            $table->string('SupAccount_City')->nullable();
            $table->string('tick')->nullable();
            $table->dateTime('TglJTTT')->nullable();
            $table->dateTime('PrintDate')->nullable();
            $table->dateTime('PrintDate1')->nullable();
            $table->integer('Completed')->nullable();
            $table->string('userEntry')->nullable();
            $table->string('userUpdate')->nullable();
            $table->dateTime('tglentry')->nullable();
            $table->dateTime('tglupdate')->nullable();
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
        Schema::dropIfExists('s_tbVoucherBayar');
    }
}
