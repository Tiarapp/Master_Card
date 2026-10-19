@extends('admin.templates.partials.default')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-file-export mr-2"></i>
                        Export OPI
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Reports</a></li>
                        <li class="breadcrumb-item active">Export OPI</li>
                    </ol>
                </div>
            </div>

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="icon fas fa-ban"></i>
                {{ session('error') }}
            </div>
            @endif
            @if($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-filter mr-1"></i>
                        Filter Data
                    </h3>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.report.opi_export') }}" class="form-inline">
                        <div class="form-group mr-3">
                            <label for="tanggal_awal" class="mr-2">Tgl Estimasi Kirim Awal:</label>
                            <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control"
                                   value="{{ $tanggal_awal ?? '' }}" style="width: 150px;">
                        </div>
                        <div class="form-group mr-3">
                            <label for="tanggal_akhir" class="mr-2">Tgl Estimasi Kirim Akhir:</label>
                            <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control"
                                   value="{{ $tanggal_akhir ?? '' }}" style="width: 150px;">
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">
                            <i class="fas fa-search mr-1"></i>Filter
                        </button>
                        <a href="{{ route('admin.report.opi_export.download') }}" id="btn-export-opi-data" class="btn btn-success">
                            <i class="fas fa-file-excel mr-1"></i>Export Excel
                        </a>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-file-alt mr-1"></i>
                        Data OPI
                    </h3>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Nomor OPI</th>
                                <th>Customer</th>
                                <th>Nama Barang</th>
                                <th>Tipe Box</th>
                                <th>Flute</th>
                                <th>Nomor Kontrak</th>
                                <th>Tgl Kontrak</th>
                                <th>Qty OPI (pcs)</th>
                                <th>Qty OPI (kg)</th>
                                <th>Tanggal Estimasi Kirim</th>
                                <th>Tanggal Kirim</th>
                                <th>Qty Realisasi (pcs)</th>
                                <th>Qty Realisasi (kg)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($opi as $row)
                            <tr>
                                <td>{{ $row->NoOPI }}</td>
                                <td>{{ $row->kontrakm->customer_name ?? '' }}</td>
                                <td>{{ $row->mc->namaBarang ?? '' }}</td>
                                <td>{{ $row->mc->tipeBox ?? '' }}</td>
                                <td>{{ $row->mc->flute ?? '' }}</td>
                                <td>{{ $row->kontrakm->kode ?? '' }}</td>
                                <td>{{ !empty($row->kontrakm->tglKontrak) ? \Carbon\Carbon::parse($row->kontrakm->tglKontrak)->format('d-m-Y') : '' }}</td>
                                <td>{{ $row->jumlahOrder }}</td>
                                <td>{{ $row->mc && $row->mc->gramSheetBoxKontrak2 ? number_format($row->jumlahOrder * $row->mc->gramSheetBoxKontrak2, 2) : '' }}</td>
                                <td>{{ $row->tglKirimDt ? \Carbon\Carbon::parse($row->tglKirimDt)->format('d-m-Y') : '' }}</td>
                                <td>{{ $row->tanggal_realisasi ? \Carbon\Carbon::parse($row->tanggal_realisasi)->format('d-m-Y') : '' }}</td>
                                <td>{{ $row->total_qty_realisasi ?? 0 }}</td>
                                <td>{{ number_format($row->total_kg_realisasi ?? 0, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="13" class="text-center">Tidak ada data OPI untuk periode ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    @if($opi->hasPages())
                    <div class="mt-3">
                        {{ $opi->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('javascripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var btn = document.getElementById('btn-export-opi-data');
    if (!btn) return;

    var baseUrl = btn.getAttribute('href');
    btn.addEventListener('click', function (e) {
        var awal = document.getElementById('tanggal_awal').value;
        var akhir = document.getElementById('tanggal_akhir').value;

        if (!awal || !akhir) {
            e.preventDefault();
            alert('Tanggal Estimasi Kirim Awal dan Akhir harus diisi sebelum export.');
            return;
        }

        if (akhir < awal) {
            e.preventDefault();
            alert('Tanggal Akhir tidak boleh lebih kecil dari Tanggal Awal.');
            return;
        }

        btn.setAttribute('href', baseUrl + '?tanggal_awal=' + encodeURIComponent(awal) + '&tanggal_akhir=' + encodeURIComponent(akhir));
    });
});
</script>
<style>
.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}
</style>
@endsection
