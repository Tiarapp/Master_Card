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
                        Laporan Kapasitas Gudang
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Reports</a></li>
                        <li class="breadcrumb-item active">Kapasitas Gudang</li>
                    </ol>
                </div>
            </div>
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
                    <form method="GET" action="{{ route('admin.report.kapasitas') }}" class="form-inline">
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
                        <a href="{{ route('admin.report.kapasitas') }}" class="btn btn-secondary mr-2">
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
                            <h3>{{ number_format(collect($gudangData)->sum('SaldoAkhirKg'), 2) }}</h3>
                            <p>Total Berat (Kg)</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-weight"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ number_format(collect($gudangData)->sum('SaldoAkhirCrt'), 2) }}</h3>
                            <p>Total Kuantitas (CRT)</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-boxes"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ number_format(collect($gudangData)->count()) }}</h3>
                            <p>Total Item</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-list"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            @php
                                $totalKg = collect($gudangData)->sum('SaldoAkhirKg');
                                $percentage = $totalKg > 0 ? ($totalKg / 1000000) * 100 : 0; // Assuming max capacity 1M kg
                            @endphp
                            <h3>{{ number_format($percentage, 1) }}%</h3>
                            <p>Kapasitas Terpakai dari 1000 Kg</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-bar mr-1"></i>
                                Distribusi Kapasitas Gudang per Jenis Produk - {{ $periode }}
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="chart-responsive">
                                        <canvas id="kapasitasChart" width="400" height="200"></canvas>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="chart-legend">
                                        <h5>Top 5 Jenis Produk:</h5>
                                        <ul class="chart-legend list-unstyled" id="chart-legend">
                                            <!-- Legend will be populated by JavaScript -->
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
                        Data Kapasitas Gudang - {{ $periode }}
                    </h3>
                    <div class="card-tools">
                        <span class="badge badge-primary">Total: {{ number_format(count($gudangData)) }} items</span>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover table-striped" id="kapasitasTable">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Jenis Produk</th>
                                <th>Qty (CRT)</th>
                                <th>Berat (Kg)</th>
                                <th>% Kontribusi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($gudangData as $index => $item)
                            @php
                                $totalKg = collect($gudangData)->sum('SaldoAkhirKg');
                                $kontribusi = $totalKg > 0 ? (($item->SaldoAkhirKg ?? 0) / $totalKg) * 100 : 0;
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $item->KodeBrg ?? 'N/A' }}</strong>
                                </td>
                                <td>{{ $item->NamaBrg ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge badge-info">{{ $item->Nama ?? 'N/A' }}</span>
                                </td>
                                <td class="text-right">
                                    <strong>{{ number_format($item->SaldoAkhirCrt ?? 0, 2) }}</strong>
                                </td>
                                <td class="text-right">
                                    <strong>{{ number_format($item->SaldoAkhirKg ?? 0, 3) }}</strong>
                                </td>
                                <td class="text-center">
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar 
                                            @if($kontribusi >= 5) bg-danger
                                            @elseif($kontribusi >= 2) bg-warning  
                                            @elseif($kontribusi >= 1) bg-info
                                            @else bg-success
                                            @endif" 
                                            style="width: {{ min($kontribusi * 5, 100) }}%">
                                            {{ number_format($kontribusi, 2) }}%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        Tidak ada data kapasitas gudang untuk periode {{ $periode }}
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
    $('#kapasitasTable').DataTable({
        "pageLength": 25,
        "ordering": true,
        "searching": true,
        "responsive": true,
        "order": [[ 5, "desc" ]], // Order by Berat (Kg) descending
        "columnDefs": [
            { "orderable": false, "targets": [6] } // Disable ordering on % Kontribusi column
        ]
    });
    
    // Prepare chart data
    const gudangData = @json($gudangData);
    
    // Group by Jenis Produk
    const groupedData = {};
    gudangData.forEach(item => {
        const jenis = item.Nama || 'Unknown';
        if (!groupedData[jenis]) {
            groupedData[jenis] = { totalKg: 0, totalCrt: 0, count: 0 };
        }
        groupedData[jenis].totalKg += parseFloat(item.SaldoAkhirKg || 0);
        groupedData[jenis].totalCrt += parseFloat(item.SaldoAkhirCrt || 0);
        groupedData[jenis].count += 1;
    });
    
    // Sort and get top 10
    const sortedData = Object.entries(groupedData)
        .sort((a, b) => b[1].totalKg - a[1].totalKg)
        .slice(0, 10);
    
    const labels = sortedData.map(item => item[0]);
    const data = sortedData.map(item => item[1].totalKg);
    const colors = [
        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
        '#FF9F40', '#FF6384', '#C9CBCF', '#4BC0C0', '#FF6384'
    ];
    
    // Create chart
    const ctx = document.getElementById('kapasitasChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: colors,
                borderColor: colors.map(color => color + '80'),
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label;
                            const value = context.raw;
                            const total = data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${label}: ${value.toLocaleString()} kg (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
    
    // Update legend
    const legendContainer = document.getElementById('chart-legend');
    sortedData.slice(0, 5).forEach((item, index) => {
        const total = data.reduce((a, b) => a + b, 0);
        const percentage = ((item[1].totalKg / total) * 100).toFixed(1);
        
        const legendItem = document.createElement('li');
        legendItem.innerHTML = `
            <i class="fa fa-circle" style="color: ${colors[index]}"></i>
            <strong>${item[0]}</strong><br>
            <small>${item[1].totalKg.toLocaleString()} kg (${percentage}%)</small>
        `;
        legendContainer.appendChild(legendItem);
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

.progress {
    background-color: #e9ecef;
}

.table-hover tbody tr:hover {
    background-color: #f5f5f5;
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