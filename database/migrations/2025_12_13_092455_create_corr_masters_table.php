<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorrMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corr_masters', function (Blueprint $table) {
            $table->id();
            $table->string('kode_corr')->unique();
            $table->date('tanggal_produksi');
            $table->string('shift');
            $table->string('revisi')->nullable();
            $table->string('notes')->nullable();
            $table->integer('total_rm')->default(0);
            $table->integer('total_kg')->default(0);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('corr_masters');
    }
}
