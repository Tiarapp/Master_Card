<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Master Card') }} - Laporan Deadstock</title>
  
  <link rel="icon" href="{{ asset('images/logo spa 1.png') }}" type="image/icon type">
  
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('asset/plugins/fontawesome-free/css/all.min.css') }}">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('asset/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('asset/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('asset/plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('asset/dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('asset/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('asset/plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('asset/plugins/summernote/summernote-bs4.min.css') }}">
  
  <!-- Select2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" />
  <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">
  
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
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  @include('admin.templates.partials._navbar')
  @include('admin.templates.partials._sidebar')

  <div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-warehouse mr-2"></i>
                        Laporan Deadstock
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Reports</a></li>
                        <li class="breadcrumb-item active">Deadstock</li>
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
                    <form method="GET" action="{{ route('admin.report.deadstock') }}" class="form-inline">
                        <div class="form-group mr-3">
                            <label for="periode" class="mr-2">Periode:</label>
                            <input type="text" 
                                   name="periode" 
                                   id="periode" 
                                   class="form-control" 
                                   placeholder="MM/YYYY" 
                                   value="{{ $periode }}"
                                   style="width: 150px;">
                        </div>
                        <div class="form-group mr-3">
                            <label for="age_filter" class="mr-2">Umur Deadstock:</label>
                            <select name="age_filter" id="age_filter" class="form-control" style="width: 150px;">
                                <option value="">Semua Kategori</option>
                                <option value="1-3" {{ request('age_filter') == '1-3' ? 'selected' : '' }}>1-3 bulan</option>
                                <option value="4-6" {{ request('age_filter') == '4-6' ? 'selected' : '' }}>4-6 bulan</option>
                                <option value="6-12" {{ request('age_filter') == '6-12' ? 'selected' : '' }}>6-1 tahun</option>
                                <option value="12+" {{ request('age_filter') == '12+' ? 'selected' : '' }}>1 tahun ++</option>
                                <option value="no-data" {{ request('age_filter') == 'no-data' ? 'selected' : '' }}>Tidak ada data</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">
                            <i class="fas fa-search mr-1"></i>Filter
                        </button>
                        <a href="{{ route('admin.report.deadstock') }}" class="btn btn-secondary mr-2">
                            <i class="fas fa-refresh mr-1"></i>Reset
                        </a>
                        {{-- <a href="{{ route('admin.report.deadstock.export', ['periode' => $periode]) }}" class="btn btn-success">
                            <i class="fas fa-file-excel mr-1"></i>Export Excel
                        </a> --}}
                    </form>
                </div>
            </div>

            <!-- Summary Statistics -->
            {{-- <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ number_format($totalItems) }}</h3>
                            <p>Total Items</p>
                            <small class="text-light">
                                {{ isset($stockWithSJ) ? $stockWithSJ->count() : 0 }} dengan SJ | {{ isset($stockWithoutSJ) ? $stockWithoutSJ->count() : 0 }} tanpa SJ
                            </small>
                        </div>
                        <div class="icon">
                            <i class="fas fa-boxes"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ number_format($totalCrt, 0) }}</h3>
                            <p>Total Crt</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-box"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ number_format($totalKg, 2) }}</h3>
                            <p>Total Kg</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-weight"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ number_format($avgDeadstockDays ?? 0, 0) }}</h3>
                            <p>Avg Days Since Last SJ</p>
                            <small class="text-light">{{ $periode }}</small>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
            </div> --}}

            <!-- Deadstock Categories -->
            {{-- <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-1"></i>
                        Kategorisasi Deadstock
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if(isset($deadstockCategories) && $deadstockCategories->count() > 0)
                        @foreach($deadstockCategories as $category => $items)
                        <div class="col-md-3 col-sm-6">
                            <div class="info-box mb-3">
                                <span class="info-box-icon 
                                    @if(strpos($category, 'Kritis') !== false) bg-danger
                                    @elseif(strpos($category, 'Tinggi') !== false) bg-warning  
                                    @elseif(strpos($category, 'Sedang') !== false) bg-info
                                    @elseif(strpos($category, 'Slow') !== false) bg-primary
                                    @else bg-success
                                    @endif elevation-1">
                                    <i class="fas fa-clock"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">{{ $category }}</span>
                                    <span class="info-box-number">
                                        {{ $items->count() }} items
                                    </span>
                                    <div class="progress">
                                        <div class="progress-bar" 
                                             style="width: {{ $totalItems > 0 ? ($items->count() / $totalItems) * 100 : 0 }}%"></div>
                                    </div>
                                    <span class="progress-description">
                                        {{ $totalItems > 0 ? number_format(($items->count() / $totalItems) * 100, 1) : 0 }}% dari total
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle mr-2"></i>
                                No deadstock categories available for this period.
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div> --}}

            <!-- Age Distribution Chart -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar mr-1"></i>
                        Distribusi Umur Deadstock - Periode {{ $periode }}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div style="height: 400px;">
                                <canvas id="ageDistributionChart" width="400" height="200"></canvas>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-success">
                                    <i class="fas fa-clock"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">1-3 Bulan</span>
                                    <span class="info-box-number" id="count-1-3">0</span>
                                    <span class="progress-description" id="percent-1-3">0% dari total</span>
                                </div>
                            </div>
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-primary">
                                    <i class="fas fa-clock"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">4-6 Bulan</span>
                                    <span class="info-box-number" id="count-4-6">0</span>
                                    <span class="progress-description" id="percent-4-6">0% dari total</span>
                                </div>
                            </div>
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-warning">
                                    <i class="fas fa-clock"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">6-1 Tahun</span>
                                    <span class="info-box-number" id="count-6-12">0</span>
                                    <span class="progress-description" id="percent-6-12">0% dari total</span>
                                </div>
                            </div>
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-danger">
                                    <i class="fas fa-skull"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">1 Tahun ++</span>
                                    <span class="info-box-number" id="count-12-plus">0</span>
                                    <span class="progress-description" id="percent-12-plus">0% dari total</span>
                                </div>
                            </div>
                            <div class="info-box">
                                <span class="info-box-icon bg-secondary">
                                    <i class="fas fa-question"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Tidak Ada Data</span>
                                    <span class="info-box-number" id="count-no-data">0</span>
                                    <span class="progress-description" id="percent-no-data">0% dari total</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-table mr-1"></i>
                        Detail Deadstock - Periode {{ $periode }}
                    </h3>
                    {{-- <div class="card-tools">
                        <button type="button" class="btn btn-success btn-sm" onclick="exportToExcel()">
                            <i class="fas fa-file-excel mr-1"></i>Export Excel
                        </button>
                        <button type="button" class="btn btn-danger btn-sm ml-1" onclick="exportToPDF()">
                            <i class="fas fa-file-pdf mr-1"></i>Export PDF
                        </button>
                    </div> --}}
                </div>
                <div class="card-body">
                    @if(isset($stock) && $stock->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" id="deadstockTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="width: 5%;">#</th>
                                    <th style="width: 15%;">Kode Barang</th>
                                    <th style="width: 30%;">Nama Barang</th>
                                    <th style="width: 10%;">Saldo Crt</th>
                                    <th style="width: 10%;">Saldo Kg</th>
                                    <th style="width: 12%;">Tanggal PHP</th>
                                    <th style="width: 10%;">Hari Sejak PHP</th>
                                    <th style="width: 12%;">Kategori Deadstock</th>
                                    <th style="width: 10%;">Periode</th>
                                    <th style="width: 5%;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stock as $index => $item)
                                @php
                                    // Gunakan TglKeluar untuk sementara (jika ada)
                                    $referenceDate = $item->TglKeluar ?? null;
                                    $daysDiff = 0;
                                    
                                    if ($referenceDate) {
                                        try {
                                            // Parse periode untuk menentukan end date
                                            $currentPeriod = date('m/Y'); // Periode saat ini
                                            $reportPeriod = $periode; // Periode laporan
                                            
                                            if ($currentPeriod === $reportPeriod) {
                                                // Jika periode sama dengan periode berjalan, gunakan hari sekarang
                                                $endDate = \Carbon\Carbon::now();
                                            } else {
                                                // Jika periode berbeda, gunakan tanggal terakhir di periode tersebut
                                                $periodeParts = explode('/', $reportPeriod);
                                                if (count($periodeParts) == 2) {
                                                    $month = (int)$periodeParts[0];
                                                    $year = (int)$periodeParts[1];
                                                    $endDate = \Carbon\Carbon::create($year, $month)->endOfMonth();
                                                } else {
                                                    $endDate = \Carbon\Carbon::now();
                                                }
                                            }
                                            
                                            $daysDiff = \Carbon\Carbon::parse($referenceDate)->diffInDays($endDate);
                                        } catch (\Exception $e) {
                                            $daysDiff = 9999;
                                        }
                                    } else {
                                        $daysDiff = 9999;
                                    }
                                @endphp
                                <tr class="deadstock-row" data-age="{{ $daysDiff }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ trim($item->KodeBrg ?? '') }}</strong>
                                    </td>
                                    <td>
                                        <span title="{{ $item->NamaBrg ?? 'N/A' }}">
                                            {{ Str::limit($item->NamaBrg ?? 'N/A', 35) }}
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <span class="badge badge-primary">
                                            {{ number_format($item->SaldoAkhirCrt ?? 0, 0) }}
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <span class="badge badge-info">
                                            {{ number_format($item->SaldoAkhirKg ?? 0, 2) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if(isset($item->TglKeluar) && $item->TglKeluar)
                                            <span class="text-primary">
                                                {{ \Carbon\Carbon::parse($item->TglKeluar)->format('d/m/Y') }}
                                            </span>
                                            <small class="text-muted d-block">
                                                ({{ \Carbon\Carbon::parse($item->TglKeluar)->diffForHumans() }})
                                            </small>
                                        @else
                                            <span class="text-danger">Tidak Ada</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($referenceDate && $daysDiff < 9999)
                                            <span class="badge 
                                                @if($daysDiff > 365) badge-danger
                                                @elseif($daysDiff > 180) badge-warning
                                                @elseif($daysDiff > 90) badge-info
                                                @elseif($daysDiff > 30) badge-primary
                                                @else badge-success
                                                @endif">
                                                {{ $daysDiff }} hari
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($referenceDate && $daysDiff < 9999)
                                            @if($daysDiff <= 90)
                                                <span class="badge badge-success">1-3 bulan</span>
                                            @elseif($daysDiff <= 180)
                                                <span class="badge badge-primary">4-6 bulan</span>
                                            @elseif($daysDiff <= 365)
                                                <span class="badge badge-warning">6-1 tahun</span>
                                            @else
                                                <span class="badge badge-danger">1 tahun ++</span>
                                            @endif
                                        @else
                                            <span class="badge badge-secondary">Tidak ada data</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-secondary">
                                            {{ $item->Periode ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($daysDiff > 365)
                                            <i class="fas fa-skull text-danger" title="Deadstock Kritis"></i>
                                        @elseif($daysDiff > 180)
                                            <i class="fas fa-exclamation-triangle text-warning" title="Deadstock Tinggi"></i>
                                        @elseif($daysDiff > 90)
                                            <i class="fas fa-exclamation text-info" title="Deadstock Sedang"></i>
                                        @elseif($daysDiff > 30)
                                            <i class="fas fa-clock text-primary" title="Slow Moving"></i>
                                        @else
                                            <i class="fas fa-check-circle text-success" title="Fast Moving"></i>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="bg-light">
                                    <th colspan="3" class="text-right">Total:</th>
                                    <th class="text-right">
                                        <strong>{{ number_format($totalCrt, 0) }}</strong>
                                    </th>
                                    <th class="text-right">
                                        <strong>{{ number_format($totalKg, 2) }}</strong>
                                    </th>
                                    <th class="text-center">
                                        <small class="text-muted">{{ isset($stockWithSJ) ? $stockWithSJ->count() : 0 }} dengan tanggal</small>
                                    </th>
                                    <th class="text-center">
                                        <small class="text-muted">Avg: {{ number_format($avgDeadstockDays ?? 0, 0) }} hari</small>
                                    </th>
                                    <th colspan="3"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    <!-- Pagination Controls -->
                    @if(isset($pagination) && $pagination['total'] > 0)
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <small class="text-muted">
                                Menampilkan {{ $pagination['from'] }} - {{ $pagination['to'] }} 
                                dari {{ number_format($pagination['total']) }} data
                            </small>
                        </div>
                        
                        <div class="btn-group" role="group">
                            <!-- Previous Page -->
                            @if($pagination['current_page'] > 1)
                                <a href="?periode={{ $periode }}&page={{ $pagination['current_page'] - 1 }}&per_page={{ $pagination['per_page'] }}&age_filter={{ request('age_filter') }}" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-chevron-left"></i> Previous
                                </a>
                            @endif
                            
                            <!-- Page Numbers -->
                            @php
                                $start = max(1, $pagination['current_page'] - 2);
                                $end = min($pagination['last_page'], $pagination['current_page'] + 2);
                            @endphp
                            
                            @for($i = $start; $i <= $end; $i++)
                                @if($i == $pagination['current_page'])
                                    <span class="btn btn-sm btn-primary">{{ $i }}</span>
                                @else
                                    <a href="?periode={{ $periode }}&page={{ $i }}&per_page={{ $pagination['per_page'] }}&age_filter={{ request('age_filter') }}" 
                                       class="btn btn-sm btn-outline-primary">{{ $i }}</a>
                                @endif
                            @endfor
                            
                            <!-- Next Page -->
                            @if($pagination['current_page'] < $pagination['last_page'])
                                <a href="?periode={{ $periode }}&page={{ $pagination['current_page'] + 1 }}&per_page={{ $pagination['per_page'] }}&age_filter={{ request('age_filter') }}" 
                                   class="btn btn-sm btn-outline-primary">
                                    Next <i class="fas fa-chevron-right"></i>
                                </a>
                            @endif
                        </div>
                        
                        <!-- Per Page Selector -->
                        <div class="d-flex align-items-center">
                            <small class="text-muted mr-2">Per halaman:</small>
                            <select class="form-control form-control-sm" style="width: 80px;" onchange="changePerPage(this.value)">
                                <option value="25" {{ ($pagination['per_page'] ?? 50) == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ ($pagination['per_page'] ?? 50) == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ ($pagination['per_page'] ?? 50) == 100 ? 'selected' : '' }}>100</option>
                            </select>
                        </div>
                    </div>
                    @endif
                    
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Tidak ada data deadstock</h5>
                        <p class="text-muted">untuk periode {{ $periode }}</p>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </section>
</div>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('asset/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('asset/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('asset/plugins/chart.js/Chart.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('asset/dist/js/adminlte.js') }}"></script>

<script>
// Isolate chart functionality - menggunakan Chart.js AdminLTE
(function() {
    'use strict';
    
    // Chart variable for global access
    let ageDistributionChart = null;
    
    // Wait for jQuery and Chart.js to be ready
    $(document).ready(function() {
        console.log('DOM ready - Chart.js available:', typeof Chart !== 'undefined');
        
        // Initialize chart with delay to ensure everything is loaded
        setTimeout(function() {
            try {
                initializeChart();
            } catch (error) {
                console.error('Error initializing chart:', error);
                showChartError();
            }
        }, 1000);
    });

// Pagination helper functions with jQuery
function showLoading() {
    const loadingHtml = `
        <div id="loadingIndicator" class="position-fixed" style="top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999;">
            <div class="d-flex justify-content-center align-items-center h-100">
                <div class="text-center text-white">
                    <div class="spinner-border mb-3" role="status"></div>
                    <h5>Loading data...</h5>
                </div>
            </div>
        </div>
    `;
    $('body').append(loadingHtml);
}

function changePerPage(perPage) {
    showLoading();
    const currentUrl = new URL(window.location);
    currentUrl.searchParams.set('per_page', perPage);
    currentUrl.searchParams.set('page', 1); // Reset to first page
    window.location.href = currentUrl.toString();
}

function goToPage(page) {
    showLoading();
    const currentUrl = new URL(window.location);
    currentUrl.searchParams.set('page', page);
    window.location.href = currentUrl.toString();
}

// Initialize other functionality with jQuery
$(document).ready(function() {
    console.log('Document ready - initializing other features');
    
    // Add loading indicator to pagination links
    $('.btn-group a').on('click', function() {
        showLoading();
    });
    
    // Auto-refresh periode input format
    $('#periode').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        if (value.length >= 2) {
            value = value.substring(0, 2) + '/' + value.substring(2, 6);
        }
        $(this).val(value);
    });
    
    // Row highlighting based on age (only if rows exist)
    $('.deadstock-row').each(function() {
        const age = parseInt($(this).data('age')) || 0;
        if (age > 365) {
            $(this).addClass('table-danger');
        } else if (age > 180) {
            $(this).addClass('table-warning');
        } else if (age > 90) {
            $(this).addClass('table-info');
        }
    });
});

    // Initialize chart
    function initializeChart() {
        console.log('Initializing chart...');
        
        // Check if Chart.js is loaded
        if (typeof Chart === 'undefined') {
            console.error('Chart.js library not loaded!');
            showChartError();
            return;
        }
        
        console.log('Chart.js loaded, using server data for chart');
        
        // Get chart data from server (passed from controller)
        const serverChartData = @json($chartData ?? []);
        console.log('Server chart data:', serverChartData);
        
        if (serverChartData && Object.keys(serverChartData).length > 0) {
            createAgeChartFromServer(serverChartData);
            updateInfoBoxesFromServer(serverChartData);
        } else {
            console.log('No server chart data, falling back to DOM calculation');
            calculateAgeDistribution();
        }
    }

    // Show error message if chart fails to load
    function showChartError() {
        const chartContainer = document.getElementById('ageDistributionChart');
        if (chartContainer) {
            chartContainer.style.display = 'none';
            const errorDiv = document.createElement('div');
            errorDiv.className = 'alert alert-warning text-center';
            errorDiv.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Chart library gagal dimuat. Silakan refresh halaman.';
            chartContainer.parentNode.appendChild(errorDiv);
        }
    }
    // Calculate age distribution from table data
    function calculateAgeDistribution() {
        console.log('Calculating age distribution');
        
        let categories = {
            '1-3': 0,
            '4-6': 0, 
            '6-12': 0,
            '12+': 0,
            'no-data': 0
        };
        
        let totalRows = 0;
        
        // Count categories from visible table data using jQuery
        $('.deadstock-row').each(function() {
            totalRows++;
            let age = parseInt($(this).data('age')) || 9999;
            console.log('Row age:', age);
            
            if (age >= 9999 || age === undefined || age === null) {
                categories['no-data']++;
            } else if (age <= 90) {
                categories['1-3']++;
            } else if (age <= 180) {
                categories['4-6']++;
            } else if (age <= 365) {
                categories['6-12']++;
            } else {
                categories['12+']++;
            }
        });
        
        console.log('Total rows found:', totalRows);
        console.log('Categories:', categories);
        
        // Calculate total
        let total = Object.values(categories).reduce((a, b) => a + b, 0);
        console.log('Total items:', total);
        
        // Update info boxes
        updateInfoBoxes(categories, total);
        
        // Create chart
        if (total > 0) {
            createAgeChart(categories, total);
        } else {
            console.log('No data found for chart');
            showNoDataMessage();
        }
    }

    function showNoDataMessage() {
        const chartContainer = $('#ageDistributionChart');
        if (chartContainer.length > 0) {
            chartContainer.hide();
            const noDataDiv = $('<div class="alert alert-info text-center"><i class="fas fa-info-circle"></i> Tidak ada data untuk ditampilkan dalam chart.</div>');
            chartContainer.parent().append(noDataDiv);
        }
    }

    function updateInfoBoxes(categories, total) {
        console.log('Updating info boxes...');
        Object.keys(categories).forEach(key => {
            let count = categories[key];
            let percent = total > 0 ? ((count / total) * 100).toFixed(1) : 0;
            
            $(`#count-${key}`).text(count.toLocaleString());
            $(`#percent-${key}`).text(`${percent}% dari total`);
        });
    }

    function createAgeChartFromServer(serverData) {
        console.log('Creating chart from server data:', serverData);
        
        const ctx = $('#ageDistributionChart')[0];
        if (!ctx) {
            console.error('Chart canvas element not found!');
            return;
        }
        
        // Destroy existing chart if it exists
        if (ageDistributionChart) {
            ageDistributionChart.destroy();
        }
        
        // Calculate total for percentages
        const total = Object.values(serverData).reduce((a, b) => a + b, 0);
        console.log('Total items from server:', total);
        
        try {
            ageDistributionChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['1-3 Bulan', '4-6 Bulan', '6-1 Tahun', '1 Tahun ++', 'Tidak Ada Data'],
                    datasets: [{
                        data: [
                            serverData['1-3'] || 0,
                            serverData['4-6'] || 0, 
                            serverData['6-12'] || 0,
                            serverData['12+'] || 0,
                            serverData['no-data'] || 0
                        ],
                        backgroundColor: [
                            '#28a745', // Success - 1-3 bulan
                            '#007bff', // Primary - 4-6 bulan
                            '#ffc107', // Warning - 6-1 tahun
                            '#dc3545', // Danger - 1 tahun ++
                            '#6c757d'  // Secondary - no data
                        ],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                let label = data.labels[tooltipItem.index] || '';
                                let value = data.datasets[0].data[tooltipItem.index];
                                let percent = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                return `${label}: ${value.toLocaleString()} items (${percent}%)`;
                            }
                        }
                    }
                }
            });
            
            console.log('Chart created successfully from server data!');
        } catch (error) {
            console.error('Error creating chart:', error);
            showChartError();
        }
    }

    function updateInfoBoxesFromServer(serverData) {
        console.log('Updating info boxes from server data...');
        
        const total = Object.values(serverData).reduce((a, b) => a + b, 0);
        
        Object.keys(serverData).forEach(key => {
            let count = serverData[key] || 0;
            let percent = total > 0 ? ((count / total) * 100).toFixed(1) : 0;
            
            $(`#count-${key}`).text(count.toLocaleString());
            $(`#percent-${key}`).text(`${percent}% dari total`);
        });
    }

    function showChartError() {
        const chartContainer = $('#ageDistributionChart');
        if (chartContainer.length > 0) {
            chartContainer.hide();
            const errorDiv = $('<div class="alert alert-warning text-center"><i class="fas fa-exclamation-triangle"></i> Chart library gagal dimuat. Silakan refresh halaman.</div>');
            chartContainer.parent().append(errorDiv);
        }
    }

})(); // End of isolated scope
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
</style>

<!-- Include Floating Feedback Button -->
@include('admin.feedback.floating-button')

</body>
</html>