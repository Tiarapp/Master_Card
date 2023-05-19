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
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">BBM Roll</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">BBM Roll</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    @if ($message = Session::get('succes'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>{{ $message }}</strong>
        </div>
    @endif
    @if ($message = Session::get('error'))
        @include('sweetalert::alert')
    @endif
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      
      <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">
        <a href="{{ route('roll.createbbm') }}" style="margin-bottom: 20px; color:white;" >BBM Roll</a>
      </button>
      <div class="card-body">
        <table class="table table-bordered" id="data_planconv">
          <thead>
            <tr>
              {{-- <th scope="col">No.</th> --}}
              <th scope="col">Tanggal BBM</th>
              <th scope="col">Kode Internal</th>
              <th scope="col">Nama Roll</th>
              <th scope="col">Gram</th>
              <th scope="col">Lebar</th>
              <th scope="col" style="width: 100px">Berat SJ (kg)</th>
              <th scope="col" style="width: 100px">Berat timbang (kg)</th>
              <th scope="col" style="width: 100px">PO</th>
              <th scope="col">Supplier</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
              <?php foreach ($bbm as $data) { ?>
            <tr>
                <td scope="col">{{ $data->tgl_bbm }}</td>
                <td scope="col">{{ $data->rolld->kode_internal }}</td>
                <td scope="col">{{ $data->rolld->rollMaster->nama }}</td>
                <td scope="col">{{ $data->rolld->rollMaster->gram }}</td>
                <td scope="col">{{ $data->rolld->rollMaster->lebar }}</td>
                <td scope="col" style="width: 100px">{{ $data->berat_sj }}</td>
                <td scope="col" style="width: 100px">{{ $data->berat_timbang }}</td>
                <td scope="col">{{ $data->no_po }}</td>
                <td scope="col">{{ $data->rolld->supp->name }}</td>
                <td scope="col">
                  <div class="input-group">
                    <div class="input-group-append" id="button-addon4">
                        <a href="../roll/edit/{{ $data->rolld->id }}" class="btn btn-outline-secondary" type="button">Edit</a>
                        {{-- <a href="../admin/roll/bbk/{{ $data->id }}" class="btn btn-outline-secondary" type="button">BBK</a>
                        <a href="../admin/roll/returbbk/{{ $data->id }}" class="btn btn-outline-secondary" type="button">Retur</a> --}}
                      {{-- <a href="../opname/sheet/delete/{{ $data->KodeBrg }}" class="btn btn-outline-danger" type="button">Delete</a> --}}
                    </div>
                  </div>
                </td>
            </tr>
              <?php } ?>
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
    
    function strtrunc(str, max, add){
      add = add || '...';
      return (typeof str === 'string' && str.length > max ? str.substring(0, max) + add : str);
    };
    $(function(){
      $('#data_planconv').DataTable({
        // "scrollY": "auto",
      })
    });
  </script>

  @endsection