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
            <h1 class="m-0">Dashboard</h1>
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
                    <th scope="col">Kode Barang</th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Satuan</th>
                    <th scope="col">Isi Per Karton</th>
                    <th scope="col">Berat Standart</th>
                    <th scope="col">Berat CRT</th>
                    <th scope="col">Weight Value</th>
                    <th scope="col">Weight Sheet</th>
                    <th scope="col">Warna</th>
                    <th scope="col">Packing</th>
                </tr>
            </thead>
            <tbody>
                    <?php 
                        $no = 1;
                        foreach ($barang as $brg) { ?>
                        <tr>
                            <td scope="row">{{ $no++ }}</td>
                            <td>{{ $brg->KodeBrg }}</td>
                            <td>{{ $brg->NamaBrg }}</td>
                            <td>{{ $brg->Satuan }}</td>
                            <td>{{ $brg->IsiPerKarton }}</td>
                            <td>{{ $brg->BeratStandart }}</td>
                            <td>{{ $brg->BeratCRT }}</td>
                            <td>{{ $brg->WeightValue }}</td>
                            <td>{{ $brg->WeightSheet }}</td>
                            <td>{{ $brg->Warna }}</td>
                            <td>{{ $brg->Packing }}</td>
                            {{-- <td>
                                <div class="input-group">
                                    <div class="input-group-append" id="button-addon4">
                                    <a href="#" class="btn btn-outline-secondary" type="button">View</a>
                                    <a href="#" class="btn btn-outline-secondary" type="button">Edit</a>
                                    <a class="btn btn-outline-danger" type="button">Delete</a>
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
        "scrollX": true,
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