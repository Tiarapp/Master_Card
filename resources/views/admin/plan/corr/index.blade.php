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
          <h1 class="m-0">Plan Corrugating</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Plan Corrugating</li>
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

      <a href="{{ route('corr.create') }}" style="margin-bottom: 20px;"> <i class="fas fa-plus-circle fa-2x"></i></a>
      <div class="card-body">
        <table class="table table-bordered" id="data_opi">
          <thead>
            <tr>
              <th scope="col">No.</th>
              <th scope="col">Kode Plan</th>
              <th scope="col">Tanggal Plan</th>
              <th scope="col">Shift</th>
              <th scope="col">Revisi</th>
              <th scope="col">Total RM</th>
              <th scope="col">Total Berat</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            {{-- <?php 
            // $no = 1;
            // foreach ($data as $data) { 
               ?> --}}
              {{-- <tr> --}}
                {{-- <td scope="row">{{ $data->id }}</td> --}}
                {{-- <td> --}}
                  {{-- <div class="input-group"> --}}
                    {{-- <div class="input-group-append" id="button-addon4"> --}}
                      {{-- <a href="../admin/sj_palet/show/{{ $data->id }}" class="btn btn-outline-secondary" type="button">View</a> --}}
                      {{-- <a href="../admin/opi/pdf/{{ $data->id }}" class="btn btn-outline-secondary" type="button">Print</a> --}}
                      {{-- <a href="../admin/kontrak/edit/{{ $data->id }}" class="btn btn-outline-secondary" type="button">Edit</a> --}}
                      {{-- <a href="../admin/sj_palet/delete/{{ $data->id }}" class="btn btn-outline-danger" type="button">Delete</a> --}}
                    {{-- </div> --}}
                  {{-- </div> --}}
                {{-- </td> --}}
                {{-- <td><b>{{ $data->noOPI }}</b></td> --}}
                {{-- <td>{{ $data->kode }}</td> --}}
                {{-- <td>{{ $data->tglKirimDt }}</td> --}}
                {{-- <td>{{ $data->pcsDt }}</td> --}}
                {{-- <td>{{ $data->namaBarang }}</td> --}}
                {{-- <td>{{ $data->status }}</td> --}}
                {{-- <td>{{ $data->noPoCustomer }}</td> --}}
              {{-- </tr> --}}
            {{-- <?php 
            // }
             ?> --}}
          {{-- </tbody> --}}
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
      $('#data_opi').DataTable({
        // "scrollY": "auto",
        processing:true,
        serverSide:true,
        ajax:"{{ route('corrm') }}",
        columns: [
          { data: 'id', name: 'id' },
          { data: 'kode_plan', name: 'kode_plan' },
          { data: 'tanggal', name: 'tanggal' },
          { data: 'shift', name: 'shift' },
          { data: 'revisi', name: 'revisi' },
          { data: 'total_RM', name: 'total_RM' },
          { data: 'total_Berat', name: 'total_Berat' },
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
        "order": [2, 'desc'],
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