@extends('admin.templates.partials.default')

@section('content')
<!-- Preload Critical CSS -->
<style>
/* Critical CSS for preventing FOUC */
.content-wrapper {
  min-height: 100vh;
}

.info-item {
  padding: 0.5rem;
  border-radius: 0.375rem;
  transition: all 0.3s ease;
}

.card-outline {
  border-top: 3px solid;
}

.card-primary.card-outline {
  border-top-color: #007bff;
}

.card-info.card-outline {
  border-top-color: #17a2b8;
}

.card-success.card-outline {
  border-top-color: #28a745;
}

.badge-lg {
  font-size: 0.875rem;
  padding: 0.375rem 0.75rem;
}

.progress-sm {
  height: 0.5rem;
}

/* Enhanced UI Styles - Loaded after content for better performance */
.info-item:hover {
  background-color: #f8f9fa;
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.badge-outline-secondary {
  color: #6c757d;
  border: 1px solid #6c757d;
  background-color: transparent;
}

.animate-row {
  transition: all 0.3s ease;
}

.animate-row:hover {
  background-color: #f1f3f4;
  transform: scale(1.01);
}

.empty-state {
  padding: 2rem;
  color: #6c757d;
}

.thead-light th {
  background-color: #f8f9fa;
  border-color: #dee2e6;
  font-weight: 600;
  font-size: 0.875rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.table-hover tbody tr:hover {
  background-color: rgba(0,123,255,0.05);
}

.loading-spinner {
  display: none;
  text-align: center;
  padding: 2rem;
}

.spinner-border-sm {
  width: 1rem;
  height: 1rem;
}

.card {
  transition: all 0.3s ease;
  border: none;
  box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
}

.card:hover {
  box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
  transform: translateY(-2px);
}

.btn-group .btn {
  margin: 0 1px;
}

.btn-sm {
  font-size: 0.75rem;
  padding: 0.25rem 0.5rem;
}

.badge {
  font-weight: 500;
  letter-spacing: 0.5px;
}

.progress-bar {
  transition: width 1s ease-in-out;
}

/* Responsive Enhancements */
@media (max-width: 768px) {
  .card-tools {
    margin-top: 0.5rem;
  }
  
  .btn-group {
    display: flex;
    flex-direction: column;
  }
  
  .btn-group .btn {
    margin: 1px 0;
  }
  
  .table-responsive {
    font-size: 0.875rem;
  }
}

/* Smooth Animations */
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

.animate-row {
  animation: fadeIn 0.5s ease forwards;
}

.fas, .far {
  width: 1rem;
  text-align: center;
}

.alert {
  border: none;
  border-radius: 0.5rem;
  box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
}
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">
              <i class="fas fa-file-contract text-primary mr-2"></i>
              Data DT & OPI
            </h1>
            <p class="text-muted mb-0">Manajemen Data Delivery Time & Order Production Instruction</p>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <a href="#" class="text-decoration-none">
                  <i class="fas fa-home mr-1"></i>Home
                </a>
              </li>
              <li class="breadcrumb-item">
                <a href="#" class="text-decoration-none">Kontrak</a>
              </li>
              <li class="breadcrumb-item active">Data DT & OPI</li>
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
        @include('admin.kontrak.adddt')
        <!-- Info Cards Row -->
        <div class="row mb-4">
          <!-- Contract Information Card -->
          <div class="col-lg-8">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-file-contract mr-2"></i>
                  Informasi Kontrak
                </h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="info-item mb-3">
                      <div class="d-flex align-items-center">
                        <i class="fas fa-barcode text-primary mr-2"></i>
                        <div>
                          <small class="text-muted">Kode Kontrak</small>
                          <div class="font-weight-bold">{{ $kontrak->kontrakm->kode }}</div>
                        </div>
                      </div>
                    </div>
                    <div class="info-item mb-3">
                      <div class="d-flex align-items-center">
                        <i class="fas fa-cube text-info mr-2"></i>
                        <div>
                          <small class="text-muted">Master Card</small>
                          <div class="font-weight-bold">
                            @if ($kontrak->mc->revisi == "R0" || $kontrak->mc->revisi == null)
                                {{ $kontrak->mc->kode }}
                            @else
                                {{ $kontrak->mc->kode }}-{{ $kontrak->mc->revisi }}
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="info-item mb-3">
                      <div class="d-flex align-items-center">
                        <i class="fas fa-layer-group text-success mr-2"></i>
                        <div>
                          <small class="text-muted">Substance Kontrak</small>
                          <div class="font-weight-bold">{{ $kontrak->mc->substancekontrak->kode }}</div>
                        </div>
                      </div>
                    </div>
                    <div class="info-item mb-3">
                      <div class="d-flex align-items-center">
                        <i class="fas fa-industry text-warning mr-2"></i>
                        <div>
                          <small class="text-muted">Substance Produksi</small>
                          <div class="font-weight-bold">{{ $kontrak->mc->substanceproduksi->kode }}</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="info-item mb-3">
                      <div class="d-flex align-items-center">
                        <i class="fas fa-weight text-secondary mr-2"></i>
                        <div>
                          <small class="text-muted">Gram Sheet Box Kontrak</small>
                          <div class="font-weight-bold">{{ $kontrak->mc->gramSheetBoxKontrak2 }} gr</div>
                        </div>
                      </div>
                    </div>
                    <div class="info-item mb-3">
                      <div class="d-flex align-items-center">
                        <i class="fas fa-weight text-secondary mr-2"></i>
                        <div>
                          <small class="text-muted">Gram Sheet Box Produksi</small>
                          <div class="font-weight-bold">{{ $kontrak->mc->gramSheetBoxProduksi2 }} gr</div>
                        </div>
                      </div>
                    </div>
                    <div class="info-item mb-3">
                      <div class="d-flex align-items-center">
                        <i class="fas fa-cubes text-primary mr-2"></i>
                        <div>
                          <small class="text-muted">Quantity bisa di OPI kan</small>
                          <div class="font-weight-bold">{{ number_format($kontrak->pcsSisaKontrak) }}</div>
                        </div>
                      </div>
                    </div>
                    <div class="info-item mb-3">
                      <div class="d-flex align-items-center">
                        <i class="fas fa-exchange-alt text-danger mr-2"></i>
                        <div>
                          <small class="text-muted">Out Conv</small>
                          <div class="font-weight-bold">{{ $kontrak->mc->outConv }}</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Summary Statistics Card -->
          <div class="col-lg-4">
            <div class="card card-info card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-2"></i>
                  Ringkasan Kontrak
                </h3>
              </div>
              <div class="card-body p-0">
                <!-- Progress Bar -->
                @php
                  $progress = $kontrak->kontrakm->realisasi ? number_format((int)$kontrak->kontrakm->realisasi->sum('qty_kirim') / $kontrak->pcsKontrak * 100, 2) : 0;
                //   var_dump($progress);
                @endphp
                <div class="p-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-sm font-weight-bold">Progress Pengiriman</span>
                    <span class="badge badge-{{ $progress >= 100 ? 'success' : ($progress >= 50 ? 'warning' : 'danger') }}">
                      {{ number_format($progress < 100 ? $progress : 100, 1) }}%
                    </span>
                  </div>
                  <div class="progress progress-sm">
                    <div class="progress-bar bg-{{ $progress >= 100 ? 'success' : ($progress >= 50 ? 'warning' : 'danger') }}" 
                         style="width: {{ min($progress, 100) }}%"></div>
                  </div>
                </div>
                
                <!-- Quantities in Pieces -->
                <div class="p-3 border-bottom">
                  <h6 class="text-muted mb-2">
                    <i class="fas fa-boxes mr-1"></i>
                    Dalam Pieces (Pcs)
                  </h6>
                  <div class="small">
                    <div class="d-flex justify-content-between">
                      <span>Kontrak:</span>
                      <strong class="text-primary">{{ number_format((int)$kontrak->pcsKontrak) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                      <span>Terkirim:</span>
                      <strong class="text-success">{{ number_format($kontrak->kontrakm->realisasi->sum('qty_kirim')) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                      <span>Sisa:</span>
                    <strong class="text-warning">{{ number_format((int)$kontrak->pcsKontrak - (int)$kontrak->kontrakm->realisasi->sum('qty_kirim')) }}</strong>
                    </div>
                  </div>
                </div>
                
                <!-- Quantities in Kilograms -->
                <div class="p-3">
                  <h6 class="text-muted mb-2">
                    <i class="fas fa-weight-hanging mr-1"></i>
                    Dalam Kilogram (Kg)
                  </h6>
                  <div class="small">
                    <div class="d-flex justify-content-between">
                      <span>Kontrak:</span>
                      <strong class="text-primary">{{ number_format((float)$kontrak->kgKontrak, 2) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                      <span>Terkirim:</span>
                      <strong class="text-success">{{ number_format((float)$kontrak->kontrakm->realisasi->sum('kg_kirim'), 2) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                      <span>Sisa:</span>
                      <strong class="text-warning">{{ number_format((float)$kontrak->kgKontrak - (float)$kontrak->kontrakm->realisasi->sum('kg_kirim'), 2) }}</strong>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Data Table Card -->
        <div class="card card-success card-outline">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-shipping-fast mr-2"></i>
              Data DT & OPI
            </h3>
            <div class="card-tools">
              <button type="button" class="btn btn-primary btn-sm opi" data-toggle="modal" data-target="#add_dt">
                <i class="fas fa-plus mr-1"></i> Tambah DT & OPI
              </button>
                
              <button type="button" class="btn btn-info btn-sm ml-2" onclick="refreshTable()">
                <i class="fas fa-sync-alt mr-1"></i> Refresh
              </button>
            </div>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover table-striped mb-0" id="data_dt">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="text-center">
                      <i class="fas fa-hashtag mr-1"></i>
                      No OPI
                    </th>
                    <th scope="col" class="text-center">
                      <i class="fas fa-calendar-alt mr-1"></i>
                      Tanggal Kirim
                    </th>
                    <th scope="col" class="text-center">
                      <i class="fas fa-boxes mr-1"></i>
                      Qty OPI (Pcs)
                    </th>
                    <th scope="col" class="text-center">
                      <i class="fas fa-weight-hanging mr-1"></i>
                      Qty OPI (Kg)
                    </th>
                    <th scope="col" class="text-center">
                      <i class="fas fa-box-open mr-1"></i>
                      Running Meter
                    </th>
                    {{-- <th scope="col" class="text-center">
                      <i class="fas fa-balance-scale mr-1"></i>
                      Sisa (Kg)
                    </th> --}}
                    <th scope="col" class="text-center">
                      <i class="fas fa-cogs mr-1"></i>
                      Action
                    </th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ( $opi as $data)
                      
                  <tr class="animate-row">
                    <td class="text-center font-weight-bold text-primary">
                      <i class="fas fa-file-alt mr-1"></i>
                      {{ $data->NoOPI }}
                    </td>
                    <td class="text-center">
                      <span class="badge badge-outline-secondary">
                        <i class="fas fa-calendar mr-1"></i>
                        {{ date('d/m/Y', strtotime($data->dt->tglKirimDt)) }}
                      </span>
                    </td>
                    <td class="text-center">
                      <span class="badge badge-success badge-lg">
                        <i class="fas fa-arrow-up mr-1"></i>
                        {{ number_format((int)$data->jumlahOrder) }}
                      </span>
                    </td>
                    <td class="text-center">
                      <span class="text-success font-weight-bold">
                        {{ number_format((float)$data->jumlahOrder * (float)$kontrak->mc->gramSheetBoxKontrak2, 2) }} kg
                      </span>
                    </td>
                    <td class="text-center">
                      <span class="text-success font-weight-bold">
                        @php
                          $qty = ($data->jumlahOrder) / $data->outConv ; 
                          $outCorr = floor(2500/$data->lebarSheet);
                          $cop = $qty / $outCorr;
                          $rm = ($data->panjangSheet * $cop) / 1000;

                          echo number_format((float)$rm, 2);
                        @endphp
                      </span>
                    </td>
                    <td class="text-center">
                      <div class="btn-group" role="group">
                        {{-- <button type="button" class="btn btn-info btn-sm" title="Lihat Detail">
                          <i class="fas fa-eye"></i>
                        </button>
                        <button type="button" class="btn btn-warning btn-sm" title="Edit">
                          <i class="fas fa-edit"></i>
                        </button> --}}
                        <form action="{{ route('opi.cancel', $data->id) }}" method="GET" style="display:inline;">
                          @csrf
                          {{-- @method('PUT') --}}
                          <button type="submit" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Yakin ingin cancel data ini?')">
                            <i class="fas fa-trash"></i>
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                  @empty 
                  <tr>
                    <td colspan="7" class="text-center py-5">
                      <div class="empty-state">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum Ada Data DT & OPI</h5>
                        <p class="text-muted">Klik tombol "Tambah DT & OPI" untuk menambahkan data baru.</p>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_dt">
                          <i class="fas fa-plus mr-1"></i> Tambah Data Pertama
                        </button>
                      </div>
                    </td>
                  </tr>
                  @endforelse
                </tbody>
                @if($opi->count() > 0)
                <tfoot class="thead-light">
                  <tr>
                    <th colspan="2" class="text-center font-weight-bold">TOTAL</th>
                    <th class="text-center">
                      <span class="badge badge-success badge-lg">
                        {{ number_format($opi->sum('jumlahOrder')) }}
                      </span>
                    </th>
                    <th class="text-center">
                      <span class="text-success font-weight-bold">
                        {{ number_format($opi->sum('jumlahOrder') * (float)$kontrak->mc->gramSheetBoxKontrak2, 2) }} kg
                      </span>
                    </th>
                    <th colspan="3"></th>
                  </tr>
                </tfoot>
                @endif
              </table>
            </div>
          </div>
          @if($opi->count() > 0)
          <div class="card-footer bg-light">
            <div class="row">
              <div class="col-sm-6">
                <small class="text-muted">
                  <i class="fas fa-info-circle mr-1"></i>
                  Menampilkan {{ $opi->count() }} data OPI 
                </small>
              </div>
              <div class="col-sm-6 text-right">
                <small class="text-muted">
                  <i class="fas fa-clock mr-1"></i>
                  Terakhir diperbarui: {{ now()->format('d/m/Y H:i') }}
                </small>
              </div>
            </div>
          </div>
          @endif
        </div>
        <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection

@section('javascripts')

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
$(document).ready(function() {
    // Event handler untuk modal OPI dengan optimasi
    $('.opi').on('click', function() {
        const btn = $(this);
        btn.addClass('btn-loading');
        
        $.ajax({
            url: "{{ route('nomer_opi') }}",
            type: "GET",
            timeout: 5000, // 5 detik timeout
            success: function(response) {
                $('#nomer_opi').val(response.nomer);

                console.log(response);
                
                
                // Set data lain
                // $('#idkontrakm').val("{{ $kontrak->kontrakm->id }}");
                // $('#kode').val("{{ $kontrak->kontrakm->kode }}");
                // $('#sisa').val($('#sisa').val());
                // $('#sisa_kirim').val($('#sisa_kirim').val());
            },
            error: function() {
                alert('Gagal mengambil nomer OPI. Silakan coba lagi.');
            },
            complete: function() {
                btn.removeClass('btn-loading');
            }
        });
    });
});
</script>