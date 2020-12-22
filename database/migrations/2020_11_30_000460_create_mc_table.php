<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMcTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mc', function (Blueprint $table) {
            $table->id('id');
            $table->string('kode')->unique();                   //AUTO NUMBER SEQUENCE
            $table->foreignId('bj_id');                         //INPUT MARKETING
            $table->foreignId('tipeBox_id');                    //INPUT MARKETING
            $table->foreignId('substanceSheet_id');             //INPUT MARKETING
            $table->foreignId('wax_id')->nullable();            //INPUT MARKETING
            $table->foreignId('joint_id');                      //INPUT MARKETING
            $table->string('mesin');                            //AUTO RUMUS MASIH DIPIKIR
            $table->integer('outConv');                         //AUTO RUMUS MASIH DIPIKIR
            $table->foreignId('flute_id');                      //INPUT MARKETING
            $table->foreignId('koli_id');                       //INPUT MARKETING
            $table->boolean('bungkus')->nullable();             //INPUT MARKETING
            $table->text('keterangan')->nullable();             //INPUT MARKETING
            $table->string('gambar');                           //UPLOAD BY DESAIN
            $table->foreignId('substanceKontrak_id');           //SUBSTANCE KONTRAK INPUT MARKETING
            $table->foreignId('substanceProduksi_id');          //SUBSTANCE PRODUKSI INPUT MARKETING
            $table->foreignId('bom_m_id');                      //BOM INPUT MARKETING
            $table->foreignId('box_id');                        //SHEET BOX INPUT MARKETING
            $table->foreignId('colorCombine_id')->nullable();   //COLOR ID INPUT MARKETING
            //RELATION
            $table->foreign('bj_id')->references('id')->on('item_bj')->cascadeOnDelete();
            $table->foreign('tipeBox_id')->references('id')->on('tipe_box')->cascadeOnDelete();
            $table->foreign('substanceSheet_id')->references('id')->on('substance_sheet')->cascadeOnDelete();
            $table->foreign('wax_id')->references('id')->on('wax')->cascadeOnDelete();
            $table->foreign('joint_id')->references('id')->on('joint')->cascadeOnDelete();
            $table->foreign('flute_id')->references('id')->on('flute')->cascadeOnDelete();
            $table->foreign('koli_id')->references('id')->on('koli')->cascadeOnDelete();
            $table->foreign('substanceKontrak_id')->references('id')->on('substance')->cascadeOnDelete();
            $table->foreign('substanceProduksi_id')->references('id')->on('substance')->cascadeOnDelete();
            $table->foreign('bom_m_id')->references('id')->on('bom_m')->cascadeOnDelete();
            $table->foreign('box_id')->references('id')->on('box')->cascadeOnDelete();
            $table->foreign('colorCombine_id')->references('id')->on('color_combine')->cascadeOnDelete();
            // TRACKING
            $table->string('createdBy');        //Auto ambil dari login
            $table->string('lastUpdatedBy')->nullable();    //Auto ambil dari login
            $table->boolean('deleted')->nullable();         //Update ketika di hapus (default false)
            $table->dateTime('deletedAt')->nullable();      //Auto ambil dari today()
            $table->string('deletedBy')->nullable();        //Auto ambil dari login
            $table->string('branch');           //Auto ambil dari login awal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mc');
    }
}
