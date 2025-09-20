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
          <h1 class="m-0">Roll</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Roll</li>
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
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="card-body">
        <table class="table table-bordered" id="data_planconv">
          <thead>
            <tr>
              {{-- <th scope="col">No.</th> --}}
              <th scope="col">Tanggal</th>
              <th scope="col">Kode Internal</th>
              <th scope="col">Jenis</th>
              <th scope="col">Kode Roll</th>
              <th scope="col">Gsm</th>
              <th scope="col">Lebar</th>
              <th scope="col">Berat SJ</th>
              <th scope="col">Berat Timbang</th>
              <th scope="col">Stok (Kg)</th>
              <th scope="col">Supplier</th>
              <th scope="col">No PO</th>
              <th scope="col">Warna</th>
              <th scope="col">Keterangan</th>
              <th scope="col">Kolom</th>
              <th scope="col">Gsm Act</th>
              <th scope="col">Persent Gsm</th>
              <th scope="col">Cobsize Top</th>
              <th scope="col">Cobsize Back</th>
              <th scope="col">RCT CD</th>
              <th scope="col">RCT MD</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
              @foreach ($rollinventories as $rollinventory )
                <tr>
                  <td>{{ $rollinventroy->tanggal }}</td>
                  <td>{{ $rollinventory->kode_internal }}</td>
                  <td>{{ $rollinventory->jenis }}</td>
                  <td>{{ $rollinventory->kode_roll }}</td>
                  <td>{{ $rollinventory->gsm }}</td>
                  <td>{{ $rollinventory->lebar }}</td>
                  <td>{{ $rollinventory->berat_sj }}</td>
                  <td>{{ $rollinventory->berat_timbang }}</td>
                  <td>{{ $rollinventory->stok }}</td>
                  <td>{{ $rollinventory->supplier->nama }}</td>
                  <td>{{ $rollinventory->no_po }}</td>
                  <td>{{ $rollinventory->warna }}</td>
                  <td>{{ $rollinventory->keterangan }}</td>
                  <td>{{ $rollinventory->kolom }}</td>
                  <td>{{ $rollinventory->gsm_act }}</td>
                  <td>{{ $rollinventory->persent_gsm }}</td>
                  <td>{{ $rollinventory->cobsize_top }}</td>
                  <td>{{ $rollinventory->cobsize_back }}</td>
                  <td>{{ $rollinventory->rct_cd }}</td>
                  <td>{{ $rollinventory->rct_md }}</td>
                  <td>
                    <a href="{{ route('roll.edit', $rollinventory->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    <form action="{{ route('roll.destroy', $rollinventory->id) }}" method="POST" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                  </td>
                </tr>
              @endforeach
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
        "scrollY": "true",
      })
    });
  </script>

  @endsection