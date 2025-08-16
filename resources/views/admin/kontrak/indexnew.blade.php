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
      @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
          <strong>{{ $message }}</strong>
        </div>
      @endif
      <!-- Small boxes (Stat box) -->

      <div class="row mb-4 align-items-center">
        <div class="col-auto d-flex align-items-center gap-3">
          <a href="{{ route('kontrak.create') }}" class="btn btn-success d-flex align-items-center shadow-sm" style="margin-bottom: 20px;">
            <i class="fas fa-plus-circle me-2"></i>
            <span>{{ __('Tambah Kontrak') }}</span>
          </a>
          <a href="{{ route('job.create') }}" class="btn btn-primary d-flex align-items-center shadow-sm" style="margin-bottom: 20px;">
            <i class="fas fa-unlock-alt me-2"></i>
            <span>{{ __('Request Buka Block') }}</span>
          </a>
        </div>
        <div class="col text-end">
          <form class="d-flex align-items-center justify-content-end gap-2" action="{{ route('kontraknew') }}" method="GET" style="margin-bottom: 20px;">
            <div class="input-group" style="max-width: 350px;">
              <span class="input-group-text bg-white border-end-0" style="border-radius: 20px 0 0 20px; border-right: none;">
                <i class="fas fa-search text-muted"></i>
              </span>
              <input 
                type="text" 
                class="form-control border-start-0 shadow-none" 
                name="search" 
                placeholder="{{ __('Cari Kontrak...') }}" 
                value="{{ request('search') }}" 
                style="border-radius: 0 20px 20px 0; border-left: none; min-width: 200px;"
                autocomplete="off"
              >
            </div>
            <button type="submit" class="btn btn-primary px-4 shadow-sm">
              <i class="fas fa-search me-1"></i> {{ __('Cari') }}
            </button>
            <a href="{{ route('kontraknew') }}" class="btn btn-outline-secondary px-4 shadow-sm">
              <i class="fas fa-sync-alt me-1"></i> {{ __('Reset') }}
            </a>
          </form>
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
                        <td class="text-{{ $contract->kontrakm->status == 4 ? 'black' : $colorClass }} fw-semibold">{{ number_format($contract->harga_pcs / $contract->mc->gramSheetBoxKontrak, 2) }}</td>
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