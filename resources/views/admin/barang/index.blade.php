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
      
      <a href={{ route('barang.create') }} style="margin-bottom: 20px;" > <i class="fas fa-plus-circle fa-2x"></i></a>
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
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            foreach ($barang as $data) { ?>
              <tr class="barang">
                <td scope="row">{{ $no++ }}</td>
                <td>
                  {{-- <input type="text" class="kode-barang" id="idbarang" value="{{ $data->KodeBrg }}" readonly> --}}
                  {{ $data->KodeBrg }}
                </td>
                <td>{{ $data->NamaBrg }}</td>
                <td>{{ round($data->BeratStandart, 2) }}</td>
                <td>{{ $data->Satuan }}</td>
                <td>{{ round($data->IsiPerKarton, 0) }}</td>
                <td>{{ round($data->SaldoPcs, 2) }}</td>
                <td>{{ round($data->SaldoKg, 2) }}</td>
                <td>{{ $data->WeightValue }}</td>
                <td>
                  <button type="button" class="btn btn-primary mutasi" data-toggle="modal" data-target="#exampleModalCenter">
                    Launch demo modal
                  </button>
                  
                  <!-- Modal -->
                  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="{{ route('barang.mutasi', ['kodebarang' => trim($data->KodeBrg)]) }}" method="POST">
                          {{ csrf_field() }}
                          {{-- {{ method_field('PUT') }} --}}
                          <div class="modal-body">
                            <label for="">Periode</label>
                            <input type="text" name="periode" id="periode" >
                            {{-- <input type="text" name="kodebarang" id="kodebarang"> --}}
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Save changes</button>
                          </div>
                        </form>
                      </div>
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