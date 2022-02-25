<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHasilControlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hasil_produksi', function (Blueprint $table) {
            $table->id('id');
            // $table->foreignId('plan_conv_m_id')->unsigned();
            // $table->foreignId('plan_conv_d_id')->unsigned();
            $table->foreignId('opi_id')->unsigned();
            $table->string('noOpi');
            $table->string('corr')->nullable();
            $table->string('flexo')->nullable();
            $table->string('tokai')->nullable();
            $table->string('stitch')->nullable();
            $table->string('wax')->nullable();
            $table->string('slitter')->nullable();
            $table->string('glue_manual')->nullable();
            $table->integer('jml_Order')->nullable();
            $table->date('tgl_corr')->nullable();
            $table->integer('hasil_baik_corr')->nullable();
            $table->integer('hasil_jelek_corr')->nullable();
            $table->date('tgl_flexo')->nullable();
            $table->integer('hasil_baik_flexo')->nullable();
            $table->integer('hasil_jelek_flexo')->nullable();
            $table->date('tgl_tokai')->nullable();
            $table->integer('hasil_baik_tokai')->nullable();
            $table->integer('hasil_jelek_tokai')->nullable();
            $table->date('tgl_stitch')->nullable();
            $table->integer('hasil_baik_stitch')->nullable();
            $table->integer('hasil_jelek_stitch')->nullable();
            $table->date('tgl_wax')->nullable();
            $table->integer('hasil_baik_wax')->nullable();
            $table->integer('hasil_jelek_wax')->nullable();
            $table->date('tgl_slitter')->nullable();
            $table->integer('hasil_baik_slitter')->nullable();
            $table->integer('hasil_jelek_slitter')->nullable();
            $table->date('tgl_glue')->nullable();
            $table->integer('hasil_baik_glue')->nullable();
            $table->integer('hasil_jelek_glue')->nullable();

            // $table->foreign('plan_conv_m_id')->references('id')->on('plan_conv_m')->cascadeOnDelete();
            // $table->foreign('plan_conv_d_id')->references('id')->on('plan_conv_d')->cascadeOnDelete();
            $table->foreign('opi_id')->references('id')->on('opi_m')->cascadeOnDelete();
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
        Schema::dropIfExists('hasil_produksi');
    }
}
