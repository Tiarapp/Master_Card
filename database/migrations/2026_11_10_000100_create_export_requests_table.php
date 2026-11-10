<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExportRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('export_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('type', 50)->index();
            $table->text('filters')->nullable();
            $table->string('status', 20)->default('pending')->index(); // pending, processing, done, failed
            $table->string('file_name')->nullable();
            $table->string('file_path')->nullable();
            $table->text('error')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('export_requests');
    }
}
