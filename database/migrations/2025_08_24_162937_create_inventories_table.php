<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_masuk')->nullable();
            $table->string('kode_internal')->unique();
            $table->boolean('kw')->default(false);
            $table->string('jenis')->nullable();
            $table->integer('gsm')->nullable();
            $table->string('kode_roll')->unique();
            $table->integer('lebar')->nullable();
            $table->integer('berat_timbang');
            $table->integer('quantity');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->string('purchase_order')->nullable();
            $table->string('descoription')->nullable();
            $table->unsignedBigInteger('potongan_id')->nullable();
            $table->double('gsm_actual')->nullable();
            $table->double('cobsize_top')->nullable();
            $table->double('cobsize_bottom')->nullable();
            $table->double('rct_cd')->nullable();
            $table->double('rct_md')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('status_roll_id')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('inventories');
    }
}