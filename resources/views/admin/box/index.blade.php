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
              <th>Kode</th>
              <th>Nama Barang</th>
              <th>Tipe Box</th>
              <th>flute</th>
              <th>Panjang Dalam Box</th>
              <th>Lebar Dalam Box</th>
              <th>Tinggi Dalam Box</th>
              <th>Ukuran Creas Corr</th>
              <th>Ukuran Creas Conv</th>
              <th>Tipe Crease</th>
              <th>Branch</th>
              <th>Action</th>
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
    $(document).ready(function() {
      $("#data_box").DataTable({
        processing: true,
        serverSide: true,
        // scrollX: true,
        // scrollY: "auto",
        ajax: {
            url: "{{ route('box') }}"
        },
        columns: [
          { data: 'kode', name: 'kode' },
          { data: 'namaBarang', name: 'namaBarang' },
          { data: 'tipebox', name: 'tipebox' },
          { data: 'flute', name: 'flute' },
          { data: 'panjangDalamBox', name: 'panjangDalamBox' },
          { data: 'lebarDalamBox', name: 'lebarDalamBox' },
          { data: 'tinggiDalamBox', name: 'tinggiDalamBox' },
          { data: 'sizeCreasCorr', name: 'sizeCreasCorr' },
          { data: 'sizeCreasConv', name: 'sizeCreasConv' },
          { data: 'tipeCreasCorr', name: 'tipeCreasCorr' },
          { data: 'branch', name: 'branch' },
          { data: 'action', name: 'action' },
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