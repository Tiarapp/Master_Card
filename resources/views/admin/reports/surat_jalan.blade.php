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
                        Data Surat Jalan
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Reports</a></li>
                        <li class="breadcrumb-item active">Surat Jalan</li>
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
                    <form method="GET" action="{{ route('admin.report.surat_jalan') }}" class="form-inline">
                        <div class="form-group mr-3">
                            <label for="tanggal_awal" class="mr-2">Tanggal Awal:</label>
                            <input type="date" 
                                   name="tanggal_awal" 
                                   id="tanggal_awal" 
                                   class="form-control" 
                                   placeholder="MM/YYYY" 
                                   value="{{ $tanggal_awal ?? '' }}"
                                   style="width: 150px;">
                        </div>
                        <div class="form-group mr-3">
                            <label for="tanggal_akhir" class="mr-2">Tanggal Akhir:</label>
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
                        <a href="{{ route('admin.report.surat_jalan.export', ['tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir]) }}" class="btn btn-success">
                            <i class="fas fa-file-excel mr-1"></i>Export Excel
                        </a>
                    </form>
                </div>
            </div>

            <!-- Surat Jalan Report Table -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-file-alt mr-1"></i>
                        Laporan Surat Jalan
                    </h3>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>No. Surat Jalan</th>
                                <th>Tanggal</th>
                                <th>MOD</th>
                                <th>Kontrak</th>
                                <th>PO</th>
                                <th>Customer</th>
                                <th>Expedisi</th>
                                <th>No. Kendaraan</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse($suratjalan as $sj)
                            <tr class="deadstock-row">
                                <td>{{ trim($sj->NomerSJ) }}</td>
                                <td>{{ \Carbon\Carbon::parse($sj->TglSJ)->format('d-m-Y') }}</td>
                                <td>{{ $sj->NomerMOD }}</td>
                                <td>{{ $sj->mod->NomerSC ?? '' }}</td>
                                <td>{{ $sj->mod->NomerPI_PO ?? '' }}</td>
                                <td>{{ $sj->NamaCust }}</td>
                                <td>{{ $sj->supplier->Nama ?? '' }}</td>
                                <td>{{ $sj->NoKend }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data untuk periode ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    @if($suratjalan->hasPages())
                    <div class="mt-3">
                        {{ $suratjalan->links() }}
                    </div>
                    @endif
                </div>
            </div>
    </section>
</div>
@endsection

@section('javascripts')

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