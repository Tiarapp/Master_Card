<!-- jQuery -->
<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>

@extends('admin.templates.partials.default')

<style>
/* Responsive improvements */
@media (max-width: 768px) {
    .card-body {
        padding: 0.5rem;
    }
    
    .table-responsive {
        font-size: 0.8rem;
    }
    
    .btn-sm {
        padding: 0.2rem 0.4rem;
        font-size: 0.75rem;
    }
    
    .badge {
        font-size: 0.7rem;
    }
}

@media (max-width: 576px) {
    .info-box {
        margin-bottom: 1rem;
    }
    
    .dataTables_info {
        text-align: center;
        margin-bottom: 1rem;
    }
    
    .dataTables_paginate {
        text-align: center !important;
    }
}

/* Table improvements */
.table td {
    vertical-align: middle;
    word-wrap: break-word;
}

.text-wrap {
    word-break: break-word;
    white-space: normal;
}

code {
    font-size: 0.9em;
}

/* Badge responsive */
.badge {
    display: inline-block;
    min-width: 1.5rem;
}
</style>

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                        <li class="breadcrumb-item active">Data Barang</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif

            <!-- Search Form -->
            <div class="row mb-3">
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <form method="GET" action="{{ route('barang.indexnew') }}" class="form-inline" id="searchForm">
                                <div class="input-group" style="width: 100%;">
                                    <input type="text" name="search" class="form-control search-input" 
                                           placeholder="Cari kode/nama barang..." value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary btn-search">
                                            <i class="fas fa-search"></i> Cari
                                        </button>
                                        @if(request('search'))
                                            <a href="{{ route('barang.indexnew') }}" class="btn btn-secondary btn-clear">
                                                <i class="fas fa-times"></i> Reset
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-boxes"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Data</span>
                            <span class="info-box-number">{{ $barang->total() }} Barang</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list"></i> Daftar Barang Jadi - Periode {{ date("m/Y") }}
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('barang.create') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> 
                            <span class="d-none d-sm-inline">Tambah Barang Baru</span>
                            <span class="d-sm-none">Tambah</span>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($barang->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Kode Barang</th>
                                        <th class="d-none d-sm-table-cell">Nama Barang</th>
                                        <th class="text-center">Saldo (Pcs)</th>
                                        <th class="text-center d-none d-md-table-cell">Saldo (Kg)</th>
                                        <th class="text-center d-none d-lg-table-cell">Berat Standart</th>
                                        <th class="text-center d-none d-xl-table-cell">Isi Karton</th>
                                        <th class="text-center action-column">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($barang as $index => $item)
                                        <tr>
                                            <td>{{ $barang->firstItem() + $index }}</td>
                                            <td>
                                                <code class="text-primary">{{ $item->KodeBrg }}</code>
                                                <!-- Show nama barang on mobile -->
                                                <div class="d-sm-none">
                                                    <small class="text-muted">{{ Str::limit($item->NamaBrg ?? '-', 30) }}</small>
                                                </div>
                                            </td>
                                            <td class="d-none d-sm-table-cell">
                                                <div class="text-wrap">{{ $item->NamaBrg ?? '-' }}</div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-success">
                                                    {{ number_format($item->SaldoPcs, 0) }}
                                                </span>
                                                <!-- Show saldo kg on mobile -->
                                                <div class="d-md-none">
                                                    <small class="badge badge-warning mt-1">
                                                        {{ number_format($item->SaldoKg, 2) }} Kg
                                                    </small>
                                                </div>
                                            </td>
                                            <td class="text-center d-none d-md-table-cell">
                                                <span class="badge badge-warning">
                                                    {{ number_format($item->SaldoKg, 2) }}
                                                </span>
                                            </td>
                                            <td class="text-center d-none d-lg-table-cell">
                                                {{ number_format($item->BeratStandart, 2) }}
                                            </td>
                                            <td class="text-center d-none d-xl-table-cell">
                                                {{ number_format($item->IsiPerKarton, 0) }}
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-primary btn-sm mutasi" 
                                                            data-toggle="modal" 
                                                            data-target="#mutasiModal" 
                                                            data-kode="{{ $item->KodeBrg }}"
                                                            title="Cek Mutasi">
                                                        <i class="fas fa-chart-line"></i>
                                                        <span class="d-none d-lg-inline ml-1">Mutasi</span>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="row mt-3">
                            <div class="col-sm-12 col-md-5">
                                <div class="dataTables_info">
                                    Menampilkan {{ $barang->firstItem() }} sampai {{ $barang->lastItem() }} 
                                    dari {{ $barang->total() }} data
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate float-right">
                                    {{ $barang->appends(request()->query())->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="callout callout-info">
                            <h5><i class="icon fas fa-info"></i> Informasi</h5>
                            @if(request('search'))
                                Tidak ada data barang yang ditemukan dengan kata kunci "<strong>{{ request('search') }}</strong>"
                            @else
                                Tidak ada data barang yang tersedia untuk periode {{ date("m/Y") }}
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<!-- Modal untuk Mutasi -->
<div class="modal fade" id="mutasiModal" tabindex="-1" role="dialog" aria-labelledby="mutasiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="mutasiModalLabel">
                    <i class="fas fa-chart-line"></i> Cek Mutasi Barang
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('barang.mutasi') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="periode"><i class="fas fa-calendar"></i> Periode</label>
                        <input type="text" name="periode" id="periode" class="form-control" 
                               placeholder="mm/yyyy" value="{{ date('m/Y') }}" required>
                        <small class="form-text text-muted">Format: mm/yyyy (contoh: 08/2025)</small>
                    </div>
                    <input type="hidden" name="kodebarang" id="kodebarang">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="fas fa-times"></i> Tutup
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Lihat Mutasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
/* Mobile responsive adjustments */
@media (max-width: 576px) {
    .content-header h1 {
        font-size: 1.5rem;
    }
    
    .card-header .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
    
    .table th, .table td {
        padding: 0.5rem 0.25rem;
        font-size: 0.875rem;
    }
    
    .badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
    
    .info-box-text {
        font-size: 0.875rem;
    }
    
    .info-box-number {
        font-size: 1.25rem;
    }
}

/* Search form adjustments */
.search-form .input-group {
    min-width: 250px;
}

@media (max-width: 768px) {
    .search-form .input-group {
        min-width: 100%;
        margin-bottom: 1rem;
    }
    
    .pagination-info {
        margin-bottom: 1rem;
    }
}

/* Table styling improvements */
.table-responsive {
    border: none;
}

.table th {
    background-color: #f8f9fa;
    border-top: none;
    font-weight: 600;
    color: #495057;
}

.table td {
    vertical-align: middle;
}

.text-wrap {
    max-width: 200px;
    word-wrap: break-word;
}

/* Button hover effects */
.btn-sm:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    transition: all 0.2s ease-in-out;
}

/* Create button styling */
.btn-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border: none;
    box-shadow: 0 2px 4px rgba(40, 167, 69, 0.3);
    transition: all 0.3s ease;
}

.btn-success:hover {
    background: linear-gradient(135deg, #218838 0%, #17a085 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(40, 167, 69, 0.4);
}

.btn-success:active {
    transform: translateY(0);
    box-shadow: 0 2px 4px rgba(40, 167, 69, 0.3);
}

/* Mobile responsive for create button */
@media (max-width: 768px) {
    .btn-lg {
        font-size: 1rem;
        padding: 0.5rem 1rem;
    }
    
    .d-grid {
        margin-top: 1rem;
    }
    
    .btn-group {
        flex-direction: column;
        width: 100%;
    }
    
    .btn-group .btn {
        margin-bottom: 0.25rem;
        border-radius: 0.25rem !important;
    }
}

/* Button group styling */
.btn-group .btn {
    border-radius: 0;
    border-right: 1px solid rgba(255, 255, 255, 0.2);
}

.btn-group .btn:first-child {
    border-top-left-radius: 0.25rem;
    border-bottom-left-radius: 0.25rem;
}

.btn-group .btn:last-child {
    border-top-right-radius: 0.25rem;
    border-bottom-right-radius: 0.25rem;
    border-right: none;
}

/* Action column width */
@media (min-width: 992px) {
    .action-column {
        width: 120px;
    }
}

/* Modal responsive */
@media (max-width: 576px) {
    .modal-dialog {
        margin: 0.5rem;
        max-width: calc(100% - 1rem);
    }
}

/* Scroll indicator for mobile */
.table-scroll-indicator {
    display: none;
}

@media (max-width: 768px) {
    .table-scroll-indicator {
        display: block;
        text-align: center;
        margin-top: 0.5rem;
        color: #6c757d;
    }
}
</style>
@endsection

@section('javascripts')
<script>
$(document).ready(function() {
    // Handle search form submission
    $('#searchForm').on('submit', function(e) {
        e.preventDefault();
        var search = $('.search-input').val().toUpperCase();
        if (search.trim() !== '') {
            window.location.href = '{{ route("barang.indexnew") }}?search=' + encodeURIComponent(search);
        }
    });
    
    // Handle clear search
    $('.btn-clear').on('click', function() {
        window.location.href = '{{ route("barang.indexnew") }}';
    });
    
    // Auto uppercase search input
    $('.search-input').on('input', function() {
        this.value = this.value.toUpperCase();
    });
    
    // Enter key search
    $('.search-input').on('keypress', function(e) {
        if (e.which === 13) {
            $('#searchForm').submit();
        }
    });

    // Handle mutasi button click
    $(document).on('click', '.mutasi', function() {
        var kodeBarang = $(this).data('kode');
        $('#kodebarang').val(kodeBarang);
        $('#mutasiModalLabel').html('<i class="fas fa-chart-line"></i> Cek Mutasi Barang: ' + kodeBarang);
    });

    // Auto format periode input
    $('#periode').on('input', function() {
        var value = $(this).val().replace(/[^\d]/g, '');
        if (value.length >= 2) {
            value = value.substring(0, 2) + '/' + value.substring(2, 6);
        }
        $(this).val(value);
    });

    // Mobile responsive features
    function initMobileFeatures() {
        // Add scroll indicator for mobile
        if (window.innerWidth < 768) {
            if (!$('.table-scroll-indicator').length) {
                $('.table-responsive').after('<div class="table-scroll-indicator"><small class="text-muted"><i class="fas fa-arrows-alt-h"></i> Scroll horizontal untuk melihat lebih banyak kolom</small></div>');
            }
            
            // Update pagination info alignment
            $('.pagination-info').addClass('text-center');
        } else {
            $('.table-scroll-indicator').remove();
            $('.pagination-info').removeClass('text-center');
        }
    }
    
    // Initialize on load
    initMobileFeatures();
    
    // Update on window resize
    $(window).resize(function() {
        initMobileFeatures();
    });
    
    // Loading state for search
    $('#searchForm').on('submit', function() {
        $('.btn-search').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Mencari...');
    });
    
    // Loading state for create button
    $('.btn-success').on('click', function(e) {
        var $btn = $(this);
        var originalText = $btn.html();
        
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Loading...');
        
        // If navigation fails, restore button after 3 seconds
        setTimeout(function() {
            $btn.prop('disabled', false).html(originalText);
        }, 3000);
    });
    
    // Show tooltip for truncated text on mobile
    @if(request()->has('search'))
        @php $searchTerm = strtoupper(request('search')); @endphp
        // Highlight search results
        $('.table tbody tr').each(function() {
            var $row = $(this);
            var kodeBarang = $row.find('code').text().toUpperCase();
            var namaBarang = $row.find('.text-wrap').text().toUpperCase();
            
            if (kodeBarang.includes('{{ $searchTerm }}') || namaBarang.includes('{{ $searchTerm }}')) {
                $row.addClass('table-active');
            }
        });
    @endif
});
</script>
@endsection
