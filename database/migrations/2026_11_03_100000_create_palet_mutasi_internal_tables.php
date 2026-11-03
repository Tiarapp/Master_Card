<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaletMutasiInternalTables extends Migration
{
    public function up()
    {
        Schema::create('palet_mutasi_internal_m', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->index();
            $table->string('sumber', 40)->index();
            $table->string('createdBy');
            $table->string('lastUpdatedBy')->nullable();
            $table->dateTime('deletedAt')->nullable();
            $table->string('deletedBy')->nullable();
            $table->string('branch')->default('Lamongan')->index();
            $table->timestamps();
        });

        Schema::create('palet_mutasi_internal_d', function (Blueprint $table) {
            $table->id();
            $table->foreignId('palet_mutasi_internal_m_id')
                ->constrained('palet_mutasi_internal_m');
            $table->foreignId('item_palet_id')->constrained('item_palet');
            $table->unsignedInteger('qty');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('palet_mutasi_internal_d');
        Schema::dropIfExists('palet_mutasi_internal_m');
    }
}
