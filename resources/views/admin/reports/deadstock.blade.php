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
                    </form>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                Distribusi Umur Deadstock - {{ $periode }}
                            </h3>
                        </div>
                        <div class="card-body">
                            <!-- Info Boxes -->
                            <div class="row mb-4">
                                <div class="col-md-2 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-success">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">1-3 Bulan</span>
                                            <span class="info-box-number" id="count-1-3">-</span>
                                            <div class="progress">
                                                <div class="progress-bar bg-success" style="width: 0%" id="progress-1-3"></div>
                                            </div>
                                            <span class="progress-description" id="percent-1-3">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-warning">
                                            <i class="fas fa-hourglass-half"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">4-6 Bulan</span>
                                            <span class="info-box-number" id="count-4-6">-</span>
                                            <div class="progress">
                                                <div class="progress-bar bg-warning" style="width: 0%" id="progress-4-6"></div>
                                            </div>
                                            <span class="progress-description" id="percent-4-6">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-danger">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">6-1 Tahun</span>
                                            <span class="info-box-number" id="count-6-12">-</span>
                                            <div class="progress">
                                                <div class="progress-bar bg-danger" style="width: 0%" id="progress-6-12"></div>
                                            </div>
                                            <span class="progress-description" id="percent-6-12">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-dark">
                                            <i class="fas fa-skull-crossbones"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">1 Tahun ++</span>
                                            <span class="info-box-number" id="count-12+">-</span>
                                            <div class="progress">
                                                <div class="progress-bar bg-dark" style="width: 0%" id="progress-12+"></div>
                                            </div>
                                            <span class="progress-description" id="percent-12+">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-secondary">
                                            <i class="fas fa-question"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">No Data</span>
                                            <span class="info-box-number" id="count-no-data">-</span>
                                            <div class="progress">
                                                <div class="progress-bar bg-secondary" style="width: 0%" id="progress-no-data"></div>
                                            </div>
                                            <span class="progress-description" id="percent-no-data">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Chart Canvas -->
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="chart-responsive">
                                        <canvas id="ageDistributionChart" width="400" height="200"></canvas>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="chart-legend">
                                        <ul class="chart-legend clearfix">
                                            <li><i class="fa fa-circle text-success"></i> 1-3 Bulan (Masih Normal)</li>
                                            <li><i class="fa fa-circle text-warning"></i> 4-6 Bulan (Perlu Perhatian)</li>
                                            <li><i class="fa fa-circle text-danger"></i> 6-1 Tahun (Deadstock)</li>
                                            <li><i class="fa fa-circle text-dark"></i> 1 Tahun ++ (Kritis)</li>
                                            <li><i class="fa fa-circle text-secondary"></i> Tidak Ada Data</li>
                                        </ul>
                                    </div>
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
                        Data Deadstock - {{ $periode }}
                    </h3>
                    <div class="card-tools">
                        <span class="badge badge-primary">Total: {{ number_format($totalItems) }} items</span>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Qty (CRT)</th>
                                <th>Satuan</th>
                                <th>Tanggal Keluar Terakhir</th>
                                <th>Umur (hari)</th>
                                <th>Kategori Umur</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stock as $index => $item)
                            <tr class="deadstock-row">
                                <td>{{ $pagination['from'] + $index }}</td>
                                <td>
                                    <strong>{{ $item->KodeBrg ?? 'N/A' }}</strong>
                                </td>
                                <td>{{ $item->NamaBrg ?? 'N/A' }}</td>
                                <td class="text-right">
                                    <strong>{{ number_format($item->SaldoAkhirCrt ?? 0, 2) }}</strong>
                                </td>
                                <td>{{ 'CRT' }}</td>
                                <td>
                                    @if($item->TglKeluar)
                                        {{ \Carbon\Carbon::parse($item->TglKeluar)->format('d/m/Y') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($item->DaysSinceLastSJ !== null && $item->DaysSinceLastSJ < 9999)
                                        @php
                                            $daysDiff = $item->DaysSinceLastSJ;
                                        @endphp
                                        <span class="badge 
                                            @if($daysDiff <= 90) badge-success
                                            @elseif($daysDiff <= 180) badge-warning  
                                            @elseif($daysDiff <= 365) badge-danger
                                            @else badge-dark
                                            @endif">
                                            {{ number_format($daysDiff) }} hari
                                        </span>
                                    @else
                                        <span class="badge badge-secondary">No Data</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->DaysSinceLastSJ !== null && $item->DaysSinceLastSJ < 9999)
                                        @php
                                            $daysDiff = $item->DaysSinceLastSJ;
                                        @endphp
                                        @if($daysDiff <= 90)
                                            <span class="badge badge-success">1-3 bulan</span>
                                        @elseif($daysDiff <= 180)
                                            <span class="badge badge-warning">4-6 bulan</span>
                                        @elseif($daysDiff <= 365)
                                            <span class="badge badge-danger">6-1 tahun</span>
                                        @else
                                            <span class="badge badge-dark">1 tahun ++</span>
                                        @endif
                                    @else
                                        <span class="badge badge-secondary">Tidak ada data</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        Tidak ada data deadstock untuk periode {{ $periode }}
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if(isset($pagination) && $pagination['last_page'] > 1)
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-6">
                            <small class="text-muted">
                                Menampilkan {{ $pagination['from'] }} sampai {{ $pagination['to'] }} 
                                dari {{ $pagination['total'] }} entries
                            </small>
                        </div>
                        <div class="col-sm-6">
                            <nav aria-label="Page navigation">
                                <ul class="pagination pagination-sm float-right">
                                    @if($pagination['current_page'] > 1)
                                        <li class="page-item">
                                            <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => 1]) }}">First</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $pagination['current_page'] - 1]) }}">Previous</a>
                                        </li>
                                    @endif
                                    
                                    @for($i = max(1, $pagination['current_page'] - 2); $i <= min($pagination['last_page'], $pagination['current_page'] + 2); $i++)
                                        <li class="page-item {{ $i == $pagination['current_page'] ? 'active' : '' }}">
                                            <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $i]) }}">{{ $i }}</a>
                                        </li>
                                    @endfor
                                    
                                    @if($pagination['current_page'] < $pagination['last_page'])
                                        <li class="page-item">
                                            <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $pagination['current_page'] + 1]) }}">Next</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $pagination['last_page']]) }}">Last</a>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection

@section('javascripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Isolated scope to prevent conflicts with app.js
(function() {
    'use strict';
    
    console.log('Deadstock Chart Script Loaded');
    
    // Get chart data from server
    const chartData = @json($chartData ?? []);
    console.log('Server chart data:', chartData);
    
    // Wait for DOM ready
    $(document).ready(function() {
        console.log('DOM ready, initializing chart...');
        
        // Check if Chart.js is loaded
        if (typeof Chart === 'undefined') {
            console.error('Chart.js not loaded');
            showChartError();
            return;
        }
        
        // Initialize chart with server data
        if (chartData && Object.keys(chartData).length > 0) {
            createAgeChartFromServer(chartData);
            updateInfoBoxesFromServer(chartData);
        } else {
            console.warn('No chart data available');
            showChartError();
        }
    });

    function createAgeChartFromServer(serverData) {
        console.log('Creating chart from server data...');
        
        try {
            const ctx = document.getElementById('ageDistributionChart');
            if (!ctx) {
                console.error('Chart canvas not found');
                return;
            }
            
            const data = {
                labels: ['1-3 Bulan', '4-6 Bulan', '6-1 Tahun', '1 Tahun ++', 'Tidak Ada Data'],
                datasets: [{
                    data: [
                        serverData['1-3'] || 0,
                        serverData['4-6'] || 0, 
                        serverData['6-12'] || 0,
                        serverData['12+'] || 0,
                        serverData['no-data'] || 0
                    ],
                    backgroundColor: ['#28a745', '#ffc107', '#dc3545', '#343a40', '#6c757d'],
                    borderColor: ['#1e7e34', '#e0a800', '#c82333', '#1d2124', '#545b62'],
                    borderWidth: 2
                }]
            };
            
            const total = Object.values(serverData).reduce((a, b) => a + b, 0);
            console.log('Total items for chart:', total);
            
            window.ageChart = new Chart(ctx, {
                type: 'doughnut',
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
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
@endsection