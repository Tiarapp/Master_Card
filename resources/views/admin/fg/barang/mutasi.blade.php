@extends('admin.templates.partials.default')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Barang</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Barang / Mutasi</li>
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
      
      <!-- Info Card -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Informasi Barang</h3>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="info-box">
                <div class="info-box-content">
                  <strong>Periode:</strong> {{ $persediaan->period }}<br>
                  <strong>Kode Barang:</strong> {{ $barang->KodeBrg }}<br>
                  <strong>Nama Barang:</strong> {{ $barang->NamaBrg }}
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="info-box">
                <div class="info-box-content">
                  <strong>Saldo Awal:</strong> {{ number_format((int)$persediaan->SaldoAwalCrt) }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Data Table Card -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Mutasi Barang</h3>
        </div>
        <div class="card-body">
          <table class="table table-bordered table-striped" id="data_barang">
            <thead class="bg-light">
              <tr>
                <th scope="col">Tanggal</th>
                <th scope="col">No Bukti</th>
                <th scope="col">Masuk</th>
                <th scope="col">Keluar</th>
                <th scope="col">Keterangan</th>
                <th scope="col">OPI</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $masuk = 0;
              $keluar = 0;
              // dd($result)
              foreach ($result as $data) { ?>
                <tr class="barang">
                  <td>{{ $data["tanggal"] }}</td>
                  <td>{{ trim($data["nobukti"]) }}</td>
                  <td class="text-right">{{ number_format((int)$data["masuk"]) }}</td>
                  <td class="text-right">{{ number_format((int)$data["keluar"]) }}</td>
                  <td>{{ trim($data["keterangan"]) }}</td>
                  <td>{{ trim($data["opi"]) }}</td>
                </tr>
              <?php
              $masuk = $masuk + (int)$data["masuk"];
              $keluar = $keluar + (int)$data["keluar"];
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
      
      <!-- Summary Card -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Ringkasan Mutasi</h3>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-4">
              <div class="info-box bg-success">
                <span class="info-box-icon"><i class="fas fa-arrow-up"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Masuk</span>
                  <span class="info-box-number">{{ number_format($masuk) }}</span>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="info-box bg-danger">
                <span class="info-box-icon"><i class="fas fa-arrow-down"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Keluar</span>
                  <span class="info-box-number">{{ number_format($keluar) }}</span>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="info-box bg-info">
                <span class="info-box-icon"><i class="fas fa-warehouse"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Saldo Akhir</span>
                  <span class="info-box-number">{{ number_format((int)$persediaan->SaldoAkhirCrt) }}</span>
                </div>
              </div>
            </div>
          </div>
            
        </div>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
@endsection

@section('javascripts')
<!-- jQuery -->
<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>
<!-- DataTables -->
<script> 
   $(document).ready(function(){
     $("#data_barang").DataTable({
      "pageLength": 50,
      "order":[
        [0, 'asc'],
        [2, 'desc']
      ],
        // "scrollX": true,
       dom: 'Bfrtip',
    //    select: true
     });   
   });
</script>
@endsection