@extends('admin.templates.partials.default')

@section('title', 'Inventory Summary by Jenis+GSM x Lebar')

@push('styles')
<!-- Select2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" />
<style>
.select2-container {
    width: 100% !important;
}
.select2-container--bootstrap4 .select2-selection {
    height: calc(2.25rem + 2px) !important;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    font-size: 0.875rem;
}
.select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
    line-height: calc(2.25rem + 2px);
    padding-left: 0.75rem;
    padding-right: 0.75rem;
    color: #495057;
}
.select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow {
    height: calc(2.25rem + 2px);
    right: 3px;
}
.select2-container--bootstrap4.select2-container--focus .select2-selection {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}
.select2-dropdown {
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    font-size: 0.875rem;
}
.select2-container--bootstrap4 .select2-results__option--highlighted {
    background-color: #007bff;
    color: white;
}
.select2-container--bootstrap4 .select2-results__option {
    padding: 6px 12px;
}
.select2-container--bootstrap4 .select2-search--dropdown .select2-search__field {
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    padding: 4px 8px;
}
.form-group label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.5rem;
}
/* Fix z-index issues */
.select2-container--open {
    z-index: 9999;
}
.select2-dropdown {
    z-index: 9999;
}
</style>
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

@push('scripts')
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
<script>
$(document).ready(function() {
    console.log('🎯 Starting Select2 initialization...');
    console.log('jQuery version:', $.fn.jquery);
    
    // Check if Select2 is loaded
    if (typeof $.fn.select2 === 'undefined') {
        console.error('❌ Select2 not loaded!');
        alert('Select2 library gagal dimuat. Silakan refresh halaman.');
        return;
    }
    
    console.log('✅ Select2 library loaded successfully');
    
    // Wait a bit for DOM to be fully ready
    setTimeout(function() {
        try {
            // Global Select2 configuration
            const select2Config = {
                theme: 'bootstrap4',
                width: '100%',
                allowClear: true,
                escapeMarkup: function (markup) {
                    return markup;
                },
                language: {
                    noResults: function() {
                        return "Tidak ada hasil ditemukan";
                    },
                    searching: function() {
                        return "Mencari...";
                    },
                    inputTooShort: function() {
                        return "Ketik untuk mencari...";
                    }
                }
            };

            // Initialize each select individually
            $('#jenis_filter').select2($.extend({}, select2Config, {
                placeholder: '-- Pilih Jenis --',
                minimumResultsForSearch: 0
            }));
            console.log('✅ Jenis filter initialized');

            $('#gsm_filter').select2($.extend({}, select2Config, {
                placeholder: '-- Pilih GSM --',
                minimumResultsForSearch: 5
            }));
            console.log('✅ GSM filter initialized');

            $('#lebar_filter').select2($.extend({}, select2Config, {
                placeholder: '-- Pilih Lebar --',
                minimumResultsForSearch: 5
            }));
            console.log('✅ Lebar filter initialized');

            $('#supplier_filter').select2($.extend({}, select2Config, {
                placeholder: '-- Pilih Supplier --',
                minimumResultsForSearch: 0
            }));
            console.log('✅ Supplier filter initialized');

            console.log('🎉 All Select2 filters initialized successfully!');

            // Handle changes
            $('.select2').on('change', function() {
                const id = $(this).attr('id');
                const value = $(this).val();
                console.log('🔄 Filter changed:', id, '=', value);
            });

            // Clear all filters button
            $('#clearFilters').on('click', function(e) {
                e.preventDefault();
                console.log('🧹 Clearing all filters...');
                $('.select2').val(null).trigger('change');
            });

        } catch (error) {
            console.error('❌ Error initializing Select2:', error);
            alert('Terjadi error saat inisialisasi Select2: ' + error.message);
        }
    }, 500);
});

function exportToExcel() {
    try {
        // Get table
        const table = document.getElementById('summaryTable');
        
        // Create workbook
        const wb = XLSX.utils.table_to_book(table, {sheet: "Inventory Summary"});
        
        // Generate filename with current date
        const date = new Date().toISOString().slice(0, 10);
        const filename = `inventory_summary_${date}.xlsx`;
        
        // Save file
        XLSX.writeFile(wb, filename);
        
        console.log('✅ Excel exported:', filename);
    } catch (error) {
        console.error('❌ Export error:', error);
        alert('Gagal export Excel: ' + error.message);
    }
}

// Auto refresh every 5 minutes (disabled for debugging)
// setInterval(function() {
//     if (confirm('Refresh data untuk update terbaru?')) {
//         location.reload();
//     }
// }, 300000);
</script>
@endpush

@endsection
