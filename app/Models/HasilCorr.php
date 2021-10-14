<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HasilCorr extends Model
{
    use HasFactory;

    protected $table = 'hasil_plan_corr';
    protected $fillable = [
        'plan_corr_m_id',
        'plan_corr_d_id',
        'hasil_baik',
        'hasil_jelek',
        'prod_time',
        'prod_meter',
        'm2',
        'jml_palet',
        'status',
        'next_mesin',
        'created_at',
        'updated_at'
    ];

    public function scopeHasilcorr($query)
    {
        $query->leftJoin('plan_corr_d', 'plan_corr_d_id', 'plan_corr_d.id')
        ->leftJoin('plan_corr_m', 'plan_corr_d.plan_corr_m_id', 'plan_corr_m.id')
        ->leftJoin('opi_m', 'plan_corr_d.opi_id', 'opi_m.id')
        ->leftJoin('kontrak_m', 'opi_m.kontrak_m_id', 'kontrak_m.id')
        ->leftJoin('mc', 'opi_m.mc_id', 'mc.id')
        ->leftJoin('color_combine', 'mc.colorCombine_id', 'color_combine.id')
        ->leftJoin('substance as subsP', 'mc.substanceProduksi_id', 'subsP.id')
        ->leftJoin('jenis_gram as Jatas', 'subsP.jenisGramLinerAtas_id', 'Jatas.id')
        ->leftJoin('jenis_gram as Jflute1', 'subsP.jenisGramFlute1_id', 'Jflute1.id')
        ->leftJoin('jenis_gram as Jtengah', 'subsP.jenisGramLinerTengah_id', 'Jtengah.id')
        ->leftJoin('jenis_gram as Jflute2', 'subsP.jenisGramFlute2_id', 'Jflute2.id')
        ->leftJoin('jenis_gram as Jbawah', 'subsP.jenisGramLinerBawah_id', 'Jbawah.id')
        ->leftJoin('substance as subsK', 'mc.substanceKontrak_id', 'subsK.id')
        ->leftJoin('dt', 'opi_m.dt_id', 'dt.id')
        ->select('plan_corr_d.*','plan_corr_d.id as idcorr','opi_m.id as opi_id', 'plan_corr_m.id', 'plan_corr_m.kode_plan as kodeplanM', 'plan_corr_m.tanggal as tglcorr', 'plan_corr_m.shift', 'plan_corr_m.revisi', 'plan_corr_m.total_RM', 'plan_corr_m.total_Berat', 'opi_m.NoOpi as noopi', 'kontrak_m.customer_name as customer', 'mc.lebarSheet as lebar', 'mc.panjangSheet as panjang','Jatas.jenisKertasMc as kertasMcAtas', 'Jatas.gramKertas as gramKertasAtas', 'Jflute1.jenisKertasMc as kertasMcflute1', 'Jflute1.gramKertas as gramKertasflute1', 'Jtengah.jenisKertasMc as kertasMctengah', 'Jtengah.gramKertas as gramKertastengah', 'Jflute2.jenisKertasMc as kertasMcflute2',  'Jflute2.gramKertas as gramKertasflute2', 'Jbawah.jenisKertasMc as kertasMcbawah', 'Jbawah.gramKertas as gramKertasbawah', 'mc.gramSheetBoxKontrak as gramSheet', 'mc.kode as mckode', 'mc.namaBarang as barang', 'mc.tipeBox as tipebox', 'mc.lebarSheet', 'mc.panjangSheet', 'dt.pcsDt as order', 'dt.tglKirimDt as tglDt', 'plan_corr_m.tanggal as tglplan', 'plan_corr_m.total_RM as totalrm', 'plan_corr_m.total_Berat as totalberat', 'kontrak_m.tipeOrder as tipeorder','color_combine.nama as warna', 'mc.joint as joint',DB::raw('SUM(hasil_baik) as totalhasil'))
        ->groupBy('plan_corr_d.id')
        ->get();
    }

    // public function scopeHasilcorrnew($query)
    // {
    //     DB::table('hasil_plan_corr')->select('hasil_baik', 'hasil_jelek', DB::raw('SUM(hasil_baik) as totalhasil'))->groupBy('hasil_baik')->get();
    // }
}
