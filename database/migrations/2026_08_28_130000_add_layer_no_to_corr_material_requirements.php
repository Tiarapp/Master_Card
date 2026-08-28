<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddLayerNoToCorrMaterialRequirements extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('corr_material_requirements', 'layer_no')) {
            Schema::table('corr_material_requirements', function (Blueprint $table) {
                $table->unsignedTinyInteger('layer_no')->nullable()->after('corr_detail_id');
            });
        }

        $indexes = collect(DB::select('SHOW INDEX FROM corr_material_requirements'))->pluck('Key_name');
        if (!$indexes->contains('cmr_detail_fk_idx')) {
            Schema::table('corr_material_requirements', function (Blueprint $table) {
                $table->index('corr_detail_id', 'cmr_detail_fk_idx');
            });
        }
        if ($indexes->contains('cmr_detail_material_unique')) {
            Schema::table('corr_material_requirements', function (Blueprint $table) {
                $table->dropUnique('cmr_detail_material_unique');
            });
        }
        if (!collect(DB::select('SHOW INDEX FROM corr_material_requirements'))->pluck('Key_name')->contains('cmr_detail_layer_unique')) {
            Schema::table('corr_material_requirements', function (Blueprint $table) {
                $table->unique(['corr_detail_id', 'layer_no'], 'cmr_detail_layer_unique');
            });
        }
    }

    public function down()
    {
        Schema::table('corr_material_requirements', function (Blueprint $table) {
            $table->dropUnique('cmr_detail_layer_unique');
            $table->dropColumn('layer_no');
            $table->unique(
                ['corr_detail_id', 'jenis', 'gsm', 'lebar_roll'],
                'cmr_detail_material_unique'
            );
        });
    }
}
