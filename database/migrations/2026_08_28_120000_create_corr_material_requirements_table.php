<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorrMaterialRequirementsTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('corr_material_requirements')) {
            return;
        }

        Schema::create('corr_material_requirements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('corr_detail_id');
            $table->string('jenis');
            $table->unsignedInteger('gsm')->default(0);
            $table->unsignedInteger('lebar_roll')->default(0);
            $table->decimal('qty_required', 14, 3)->default(0);
            $table->decimal('qty_booked', 14, 3)->default(0);
            $table->string('status', 20)->default('PENDING');
            $table->timestamps();

            $table->foreign('corr_detail_id')->references('id')->on('corr_details')->onDelete('cascade');
            $table->unique(
                ['corr_detail_id', 'jenis', 'gsm', 'lebar_roll'],
                'cmr_detail_material_unique'
            );
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('corr_material_requirements');
    }
}
