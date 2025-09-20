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
      
      <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h2>Periode : {{ $persediaan->period }}</h2>
                <h2>Kode Barang : {{ $barang->KodeBrg }}</h2>
                <h2>Nama Barang : {{ $barang->NamaBrg }}</h2>
            </div>
            <div class="col-md-6">
                <h2>Saldo Awal P : {{ number_format((int)$persediaan->SaldoAwalP) }}</h2>
                <h2>Saldo Awal S : {{ number_format((int)$persediaan->SaldoAwalS) }}</h2>
            </div>
        </div>
        <table class="table table-bordered" id="data_barang">
          <thead>
            <tr>
              <th scope="col">Tanggal</th>
              <th scope="col">No Bukti</th>
              <th scope="col">Masuk P</th>
              <th scope="col">Masuk S</th>
              <th scope="col">Keluar P</th>
              <th scope="col">Keluar S</th>
              <th scope="col">Keterangan</th>
            </tr>
          </thead>
          <tbody>
            @php
                $masukp = 0;
                $masuks = 0;
                $keluarp = 0;
                $keluars = 0;
            @endphp
            @foreach ($result as $data)
              <tr class="barang">
                <td>{{ $data["tanggal"] }}</td>
                <td>{{ trim($data["nobukti"]) }}</td>
                <td>{{ number_format( $data["masukp"], 2) }}</td>
                <td>{{ number_format($data["masuks"], 2) }}</td>
                <td>{{ number_format($data["keluarp"], 2) }}</td>
                <td>{{ number_format($data["keluars"], 2) }}</td>
                <td>{{ trim($data["keterangan"]) }}</td>
              </tr>
              @php
                $masukp += (int)$data["masukp"];
                $masuks += (int)$data["masuks"];
                $keluarp += (int)$data["keluarp"];
                $keluars += (int)$data["keluars"];
              @endphp
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <td colspan="2"></td>
              <td>{{ number_format($masukp) }}</td>
              <td>{{ number_format($masuks) }}</td>
              <td>{{ number_format($keluarp) }}</td>
              <td>{{ number_format($keluars) }}</td>
              <td></td>
            </tr>
          </tfoot>
        </table>
        <div class="row">
            <div class="col-md-3">

            </div>
            <div class="col-md-6">
                <div class="row">
                    <h3>Total Mutasi</h3>
                    <div style="margin-left: 120px">
                        <label for=""><h2>{{ number_format($masukp) }} {{ number_format($masuks) }}  </h2></label>
                    </div>
                    <div style="margin-left: 220px">
                        <label for=""><h2>{{ number_format($keluarp) }} {{ number_format($keluars) }}</h2></label>
                    </div>
                </div>
                <div class="row">
                    <h3>Sisa :</h3> 
                    <label for="" style="margin-left: 500px"><h2>{{ number_format((int)$persediaan->SaldoAkhirS) }}</h2></label>
                </div>
            </div>
            
        </div>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
  @endsection

@section('javascripts')
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