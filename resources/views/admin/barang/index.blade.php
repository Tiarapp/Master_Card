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
            <h1 class="m-0">Barang</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Barang</li>
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
      
      <a href="#" style="margin-bottom: 20px;" > <i class="fas fa-plus-circle fa-2x"></i></a>
      <div class="card-body">
        <table class="table table-bordered" id="data_barang">
          <thead>
            <tr>
              <th scope="col">No.</th>
              <th scope="col">Kode</th>
              <th scope="col">Nama</th>
              <th scope="col">Gram</th>
              <th scope="col">Satuan</th>
              <th scope="col">Isi Per Karton</th>
              <th scope="col">Saldo Pcs</th>
              <th scope="col">Saldo Kg</th>
              <th scope="col">Mastercard ID</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            foreach ($barang as $data) { ?>
              <tr>
                <td scope="row">{{ $no++ }}</td>
                <td>{{ $data->KodeBrg }}</td>
                <td>{{ $data->NamaBrg }}</td>
                <td>{{ round($data->BeratStandart, 2) }}</td>
                <td>{{ $data->Satuan }}</td>
                <td>{{ round($data->IsiPerKarton, 0) }}</td>
                <td>{{ round($data->SaldoPcs, 2) }}</td>
                <td>{{ round($data->SaldoKg, 2) }}</td>
                <td>{{ $data->WeightValue }}</td>
                {{-- <td>
                  <div class="input-group">
                    <div class="input-group-append" id="button-addon4">
                      <a href="/admin/divisi/show/{{ $data->KodeBrg }}" class="btn btn-outline-secondary" type="button">View</a>
                      <a href="/admin/divisi/edit/{{ $data->KodeBrg }}" class="btn btn-outline-secondary" type="button">Edit</a>
                      <a href="/admin/divisi/delete/{{ $data->KodeBrg }}" class="btn btn-outline-danger" type="button">Delete</a>
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
   $(document).ready(function(){
     $("#data_barang").DataTable({
        // "scrollX": true,
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
           exportOption:{
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