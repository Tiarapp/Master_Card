<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Opi_M extends Model
{
    use HasFactory;

    protected $table = 'opi_m';
    protected $fillable = [
        'NoOPI',
        'nama',
        'mc_id',
        'dt_id',
        'tglKirimDt',
        'hariKirimDt',
        'kontrak_m_id',
        'kontrak_d_id',
        'keterangan',
        'jumlahOrder',
        'createdBy',
        'lastUpdatedBy',
    ];

    public function kontrak()
    {
        return $this->hasMany(Kontrak_M::class, 'kontrak_m_id', 'id');
    }

    public function scopeOpi2($query)
    {
        $query->leftJoin('kontrak_m', 'kontrak_m_id', 'kontrak_m.id')
        ->leftJoin('kontrak_d', 'kontrak_d_id', 'kontrak_d.id')
        ->leftJoin('dt', 'dt_id', 'dt.id')
        ->leftJoin('mc', 'kontrak_d.mc_id', 'mc.id')
        ->leftJoin('box', 'mc.box_id', 'box.id')
        ->leftJoin('substance as subsP', 'mc.substanceProduksi_id', 'subsP.id')
        ->leftJoin('jenis_gram as Jatas', 'subsP.jenisGramLinerAtas_id', 'Jatas.id')
        ->leftJoin('jenis_gram as Jflute1', 'subsP.jenisGramFlute1_id', 'Jflute1.id')
        ->leftJoin('jenis_gram as Jtengah', 'subsP.jenisGramLinerTengah_id', 'Jtengah.id')
        ->leftJoin('jenis_gram as Jflute2', 'subsP.jenisGramFlute2_id', 'Jflute2.id')
        ->leftJoin('jenis_gram as Jbawah', 'subsP.jenisGramLinerBawah_id', 'Jbawah.id')
        ->leftJoin('substance as subsK', 'mc.substanceKontrak_id', 'subsK.id')
        ->leftJoin('color_combine', 'mc.colorCombine_id', 'color_combine.id')
        ->select('opi_m.id as opiid','opi_m.NoOPI as noopi', 'opi_m.jumlahOrder', 'kontrak_d.harga_kg', 'opi_m.keterangan', 'mc.namaBarang', 'opi_m.nama', 'mc.revisi', 'mc.kodeBarang', 'opi_m.created_at as tglopi', 'box.panjangDalamBox as panjang', 'box.lebarDalamBox as lebar', 'box.tinggiDalamBox as tinggi', 'subsP.kode as subsP', 'subsK.kode as subsK', 'box.flute', 'color_combine.nama as namacc', 'mc.gramSheetBoxProduksi2 as gram', 'mc.koli', 'mc.joint', 'mc.tipeBox', 'mc.kode as mcKode', 'dt.pcsDt', 'dt.tglKirimDt','kontrak_m.kode', 'kontrak_m.tglKontrak', 'kontrak_m.customer_name as Cust', 'kontrak_m.poCustomer', 'kontrak_m.alamatKirim', 'kontrak_d.pctToleransiKurangKontrak as toleransiKurang', 'kontrak_d.pctToleransiLebihKontrak as toleransiLebih', 'kontrak_m.tipeOrder', 'kontrak_d.pcsKontrak', 'mc.lebarSheet', 'mc.panjangSheet', 'mc.outConv', 'Jatas.jenisKertasMc as kertasMcAtas', 'Jatas.gramKertas as gramKertasAtas', 'Jflute1.jenisKertasMc as kertasMcflute1', 'Jflute1.gramKertas as gramKertasflute1', 'Jtengah.jenisKertasMc as kertasMctengah', 'Jtengah.gramKertas as gramKertastengah', 'Jflute2.jenisKertasMc as kertasMcflute2',  'Jflute2.gramKertas as gramKertasflute2', 'Jbawah.jenisKertasMc as kertasMcbawah', 'Jbawah.gramKertas as gramKertasbawah', 'mc.gramSheetBoxKontrak as gramSheet', 'color_combine.nama as ccnama', 'mc.wax')
        ->orderBy('dt.tglKirimDt', 'desc')
        ->get();

        return $query;
    }
}
