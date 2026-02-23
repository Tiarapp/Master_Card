<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPlanCorrToOpiMTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('opi_m', function (Blueprint $table) {
            $table->boolean('plan_corr')->default(false)->comment('Status planning corrugated');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('opi_m', function (Blueprint $table) {
            $table->dropColumn('plan_corr');
        });
    }
}
