@extends('admin.templates.partials.default')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

{{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> --}}

<style>
    .select2 {
        width: 206px !important;
    }
    .row  {
        margin-bottom: 10px;
    }
</style>


@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row" id="form_list_mc">
            <div class="col-md-12">
                <h4 class="modal-title">Planning Corrugating</h4>
                <hr>
                
                @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Error!</strong> 
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $errors }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                <form action="{{ route('fb.store.bbm') }}"  method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-2">    
                                    <label for="">Periode</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="periode" name="periode" value="{{ date("m/Y") }}" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">    
                                    <label for="">Tanggal</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="date" id="tanggal_masuk" name="tanggal_masuk" value="{{ date("Y-m-d") }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">    
                                    <label for="">No. BBM</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="nobukti" name="nobukti" value="{{ $nobukti }}" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">    
                                    <label for="">Supplier</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" id="kode_supp" name="kode_supp" required>
                                </div>
                                <div class="modal fade" id="list-supplier">
                                    <div class="modal-dialog modal-xl"> 
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">List Supplier</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body supplier">
                                                <div class="card-body">
                                                    <table class="table table-bordered" id="data_supplier">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Kode</th>
                                                                <th scope="col">Nama Supplier</th>
                                                                <th scope="col">Alamat Kantor</th>
                                                                <th scope="col">Kota</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Simpan</button>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <button type="button" data-toggle="modal" data-target="#list-supplier">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-10">
                                    <h5 class="nama_supp" id="nama_supp"></h5>
                                    <h5 class="alamat" id="alamat"></h5>
                                    <h5 class="kota" id="kota"></h5>
                                    {{-- <textarea name="ket_supp" id="ket_supp" cols="30" rows="4" readonly></textarea> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-2">    
                                    <label for="">Departemen</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" id="dept" class="dept" required>
                                </div>
                                <div class="col-md-4">
                                    <h5 id="ldept" class="ldept"></h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">    
                                    <label for="">Tanggal Jth Tempo</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="date" id="tgl_jatuh_tempo" name="tgl_jatuh_tempo" value="{{ date("Y-m-d") }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">    
                                    <label for="">Keterangan</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" id="keterangan" name="keterangan" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">    
                                    <label for="">Kode Perkiraan</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" id="kode_perk" name="kode_perk" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="modal fade" id="list-po">
                                <div class="modal-dialog modal-xl"> 
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Purchase Order</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body po">
                                            <div class="card-body">
                                                <table class="table table-bordered" id="data_po">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" id="nurut" class="nurut">Id</th>
                                                            <th scope="col">PO</th>
                                                            <th scope="col">OPB</th>
                                                            <th scope="col">Kode Barang</th>
                                                            <th scope="col">Nama Barang</th>
                                                            <th scope="col">Harga</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success cari_po" style="margin-bottom: 10px" data-toggle="modal" data-target="#list-po">Cari PO</button>
                            <input type="hidden" name="nomer" id="nomer" value="0">
                            <br>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>No PO</th>
                                        <th>No OPB</th>
                                        <th>Qty</th>
                                        <th>Berat</th>
                                        <th>Harga</th>
                                        <th>Kode Roll</th>
                                        <th>Kode Internal</th>
                                        <th>Nilai</th>
                                    </tr>
                                </thead>
                                <tbody id="detail_bbm"></tbody>
                            </table>
                            <button type="submit" class="btn btn-primary" style="margin-bottom: 10px">Simpan</button>
                        </div>
                    </div>
                </form> 
            </div>
        </div>
    </div>    
</div>
@endsection

@section('javascripts')
<script type="text/javascript">
$(".supplier").ready(function(){
    var tbsuppllier = $("#data_supplier").DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('get.supp') !!}',
        columns: [{
                data: 'Kode',
                id: 'kode'
            },
            {
                data: 'Nama',
                id: 'nama'
            },
            {
                data: 'AlamatKantor',
                id: 'alamat'
            },
            {
                data: 'KotaKantor',
                id: 'kota'
            }
        ],
        select: true,
    });
    
    $('#data_supplier tbody').on( 'click', 'td', function () {
        var cust = (tbsuppllier.row(this).data());
        
        document.getElementById('nama_supp').innerHTML = cust.Nama;
        document.getElementById('alamat').innerHTML = cust.AlamatKantor;
        document.getElementById('kota').innerHTML = cust.KotaKantor;
        document.getElementById('kode_supp').value = cust.Kode;

        var tbpo = $("#data_po").DataTable({
            processing: true,
            serverSide: true,
            retrieve: true,
            // destroy: true,
            ajax: "../../po/" + cust.Kode,
            columns: [
                { data: 'NoUrut', name: 'NoUrut'},
                { data: 'NoOP', name: 'NoOP'},
                { data: 'NoOPB', name: 'NoOPB'},
                { data: 'KodeBrg', name: 'KodeBrg'},
                { data: 'barang', name: 'TBarang.NamaBrg', searchable: true},
                { data: 'HargaReal', name: 'HargaReal'},
            ],
            select: true,
        })
                                                                                                                                                                                                                 
        $('#data_po tbody').on('click', 'td', function () {
            var cust = (tbpo.row(this).data());
            var nomer = document.getElementById("nomer").value;
            
            var html = '';

            html += "<tr class='po-list'>";
                html += "<td>";
                    html += "<input class='col-md-12' type='text'  name='nurut["+ nomer +"]' value='"+ cust.NoUrut +"' readonly>";
                    html += "<input class='col-md-12' type='text'  name='kodebrg["+ nomer +"]' value='"+ cust.KodeBrg +"' readonly>";
                html += "</td>";
                html += "<td>";
                    html += "<input class='col-md-12' type='text'  name='namabrg["+ nomer +"]' value='"+ cust.barang +"' readonly>";
                html += "</td>";
                html += "<td>";
                    html += "<input class='col-md-12' type='text'  name='po["+ nomer +"]' value='"+ cust.NoOP +"' readonly>";
                html += "</td>";
                html += "<td>";
                    html += "<input class='col-md-12' type='text'  name='opb["+ nomer +"]' value='"+ cust.NoOPB +"' readonly>";
                html += "</td>";
                html += "<td>";
                    html += "<input class='col-md-12 qty' type='number'  name='qty["+ nomer +"]' value=''>";
                html += "</td>";
                html += "<td>";
                    html += "<input class='col-md-12 berat' type='text'  name='berat["+ nomer +"]' value=''>";
                html += "</td>";
                html += "<td>";
                    html += "<input class='col-md-12 harga' type='text'  name='harga["+ nomer +"]' value='"+ cust.HargaReal +"' readonly>";
                html += "</td>";
                html += "<td>";
                    html += "<input class='col-md-12' type='text'  name='kdroll["+ nomer +"]' value=''>";
                html += "</td>";
                html += "<td>";
                    html += "<input class='col-md-12' type='text'  name='internal["+ nomer +"]' value=''>";
                html += "</td>";
                html += "<td>";
                    html += "<input class='col-md-12 nilai' type='text'  name='nilai["+ nomer +"]' value=''>";
                html += "</td>";
            html += "</tr>";

            $("#detail_bbm").append(html);
                
            document.getElementById("nomer").value = parseInt(nomer) + 1;
            $("#list-po").modal("hide");
            });

        $("#list-supplier").modal("hide");
    } );
} );

$("#list_po").ready(function() {
    $('.cari_po').on("click", function(){
        supp = document.getElementById("kode_supp").value;
    
        if (supp = '') {
            alert("PO Kosong, Silahkan Pilih Customer dahulu !!")
        } 
    })
})

$(document).on("change", ".berat", function(e) {
    berat = $(this).val()
    harga = $(this).closest(".po-list").find(".harga").val();

    nilai = parseInt(harga) * parseInt(berat);

    $(this).closest(".po-list").find(".nilai").val(nilai.toLocaleString());

})
</script>
@endsection