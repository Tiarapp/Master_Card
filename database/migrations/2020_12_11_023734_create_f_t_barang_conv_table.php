<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFTBarangConvTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('f_TBarangConv', function (Blueprint $table) {
            $table->id('id');
            $table->string('KodeBrg')->nullable();
            $table->string('KodeLama')->nullable();
            $table->string('Eceran')->nullable();
            $table->string('Tujuan')->nullable();
            $table->date('TglKeluar')->nullable();
            $table->string('JenisProd')->nullable();
            $table->string('Merk')->nullable();
            $table->string('Design')->nullable();
            $table->string('WeightSheet')->nullable();
            $table->string('Packing')->nullable();
            $table->string('WeightValue')->nullable();
            $table->string('Warna')->nullable();
            $table->string('CustNick')->nullable();
            $table->string('NamaBrg')->nullable();
            $table->string('Satuan')->nullable();
            $table->float('IsiPerKarton',10,2)->nullable();
            $table->float('BeratStandart',10,2)->nullable();
            $table->float('HargaJualRp',10,2)->nullable();
            $table->float('HargaJualUSD',10,2)->nullable();
            $table->float('BeratCRT',10,2)->nullable();
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
        Schema::dropIfExists('f_TBarangConv');
    }
}
