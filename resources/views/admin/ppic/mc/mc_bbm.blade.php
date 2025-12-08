@extends('admin.templates.partials.default')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Relasi Mastercard & PHP Data</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">MC-PHP Relasi</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            
            @if(isset($firebird_error))
            <!-- Firebird Error Alert -->
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Peringatan!</h5>
                        {{ $firebird_error }}
                        <br><small class="text-muted">Menampilkan data Mastercard tanpa integrasi PHP database.</small>
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Summary Statistics -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ number_format($summary['total_mc']) }}</h3>
                            <p>Total Mastercard</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <a href="{{ route('ppic.karet') }}" class="small-box-footer">
                            Lihat Semua <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ number_format($summary['mc_with_php']) }}</h3>
                            <p>MC dengan Data PHP</p>
                            <span class="small text-light">
                                {{ $summary['mc_with_php'] > 0 ? number_format(($summary['mc_with_php'] / $summary['total_mc']) * 100, 1) : 0 }}% dari total
                            </span>
                        </div>
                        <div class="icon">
                            <i class="fas fa-link"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ number_format($summary['total_php_records']) }}</h3>
                            <p>Total Kode PHP</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-database"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ number_format($summary['total_php_quantity']) }}</h3>
                            <p>Total Quantity PHP</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-boxes"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mastercard dengan Data PHP -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-table mr-1"></i>
                        Mastercard dengan Data PHP
                    </h3>
                    <div class="card-tools">
                        <div class="d-flex align-items-center">
                            <!-- Quick Filter Buttons -->
                            <div class="btn-group btn-group-sm mr-2">
                                <a href="{{ route('ppic.karet') }}" 
                                   class="btn {{ !request('filter') ? 'btn-primary' : 'btn-outline-primary' }}">
                                    Semua
                                </a>
                                <a href="{{ route('ppic.karet', ['filter' => 'with_php']) }}" 
                                   class="btn {{ request('filter') == 'with_php' ? 'btn-success' : 'btn-outline-success' }}">
                                    <i class="fas fa-link mr-1"></i>Ada PHP
                                </a>
                                <a href="{{ route('ppic.karet', ['filter' => 'without_php']) }}" 
                                   class="btn {{ request('filter') == 'without_php' ? 'btn-secondary' : 'btn-outline-secondary' }}">
                                    <i class="fas fa-unlink mr-1"></i>Tanpa PHP
                                </a>
                            </div>
                            
                            <!-- Search Form -->
                            <form method="GET" class="form-inline">
                                @if(request('filter'))
                                <input type="hidden" name="filter" value="{{ request('filter') }}">
                                @endif
                                <div class="input-group input-group-sm" style="width: 250px;">
                                    <input type="text" 
                                           name="search" 
                                           class="form-control" 
                                           placeholder="Cari kode MC, nama barang..." 
                                           value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        @if(request('search'))
                                        <a href="{{ route('ppic.karet', request('filter') ? ['filter' => request('filter')] : []) }}" 
                                           class="btn btn-default" title="Clear Search">
                                            <i class="fas fa-times"></i>
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(request('search') || request('filter'))
                    <div class="alert alert-info alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fas fa-info"></i>
                        @if(request('search'))
                            Hasil pencarian untuk: <strong>"{{ request('search') }}"</strong>
                        @endif
                        @if(request('filter'))
                            @if(request('search')) | @endif
                            Filter: <strong>
                                @if(request('filter') == 'with_php')
                                    Hanya dengan Data PHP
                                @elseif(request('filter') == 'without_php')  
                                    Tanpa Data PHP
                                @endif
                            </strong>
                        @endif
                    </div>
                    @endif
                    
                    <div class="table-responsive" id="mc-table-container" style="min-height: 400px;">
                        <div id="table-loading" class="text-center py-5" style="display: none;">
                            <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                            <p class="mt-2">Memuat data...</p>
                        </div>
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="width: 15%;">Kode MC</th>
                                    <th style="width: 15%;">Kode Barang</th>
                                    <th style="width: 25%;">Nama Barang</th>
                                    <th style="width: 15%;">Customer</th>
                                    <th style="width: 10%;">Status PHP</th>
                                    <th style="width: 10%;">Total Quantity</th>
                                    <th style="width: 10%;">Total Records</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mcWithPhp as $mc)
                                <tr class="{{ ($mc->php_data['has_data'] ?? false) ? 'table-success' : 'table-light' }}">
                                    <td><strong>{{ ($mc->revisi === 'R0' || $mc->revisi === null) ? $mc->kode : $mc->kode.'-'.$mc->revisi }}</strong></td>
                                    <td>{{ $mc->kodeBarang }}</td>
                                    <td>{{ Str::limit($mc->namaBarang, 40) }}</td>
                                    <td>{{ Str::limit($mc->customer, 25) }}</td>
                                    <td>
                                        @if(($mc->php_data['has_data'] ?? false))
                                            <span class="badge badge-success badge-sm" 
                                                  title="Ditemukan {{ $mc->php_data['total_records'] ?? 0 }} record">
                                                <i class="fas fa-check"></i> Ada
                                            </span>
                                        @else
                                            <span class="badge badge-secondary badge-sm" 
                                                  title="Tidak ada data PHP">
                                                <i class="fas fa-times"></i> Tidak Ada
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <strong>{{ number_format($mc->php_data['total_quantity'] ?? 0) }}</strong>
                                    </td>
                                    <td class="text-right">{{ $mc->php_data['total_records'] ?? 0 }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-3"></i><br>
                                        Tidak ada data yang ditemukan
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination Links -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="pagination-info">
                            <small class="text-muted">
                                @if($mcWithPhp->total() > 0)
                                    <div class="d-flex flex-column">
                                        <div class="mb-1">
                                            <i class="fas fa-list mr-1 text-primary"></i>
                                            Menampilkan {{ number_format($mcWithPhp->firstItem()) }} sampai {{ number_format($mcWithPhp->lastItem()) }} 
                                            dari {{ number_format($mcWithPhp->total()) }} data
                                            @if(request('search'))
                                                <span class="badge badge-info badge-sm ml-1">pencarian</span>
                                            @endif
                                        </div>
                                        <div class="mb-1">
                                            <i class="fas fa-bookmark mr-1 text-success"></i>
                                            Halaman <strong class="text-primary">{{ $mcWithPhp->currentPage() }}</strong> 
                                            dari <strong>{{ $mcWithPhp->lastPage() }}</strong> halaman
                                        </div>
                                        <div>
                                            <i class="fas fa-link mr-1 text-success"></i>
                                            {{ $mcWithPhp->where('php_data.has_data', true)->count() }} data memiliki relasi PHP
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <i class="fas fa-search mr-1"></i>
                                        Tidak ada data yang ditemukan
                                    </div>
                                @endif
                            </small>
                        </div>
                        <div class="pagination-links d-flex align-items-center flex-wrap">
                            {{ $mcWithPhp->links('custom.pagination') }}
                            
                            @if($mcWithPhp->lastPage() > 1)
                            <div class="pagination-quick-jump ml-3">
                                <span class="text-muted">Langsung ke:</span>
                                <form method="GET" class="d-inline-flex align-items-center" id="quickJumpForm">
                                    @if(request('search'))
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                    @endif
                                    @if(request('filter'))
                                        <input type="hidden" name="filter" value="{{ request('filter') }}">
                                    @endif
                                    <input type="number" 
                                           name="page" 
                                           min="1" 
                                           max="{{ $mcWithPhp->lastPage() }}" 
                                           placeholder="{{ $mcWithPhp->currentPage() }}"
                                           class="form-control form-control-sm"
                                           style="width: 60px;"
                                           title="Masukkan nomor halaman (1-{{ $mcWithPhp->lastPage() }})">
                                    <button type="submit" class="btn btn-sm btn-outline-primary ml-1" title="Pergi ke halaman">
                                        <i class="fas fa-arrow-right"></i>
                                    </button>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // PERFORMANCE: Show loading state on page transitions
    function showTableLoading() {
        $('#table-loading').show();
        $('.table').hide();
    }
    
    function hideTableLoading() {
        $('#table-loading').hide();
        $('.table').show();
    }
    
    // Initial page load animation
    $('.table').css('opacity', '0').animate({'opacity': '1'}, 300);
    
    // PERFORMANCE: Defer heavy operations
    setTimeout(function() {
        // Styling untuk pagination Laravel
        $('.pagination').addClass('pagination-sm justify-content-center');
    
    // Optimized pagination loading
    $(document).on('click', '.pagination a', function(e) {
        showTableLoading();
        var $clickedLink = $(this);
        $clickedLink.html('<i class="fas fa-spinner fa-spin"></i>');
        
        // Reduced scroll animation time for better performance
        $('html, body').animate({
            scrollTop: $('.card').first().offset().top - 80
        }, 300);
    });
    
    // Highlight active page with pulse effect
    $('.pagination .page-item.active .page-link').addClass('pulse-active');
    
    // Add hover effects to pagination
    $('.pagination .page-link').on('mouseenter', function() {
        if (!$(this).closest('.page-item').hasClass('active') && !$(this).closest('.page-item').hasClass('disabled')) {
            $(this).css('transform', 'translateY(-2px) scale(1.05)');
        }
    }).on('mouseleave', function() {
        if (!$(this).closest('.page-item').hasClass('active')) {
            $(this).css('transform', '');
        }
    });
    
    // PERFORMANCE: Use event delegation untuk large tables
    $('.table tbody').on('mouseenter', 'tr.table-success', function() {
        $(this).addClass('bg-success-hover');
    }).on('mouseleave', 'tr.table-success', function() {
        $(this).removeClass('bg-success-hover');
    });
    
    // Auto submit search form on Enter
    $('input[name="search"]').on('keypress', function(e) {
        if (e.which === 13) {
            $(this).closest('form').submit();
        }
    });
    
    // Optimized loading states
    $('.btn-group a').on('click', function() {
        if (!$(this).hasClass('btn-primary') && !$(this).hasClass('btn-success') && !$(this).hasClass('btn-secondary')) {
            showTableLoading();
            $(this).prepend('<i class="fas fa-spinner fa-spin mr-1"></i>');
        }
    });
    
    // Form submit loading
    $('form').on('submit', function() {
        showTableLoading();
        $(this).find('button[type="submit"]').html('<i class="fas fa-spinner fa-spin"></i>');
    });
    
    // Tooltip for badges
    $('.badge').tooltip();
    
    // Initialize tooltips for pagination
    $('.pagination .page-link').tooltip();
    
    // Add page indicator on load
    if ($('.pagination .page-item.active').length > 0) {
        var currentPage = $('.pagination .page-item.active .page-link strong').text();
        var totalPages = $('.pagination .page-item:not(.disabled)').last().prev().find('a').text() || currentPage;
        
        // Add subtle animation to show current page loaded
        $('.pagination .page-item.active').addClass('page-loaded');
        setTimeout(function() {
            $('.pagination .page-item.active').removeClass('page-loaded');
        }, 1000);
    }
    
    // Quick jump form validation
    $('#quickJumpForm').on('submit', function(e) {
        var pageInput = $(this).find('input[name="page"]');
        var page = parseInt(pageInput.val());
        var maxPage = parseInt(pageInput.attr('max'));
        
        if (!page || page < 1 || page > maxPage) {
            e.preventDefault();
            pageInput.focus();
            alert('Masukkan nomor halaman yang valid (1-' + maxPage + ')');
            return false;
        }
        
        // Show loading state
        $(this).find('button').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
    });
    
    // Quick jump input enhancement
    $('.pagination-quick-jump input[type="number"]').on('keypress', function(e) {
        if (e.which === 13) { // Enter key
            $(this).closest('form').submit();
        }
    }).on('input', function() {
        var page = parseInt($(this).val());
        var maxPage = parseInt($(this).attr('max'));
        
        if (page && (page < 1 || page > maxPage)) {
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });
    
    }, 100); // Defer untuk performa
});
</script>

<style>
.pagination-info {
    font-size: 0.875rem;
    color: #6c757d;
}

.pagination-links .pagination {
    margin-bottom: 0;
}

.pagination .page-link {
    border-radius: 0.5rem;
    margin: 0 3px;
    border: 1px solid #dee2e6;
    padding: 8px 12px;
    transition: transform 0.2s ease, box-shadow 0.2s ease; /* Reduced transitions */
    font-weight: 500;
    will-change: transform; /* Optimize for animations */
}

.pagination .page-link:hover {
    background-color: #e9ecef;
    border-color: #adb5bd;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    border-color: #007bff;
    color: white;
    font-weight: 600;
    box-shadow: 0 3px 8px rgba(0, 123, 255, 0.3);
    transform: translateY(-2px);
}

.pagination .page-item.active .page-link.page-active-highlight {
    position: relative;
    overflow: hidden;
}

.pagination .page-item.active .page-link.page-active-highlight::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    0% { left: -100%; }
    50% { left: 100%; }
    100% { left: 100%; }
}

@keyframes pulseActive {
    0% { box-shadow: 0 3px 8px rgba(0, 123, 255, 0.3); }
    50% { box-shadow: 0 3px 12px rgba(0, 123, 255, 0.5), 0 0 0 3px rgba(0, 123, 255, 0.1); }
    100% { box-shadow: 0 3px 8px rgba(0, 123, 255, 0.3); }
}

.pulse-active {
    animation: pulseActive 2s ease-in-out infinite;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.pagination {
    animation: fadeIn 0.5s ease-out;
}

@keyframes pageLoaded {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); background-color: #28a745; }
    100% { transform: scale(1); }
}

.page-loaded {
    animation: pageLoaded 0.6s ease-in-out;
}

/* Quick jump to page feature */
.pagination-quick-jump {
    display: inline-flex;
    align-items: center;
    margin-left: 15px;
    font-size: 0.875rem;
}

.pagination-quick-jump input {
    width: 50px;
    padding: 4px 8px;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    text-align: center;
    margin: 0 5px;
}

.pagination .page-item.disabled .page-link {
    background-color: #f8f9fa;
    border-color: #dee2e6;
    color: #6c757d;
}

.pagination .page-item:first-child .page-link,
.pagination .page-item:last-child .page-link {
    background-color: #f8f9fa;
    color: #007bff;
    font-size: 0.9rem;
}

.pagination .page-item:first-child .page-link:hover,
.pagination .page-item:last-child .page-link:hover {
    background-color: #007bff;
    color: white;
}

.bg-success-hover {
    background-color: #d4edda !important;
}

.table tbody tr {
    transition: background-color 0.1s ease-in-out; /* Faster transition */
}

/* Performance optimizations */
.table {
    table-layout: fixed; /* Improve rendering performance */
}

.table td {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

/* Optimize animations */
@media (prefers-reduced-motion: reduce) {
    *, *::before, *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
}

/* Additional pagination enhancements */
.pagination-links {
    position: relative;
}

.pagination-links::before {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 50%;
    transform: translateX(-50%);
    width: 60%;
    height: 1px;
    background: linear-gradient(to right, transparent, #dee2e6, transparent);
}

/* Quick Jump Styling */
.pagination-quick-jump {
    border-left: 1px solid #dee2e6;
    padding-left: 15px;
    margin-left: 15px !important;
}

.pagination-quick-jump input[type="number"] {
    text-align: center;
    border-radius: 4px;
    border: 1px solid #ddd;
    transition: all 0.2s ease;
}

.pagination-quick-jump input[type="number"]:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 2px rgba(0,123,255,0.25);
    outline: none;
}

.pagination-quick-jump .btn {
    height: 31px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.pagination-quick-jump input[type="number"].is-invalid {
    border-color: #dc3545;
    box-shadow: 0 0 0 2px rgba(220,53,69,0.25);
}

/* Mobile responsive pagination */
@media (max-width: 576px) {
    .pagination .page-link {
        padding: 6px 10px;
        font-size: 0.875rem;
        margin: 0 1px;
    }
    
    .pagination-links::before {
        display: none;
    }
    
    .pagination-quick-jump {
        border-left: none;
        padding-left: 0;
        margin-left: 0 !important;
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid #dee2e6;
        width: 100%;
        justify-content: center;
    }
}
</style>
@endsection
