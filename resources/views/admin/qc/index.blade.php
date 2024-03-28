
<!-- jQuery -->
<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>

@extends('admin.templates.partials.default')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
          
          @if ($message = Session::get('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <strong>{{ $message }}</strong>
          </div>
          @endif
          <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Plan Corrugating</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Plan Corrugating</li>
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
        <a href="{{ route('qc.create') }}" style="margin-bottom: 20px;"> <i class="fas fa-plus-circle fa-2x"></i></a>
        <div class="card-body">
            <table class="table table-bordered" id="testqc">
            <thead>
                <tr>
                <th scope="col">ID</th>
                <th scope="col">No Analisa</th>
                <th scope="col">Customer</th>
                <th scope="col">Box</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($data as $data) {
                ?>
                <tr>
                  <td>{{ $data->id }}</td>
                  <td>{{ $data->no_analisa }}</td>
                  <td>{{ $data->cust }}</td>
                  <td>{{ $data->item }}</td>
                  <td>
                    <a href="../admin/qc/edit/{{ $data->id }}" class="btn btn-outline-secondary" type="button">Edit</a>
                    <a href="../admin/qc/print/{{ $data->id }}" class="btn btn-outline-secondary" type="button">Print</a>
                    <a href="../admin/qc/delete/{{ $data->id }}" class="btn btn-outline-secondary" onclick="return confirm('Are you sure?')" type="button">Hapus</a>
                  </td>
                </tr>
                <?php
                    }   
                ?>
            </tbody>
            </table>
        </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
  @endsection

  @section('javascripts')
  <!-- DataTables -->
  <script>
    $(document).ready(function() {
      $("#testqc").DataTable({
        // "scrollX": true,
        // "scrollY": "auto",
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