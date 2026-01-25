<!-- jQuery -->
<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>

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

.table td, .table th {
    vertical-align: middle;
    padding: 8px;
}

.badge-sisa {
    font-size: 0.9em;
    padding: 0.5em 0.8em;
}

.detail-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 15px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.detail-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}

.detail-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
}

.stat-card {
    text-align: center;
    padding: 25px;
    border-radius: 15px;
    margin-bottom: 20px;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-3px);
}
</style>

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Detail Alokasi Karet</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('karet.index') }}">Alokasi Karet</a></li>
            <li class="breadcrumb-item active">Detail</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      
      <!-- Header Information Card -->
      <div class="detail-header">
        <div class="row align-items-center">
          <div class="col-md-8">
            <h2 class="mb-3">
              <i class="fas fa-info-circle me-2"></i>
              {{ $karet->nama_karet }}
            </h2>
            <div class="row">
              <div class="col-md-6">
                <p class="mb-2"><strong>Customer:</strong> {{ $karet->customer }}</p>
                <p class="mb-2"><strong>Sales:</strong> {{ $karet->sales_name }}</p>
                <p class="mb-2"><strong>No. PO:</strong> {{ $karet->no_po ?? '-' }}</p>
              </div>
              <div class="col-md-6">
                <p class="mb-2"><strong>Kode Barang:</strong> {{ $karet->kode_barang ?? '-' }}</p>
                <p class="mb-2"><strong>GSM:</strong> {{ number_format($karet->gsm, 3) }}</p>
                <p class="mb-2"><strong>Lokasi Kirim:</strong> {{ $karet->lokasi_kirim }}</p>
              </div>
            </div>
          </div>
          <div class="col-md-4 text-end">
            <div class="stat-card bg-white text-dark">
              <h4 class="text-primary mb-1">Rp {{ number_format($karet->harga, 0, ',', '.') }}</h4>
              <p class="mb-0 text-muted">Total Nilai</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Statistics Cards -->
      <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
          <div class="stat-card bg-primary text-white">
            <div class="d-flex align-items-center justify-content-between">
              <div>
                <h4>{{ $transaksi->count() }}</h4>
                <p class="mb-0">Total Transaksi</p>
              </div>
              <i class="fas fa-list fa-2x opacity-75"></i>
            </div>
          </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
          <div class="stat-card bg-success text-white">
            <div class="d-flex align-items-center justify-content-between">
              <div>
                <h4>{{ number_format($transaksi->sum('pcs'), 0) }}</h4>
                <p class="mb-0">Total PCS</p>
              </div>
              <i class="fas fa-boxes fa-2x opacity-75"></i>
            </div>
          </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
          <div class="stat-card bg-info text-white">
            <div class="d-flex align-items-center justify-content-between">
              <div>
                <h4>{{ number_format($karet->alokasi, 0) }}</h4>
                <p class="mb-0">Alokasi (KG)</p>
              </div>
              <i class="fas fa-weight fa-2x opacity-75"></i>
            </div>
          </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
          <div class="stat-card {{ $karet->sisa > 0 ? 'bg-warning' : ($karet->sisa == 0 ? 'bg-secondary' : 'bg-danger') }} text-white">
            <div class="d-flex align-items-center justify-content-between">
              <div>
                <h4>{{ number_format($karet->sisa, 0) }}</h4>
                <p class="mb-0">Sisa Karet</p>
              </div>
              <i class="fas fa-balance-scale fa-2x opacity-75"></i>
            </div>
          </div>
        </div>
      </div>

      <!-- Karet Information Card -->
      <div class="row">
        <div class="col-md-4 mb-4">
          <div class="detail-card">
            <div class="card-header bg-primary text-white">
              <h5 class="mb-0">
                <i class="fas fa-info-circle me-2"></i>
                Informasi Karet
              </h5>
            </div>
            <div class="card-body">
              <table class="table table-borderless">
                <tr>
                  <td><strong>Tanggal Masuk:</strong></td>
                  <td>{{ \Carbon\Carbon::parse($karet->tanggal_masuk)->format('d F Y') }}</td>
                </tr>
                <tr>
                  <td><strong>Harga per KG:</strong></td>
                  <td>Rp {{ number_format($karet->harga_per_kg, 0, ',', '.') }}</td>
                </tr>
                <tr>
                  <td><strong>Tipe:</strong></td>
                  <td>
                    @if($karet->type)
                      <span class="badge bg-secondary">{{ $karet->type }}</span>
                    @else
                      -
                    @endif
                  </td>
                </tr>
                @if($karet->mastercard)
                <tr>
                  <td><strong>Master Card:</strong></td>
                  <td>{{ $karet->mastercard->kode }}</td>
                </tr>
                @endif
              </table>
            </div>
          </div>
        </div>

        <!-- Monthly Transactions -->
        <div class="col-md-8 mb-4">
          <div class="detail-card">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
              <h5 class="mb-0">
                <i class="fas fa-calendar-alt me-2"></i>
                Riwayat Transaksi Per Bulan
              </h5>
              <span class="badge bg-light text-dark">{{ $transaksi->count() }} transaksi</span>
            </div>
            <div class="card-body p-0">
              @if($transaksiPerBulan->count() > 0)
                @foreach($transaksiPerBulan as $monthData)
                <div class="mb-4">
                  <!-- Month Header -->
                  <div class="bg-light p-3 border-bottom">
                    <div class="row align-items-center">
                      <div class="col-md-6">
                        <h6 class="mb-0 text-primary">
                          <i class="fas fa-calendar me-2"></i>
                          {{ $monthData['bulan'] }}
                        </h6>
                      </div>
                      <div class="col-md-6 text-end">
                        <span class="badge bg-info me-2">{{ $monthData['total_pcs'] }} PCS</span>
                        <span class="badge bg-success">Rp {{ number_format($monthData['total_harga'], 0, ',', '.') }}</span>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Month Transactions -->
                  <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                      <thead class="table-light">
                        <tr>
                          <th width="40">#</th>
                          <th>Tanggal</th>
                          <th class="text-center">PCS</th>
                          <th class="text-end">Harga</th>
                          <th>Master Card</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($monthData['transaksi'] as $index => $item)
                        <tr>
                          <td class="text-muted">{{ $index + 1 }}</td>
                          <td>
                            <strong>{{ \Carbon\Carbon::parse($item->tanggal_kirim)->format('d/m/Y') }}</strong>
                            <br>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($item->tanggal_kirim)->format('l') }}</small>
                          </td>
                          <td class="text-center">
                            <span class="badge bg-info" style="font-size: 11px">
                              {{ number_format($item->pcs, 0) }}
                            </span>
                          </td>
                          <td class="text-end">
                            <strong class="text-success">
                              Rp {{ number_format($item->alokasi_harga, 0, ',', '.') }}
                            </strong>
                          </td>
                          <td>
                            @if($item->mastercard)
                              <span class="badge bg-secondary" style="font-size: 10px">{{ $item->mastercard->kode }}</span>
                            @else
                              <span class="text-muted">-</span>
                            @endif
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
                @endforeach
                
                <!-- Overall Total -->
                <div class="bg-primary text-white p-3">
                  <div class="row">
                    <div class="col-md-6">
                      <h6 class="mb-0">
                        <i class="fas fa-calculator me-2"></i>
                        Total Keseluruhan
                      </h6>
                    </div>
                    <div class="col-md-6 text-end">
                      <span class="badge bg-light text-dark me-2">{{ number_format($transaksi->sum('pcs'), 0) }} PCS</span>
                      <span class="badge bg-warning text-dark">Rp {{ number_format($transaksi->sum('alokasi_harga'), 0, ',', '.') }}</span>
                    </div>
                  </div>
                </div>
              @else
                <div class="text-center py-5">
                  <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                  <h6 class="text-muted">Belum Ada Transaksi Alokasi</h6>
                  <p class="text-muted mb-0">Belum ada riwayat transaksi alokasi untuk karet ini.</p>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="row">
        <div class="col-12">
          <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('karet.index') }}" class="btn btn-secondary">
              <i class="fas fa-arrow-left me-2"></i>
              Kembali ke Daftar
            </a>
            
            <div>
              <button class="btn btn-info" onclick="window.print()">
                <i class="fas fa-print me-2"></i>
                Cetak Detail
              </button>
              <a href="#" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>
                Edit
              </a>
            </div>
          </div>
        </div>
      </div>

    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Add any additional JavaScript functionality here
    
    // Example: Add tooltip to badges
    $('[data-toggle="tooltip"]').tooltip();
    
    // Print functionality
    window.printDetail = function() {
        window.print();
    };
});

// Print specific styling
@media print {
    .content-wrapper {
        margin: 0 !important;
        padding: 20px !important;
    }
    
    .btn, .breadcrumb, .content-header {
        display: none !important;
    }
    
    .detail-card {
        box-shadow: none !important;
        border: 1px solid #ddd !important;
    }
}
</script>
@endsection