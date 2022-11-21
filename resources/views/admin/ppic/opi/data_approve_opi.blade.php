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
      <div class="form-group">
        <div class="row">
          <div class="col-md-6">
              <input type="date" name="mulai" id="mulai" required>
              <input type="date" name="end" id="end" required>
              <button name="search" id="search"> Search </button>
            {{-- </form> --}}
          </div>
        </div>
      </div>
      <!-- Small boxes (Stat box) -->

      {{-- <a href="{{ route('opi.create') }}" style="margin-bottom: 20px;"> <i class="fas fa-plus-circle fa-2x"></i></a> --}}
      <div class="card-body">
        <table class="table table-bordered" id="data_opi">
          <thead>
            <tr>
              <th scope="col">OPI</th>
              <th scope="col">Kontrak</th>
              <th scope="col">Tgl Kirim</th>
              <th scope="col">QTY Kirim</th>
              <th scope="col">Customer</th>
              <th scope="col">Item</th>
              <th scope="col">Qty Order</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
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
    $(function(){

      $('#search').click(function() {
        var mulai = document.getElementById("mulai").value;
        var end = document.getElementById("end").value;

        if (mulai !== '' && end !== '') {
          $('#data_opi').DataTable({
            "bDestroy": true,
            "searching": false,
            "processing":true,
            "serverSide":true,
            "ajax":{
              "url": "../ppic/opidata?mulai="+mulai+"&end="+end,
              "dataType": "json",
              "type": "GET",
              "data":{_token: "{{ csrf_token() }}"}
            },
            "columns": [
              {"data": "NoOPI" },
              {"data": "kode" },
              {"data": "tglKirimDt"},
              {"data": "pcsDt" },
              {"data": "Cust" },
              {"data": "namaBarang" },
              {"data": "jumlahOrder" },
              {"data": "keterangan" },
              {"data": "poCustomer" },
              {"data": "mcKode" },
              {"data": "revisimc" },
              {"data": "flute" },
              {"data": "tipeBox"},
              {"data": "panjangSheet" },
              {"data": "lebarSheet" },
              {"data": "outConv" },
              {"data": "tipeOrder" },
              {"data": "namacc" },
              {"data": "joint"},
              {"data": "kertasMcAtas" },
              {"data": "gramKertasAtas" },
              {"data": "gramKertasflute1" },
              {"data": "gramKertastengah" },
              {"data": "gramKertasflute2"},
              {"data": "gramKertasbawah" },
              {"data": "kertasMcbawah" },
              {"data": "wax" },
              {"data": "gramSheet" },
              {"data": "toleransiLebih" },
              {"data": "toleransiKurang" },
              {"data": "panjang" },
              {"data": "lebar" },
              {"data": "tinggi" },
              {"data": "koli"},
              {"data": "tipeCreasCorr" },
              {"data": "bungkus" },
            ],
          "paging": false,
          dom: 'Bftrip',
          buttons: [
            'excel',
          ],
          });
        }
      })
    });

    
  </script>

  @endsection