@extends('admin.templates.partials.default')

@section('title', 'Inventory Summary by Jenis+GSM x Lebar')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Inventory Summary</h1>
                    <p class="text-muted">Ringkasan Inventory berdasarkan (Jenis + GSM) x Lebar</p>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('inventory.index') }}">Inventory</a></li>
                        <li class="breadcrumb-item active">Summary</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <!-- Summary Cards -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ number_format($totalVariants) }}</h3>
                            <p>Total Varian</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-layer-group"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ number_format($grandTotal, 2) }}</h3>
                            <p>Total Quantity</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-weight"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ number_format($totalRolls) }}</h3>
                            <p>Total Roll</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-scroll"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ number_format($avgWeight, 2) }}</h3>
                            <p>Rata-rata Berat</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-balance-scale"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-filter"></i> Filter Data
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.inventory.summary') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="jenis_filter">Jenis</label>
                                    <select name="jenis_filter" id="jenis_filter" class="form-control">
                                        <option value="">-- Semua Jenis --</option>
                                        @foreach($jenisOptions as $jenis)
                                            <option value="{{ $jenis }}" {{ request('jenis_filter') == $jenis ? 'selected' : '' }}>
                                                {{ $jenis }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="gsm_filter">GSM</label>
                                    <select name="gsm_filter" id="gsm_filter" class="form-control">
                                        <option value="">-- Semua GSM --</option>
                                        @foreach($gsmOptions as $gsm)
                                            <option value="{{ $gsm }}" {{ request('gsm_filter') == $gsm ? 'selected' : '' }}>
                                                {{ $gsm }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="lebar_filter">Lebar</label>
                                    <select name="lebar_filter" id="lebar_filter" class="form-control">
                                        <option value="">-- Semua Lebar --</option>
                                        @foreach($lebarOptions as $lebar)
                                            <option value="{{ $lebar }}" {{ request('lebar_filter') == $lebar ? 'selected' : '' }}>
                                                {{ $lebar }} cm
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="supplier_filter">Supplier</label>
                                    <select name="supplier_filter" id="supplier_filter" class="form-control">
                                        <option value="">-- Semua Supplier --</option>
                                        @foreach($supplierOptions as $supplier)
                                            <option value="{{ $supplier->id }}" {{ request('supplier_filter') == $supplier->id ? 'selected' : '' }}>
                                                {{ $supplier->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                                <a href="{{ route('admin.inventory.summary') }}" class="btn btn-secondary">
                                    <i class="fas fa-undo"></i> Reset
                                </a>
                                <a href="{{ route('inventory.index') }}" class="btn btn-info">
                                    <i class="fas fa-list"></i> Lihat Detail Inventory
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Summary Table -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-table"></i> Summary by (Jenis + GSM) x Lebar
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-sm btn-success" onclick="exportToExcel()">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </button>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap" id="summaryTable">
                        <thead class="bg-light">
                            <tr>
                                <th>No</th>
                                <th>Jenis + GSM</th>
                                <th>Lebar (cm)</th>
                                <th>Total Quantity</th>
                                <th>Total Roll</th>
                                <th>Rata-rata Berat</th>
                                <th>%</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($summaryData as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ $item->jenis }}</strong> 
                                        <span class="badge badge-primary">{{ $item->gsm }} GSM</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">{{ $item->lebar }} cm</span>
                                    </td>
                                    <td>
                                        <strong class="text-success">{{ number_format($item->total_quantity, 2) }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge badge-warning">{{ number_format($item->total_rolls) }}</span>
                                    </td>
                                    <td>{{ number_format($item->avg_weight, 2) }}</td>
                                    <td>
                                        @php
                                            $percentage = $grandTotal > 0 ? ($item->total_quantity / $grandTotal) * 100 : 0;
                                        @endphp
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-primary" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <small>{{ number_format($percentage, 1) }}%</small>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <br>
                                        Tidak ada data yang ditemukan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if($summaryData->count() > 0)
                        <tfoot class="bg-light">
                            <tr>
                                <th colspan="3" class="text-right">TOTAL HALAMAN INI:</th>
                                <th class="text-success">{{ number_format($summaryData->sum('total_quantity'), 2) }}</th>
                                <th class="text-warning">{{ number_format($summaryData->sum('total_rolls')) }}</th>
                                <th>{{ number_format($summaryData->avg('avg_weight'), 2) }}</th>
                                <th>
                                    @php
                                        $currentPageTotal = $summaryData->sum('total_quantity');
                                        $currentPagePercentage = $grandTotal > 0 ? ($currentPageTotal / $grandTotal) * 100 : 0;
                                    @endphp
                                    {{ number_format($currentPagePercentage, 1) }}%
                                </th>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
                @if($summaryData->hasPages())
                <div class="card-footer clearfix">
                    <div class="row">
                        <div class="col-sm-12 col-md-5">
                            <div class="dataTables_info">
                                Menampilkan {{ $summaryData->firstItem() }} sampai {{ $summaryData->lastItem() }} 
                                dari {{ $summaryData->total() }} varian
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers float-right">
                                {{ $summaryData->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
<script>
function exportToExcel() {
    // Get table
    const table = document.getElementById('summaryTable');
    
    // Create workbook
    const wb = XLSX.utils.table_to_book(table, {sheet: "Inventory Summary"});
    
    // Generate filename with current date
    const date = new Date().toISOString().slice(0, 10);
    const filename = `inventory_summary_${date}.xlsx`;
    
    // Save file
    XLSX.writeFile(wb, filename);
}

// Auto refresh every 5 minutes
setInterval(function() {
    if (confirm('Refresh data untuk update terbaru?')) {
        location.reload();
    }
}, 300000);
</script>
@endpush

@endsection
