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
        'periode',
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
        'status',
        'lastUpdatedBy',
        'os_corr',
        'os_flx',
        'os_fin',
        'sisa_order',
        'status_opi',
        'tol_corr'
    ];

    public function kontrak()
    {
        return $this->belongsTo(Kontrak_M::class, 'kontrak_m_id', 'id');
    }

    public function dt()
    {
        return $this->belongsTo(DeliveryTime::class, 'dt_id', 'id');
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
        ->leftJoin('jenis_gram as JatasK', 'subsK.jenisGramLinerAtas_id', 'JatasK.id')
        ->leftJoin('jenis_gram as Jflute1K', 'subsK.jenisGramFlute1_id', 'Jflute1K.id')
        ->leftJoin('jenis_gram as JtengahK', 'subsK.jenisGramLinerTengah_id', 'JtengahK.id')
        ->leftJoin('jenis_gram as Jflute2K', 'subsK.jenisGramFlute2_id', 'Jflute2K.id')
        ->leftJoin('jenis_gram as JbawahK', 'subsK.jenisGramLinerBawah_id', 'JbawahK.id')
        ->leftJoin('color_combine', 'mc.colorCombine_id', 'color_combine.id')
        ->select('opi_m.id as opiid','opi_m.NoOPI as noopi', 'opi_m.jumlahOrder', 'kontrak_d.harga_kg', 'opi_m.keterangan', 'mc.namaBarang', 'opi_m.nama', 'mc.revisi as revisimc', 'mc.kodeBarang', 'opi_m.created_at as tglopi', 'box.panjangDalamBox as panjang', 'box.lebarDalamBox as lebar', 'box.tinggiDalamBox as tinggi', 'subsP.kode as subsP', 'subsK.kode as subsK', 'box.flute', 'color_combine.nama as namacc', 'mc.gramSheetBoxProduksi2 as gram', 'mc.gramSheetCorrProduksi as gramcorr', 'mc.koli', 'mc.joint', 'mc.tipeBox', 'mc.kode as mcKode', 'dt.pcsDt', 'dt.tglKirimDt','kontrak_m.kode', 'kontrak_m.tglKontrak', 'kontrak_m.customer_name as Cust', 'kontrak_m.poCustomer', 'kontrak_m.alamatKirim', 'kontrak_m.keterangan as ketkontrak','kontrak_d.pctToleransiKurangKontrak as toleransiKurang', 'kontrak_d.pctToleransiLebihKontrak as toleransiLebih', 'kontrak_m.tipeOrder', 'kontrak_d.pcsKontrak', 'mc.lebarSheet', 'mc.panjangSheet', 'mc.outConv', 'Jatas.jenisKertasMc as kertasMcAtas', 'Jatas.gramKertas as gramKertasAtas', 'Jflute1.jenisKertasMc as kertasMcflute1', 'Jflute1.gramKertas as gramKertasflute1', 'Jtengah.jenisKertasMc as kertasMctengah', 'Jtengah.gramKertas as gramKertastengah', 'Jflute2.jenisKertasMc as kertasMcflute2',  'Jflute2.gramKertas as gramKertasflute2', 'Jbawah.jenisKertasMc as kertasMcbawah', 'Jbawah.gramKertas as gramKertasbawah', 'JatasK.jenisKertasMc as kertasMcAtasK', 'JatasK.gramKertas as gramKertasAtasK', 'Jflute1K.jenisKertasMc as kertasMcflute1K', 'Jflute1K.gramKertas as gramKertasflute1K', 'JtengahK.jenisKertasMc as kertasMctengahK', 'JtengahK.gramKertas as gramKertastengahK', 'Jflute2K.jenisKertasMc as kertasMcflute2K',  'Jflute2K.gramKertas as gramKertasflute2K', 'JbawahK.jenisKertasMc as kertasMcbawahK', 'JbawahK.gramKertas as gramKertasbawahK', 'mc.gramSheetBoxKontrak as gramSheet', 'color_combine.nama as ccnama', 'mc.wax', 'box.tipeCreasCorr', 'mc.bungkus', 'mc.lain', 'opi_m.tol_corr' )
        ->orderBy('opi_m.created_at', 'desc')
        ->where('opi_m.status_opi', '!=', 'Cancel')
        ->get();

        return $query;
    }

    public function scopeOpi($query)
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
        ->leftJoin('jenis_gram as JatasK', 'subsK.jenisGramLinerAtas_id', 'JatasK.id')
        ->leftJoin('jenis_gram as Jflute1K', 'subsK.jenisGramFlute1_id', 'Jflute1K.id')
        ->leftJoin('jenis_gram as JtengahK', 'subsK.jenisGramLinerTengah_id', 'JtengahK.id')
        ->leftJoin('jenis_gram as Jflute2K', 'subsK.jenisGramFlute2_id', 'Jflute2K.id')
        ->leftJoin('jenis_gram as JbawahK', 'subsK.jenisGramLinerBawah_id', 'JbawahK.id')
        ->leftJoin('color_combine', 'mc.colorCombine_id', 'color_combine.id')
        ->select('opi_m.*', 'kontrak_d.harga_kg', 'mc.namaBarang', 'mc.revisi as revisimc', 'mc.kodeBarang', 'box.panjangDalamBox as panjang', 'box.lebarDalamBox as lebar', 'box.tinggiDalamBox as tinggi', 'subsP.kode as subsP', 'subsK.kode as subsK', 'mc.flute', 'color_combine.nama as namacc', 'mc.gramSheetBoxProduksi as gramProd', 'mc.gramSheetBoxKontrak as gramKontrak', 'mc.koli', 'mc.joint', 'mc.tipeBox', 'mc.kode as mcKode', 'dt.pcsDt', 'dt.tglKirimDt','kontrak_m.kode', 'kontrak_m.tglKontrak', 'kontrak_m.customer_name as Cust', 'kontrak_m.poCustomer', 'kontrak_m.alamatKirim', 'kontrak_m.keterangan as ketkontrak','kontrak_d.pctToleransiKurangKontrak as toleransiKurang', 'kontrak_d.pctToleransiLebihKontrak as toleransiLebih', 'kontrak_m.tipeOrder', 'kontrak_d.pcsKontrak', 'mc.lebarSheet', 'mc.panjangSheet', 'mc.outConv', 'Jatas.jenisKertasMc as kertasMcAtas', 'Jatas.gramKertas as gramKertasAtas', 'Jflute1.jenisKertasMc as kertasMcflute1', 'Jflute1.gramKertas as gramKertasflute1', 'Jtengah.jenisKertasMc as kertasMctengah', 'Jtengah.gramKertas as gramKertastengah', 'Jflute2.jenisKertasMc as kertasMcflute2',  'Jflute2.gramKertas as gramKertasflute2', 'Jbawah.jenisKertasMc as kertasMcbawah', 'Jbawah.gramKertas as gramKertasbawah', 'JatasK.jenisKertasMc as kertasMcAtasK', 'JatasK.gramKertas as gramKertasAtasK', 'Jflute1K.jenisKertasMc as kertasMcflute1K', 'Jflute1K.gramKertas as gramKertasflute1K', 'JtengahK.jenisKertasMc as kertasMctengahK', 'JtengahK.gramKertas as gramKertastengahK', 'Jflute2K.jenisKertasMc as kertasMcflute2K',  'Jflute2K.gramKertas as gramKertasflute2K', 'JbawahK.jenisKertasMc as kertasMcbawahK', 'JbawahK.gramKertas as gramKertasbawahK', 'mc.gramSheetBoxKontrak as gramSheet', 'color_combine.nama as ccnama', 'mc.wax', 'box.tipeCreasCorr', 'mc.bungkus','dt.dt_perubahan','dt.approve_mkt','dt.approve_ppic', 'mc.outConv as outConv')
        ->orderBy('opi_m.id', 'desc')
        ->where('opi_m.status_opi', '=', 'Proses')
        ->get();

        // dd($query);
        return $query;
    }

    public function scopeOpidt($query)
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
        ->leftJoin('jenis_gram as JatasK', 'subsK.jenisGramLinerAtas_id', 'JatasK.id')
        ->leftJoin('jenis_gram as Jflute1K', 'subsK.jenisGramFlute1_id', 'Jflute1K.id')
        ->leftJoin('jenis_gram as JtengahK', 'subsK.jenisGramLinerTengah_id', 'JtengahK.id')
        ->leftJoin('jenis_gram as Jflute2K', 'subsK.jenisGramFlute2_id', 'Jflute2K.id')
        ->leftJoin('jenis_gram as JbawahK', 'subsK.jenisGramLinerBawah_id', 'JbawahK.id')
        ->leftJoin('color_combine', 'mc.colorCombine_id', 'color_combine.id')
        ->select('opi_m.*', 'kontrak_d.harga_kg', 'mc.namaBarang', 'mc.revisi as revisimc', 'mc.kodeBarang', 'box.panjangDalamBox as panjang', 'box.lebarDalamBox as lebar', 'box.tinggiDalamBox as tinggi', 'subsP.kode as subsP', 'subsK.kode as subsK', 'mc.flute', 'color_combine.nama as namacc', 'mc.gramSheetBoxProduksi as gramProd', 'mc.gramSheetBoxKontrak as gramKontrak', 'mc.koli', 'mc.joint', 'mc.tipeBox', 'mc.kode as mcKode', 'dt.pcsDt', 'dt.tglKirimDt','kontrak_m.kode', 'kontrak_m.tglKontrak', 'kontrak_m.customer_name as Cust', 'kontrak_m.poCustomer', 'kontrak_m.alamatKirim', 'kontrak_m.keterangan as ketkontrak','kontrak_d.pctToleransiKurangKontrak as toleransiKurang', 'kontrak_d.pctToleransiLebihKontrak as toleransiLebih', 'kontrak_m.tipeOrder', 'kontrak_d.pcsKontrak', 'mc.lebarSheet', 'mc.panjangSheet', 'mc.outConv', 'Jatas.jenisKertasMc as kertasMcAtas', 'Jatas.gramKertas as gramKertasAtas', 'Jflute1.jenisKertasMc as kertasMcflute1', 'Jflute1.gramKertas as gramKertasflute1', 'Jtengah.jenisKertasMc as kertasMctengah', 'Jtengah.gramKertas as gramKertastengah', 'Jflute2.jenisKertasMc as kertasMcflute2',  'Jflute2.gramKertas as gramKertasflute2', 'Jbawah.jenisKertasMc as kertasMcbawah', 'Jbawah.gramKertas as gramKertasbawah', 'JatasK.jenisKertasMc as kertasMcAtasK', 'JatasK.gramKertas as gramKertasAtasK', 'Jflute1K.jenisKertasMc as kertasMcflute1K', 'Jflute1K.gramKertas as gramKertasflute1K', 'JtengahK.jenisKertasMc as kertasMctengahK', 'JtengahK.gramKertas as gramKertastengahK', 'Jflute2K.jenisKertasMc as kertasMcflute2K',  'Jflute2K.gramKertas as gramKertasflute2K', 'JbawahK.jenisKertasMc as kertasMcbawahK', 'JbawahK.gramKertas as gramKertasbawahK', 'mc.gramSheetBoxKontrak as gramSheet', 'color_combine.nama as ccnama', 'mc.wax', 'box.tipeCreasCorr', 'mc.bungkus','dt.dt_perubahan','dt.approve_mkt','dt.approve_ppic', 'mc.outConv as outConv')
        ->orderBy('opi_m.id', 'desc')
        // ->where('opi_m.status', '=', 'Proses')
        ->get();

        // dd($query);
        return $query;
    }

    public function scopeControl($query)
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
        ->leftJoin('jenis_gram as JatasK', 'subsK.jenisGramLinerAtas_id', 'JatasK.id')
        ->leftJoin('jenis_gram as Jflute1K', 'subsK.jenisGramFlute1_id', 'Jflute1K.id')
        ->leftJoin('jenis_gram as JtengahK', 'subsK.jenisGramLinerTengah_id', 'JtengahK.id')
        ->leftJoin('jenis_gram as Jflute2K', 'subsK.jenisGramFlute2_id', 'Jflute2K.id')
        ->leftJoin('jenis_gram as JbawahK', 'subsK.jenisGramLinerBawah_id', 'JbawahK.id')
        ->leftJoin('color_combine', 'mc.colorCombine_id', 'color_combine.id')
        ->select('opi_m.*', 'kontrak_d.harga_kg', 'mc.namaBarang', 'mc.revisi as revisimc', 'mc.kodeBarang', 'box.panjangDalamBox as panjang', 'box.lebarDalamBox as lebar', 'box.tinggiDalamBox as tinggi', 'subsP.kode as subsP', 'subsK.kode as subsK', 'mc.flute', 'color_combine.nama as namacc', 'mc.gramSheetBoxProduksi as gram', 'mc.koli', 'mc.joint', 'mc.tipeBox', 'mc.kode as mcKode', 'dt.pcsDt', 'dt.tglKirimDt','kontrak_m.kode', 'kontrak_m.tglKontrak', 'kontrak_m.customer_name as Cust', 'kontrak_m.poCustomer', 'kontrak_m.alamatKirim', 'kontrak_m.keterangan as ketkontrak','kontrak_d.pctToleransiKurangKontrak as toleransiKurang', 'kontrak_d.pctToleransiLebihKontrak as toleransiLebih', 'kontrak_m.tipeOrder', 'kontrak_d.pcsKontrak', 'mc.lebarSheet', 'mc.panjangSheet', 'mc.outConv', 'Jatas.jenisKertasMc as kertasMcAtas', 'Jatas.gramKertas as gramKertasAtas', 'Jflute1.jenisKertasMc as kertasMcflute1', 'Jflute1.gramKertas as gramKertasflute1', 'Jtengah.jenisKertasMc as kertasMctengah', 'Jtengah.gramKertas as gramKertastengah', 'Jflute2.jenisKertasMc as kertasMcflute2',  'Jflute2.gramKertas as gramKertasflute2', 'Jbawah.jenisKertasMc as kertasMcbawah', 'Jbawah.gramKertas as gramKertasbawah', 'JatasK.jenisKertasMc as kertasMcAtasK', 'JatasK.gramKertas as gramKertasAtasK', 'Jflute1K.jenisKertasMc as kertasMcflute1K', 'Jflute1K.gramKertas as gramKertasflute1K', 'JtengahK.jenisKertasMc as kertasMctengahK', 'JtengahK.gramKertas as gramKertastengahK', 'Jflute2K.jenisKertasMc as kertasMcflute2K',  'Jflute2K.gramKertas as gramKertasflute2K', 'JbawahK.jenisKertasMc as kertasMcbawahK', 'JbawahK.gramKertas as gramKertasbawahK', 'mc.gramSheetBoxKontrak as gramSheet', 'color_combine.nama as ccnama', 'mc.wax', 'box.tipeCreasCorr', 'mc.bungkus','dt.dt_perubahan','dt.approve_mkt','dt.approve_ppic')
        ->orderBy('opi_m.noopi', 'desc')
        ->where('opi_m.noopi', 'NOT LIKE', "%CANCEL%")
        ->get();

        // dd($query);
        return $query;
    }

    public function scopeKapasitasB1($query)
    {
        $query
        ->leftJoin('dt', 'dt_id', 'dt.id')
        ->leftJoin('mc', 'mc_id', 'mc.id')
        ->select('opi_m.jumlahOrder', 'dt.tglKirimDt', 'mc.tipeBox')
        ->where('mc.tipeBox', '=', 'B1')
        ->sum('opi_m.jumlahOrder')
        ->groupBy('dt.tglKirimDt');
        // ->get();

        return $query;
    }

    public function scopeApporve_opi($query)
    {
        $query
        ->leftJoin('dt', 'dt_id', 'dt.id')
        ->leftJoin('mc', 'mc_id', 'mc.id')
        ->leftJoin('kontrak_m', 'kontrak_m_id', 'kontrak_m.id');
    }
}
