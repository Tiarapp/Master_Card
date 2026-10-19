@extends('admin.templates.partials.default')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-warehouse mr-2"></i>
                        Realisasi Kirim OPI
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Reports</a></li>
                        <li class="breadcrumb-item active">Realisasi Kirim OPI</li>
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
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <!-- Filter Controls -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-filter mr-1"></i>
                        Filter Data
                    </h3>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.report.opi') }}" class="form-inline">
                        <div class="form-group mr-3">
                            <label for="tanggal_awal" class="mr-2">Tanggal Kirim Awal:</label>
                            <input type="date"
                                   name="tanggal_awal"
                                   id="tanggal_awal"
                                   class="form-control"
                                   placeholder="MM/YYYY"
                                   value="{{ $tanggal_awal ?? '' }}"
                                   style="width: 150px;">
                        </div>
                        <div class="form-group mr-3">
                            <label for="tanggal_akhir" class="mr-2">Tanggal Kirim Akhir:</label>
                            <input type="date"
                                   name="tanggal_akhir"
                                   id="tanggal_akhir"
                                   class="form-control"
                                   placeholder="MM/YYYY"
                                   value="{{ $tanggal_akhir ?? '' }}"
                                   style="width: 150px;">
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">
                            <i class="fas fa-search mr-1"></i>Filter
                        </button>
                        <a href="{{ route('admin.report.opi.export') }}" id="btn-export-opi" class="btn btn-success mr-2">
                            <i class="fas fa-file-excel mr-1"></i>Export Excel
                        </a>
                        <a href="{{ route('admin.report.opi') }}" class="btn btn-secondary">
                            <i class="fas fa-redo mr-1"></i>Reset
                        </a>
                    </form>
                </div>
            </div>

            <!-- OPI Report Table -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-file-alt mr-1"></i>
                        Relasi OPI -> Realisasi Kirim
                    </h3>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>No. OPI</th>
                                <th>Customer</th>
                                <th>No. Kontrak</th>
                                <th>Tanggal Rencana Kirim</th>
                                <th>Qty OPI (pcs)</th>
                                <th>Qty OPI (kg)</th>
                                <th>Tanggal Realisasi</th>
                                <th>No. Surat Jalan</th>
                                <th>Qty Kirim (pcs)</th>
                                <th>Qty Kirim (kg)</th>
                                <th>Harga per Kg</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($realisasi as $kirim)
                            <tr class="deadstock-row">
                                <td>{{ $kirim->opi->NoOPI ?? '' }}</td>
                                <td>{{ $kirim->opi->kontrakm->customer_name ?? $kirim->kontrakm->customer_name ?? '' }}</td>
                                <td>{{ $kirim->opi->kontrakm->kode ?? $kirim->kontrakm->kode ?? '' }}</td>
                                <td>{{ $kirim->opi && $kirim->opi->tglKirimDt ? \Carbon\Carbon::parse($kirim->opi->tglKirimDt)->format('d-m-Y') : '' }}</td>
                                <td>{{ $kirim->opi->jumlahOrder ?? '' }}</td>
                                <td>{{ $kirim->opi && $kirim->opi->mc && $kirim->opi->mc->gramSheetBoxKontrak2 ? $kirim->opi->jumlahOrder * $kirim->opi->mc->gramSheetBoxKontrak2 : '' }}</td>
                                <td>{{ $kirim->tanggal_kirim ? \Carbon\Carbon::parse($kirim->tanggal_kirim)->format('d-m-Y') : '' }}</td>
                                <td>{{ $kirim->nomer_sj ?? '' }}</td>
                                <td>{{ $kirim->qty_kirim ?? '' }}</td>
                                <td>{{ $kirim->kg_kirim ?? '' }}</td>
                                <td>{{ $kirim->opi->kontrakd->harga_kg ?? '' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">Tidak ada data realisasi OPI untuk periode ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    @if($realisasi->hasPages())
                    <div class="mt-3">
                        {{ $realisasi->links() }}
                    </div>
                    @endif
                </div>
            </div>
    </section>
</div>
@endsection

@section('javascripts')

<script>
document.addEventListener('DOMContentLoaded', function () {
    var btn = document.getElementById('btn-export-opi');
    if (!btn) return;

    var baseUrl = btn.getAttribute('href');
    btn.addEventListener('click', function (e) {
        var awal = document.getElementById('tanggal_awal').value;
        var akhir = document.getElementById('tanggal_akhir').value;

        if (!awal || !akhir) {
            e.preventDefault();
            alert('Tanggal Kirim Awal dan Tanggal Kirim Akhir harus diisi sebelum export.');
            return;
        }

        if (akhir < awal) {
            e.preventDefault();
            alert('Tanggal Kirim Akhir tidak boleh lebih kecil dari Tanggal Kirim Awal.');
            return;
        }

        btn.setAttribute('href', baseUrl + '?tanggal_awal=' + encodeURIComponent(awal) + '&tanggal_akhir=' + encodeURIComponent(akhir));
    });
});
</script>

<style>
.deadstock-row {
    transition: background-color 0.3s ease;
}

.table-hover tbody tr:hover {
    background-color: #f5f5f5;
}

.info-box {
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
}

.small-box {
    border-radius: 0.5rem;
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
}

.badge {
    font-size: 0.875rem;
}

.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.thead-dark th {
    background-color: #343a40;
    border-color: #454d55;
}

@media (max-width: 768px) {
    .small-box h3 {
        font-size: 1.5rem;
    }

    .table-responsive {
        font-size: 0.875rem;
    }
}
</style>
@endsection
