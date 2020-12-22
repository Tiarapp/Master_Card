<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlamatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alamat', function (Blueprint $table) {
            $table->id('id');
            $table->enum('jenis',['Kantor','Kirim','Tagihan','Toko']);  //INPUT
            $table->integer('customer_id')->nullable();     //AUTO
            $table->integer('supplier_id')->nullable();     //AUTO
            $table->decimal('latitude',9,6)->nullable();    //INPUT
            $table->decimal('longitude',9,6)->nullable();   //INPUT
            $table->string('pic');                      //INPUT
            $table->string('telpPic');                  //INPUT
            $table->string('alamat');                   //INPUT
            $table->string('perumahanNamaTempat')->nullable();           //INPUT
            $table->string('rt')->nullable();           //INPUT
            $table->string('rw')->nullable();           //INPUT
            $table->enum('kelurahanDesa',['Kelurahan','Desa'])->nullable(); //INPUT
            $table->string('kecamatan')->nullable();                    //INPUT
            $table->enum('kotaKabupaten',['Kota','Kabupaten']);         //INPUT
            $table->string('provinsi');                                 //INPUT
            $table->string('kodePos')->nullable();                      //INPUT
            $table->string('negara');                                   //INPUT
            $table->string('alamatLengkap');            //AUTO alamat+perumahanNamaTempat+rt+rw+kelurahanDesa+Kecamatan+kotaKabupaten+provinsi+negara+kodePos
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
        Schema::dropIfExists('alamat');
    }
}
