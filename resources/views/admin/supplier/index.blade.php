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
      
      <a href="#" style="margin-bottom: 20px;" > <i class="fas fa-plus-circle fa-2x"></i></a>
      <div class="card-body">
        <table class="table table-bordered" id="data_supplier">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Kode</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Kantor</th>
                    <th scope="col">Telp</th>
                    <th scope="col">PIC</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                    <?php 
                        foreach ($suppliers as $supp) { ?>
                        <tr>
                            <td scope="row">{{ $supp->id }}</td>
                            <td>{{ $supp->Kode }}</td>
                            <td>{{ $supp->Nama }}</td>
                            <td>{{ $supp->AlamatKantor }}</td>
                            <td>{{ $supp->KotaKantor }}</td>
                            <td>{{ $supp->TelpKantor }}</td>
                            <td>{{ $supp->PIC }}</td>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-append" id="button-addon4">
                                    <a href="{{ route('supplier.show', $supp->id) }}" class="btn btn-outline-secondary" type="button">View</a>
                                    <a href="{{ route('satuans.edit', $supp->id) }}" class="btn btn-outline-secondary" type="button">Edit</a>
                                    <a class="btn btn-outline-danger" type="button">Delete</a>
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
     $("#data_supplier").DataTable({
       dom: 'Bfrtip',
       buttons: [
         'copy',
         'csv',
         'excel',
         'pdf',
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