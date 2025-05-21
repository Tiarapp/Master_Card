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
          <h1 class="m-0">OPI</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">OPI</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      {{-- <div class="form-group">
        <div class="row">
          <div class="col-md-6">
              <input type="text" name="periode" id="periode" value="{{ date("m/Y") }}" required>
              <input type="date" name="end" id="end" required>
              <button name="search" id="search"> Search </button>
            </form>
          </div>
        </div>
      </div> --}}
      <!-- Small boxes (Stat box) -->

      {{-- <a href="{{ route('opi.create') }}" style="margin-bottom: 20px;"> <i class="fas fa-plus-circle fa-2x"></i></a> --}}
      <div class="card-body">
        <table class="table table-bordered" id="data_faktur">
          <thead>
            <tr>
              <th scope="col">Kode Customer</th>
              <th scope="col">Nama Customer</th>
                <th scope="col">Total Piutang</th>
                <th scope="col">Total Terima</th>
              <th scope="col">Total Piutang Customer</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            foreach ($piutang as $data) { ?>
              <tr>
                <td scope="row">{{ $data->KodeCust }}</td>
                <td>{{ $data->NamaCust }}</td>
                <td>{{ number_format($data->total_piutang, 2, '.', ',') }}</td>
                <td>{{ number_format($data->total_terima, 2, '.', ',') }}</td>
                <td>{{ number_format($data->total_piutang - $data->total_terima, 2, '.', ',') }}</td>
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
    $(document).ready(function() {
        var table = $('#data_faktur').DataTable({
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
                exportOption: {
                modifier: {
                    selected: null
                }
                }
            }
            ],
            "pageLength": 25,

            select: true
        });
    })
  </script>

  @endsection