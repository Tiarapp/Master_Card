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
      <!-- Small boxes (Stat box) -->

      {{-- <a href="{{ route('opi.create') }}" style="margin-bottom: 20px;"> <i class="fas fa-plus-circle fa-2x"></i></a> --}}
      <div class="card-body">
        
      <button id="processSelected" class="btn btn-primary">Approve Data</button>
        <table class="table table-bordered" id="data_opi">
          <thead>
            <tr>
              <th><input type="checkbox" id="selectAll"></th>
              <th scope="col">OPI</th>
              <th scope="col">Kontrak</th>
              <th scope="col">Tgl Kirim</th>
              <th scope="col">QTY Kirim</th>
              <th scope="col">Item</th>
              <th scope="col">Customer</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          {{-- <tbody>
            @foreach ($opi as $data)
            <tr>
                <td>{{ $data->NoOPI }}</td>
                <td>{{ $data->kode }}</td>
                <td>{{ $data->tglKirimDt }}</td>
                <td>{{ $data->jumlahOrder }}</td>
                <td>{{ $data->Cust }}</td>
                <td>{{ $data->namaBarang }}</td>
                <td>{{ $data->pcsKontrak }}</td>
                <td>
                  <div class="input-group">
                    <div class="input-group-append" id="button-addon4">
                      <a href="../ppic/opi_approve_proses/{{ $data->id }}" class="btn btn-outline-secondary" type="button">Approve</a>
                    </div>
                  </div>
                </td>
            </tr>
              @endforeach
          </tbody> --}}
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
      const table = $('#data_opi').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('opi.approve') }}",
        columns: [
          { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
          { data: 'NoOPI', name: 'NoOPI' },
          { data: 'kode', name: 'kode'},
          { data: 'tglKirimDt', name: 'tglKirimDt'},
          { data: 'pcsDt', name: 'pcsDt'},
          { data: 'namaBarang', name: 'namaBarang'},
          { data: 'Cust', name: 'Cust'},
          { data: 'action', name: 'action'},
        ]
      })
      
    $('#selectAll').on('change', function() {
        $('.rowCheckbox').prop('checked', $(this).prop('checked'));
    });

    $('#processSelected').click(function() {
        let selectedIds = [];
        $('.rowCheckbox:checked').each(function() {
            selectedIds.push($(this).val());
        });

        if (selectedIds.length === 0) {
            alert('Silakan pilih setidaknya satu data!');
            return;
        }
        

        $.ajax({
            url: '/approve',
            type: 'POST',
            data: {
                ids: selectedIds,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                alert(response.message);
                table.ajax.reload(); // Reload DataTables jika perlu
            },
            error: function(xhr) {
                alert('Terjadi kesalahan, coba lagi!');
            }
        });
    });

      // table.on('click', 'tbody tr', function (e) {
      //   e.currentTarget.classList.toggle('selected');
      // })
    })

    
  </script>

  @endsection