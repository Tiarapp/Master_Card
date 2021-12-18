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
      <button >
        <a href="{{ route('mastercard.create') }}" style="margin-bottom: 20px;" > <i class="fas fa-plus-circle fa-2x"></i></a>
      </button>
      <button class="btn btn-primary">
        <a href="{{ route('mastercardb1') }}" style="margin-bottom: 20px; color:white" >Approved</a>
      </button>
      <button class="btn btn-primary">
        <a href="{{ route('mastercarddc') }}" style="margin-bottom: 20px; color:white" >Process</a>
      </button>
      <div class="card-body">
        
        <table class="table table-bordered" id="data_mc">
            <thead>
                <tr>
                    {{-- <th scope="col">No.</th> --}}
                    <th scope="col">Kode</th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Tipe Box</th>
                    <th scope="col">Creas Corr P</th>
                    <th scope="col">Creas Corr L</th>
                    <th scope="col">Joint</th>
                    <th scope="col">Panjang Sheet</th>
                    <th scope="col">Lebar Sheet</th>
                    <th scope="col">Luas Sheet</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Gambar</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                    <?php 
                        $no = 1;
                        foreach ($mc as $data) { 
                          if ($data->revisi == null) {
                            $revisi = "";
                          } else {
                            $revisi = "-".$data->revisi;
                          }
                          ?>
                        <tr>
                            {{-- <td scope="row">{{ $no++ }}</td> --}}
                            <td>{{ $data->kode }}{{ $revisi }}</td>
                            <td>{{ $data->namaBarang }}</td>
                            <td>{{ $data->tipeBox }}</td>
                            <td>{{ $data->CreasCorrP }}</td>
                            <td>{{ $data->CreasCorrL }}</td>
                            <td>{{ $data->joint }}</td>
                            <td>{{ $data->panjangSheet }}</td>
                            <td>{{ $data->lebarSheet }}</td>
                            <td>{{ $data->luasSheet }}</td>
                            <td>{{ $data->keterangan }}</td>
                            <td><a href="../upload/{{ $data->gambar }}" target="_blank"><img width="150px" src="{{ url('/upload/'.$data->gambar) }}"></a></td>
                            <td> 
                                <a href="../mastercard/pdf/{{ $data->id }}" class="btn btn-outline-secondary" type="button">Print</a>
                                <a href="../mastercard/edit/{{ $data->id }}" class="btn btn-outline-secondary" type="button">Edit</a> 
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
     $("#data_mc").DataTable({
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
       "orderable":false,
       select: true
     });
   });
</script>

@endsection