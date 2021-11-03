<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanConvDTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_conv_d', function (Blueprint $table) {
            $table->id();
            $table->foreignId('opi_id')->unsigned();
            $table->foreignId('plan_corr_id')->unsigned();
            $table->foreignId('plan_conv_m_id')->unsigned();
            $table->date('tgl_kirim');
            $table->string('nomc');
            $table->string('nama_item');
            $table->string('customer');
            $table->string('tipe_order');
            $table->string('joint');
            $table->string('wax');
            $table->string('mesin');
            $table->integer('sheet_p');
            $table->integer('sheet_l');
            $table->string('flute');
            $table->string('bentuk');
            $table->integer('warna');
            $table->integer('out_flexo')->nullable();
            $table->integer('qtyOrder');
            $table->integer('jml_plan');
            $table->integer('ukuran_roll');
            $table->string('bungkus');
            $table->string('lain_lain');
            $table->integer('rm_order');
            $table->double('tonase',25);
            $table->string('keterangan');
            $table->enum('status',['Proses', 'Belum Selesai', 'Selesai'])->default('Proses');
            $table->boolean('lock');

            $table->foreign('opi_id')->references('id')->on('opi_m')->cascadeOnDelete();
            $table->foreign('plan_conv_m_id')->references('id')->on('plan_conv_m')->cascadeOnDelete();
            $table->foreign('plan_corr_id')->references('id')->on('plan_corr_d')->cascadeOnDelete();
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
        Schema::dropIfExists('plan_conv_d');
    }
}
