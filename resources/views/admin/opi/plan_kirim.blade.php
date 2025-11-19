@extends('admin.templates.partials.default')

<style>
.label {
  color: white;
}

.status {
  width: auto;
  height: auto;
  margin-top: 20px;
  text-align: center;
  padding: 8px;
  border-radius: 10%;
}

.success {background-color: #04AA6D;} /* Green */
.info {background-color: #2196F3;} /* Blue */
.warning {background-color: #ff9800;} /* Orange */
.danger {background-color: #f44336;} /* Red */
.other {background-color: #e7e7e7; color: black;} /* Gray */

.plan-kirim-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 30px;
}

.date-range {
    background-color: rgba(255,255,255,0.1);
    padding: 10px 15px;
    border-radius: 5px;
    display: inline-block;
}
</style>

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Plan Kirim OPI</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('opinew') }}">OPI</a></li>
            <li class="breadcrumb-item active">Plan Kirim</li>
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

      <!-- Form Filter Tanggal -->
      <div class="card mb-4">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filter Periode Tanggal</h5>
        </div>
        <div class="card-body">
          <form action="{{ route('opi.plan_kirim') }}" method="GET" class="row g-3">
            <div class="col-md-4">
              <label for="start_date" class="form-label">Tanggal Mulai</label>
              <input type="date" class="form-control" id="start_date" name="start" value="{{ request('start', date('Y-m-d')) }}" required>
            </div>
            <div class="col-md-4">
              <label for="end_date" class="form-label">Tanggal Selesai</label>
              <input type="date" class="form-control" id="end_date" name="end" value="{{ request('end', date('Y-m-d', strtotime('+7 days'))) }}" required>
            </div>
            <div class="col-md-4 d-flex align-items-end">
              <button type="submit" class="btn btn-primary me-2">
                <i class="fas fa-search me-2"></i>Cari
              </button>
              <button type="button" class="btn btn-outline-secondary" onclick="resetDates()">
                <i class="fas fa-sync-alt me-2"></i>Reset
              </button>
            </div>
          </form>
          
          <!-- Quick Date Presets -->
          <div class="mt-3">
            <small class="text-muted">Preset Cepat:</small>
            <div class="btn-group btn-group-sm mt-1" role="group">
              <button type="button" class="btn btn-outline-info" onclick="setDateRange(0, 0)">Hari Ini</button>
              <button type="button" class="btn btn-outline-info" onclick="setDateRange(0, 6)">Minggu Ini</button>
              <button type="button" class="btn btn-outline-info" onclick="setDateRange(0, 13)">2 Minggu</button>
              <button type="button" class="btn btn-outline-info" onclick="setDateRange(0, 29)">Bulan Ini</button>
            </div>
          </div>
        </div>
      </div>

      @if(isset($start_date) && isset($end_date))
      <!-- Header dengan periode tanggal -->
      <div class="plan-kirim-header">
        <h3 class="mb-3"><i class="fas fa-calendar-alt me-2"></i>Rencana Pengiriman OPI</h3>
        <div class="date-range">
          <i class="fas fa-calendar-check me-2"></i>
          <strong>Periode: {{ $start_date }} - {{ $end_date }}</strong>
        </div>
        <div class="mt-3">
          <small><i class="fas fa-info-circle me-2"></i>Total OPI: {{ count($data) }} items | Status: Proses | Diurutkan berdasarkan Kode Barang</small>
        </div>
      </div>
      @endif

      @if(isset($data) && count($data) > 0)
      <!-- Export dan Filter -->
      <div class="row mb-4 align-items-center">
        <div class="col-auto d-flex align-items-center gap-3">
          {{-- <button onclick="window.print()" class="btn btn-primary mb-3">
            <i class="fas fa-print me-2"></i>Print Rencana Kirim
          </button> --}}
          <a href="{{ route('opi.plan_kirim.export', ['start' => request('start'), 'end' => request('end')]) }}" class="btn btn-success mb-3">
            <i class="fas fa-file-excel me-2"></i>Export to Excel
          </a>
          <a href="{{ route('opinew') }}" class="btn btn-outline-secondary mb-3">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke OPI
          </a>
        </div>
      </div>

      <!-- Tabel Plan Kirim -->
      <div class="table-responsive shadow rounded-3">
        <table class="table align-middle table-striped table-hover" style="background-color: #fff;">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tanggal Kirim</th>
                    <th scope="col">Customer</th>
                    <th scope="col">PO Customer</th>
                    <th scope="col">No. Kontrak</th>
                    <th scope="col">No OPI</th>
                    <th scope="col">Kode Barang</th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Qty Order</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Gram</th>
                    <th scope="col">Ton</th>
                    <th scope="col">Status Stock</th>
                    <th scope="col">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $index => $item)
                    <tr>
                        <td class="fw-bold">{{ $index + 1 }}</td>
                        <td>
                            @if($item->dt_perubahan !== '' && $item->approve_mkt == 1 && $item->approve_ppic == 1)
                                <span class="badge bg-warning text-dark">{{ date('d M Y', strtotime($item->dt_perubahan)) }}</span>
                                <small class="d-block text-muted">Perubahan</small>
                            @else
                                <span class="badge bg-info">{{ date('d M Y', strtotime($item->tglKirimDt)) }}</span>
                            @endif
                        </td>
                        <td>{{ $item->kontrakm->customer_name ?? '-' }}</td>
                        <td>{{ $item->kontrakm->poCustomer ?? '-' }}</td>
                        <td>{{ $item->kontrakm->kode ?? '-' }}</td>
                        <td class="text-primary fw-bold">{{ $item->NoOPI }}</td>
                        <td class="fw-bold text-success">{{ $item->mc->kodeBarang ?? '-' }}</td>
                        <td>{{ $item->mc->namaBarang ?? '-' }}</td>
                        <td class="text-end">
                            <span class="badge bg-primary">{{ number_format($item->jumlahOrder) }} pcs</span>
                        </td>
                        <td class="text-end">
                            <span class="fw-bold text-{{ $item->stock_indicator ?? 'muted' }}">
                                {{ number_format($item->stock_quantity ?? 0) }} pcs
                            </span>
                            @if(isset($item->stock_difference))
                                <br><small class="text-muted">
                                    {{ $item->stock_difference >= 0 ? '+' : '' }}{{ number_format($item->stock_difference) }}
                                </small>
                            @endif
                        </td>
                        <td class="text-end">
                            <span class="badge bg-secondary">{{ number_format($item->mc->gramSheetBoxKontrak2 ?? 0, 2) }} kg/pcs</span>
                        </td>
                        <td class="text-end">
                            @php
                                $totalKg = ($item->jumlahOrder * ($item->mc->gramSheetBoxKontrak2 ?? 0)) / 1000; // Convert to tons
                            @endphp
                            <span class="fw-bold text-warning">{{ number_format($totalKg, 3) }} ton</span>
                            <br><small class="text-muted">{{ number_format($item->jumlahOrder * ($item->mc->gramSheetBoxKontrak2 ?? 0), 2) }} kg</small>
                        </td>
                        <td class="text-center">
                            @if(isset($item->stock_status))
                                <span class="badge bg-{{ $item->stock_indicator }}">
                                    @if($item->stock_status == 'aman')
                                        <i class="fas fa-check-circle me-1"></i>Aman
                                    @elseif($item->stock_status == 'kurang')
                                        <i class="fas fa-exclamation-triangle me-1"></i>Kurang
                                    @else
                                        <i class="fas fa-times-circle me-1"></i>Habis
                                    @endif
                                </span>
                            @else
                                <span class="badge bg-secondary">-</span>
                            @endif
                        </td>
                        <td>
                            <small>{{ Str::limit($item->dt->keterangan ?? '-', 500) }}</small>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="14" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <h5>Tidak ada data OPI</h5>
                                <p>Tidak ada OPI yang dijadwalkan untuk periode tanggal yang dipilih.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
      </div>
      @else
        <div class="card">
          <div class="card-body text-center py-5">
            <i class="fas fa-calendar-day fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">Pilih Periode Tanggal</h4>
            <p class="text-muted">Silakan pilih tanggal mulai dan tanggal selesai untuk melihat rencana pengiriman OPI.</p>
          </div>
        </div>
      @endif

      @if(isset($data) && count($data) > 0)
      <!-- Summary -->
      <div class="card mt-4">
        <div class="card-header bg-light">
          <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Ringkasan</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-2">
              <div class="text-center">
                <h4 class="text-primary">{{ count($data) }}</h4>
                <small class="text-muted">Total OPI</small>
              </div>
            </div>
            <div class="col-md-2">
              <div class="text-center">
                <h4 class="text-success">{{ number_format($data->sum('jumlahOrder')) }}</h4>
                <small class="text-muted">Total Quantity (pcs)</small>
              </div>
            </div>
            <div class="col-md-2">
              <div class="text-center">
                @php
                    $totalKg = $data->sum(function($item) {
                        return $item->jumlahOrder * ($item->mc->gramSheetBoxKontrak2 ?? 0);
                    });
                    $totalTon = $totalKg / 1000;
                @endphp
                <h4 class="text-warning">{{ number_format($totalTon, 3) }}</h4>
                <small class="text-muted">Total Tonnage (ton)</small>
              </div>
            </div>
            <div class="col-md-2">
              <div class="text-center">
                <h4 class="text-info">{{ $data->unique('kontrakm.customer_name')->count() }}</h4>
                <small class="text-muted">Unique Customers</small>
              </div>
            </div>
            <div class="col-md-2">
              <div class="text-center">
                <h4 class="text-warning">{{ $data->unique('mc.kodeBarang')->count() }}</h4>
                <small class="text-muted">Unique Items</small>
              </div>
            </div>
            <div class="col-md-2">
              <div class="text-center">
                @php
                  $stockAman = $data->where('stock_status', 'aman')->count();
                @endphp
                <h4 class="text-success">{{ $stockAman }}</h4>
                <small class="text-muted">Stock Aman</small>
              </div>
            </div>
            <div class="col-md-2">
              <div class="text-center">
                @php
                  $stockKurang = $data->where('stock_status', 'kurang')->count() + $data->where('stock_status', 'habis')->count();
                @endphp
                <h4 class="text-danger">{{ $stockKurang }}</h4>
                <small class="text-muted">Stock Kurang/Habis</small>
              </div>
            </div>
          </div>
          
          <!-- Tonnage Detail Summary -->
          <div class="row mt-4">
            <div class="col-12">
              <div class="alert alert-info">
                <div class="row text-center">
                  <div class="col-md-3">
                    <h3 class="text-primary mb-1">{{ number_format($totalTon, 3) }}</h3>
                    <strong>Total Tonnage</strong>
                    <small class="d-block text-muted">{{ number_format($totalKg, 2) }} kg</small>
                  </div>
                  <div class="col-md-3">
                    <h3 class="text-success mb-1">{{ number_format($data->sum('jumlahOrder')) }}</h3>
                    <strong>Total Pieces</strong>
                    <small class="d-block text-muted">Semua OPI</small>
                  </div>
                  <div class="col-md-3">
                    @php
                        $avgWeight = $data->count() > 0 ? $totalKg / $data->sum('jumlahOrder') : 0;
                    @endphp
                    <h3 class="text-warning mb-1">{{ number_format($avgWeight, 3) }}</h3>
                    <strong>Avg Weight/pcs</strong>
                    <small class="d-block text-muted">kg per pieces</small>
                  </div>
                  <div class="col-md-3">
                    @php
                        $avgTonnagePerOPI = count($data) > 0 ? $totalTon / count($data) : 0;
                    @endphp
                    <h3 class="text-info mb-1">{{ number_format($avgTonnagePerOPI, 3) }}</h3>
                    <strong>Avg Tonnage/OPI</strong>
                    <small class="d-block text-muted">ton per OPI</small>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Stock Detail Summary -->
          <div class="row mt-4">
            <div class="col-12">
              <h6 class="mb-3"><i class="fas fa-boxes me-2"></i>Detail Status Stock</h6>
              <div class="row">
                @php
                  $stockSummary = $data->groupBy('stock_status')->map(function($items, $status) {
                    return [
                      'count' => $items->count(),
                      'total_qty' => $items->sum('jumlahOrder'),
                      'total_stock' => $items->sum('stock_quantity')
                    ];
                  });
                @endphp
                
                @foreach(['aman' => 'success', 'kurang' => 'warning', 'habis' => 'danger'] as $status => $color)
                  <div class="col-md-4">
                    <div class="card border-{{ $color }}">
                      <div class="card-body text-center">
                        <h5 class="text-{{ $color }}">
                          {{ $stockSummary[$status]['count'] ?? 0 }} OPI
                        </h5>
                        <p class="mb-1">
                          <strong>Kebutuhan:</strong> {{ number_format($stockSummary[$status]['total_qty'] ?? 0) }} pcs<br>
                          <strong>Stock:</strong> {{ number_format($stockSummary[$status]['total_stock'] ?? 0) }} pcs
                        </p>
                        <span class="badge bg-{{ $color }}">Stock {{ ucfirst($status) }}</span>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
      @endif

      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>

@section('javascripts')
<script>
// Print functionality dengan style khusus
window.addEventListener('beforeprint', function() {
    document.title = 'Plan Kirim OPI - {{ $start_date ?? "Custom Date" }} to {{ $end_date ?? "Custom Date" }}';
});

// Auto-hide alert setelah 5 detik
$(document).ready(function() {
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
});

// Reset dates to default (today to +7 days)
function resetDates() {
    const today = new Date();
    const nextWeek = new Date();
    nextWeek.setDate(today.getDate() + 7);
    
    document.getElementById('start_date').value = today.toISOString().split('T')[0];
    document.getElementById('end_date').value = nextWeek.toISOString().split('T')[0];
}

// Validate date range
document.getElementById('start_date').addEventListener('change', function() {
    const startDate = new Date(this.value);
    const endDateInput = document.getElementById('end_date');
    const endDate = new Date(endDateInput.value);
    
    if (endDate < startDate) {
        endDateInput.value = this.value;
    }
});

document.getElementById('end_date').addEventListener('change', function() {
    const endDate = new Date(this.value);
    const startDateInput = document.getElementById('start_date');
    const startDate = new Date(startDateInput.value);
    
    if (startDate > endDate) {
        startDateInput.value = this.value;
    }
});

// Quick date presets
function setDateRange(startOffset, endOffset) {
    const today = new Date();
    const startDate = new Date();
    const endDate = new Date();
    
    startDate.setDate(today.getDate() + startOffset);
    endDate.setDate(today.getDate() + endOffset);
    
    document.getElementById('start_date').value = startDate.toISOString().split('T')[0];
    document.getElementById('end_date').value = endDate.toISOString().split('T')[0];
}
</script>
@endsection
@endsection