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
      @if ($message = Session::get('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        <strong>{{ $message }}</strong>
      </div>
    @endif
    
    <div class="card-body">
        <a href="{{ route('mkt.create.mod') }}" style="margin-bottom: 20px;" > <i class="fas fa-plus-circle fa-2x"></i></a>
        <table class="table table-bordered" id="data_mod">
          <thead>
            <tr>
                <th>Tanggal</th>
                <th>No MOD</th>
                <th>Customer</th>
                <th>Kota</th>
                <th>Total Crt</th>
                <th>Total Ecr</th>
                <th>Total</th>
                <th>Cetak</th>
                <th>Blocked</th>
                <th>Keterangan</th>
                <th>Action</th>
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
    $(document).ready(function() {
        $("#data_mod").DataTable({
            // dom: 'Bfrtip',
            pageLength: 20,
            processing: true,
            serverSide: true,
            ajax: "{{ route('mkt.index.mod') }}",
            columns: [
                { data: 'TglOrder', name: 'TglOrder' },
                { data: 'NoBukti', name: 'NoBukti' },
                { data: 'NamaCust', name: 'NamaCust' },
                { data: 'ShortName', name: 'ShortName' },
                { data: 'qtyCrt', name: 'qtyCrt' },
                { data: 'qtyEcr', name: 'qtyEcr' },
                { data: 'total', name: 'total' },
                { data: 'Print', name: 'Print' },
                { data: 'Blocked', name: 'Blocked' },
                { data: 'Keterangan', name: 'Keterangan' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: ['1', 'desc'],
        // select: true,
        })
    })
</script>

@endsection