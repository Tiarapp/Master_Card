<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSTbTransaksiDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_tbTransaksi_Detail', function (Blueprint $table) {
            $table->id('id');
            $table->string('Nomor')->nullable();
            $table->string('No_BG')->nullable();
            $table->string('Line')->nullable();
            $table->string('BPB_No')->nullable();
            $table->string('Vo_No')->nullable();
            $table->string('Kode_Dept')->nullable();
            $table->string('SupplierCode')->nullable();
            $table->string('Pay_To')->nullable();
            $table->string('SupplierExt')->nullable();
            $table->string('Description')->nullable();
            $table->string('RefDate')->nullable();
            $table->string('RefNo')->nullable();
            $table->string('NoProyek')->nullable();
            $table->string('RincPakai')->nullable();
            $table->string('NoPolisi')->nullable();
            $table->string('KM')->nullable();
            $table->string('COA')->nullable();
            $table->string('COA_Lawan')->nullable();
            $table->string('Curr1')->nullable();
            $table->float('Nilai1',18,4)->nullable();
            $table->float('ExRate',18,4)->nullable();
            $table->string('Curr2')->nullable();
            $table->float('Nilai2',18,4)->nullable();
            $table->float('ExRate3',18,4)->nullable();
            $table->float('Nilai3',18,4)->nullable();
            $table->string('Remark')->nullable();
            $table->string('MasaSPT')->nullable();
            $table->string('PO_No')->nullable();
            $table->dateTime('DataTransferred')->nullable();
            $table->string('BBM_Paid')->nullable();
            $table->date('TglEntry')->nullable();
            $table->string('UserEntry')->nullable();
            $table->date('TglUpdate')->nullable();
            $table->string('UserUpdate')->nullable();
            $table->dateTime('Due_Date')->nullable();
            $table->string('KdUnit')->nullable();
            $table->float('DefAmount',18,4)->nullable();
            $table->string('NoFP')->nullable();
            $table->string('NoKwitansi')->nullable();
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
        Schema::dropIfExists('s_tbTransaksi_Detail');
    }
}
