<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSTbVoucherBayarDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_tbVoucherBayar_Detail', function (Blueprint $table) {
            $table->id('id');
            $table->string('Nomor')->nullable();
            $table->integer('Line')->nullable();
            $table->string('Kode_Dept')->nullable();
            $table->string('COA')->nullable();
            $table->string('COA_Lawan')->nullable();
            $table->string('SupplierCode')->nullable();
            $table->string('Pay_To')->nullable();
            $table->string('Description')->nullable();
            $table->string('PO_No')->nullable();
            $table->integer('PO_Line')->nullable();
            $table->dateTime('PO_Tanggal')->nullable();
            $table->string('Vo_No')->nullable();
            $table->string('BPB_No')->nullable();
            $table->integer('BPB_Line')->nullable();
            $table->dateTime('BPB_Tgl')->nullable();
            $table->string('Jenis_Ref')->nullable();
            $table->string('RefNo')->nullable();
            $table->dateTime('RefDate')->nullable();
            $table->dateTime('RefDue')->nullable();
            $table->string('NoProyek')->nullable();
            $table->string('RincPakai')->nullable();
            $table->string('NoPolisi')->nullable();
            $table->string('KM')->nullable();
            $table->string('TOP')->nullable();
            $table->string('Curr1')->nullable();
            $table->float('Nilai1',18,4);
            $table->float('ExRate',18,4);
            $table->string('Curr2')->nullable();
            $table->float('Nilai2',18,4);
            $table->string('Remark')->nullable();
            $table->string('MasaSPT')->nullable();
            $table->string('Pajak_Jenis')->nullable();
            $table->string('Pajak_Ref')->nullable();
            $table->dateTime('Pajak_TglRef')->nullable();
            $table->float('Pajak_Tarip',18,4)->nullable();
            $table->string('Pajak_CurrInv')->nullable();
            $table->float('Pajak_NilaiInv',18,4)->nullable();
            $table->string('KdUnit')->nullable();
            $table->float('DefAmount',18,4)->nullable();
            $table->string('RefOther')->nullable();
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
        Schema::dropIfExists('s_tbVoucherBayar_Detail');
    }
}
