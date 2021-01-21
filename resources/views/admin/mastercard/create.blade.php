@extends('admin.templates.partials.default')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>


@section('content')
<div class="content-wrapper" style="height: auto !important">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row" id="form_list_mc">
            <div class="col-md-12">
                <h4 class="modal-title">Print Master Card</h4>
                <hr>
                
                @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Error!</strong> 
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li></li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                <form action="#" method="POST">
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12" style="border: 2px solid black;  margin-top:10px;">
                                <div class="form-group">
                                    <h4 class="form-section"> Data Master Item</h4>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Tanggal MC</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="datetime-local" class="form-control txt_line" name="tglmc" id="tglmc" placeholder="No. Item" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">No Item</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <input type="hidden" name="bj_id" id="bj_id">
                                                    <input type="text" class="form-control txt_line" name="noitem" id="noitem" readonly>
                                                </div>
                                                <button type="button" class="col-md-1" data-toggle="modal" data-target="#Item" id>
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="Item">
                                            <div class="modal-dialog modal-xl">
                                                
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Barang PHP</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body Item">
                                                        <div class="card-body">
                                                            <table class="table table-bordered" id="data_barang">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">ID.</th>
                                                                        <th scope="col">Kode</th>
                                                                        <th scope="col">Nama</th>
                                                                        <th scope="col">MC ID</th>
                                                                        <th scope="col">Pcs</th>
                                                                        <th scope="col">Gram</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $no = 1;
                                                                    foreach ($item as $data) { ?>
                                                                        <tr>
                                                                            <td scope="row">{{ $data->id }}</td>
                                                                            <td>{{ $data->kode }}</td>
                                                                            <td>{{ $data->nama }}</td>
                                                                            <td>{{ $data->mc_id }}</td>
                                                                            <td>{{ $data->pcs }}</td>
                                                                            <td>{{ $data->gram }}</td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Nama Item</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" name="namaitem" id="namaitem" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="border: 2px solid black;  margin-top:10px;">
                                <div class="form-group">
                                    <h4 class="form-section">Ukuran Box</h4>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Tipe Box</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" name="namaitem" id="namaitem" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Box</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control txt_line" name="noitem" id="noitem" readonly>
                                                </div>
                                                <button type="button" class="col-md-1" data-toggle="modal" data-target="#Box" id>
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                            <div class="modal fade" id="Box">
                                                <div class="modal-dialog modal-xl">
                                                    
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Box</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body Box">
                                                            <div class="card-body">
                                                                <table class="table table-bordered" id="data_box">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">ID.</th>
                                                                            <th scope="col">Kode</th>
                                                                            <th scope="col">Nama</th>
                                                                            <th scope="col">Tipe Box</th>
                                                                            <th scope="col">flute</th>
                                                                            <th scope="col">Panjang Box</th>
                                                                            <th scope="col">Lebar Box</th>
                                                                            <th scope="col">Tinggi Box</th>
                                                                            <th scope="col">Luas Box</th>
                                                                            <th scope="col">Panjang Dalam Box</th>
                                                                            <th scope="col">Lebar Dalam Box</th>
                                                                            <th scope="col">Tinggi Dalam Box</th>
                                                                            <th scope="col">Ukuran Creas Corr</th>
                                                                            <th scope="col">Ukuran Creas Conv</th>
                                                                            <th scope="col">Branch</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        $no = 1;
                                                                        foreach ($box as $data) { ?>
                                                                            <tr>
                                                                                <td>{{ $data->id }}</td>
                                                                                <td>{{ $data->kode }}</td>
                                                                                <td>{{ $data->nama }}</td>
                                                                                <td>{{ $data->tipebox }}</td>
                                                                                <td>{{ $data->flute }}</td>
                                                                                <td>{{ $data->lebarSheetBox }}</td>
                                                                                <td>{{ $data->panjangSheetBox }}</td>
                                                                                <td>{{ $data->tinggiSheetBox }}</td>
                                                                                <td>{{ $data->luasSheetBox }}</td>
                                                                                <td>{{ $data->lebarDalamBox }}</td>
                                                                                <td>{{ $data->panjangDalamBox }}</td>
                                                                                <td>{{ $data->tinggiDalamBox }}</td>
                                                                                <td>{{ $data->sizeCreasCorr }}</td>
                                                                                <td>{{ $data->sizeCreasConv }}</td>
                                                                                <td>{{ $data->branch }}</td>
                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Ukuran Sheet Box</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control txt_line" name="namaitem" id="namaitem" readonly>
                                        </div>
                                        <div class="col-md-1">
                                            <label class="control-label">Out Conv</label>
                                        </div>
                                        <div class="col-md-1">
                                            <input type="text" class="form-control txt_line" name="namaitem" id="namaitem" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2" style="margin-top: 30px;">
                                            <label class="control-label">Ukuran Dalam Box</label> 
                                        </div>
                                        <div class="col-md-2">
                                            <span class="x">P</span>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control txt_line" name="panjangbox" id="panjangbox" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="x">L</span>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control txt_line" name="lebarbox" id="lebarbox" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="x">T</span>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control txt_line" name="tinggibox" id="tinggibox" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Luas Sheet Box</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" name="namaitem" id="namaitem" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Berat Sheet Box</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" name="namaitem" id="namaitem" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Creas Corr</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" name="namaitem" id="namaitem" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Creas Conv</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" name="namaitem" id="namaitem" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="border: 2px solid black;  margin-top:10px;">
                                <div class="form-group">
                                    <h4 class="form-section">Ukuran Sheet</h4>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Flute</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" name="namaitem" id="namaitem" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2" style="margin-top: 30px;">
                                            <label class="control-label">Ukuran Dalam Box</label> 
                                        </div>
                                        <div class="col-md-2">
                                            <span class="x">P</span>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control txt_line" name="panjangbox" id="panjangbox" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="x">L</span>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control txt_line" name="lebarbox" id="lebarbox" readonly>
                                                </div>
                                                <div class="col-md-2">
                                                    MM
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Luas Sheet Corr</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" name="namaitem" id="namaitem" readonly>
                                        </div>
                                        <div class="col-md-2">
                                            M<sup>2</sup>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Berat Sheet Corr</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" name="namaitem" id="namaitem" readonly>
                                        </div>
                                        <div class="col-md-2">
                                            Gram
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Substance Kontrak</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" name="namaitem" id="namaitem" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Substance Produksi</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" name="namaitem" id="namaitem" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="border: 2px solid black;  margin-top:10px;">
                                <div class="form-group">
                                    <h4 class="form-section">Deskripsi Detail</h4>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Warna</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" name="namaitem" id="namaitem" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Wax</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" name="namaitem" id="namaitem" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Packing</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" name="namaitem" id="namaitem" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Bungkus</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" name="namaitem" id="namaitem" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Keterangan</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" name="namaitem" id="namaitem" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Gambar</label>
                                        </div>
                                        <div class="col-md-4">
                                            <img src="" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </form>
        </div>
    </div>
</div>

</div>    


@endsection

<script type="text/javascript">
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
    // Datatable Barang(Item)
    $(".Item").ready(function(){
        
        var table = $("#data_barang").DataTable({
            select: true,
        });
        
        $('#data_barang tbody').on( 'click', 'td', function () {
            var item = (table.row(this).data());
            
            document.getElementById('bj_id').value = item[0];
            document.getElementById('noitem').value = item[1];
            document.getElementById('namaitem').value = item[2];
        } );
        //  alert.row();
    } );
    
    $(".SubstanceKontrak").ready(function(){
        
        var table = $("#data_substanceKontrak").DataTable({
            select: true,
        });
        
        $('#data_substanceKontrak tbody').on( 'click', 'td', function () {
            var SubstanceKontrak = (table.row(this).data());
            
            document.getElementById('Katas').value = SubstanceKontrak[3]    ;
            document.getElementById('Kbf').value = SubstanceKontrak[4];
            document.getElementById('Ktengah').value = SubstanceKontrak[5];
            document.getElementById('Kcf').value = SubstanceKontrak[6];
            document.getElementById('Kbawah').value = SubstanceKontrak[7];
            
            document.getElementById('substanceKontrak_id').value = SubstanceKontrak[0];
            document.getElementById('subskontrak').value = SubstanceKontrak[2];
            
            getGramKontrak();
        } );
    } );
    
    $(".SubstanceProduksi").ready(function(){
        
        var table = $("#data_substanceProduksi").DataTable({
            select: true,
        });
        
        $('#data_substanceProduksi tbody').on( 'click', 'td', function () {
            var SubstanceProduksi = (table.row(this).data());
            
            document.getElementById('Patas').value = SubstanceProduksi[3]    ;
            document.getElementById('Pbf').value = SubstanceProduksi[4];
            document.getElementById('Ptengah').value = SubstanceProduksi[5];
            document.getElementById('Pcf').value = SubstanceProduksi[6];
            document.getElementById('Pbawah').value = SubstanceProduksi[7];
            
            document.getElementById('substanceProduksi_id').value = SubstanceProduksi[0];
            document.getElementById('subsProduksi').value = SubstanceProduksi[2];
            
            getGramProduksi();
        } );
    } );
    
    $(".Sheet").ready(function(){
        
        var table = $("#data_sheet").DataTable({
            select: true,
        });
        
        $('#data_sheet tbody').on( 'click', 'td', function () {
            var sheet = (table.row(this).data());
            
            document.getElementById('namasheet').value = sheet[2];
            document.getElementById('luasSheet').value = sheet[5];
        } );
        //  alert.row();
    } );
    
    function getFlute(){
        var data = document.getElementById('flute').value;
        var array = data.split(" ");
        var flute = array[3];
        
        document.getElementById('flute_id').value = array[0];
        document.getElementById('tur1').value = array[1];
        document.getElementById('tur2').value = array[2];
        document.getElementById('flutenama').value = array[3];
        // console.log(array);
        
        return flute;
        getGramKontrak();
    }
    
    function getGramKontrak(){
        
        var flutenama = document.getElementById('flutenama').value;
        var Katas = parseInt(document.getElementById('Katas').value);
        var Kbf = parseFloat(document.getElementById('Kbf').value);
        var Ktengah = parseFloat(document.getElementById('Ktengah').value);
        var Kcf = parseFloat(document.getElementById('Kcf').value);
        var Kbawah = parseFloat(document.getElementById('Kbawah').value);
        var luasSheet = parseFloat(document.getElementById('luasSheet').value);
        var tur1 = parseFloat(document.getElementById('tur1').value);
        var tur2 = parseFloat(document.getElementById('tur2').value);
        
        var result;
        
        if (flutenama == 'BF') {
            if (isNaN(Katas)) {
                Katas = 0;
            } 
            if (isNaN(Kbf)) {
                Kbf = 0;
            }
            if (isNaN(Ktengah)) {
                Ktengah = 0;
            }
            if (isNaN(Kcf)) {
                Kcf = 0;
            }
            if (isNaN(Kbawah)) {
                Kbawah = 0 ;
            }
            if (isNaN(tur2)) {
                tur2 = 0;
            }
            
            result = (luasSheet * (Katas + (Kbf*tur1) + Ktengah + (Kcf*tur2) + Kbawah))/1000000;
            
            document.getElementById('gramSheetCorrKontrak').value = result.toFixed(2);
        } else
        if (flutenama == 'CF') {
            if (isNaN(Katas)) {
                Katas = 0;
            } 
            if (isNaN(Kbf)) {
                Kbf = 0;
            }
            if (isNaN(Ktengah)) {
                Ktengah = 0;
            }
            if (isNaN(Kcf)) {
                Kcf = 0;
            }
            if (isNaN(Kbawah)) {
                Kbawah = 0 ;
            }
            if (isNaN(tur2)) {
                tur2 = 0;
            }
            
            result = (luasSheet * (Katas + (Kcf*tur1) + Ktengah + (Kbf*tur2) + Kbawah))/1000000;
            document.getElementById('gramSheetCorrKontrak').value = result.toFixed(2);
            
        } else {
            result = (luasSheet * (Katas + (Kbf*tur1) + Ktengah + (Kcf*tur2) + Kbawah))/1000000;
            document.getElementById('gramSheetCorrKontrak').value = result.toFixed(2);
        }
    }
    
    function getGramProduksi(){
        
        var flutenama = document.getElementById('flutenama').value;
        var Patas = parseInt(document.getElementById('Patas').value);
        var Pbf = parseFloat(document.getElementById('Pbf').value);
        var Ptengah = parseFloat(document.getElementById('Ptengah').value);
        var Pcf = parseFloat(document.getElementById('Pcf').value);
        var Pbawah = parseFloat(document.getElementById('Pbawah').value);
        var luasSheet = parseFloat(document.getElementById('luasSheet').value);
        var tur1 = parseFloat(document.getElementById('tur1').value);
        var tur2 = parseFloat(document.getElementById('tur2').value);
        
        var result;
        
        if (flutenama == 'BF') {
            if (isNaN(Patas)) {
                Patas = 0;
            } 
            if (isNaN(Pbf)) {
                Pbf = 0;
            }
            if (isNaN(Ptengah)) {
                Ptengah = 0;
            }
            if (isNaN(Pcf)) {
                Pcf = 0;
            }
            if (isNaN(Pbawah)) {
                Pbawah = 0 ;
            }
            if (isNaN(tur2)) {
                tur2 = 0;
            }
            
            result = (luasSheet * (Patas + (Pbf*tur1) + Ptengah + (Pcf*tur2) + Pbawah))/1000000;
            
            document.getElementById('gramSheetCorrProduksi').value = result.toFixed(2);
        } else
        if (flutenama == 'CF') {
            if (isNaN(Patas)) {
                Patas = 0;
            } 
            if (isNaN(Pbf)) {
                Pbf = 0;
            }
            if (isNaN(Ptengah)) {
                Ptengah = 0;
            }
            if (isNaN(Pcf)) {
                Pcf = 0;
            }
            if (isNaN(Pbawah)) {
                Pbawah = 0 ;
            }
            if (isNaN(tur2)) {
                tur2 = 0;
            }
            
            result = (luasSheet * (Patas + (Pcf*tur1) + Ptengah + (Pbf*tur2) + Pbawah))/1000000;
            document.getElementById('gramSheetCorrProduksi').value = result.toFixed(2);
            
        } else {
            result = (luasSheet * (Patas + (Pbf*tur1) + Ptengah + (Pcf*tur2) + Pbawah))/1000000;
            document.getElementById('gramSheetCorrProduksi').value = result.toFixed(2);
        }
    }
    
    
</script>