<!-- jQuery -->
<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>

@extends('admin.templates.partials.default')


{{-- <style>
  td, tr {
    border:1px solid black !important;
  }
</style> --}}

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    @if ($message = Session::get('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        <strong>{{ $message }}</strong>
      </div>
    @endif
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Kontrak Open</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Kontrak Open</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="form-group">
        <div class="row">
        </div>
      </div>
      <!-- Small boxes (Stat box) -->

      {{-- <a href="{{ route('opi.create') }}" style="margin-bottom: 20px;"> <i class="fas fa-plus-circle fa-2x"></i></a> --}}
      <div class="card-body">
        <table class="table table-bordered" id="data_stationary">
          <thead>
            <tr>
              <th scope="col">Kode Barang</th>
              <th scope="col">Nama Barang</th>
              <th scope="col">Spesifikasi</th>
              <th scope="col">Saldo Akhir Primer</th>
              <th scope="col">Saldo Akhir Sekunder</th>
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
    $(document).ready(function() {
        var table = $('#data_stationary').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('kontrak.opened') }}"
            },
            columns: [
                { data: 'kode', name: 'kode' },
                { data: 'tglKontrak', name: 'tglKontrak' },
                { data: 'customer_name', name: 'customer_name' },
                { data: 'poCustomer', name: 'poCustomer' },
                { data: 'sales', name: 'sales' },
                { data: 'action', name: 'action' }
            ],
            order: [1, 'desc']
        })

        // $('#search').click(function() {
        //     table.ajax.reload()
        // })
    })
  </script>

  @endsection