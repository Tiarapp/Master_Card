<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorrDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corr_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('corr_master_id')->nullable();
            $table->unsignedBigInteger('opi_id')->nullable();
            $table->unsignedBigInteger('mc_id')->nullable();
            $table->integer('sheet_p')->default(0);
            $table->integer('sheet_l')->default(0);
            $table->integer('order_qty')->default(0);
            $table->integer('out_flx')->default(0);
            $table->integer('plan_plus')->default(0);
            $table->integer('plan_min')->default(0);
            $table->integer('out_corr')->default(0);
            $table->integer('lebar_roll')->default(0);
            $table->integer('trim_waste')->default(0);
            $table->integer('cop_plus')->default(0);
            $table->integer('cop_min')->default(0);
            $table->string('jenis_kertas1')->nullable();
            $table->integer('gram_kertas1')->default(0);
            $table->integer('kebutuhan_kertas1')->default(0);
            $table->string('jenis_kertas2')->nullable();
            $table->integer('gram_kertas2')->default(0);
            $table->integer('kebutuhan_kertas2')->default(0);
            $table->string('jenis_kertas3')->nullable();
            $table->integer('gram_kertas3')->default(0);
            $table->integer('kebutuhan_kertas3')->default(0);
            $table->string('jenis_kertas4')->nullable();
            $table->integer('gram_kertas4')->default(0);
            $table->integer('kebutuhan_kertas4')->default(0);
            $table->string('jenis_kertas5')->nullable();
            $table->integer('gram_kertas5')->default(0);
            $table->integer('kebutuhan_kertas5')->default(0);
            $table->integer('rm_total')->default(0);
            $table->integer('kg_total')->default(0);
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('corr_details');
    }
}
