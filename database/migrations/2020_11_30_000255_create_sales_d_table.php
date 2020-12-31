<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesDTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_d', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('sales_m_id')->index();           //AUTO
            $table->string('periode')->index();                 //AUTO
            $table->integer('qtyNewCustomer')->nullable();      //AUTO
            $table->integer('qtyTargetPenawaran')->nullable();  //INPUT
            $table->integer('kgTargetPenawaran')->nullable();   //AUTO
            $table->integer('qtyTargetKontrak')->nullable();    //INPUT
            $table->integer('rpTargetKontrak')->nullable();     //INPUT
            $table->integer('kgTargetKontrak')->nullable();     //AUTO
            $table->integer('qtyTargetOmset')->nullable();      //INPUT
            $table->integer('kgTargetOmset')->nullable();       //AUTO
            $table->integer('rpTargetOmset')->nullable();       //INPUT
            $table->integer('qtyPenawaran')->nullable();        //AUTO
            $table->integer('kgPenawaran')->nullable();         //AUTO
            $table->integer('rpPenawaran')->nullable();         //AUTO
            $table->integer('qtyKontrak')->nullable();          //AUTO
            $table->integer('kgKontrak')->nullable();           //AUTO
            $table->integer('rpKontrak')->nullable();           //AUTO
            $table->integer('qtyOmset')->nullable();            //AUTO
            $table->integer('kgOmset')->nullable();             //AUTO
            $table->integer('rpOmset')->nullable();             //AUTO
            $table->integer('qtySj')->nullable();               //AUTO
            $table->integer('kgSj')->nullable();                //AUTO
            $table->integer('rpSj')->nullable();                //AUTO
            $table->integer('qtyWip')->nullable();              //AUTO
            $table->integer('kgWip')->nullable();               //AUTO
            $table->integer('rpWip')->nullable();               //AUTO
            $table->integer('qtyBjBlmSj')->nullable();          //AUTO
            $table->integer('kgBjBlmSj')->nullable();           //AUTO
            $table->integer('rpBjBlmSj')->nullable();           //AUTO
            $table->integer('rpPiutang')->nullable();           //AUTO
            $table->integer('rpAvgRpKg')->nullable();           //AUTO
            //RELATION
            $table->foreign('sales_m_id')->references('id')->on('sales_m')->cascadeOnDelete();
            // TRACKING
            $table->string('createdBy');        //Auto ambil dari login
            $table->string('lastUpdatedBy')->nullable();    //Auto ambil dari login
            $table->boolean('deleted')->default(0);         //Update ketika di hapus (default false)
            $table->dateTime('deletedAt')->nullable();      //Auto ambil dari today()
            $table->string('deletedBy')->nullable();        //Auto ambil dari login
            $table->string('branch')->index();              //Auto ambil dari login awal
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
        Schema::dropIfExists('sales_d');
    }
}
