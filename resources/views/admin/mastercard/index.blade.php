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
            <h1 class="m-0">Mastercard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Mastercard</li>
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
      
      <a href="{{ route('mastercard.create') }}" style="margin-bottom: 20px;" > <i class="fas fa-plus-circle fa-2x"></i></a>
      <div class="card-body">
        
        <table class="table table-bordered" id="data_mc">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Kode</th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Tipe Box</th>
                    <th scope="col">Flute</th>
                    <th scope="col">Koli</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Warna</th>
                    <th scope="col">Box</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                    <?php 
                        $no = 1;
                        foreach ($mc as $mc) { ?>
                        <tr>
                            <td scope="row">{{ $no++ }}</td>
                            <td>{{ $mc->Kode }}</td>
                            <td>{{ $mc->Nama }}</td>
                            <td>{{ $mc->AlamatKantor }}</td>
                            <td>{{ $mc->KotaKantor }}</td>
                            <td>{{ $mc->TelpKantor }}</td>
                            <td>{{ $mc->PIC }}</td>
                            <a href="/admin/mastercard/pdf/{{ $data->id }}" class="btn btn-outline-secondary" type="button">Print</a>
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
     $("#data_mc").DataTable({
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