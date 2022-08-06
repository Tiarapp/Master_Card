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
                      <a href="../admin/dt/show/{{ $data->id }}" class="btn btn-outline-success" type="button">
                        <i class="fa fa-eye" data-toggle="tooltip" data-placement="bottom" title="view" id="view"></i>
                      </a>
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