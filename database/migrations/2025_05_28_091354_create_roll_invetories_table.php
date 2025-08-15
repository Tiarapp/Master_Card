<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRollInvetoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roll_invetories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('warna_id')->nullable();
            $table->string('kode_intern')->unique();
            $table->string('jenis')->nullable();
            $table->string('kode_roll')->nullable();
            $table->string('gsm')->nullable();
            $table->integer('lebar_roll')->nullable();
            $table->integer('berat_sj')->nullable();
            $table->integer('berat_timbang')->nullable();
            $table->integer('berat_actual')->nullable();
            $table->string('no_po')->nullable();    
            $table->string('keteragan')->nullable();
            $table->string('kolom')->nullable();
            $table->string('gsm_actual')->nullable();
            $table->string('percent_gsm')->nullable();
            $table->string('cobsize_top')->nullable();
            $table->string('cobsize_back')->nullable();
            $table->string('rct_cd')->nullable();
            $table->string('rct_md')->nullable();
            $table->string('nama_roll')->nullable();
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
        Schema::dropIfExists('roll_invetories');
    }
}
