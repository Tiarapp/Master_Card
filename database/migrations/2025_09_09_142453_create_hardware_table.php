<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHardwareTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hardware', function (Blueprint $table) {
            $table->id();
            $table->string('kode_hardware', 50)->unique();
            $table->string('nama_hardware', 255);
            $table->string('merk', 100)->nullable();
            $table->string('model', 100)->nullable();
            $table->string('serial_number', 100)->nullable();
            $table->text('spesifikasi')->nullable();
            $table->enum('kategori', ['Komputer', 'Laptop', 'Server', 'Network', 'Printer', 'Scanner', 'Proyektor', 'Monitor', 'Storage', 'Others']);
            $table->enum('status', ['Aktif', 'Maintenance', 'Rusak', 'Retired'])->default('Aktif');
            $table->date('tanggal_pembelian')->nullable();
            $table->decimal('harga_pembelian', 15, 2)->nullable();
            $table->string('lokasi', 255)->nullable();
            $table->string('pic_pengguna', 255)->nullable();
            $table->string('divisi', 100)->nullable();
            $table->text('keterangan')->nullable();
            $table->date('tanggal_garansi_mulai')->nullable();
            $table->date('tanggal_garansi_selesai')->nullable();
            $table->string('vendor', 255)->nullable();
            $table->string('no_invoice', 100)->nullable();
            $table->string('created_by', 100)->nullable();
            $table->string('updated_by', 100)->nullable();
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
        Schema::dropIfExists('hardware');
    }
}
