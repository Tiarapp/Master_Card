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
          <h1 class="m-0">Stationary</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Stationary</li>
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
        <table class="table table-bordered" id="data_jobs">
          <thead>
            <tr>
              <th scope="col">Tanggal</th>
              <th scope="col">Kode</th>
              <th scope="col">Pemohon</th>
              <th scope="col">Alasan</th>
              <th scope="col">Status</th>
              <th scope="col">PIC</th>     
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
        var table = $('#data_jobs').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('job.index') }}"
            },
            columns: [
                { data: 'tanggal', name: 'tanggal' },
                { data: 'kontrak', name: 'kontrak' },
                { data: 'pemohon', name: 'pemohon' },
                { data: 'alasan', name: 'alasan' },
                { data: 'status', name: 'status' },
                { data: 'pic', name: 'pic' },
                { data: 'action', name: 'action' }
            ],
            order: [0, 'desc']
        })

        // $('#search').click(function() {
        //     table.ajax.reload()
        // })
    })
  </script>

  @endsection