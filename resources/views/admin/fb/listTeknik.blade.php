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
      @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
          <strong>{{ $message }}</strong>
        </div>
      @endif
      
      {{-- <a href="{{ route('fb.add.bbm') }}" style="margin-bottom: 20px;" > <i class="fas fa-plus-circle fa-2x"></i></a> --}}
      <div class="card-body">
        <table class="table table-bordered" id="data_barang">
          <thead>
            <tr>
                <th scope="col">Kode Barang</th>
                <th scope="col">Nama Barang</th>
                <th scope="col">Merk</th>
                <th scope="col">Tipe</th>
                <th scope="col">Spesifikasi</th>
                <th scope="col">Stok</th>
                <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            foreach ($persediaan as $data) { ?>
              <tr class="barang">
                <td>
                  {{ $data->KodeBrg }}
                </td>
                <td>{{ $data->NamaBrg }}</td>
                <td>{{ $data->Merk }}</td>
                <td>{{ $data->Tipe }}</td>
                <td>{{ $data->Spesifikasi }}</td>
                <td>{{ round($data->SaldoAkhir, 2) }}</td>
                <td>
                  <a href="../fb/mutasi/{{ trim($data->KodeBrg) }}" class="btn btn-outline-secondary" type="button">Edit</a>
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

   $(document).on("click", '.mutasi', function() {
    kodebarang = $(this).val();

    document.getElementById("kodebarang").value = kodebarang;
    
   })
</script>

@endsection