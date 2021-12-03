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
          <h1 class="m-0">Box</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Box</li>
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
      
      <a href="{{ route('box.create') }}" style="margin-bottom: 20px;"> <i class="fas fa-plus-circle fa-2x"></i></a>
      <div class="card-body">
        <table class="table table-bordered" id="data_box">
          <thead>
            <tr>
              <th scope="col">Kode</th>
              {{-- <th scope="col">Kode Barang</th> --}}
              <th scope="col">Nama Barang</th>
              <th scope="col">Tipe Box</th>
              <th scope="col">flute</th>
              <th scope="col">Panjang Dalam Box</th>
              <th scope="col">Lebar Dalam Box</th>
              <th scope="col">Tinggi Dalam Box</th>
              <th scope="col">Ukuran Creas Corr</th>
              <th scope="col">Ukuran Creas Conv</th>
              <th scope="col">Branch</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            foreach ($box as $data) { ?>
              <tr>
                <td scope="row">{{ $data->kode }}</td>
                {{-- <td>{{ $data->kodeBarang }}</td> --}}
                <td>{{ $data->namaBarang }}</td>
                <td>{{ $data->tipebox }}</td>
                <td>{{ $data->flute }}</td>
                <td>{{ $data->panjangDalamBox }}</td>
                <td>{{ $data->lebarDalamBox }}</td>
                <td>{{ $data->tinggiDalamBox }}</td>
                <td>{{ $data->sizeCreasCorr }}</td>
                <td>{{ $data->sizeCreasConv }}</td>
                <td>{{ $data->branch }}</td>
                <td>
                  <div class="input-group">
                    <div class="input-group-append" id="button-addon4">
                      <a href="../admin/sheet/show/{{ $data->id }}" class="btn btn-outline-secondary" type="button">View</a>
                      <a href="../admin/sheet/edit/{{ $data->id }}" class="btn btn-outline-secondary" type="button">Edit</a>
                      <a href="../admin/sheet/delete/{{ $data->id }}" class="btn btn-outline-danger" type="button">Delete</a>
                    </div>
                  </div>
                </td>
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
    $(document).ready(function() {
      $("#data_box").DataTable({
        "scrollX": true,
        "scrollY": "auto",
        "columnDefs": [
        {
          'targets': 2,
          'render': function(data, type, full, meta){
            if(type === 'display'){
              data = strtrunc(data, 10);
            }
            
            return data;
          }
        }
        ],
        dom: 'Bfrtip',
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
        select: true
      });
    });
  </script>
  
  @endsection