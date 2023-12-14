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

      <a href="{{ route('data.sync') }}" style="margin-bottom: 20px;margin-left: 20px;"> <i class="fas fa-plus-circle fa-2x"></i></a>
      <div class="card-body">
        <table class="table table-bordered" id="data_divisi">
          <thead>
            <tr>
              <th scope="col">Kode.</th>
              <th scope="col">Nama</th>
              <th scope="col">NPWP</th>
              <th scope="col">Alamat Kantor</th>
              <th scope="col">Telp Kantor</th>
              <th scope="col">PIC</th>
              <th scope="col">Alamat Kirim</th>
              <th scope="col">Plafond</th>
              <th scope="col">top</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            foreach ($cust as $data) { ?>
              <tr>
                <td scope="row">{{ $data->Kode }}</td>
                <td>{{ $data->Nama }}</td>
                <td>{{ $data->NPWP }}</td>
                <td>{{ $data->AlamatKantor }}</td>
                <td>{{ $data->TelpKantor }}</td>
                <td>{{ $data->PIC }}</td>
                <td>{{ $data->AlamatKirim }}</td>
                <td>{{ $data->plafond }}</td>
                <td>{{ $data->top }}</td>
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