@extends('admin.templates.partials.default')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Marketing Order</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">MOD</li>
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
                <th scope="col">TOP</th>
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
        try {
            // Check if DataTable is already initialized and destroy it
            if ($.fn.DataTable.isDataTable('#data_barang')) {
                $('#data_barang').DataTable().destroy();
            }
            
            // Clear the table body
            $('#data_barang tbody').empty();
            
            // Initialize new DataTable
            $("#data_barang").DataTable({
                dom: 'Bfrtip',
                pageLength: 100,
                processing: true,
                serverSide: true,
                ajax: {
                    url: 'mod_by_tanggal/'+tanggal,
                    error: function(xhr, error, code) {
                        console.log('DataTable Ajax Error:', error);
                        alert('Error loading data: ' + error);
                    }
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
                {
                    data: 'WaktuBayar',
                    name: 'WaktuBayar',
                },
            
            ],
            order: ['3', 'asc'],
            select: true,
            });
        } catch (error) {
            console.error('DataTable initialization error:', error);
            alert('Error initializing table: ' + error.message);
        }
    }
   }
</script>

@endsection