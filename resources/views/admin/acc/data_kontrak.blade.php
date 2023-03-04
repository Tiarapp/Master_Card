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
          <h1 class="m-0">OPI</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">OPI</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="form-group">
        <div class="row">
          <div class="col-md-6">
              <input type="text" name="periode" id="periode" required>
              {{-- <input type="date" name="end" id="end" required> --}}
              <button name="search" id="search"> Search </button>
            {{-- </form> --}}
          </div>
        </div>
      </div>
      <!-- Small boxes (Stat box) -->

      {{-- <a href="{{ route('opi.create') }}" style="margin-bottom: 20px;"> <i class="fas fa-plus-circle fa-2x"></i></a> --}}
      <div class="card-body">
        <table class="table table-bordered" id="data_opi">
          <thead>
            <tr>
              <th scope="col">No. Kontrak</th>
              <th scope="col">Nama Barang</th>
              <th scope="col">Tgl Kontrak</th>
              <th scope="col">pcs Kontrak</th>
              <th scope="col">Customer</th>
              <th scope="col">PO Customer</th>
              <th scope="col">Top</th>
              <th scope="col">Kirim</th>
              <th scope="col">Komisi</th>
              <th scope="col">Sales</th>              
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

      $('#search').click(function() {
        var periode = document.getElementById("periode").value;
        // var end = document.getElementById("end").value;

        if (periode !== '' ) {
          $('#data_opi').DataTable({
            "bDestroy": true,
            "searching": false,
            "processing":true,
            "serverSide":true,
            "ajax":{
              "url": "acc/kontrak?periode="+periode,
              "dataType": "json",
              "type": "GET",
              "data":{_token: "{{ csrf_token() }}"}
            },
            "columns": [
              {"data": "kode" },
              {"data": "namaBarang" },
              {"data": "tglKontrak" },
              {"data": "pcsKontrak" },
              {"data": "cust" },
              {"data": "poCustomer" },
              {"data": "top" },
              {"data": "kirim" },
              {"data": "komisi" },
              {"data": "sales" },
            ],
          "paging": false,
          dom: 'Bftrip',
          buttons: [
            'excel',
          ],
          });
        }
      })
    });

    
  </script>

  @endsection