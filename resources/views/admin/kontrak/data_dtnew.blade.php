@extends('admin.templates.partials.default')

@push('styles')
<!-- Optimized CSS for data_dtnew page -->
<link rel="stylesheet" href="{{ asset('css/data-dtnew.css') }}">
@endpush

@section('content')

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
        @include('admin.kontrak.edit_opi')
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
                            @if ($kontrak->mc && ($kontrak->mc->revisi == "R0" || $kontrak->mc->revisi == null))
                                {{ $kontrak->mc->kode ?? 'N/A' }}
                            @elseif ($kontrak->mc)
                                {{ $kontrak->mc->kode ?? 'N/A' }}-{{ $kontrak->mc->revisi ?? '' }}
                            @else
                                N/A
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
                          <div class="font-weight-bold">{{ $kontrak->mc->substancekontrak->kode ?? 'N/A' }}</div>
                        </div>
                      </div>
                    </div>
                    <div class="info-item mb-3">
                      <div class="d-flex align-items-center">
                        <i class="fas fa-industry text-warning mr-2"></i>
                        <div>
                          <small class="text-muted">Substance Produksi</small>
                          <div class="font-weight-bold">{{ $kontrak->mc->substanceproduksi->kode ?? 'N/A' }}</div>
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
                          <div class="font-weight-bold">{{ $kontrak->mc->gramSheetBoxKontrak2 ?? 0 }} gr</div>
                        </div>
                      </div>
                    </div>
                    <div class="info-item mb-3">
                      <div class="d-flex align-items-center">
                        <i class="fas fa-weight text-secondary mr-2"></i>
                        <div>
                          <small class="text-muted">Gram Sheet Box Produksi</small>
                          <div class="font-weight-bold">{{ $kontrak->mc->gramSheetBoxProduksi2 ?? 0 }} gr</div>
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
                          <div class="font-weight-bold">{{ $kontrak->mc->outConv ?? 1 }}</div>
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
                  $progress = 0;
                  if ($kontrak->kontrakm->realisasi && $kontrak->pcsKontrak > 0) {
                    $progress = number_format((int)$kontrak->kontrakm->realisasi->sum('qty_kirim') / $kontrak->pcsKontrak * 100, 2);
                  }
                  // Ensure progress doesn't exceed 100%
                  $progress = min($progress, 100);
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
              <!-- Primary Button untuk Tambah DT & OPI -->
              <button type="button" class="btn btn-primary btn-sm opi" data-toggle="modal" data-target="#add_dt" id="btnTambahDT">
                <i class="fas fa-plus mr-1"></i> Tambah DT & OPI
              </button>
                
              <!-- Button untuk refresh -->
              <a href="{{ route('kontrak.recall', $kontrak->kontrak_m_id) }}">
                <button type="button" class="btn btn-info btn-sm ml-2">
                  <i class="fas fa-sync-alt mr-1"></i> Refresh
                </button>
              </a>
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
                    <th scope="col" class="text-center">
                      <i class="fas fa-box-open mr-1"></i>
                      Status
                    </th>
                    <th scope="col" class="text-center">
                      <i class="fas fa-box-open mr-1"></i>
                      Keterangan Kirim
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
                        {{ $data->dt_id ? date('d/m/Y', strtotime($data->dt->tglKirimDt)) : '' }}
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
                        {{ number_format((float)$data->jumlahOrder * (float)($kontrak->mc->gramSheetBoxKontrak2 ?? 0), 2) }} kg
                      </span>
                    </td>
                    <td class="text-center">
                      <span class="text-success font-weight-bold">
                        @php
                          $rm = 0;
                          
                          // Check for valid data before calculations
                          if ($data->outConv > 0 && $data->lebarSheet > 0) {
                            $qty = ($data->jumlahOrder) / $data->outConv;
                            $outCorr = floor(2500 / $data->lebarSheet);
                            
                            if ($outCorr > 0) {
                              $cop = $qty / $outCorr;
                              $rm = ($data->panjangSheet * $cop) / 1000;
                            }
                          }
                          
                          echo number_format((float)$rm, 2);
                        @endphp
                      </span>
                    </td>
                    <td class="text-center">
                      <span class="badge {{ $data->status_opi == 'Pending' ? 'badge-warning' : ($data->status_opi == 'Proses' ? 'badge-success' : 'badge-secondary') }} font-weight-bold">
                        {{ $data->status_opi == 'Pending' ? 'Tunggu Approve' : $data->status_opi }}
                      </span>
                    </td>
                    <td class="text-center">
                      <span class="text-success font-weight-bold">
                        {{ $data->dt ? $data->dt->keterangan : '' }}
                      </span>
                    </td>
                    <td class="text-center">
                      <div class="btn-group" role="group">
                        <button type="button" class="btn btn-info btn-sm" title="Lihat Detail" onclick="viewOpiDetail({{ $data->id }})">
                          <i class="fas fa-eye"></i>
                        </button>
                        <button type="button" class="btn btn-warning btn-sm" title="Edit" onclick="editOpi({{ $data->id }})" data-toggle="modal" data-target="#edit_opi">
                          <i class="fas fa-edit"></i>
                        </button>
                        <form action="{{ route('opi.cancel', $data->id) }}" method="GET" style="display:inline;">
                          @csrf
                          <button type="submit" class="btn btn-danger btn-sm" title="Cancel" onclick="return confirm('Yakin ingin cancel data ini?')">
                            <i class="fas fa-ban"></i>
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
                        <button type="button" class="btn btn-primary opi" data-toggle="modal" data-target="#add_dt">
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
                        {{ number_format($opi->sum('jumlahOrder') * (float)($kontrak->mc->gramSheetBoxKontrak2 ?? 0), 2) }} kg
                      </span>
                    </th>
                    <th colspan="4"></th>
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
<script>
// Optimized JavaScript for data_dtnew page
$(document).ready(function() {
    // Performance optimization: Debounce AJAX calls
    let ajaxTimeout;
    
    // Event handler untuk modal OPI dengan optimasi
    $('.opi').on('click', function(e) {
        e.preventDefault();
        
        $('#add_dt').modal('show');
        
        // const btn = $(this);
        // const originalText = btn.html();
        
        // // Add loading state
        // btn.prop('disabled', true)
        //    .html('<i class="fas fa-spinner fa-spin"></i> Loading...');
        
        // // Clear previous timeout
        // if (ajaxTimeout) {
        //     clearTimeout(ajaxTimeout);
        // }
        
        // // Always get OPI number from database sequence
        // ajaxTimeout = setTimeout(function() {
        //       complete: function() {
        //           btn.prop('disabled', false).html(originalText);
        //           $('#add_dt').modal('show');
        //       }
        //   });
        // }, 300);
    });

    // Modal events
    $('#add_dt').on('shown.bs.modal', function(e) {
        $('#tglKirim').focus();
    });
    
    $('#add_dt').on('hidden.bs.modal', function(e) {
        $('#jquery-val-form')[0].reset();
    });

    // Performance: Initialize tooltips only when needed
    if (window.innerWidth > 768) {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: 'hover',
            delay: { show: 500, hide: 100 }
        });
    }
});

// Edit OPI function
function editOpi(opiId) {
    // Fetch OPI data
    $.ajax({
        url: '/admin/opi/edit/' + opiId,
        type: 'GET',
        beforeSend: function() {
            // Show loading state
            $('#edit_opi .modal-body').addClass('text-center').html('<i class="fas fa-spinner fa-spin fa-2x text-primary"></i><br><br>Memuat data...');
        },
        success: function(response) {
            if (response.success) {
                const data = response.data;
                
                // Restore modal content and remove loading class
                $('#edit_opi .modal-body').removeClass('text-center').html(`
                    <div class="row">
                        <!-- OPI Information -->
                        <div class="col-md-6">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0">
                                        <i class="fas fa-file-alt mr-1"></i>
                                        Informasi OPI
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="edit_noopi" class="form-label">
                                            <i class="fas fa-hashtag mr-1"></i>
                                            No OPI
                                        </label>
                                        <input type="text" class="form-control" id="edit_noopi" name="NoOPI" readonly>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="edit_customer" class="form-label">
                                            <i class="fas fa-building mr-1"></i>
                                            Customer
                                        </label>
                                        <input type="text" class="form-control" id="edit_customer" readonly>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="edit_namabarang" class="form-label">
                                            <i class="fas fa-box mr-1"></i>
                                            Nama Barang
                                        </label>
                                        <input type="text" class="form-control" id="edit_namabarang" readonly>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="edit_jumlahorder" class="form-label">
                                            <i class="fas fa-sort-numeric-up mr-1"></i>
                                            Jumlah Order (Pcs) <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" class="form-control" id="edit_jumlahorder" name="jumlahOrder" required min="1" readonly>
                                        <small class="form-text text-muted">Masukkan jumlah order dalam pieces</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- DT Information -->
                        <div class="col-md-6">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h6 class="mb-0">
                                        <i class="fas fa-truck mr-1"></i>
                                        Informasi Delivery Time
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="edit_tglkirim" class="form-label">
                                            <i class="fas fa-calendar-alt mr-1"></i>
                                            Tanggal Kirim <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" class="form-control" id="edit_tglkirim" name="tglKirimDt" required>
                                        <small class="form-text text-muted">Pilih tanggal pengiriman yang diinginkan</small>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="edit_pcsdt" class="form-label">
                                            <i class="fas fa-boxes mr-1"></i>
                                            Quantity DT (Pcs) <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" class="form-control" id="edit_pcsdt" name="pcsDt" required min="1" readonly>
                                        <small class="form-text text-muted">Biasanya sama dengan jumlah order OPI</small>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-info-circle mr-1"></i>
                                            Status OPI
                                        </label>
                                        <input type="text" class="form-control" id="edit_status" readonly>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="edit_keterangan_opi" class="form-label">
                                            <i class="fas fa-comment mr-1"></i>
                                            Keterangan OPI
                                        </label>
                                        <textarea class="form-control" id="edit_keterangan_opi" name="keterangan" rows="3" placeholder="Tambahkan keterangan untuk OPI ini..."></textarea>
                                    </div>
                                    
                                    <!-- Info Display -->
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        <strong>Data berhasil dimuat</strong>
                                        <div class="mt-2">
                                            <small>Silakan edit data sesuai kebutuhan.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Warning Alert -->
                    <div class="alert alert-warning mt-3">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>Perhatian:</strong> 
                        Pastikan data yang Anda ubah sudah benar. Perubahan akan mempengaruhi laporan dan kalkulasi terkait.
                    </div>
                `);
                
                // Fill form with data
                $('#edit_noopi').val(data.NoOPI);
                $('#edit_customer').val(data.customer_name);
                $('#edit_namabarang').val(data.namaBarang);
                $('#edit_jumlahorder').val(data.jumlahOrder);
                $('#edit_keterangan_opi').val(data.keterangan);
                $('#edit_tglkirim').val(data.tglKirimDt);
                $('#edit_pcsdt').val(data.pcsDt);
                $('#edit_status').val(data.status_opi);
                
                // Set form action
                $('#edit-opi-form').attr('action', '/admin/opi/update/' + opiId);
                
                // Auto-sync quantity fields
                $('#edit_jumlahorder').on('input', function() {
                    $('#edit_pcsdt').val(this.value);
                });
                
            } else {
                $('#edit_opi .modal-body').html('<div class="alert alert-danger"><i class="fas fa-exclamation-triangle mr-2"></i>Gagal memuat data: ' + response.message + '</div>');
            }
        },
        error: function(xhr, status, error) {
            $('#edit_opi .modal-body').html('<div class="alert alert-danger"><i class="fas fa-exclamation-triangle mr-2"></i>Terjadi kesalahan saat memuat data OPI</div>');
            console.error('Error:', error);
        }
    });
}

// View OPI Detail function
function viewOpiDetail(opiId) {
    // Redirect to OPI print/detail page
    window.open('/admin/opi/print/' + opiId, '_blank');
}

// Form validation function
function validateForm() {
    const jumlahKirim = parseInt($('#jumlahKirim').val()) || 0;
    const sisaKontrak = parseInt($('#sisaKontrak').val()) || 0;
    
    if (jumlahKirim > sisaKontrak) {
        alert('Jumlah kirim tidak boleh melebihi sisa kontrak (' + sisaKontrak.toLocaleString() + ')!');
        return false;
    }
    
    if (jumlahKirim <= 0) {
        alert('Jumlah kirim harus lebih dari 0!');
        return false;
    }
    
    const tglKirim = $('#tglKirim').val();
    if (!tglKirim) {
        alert('Tanggal kirim harus diisi!');
        return false;
    }
    
    return true;
}

// Memory cleanup on page unload
$(window).on('beforeunload', function() {
    if (typeof ajaxTimeout !== 'undefined') {
        clearTimeout(ajaxTimeout);
    }
    $('.opi').off('click');
    $('[data-toggle="tooltip"]').tooltip('dispose');
});
</script>
@endsection