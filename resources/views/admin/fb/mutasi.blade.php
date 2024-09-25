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
                <h2>Saldo Sekarang : {{ number_format((int)$persediaan->SaldoAkhir) }}</h2>
            </div>
        </div>
        <table class="table table-bordered" id="data_barang">
          <thead>
            <tr>
              <th scope="col">Tanggal</th>
              <th scope="col">No Bukti</th>
              <th scope="col">Jenis</th>
              <th scope="col">Masuk</th>
              <th scope="col">Keluar</th>
              <th scope="col">Harga/Pcs</th>
              <th scope="col">Keterangan</th>
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
                <td><strong>{{ $data["jenis"] }}</strong></td>
                <td>{{ number_format((int)$data["masuk"]) }}</td>
                <td>{{ number_format((int)$data["keluar"]) }}</td>
                <td>{{ number_format((int)$data["harga"]) }}</td>
                <td>{{ trim($data["keterangan"]) }}</td>
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
   $(document).ready(function(){
     $("#data_barang").DataTable({
      "pageLength": 50,
      "order":[
        [0, 'desc'],
        [3, 'desc']
      ],
        // "scrollX": true,
       dom: 'Bfrtip',
    //    select: true
     });   
   });
</script>

@endsection