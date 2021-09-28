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

      <a href="{{ route('opi.create') }}" style="margin-bottom: 20px;"> <i class="fas fa-plus-circle fa-2x"></i></a>
      <div class="card-body">
        <table class="table table-bordered" id="data_opi">
          <thead>
            <tr>
              <th scope="col">No.</th>
              <th scope="col">No OPI</th>
              <th scope="col">Action</th>
              <th scope="col">Tgl OPI</th>
              <th scope="col">Kontrak</th>
              <th scope="col">DT</th>
              <th scope="col">QTY Kirim</th>
              <th scope="col">Customer</th>
              <th scope="col">Item</th>
              <th scope="col">Qty Order</th>
              <th scope="col">keterangan</th>
              <th scope="col">OPI</th>
              <th scope="col">PO Customer</th>
              <th scope="col">No MC</th>
              <th scope="col">Hari</th>
              <th scope="col">Flute</th>
              <th scope="col">Bentuk</th>
              <th scope="col">Sheet P</th>
              <th scope="col">Sheet L</th>
              <th scope="col">Out</th>
              <th scope="col">Tipe Order</th>
              <th scope="col">Warna</th>
              <th scope="col">Finishing</th>
              <th scope="col">Kualitas Produksi</th>
              <th scope="col">Gram</th>
              <th scope="col">Tanggal Order</th>
              <th scope="col">Alamat</th>
              <th scope="col">Toleransi (lebih/kurang)</th>
              <th scope="col">Box P</th>
              <th scope="col">Box L</th>
              <th scope="col">Box T</th>
              <th scope="col">Koli</th>
              <th scope="col">DT Perubahan</th>
              <th scope="col">Harga (kg)</th>
            </tr>
          </thead>
          <tbody>
            {{-- <?php 
            // $no = 1;
            // foreach ($data as $data) { 
               ?> --}}
              {{-- <tr> --}}
                {{-- <td scope="row">{{ $data->id }}</td> --}}
                {{-- <td> --}}
                  {{-- <div class="input-group"> --}}
                    {{-- <div class="input-group-append" id="button-addon4"> --}}
                      {{-- <a href="../admin/sj_palet/show/{{ $data->id }}" class="btn btn-outline-secondary" type="button">View</a> --}}
                      {{-- <a href="../admin/opi/pdf/{{ $data->id }}" class="btn btn-outline-secondary" type="button">Print</a> --}}
                      {{-- <a href="../admin/kontrak/edit/{{ $data->id }}" class="btn btn-outline-secondary" type="button">Edit</a> --}}
                      {{-- <a href="../admin/sj_palet/delete/{{ $data->id }}" class="btn btn-outline-danger" type="button">Delete</a> --}}
                    {{-- </div> --}}
                  {{-- </div> --}}
                {{-- </td> --}}
                {{-- <td><b>{{ $data->noOPI }}</b></td> --}}
                {{-- <td>{{ $data->kode }}</td> --}}
                {{-- <td>{{ $data->tglKirimDt }}</td> --}}
                {{-- <td>{{ $data->pcsDt }}</td> --}}
                {{-- <td>{{ $data->namaBarang }}</td> --}}
                {{-- <td>{{ $data->status }}</td> --}}
                {{-- <td>{{ $data->noPoCustomer }}</td> --}}
              {{-- </tr> --}}
            {{-- <?php 
            // }
             ?> --}}
          {{-- </tbody> --}}
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
      $('#data_opi').DataTable({
        // "scrollY": "auto",
        processing:true,
        serverSide:true,
        ajax:"{{ route('opi') }}",
        columns: [
          { data: 'id', name: 'id' },
          { data: 'noOPI', name: 'noOPI' },
          {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
          },
          { data: 'tglopi', name: 'tglopi' },
          { data: 'kode', name: 'kode' },
          { data: 'tglKirimDt', name: 'tglKirimDt' }, 
          // { data: 'tglKontrak', name: 'tglKontrak' },
          // { name: 'mod' },
          { data: 'pcsDt', name: 'pcsDt' },
          { data: 'Cust', name: 'Cust' },
          { data: 'namaBarang', name: 'namaBarang' },
          { data: 'pcsKontrak', name: 'pcsKontrak' },
          { data: 'keterangan', name: 'keterangan' },
          { data: 'noOPI', name: 'noOPI' },
          { data: 'poCustomer', name: 'poCustomer' },
          { data: 'mcKode', name: 'mcKode' },
          { 
            data: 'hari',
            name: 'hari',
            orderable: false,
            searchable: false
          },
          { data: 'flute', name: 'flute' },
          { data: 'tipeBox', name: 'tipeBox' },
          { data: 'panjangSheet', name: 'panjangSheet' },
          { data: 'lebarSheet', name: 'lebarSheet' },
          { data: 'outConv', name: 'outConv' },
          { data: 'tipeOrder', name: 'tipeOrder' },
          { data: 'namacc', name: 'namacc' },
          { data: 'joint', name: 'joint' },
          { data: 'subsP', name: 'subsP' },
          { data: 'gram', name: 'gram' },
          { data: 'tglKontrak', name: 'tglKontrak' },
          { data: 'alamatKirim', name: 'alamatKirim' },
          { data: 'toleransi', name: 'toleransi' },
          { data: 'panjang', name: 'panjang' },
          { data: 'lebar', name: 'lebar' },
          { data: 'tinggi', name: 'tinggi' },
          { data: 'koli', name: 'koli' },
          { data: 'tglKirimDt', name: 'tglKirimDt' },
          { data: 'harga_kg', name: 'harga_kg' },
        ],
        "columnDefs": [
        {
          'targets': [0
          ],
          'render': function(data, type, full, meta){
            if(type === 'display'){
              data = strtrunc(data, 10);
            }
            return data;
          }
        }
        ],
        "order": [2, 'desc'],
        "pageLength": 1000,
        dom: 'Bftrip',
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
        // "scrollX": true,
        select: true,
      });
    });
  </script>

  @endsection