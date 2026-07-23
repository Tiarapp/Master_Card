<!-- jQuery -->

@extends('admin.templates.partials.default')


{{-- <style>
  td, tr {
    border:1px solid black !important;
  }
</style> --}}

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Surat Jalan Palet</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Surat Jalan Palet</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12" style="margin-bottom: 20px;">
                <form action="{{ route('sj_palet') }}" method="GET">
                    <div class="row">
                        <div class="row col-md-6">
                            <div class="col-md-2">
                                <label>Start Date:</label>
                            </div>
                            <div class="col-md-3">
                                <input type="date" class="form-control txt_line" name="start_date" value="{{ $start_date }}" required>
                            </div>
                            <div class="col-md-2">
                                <label>End Date:</label>
                            </div>
                            <div class="col-md-3">
                                <input type="date" class="form-control txt_line" name="end_date" value="{{ $end_date }}" required>
                            </div>
                        </div>
                        <div class="input-group col-md-5">
                            <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit">Search</button>
                            </div>
                            <div class="input-group-append">
                                <a href="{{ route('sj_palet') }}" class="btn btn-outline-secondary" type="button">Reset</a>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <a href="{{ route('export.sjpalet', ['start_date' => $start_date, 'end_date' => $end_date, 'search' => request('search')]) }}" class="btn btn-outline-success" type="button">Export</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

      <div class="table-responsive shadow rounded-3">
        <table class="table align-middle table-row-dashed table-row-bordered gy-5 gs-7 fs-6" style="background-color: #fff;">
            <thead>
                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                    <th class="min-w-125px">{{ __('No Surat Jalan') }}</th>
                    <th class="min-w-125px">{{ __('Tanggal') }}</th>
                    <th class="min-w-125px">{{ __('No Kendaraan') }}</th>
                    <th class="min-w-125px">{{ __('Customer') }}</th>
                    <th class="min-w-125px">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody class="text-gray-900 fw-semibold">
                @foreach ($sj as $suratjalan)
                    <tr>
                        <td class="text-gray-800 bold">{{ $suratjalan->noSuratJalan }}</td>
                        <td class="text-gray-800 bold">{{ $suratjalan->tanggal }}</td>
                        <td class="text-gray-800 bold">{{ $suratjalan->noPolisi }}</td>
                        <td class="text-gray-800 bold">{{ $suratjalan->namaCustomer }}</td>
                        <td class="text-gray-800 bold">
                            <div class="input-group">
                                <div class="input-group-append" id="button-addon4">
                                    <a href="../admin/sj_palet/show/{{ $suratjalan->id }}" class="btn btn-outline-secondary" type="button">View</a>
                                    <a href="../admin/sj_palet/edit/{{ $suratjalan->id }}" class="btn btn-outline-secondary" type="button">Edit</a>
                                    <a href="../admin/sj_palet/delete/{{ $suratjalan->id }}" class="btn btn-outline-danger" type="button">Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
      </div><!-- /.table-responsive -->
      {{ $sj->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
  @endsection

  @section('javascripts')
  <!-- DataTables -->
  {{-- Script untuk Datatable --}}
  <script>
  </script>

  @endsection
