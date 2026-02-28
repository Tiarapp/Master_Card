<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColorCombine extends Model
{
    use HasFactory;

    protected $table = 'color_combine';

    protected $fillable = [
        'kode',
        'nama',
        'idColor1',
        'idColor2',
        'idColor3',
        'idColor4',
        'idColor5',
        'createdBy',
        'lastUpdatedBy',
        'deleted',
        'deletedAt',
        'deletedBy',
        'branch'
    ];

    public function color1()
    {
        return $this->belongsTo(Warna::class, 'idColor1');
    }

    public function color2()
    {
        return $this->belongsTo(Warna::class, 'idColor2');
    }

    public function color3()
    {
        return $this->belongsTo(Warna::class, 'idColor3');
    }

    public function color4()
    {
        return $this->belongsTo(Warna::class, 'idColor4');
    }

    public function color5()
    {
        return $this->belongsTo(Warna::class, 'idColor5');
    }
}
