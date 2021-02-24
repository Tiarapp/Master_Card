<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class saldoAwal extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    }
}


Schema::create('color_combine', function (Blueprint $table) {
    $table->id('id');
    $table->string('kode')->unique()->index();           //AUTO NUMBER SEQUENCE
    $table->string('nama')->nullable()->index();         //CONCATENATE idColor1+....
    $table->foreignId('idColor1')->nullable()->index();  //INPUT DESAIN
    $table->foreignId('idColor2')->nullable()->index();  //INPUT DESAIN
    $table->foreignId('idColor3')->nullable()->index();  //INPUT DESAIN
    $table->foreignId('idColor4')->nullable()->index();  //INPUT DESAIN
    //RELATION
    $table->foreign('idColor1')->references('id')->on('color')->cascadeOnDelete();
    $table->foreign('idColor2')->references('id')->on('color')->cascadeOnDelete();
    $table->foreign('idColor3')->references('id')->on('color')->cascadeOnDelete();
    $table->foreign('idColor4')->references('id')->on('color')->cascadeOnDelete();
    // TRACKING
    $table->string('createdBy');                    //Auto ambil dari login



