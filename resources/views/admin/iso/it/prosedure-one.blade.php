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
          <h1 class="m-0">ISO IT</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
            <li class="breadcrumb-item active">ISO</li>
            <li class="breadcrumb-item active">IT</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <table class="table tabel-bordered" id="example1">
            <tr>
              <td>Tujuan</td>
              <td>Memastikan sistem informasi dan teknologi informasi dapat digunakan dengan baik untuk menunjang proses operasional</td>
            </tr>
            <tr>
              <td>Ruang Lingkup</td>
              <td>Mulai dari proses perbaikan, instalasi, sampai pengembangan sistem, sampai back-up dan restore software dan data</td>
            </tr>
            <tr>
              <td>Definisi</td>
              <td>Sistem dan teknologi informasi meliputi jaringan komputer, printer dan perangkat keras lainnya serta keamanan data dari virus, sistem backup data</td>
            </tr>
            <tr>
              <td>Referensi</td>
              <td>Pasal 7.1.3 ISO 9001:2015</td>
            </tr>
        </table>
      </div>

    </div>
  </section>
  <!-- /.content -->
  @endsection

  @section('javascripts')
  <!-- DataTables -->
  <script>

  </script>

  @endsection
