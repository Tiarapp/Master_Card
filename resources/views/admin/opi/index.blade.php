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
              <th scope="col">Kontrak</th>
              <th scope="col">Opi Ke</th>
              <th scope="col">DT</th>
              <th scope="col">QTY Kirim</th>
              <th scope="col">Customer</th>
              <th scope="col">Item</th>
              <th scope="col">Qty Order</th>
              <th scope="col">Sisa Qty Order</th>
              <th scope="col">Keterangan OPI</th>
              <th scope="col">Opi</th>
              <th scope="col">PO Customer</th>
              <th scope="col">No MC</th>
              <th scope="col">Hari</th>
              <th scope="col">Flute</th>
              <th scope="col">Bentuk</th>
              <th scope="col">Sheet P</th>
              <th scope="col">Sheet L</th>
              <th scope="col">Out</th>
              <th scope="col">UK Roll</th>
              <th scope="col">Tipe Order</th>
              <th scope="col">Warna</th>
              <th scope="col">Finishing</th>
              <th scope="col">Kualitas Produksi K/M Atas</th>
              <th scope="col">Kualitas Produksi I1</th>
              <th scope="col">Kualitas Produksi I2</th>
              <th scope="col">Kualitas Produksi I3</th>
              <th scope="col">Kualitas Produksi I4</th>
              <th scope="col">Kualitas Produksi I5</th>
              <th scope="col">Kualitas Produksi K/M Bawah</th>
              <th scope="col">Wax</th>
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
              <th scope="col">Real Kirim</th>
              <th scope="col">Sisa DT</th>
              <th scope="col">Status</th>
              <th scope="col">No Kontrak + Urut</th>
              <th scope="col">TGL Kontrak</th>
              <th scope="col">Kualitas Kontrak K/M Atas</th>
              <th scope="col">Kualitas Kontrak I1</th>
              <th scope="col">Kualitas Kontrak I2</th>
              <th scope="col">Kualitas Kontrak I3</th>
              <th scope="col">Kualitas Kontrak I4</th>
              <th scope="col">Kualitas Kontrak I5</th>
              <th scope="col">Kualitas Kontrak K/M Bawah</th>
              <th scope="col"></th>
              <th scope="col">Kode Barang</th>
              <th scope="col">Tipe Crease</th>
              <th scope="col">Bungkus</th>
              <th scope="col">Lain-Lain</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $no = 1;
            foreach ($data as $data) { 
               ?> 
              <tr>
                <td scope="row">{{ $data->opiid }}</td>
                <td><b>{{ $data->noopi }}</b></td>
                <td>
                  <div class="input-group">
                    <div class="input-group-append" id="button-addon4">
                      <a href="../admin/opi/edit/{{ $data->opiid }}" class="btn btn-outline-secondary" type="button">Edit</a>
                      <a href="../admin/opi/print/{{ $data->opiid }}" class="btn btn-outline-secondary" type="button">Print</a>
                      {{-- <a href="../admin/kontrak/edit/{{ $data->id }}" class="btn btn-outline-secondary" type="button">Edit</a>
                      <a href="../admin/sj_palet/delete/{{ $data->id }}" class="btn btn-outline-danger" type="button">Delete</a> --}}
                    </div>
                  </div>
                </td>
                {{-- <td><b>{{ $data->noopi }}</b></td> --}}
                <td>{{ $data->kode }}</td>
                <td><b>{{ $data->tglopi }}</b></td>
                <td>{{ $data->tglKirimDt }}</td>
                <td>{{ $data->pcsDt }}</td>
                <td>{{ $data->Cust }}</td>
                <td>{{ $data->namaBarang }}</td>
                <td>{{ $data->pcsKontrak }}</td>
                <td>-</td>
                <td>{{ $data->ketkontrak }}</td>
                <td>{{ $data->noopi }}</td>
                <td>{{ $data->poCustomer }}</td>
                <td>{{ $data->mcKode }}</td>
                <td>
                    <?php 
                      $day = ["MINGGU", "SENIN", "SELASA", "RABU", "KAMIS", "JUM'AT", "SABTU"];
                      $hari = $day[date('w', strtotime($data->tglKirimDt))];  
                      echo $hari;
                    ?>
                </td>
                <td>{{ $data->flute }}</td>
                <td>{{ $data->tipeBox }}</td>
                <td>{{ $data->panjangSheet }}</td>
                <td>{{ $data->lebarSheet }}</td>
                <td>{{ $data->outConv }}</td>
                <td>-</td>
                <td>{{ $data->tipeOrder }}</td>
                <td>{{ $data->ccnama }}</td>
                <td>{{ $data->joint }}</td>
                <td>{{ $data->kertasMcAtas }}</td>
                <td>{{ $data->gramKertasAtas }}</td>
                <td>{{ $data->gramKertasflute1 }}</td>
                <td>{{ $data->gramKertastengah }}</td>
                <td>{{ $data->gramKertasflute2 }}</td>
                <td>{{ $data->gramKertasbawah }}</td>
                <td>{{ $data->kertasMcbawah }}</td>
                <td>{{ $data->wax }}</td>
                <td>{{ $data->gramSheet }}</td>
                <td>{{ $data->tglKontrak }}</td>
                <td>{{ $data->alamatKirim }}</td>
                <td>-{{ $data->toleransiKurang }}/+{{ $data->toleransiKurang }}</td>
                <td>{{ $data->panjang }}</td>
                <td>{{ $data->lebar }}</td>
                <td>{{ $data->tinggi }}</td>
                <td>{{ $data->koli }}</td>
                <td>{{ $data->tglKirimDt }}</td>
                <td>{{ $data->harga_kg }}</td>
                <td>-</td>
                <td>-</td>
                <td>BELUM</td>
                <td>-</td>
                <td>{{ $data->tglKontrak }}</td>
                <td>{{ $data->kertasMcAtasK }}</td>
                <td>{{ $data->gramKertasAtasK }}</td>
                <td>{{ $data->gramKertasflute1K }}</td>
                <td>{{ $data->gramKertastengahK }}</td>
                <td>{{ $data->gramKertasflute2K }}</td>
                <td>{{ $data->gramKertasbawahK }}</td>
                <td>{{ $data->kertasMcbawahK }}</td>
                <td></td>
                <td>{{ $data->kodeBarang }}</td>
                <td>{{ $data->tipeCreasCorr }}</td>
                <td>{{ $data->bungkus }}</td>
                <td></td>
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
    function strtrunc(str, max, add){
      add = add || '...';
      return (typeof str === 'string' && str.length > max ? str.substring(0, max) + add : str);
    };
    $(function(){
      $('#data_opi').DataTable({
        // "initComplete": function (settings, json) {  
        //     $("#data_opi").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
        // },
        // "scrollY": "auto",
        // processing:true,
        // serverSide:true,
        // ajax:"{{ route('opi') }}",
        // columns: [
        //   { data: 'opiid', name: 'opiid' },
        //   { data: 'noopi', name: 'noopi' },
        //   {
        //     data: 'action',
        //     name: 'action',
        //     orderable: false,
        //     searchable: false
        //   },
        //   { data: 'tglopi', name: 'tglopi' },
        //   { data: 'kode', name: 'kode' },
        //   { data: 'tglKirimDt', name: 'tglKirimDt' }, 
        //   // { data: 'tglKontrak', name: 'tglKontrak' },
        //   // { name: 'mod' },
        //   { data: 'pcsDt', name: 'pcsDt' },
        //   { data: 'Cust', name: 'Cust' },
        //   { data: 'namaBarang', name: 'namaBarang' },
        //   { data: 'pcsKontrak', name: 'pcsKontrak' },
        //   { data: 'keterangan', name: 'keterangan' },
        //   { data: 'noopi', name: 'noopi' },
        //   { data: 'poCustomer', name: 'poCustomer' },
        //   { data: 'mcKode', name: 'mcKode' },
        //   { 
        //     data: 'hari',
        //     name: 'hari',
        //     orderable: false,
        //     searchable: false
        //   },
        //   { data: 'flute', name: 'flute' },
        //   { data: 'tipeBox', name: 'tipeBox' },
        //   { data: 'panjangSheet', name: 'panjangSheet' },
        //   { data: 'lebarSheet', name: 'lebarSheet' },
        //   { data: 'outConv', name: 'outConv' },
        //   { data: 'tipeOrder', name: 'tipeOrder' },
        //   { data: 'namacc', name: 'namacc' },
        //   { data: 'joint', name: 'joint' },
        //   { data: 'subsP', name: 'subsP' },
        //   { data: 'gram', name: 'gram' },
        //   { data: 'tglKontrak', name: 'tglKontrak' },
        //   { data: 'alamatKirim', name: 'alamatKirim' },
        //   { data: 'toleransi', name: 'toleransi' },
        //   { data: 'panjang', name: 'panjang' },
        //   { data: 'lebar', name: 'lebar' },
        //   { data: 'tinggi', name: 'tinggi' },
        //   { data: 'koli', name: 'koli' },
        //   { data: 'tglKirimDt', name: 'tglKirimDt' },
        //   { data: 'harga_kg', name: 'harga_kg' },
        // ],
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
        "order": [1, 'desc'],
        "pageLength": 50,
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
        "scrollX": true,
        select: true,
      });
    });
  </script>

  @endsection