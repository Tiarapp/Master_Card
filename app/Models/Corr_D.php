<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Corr_D extends Model
{
    use HasFactory;
    protected $table = 'plan_corr_d';

    protected $fillable = [
        'opi_id',
        'plan_corr_m_id',
        'kode_plan_d',
        'sheet_p',
        'sheet_l',
        'flute',
        'bentuk',
        'out_corr',
        'out_flexo',
        'qtyOrder',
        'jml_order',
        'ukuran_roll',
        'custom_roll',
        'cop',
        'trim_waste',
        'rm_order',
        'tonase',
        'sisa',
        'jenis_atas',
        'gram_atas',
        'jenis_bf',
        'gram_bf',
        'jenis_tengah',
        'gram_tengah',
        'jenis_cf',
        'gram_cf',
        'jenis_bawah',
        'gram_bawah',
        'kebutuhan_kertasAtas',
        'kebutuhan_kertasFlute1',
        'kebutuhan_kertasTengah',
        'kebutuhan_kertasFlute2',
        'kebutuhan_kertasBawah',
        'keterangan',
        'toleransi',
        'status',
        'lock',
        'urutan',
        'dt_perubahan'
    ];

    public function corrm()
    {
        return $this->belongsTo(Corr_M::class, 'plan_corr_m_id','id');
    }

    public function hasil()
    {
        return $this->hasMany(HasilProduksi::class, 'corr_id','id');
    }

    public function scopeCorr($query)
    {
        $query->leftJoin('plan_corr_m', 'plan_corr_m_id', 'plan_corr_m.id')
        ->leftJoin('opi_m', 'opi_id', 'opi_m.id')
        ->leftJoin('kontrak_m', 'opi_m.kontrak_m_id', 'kontrak_m.id')
        ->leftJoin('mc', 'opi_m.mc_id', 'mc.id')
        ->select('plan_corr_d.*','opi_m.id as opi_id', 'plan_corr_m.id as corrmid', 'plan_corr_d.id as corrdid', 'plan_corr_m.kode_plan as kodeplanM', 'plan_corr_m.tanggal as tglcorr', 'plan_corr_m.shift', 'plan_corr_d.sheet_p as panjangsheet', 'plan_corr_d.sheet_l as lebarsheet', 'plan_corr_m.revisi', 'plan_corr_d.qtyOrder as plan', 'plan_corr_m.total_RM', 'plan_corr_m.total_Berat', 'plan_corr_d.qtyOrder as plan', 'opi_m.nama as opikode', 'kontrak_m.customer_name as customer', 'mc.namaBarang as barang', 'opi_m.tglKirimDt as tglkirim', 'mc.gramSheetCorrProduksi as gramSheet')
        ->where('plan_corr_d.id', '!=', 'null')
        ->get();


        return $query;
    }

    public function scopeCorrPrint($query)
    {
        $query->leftJoin('plan_corr_m', 'plan_corr_m_id', 'plan_corr_m.id')
        ->leftJoin('opi_m', 'opi_id', 'opi_m.id')
        ->leftJoin('kontrak_m', 'opi_m.kontrak_m_id', 'kontrak_m.id')
        ->leftJoin('kontrak_d', 'opi_m.kontrak_d_id', 'kontrak_d.id')
        ->leftJoin('mc', 'opi_m.mc_id', 'mc.id')
        ->leftJoin('box', 'mc.box_id', 'box.id')
        // ->leftJoin('substance as subsP', 'mc.substanceProduksi_id', 'subsP.id')
        // ->leftJoin('jenis_gram as Jatas', 'subsP.jenisGramLinerAtas_id', 'Jatas.id')
        // ->leftJoin('jenis_gram as Jflute1', 'subsP.jenisGramFlute1_id', 'Jflute1.id')
        // ->leftJoin('jenis_gram as Jtengah', 'subsP.jenisGramLinerTengah_id', 'Jtengah.id')
        // ->leftJoin('jenis_gram as Jflute2', 'subsP.jenisGramFlute2_id', 'Jflute2.id')
        // ->leftJoin('jenis_gram as Jbawah', 'subsP.jenisGramLinerBawah_id', 'Jbawah.id')
        // ->leftJoin('substance as subsK', 'mc.substanceKontrak_id', 'subsK.id')
        ->leftJoin('dt', 'opi_m.dt_id', 'dt.id')
        ->select('plan_corr_d.*','plan_corr_d.id as idcorr','opi_m.id as opi_id', 'plan_corr_m.id', 'plan_corr_m.kode_plan as kodeplanM', 'plan_corr_m.tanggal as tglcorr', 'plan_corr_m.shift', 'plan_corr_m.revisi', 'plan_corr_m.total_RM', 'plan_corr_m.total_Berat', 'opi_m.NoOpi as noopi', 'kontrak_m.customer_name as customer', 'mc.lebarSheet as lebar', 'mc.panjangSheet as panjang', 'mc.gramSheetBoxKontrak as gramSheet', 'mc.kode as mckode', 'mc.namaBarang as barang', 'mc.tipeBox as tipebox', 'mc.lebarSheet', 'mc.panjangSheet', 'dt.pcsDt as order', 'dt.tglKirimDt as tglDt', 'plan_corr_m.tanggal as tglplan', 'plan_corr_m.total_RM as totalrm', 'plan_corr_m.total_Berat as totalberat','kontrak_d.pctToleransiLebihKontrak as toleransiLebih', 'kontrak_d.pctToleransiKurangKontrak as toleransiKurang')
        ->get();

        // 'Jatas.jenisKertasMc as kertasMcAtas', 'Jatas.gramKertas as gramKertasAtas', 'Jflute1.jenisKertasMc as kertasMcflute1', 'Jflute1.gramKertas as gramKertasflute1', 'Jtengah.jenisKertasMc as kertasMctengah', 'Jtengah.gramKertas as gramKertastengah', 'Jflute2.jenisKertasMc as kertasMcflute2',  'Jflute2.gramKertas as gramKertasflute2', 'Jbawah.jenisKertasMc as kertasMcbawah', 'Jbawah.gramKertas as gramKertasbawah',
        return $query;
    }
}
