<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMastercardApprovalsTable extends Migration
{
    public function up()
    {
        Schema::create('mastercard_approvals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('mastercard_id')->index();
            $table->string('original_name');
            $table->string('path');
            $table->string('mime_type', 30);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mastercard_approvals');
    }
}
