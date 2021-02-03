{{-- @extends('admin.templates.partials.default') --}}
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<style>
    .row {
        margin-top: 5px;
    }
    
    h4 {
        margin-bottom: 20px !important;
    }
    
    span.x {
        display: inline-block;
        padding-left: 70px;
    }
</style>


<div class="content-wrapper" style="margin: 50px; height: auto !important; width: 100% px !important">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row" id="form_list_mc">
            <div class="col-md-12">
                <h4 class="modal-title">Print Master Card</h4>
                <hr>
                
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
                                            <input type="text" class="form-control txt_line" name="tglmc" id="tglmc"  value="{{ $mc->created_at }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">No Item</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control txt_line" value="{{ $mc->kodeBrg }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Nama Item</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" value="{{ $mc->namaBrg }}" readonly>
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
                                            <input type="text" class="form-control txt_line" value="{{ $mc->tipebox }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Ukuran Sheet Box</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control txt_line" value="{{ $mc->panjangSheetBox }}">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control txt_line" value="{{ $mc->lebarSheetBox }}">
                                        </div>
                                        <div class="col-md-1">
                                            <label class="control-label">Out Conv</label>
                                        </div>
                                        <div class="col-md-1">
                                            <input type="text" class="form-control txt_line" value="{{ $mc->outConv }}" readonly>
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
                                                    <input type="text" class="form-control txt_line" value="{{ $mc->panjangbox }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="x">L</span>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control txt_line" value="{{ $mc->lebarbox }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="x">T</span>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control txt_line" value="{{ $mc->tinggibox }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Luas Sheet Box</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" value="{{ $mc->luasSheetBox }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Berat Sheet Box</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" value="{{ $mc->gramSheetBox }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Creas Corr</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" value="{{ $mc->CreasCorrP }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Creas Conv</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" value="{{ $mc->CreasCorrL }}" readonly>
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
                                            <input type="text" class="form-control txt_line" value="{{ $mc->flute }}" readonly>
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
                                                    <input type="text" class="form-control txt_line" value="{{ $mc->panjangDalamBox }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="x">L</span>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control txt_line" value="{{ $mc->lebarDalamBox }}" readonly>
                                                </div>
                                                <div class="col-md-2">
                                                    MM
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <span class="x">T</span>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control txt_line" value="{{ $mc->tinggiDalamBox }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Luas Sheet Corr</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" value="{{ $mc->luasSheet }}" readonly>
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
                                            <input type="text" class="form-control txt_line" value="{{ $mc-> }}" readonly>
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
                                            <input type="text" class="form-control txt_line" value="{{ $mc-> }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Substance Produksi</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" value="{{ $mc-> }}" readonly>
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
                                            <input type="text" class="form-control txt_line" value="{{ $mc-> }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Wax</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" value="{{ $mc-> }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Packing</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" value="{{ $mc-> }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Bungkus</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" value="{{ $mc-> }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Keterangan</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" value="{{ $mc-> }}" readonly>
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
                </form>
                
            </div>
        </div>
    </div>
    
</div>    

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
    
    function strtrunc(str, max, add){
        add = add || '...';
        return (typeof str === 'string' && str.length > max ? str.substring(0, max) + add : str);
    };
    
    //Datatable Box
    $(".Box").ready(function(){
        
        var table = $("#data_box").DataTable({
            "scrollX": "100%",
            "scrollY": "400px",
            select: true,
        });
        
        $('#data_box tbody').on( 'click', 'td', function () {
            var Box = (table.row(this).data());
            
            // document.getElementById('bj_id').value = Box[0];
            // document.getElementById('noBox').value = Box[1];
            // document.getElementById('namaBox').value = Box[2];
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