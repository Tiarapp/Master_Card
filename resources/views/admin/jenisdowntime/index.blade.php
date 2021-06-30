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
          <h1 class="m-0">Jenis Downtime</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Jenis Downtime</li>
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
      
      <a href="{{ route('jenisdowntime.create') }}" style="margin-bottom: 20px;"> <i class="fas fa-plus-circle fa-2x"></i></a>
      <div class="card-body">
        <table class="table table-bordered" id="data_jenisdowntime">
          <thead>
            <tr>
              <th scope="col">Mesin</th>
              <th scope="col">Downtime</th>
              <th scope="col">Category</th>
              <th scope="col">Yang diperbolehkan</th>
              <th scope="col">Branch</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            foreach ($jenisdowntime as $data) { ?>
              <tr>
                <td scope="row">{{ $no++ }}</td>
                <td>{{ $data->mesin }}</td>
                <td>{{ $data->downtime }}</td>
                <td>{{ $data->category }}</td>
                <td>{{ $data->allowedMinute }}</td>
                <td>{{ $data->branch }}</td>
                <td>
                  <div class="input-group">
                    <div class="input-group-append" id="button-addon4">
                      <a href="../admin/jenisdowntime/show/{{ $data->id }}" class="btn btn-outline-secondary" type="button">View</a>
                      <a href="../admin/jenisdowntime/edit/{{ $data->id }}" class="btn btn-outline-secondary" type="button">Edit</a>
                      <a href="../admin/jenisdowntime/delete/{{ $data->id }}" class="btn btn-outline-danger" type="button">Delete</a>
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
  
  
  $table->id('id');
  $table->foreignId('mesin_id')->index();
  $table->string('downtime')->index();
  $table->enum('category',['CORR','PRINTING','FINISHING','MEKANIK'])->index();  //INPUT IT
  
  $table->integer('allowedMinute')->index();
  // TRACKING
  $table->string('createdBy');                    //Auto ambil dari login
  $table->string('lastUpdatedBy')->nullable();    //Auto ambil dari login
  $table->dateTime('deletedAt')->nullable();      //Auto ambil dari today()
  $table->string('deletedBy')->nullable();        //Auto ambil dari login
  $table->integer('printedKe')->nullable();       //Auto ambil dari login
  $table->dateTime('printedAt')->nullable();      //Auto ambil dari login
  $table->string('branch')->default('Lamongan')->index();              //Auto ambil dari login awal
  $table->timestamps();
  
  @section('javascripts')
  <!-- DataTables -->
  <script>
    $(document).ready(function() {
      $("#data_flute").DataTable({
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