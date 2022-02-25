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
      
      {{-- <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">
        <a href="{{ route('conv.create_printing') }}" style="margin-bottom: 20px; color:white;" >Plan Printing</a>
      </button>
      
      <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">
        <a href="{{ route('conv.create_non_printing') }}" style="margin-bottom: 20px; color:white;" >Plan Non Printing</a>
      </button> --}}
      <div class="card-body">
        <table class="table table-bordered" id="data_planconv">
          <thead>
            <tr>
              {{-- <th scope="col">No.</th> --}}
              <th scope="col">Opi</th>
              <th scope="col">Jumlah Order</th>
              <th scope="col">Tanggal Corr</th>
              <th scope="col">Hasil Corr Baik</th>
              <th scope="col">Hasil Corr Jelek</th>
              <th scope="col">Tanggal Flexo</th>
              <th scope="col">Hasil Flexo Baik</th>
              <th scope="col">Hasil Flexo Jelek</th>
              <th scope="col">Tanggal Tokai</th>
              <th scope="col">Hasil Tokai Baik</th>
              <th scope="col">Hasil Tokai Jelek</th>
              <th scope="col">Tanggal Stitch</th>
              <th scope="col">Hasil Stitch Baik</th>
              <th scope="col">Hasil Stitch Jelek</th>
              <th scope="col">Tanggal Wax</th>
              <th scope="col">Hasil Wax Baik</th>
              <th scope="col">Hasil Wax Jelek</th>
              <th scope="col">Tanggal Slitter</th>
              <th scope="col">Hasil Slitter Baik</th>
              <th scope="col">Hasil Slitter Jelek</th>
              <th scope="col">Tanggal Glue Manual</th>
              <th scope="col">Hasil Glue Manual Baik</th>
              <th scope="col">Hasil Glue Manual Jelek</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            foreach ($control as $data) { ?>
              <tr>
                {{-- <td scope="row">{{ $data->id }}</td> --}}
                <td>{{ $data->noOpi }}</td>
                <td>{{ $data->jml_Order }}</td>
                <td>{{ $data->tgl_corr }}</td>
                <td>{{ $data->hasil_baik_corr }}</td>
                <td>{{ $data->hasil_jelek_corr }}</td>
                <td>{{ $data->tgl_flexo }}</td>
                <td>{{ $data->hasil_baik_flexo }}</td>
                <td>{{ $data->hasil_jelek_flexo }}</td>
                <td>{{ $data->tokai }}</td>
                <td>{{ $data->hasil_baik_tokai }}</td>
                <td>{{ $data->hasil_jelek_tokai }}</td>
                <td>{{ $data->stitch }}</td>
                <td>{{ $data->hasil_baik_stitch }}</td>
                <td>{{ $data->hasil_jelek_stitch }}</td>
                <td>{{ $data->wax }}</td>
                <td>{{ $data->hasil_baik_wax }}</td>
                <td>{{ $data->hasil_jelek_wax }}</td>
                <td>{{ $data->slitter }}</td>
                <td>{{ $data->hasil_baik_slitter }}</td>
                <td>{{ $data->hasil_jelek_slitter }}</td>
                <td>{{ $data->glue_manual }}</td>
                <td>{{ $data->hasil_baik_glue }}</td>
                <td>{{ $data->hasil_jelek_glue }}</td>
                {{-- <td>
                  <div class="input-group">
                    <div class="input-group-append" id="button-addon4">
                      <a href="../admin/substance/show/{{ $data->id }}" class="btn btn-outline-secondary" type="button">View</a>
                      <a href="../admin/substance/edit/{{ $data->id }}" class="btn btn-outline-secondary" type="button">Edit</a>
                      <a href="../admin/substance/delete/{{ $data->id }}" class="btn btn-outline-danger" type="button">Delete</a>
                    </div>
                  </div>
                </td> --}}
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
    
    function strtrunc(str, max, add){
      add = add || '...';
      return (typeof str === 'string' && str.length > max ? str.substring(0, max) + add : str);
    };
    $(function(){
      $('#data_planconv').DataTable({
        "scrollX": true,
        // "scrollY": "auto",
        // processing:true,
        // serverSide:true,
        // ajax:"{{ route('convd') }}",
        // columns: [
        //   // { data: 'id', name: 'id' },
        //   { data: 'kode', name: 'kode' },
        //   { data: 'tanggal', name: 'tanggal' },
        //   { data: 'shift', name: 'shift' },
        //   { data: 'revisi', name: 'revisi' },
        //   { data: 'total_pcs', name: 'total_pcs' },
        //   { data: 'total_kg', name: 'total_kg' },
        //   {
        //     data: 'action',
        //     name: 'action',
        //     orderable: false,
        //     searchable: false
        //   },
        // ],
        // "columnDefs": [
        // {
        //   'targets': [2
        //   ],
        //   'render': function(data, type, full, meta){
        //     if(type === 'display'){
        //       data = strtrunc(data, 10);
        //     }
        //     return data;
        //   }
        // }
        // ],
        // "order": [2, 'desc'],
        // "pageLength": 1000,
        // // dom: 'Bftrip',
        // // buttons: [
        // //   'copy',
        // //   'excel',
        // //   'pdf',
        // //   {
        // //     extend: 'print',
        // //     text: 'Print',
        // //     exportOption: {
        // //       modifier: {
        // //         selected: null
        // //       }
        // //     }
        // //   }
        // // ],
        // select: true,
      });
    });
  </script>

  @endsection