<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFTFakturConvTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('f_TFakturConv', function (Blueprint $table) {
            $table->id('id');
            $table->string('NoFaktur')->nullable();
            $table->string('NoFakturPajak')->nullable();
            $table->string('Periode')->nullable();
            $table->date('TglFaktur')->nullable();
            $table->date('TglFakturPajak')->nullable();
            $table->string('NoKwitansi')->nullable();
            $table->string('KodeCust')->nullable();
            $table->string('NomerSJ')->nullable();
            $table->string('StatusHarga')->nullable();
            $table->string('MataUang')->nullable();
            $table->float('NilaiKursRp',18,4)->nullable();
            $table->float('NilaiKursUSD',18,4)->nullable();
            $table->integer('WaktuBayar')->nullable();
            $table->string('NoFakturUM')->nullable();
            $table->string('KeteranganUM')->nullable();
            $table->decimal('UangMuka',18,4)->nullable();
            $table->float('TotalAwal',18,4)->nullable();
            $table->float('TotalPotongan',18,4)->nullable();
            $table->float('TotSblmPPN',18,4)->nullable();
            $table->float('PPN',18,4)->nullable();
            $table->float('PPH22',18,4)->nullable();
            $table->float('TotalTagihan',18,4)->nullable();
            $table->string('Print')->nullable();
            $table->string('Aktif')->nullable();
            $table->string('Posting')->nullable();
            $table->integer('PPHSign')->nullable();
            $table->string('TOTALBAYAR')->nullable();
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
        Schema::dropIfExists('f_TFakturConv');
    }
}
