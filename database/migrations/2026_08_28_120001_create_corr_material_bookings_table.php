<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorrMaterialBookingsTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('corr_material_bookings')) {
            return;
        }

        Schema::create('corr_material_bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('corr_material_requirement_id');
            $table->unsignedBigInteger('inventory_id');
            $table->decimal('qty_booked', 14, 3);
            $table->string('status', 20)->default('BOOKED');
            $table->timestamp('booked_at')->nullable();
            $table->timestamp('released_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('corr_material_requirement_id')->references('id')->on('corr_material_requirements')->onDelete('cascade');
            $table->foreign('inventory_id')->references('id')->on('inventories');
            $table->index(['inventory_id', 'status']);
            $table->index(['corr_material_requirement_id', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('corr_material_bookings');
    }
}
