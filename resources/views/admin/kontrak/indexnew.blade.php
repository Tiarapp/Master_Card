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
</style>

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Kontrak</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Kontrak</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      @if ($message = Session::get('error'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
          <strong>{{ $message }}</strong>
        </div>
      @endif
      <!-- Small boxes (Stat box) -->

      <!-- Control Panel -->
      <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
          <!-- Header Actions Row -->
          <div class="row mb-3">
            <div class="col-12">
              <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <!-- Action Buttons -->
                <div class="d-flex flex-wrap gap-2">
                  <a href="{{ route('kontrak.create') }}" class="btn btn-success d-flex align-items-center shadow-sm">
                    <i class="fas fa-plus-circle me-2"></i>
                    <span>{{ __('Tambah Kontrak') }}</span>
                  </a>
                  <a href="{{ route('job.create') }}" class="btn btn-primary d-flex align-items-center shadow-sm">
                    <i class="fas fa-unlock-alt me-2"></i>
                    <span>{{ __('Request Buka Block') }}</span>
                  </a>
                </div>
                
                <!-- Status Indicators -->
                <div class="d-flex align-items-center gap-2">
                  @if(request('search'))
                    <span class="badge bg-primary">
                      <i class="fas fa-filter me-1"></i>
                      Filter Aktif
                    </span>
                  @endif
                </div>
              </div>
            </div>
          </div>

          <!-- Search & Export Controls Row -->
          <div class="row g-3">
            <!-- Search Section -->
            <div class="col-lg-6">
              <div class="border rounded p-3 h-100" style="background-color: #f8f9fa;">
                <div class="d-flex align-items-center mb-3">
                  <i class="fas fa-search text-primary me-2"></i>
                  <h6 class="mb-0 fw-bold text-dark">Pencarian Data</h6>
                </div>
                
                <form action="{{ route('kontraknew') }}" method="GET" class="row g-2">
                  <div class="col-md-8">
                    <div class="input-group input-group-sm">
                      <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted"></i>
                      </span>
                      <input type="text" class="form-control border-start-0" name="search" 
                             placeholder="{{ __('Cari kontrak, customer, PO, sales...') }}" 
                             value="{{ request('search') }}" autocomplete="off"
                             title="Ketik untuk mencari data kontrak">
                    </div>
                  </div>
                  
                  <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-sm w-100 d-flex align-items-center justify-content-center shadow-sm">
                      <i class="fas fa-search me-1"></i>
                      <span class="d-none d-lg-inline">Cari</span>
                    </button>
                  </div>
                  
                  <div class="col-md-2">
                    <a href="{{ route('kontraknew') }}" class="btn btn-outline-secondary btn-sm w-100 d-flex align-items-center justify-content-center shadow-sm">
                      <i class="fas fa-sync-alt me-1"></i>
                      <span class="d-none d-lg-inline">Reset</span>
                    </a>
                  </div>
                </form>
                
                @if(request('search'))
                  <div class="mt-2">
                    <small class="text-muted">
                      <i class="fas fa-filter me-1"></i>
                      Menampilkan hasil untuk: <strong>"{{ request('search') }}"</strong>
                    </small>
                  </div>
                @endif
              </div>
            </div>

            <!-- Export Section -->
            <div class="col-lg-6">
              <div class="border rounded p-3 h-100" style="background-color: #f0f8f0;">
                <div class="d-flex align-items-center mb-3">
                  <i class="fas fa-file-excel text-success me-2"></i>
                  <h6 class="mb-0 fw-bold text-dark">Export Data</h6>
                </div>
                
                <form action="{{ route('kontrak.export') }}" method="GET" class="row g-2">
                  <!-- Hidden search parameter untuk export dengan filter yang sama -->
                  @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                  @endif
                  
                  <div class="col-md-5">
                    <div class="input-group input-group-sm">
                      <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-calendar-alt text-muted"></i>
                      </span>
                      <input type="date" name="start_date" class="form-control border-start-0" 
                             placeholder="Dari Tanggal" value="{{ request('start_date') }}" 
                             title="Tanggal Mulai">
                    </div>
                  </div>
                  
                  <div class="col-md-5">
                    <div class="input-group input-group-sm">
                      <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-calendar-alt text-muted"></i>
                      </span>
                      <input type="date" name="end_date" class="form-control border-start-0" 
                             placeholder="Sampai Tanggal" value="{{ request('end_date') }}"
                             title="Tanggal Akhir">
                    </div>
                  </div>
                  
                  <div class="col-md-2">
                    <button type="submit" class="btn btn-success btn-sm w-100 d-flex align-items-center justify-content-center shadow-sm"
                            title="{{ request('search') ? 'Export data yang sudah difilter' : 'Export semua data' }}">
                      <i class="fas fa-download me-1"></i>
                      @if(request('search'))
                        <span class="d-none d-lg-inline">Filtered</span>
                      @else
                        <span class="d-none d-lg-inline">Excel</span>
                      @endif
                    </button>
                  </div>
                </form>
                
                @if(request('search'))
                  <div class="mt-2">
                    <small class="text-muted">
                      <i class="fas fa-info-circle me-1"></i>
                      Export akan menggunakan filter: <strong>"{{ request('search') }}"</strong>
                    </small>
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="table-responsive shadow rounded-3">
        <table class="table align-middle table-row-dashed table-row-bordered gy-5 gs-7 fs-6" style="background-color: #fff;">
            <thead>
                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                    <th class="min-w-125px">{{ __('Kode Barang') }}</th>
                    <th class="min-w-125px">{{ __('Status') }}</th>
                    <th class="min-w-125px">{{ __('Action') }}</th>
                    <th class="min-w-150px">{{ __('Tanggal') }}</th>
                    <th class="min-w-150px">{{ __('No MC') }}</th>
                    <th class="min-w-100px">{{ __('Customer') }}</th>
                    <th class="min-w-100px">{{ __('PO Customer') }}</th>
                    <th class="min-w-100px">{{ __('No Kontrak') }}</th>
                    <th class="min-w-100px">{{ __('Nama Barang') }}</th>
                    <th class="min-w-100px">{{ __('Tipe Order') }}</th>
                    <th class="min-w-100px">{{ __('Alamat') }}</th>
                    <th class="min-w-100px">{{ __('Berat(KG)') }}</th>
                    <th class="min-w-100px">{{ __('Harga / PCS') }}</th>
                    <th class="min-w-100px">{{ __('Harga / Kg') }}</th>
                    <th class="min-w-100px">{{ __('QTY Kontrak') }}</th>
                    <th class="min-w-100px">{{ __('Kg Kontrak') }}</th>
                    <th class="min-w-100px">{{ __('Realisasi Kirim') }}</th>
                    <th class="min-w-100px">{{ __('Sisa Kontrak') }}</th>
                    <th class="min-w-100px">{{ __('Sales') }}</th>
                    <th class="min-w-100px">{{ __('Komisi') }}</th>
                    <th class="min-w-100px">{{ __('B. Expedisi') }}</th>
                    <th class="min-w-100px">{{ __('B. Glue Manual') }}</th>
                    <th class="min-w-100px">{{ __('B. Wax') }}</th>
                    {{-- <th class="min-w-100px">{{ __('Kode Barang') }}</th> --}}
                </tr>
            </thead>
            <tbody class="text-gray-900 fw-semibold">
                @foreach ($contracts as $contract)
                    <tr>
                        <td class="text-gray-800 bold">{{ $contract->mc->kodeBarang }}</td>
                        @php
                          $status = $contract->kontrakm->status;
                          switch ($status) {
                            case 1:
                              $colorClass = 'success';
                              $statusText = 'Aktif';
                              break;
                            case 2:
                              $colorClass = 'warning';
                              $statusText = 'Opened';
                              break;
                            case 3:
                              $colorClass = 'info';
                              $statusText = 'Closed';
                              break;
                            case 4:
                              $colorClass = 'success';
                              $statusText = 'Processed';
                              break;
                            case 5:
                              $colorClass = 'danger';
                              $statusText = 'Canceled';
                              break;
                            default:
                              $colorClass = 'other';
                              $statusText = $status;
                          }
                        @endphp
                        <td class="p-10">
                          <span class="label status {{ $colorClass }}">{{ $statusText }}</span>
                        </td>
                        <td>
                              <a href="{{ route('kontrak.pdfb1', $contract->kontrak_m_id) }}"
                                 class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1 shadow-sm mt-1"
                                 title="Cetak Kontrak">
                                <i class="fas fa-print"></i>
                                <span>Print</span>
                              </a>
                              <a href="{{ route('kontrak.dt', $contract->kontrak_m_id) }}"
                                 class="btn btn-outline-info btn-sm d-flex align-items-center gap-1 shadow-sm mt-1"
                                 title="Detail DT">
                                <i class="fas fa-file-alt"></i>
                                <span>DT</span>
                              </a>
                              <a href="{{ route('kontrak.realisasi', $contract->kontrak_m_id) }}"
                                 class="btn btn-outline-success btn-sm d-flex align-items-center gap-1 shadow-sm mt-1"
                                 title="Realisasi Pengiriman">
                                <i class="fas fa-truck"></i>
                                <span>Kirim</span>
                              </a>
                              <a href="{{ route('kontrak.cancel', $contract->kontrak_m_id) }}"
                                 class="btn btn-outline-danger btn-sm d-flex align-items-center gap-1 shadow-sm mt-1"
                                 title="Cancel Kontrak">
                                <i class="fas fa-times-circle"></i>
                                <span>Cancel</span>
                              </a>
                            @if ($contract->kontrakm->status == 2)
                              <a href="{{ route('kontrak.edit', $contract->kontrak_m_id) }}"
                                 class="btn btn-outline-warning btn-sm d-flex align-items-center gap-1 shadow-sm mt-1"
                                 title="Edit Kontrak">
                                <i class="fas fa-edit"></i>
                                <span>Edit</span>
                              </a>
                            @endif
                        </td>
                        <td class="text-{{ $contract->kontrakm->status == 4 ? 'black' : $colorClass }} fw-semibold">{{ \Carbon\Carbon::parse($contract->kontrakm->tglKontrak)->format('d-m-Y') }}</td>
                        <td class="text-{{ $contract->kontrakm->status == 4 ? 'black' : $colorClass }} fw-semibold">
                          {{ $contract->mc->revisi == "R0" ? $contract->mc->kode : $contract->mc->kode .'-' . $contract->mc->revisi }}
                        </td>
                        <td class="text-{{ $contract->kontrakm->status == 4 ? 'black' : $colorClass }} fw-semibold">{{ $contract->kontrakm->customer_name??'-' }}</td>
                        <td class="text-{{ $contract->kontrakm->status == 4 ? 'black' : $colorClass }} fw-semibold">{{ $contract->kontrakm->poCustomer }}</td>
                        <td class="text-{{ $contract->kontrakm->status == 4 ? 'black' : $colorClass }} fw-semibold">{{ $contract->kontrakm->kode }}</td>
                        <td class="text-{{ $contract->kontrakm->status == 4 ? 'black' : $colorClass }} fw-semibold">{{ $contract->mc->namaBarang }}</td>
                        <td class="text-{{ $contract->kontrakm->status == 4 ? 'black' : $colorClass }} fw-semibold">{{ $contract->kontrakm->tipeOrder }}</td>
                        <td class="text-{{ $contract->kontrakm->status == 4 ? 'black' : $colorClass }} fw-semibold">{{ $contract->kontrakm->alamatKirim }}</td>
                        <td class="text-{{ $contract->kontrakm->status == 4 ? 'black' : $colorClass }} fw-semibold">{{ $contract->mc->gramSheetBoxKontrak }}</td>
                        <td class="text-{{ $contract->kontrakm->status == 4 ? 'black' : $colorClass }} fw-semibold">{{ $contract->harga_pcs }}</td>
                        <td class="text-{{ $contract->kontrakm->status == 4 ? 'black' : $colorClass }} fw-semibold">{{ $contract->harga_pcs ? number_format($contract->harga_pcs / $contract->mc->gramSheetBoxKontrak, 2) : 0 }}</td>
                        <td class="text-{{ $contract->kontrakm->status == 4 ? 'black' : $colorClass }} fw-semibold">{{ $contract->pcsKontrak }}</td>
                        <td class="text-{{ $contract->kontrakm->status == 4 ? 'black' : $colorClass }} fw-semibold">{{ $contract->kgKontrak }}</td>
                        <td class="text-{{ $contract->kontrakm->status == 4 ? 'black' : $colorClass }} fw-semibold">
                          @if ($contract->kontrakm->realisasi)
                            @foreach ($contract->kontrakm->realisasi as $data )
                              <li>{{ $data->qty_kirim .' ('. $data->tanggal_kirim.')' }}</li>
                            @endforeach
                          @endif
                        </td>
                        <td class="text-{{ $contract->kontrakm->status == 4 ? 'black' : $colorClass }} fw-semibold">
                          {{ $contract->pcsKontrak - ($contract->kontrakm->realisasi ? $contract->kontrakm->realisasi->sum('qty_kirim') : 0) }}
                        </td>
                        <td class="text-{{ $contract->kontrakm->status == 4 ? 'black' : $colorClass }} fw-semibold">{{ $contract->kontrakm->sales }}</td>
                        <td class="text-{{ $contract->kontrakm->status == 4 ? 'black' : $colorClass }} fw-semibold">
                          @if (Auth::user()->divisi_id == 2)
                            {{ $contract->kontrakm->komisi ?? '-' }}
                          @endif
                        </td>
                        <td class="text-{{ $contract->kontrakm->status == 4 ? 'black' : $colorClass }} fw-semibold">{{ $contract->kontrakm->biaya_exp }}</td>
                        <td class="text-{{ $contract->kontrakm->status == 4 ? 'black' : $colorClass }} fw-semibold">{{ $contract->kontrakm->biaya_glue }}</td>
                        <td class="text-{{ $contract->kontrakm->status == 4 ? 'black' : $colorClass }} fw-semibold">{{ $contract->kontrakm->biaya_wax }}</td>
                        {{-- <td class="text-{{ $colorClass }} fw-semibold">{{ $contract->mc->kodeBarang }}</td> --}}
                        {{-- <td>
                            <a href="{{ route('contract.show', $contract->id) }}" class="btn btn-light-primary btn-sm me-lg-n7"><i class="ki-outline ki-eye"></i>View</a>
                        </td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $contracts->appends(request()->query())->links('pagination::bootstrap-4') }}
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
  @endsection