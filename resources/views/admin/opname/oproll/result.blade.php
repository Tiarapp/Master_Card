<!-- jQuery -->
<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>

@extends('admin.templates.partials.default')
<title>Opname Roll | Rekap Opname </title>


@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Opname Roll</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Opbame Roll</li>
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

      <div class="card-body">
        <table class="table table-bordered" id="data_roll">
          <thead>
            <tr>
              <th scope="col">Kode</th>
              <th scope="col">Nama Barang</th>
              <th scope="col">Saldo Akhir (kg)</th>
              <th scope="col">Periode</th>
              <th scope="col">Saldo Opname (kg)</th>
              <th scope="col">Jumlah</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            foreach ($oproll as $data) { ?>
              <tr>
                <td>{{ $data->kode }}</td>
                <td>{{ $data->nama }}</td>
                <td>{{ $data->saldo }}</td>
                <td>{{ $data->periode }}</td>
                <td>{{ $data->opname }}</td>
                <td>{{ $data->opname - $data->saldo}}</td>
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
      $("#data_roll").DataTable({
        dom: 'Bfrtip',
        buttons: [
          'excel',
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