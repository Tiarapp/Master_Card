<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSTPiutangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_TPiutang', function (Blueprint $table) {
            $table->id('id');
            $table->string('NoBukti')->nullable();
            $table->string('NoRef')->nullable();
            $table->string('NoOtherRef')->nullable();
            $table->string('Note')->nullable();
            $table->string('JTrans')->nullable();
            $table->string('Jenis')->nullable();
            $table->string('JenisDK')->nullable();
            $table->string('Periode')->nullable();
            $table->dateTime('Tanggal')->nullable();
            $table->dateTime('TglJT')->nullable();
            $table->dateTime('TglBuku')->nullable();
            $table->string('KodeCust')->nullable();
            $table->string('NamaCust')->nullable();
            $table->string('KodeGroupCust')->nullable();
            $table->string('GroupCust')->nullable();
            $table->string('Kota')->nullable();
            $table->string('GlobalArea')->nullable();
            $table->string('KdPerkiraan')->nullable();
            $table->string('MataUang')->nullable();
            $table->float('NilaiKurs',18,4)->nullable();
            $table->float('Total',18,4)->nullable();
            $table->float('TotalRp',18,4)->nullable();
            $table->float('TotalTerima',18,4)->nullable();
            $table->float('Penjualan',18,4)->nullable();
            $table->float('PPN',18,4)->nullable();
            $table->float('PPH',18,4)->nullable();
            $table->string('SJINV')->nullable();
            $table->dateTime('TglKirimInv')->nullable();
            $table->dateTime('TglTerimaInv')->nullable();
            $table->dateTime('TglJTInv')->nullable();
            $table->float('TotalBG')->nullable();
            $table->string('NoTT')->nullable();
            $table->string('NoPPH22')->nullable();
            $table->dateTime('TglPPH22')->nullable();
            $table->string('KdDept')->nullable();
            $table->string('NoKwitansi')->nullable();
            $table->string('Salesman')->nullable();
            $table->float('Setting')->nullable();
            $table->string('External')->nullable();
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
        Schema::dropIfExists('s_TPiutang');
    }
}
