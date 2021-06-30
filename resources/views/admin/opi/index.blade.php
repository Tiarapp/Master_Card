<!-- jQuery -->
<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>

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
          <h1 class="m-0">OPI</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">OPI</li>
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

      <a href="{{ route('opi.create') }}" style="margin-bottom: 20px;"> <i class="fas fa-plus-circle fa-2x"></i></a>
      <div class="card-body">
        <table class="table table-bordered" id="data_palet">
          <thead>
            <tr>
              {{-- <th scope="col">No.</th> --}}
              <th scope="col">No OPI</th>
              <th scope="col">Kontrak</th>
              <th scope="col">DT</th>
              <th scope="col">Item</th>
              <th scope="col">Sales</th>
              <th scope="col">status</th>
              {{-- <th scope="col">No PO Customer</th> --}}
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            foreach ($opi_m as $data) { 
              ?>
              <tr>
                {{-- <td scope="row">{{ $no++ }}</td> --}}
                <td><b>{{ $data->NoOPI }}</b></td>
                <td>{{ $data->namaKontrak }}</td>
                <td>{{ $data->dt }}</td>
                <td>{{ $data->Item }}</td>
                <td>{{ $data->sales }}</td>
                <td>{{ $data->status }}</td>
                {{-- <td>{{ $data->noPoCustomer }}</td> --}}
                <td>
                  <div class="input-group">
                    <div class="input-group-append" id="button-addon4">
                      {{-- <a href="../admin/sj_palet/show/{{ $data->id }}" class="btn btn-outline-secondary" type="button">View</a> --}}
                      <a href="../admin/kontrak/pdf/{{ $data->id }}" class="btn btn-outline-secondary" type="button">Print</a>
                      <a href="../admin/kontrak/edit/{{ $data->id }}" class="btn btn-outline-secondary" type="button">Edit</a>
                      {{-- <a href="../admin/sj_palet/delete/{{ $data->id }}" class="btn btn-outline-danger" type="button">Delete</a> --}}
                    </div>
                  </div>
                </td>
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