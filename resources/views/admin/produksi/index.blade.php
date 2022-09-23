
@extends('admin.templates.partials.default')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<style>
    .select2 {
        width: 206px !important;
    }
</style>


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
      <div class="form-group">
        <div class="row">
          <div class="col-md-6">
            {{-- <form action="{{ route('filter') }}" method="get"> --}}
              <select class="js-example-basic-single" name="mesin" id="mesin">
                <option value="" selected disabled>Pilih Mesin</option>
                @foreach ($mesin as $m)
                    <option value="{{ $m->nama }}">{{ $m->nama }}</option>
                @endforeach
              </select>
              <input type="date" name="mulai" id="mulai">
              <input type="date" name="end" id="end">
              <button name="search" id="search"> Search </button>
            {{-- </form> --}}
          </div>
        </div>
      </div>

      <div class="card-body">
        <table class="table table-bordered" id="laporan">
          <thead>
            <tr>
              <th scope="col">Jam Mulai</th>
              <th scope="col">Jam Selesai</th>
              <th scope="col">Hasil Baik (pcs)</th>
              <th scope="col">OPI</th>
              <th scope="col">Mesin</th>
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
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
        // $("#laporan").DataTable();
    }); 

    $(function(){

      $('#search').click(function() {
        var mesin = document.getElementById("mesin").value;
        var mulai = document.getElementById("mulai").value;
        var end = document.getElementById("end").value;

        console.log(mulai);
        console.log(end);

        if (mulai == '' && end == '') {
          if (mesin) {
              $('#laporan').DataTable({
              "bDestroy": true,
              "searching": false,
              "processing":true,
              "serverSide":true,
              "ajax":{
                "url": "/produksi/filter?mesin="+mesin,
                "dataType": "json",
                "type": "GET",
                "data":{_token: "{{ csrf_token() }}"}
              },
              "columns": [
                {"data": "start_date"},
                {"data": "end_date"},
                {"data": "hasil_baik"},
                {"data": "noOpi"},
                {"data": "mesin"},
                
              ],
              "paging": false,
              dom: 'Bftrip',
              buttons: [
                'excel',
              ],
            });
          } 
        } 
        else {
          if (mesin == '') {
            
            $('#laporan').DataTable({
            "bDestroy": true,
            "searching": false,
            "processing":true,
            "serverSide":true,
            "ajax":{
              "url": "/produksi/filter?mulai="+mulai+"&end="+end,
              "dataType": "json",
              "type": "GET",
              "data":{_token: "{{ csrf_token() }}"}
            },
            "columns": [
              {"data": "start_date"},
              {"data": "end_date"},
              {"data": "hasil_baik"},
              {"data": "noOpi"},
              {"data": "mesin"},
              
            ],
            "paging": false,
              dom: 'Bftrip',
            buttons: [
              'excel',
            ],
          });
          } else {
            
            $('#laporan').DataTable({
            "bDestroy": true,
              "searching": false,
            "processing":true,
            "serverSide":true,
            "ajax":{
              "url": "/produksi/filter?mesin="+mesin+"&mulai="+mulai+"&end="+end,
              "dataType": "json",
              "type": "GET",
              "data":{_token: "{{ csrf_token() }}"}
            },
            "columns": [
              {"data": "start_date"},
              {"data": "end_date"},
              {"data": "hasil_baik"},
              {"data": "noOpi"},
              {"data": "mesin"},
              
            ],
            "paging": false,
              dom: 'Bftrip',
            buttons: [
              'excel',
            ],
          });
          }
        }
      })
    });
  </script>

  @endsection