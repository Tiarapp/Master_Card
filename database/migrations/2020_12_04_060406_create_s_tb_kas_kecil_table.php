<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSTbKasKecilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_tbKasKecil', function (Blueprint $table) {
            $table->id('id');
            $table->string('Ex_In')->nullable();
            $table->dateTime('Tanggal')->nullable();
            $table->string('Nomor')->nullable();
            $table->dateTime('BS_Duedate')->nullable();
            $table->string('COAKasKecil')->nullable();
            $table->string('JenisTransaksi')->nullable();
            $table->string('SupplierCode')->nullable();
            $table->string('Pay_Through')->nullable();
            $table->dateTime('Tgl_Reimburse')->nullable();
            $table->string('No_Reimburse')->nullable();
            $table->dateTime('Tgl_PenyelesaianBS')->nullable();
            $table->dateTime('No_PenyelesaianBS')->nullable();
            $table->dateTime('DataTransferred')->nullable();
            $table->dateTime('Tgl_Entry')->nullable();
            $table->string('Remark')->nullable();
            $table->string('Tick')->nullable();
            $table->integer('Completed')->nullable();
            $table->string('UserEntry')->nullable();
            $table->string('userUpdate')->nullable();
            $table->dateTime('tglUpdate')->nullable();
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
        Schema::dropIfExists('s_tbKasKecil');
    }
}
