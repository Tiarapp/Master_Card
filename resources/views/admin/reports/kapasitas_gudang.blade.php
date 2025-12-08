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
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ number_format($totals['totalKg'], 2) }}</h3>
                            <p>Total Berat (Kg)</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-weight"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ number_format($totals['totalCrt'], 2) }}</h3>
                            <p>Total Kuantitas (CRT)</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-boxes"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ number_format($totals['totalItems']) }}</h3>
                            <p>Total Item</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-list"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ number_format($totals['percentage'], 1) }}%</h3>
                            <p>Kapasitas Terpakai</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>{{ number_format((1000000 - $totals['totalKg']), 0) }}</h3>
                            <p>Sisa Kapasitas (Kg)</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-warehouse"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ number_format((100 - $totals['percentage']), 1) }}%</h3>
                            <p>Sisa Kapasitas (%)</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-percent"></i>
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
                                <div class="col-md-6">
                                    <div class="chart-responsive">
                                        <canvas id="kapasitasChart" width="400" height="200"></canvas>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="chart-legend-container">
                                        <h5>Semua Jenis Produk:</h5>
                                        <div class="row" id="chart-legend">
                                            <!-- Legend will be populated by JavaScript -->
                                        </div>
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
                        <span class="badge badge-primary">Total: {{ number_format($totals['totalItems']) }} items</span>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <!-- Loading indicator -->
                    <div id="table-loading" class="text-center py-4">
                        <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                        <p class="mt-2">Memuat data kapasitas gudang...</p>
                    </div>
                    
                    <table class="table table-hover table-striped" id="kapasitasTable" style="display: none;">
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
                                $kontribusi = $totals['totalKg'] > 0 ? (($item->SaldoAkhirKg ?? 0) / $totals['totalKg']) * 100 : 0;
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
    // Show loading indicator
    $('#table-loading').show();
    $('#kapasitasTable').hide();
    
    // Initialize DataTable with optimized settings
    const table = $('#kapasitasTable').DataTable({
        "pageLength": 50,
        "ordering": true,
        "searching": true,
        "responsive": true,
        "deferRender": true,        // Render rows only when needed
        "processing": true,         // Show processing indicator
        "stateSave": true,          // Save user state
        "order": [[ 5, "desc" ]], // Order by Berat (Kg) descending
        "columnDefs": [
            { "orderable": false, "targets": [6] } // Disable ordering on % Kontribusi column
        ],
        "language": {
            "processing": "Memproses data...",
            "search": "Cari:",
            "lengthMenu": "Tampilkan _MENU_ data",
            "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            "paginate": {
                "first": "Pertama",
                "last": "Terakhir", 
                "next": "Selanjutnya",
                "previous": "Sebelumnya"
            }
        },
        "initComplete": function() {
            // Hide loading indicator and show table
            $('#table-loading').fadeOut();
            $('#kapasitasTable').fadeIn();
        }
    });
    
    // Prepare chart data with optimization
    const gudangData = @json($gudangData);
    
    // Optimize chart processing for large datasets
    const processChartData = () => {
        // Group by Jenis Produk with efficient aggregation
        const groupedData = {};
        
        // Single pass through data
        gudangData.forEach(item => {
            const jenis = item.Nama || 'Unknown';
            if (!groupedData[jenis]) {
                groupedData[jenis] = { totalKg: 0, totalCrt: 0, count: 0 };
            }
            groupedData[jenis].totalKg += parseFloat(item.SaldoAkhirKg || 0);
            groupedData[jenis].totalCrt += parseFloat(item.SaldoAkhirCrt || 0);
            groupedData[jenis].count += 1;
        });
        
        return groupedData;
    };
    
    // Process data efficiently
    const groupedData = processChartData();
    
    // Sort ALL data for chart (show all product types)
    const sortedData = Object.entries(groupedData)
        .sort((a, b) => b[1].totalKg - a[1].totalKg);
    
    console.log('Total product types found:', sortedData.length);
    
    // Calculate remaining capacity
    const totalUsedKg = @json($totals['totalKg']);
    const maxCapacityKg = 1000000; // 1 million kg max capacity
    const remainingCapacityKg = Math.max(0, maxCapacityKg - totalUsedKg);
    
    // Debug information
    console.log('Total Used Kg:', totalUsedKg);
    console.log('Remaining Capacity Kg:', remainingCapacityKg);
    
    // Prepare chart data including remaining capacity
    const labels = sortedData.map(item => item[0]);
    const data = sortedData.map(item => item[1].totalKg);
    
    // Always add remaining capacity to chart (even if 0 for awareness)
    labels.push('Sisa Kapasitas Gudang');
    data.push(remainingCapacityKg);
    
    // Generate dynamic colors for all product types
    const generateColors = (count) => {
        const baseColors = [
            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
            '#FF9F40', '#8E5EA2', '#F7464A', '#46BFBD', '#FDB45C',
            '#949FB1', '#4D5360', '#AC64AD', '#FF5722', '#795548',
            '#607D8B', '#E91E63', '#9C27B0', '#673AB7', '#3F51B5',
            '#2196F3', '#03A9F4', '#00BCD4', '#009688', '#4CAF50',
            '#8BC34A', '#CDDC39', '#FFEB3B', '#FFC107', '#FF9800'
        ];
        
        const colors = [];
        for (let i = 0; i < count - 1; i++) { // -1 because last color is for remaining capacity
            if (i < baseColors.length) {
                colors.push(baseColors[i]);
            } else {
                // Generate additional colors using HSL
                const hue = (i * 137.5) % 360; // Golden angle for good distribution
                const saturation = 60 + (i % 3) * 15; // Vary saturation
                const lightness = 45 + (i % 4) * 10;  // Vary lightness
                colors.push(`hsl(${hue}, ${saturation}%, ${lightness}%)`);
            }
        }
        colors.push('#95A5A6'); // Gray for remaining capacity
        return colors;
    };
    
    const colors = generateColors(labels.length);
    
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
                            
                            if (label === 'Sisa Kapasitas Gudang') {
                                const capacityPercentage = ((value / 1000000) * 100).toFixed(1);
                                return `${label}: ${value.toLocaleString()} kg (${capacityPercentage}% dari total kapasitas)`;
                            } else {
                                return `${label}: ${value.toLocaleString()} kg (${percentage}% dari terpakai)`;
                            }
                        }
                    }
                },
                title: {
                    display: true,
                    text: 'Distribusi Kapasitas Gudang (Maks: 1,000,000 kg)',
                    font: {
                        size: 14
                    }
                }
            }
        }
    });
    
    // Update legend
    const legendContainer = document.getElementById('chart-legend');
    
    // Add header with count information
    const headerInfo = document.createElement('div');
    headerInfo.innerHTML = `<small class="text-muted mb-3 d-block">Total: ${sortedData.length} jenis produk</small>`;
    headerInfo.className = 'col-12';
    legendContainer.appendChild(headerInfo);
    
    // Show ALL product types in legend using grid layout
    sortedData.forEach((item, index) => {
        const total = data.reduce((a, b) => a + b, 0);
        const percentage = ((item[1].totalKg / total) * 100).toFixed(1);
        
        const legendItem = document.createElement('div');
        legendItem.className = 'col-6 col-lg-4 mb-2'; // 2 columns on mobile, 3 on desktop
        legendItem.innerHTML = `
            <div class="legend-item">
                <i class="fa fa-circle" style="color: ${colors[index]}"></i>
                <strong class="legend-title">${item[0]}</strong>
                <small class="legend-value d-block">${item[1].totalKg.toLocaleString()} kg (${percentage}%)</small>
            </div>
        `;
        legendContainer.appendChild(legendItem);
    });
    
    // Always add remaining capacity to legend
    const total = data.reduce((a, b) => a + b, 0);
    const percentage = ((remainingCapacityKg / total) * 100).toFixed(1);
    const capacityPercentage = ((remainingCapacityKg / 1000000) * 100).toFixed(1);
    
    const legendItem = document.createElement('div');
    legendItem.className = 'col-12 mt-3';
    legendItem.innerHTML = `
        <div class="legend-item legend-capacity">
            <i class="fa fa-circle" style="color: ${colors[colors.length - 1]}"></i>
            <strong class="legend-title">Sisa Kapasitas</strong>
            <small class="legend-value d-block">${remainingCapacityKg.toLocaleString()} kg (${capacityPercentage}% dari total kapasitas)</small>
        </div>
    `;
    
    // Add special styling if remaining capacity is very low
    if (remainingCapacityKg < 50000) { // Less than 50,000 kg remaining
        legendItem.querySelector('.legend-capacity').style.backgroundColor = '#ffebee';
        legendItem.querySelector('.legend-capacity').style.border = '1px solid #ef5350';
    }
    
    legendContainer.appendChild(legendItem);
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

/* Loading animation */
#table-loading {
    min-height: 200px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

/* Optimize table rendering */
#kapasitasTable {
    table-layout: auto;
}

#kapasitasTable tbody tr {
    transition: background-color 0.2s ease;
}

/* DataTables processing overlay */
.dataTables_processing {
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: white;
    border: none;
    border-radius: 8px;
}

/* Chart legend styling - Grid Layout */
.chart-legend-container {
    padding: 15px;
}

.chart-legend-container h5 {
    margin-bottom: 15px;
    color: #495057;
    font-weight: 600;
}

.legend-item {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 6px;
    padding: 8px 12px;
    transition: all 0.2s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.legend-item:hover {
    background-color: #e9ecef;
    border-color: #6c757d;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.legend-item i {
    margin-right: 8px;
    font-size: 12px;
    vertical-align: middle;
}

.legend-title {
    font-size: 12px;
    color: #495057;
    font-weight: 600;
    line-height: 1.2;
    margin-bottom: 2px;
}

.legend-value {
    color: #6c757d;
    font-size: 10px;
    line-height: 1.1;
}

.legend-capacity {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border: 2px solid #6c757d;
    font-weight: bold;
}

.legend-capacity .legend-title {
    font-size: 14px;
    color: #495057;
}

.legend-capacity .legend-value {
    font-size: 12px;
    color: #495057;
    font-weight: 600;
}

/* Chart responsive container */
.chart-responsive {
    position: relative;
    height: 400px;
}

#kapasitasChart {
    max-height: 400px;
}

@media (max-width: 768px) {
    .small-box h3 {
        font-size: 1.5rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
    
    #table-loading {
        min-height: 150px;
    }
    
    .chart-responsive {
        height: 300px;
        margin-bottom: 20px;
    }
    
    .legend-item {
        margin-bottom: 8px;
        padding: 6px 8px;
    }
    
    .legend-title {
        font-size: 11px;
    }
    
    .legend-value {
        font-size: 9px;
    }
    
    .chart-legend-container h5 {
        font-size: 14px;
        margin-bottom: 10px;
    }
}

@media (max-width: 576px) {
    .legend-item {
        padding: 5px 6px;
    }
    
    .legend-title {
        font-size: 10px;
    }
    
    .legend-value {
        font-size: 8px;
    }
}
</style>
@endsection