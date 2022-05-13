<!-- jQuery -->
<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>

@extends('admin.templates.partials.default')


{{-- <style>
  td, tr {
    border:1px solid black !important;
  }
</style> --}}

@section('content')
@if ($message = Session::get('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    <strong>{{ $message }}</strong>
  </div>
@endif
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Kontrak</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Kontrak</li>
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

      <a href="{{ route('kontrak.create') }}" style="margin-bottom: 20px;"> <i class="fas fa-plus-circle fa-2x"></i></a>
      <div class="card-body">
        <table class="table table-bordered" id="data_kontrak">
          <thead>
            <tr>
              <th scope="col">ID.</th>
              <th scope="col">Action</th>
              <th scope="col">No Kontrak</th>
              <th scope="col">Tanggal</th>
              <th scope="col">Kode Barang</th>
              <th scope="col">Customer</th>
              <th scope="col">Alamat</th>
              <th scope="col">QTY Kontrak</th>
              <th scope="col">No MC</th>
              <th scope="col">Realisasi Kirim</th>
              <th scope="col">Sisa Kontrak</th>
              <th scope="col">Sales</th>
              {{-- <th scope="col">No PO Customer</th> --}}
            </tr>
          </thead>
          
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
    $(function(){
      $('#data_kontrak').DataTable({
        "processing":true,
        "serverSide":true,
        "ajax":{
          "url": "{{ url('kontrakjson') }}",
          "dataType": "json",
          "type": "POST",
          "data":{_token: "{{ csrf_token() }}"}
        },
        "columns": [
          {"data": "id"},
          {"data": "action"},
          {"data": "kontrak"},
          {"data": "tglKontrak"},
          {"data": "kodeBarang"},
          {"data": "cust"},
          {"data": "alamatKirim"},
          {"data": "pcsKontrak"},
          {"data": "nomc"},
          {"data": "realisasi"},
          {"data": "sisaKirim"},
          {"data": "sales"},
          
        ],
        // "order": [2, 'desc'],
        // "pageLength": 1000,
        dom: 'Bftrip',
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
        select: true,
      });
    });
    // $(document).ready(function() {
    //   $("#data_kontrak").DataTable({
    //     "order": [0, 'desc'],
    //     dom: 'Bfrtip',
    //     buttons: [
    //       'copy',
    //       'csv',
    //       'excel',
    //       'pdf',
    //       'colvis',
    //       {
    //         extend: 'print',
    //         text: 'Print',
    //         exportOption: {
    //           modifier: {
    //             selected: null
    //           }
    //         }
    //       }
    //     ],
    //     select: true
    //   });
    // });
  </script>

  @endsection