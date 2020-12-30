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
              <li class="breadcrumb-item active">Dashboard</li>
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
      
      <a href="{{ route('satuans.create') }}" style="margin-bottom: 20px;" > <i class="fas fa-plus-circle fa-2x"></i></a>
      <div class="card-body">
        <table class="table table-bordered" id="data_satuan">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Kode</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Branch</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                    <?php 
                        foreach ($satuans as $satuan) { ?>
                        <tr>
                            <td scope="row">{{ $satuan->id }}</td>
                            <td>{{ $satuan->kode }}</td>
                            <td>{{ $satuan->nama }}</td>
                            <td>{{ $satuan->branch }}</td>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-append" id="button-addon4">
                                    <a href="{{ route('satuans.edit', $satuan->id) }}" class="btn btn-outline-secondary" type="button">Edit</a>
                                    <a href="{{ route('satuans.destroy'), $satuan->id }}" class="btn btn-outline-danger" type="button">Delete</a>
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
   $(document).ready(function(){
     $("#data_satuan").DataTable({
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