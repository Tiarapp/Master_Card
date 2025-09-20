<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hardware extends Model
{
    use HasFactory;

    protected $table = 'hardware';

    protected $fillable = [
        'kode_hardware',
        'nama_hardware',
        'merk',
        'model',
        'serial_number',
        'spesifikasi',
        'kategori',
        'status',
        'tanggal_pembelian',
        'harga_pembelian',
        'lokasi',
        'pic_pengguna',
        'divisi',
        'keterangan',
        'tanggal_garansi_mulai',
        'tanggal_garansi_selesai',
        'vendor',
        'no_invoice',
        'created_by',
        'updated_by'
    ];

    protected $dates = [
        'tanggal_pembelian',
        'tanggal_garansi_mulai',
        'tanggal_garansi_selesai'
    ];

    protected $casts = [
        'harga_pembelian' => 'decimal:2',
        'tanggal_pembelian' => 'date',
        'tanggal_garansi_mulai' => 'date',
        'tanggal_garansi_selesai' => 'date'
    ];

    // Scopes
    public function scopeAktif($query)
    {
        return $query->where('status', 'Aktif');
    }

    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    public function scopeByDivisi($query, $divisi)
    {
        return $query->where('divisi', $divisi);
    }

    // Accessors
    public function getHargaPembelianFormattedAttribute()
    {
        return 'Rp ' . number_format($this->harga_pembelian, 0, ',', '.');
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'Aktif' => 'success',
            'Maintenance' => 'warning',
            'Rusak' => 'danger',
            'Retired' => 'secondary'
        ];
        
        return $badges[$this->status] ?? 'primary';
    }

    public function getGaransiStatusAttribute()
    {
        if (!$this->tanggal_garansi_selesai) {
            return 'Tidak Ada Garansi';
        }

        $today = now();
        $garansiSelesai = $this->tanggal_garansi_selesai;

        if ($garansiSelesai->lt($today)) {
            return 'Garansi Habis';
        } elseif ($garansiSelesai->diffInDays($today) <= 30) {
            return 'Garansi Akan Habis';
        } else {
            return 'Garansi Aktif';
        }
    }
}
