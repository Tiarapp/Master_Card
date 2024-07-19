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
              <li class="breadcrumb-item active">Barang</li>
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
      
      {{-- <a href="{{ route('fb.add.bbm') }}" style="margin-bottom: 20px;" > <i class="fas fa-plus-circle fa-2x"></i></a> --}}
      <div class="card-body">
        <table class="table table-bordered" id="data_barang">
          <thead>
            <tr>
                <th scope="col">Kode Barang</th>
                <th scope="col">Nama Barang</th>
                <th scope="col">Merk</th>
                <th scope="col">Tipe</th>
                <th scope="col">Spesifikasi</th>
                <th scope="col">Stok</th>
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
   $(document).ready(function(){
    var teknik = $("#data_barang").DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('fb.get.teknik') !!}',
        columns: [{
                data: 'KodeBrg',
                name: 'KodeBrg'
            },
            {
                data: 'NamaBrg',
                name: 'TBarang.NamaBrg'
            },
            {
                data: 'Merk',
                name: 'TBarang.Merk'
            },
            {
                data: 'Tipe',
                name: 'TBarang.Tipe'
            },
            {
                data: 'Spesifikasi',
                name: 'TBarang.Spesifikasi'
            },
            {
                data: 'SaldoAkhir',
                name: 'SaldoAkhir'
            },
        ],
        select: true,
    });
   });
</script>

@endsection