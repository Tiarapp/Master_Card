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

      <a href="{{ route('opi.create') }}" style="margin-bottom: 20px;"> <i class="fas fa-plus-circle fa-2x"></i></a>
      <div class="card-body">
        <table class="table table-bordered" id="data_opi">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">No OPI</th>
              <th scope="col">Action</th>
              <th scope="col">Kontrak</th>
              <th scope="col">OPI ke</th>
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
          {{-- <tfoot>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">No OPI</th>
              <th scope="col">Action</th>
              <th scope="col">Kontrak</th>
              <th scope="col">OPI ke</th>
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
          </tfoot> --}}
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
    //   function strtrunc(str, max, add){
    //   add = add || '...';
    //   return (typeof str === 'string' && str.length > max ? str.substring(0, max) + add : str);
    // };
    $('#data_opi tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<input type="text" style="width:50px" placeholder="Search ' + title + '" />');
    });
    $(function(){
      $('#data_opi').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{ url('opijson') }}",
            "dataType": "json",
            "type": "POST",
            "data":{ _token: "{{ csrf_token() }}"}
        },
        "columns": [
            {"data": "id"},
            {"data": "NoOPI" },
            {"data": "action" },
            {"data": "kode" },
            {"data": "created_at" },
            {"data": "tglKirimDt"},
            {"data": "pcsDt" },
            {"data": "Cust" },
            {"data": "namaBarang" },
            {"data": "jumlahOrder" },
            {"data": "sisa_order" },
            {"data": "keterangan" },
            {"data": "NoOPI"},
            {"data": "poCustomer" },
            {"data": "nomc" },
            {"data": "hari" },
            {"data": "flute" },
            {"data": "tipeBox"},
            {"data": "panjangSheet" },
            {"data": "lebarSheet" },
            {"data": "outConv" },
            {"data": "Ukroll" },
            {"data": "tipeOrder" },
            {"data": "namacc" },
            {"data": "joint"},
            {"data": "KertasAtas" },
            {"data": "gramKertasAtas" },
            {"data": "gramKertasflute1" },
            {"data": "gramKertastengah" },
            {"data": "gramKertasflute2"},
            {"data": "gramKertasbawah" },
            {"data": "kertasMcbawah" },
            {"data": "wax" },
            {"data": "gram" },
            {"data": "tglKontrak" },
            {"data": "alamatKirim" },
            {"data": "toleransi" },
            {"data": "panjang" },
            {"data": "lebar" },
            {"data": "tinggi" },
            {"data": "koli"},
            {"data": "tglKirimDt" },
            {"data": "harga_kg" },
            {"data": "Ukroll" },
            {"data": "Ukroll" },
            {"data": "status" },
            {"data": "kode"},
            {"data": "tglKontrak" },
            {"data": "kertasMcAtasK" },
            {"data": "gramKertasAtasK" },
            {"data": "gramKertasflute1K" },
            {"data": "gramKertastengahK"},
            {"data": "gramKertasflute2K" },
            {"data": "gramKertasbawahK" },
            {"data": "kertasMcbawahK" },
            {"data": "Ukroll" },
            {"data": "kodeBarang" },
            {"data": "tipeCreasCorr" },
            {"data": "bungkus" },
            {"data": "Ukroll" },
            
        ],
        // initComplete: function () {
        //   // Apply the search
        //   this.api()
        //       .columns()
        //       .every(function () {
        //           var that = this;

        //           $('input', this.footer()).on('keyup change clear', function () {
        //               if (that.search() !== this.value) {
        //                   that.search(this.value).draw();
        //               }
        //           });
        //       });
        // },
        // "columnDefs": [
        // {
        //   'targets': [0
        //   ],
        //   'render': function(data, type, full, meta){
        //     if(type === 'display'){
        //       data = strtrunc(data, 10);
        //     }
        //     return data;
        //   }
        // }
        // ],
        "order":[1, 'desc'],
        "pageLength": 25,
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
    });

    
  </script>

  @endsection