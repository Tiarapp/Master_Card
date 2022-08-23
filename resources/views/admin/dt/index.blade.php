<!-- jQuery -->
<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>

@extends('admin.templates.partials.default')


@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header"> @if ($message = Session::get('success'))
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
          <h1 class="m-0">Delivery Time</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Delivery Time</li>
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

      {{-- <a href="{{ route('divisi.create') }}" style="margin-bottom: 20px;margin-left: 20px;"> <i class="fas fa-plus-circle fa-2x"></i></a> --}}
      <div class="card-body">
        <table class="table table-bordered" id="data_divisi">
          <thead>
            <tr>
              <th scope="col">No.</th>
              <th scope="col">Kontrak</th>
              <th scope="col">Delivery</th>
              <th scope="col">Qty Kirim</th>
              <th scope="col">DT Perubahan</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            foreach ($dt as $data) { ?>
              <tr>
                <td scope="row">{{ $no++ }}</td>
                <td>{{ $data->kodeKontrak }}</td>
                <td>{{ $data->tglKirimDt }}</td>
                <td>{{ $data->pcsDt }}</td>
                <td>{{ $data->dt_perubahan }}</td>
                <td>
                  <div class="input-group">
                    <div class="input-group-append" id="button-addon4">
                      <?php
                        if ($data->approve_mkt == 0 && $data->approve_ppic == 1) {
                      ?>    
                      <a href="../admin/dt/approve/{{ $data->id }}" class="btn btn-outline-success" type="button">
                        Need Approve MKT
                      </a>
                      <?php  }  
                      else if ($data->approve_mkt == 1 && $data->approve_ppic == 0) {
                      ?>    
                        <a href="../admin/dt/approve/{{ $data->id }}" class="btn btn-outline-success" type="button">
                          Need Approve PPIC
                        </a>
                      <?php
                      }
                      ?>
                      <a href="../admin/dt/edit/{{ $data->id }}" class="btn btn-outline-warning" type="button">
                        <i class="fa fa-edit" data-toggle="tooltip" data-placement="bottom" title="edit" id="edit"></i>
                      </a>
                      <a href="../admin/dt/delete/{{ $data->id }}" class="btn btn-outline-danger" type="button">
                        <i class="far fa-window-close" data-toggle="tooltip" data-placement="bottom" title="delete" id="delete"></i>
                      </a>
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
    $(document).ready(function() {
      $("#data_divisi").DataTable({
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
        select: true
      });
    });
  </script>

  @endsection