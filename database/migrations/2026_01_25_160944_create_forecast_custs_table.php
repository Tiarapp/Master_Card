<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForecastCustsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forecast_custs', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->unsignedBigInteger('sales_id')->nullable();
            $table->integer('bulan');
            $table->integer('tahun');
            $table->decimal('target_tonase', 10, 2);
            $table->text('keterangan')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
            
            // Add foreign key constraint
            $table->foreign('sales_id')->references('id')->on('sales_m')->onDelete('set null');
            
            // Add unique constraint to prevent duplicate forecasts
            $table->unique(['customer_name', 'bulan', 'tahun'], 'unique_forecast_per_customer_month');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forecast_custs');
    }
}
