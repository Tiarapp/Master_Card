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
          <h1 class="m-0">Hasil Plan Converting</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Hasil Plan Flexo</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
    <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">
      <a href="{{ route('conv.hasilflexo') }}" style="margin-bottom: 20px; color:white;" >FLEXO</a>
    </button>
    
    <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">
      <a href="{{ route('conv.hasiltokai') }}" style="margin-bottom: 20px; color:white;" >TOKAI</a>
    </button>

    <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">
      <a href="{{ route('conv.hasilstich') }}" style="margin-bottom: 20px; color:white;" >STICHING</a>
    </button>
    
    <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">
      <a href="{{ route('conv.hasilwax') }}" style="margin-bottom: 20px; color:white;" >WAX</a>
    </button>
    
    <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">
      <a href="{{ route('conv.hasilslitter') }}" style="margin-bottom: 20px; color:white;" >SLITTER</a>
    </button>

      <div class="card-body">
        <table class="table table-bordered" id="data_hasilconvflexo">
          <thead>
            <tr>
              <th scope="col">Kode Plan</th>
              <th scope="col">MC</th>
              <th scope="col">No OPI</th>
              <th scope="col">Tanggal Kirim</th>
              <th scope="col">Jumlah Plan</th>
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
    
    function strtrunc(str, max, add){
      add = add || '...';
      return (typeof str === 'string' && str.length > max ? str.substring(0, max) + add : str);
    };
    $(function(){
      $('#data_hasilconvflexo').DataTable({
        // "scrollY": "auto",
        processing:true,
        serverSide:true,
        ajax:"{{ route('convd.flexo') }}",
        columns: [
          { data: 'kodeplanM', name: 'kodeplanM' },
          { data: 'nomc', name: 'nomc' },
          { data: 'noopi', name: 'noopi' },
          { data: 'tgl_kirim', name: 'tgl_kirim' },
          { data: 'pcsKontrak', name: 'pcsKontrak' },
          {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
          },
        ],
        "columnDefs": [
        {
          'targets': [0
          ],
          'render': function(data, type, full, meta){
            if(type === 'display'){
              data = strtrunc(data, 20);
            }
            return data;
          }
        }
        ],
        "order": [0, 'asc'],
        "pageLength": 1000,
        dom: 'Bftrip',
        buttons: [
          'copy',
          'excel',
          'pdf',
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
        // "scrollX": true,
        select: true,
      });
    });
  </script>

  @endsection