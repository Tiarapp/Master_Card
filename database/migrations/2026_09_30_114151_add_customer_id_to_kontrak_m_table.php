<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomerIdToKontrakMTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kontrak_m', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id')->nullable()->before('customer_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kontrak_m', function (Blueprint $table) {
            $table->dropColumn('customer_id');
        });
    }
}
