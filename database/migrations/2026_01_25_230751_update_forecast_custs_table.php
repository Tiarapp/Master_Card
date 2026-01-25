<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForecastCustsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forecast_custs', function (Blueprint $table) {
            // Drop old columns
            $table->dropColumn(['sales_person', 'forecast_amount', 'forecast_month']);
            
            // Add new columns
            $table->unsignedBigInteger('sales_id')->nullable();
            $table->integer('bulan');
            $table->integer('tahun');
            $table->decimal('target_tonase', 10, 2);
            $table->text('keterangan')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            
            // Add foreign key constraint
            $table->foreign('sales_id')->references('id')->on('sales_m')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('forecast_custs', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['sales_id']);
            
            // Drop new columns
            $table->dropColumn(['sales_id', 'bulan', 'tahun', 'target_tonase', 'keterangan', 'created_by', 'updated_by']);
            
            // Add back old columns
            $table->string('sales_person');
            $table->double('forecast_amount');
            $table->date('forecast_month');
        });
    }
}
