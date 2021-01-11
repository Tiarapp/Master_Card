<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSTbTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_tbTransaksi', function (Blueprint $table) {
            $table->id('id');
            $table->string('Ex_In')->nullable();
            $table->dateTime('Tanggal')->nullable();
            $table->string('Nomor')->nullable();
            $table->string('COABank')->nullable();
            $table->string('JenisTransaksi')->nullable();
            $table->string('Jenis')->nullable();
            $table->string('No_BG')->nullable();
            $table->dateTime('TGL_BG')->nullable();
            $table->dateTime('JT_BG')->nullable();
            $table->dateTime('TglTerima_BG')->nullable();
            $table->dateTime('OutSupplier_BG')->nullable();
            $table->string('Tolakan_BG')->nullable();
            $table->string('SupplierCode')->nullable();
            $table->string('Pay_To')->nullable();
            $table->string('Pay_Through')->nullable();
            $table->string('General_Desc')->nullable();
            $table->dateTime('Tgl_Reimburse')->nullable();
            $table->string('No_Reimburse')->nullable();
            $table->dateTime('Tgl_PenyelesaianBS')->nullable();
            $table->string('No_PenyelesaianBS')->nullable();
            $table->dateTime('DataTransferred')->nullable();
            $table->dateTime('Tgl_Entry')->nullable();
            $table->string('Remark')->nullable();
            $table->string('Tick')->nullable();
            $table->string('SupAccount_Name')->nullable();
            $table->string('SupAccount_No')->nullable();
            $table->string('SupAccount_Curr')->nullable();
            $table->string('SupAccount_Bank')->nullable();
            $table->string('SupAccount_City')->nullable();
            $table->dateTime('PrintDate')->nullable();
            $table->string('UserLock')->nullable();
            $table->string('UserEntry')->nullable();
            $table->date('TglUpdate')->nullable();
            $table->string('UserUpdate')->nullable();
            $table->string('CustomerCode')->nullable();
            $table->string('Pay_From')->nullable();
            $table->dateTime('Due_date')->nullable();
            $table->string('Ext')->nullable();
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
        Schema::dropIfExists('s_tbTransaksi');
    }
}
