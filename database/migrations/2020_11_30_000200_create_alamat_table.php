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
            $table->enum('jenis',['KANTOR','KIRIM','TAGIHAN','TOKO'])->index();  //INPUT
            $table->integer('customer_id')->nullable()->index();     //AUTO
            $table->integer('supplier_id')->nullable()->index();     //AUTO
            $table->decimal('latitude',9,6)->nullable();    //INPUT
            $table->decimal('longitude',9,6)->nullable();   //INPUT
            $table->string('pic');                      //INPUT
            $table->string('telpPic');                  //INPUT
            $table->string('alamat');                   //INPUT
            $table->string('perumahanNamaTempat')->nullable();               //INPUT
            $table->string('rt')->nullable();           //INPUT
            $table->string('rw')->nullable();           //INPUT
            $table->enum('kelurahanDesa',['KELURAHAN','DESA'])->nullable(); //INPUT
            $table->string('namaKelurahanDesa')->nullable(); //INPUT
            $table->string('kecamatan')->nullable();            //INPUT
            $table->enum('kotaKabupaten',['KOTA','KABUPATEN'])->nullable(); //INPUT
            $table->string('namaKotaKabupaten')->nullable();    //INPUT
            $table->string('provinsi')->nullable();             //INPUT
            $table->string('kodePos')->nullable();              //INPUT
            $table->string('negara');                           //INPUT
            $table->string('alamatLengkap')->index();            //AUTO alamat+perumahanNamaTempat+rt+rw+kelurahanDesa+Kecamatan+kotaKabupaten+provinsi+negara+kodePos
            $table->boolean('aktif')->default(1)->comment('1:Aktif, 0:Non Aktif')->index();  //INPUT
            // TRACKING
            $table->string('createdBy');                    //Auto ambil dari login
            $table->string('lastUpdatedBy')->nullable();    //Auto ambil dari login
            $table->dateTime('deletedAt')->nullable();      //Auto ambil dari today()
            $table->string('deletedBy')->nullable();        //Auto ambil dari login
            $table->integer('printedKe')->nullable();       //Auto ambil dari login
            $table->dateTime('printedAt')->nullable();      //Auto ambil dari login
            $table->string('branch')->default('Lamongan')->index();              //Auto ambil dari login awal
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
