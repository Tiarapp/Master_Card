<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToKaretsTablbe extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('karets', function (Blueprint $table) {
            $table->string('type')->nullable()->after('mc_id');
            $table->string('bbm_id')->nullable()->after('type');
            $table->double('alokasi')->default(0)->after('harga');
            $table->double('sisa')->default(0)->after('alokasi');
        });
    }

    /**
     * Reverse the migrations.
     *
    * @return void
     */
    public function down()
    {
        Schema::table('karets', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('bbm_id');
            $table->dropColumn('alokasi');
            $table->dropColumn('sisa');
        });
    }
}
