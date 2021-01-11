<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFTDetSJTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('f_TDetSJ', function (Blueprint $table) {
            $table->id('id');
            $table->integer('NoUrut')->nullable();
            $table->string('NomerSJ')->nullable();
            $table->string('KodeBrg')->nullable();
            $table->float('IsiPerKarton',18,4)->nullable();
            $table->float('Quantity',18,4)->nullable();
            $table->float('HargaAwal',18,4)->nullable();
            $table->float('Discount1',18,4)->nullable();
            $table->float('Discount2',18,4)->nullable();
            $table->float('Discount3',18,4)->nullable();
            $table->float('Discount4',18,4)->nullable();
            $table->float('Discount5',18,4)->nullable();
            $table->float('SubTotalAwal',18,4)->nullable();
            $table->float('SubTotalDisc',18,4)->nullable();
            $table->float('SubTotalSblmPPN',18,4)->nullable();
            $table->float('PPN',18,4)->nullable();
            $table->float('SubTotalAkhir',18,4)->nullable();
            $table->float('PPH22',18,4)->nullable();
            $table->integer('ReffNoUrut')->nullable();
            $table->string('NomerBC',18,4)->nullable();
            $table->date('BCDate',18,4)->nullable();
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
        Schema::dropIfExists('f_TDetSJ');
    }
}
