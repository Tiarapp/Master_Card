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
            <h1 class="m-0">MOD</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">MOD</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

     <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
          <strong>{{ $message }}</strong>
        </div>
      @endif    
      <div class="card-body">
        <table class="table table-bordered" id="data_mod">
          <thead>
            <tr>
              <th scope="col">No Bukti</th>
              <th scope="col">Customer</th>
              <th scope="col">Quantity</th>
              <th scope="col">Nilai</th>
              <th scope="col">Alasan</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ route('acc.mod.disapprove') }}" method="POST">
              {{ csrf_field() }}
              {{-- {{ method_field('PUT') }} --}}
              <div class="modal-body">
                <label for="">Alasan</label>
                <input type="text" name="alasan" id="alasan" >
                <input type="text" name="kodebarang" id="kodebarang">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"> 
                  Close 
                </button>
                <button type="submit" class="btn btn-primary">
                  Save changes
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
  @endsection

@section('javascripts')
<!-- DataTables -->
<script> 
   $(document).ready(function(){
    $("#data_mod").DataTable({
        "scrollX": true,
        "scrollY": "auto",
        pageLength: 20,
        processing: true,
        serverSide: true,
        ajax: "{{ route('acc.mod.index') }}",
        columns: [
            { data: 'NoBukti', name: 'NoBukti' },
            { data: 'NamaCust', name: 'NamaCust' },
            { data: 'qtyEcr', name: 'qtyEcr' },
            { data: 'total', name: 'total' },
            { data: 'ALASAN', name: 'ALASAN' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: ['1', 'desc'],
     });   
   });

   $(document).on("click", '.tolak', function() {
    kodebarang = $(this).val();
    
    document.getElementById("kodebarang").value = kodebarang;
    
   })
</script>

@endsection