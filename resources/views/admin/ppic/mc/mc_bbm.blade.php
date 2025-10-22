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
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Kode MC</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Customer</th>
                                    <th>Status PHP</th>
                                    <th>Total Quantity</th>
                                    <th>Total Records</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mcWithPhp as $mc)
                                <tr class="{{ $mc->php_data['has_data'] ? 'table-success' : 'table-light' }}">
                                    <td><strong>{{ $mc->kode }}</strong></td>
                                    <td>{{ $mc->kodeBarang }}</td>
                                    <td>{{ $mc->namaBarang }}</td>
                                    <td>{{ $mc->customer }}</td>
                                    <td>
                                        @if($mc->php_data['has_data'])
                                            <span class="badge badge-success" 
                                                  title="Ditemukan {{ $mc->php_data['total_records'] }} record di database PHP"
                                                  data-toggle="tooltip">
                                                <i class="fas fa-check mr-1"></i>Ada Data
                                            </span>
                                        @else
                                            <span class="badge badge-secondary" 
                                                  title="Tidak ditemukan data matching di database PHP"
                                                  data-toggle="tooltip">
                                                <i class="fas fa-times mr-1"></i>Tidak Ada
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <strong>{{ number_format($mc->php_data['total_quantity']) }}</strong>
                                    </td>
                                    <td class="text-right">{{ $mc->php_data['total_records'] }}</td>
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
                                    Menampilkan {{ number_format($mcWithPhp->firstItem()) }} sampai {{ number_format($mcWithPhp->lastItem()) }} 
                                    dari {{ number_format($mcWithPhp->total()) }} data
                                    @if(request('search'))
                                        (hasil pencarian)
                                    @endif
                                    <br>
                                    <i class="fas fa-info-circle mr-1"></i>
                                    {{ $mcWithPhp->where('php_data.has_data', true)->count() }} data memiliki relasi PHP
                                @else
                                    Tidak ada data yang ditemukan
                                @endif
                            </small>
                        </div>
                        <div class="pagination-links">
                            {{ $mcWithPhp->links() }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- <!-- PHP Data dengan Info MC -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-database mr-1"></i>
                        Data PHP dengan Informasi Mastercard
                    </h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Kode Barang</th>
                                    <th>Total Quantity PHP</th>
                                    <th>Status MC</th>
                                    <th>Kode MC</th>
                                    <th>Nama Barang</th>
                                    <th>Customer</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($phpWithMcInfo as $php)
                                <tr class="{{ $php['has_mc'] ? 'table-info' : 'table-warning' }}">
                                    <td><strong>{{ $php['kode_brg'] }}</strong></td>
                                    <td class="text-right">
                                        <strong>{{ number_format($php['total_quantity']) }}</strong>
                                    </td>
                                    <td>
                                        @if($php['has_mc'])
                                            <span class="badge badge-info">
                                                <i class="fas fa-link mr-1"></i>Ada MC
                                            </span>
                                        @else
                                            <span class="badge badge-warning">
                                                <i class="fas fa-unlink mr-1"></i>Tanpa MC
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $php['mc_info']['kode'] ?? '-' }}</td>
                                    <td>{{ $php['mc_info']['nama_barang'] ?? '-' }}</td>
                                    <td>{{ $php['mc_info']['customer'] ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Debug Info (Optional - bisa dihapus di production) -->
            @if(config('app.debug'))
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-bug mr-1"></i>
                        Debug Information
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Sample PHP Raw Data:</h5>
                            <pre>{{ json_encode($phpData->take(3), JSON_PRETTY_PRINT) }}</pre>
                        </div>
                        <div class="col-md-6">
                            <h5>Sample MC Data:</h5>
                            <pre>{{ json_encode($mastercards->take(2)->toArray(), JSON_PRETTY_PRINT) }}</pre>
                        </div>
                    </div>
                </div>
            </div>
            @endif --}}

        </div>
    </section>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Styling untuk pagination Laravel
    $('.pagination').addClass('pagination-sm justify-content-center');
    
    // Smooth scrolling untuk pagination
    $(document).on('click', '.pagination a', function(e) {
        $('html, body').animate({
            scrollTop: $('.card').first().offset().top - 100
        }, 500);
    });
    
    // Highlight baris dengan data PHP
    $('.table tbody tr.table-success').hover(
        function() {
            $(this).addClass('bg-success-hover');
        },
        function() {
            $(this).removeClass('bg-success-hover');
        }
    );
    
    // Auto submit search form on Enter
    $('input[name="search"]').on('keypress', function(e) {
        if (e.which === 13) {
            $(this).closest('form').submit();
        }
    });
    
    // Loading state for filter buttons
    $('.btn-group a').on('click', function() {
        if (!$(this).hasClass('btn-primary') && !$(this).hasClass('btn-success') && !$(this).hasClass('btn-secondary')) {
            $(this).html('<i class="fas fa-spinner fa-spin"></i> Loading...');
        }
    });
    
    // Show loading indicator on form submit
    $('form').on('submit', function() {
        $(this).find('button[type="submit"]').html('<i class="fas fa-spinner fa-spin"></i>');
    });
    
    // Tooltip for badges
    $('.badge').tooltip();
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
    border-radius: 0.375rem;
    margin: 0 2px;
    border: 1px solid #dee2e6;
}

.pagination .page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
}

.bg-success-hover {
    background-color: #d4edda !important;
}

.table tbody tr {
    transition: background-color 0.15s ease-in-out;
}
</style>
@endsection
