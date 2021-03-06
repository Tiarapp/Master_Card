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

      <a href="../admin/sj_palet/create" style="margin-bottom: 20px;"> <i class="fas fa-plus-circle fa-2x"></i></a>

      {{-- Datatable SJ Palet --}}
      <div class="card-body">
        <table class="table table-bordered" id="data_palet">
          <thead>
            <tr>
              {{-- <th scope="col">No.</th> --}}
              <th scope="col">No SJ</th>
              <th scope="col">Tanggal</th>
              <th scope="col">No Polisi</th>
              <th scope="col">Customer</th>
              {{-- <th scope="col">No PO Customer</th> --}}
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            // Perulangan untuk mengambil data SJ
            foreach ($sj as $data) { ?>
              <tr>
                {{-- <td scope="row">{{ $no++ }}</td> --}}
                <td><b>{{ $data->noSuratJalan }}</b></td>
                <td>{{ $data->tanggal }}</td>
                <td>{{ $data->noPolisi }}</td>
                <td>{{ $data->namaCustomer }}</td>
                {{-- <td>{{ $data->noPoCustomer }}</td> --}}
                <td>
                  <div class="input-group">
                    <div class="input-group-append" id="button-addon4">
                      {{-- <a href="../admin/sj_palet/show/{{ $data->id }}" class="btn btn-outline-secondary" type="button">View</a> --}}
                      <a href="../admin/sj_palet/pdf/{{ $data->id }}" class="btn btn-outline-secondary" type="button">Print</a>
                      <a href="../admin/sj_palet/edit/{{ $data->id }}" class="btn btn-outline-secondary" type="button">Edit</a>
                      {{-- <a href="../admin/sj_palet/delete/{{ $data->id }}" class="btn btn-outline-danger" type="button">Delete</a> --}}
                    </div>
                  </div>
                </td>
              </tr>
            <?php
            }
            // End Perulangan
            ?>
          </tbody>
        </table>
      </div>
      {{-- End Datatable SJ --}}
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
  @endsection

  @section('javascripts')
  <!-- DataTables -->
  {{-- Script untuk Datatable --}}
  <script>
    // Javascript untuk Datatable
    $(document).ready(function() {
      $("#data_palet").DataTable({
        "order": [0, 'desc'],
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