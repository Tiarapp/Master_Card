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
          <h1 class="m-0">Hasil Plan Corrugating</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Hasil Plan Corrugating</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="card-body">
        <table class="table table-bordered" id="data_hasilcorr">
          <thead>
            <tr>
              <th scope="col">Kode Plan</th>
              <th scope="col">Kode OPI</th>
              <th scope="col">Tanggal Plan</th>
              <th scope="col">Panjang</th>
              <th scope="col">Lebar</th>
              <th scope="col">Plan</th>
              <th scope="col">Flute</th>
              <th scope="col">Sisa</th>
              <th scope="col">Status</th>
              <th scope="col">Action</th>
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
    
    function strtrunc(str, max, add){
      add = add || '...';
      return (typeof str === 'string' && str.length > max ? str.substring(0, max) + add : str);
    };
    $(function(){
      $('#data_hasilcorr').DataTable({
        // "scrollY": "auto",
        processing:true,
        serverSide:true,
        ajax:"{{ route('corrd') }}",
        columns: [
          { data: 'kodeplanM', name: 'kodeplanM' },
          { data: 'opikode', name: 'opikode' },
          { data: 'tglcorr', name: 'tglcorr' },
          { data: 'panjangsheet', name: 'panjangsheet' },
          { data: 'lebarsheet', name: 'lebarsheet' },
          { data: 'plan', name: 'plan' },
          { data: 'flute', name: 'flute' },
          { data: 'sisa', name: 'sisa' },
          { data: 'status', name: 'status' },
          {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
          },
        ],
        "columnDefs": [
        {
          'targets': [0
          ],
          'render': function(data, type, full, meta){
            if(type === 'display'){
              data = strtrunc(data, 10);
            }
            return data;
          }
        }
        ],
        "order": [0, 'asc'],
        "pageLength": 1000,
        dom: 'Bftrip',
        buttons: [
          'copy',
          'excel',
          'pdf',
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
        // "scrollX": true,
        select: true,
      });
    });
  </script>

  @endsection