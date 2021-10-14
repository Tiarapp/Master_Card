<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conv_D extends Model
{
    use HasFactory;

    protected $table = 'plan_conv_d';
    protected $fillable = [
        'opi_id',
        'plan_conv_m_id',
        'plan_corr_id',
        'tgl_kirim',
        'nomc',
        'nama_item',
        'customer',
        'tipe_order',
        'joint',
        'wax',
        'mesin',
        'sheet_p',
        'sheet_l',
        'flute',
        'bentuk',
        'warna',
        'out_flexo',
        'qtyOrder',
        'jml_plan',
        'ukuran_roll',
        'bungkus',
        'lain_lain',
        'rm_order',
        'tonase',
        'keterangan',
        'status',
        'lock'
    ];

    public function convm()
    {
        return $this->belongsTo(Conv_M::class, 'plan_conv_m_id', 'id');
    }

    public function scopeConv($query)
    {
        $query->leftJoin('plan_corr_d', 'plan_corr_id', 'plan_corr_d.id')
        ->leftJoin('plan_corr_m', 'plan_corr_d.plan_corr_m_id', 'plan_corr_m.id')
        ->leftJoin('opi_m', 'plan_corr_d.opi_id', 'opi_m.id')
        ->leftJoin('kontrak_m', 'opi_m.kontrak_m_id', 'kontrak_m.id')
        ->leftJoin('mc', 'opi_m.mc_id', 'mc.id')
        ->leftJoin('substance as subsP', 'mc.substanceProduksi_id', 'subsP.id')
        ->leftJoin('jenis_gram as Jatas', 'subsP.jenisGramLinerAtas_id', 'Jatas.id')
        ->leftJoin('jenis_gram as Jflute1', 'subsP.jenisGramFlute1_id', 'Jflute1.id')
        ->leftJoin('jenis_gram as Jtengah', 'subsP.jenisGramLinerTengah_id', 'Jtengah.id')
        ->leftJoin('jenis_gram as Jflute2', 'subsP.jenisGramFlute2_id', 'Jflute2.id')
        ->leftJoin('jenis_gram as Jbawah', 'subsP.jenisGramLinerBawah_id', 'Jbawah.id')
        ->leftJoin('substance as subsK', 'mc.substanceKontrak_id', 'subsK.id')
        ->leftJoin('dt', 'opi_m.dt_id', 'dt.id')
        ->select('plan_corr_d.*','plan_corr_d.id as idcorr','opi_m.id as opi_id', 'plan_corr_m.id', 'plan_corr_m.kode_plan as kodeplanM', 'plan_corr_m.tanggal as tglcorr', 'plan_corr_m.shift', 'plan_corr_m.revisi', 'plan_corr_m.total_RM', 'plan_corr_m.total_Berat', 'opi_m.NoOpi as noopi', 'kontrak_m.customer_name as customer', 'mc.lebarSheet as lebar', 'mc.panjangSheet as panjang','Jatas.jenisKertasMc as kertasMcAtas', 'Jatas.gramKertas as gramKertasAtas', 'Jflute1.jenisKertasMc as kertasMcflute1', 'Jflute1.gramKertas as gramKertasflute1', 'Jtengah.jenisKertasMc as kertasMctengah', 'Jtengah.gramKertas as gramKertastengah', 'Jflute2.jenisKertasMc as kertasMcflute2',  'Jflute2.gramKertas as gramKertasflute2', 'Jbawah.jenisKertasMc as kertasMcbawah', 'Jbawah.gramKertas as gramKertasbawah', 'mc.gramSheetBoxKontrak as gramSheet', 'mc.kode as mckode', 'mc.namaBarang as barang', 'mc.tipeBox as tipebox', 'mc.lebarSheet', 'mc.panjangSheet', 'dt.pcsDt as order', 'dt.tglKirimDt as tglDt', 'plan_corr_m.tanggal as tglplan', 'plan_corr_m.total_RM as totalrm', 'plan_corr_m.total_Berat as totalberat')
        ->get();
    }
}
