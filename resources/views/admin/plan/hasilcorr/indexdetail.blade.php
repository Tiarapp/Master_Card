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
    @if ($message = Session::get('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        <strong>{{ $message }}</strong>
      </div>
    @endif
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Detail Planning</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Hasil Corr</a></li>
            <li class="breadcrumb-item active">Detail Planning</li>
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

      {{-- <a href="{{ route('opi.create') }}" style="margin-bottom: 20px;"> <i class="fas fa-plus-circle fa-2x"></i></a> --}}
      <div class="card-body">
        <table class="table table-bordered" id="data_opi">
          <thead>
            <tr>
              <th scope="col">urutan</th>
              <th scope="col">No OPI</th>
              <th scope="col">Order</th>
              <th scope="col">Ukuran Roll</th>
              <th scope="col">Panjang</th>
              <th scope="col">Lebar</th>
              <th scope="col">Bentuk</th>
              <th scope="col">Flute</th>
              <th scope="col">Hasil</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($corrd as $data)
              <tr>
                <td scope="col">{{ $data->urutan }}</td> 
                <td scope="col">{{ $data->opikode }}</td> 
                <td scope="col">{{ $data->qtyOrder }}</td> 
                <td scope="col">{{ $data->ukuran_roll }}</td> 
                <td scope="col">{{ $data->sheet_p }}</td> 
                <td scope="col">{{ $data->sheet_l }}</td> 
                <td scope="col">{{ $data->bentuk }}</td> 
                <td scope="col">{{ $data->flute }}</td> 
                <td scope="col">
                  @foreach ($data->hasil as $hasil)
                      <li>{{ $hasil->hasil_baik }}({{ $hasil->end_date }})</li>
                  @endforeach
                </td> 
                <td>
                  <a href="../hasilcorr/edit/{{ $data->id }}">Input Hasil</a>
                </td>
              </tr>  
            @endforeach
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
    // $(document).ready(function() {
    //   function strtrunc(str, max, add){
    //   add = add || '...';
    //   return (typeof str === 'string' && str.length > max ? str.substring(0, max) + add : str);
    // };
    $(document).ready(function() {
      $("#data_opi").DataTable({
        processing:true,
        // serverSide:true,
        select: true
      });
    });

    
  </script>

  @endsection