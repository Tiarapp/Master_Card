<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUrutanToCorrDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('corr_details', function (Blueprint $table) {
            $table->integer('urutan')->nullable()->after('opi_id')->comment('Urutan item dalam planning');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('corr_details', function (Blueprint $table) {
            $table->dropColumn('urutan');
        });
    }
}
