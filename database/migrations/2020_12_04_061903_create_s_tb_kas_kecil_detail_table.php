<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSTbKasKecilDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_tbKasKecil_Detail', function (Blueprint $table) {
            $table->id('id');
            $table->string('Nomor')->nullable();
            $table->integer('Line')->nullable();
            $table->string('BPB_No')->nullable();
            $table->string('Vo_No')->nullable();
            $table->string('Kode_Dept')->nullable();
            $table->string('SupplierCode')->nullable();
            $table->string('Pay_To')->nullable();
            $table->string('SupplierExt')->nullable();
            $table->string('Description')->nullable();
            $table->dateTime('RefDate')->nullable();
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
            $table->string('Remark')->nullable();
            $table->string('MasaSPT')->nullable();
            $table->string('PO_No')->nullable();
            $table->dateTime('DataTransferred')->nullable();
            $table->float('DefAmount',18,4)->nullable();
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
        Schema::dropIfExists('s_tbKasKecil_Detail');
    }
}
