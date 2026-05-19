<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBeforeAfterToTrackingTable extends Migration
{
    public function up()
    {
        Schema::table('tracking', function (Blueprint $table) {
            $table->text('before')->nullable()->after('event');
            $table->text('after')->nullable()->after('before');
        });
    }

    public function down()
    {
        Schema::table('tracking', function (Blueprint $table) {
            $table->dropColumn(['before', 'after']);
        });
    }
}
