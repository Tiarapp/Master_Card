<!-- jQuery -->
<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>

@extends('admin.templates.partials.default')


@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Data Customer</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Customer</li>
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
      <form action="{{ route('data.detbbm') }}" method="GET">
        @csrf
        Tanggal Awal <input type="date" name="mulai" id="mulai">
        Tanggal Akhir <input type="date" name="selesai" id="selesai">
        <button type="submit" class="btn-success">Recall</button>
      </form>
      {{-- <a href="{{ route('data.sync') }}" style="margin-bottom: 20px;margin-left: 20px;"> <i class="fas fa-plus-circle fa-2x"></i></a> --}}
      <div class="card-body">
        <table class="table table-bordered" id="data_divisi">
          <thead>
            <tr>
              <th scope="col">BBM</th>
              <th scope="col">Tanggal Masuk</th>
              <th scope="col">Kode Barang</th>
              <th scope="col">Nama Barang</th>
              <th scope="col">Ukuran</th>
              <th scope="col">Gsm</th>
              <th scope="col">Kode Roll</th>
              <th scope="col">QTY (Kg)</th>
              <th scope="col">Kode Roll Supp</th>
              <th scope="col">Kode Supp</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            foreach ($detbbm as $data) { ?>
              <tr>
                <td scope="row">{{ $data->NoBukti }}</td>
                <td scope="row">{{ $data->TglMasuk }}</td>
                <td scope="row">{{ $data->KodeBrg }}</td>
                <td scope="row">{{ $data->NamaBrg }}</td>
                <td scope="row">{{ $data->NamaKel }}</td>
                <td scope="row">{{ $data->JenisProduksi }}</td>
                <td>{{ $data->KodeRoll }}</td>
                <td>{{ number_format($data->BrtRew,2,".",",") }}</td>
                <td>{{ $data->KDROLLSUP }}</td>
                <td>{{ $data->KodeSupp }}</td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
  @endsection

  @section('javascripts')
  <!-- DataTables -->
  <script>
    $(document).ready(function() {
      $("#data_divisi").DataTable({
        dom: 'Bfrtip',
        buttons: [
          'copy',
          'csv',
          'excel',
          'pdf',
          'colvis',
          {
            extend: 'print',
            text: 'Print',
            exportOption: {
              modifier: {
                selected: null
              }
            }
          }
        ],
        select: true
      });
    });
  </script>

  @endsection