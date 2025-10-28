@extends('admin.templates.partials.default')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-exchange-alt mr-2"></i>
                        Laporan In/Out Bound
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Reports</a></li>
                        <li class="breadcrumb-item active">In/Out Bound</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fas fa-ban"></i> Error!</h4>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Filter Controls -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-filter mr-1"></i>
                        Filter Data
                    </h3>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.report.in_out_bound') }}" class="form-inline">
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
                        <button type="submit" class="btn btn-primary mr-2">
                            <i class="fas fa-search mr-1"></i>Filter
                        </button>
                        <a href="{{ route('admin.report.in_out_bound') }}" class="btn btn-secondary mr-2">
                            <i class="fas fa-refresh mr-1"></i>Reset
                        </a>
                    </form>
                </div>
            </div>

            <!-- Summary Statistics -->
            <div class="row mb-4">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ number_format(collect($inOutData)->sum('qtySJ'), 2) }}</h3>
                            <p>Total Qty SJ (Kg)</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-truck"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ number_format(collect($inOutData)->sum('qtyPHP'), 2) }}</h3>
                            <p>Total Qty PHP (Kg)</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-download"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ collect($inOutData)->sum('total_sj') }}</h3>
                            <p>Total Dokumen SJ</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ collect($inOutData)->sum('total_php') }}</h3>
                            <p>Total Dokumen PHP</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-file"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-bar mr-1"></i>
                                Perbandingan SJ vs PHP (14 Data Terakhir)
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="chart-responsive">
                                <canvas id="trendChart" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                Distribusi SJ vs PHP
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="chart-responsive">
                                <canvas id="distributionChart" width="400" height="200"></canvas>
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
                        Data Detail In/Out Bound - {{ $periode }}
                    </h3>
                    <div class="card-tools">
                        <span class="badge badge-primary">Total: {{ number_format(count($inOutData)) }} records</span>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover table-striped" id="inOutTable">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Total Jenis Barang</th>
                                <th>Qty SJ (Kg)</th>
                                <th>Qty PHP (Kg)</th>
                                <th>Total Dokumen SJ</th>
                                <th>Total Dokumen PHP</th>
                                <th>Selisih (Kg)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($inOutData as $index => $item)
                                @php
                                    $selisih = ($item->qtySJ ?? 0) - ($item->qtyPHP ?? 0);
                                @endphp
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        @if($item->tanggal)
                                            <strong>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</strong>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-warning">{{ $item->total_item_types ?? 0 }} jenis</span>
                                    </td>
                                    <td class="text-right">
                                        <strong>{{ number_format($item->qtySJ ?? 0, 2, ',', '.') }}</strong>
                                    </td>
                                    <td class="text-right">
                                        <strong>{{ number_format($item->qtyPHP ?? 0, 2, ',', '.') }}</strong>
                                    </td>
                                    <td class="text-center">{{ $item->total_sj ?? 0 }}</td>
                                    <td class="text-center">{{ $item->total_php ?? 0 }}</td>
                                    <td class="text-right">
                                        <span class="badge {{ $selisih >= 0 ? 'badge-success' : 'badge-danger' }}">
                                            {{ number_format($selisih, 2, ',', '.') }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle mr-2"></i>
                                            Tidak ada data untuk periode {{ $periode }}
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('javascripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#inOutTable').DataTable({
        "pageLength": 10,
        "ordering": true,
        "searching": true,
        "responsive": true,
        "order": [[ 1, "desc" ]], // Order by date desc
        "columnDefs": [
            { "orderable": false, "targets": [0, 3] } // Disable ordering on No and Daftar Barang columns
        ]
    });

    // Prepare chart data
    const chartData = @json($inOutData);
    
    // Group data by date for trend chart
    const dateGroups = {};
    chartData.forEach(item => {
        const date = item.tanggal || 'Unknown';
        if (!dateGroups[date]) {
            dateGroups[date] = { qtySJ: 0, qtyPHP: 0 };
        }
        dateGroups[date].qtySJ += parseFloat(item.qtySJ || 0);
        dateGroups[date].qtyPHP += parseFloat(item.qtyPHP || 0);
    });

    // Get last 14 dates sorted by date (most recent first)
    const sortedDates = Object.keys(dateGroups)
        .sort((a, b) => new Date(b) - new Date(a)) // Sort by date descending
        .slice(0, 14) // Take last 14 records
        .reverse(); // Reverse to show chronological order in chart

    const trendLabels = sortedDates.map(date => {
        try {
            return new Date(date).toLocaleDateString('id-ID', { 
                day: '2-digit', 
                month: '2-digit',
                year: '2-digit'
            });
        } catch (e) {
            return date;
        }
    });

    const sjData = sortedDates.map(date => dateGroups[date].qtySJ);
    const phpData = sortedDates.map(date => dateGroups[date].qtyPHP);

    // Trend Chart (Changed to Bar Chart)
    const trendCtx = document.getElementById('trendChart').getContext('2d');
    new Chart(trendCtx, {
        type: 'bar',
        data: {
            labels: trendLabels,
            datasets: [{
                label: 'SJ (Outbound)',
                data: sjData,
                backgroundColor: 'rgba(54, 162, 235, 0.8)',
                borderColor: 'rgb(54, 162, 235)',
                borderWidth: 1
            }, {
                label: 'PHP (Inbound)',
                data: phpData,
                backgroundColor: 'rgba(75, 192, 192, 0.8)',
                borderColor: 'rgb(75, 192, 192)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Tanggal (14 Data Terakhir)'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Quantity (Kg)'
                    },
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('id-ID') + ' Kg';
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + 
                                   context.parsed.y.toLocaleString('id-ID') + ' Kg';
                        }
                    }
                }
            }
        }
    });

    // Distribution Chart
    const totalSJ = chartData.reduce((sum, item) => sum + parseFloat(item.qtySJ || 0), 0);
    const totalPHP = chartData.reduce((sum, item) => sum + parseFloat(item.qtyPHP || 0), 0);

    const distributionCtx = document.getElementById('distributionChart').getContext('2d');
    new Chart(distributionCtx, {
        type: 'doughnut',
        data: {
            labels: ['SJ (Outbound)', 'PHP (Inbound)'],
            datasets: [{
                data: [totalSJ, totalPHP],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(75, 192, 192, 0.8)'
                ],
                borderColor: [
                    'rgb(54, 162, 235)',
                    'rgb(75, 192, 192)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = totalSJ + totalPHP;
                            const percentage = total > 0 ? ((context.parsed / total) * 100).toFixed(1) : 0;
                            return context.label + ': ' + 
                                   context.parsed.toLocaleString('id-ID') + ' Kg (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });
});
</script>

<style>
.small-box {
    border-radius: 0.5rem;
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
}

.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.thead-dark th {
    background-color: #343a40;
    border-color: #454d55;
}

.table-hover tbody tr:hover {
    background-color: #f5f5f5;
}

.chart-responsive {
    position: relative;
    height: 300px;
}

@media (max-width: 768px) {
    .small-box h3 {
        font-size: 1.5rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .chart-responsive {
        height: 250px;
    }
}
</style>
@endsection