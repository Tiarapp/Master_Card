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
            <h1 class="m-0">Form Mastercard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Form Mastercard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

     <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
           
      <div>
        <input type="date" name="tgl_mod" id="tgl_mod" onchange="getMOD()">
      </div>
      <div class="card-body">
        <table class="table table-bordered" id="data_barang">
          <thead>
            <tr>
                <th scope="col">Tgl Order</th>
                <th scope="col">Customer</th>
                <th scope="col">Kontrak</th>
                <th scope="col">MOD</th>
                <th scope="col">Nama Item</th>
                <th scope="col">Quantity</th>
            </tr>
          </thead>
          <tbody>
            
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
   function getMOD() {
    tanggal = document.getElementById("tgl_mod").value ;

    console.log(tanggal);
    
    if (tanggal) {
        $("#data_barang").DataTable({
            dom: 'Bfrtip',
            pageLength: 50,
            processing: true,
            serverSide: true,
            ajax: {
                url: 'mod/'+tanggal,
                // dataSrc: ''
            },
            columns: [{
                data: 'TglOrder',
                name: 'TglOrder',
            },
            {
                data: 'NamaCust',
                name: 'NamaCust',
            },
            {
                data: 'NomerSC',
                name: 'NomerSC',
            },
            {
                data: 'NoMOD',
                name: 'NoMOD',
            },
            {
                data: 'NamaBrg',
                name: 'NamaBrg',
            },
            {
                data: 'Quantity',
                name: 'Quantity',
            },
        
        ],
        select: true,
        })
    }
   }
</script>

@endsection