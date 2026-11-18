<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMastercardFirebirdGenerationsTable extends Migration
{
    public function up()
    {
        Schema::create('mastercard_firebird_generations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode_barang', 100)->unique();
            $table->unsignedBigInteger('mastercard_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamp('generated_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('mastercard_firebird_generations');
    }
}
