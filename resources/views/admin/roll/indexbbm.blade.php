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
          <h1 class="m-0">BBM Roll</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">BBM Roll</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    @if ($message = Session::get('succes'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>{{ $message }}</strong>
        </div>
    @endif
    @if ($message = Session::get('error'))
        @include('sweetalert::alert')
    @endif
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      
      <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">
        <a href="{{ route('roll.createbbm') }}" style="margin-bottom: 20px; color:white;" >BBM Roll</a>
      </button>
      <div class="card-body">
        <table class="table table-bordered" id="data_planconv">
          <thead>
            <tr>
              {{-- <th scope="col">No.</th> --}}
              <th scope="col">Tanggal BBM</th>
              <th scope="col">Kode Internal</th>
              <th scope="col">Nama Roll</th>
              <th scope="col">Gram</th>
              <th scope="col">Lebar</th>
              <th scope="col" style="width: 100px">Berat SJ (kg)</th>
              <th scope="col" style="width: 100px">Berat timbang (kg)</th>
              <th scope="col" style="width: 100px">PO</th>
              <th scope="col">Supplier</th>
              <th scope="col">Action</th>
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
    
    function strtrunc(str, max, add){
      add = add || '...';
      return (typeof str === 'string' && str.length > max ? str.substring(0, max) + add : str);
    };
    $(function(){
      $('#data_planconv').DataTable({
        // "scrollY": "auto",
      })
    });
  </script>

  @endsection