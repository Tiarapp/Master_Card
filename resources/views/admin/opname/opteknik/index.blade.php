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
          <h1 class="m-0">Opname Teknik</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Opbame Roll</li>
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

      <a href="../opname/teknik/create" style="margin-bottom: 20px;"> <i class="fas fa-plus-circle fa-2x"></i></a>
      &nbsp&nbsp&nbsp
      <a href="../opname/teknik/result" style="margin-bottom: 20px;"> <i class="fas fa-poll">Laporan</i></a>
      <button type="button" class="btn btn-primary mr-5" data-toggle="modal" data-target="#importExcel">
        IMPORT EXCEL
      </button>

      <div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <form method="post" action="../opname/teknik/import" enctype="multipart/form-data">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
              </div>
              <div class="modal-body">
   
                {{ csrf_field() }}
   
                <label>Pilih file excel</label>
                <div class="form-group">
                  <input type="file" name="file" required="required">
                </div>
   
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Import</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="card-body">
        <table class="table table-bordered" id="data_teknik">
          <thead>
            <tr>
              <th scope="col">No.</th>
              <th scope="col">Kode</th>
              <th scope="col">Nama Barang</th>
              <th scope="col">Satuan</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            foreach ($teknik as $data) { ?>
              <tr>
                <td scope="row">{{ $no++ }}</td>
                <td>{{ $data->KodeBrg }}</td>
                <td>{{ $data->NamaBrg." ".$data->Merk." ".$data->Tipe." ". $data->Spesifikasi }}</td>
                <td>{{ $data->SatuanP }}</td>
                <td>
                  <div class="input-group">
                    <div class="input-group-append" id="button-addon4">
                      {{-- <a href="../opname/sheet/show/{{ $data->KodeBrg }}" class="btn btn-outline-secondary" type="button">View</a> --}}
                      <a href="../opname/teknik/edit/{{ $data->KodeBrg }}" class="btn btn-outline-secondary" type="button">Opname</a>
                      {{-- <a href="../opname/sheet/delete/{{ $data->KodeBrg }}" class="btn btn-outline-danger" type="button">Delete</a> --}}
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
      $("#data_teknik").DataTable({
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