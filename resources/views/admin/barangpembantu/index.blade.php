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
              <th scope="col">Kode</th>
              <th scope="col">Nama</th>
              <th scope="col">Satuan Primer</th>
              <th scope="col">Satuan Sekunder</th>
              <th scope="col">Berat std</th>
              <th scope="col">Saldo Primer</th>
              <th scope="col">Saldo Sekunder</th>
              {{-- <th scope="col">Mastercard ID</th> --}}
              <th scope="col">Action</th>
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
   $(document).ready(function(){
     $("#data_barang").DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: "{{ route('fb.list.bp') }}"
      },
      columns: [
        { data: 'KodeBrg', name: 'KodeBrg'},
        { data: 'NamaBrg', name: 'NamaBrg'},
        { data: 'SatuanP', name: 'SatuanP'},
        { data: 'SatuanS', name: 'SatuanS'},
        { data: 'berat', name: 'berat'},
        { data: 'saldo_pcs', name: 'saldo_pcs'},
        { data: 'saldo_kg', name: 'saldo_kg'},
        { data: 'action', name: 'action'},
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