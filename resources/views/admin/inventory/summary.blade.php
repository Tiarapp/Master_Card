@extends('admin.templates.partials.default')

@section('title', 'Inventory Summary by Jenis+GSM x Lebar')

@push('styles')
<!-- INLINE SELECT2 CSS - FORCE LOAD -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" />

<!-- INLINE CSS FOR SELECT2 -->
<style>
/* Force Select2 styling */
.select2-container {
    width: 100% !important;
    display: block !important;
}

.select2-container--bootstrap4 .select2-selection {
    height: calc(2.25rem + 2px) !important;
    border: 1px solid #ced4da !important;
    border-radius: 0.25rem !important;
    font-size: 0.875rem !important;
    background-color: #fff !important;
}

.select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
    line-height: calc(2.25rem + 2px) !important;
    padding-left: 0.75rem !important;
    padding-right: 0.75rem !important;
    color: #495057 !important;
}

.select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow {
    height: calc(2.25rem + 2px) !important;
    right: 3px !important;
}

.select2-container--bootstrap4.select2-container--focus .select2-selection {
    border-color: #80bdff !important;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
}

.select2-dropdown {
    border: 1px solid #ced4da !important;
    border-radius: 0.25rem !important;
    font-size: 0.875rem !important;
    z-index: 9999 !important;
}

.select2-container--bootstrap4 .select2-results__option--highlighted {
    background-color: #007bff !important;
    color: white !important;
}

.select2-container--bootstrap4 .select2-results__option {
    padding: 6px 12px !important;
}

.select2-container--bootstrap4 .select2-search--dropdown .select2-search__field {
    border: 1px solid #ced4da !important;
    border-radius: 0.25rem !important;
    padding: 4px 8px !important;
}

.form-group label {
    font-weight: 600 !important;
    color: #495057 !important;
    margin-bottom: 0.5rem !important;
}

/* High z-index to avoid conflicts */
.select2-container--open {
    z-index: 99999 !important;
}

.select2-dropdown {
    z-index: 99999 !important;
}

/* Debug styling to see if Select2 is applied */
.select2-container::after {
    content: "✅ Select2 Applied" !important;
    position: absolute !important;
    top: -20px !important;
    left: 0 !important;
    font-size: 10px !important;
    color: green !important;
    background: white !important;
    padding: 2px !important;
    border: 1px solid green !important;
    border-radius: 3px !important;
    z-index: 99999 !important;
}

/* Prevent conflicting styles */
body.inventory-summary-page {
    /* Override any conflicting styles */
}
</style>

<script>
// Early script to prevent conflicts
console.log('🎨 Select2 CSS loaded inline');
window.select2CssLoaded = true;
</script>
@endpush

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
                                    <select name="jenis_filter" id="jenis_filter" class="form-control select2" data-placeholder="-- Semua Jenis --">
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
                                    <select name="gsm_filter" id="gsm_filter" class="form-control select2" data-placeholder="-- Semua GSM --">
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
                                    <select name="lebar_filter" id="lebar_filter" class="form-control select2" data-placeholder="-- Semua Lebar --">
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
                                    <select name="supplier_filter" id="supplier_filter" class="form-control select2" data-placeholder="-- Semua Supplier --">
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
                                <button type="button" id="clearFilters" class="btn btn-warning">
                                    <i class="fas fa-eraser"></i> Clear Filter
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

@section('javascripts')
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
<script>
console.log('🚀 Starting Select2 initialization...');

$(document).ready(function() {
    console.log('✅ jQuery ready, version:', $.fn.jquery);
    
    // Check if Select2 is available
    if (typeof $.fn.select2 === 'undefined') {
        console.error('❌ Select2 not available!');
        return;
    }
    
    console.log('✅ Select2 is available');
    
    // Find elements
    const selectors = ['#gsm_filter', '#lebar_filter', '#jenis_filter', '#supplier_filter'];
    let foundElements = 0;
    
    selectors.forEach(function(selector) {
        const element = $(selector);
        if (element.length > 0) {
            foundElements++;
            console.log('✅ Found:', selector);
        } else {
            console.warn('⚠️ Not found:', selector);
        }
    });
    
    console.log(`Found ${foundElements}/${selectors.length} elements`);
    
    if (foundElements === 0) {
        console.error('❌ No select elements found!');
        return;
    }
    
    try {
        // Initialize Select2 with exact same config as index.blade.php
        $('#gsm_filter, #lebar_filter, #jenis_filter, #supplier_filter').select2({
            theme: 'bootstrap4',
            width: '100%',
            allowClear: true
        });
        
        console.log('🎉 Select2 initialized successfully!');
        
        // Test by checking if select2 is applied
        selectors.forEach(function(selector) {
            const element = $(selector);
            if (element.length > 0 && element.hasClass('select2-hidden-accessible')) {
                console.log('✅ Select2 applied to:', selector);
            } else if (element.length > 0) {
                console.warn('⚠️ Select2 NOT applied to:', selector);
            }
        });
        
    } catch (error) {
        console.error('❌ Error initializing Select2:', error);
    }
    
    // Clear filters button
    $('#clearFilters').on('click', function(e) {
        e.preventDefault();
        console.log('🗑️ Clearing all filters...');
        $('#gsm_filter, #lebar_filter, #jenis_filter, #supplier_filter').val(null).trigger('change');
    });
});

// Export Excel function
function exportToExcel() {
    try {
        const table = document.getElementById('summaryTable');
        const wb = XLSX.utils.table_to_book(table, {sheet: "Inventory Summary"});
        const date = new Date().toISOString().slice(0, 10);
        const filename = `inventory_summary_${date}.xlsx`;
        XLSX.writeFile(wb, filename);
    } catch (error) {
        console.error('Export error:', error);
        alert('Gagal export Excel: ' + error.message);
    }
}
</script>
@endsection

@endsection
