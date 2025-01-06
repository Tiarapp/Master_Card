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
          <h1 class="m-0">Sheet</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Sheet</li>
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

      <a href="{{ route('sheet.create') }}" style="margin-bottom: 20px;"> <i class="fas fa-plus-circle fa-2x"></i></a>
      <div class="card-body">
        <table class="table table-bordered" id="data_sheet">
          <thead>
            <tr>
              <th scope="col">Kode</th>
              <th scope="col">Nama</th>
              <th scope="col">Satuan P</th>
              <th scope="col">Satuan S</th>
              <th scope="col">Berat Std</th>
              <th scope="col">Stok P</th>
              <th scope="col">Stok S</th>
            </tr>
          </thead>
          <tbody>
            
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
      $("#data_sheet").DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('getsheet') }}",
        columns: [
          {data: 'kode', name: 'kode' },
          {data: 'NamaBrg', name: 'NamaBrg' },
          {data: 'SatuanP', name: 'SatuanP' },
          {data: 'SatuanS', name: 'SatuanS' },
          {data: 'berat', name: 'berat' },
          {data: 'stokp', name: 'stokp' },
          {data: 'stoks', name: 'stoks' },
        ]
      });
    });
  </script>

  @endsection