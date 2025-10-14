@extends('admin.templates.partials.default')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-eye mr-2"></i>Detail Retur Penjualan
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('barang.retur') }}">Retur Penjualan</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            
            <!-- Header Card -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-eye mr-2"></i>Detail Retur Penjualan
                    </h3>
                    <div class="card-tools">
                        <span class="badge badge-info">{{ $retur->NoBukti }}</span>
                        <span class="badge {{ $retur->Blocked == 'Y' ? 'badge-success' : 'badge-danger' }}">
                            Blocked: {{ $retur->Blocked }}
                        </span>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <!-- Kolom Kiri -->
                        <div class="col-md-6">
                            <!-- Info Umum -->
                            <div class="form-group">
                                <label><i class="fas fa-calendar-alt mr-1"></i>Tanggal Retur:</label>
                                <div class="form-control-plaintext border p-2 bg-light">
                                    {{ \Carbon\Carbon::parse($retur->TglRetur)->format('d/m/Y') }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label><i class="fas fa-barcode mr-1"></i>No Bukti:</label>
                                <div class="form-control-plaintext border p-2 bg-light">
                                    {{ $retur->NoBukti }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label><i class="fas fa-user mr-1"></i>Kode Customer:</label>
                                <div class="form-control-plaintext border p-2 bg-light">
                                    {{ $retur->KodeCust }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label><i class="fas fa-building mr-1"></i>Nama Customer:</label>
                                <div class="form-control-plaintext border p-2 bg-light">
                                    {{ $retur->NamaCust }}
                                </div>
                            </div>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="col-md-6">
                            <!-- Status -->
                            <div class="form-group">
                                <label><i class="fas fa-info-circle mr-1"></i>Status:</label>
                                <div class="d-flex flex-wrap">
                                    <span class="badge badge-info mr-2 mb-2">Aktif: {{ $retur->Aktif }}</span>
                                    <span class="badge badge-secondary mr-2 mb-2">Print: {{ $retur->Print }}</span>
                                    <span class="badge {{ $retur->Blocked == 'Y' ? 'badge-success' : 'badge-danger' }} mr-2 mb-2">
                                        Blocked: {{ $retur->Blocked }}
                                    </span>
                                </div>
                            </div>

                            <!-- User Info -->
                            <div class="form-group">
                                <label><i class="fas fa-user-circle mr-1"></i>User Created:</label>
                                <div class="form-control-plaintext border p-2 bg-light">
                                    {{ $retur->UserCreated ? $retur->UserCreated : 'N/A' }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label><i class="fas fa-clock mr-1"></i>Created At:</label>
                                <div class="form-control-plaintext border p-2 bg-light">
                                    {{ $retur->CreatedAt ? \Carbon\Carbon::parse($retur->CreatedAt)->format('d/m/Y H:i:s') : 'N/A' }}
                                </div>
                            </div>

                            @if($retur->Blocked == 'Y')
                                <div class="alert alert-success alert-sm">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    <strong>Status:</strong> Retur ini dapat diedit karena status Blocked = Y
                                </div>
                            @else
                                <div class="alert alert-warning alert-sm">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    <strong>Status:</strong> Retur ini tidak dapat diedit (Blocked ≠ Y)
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Barang -->
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-truck mr-2"></i>Detail Retur Barang
                    </h3>
                    <div class="card-tools">
                        <span class="badge badge-secondary">
                            Total: {{ $returDetails ? $returDetails->count() : 0 }} item(s)
                        </span>
                    </div>
                </div>
                
                <div class="card-body">
                    @if($returDetails && $returDetails->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="15%">No SJ</th>
                                        <th width="12%">Kode Barang</th>
                                        <th width="28%">Nama Barang</th>
                                        <th width="8%">Qty</th>
                                        <th width="32%">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($returDetails as $index => $detail)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td>
                                                <span class="badge badge-info">{{ $detail->NomerSJ }}</span>
                                            </td>
                                            <td>
                                                <code>{{ $detail->KodeBrg }}</code>
                                            </td>
                                            <td>{{ $detail->NamaBrg }}</td>
                                            <td class="text-right">
                                                <span class="badge badge-primary">{{ number_format($detail->Quantity, 2) }}</span>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $detail->Keterangan ? $detail->Keterangan : 'Tidak ada keterangan' }}</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-light">
                                    <tr>
                                        <th colspan="4" class="text-right">Total Quantity:</th>
                                        <th class="text-right">
                                            <span class="badge badge-success">
                                                {{ number_format($returDetails->sum('Quantity'), 2) }}
                                            </span>
                                        </th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Tidak ada detail retur</h5>
                            <p class="text-muted">Retur ini belum memiliki detail barang yang diretur.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <a href="{{ route('barang.retur') }}" class="btn btn-secondary mr-2">
                                <i class="fas fa-arrow-left mr-1"></i>Kembali ke Daftar
                            </a>
                            
                            @if($retur->Blocked == 'Y')
                                <a href="{{ route('barang.retur.edit', $retur->NoBukti) }}" class="btn btn-warning mr-2">
                                    <i class="fas fa-edit mr-1"></i>Edit Retur
                                </a>
                            @endif
                            
                            <button type="button" class="btn btn-info" onclick="window.print()">
                                <i class="fas fa-print mr-1"></i>Print Detail
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Box -->
            <div class="row">
                <div class="col-12">
                    <div class="callout callout-info">
                        <h5><i class="fas fa-info mr-2"></i>Informasi Detail:</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-0">
                                    • <strong>No Bukti:</strong> {{ $retur->NoBukti }}<br>
                                    • <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($retur->TglRetur)->format('d/m/Y') }}<br>
                                    • <strong>Customer:</strong> {{ $retur->KodeCust }} - {{ $retur->NamaCust }}<br>
                                    • <strong>Total Item:</strong> {{ $returDetails ? $returDetails->count() : 0 }} barang
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-0">
                                    • <strong>Status Blocked:</strong> {{ $retur->Blocked }}<br>
                                    • <strong>Status Aktif:</strong> {{ $retur->Aktif }}<br>
                                    • <strong>Status Print:</strong> {{ $retur->Print }}<br>
                                    • <strong>Total Quantity:</strong> {{ $returDetails ? number_format($returDetails->sum('Quantity'), 2) : '0.00' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
@media print {
    .content-wrapper {
        margin: 0 !important;
        padding: 0 !important;
    }
    .content-header {
        page-break-after: avoid;
    }
    .card {
        border: 1px solid #000 !important;
        box-shadow: none !important;
    }
    .btn, .breadcrumb, .callout {
        display: none !important;
    }
    .badge {
        border: 1px solid #000 !important;
        background-color: #fff !important;
        color: #000 !important;
    }
    .thead-dark th {
        background-color: #000 !important;
        color: #fff !important;
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f8f9fa !important;
    }
}
</style>

@endsection