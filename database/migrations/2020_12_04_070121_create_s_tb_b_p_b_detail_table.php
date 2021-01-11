<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSTbBPBDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_tbBPB_Detail', function (Blueprint $table) {
            $table->id('id');
            $table->string('Nomor')->nullable();
            $table->integer('Line')->nullable();
            $table->string('ProductID')->nullable();
            $table->string('Product')->nullable();
            $table->string('Merk')->nullable();
            $table->string('Spec')->nullable();
            $table->string('Packaging')->nullable();
            $table->string('UOM')->nullable();
            $table->float('QTY',18,4);
            $table->string('Curr')->nullable();
            $table->float('Harga',18,4);
            $table->float('Nilai',18,4);
            $table->float('PPN',18,4);
            $table->float('PPh',18,4);
            $table->float('ex_Rate',18,4);
            $table->string('Curr2')->nullable();
            $table->float('Nilai2',18,4);
            $table->float('PPN2',18,4);
            $table->string('JenisPPh')->nullable();
            $table->float('PPh2',18,4);
            $table->float('LandedCost1',18,4);
            $table->float('LandedCost2',18,4);
            $table->string('Kode_Aktiva_Tetap')->nullable();
            $table->string('Remark')->nullable();
            $table->integer('POLine')->nullable();
            $table->string('PO')->nullable();
            $table->integer('OPB_Line')->nullable();
            $table->string('OPB')->nullable();
            $table->string('AccountBarang')->nullable();
            $table->string('AccountLawan')->nullable();
            $table->string('AccountPPN')->nullable();
            $table->string('AccountPPh')->nullable();
            $table->string('AccountLandedCost')->nullable();
            $table->string('SupplierRef')->nullable();
            $table->string('Warehouse')->nullable();
            $table->integer('TOP_PO')->nullable();
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
        Schema::dropIfExists('s_tbBPB_Detail');
    }
}
