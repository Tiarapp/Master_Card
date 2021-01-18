<!-- jQuery -->
<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>
@extends('admin.templates.partials.default')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

@section('content')


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row" id="form_list_mc">
            <div class="col-md-5">
                <h4 class="modal-title">Tambah Box</h4>
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
                
                <form action="/admin/box/store" method="POST" class="inputSheet">
                    @csrf
                    <div class="row was-validated">
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="">
                            <div class="form-group">
                                <label>Kode</label>
                                <input type="text" class="form-control txt_line" placeholder="" name="kode" id="kode" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control txt_line" placeholder="" name="nama" id="nama" required readonly>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="">
                            <div class="form-group">
                                <label>Flute</label>
                                <select class="js-example-basic-single col-md-12" name="flute" id="flute" onchange="getFlute()">
                                    <option value="">Pilih Flute ..</option>
                                    @foreach ($flute as $data)
                                        <option value="{{ $data->nama }}">{{ $data->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="">
                            <div class="form-group">
                                <label>Tipe Box</label>
                                <select class="js-example-basic-single col-md-12" name="tipebox" id="tipebox" onchange="getTipe()">
                                    <option value="">Pilih Tipe ..</option>
                                    @foreach ($tipebox as $data)
                                        <option value="{{ $data->nama }}">{{ $data->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="">
                            <div class="form-group">
                                <label>Tipe Creas Corr</label>
                                <select class="js-example-basic-single col-md-12" name="tipeCreasCorr" id="tipeCreasCorr">
                                    <option value="MALE-FLAT">MALE-FLAT</option>
                                    <option value="MALE-MALE">MALE-MALE</option>
                                    <option value="MALE-FEMALE">MALE-FEMALE</option>
                                    <option value="TANPA CREASE">TANPA CREASE</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="">
                            <div class="form-group">
                                <label>Lebar</label>
                                <input type="text" class="form-control txt_line" placeholder="" name="lebarSheetBox" id="lebarSheetBox" onchange="luas(); getNama();" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="">
                            <div class="form-group">
                                <label>Panjang</label>
                                <input type="text" class="form-control txt_line" placeholder="" name="panjangSheetBox" id="panjangSheetBox" onchange="luas(); getNama();" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="">
                            <div class="form-group">
                                <label>Tinggi</label>
                                <input type="text" class="form-control txt_line" placeholder="" name="tinggiSheetBox" id="tinggiSheetBox" onchange="luas(); getNama();" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Luas sheet">
                            <div class="form-group">
                                <label>Luas</label>
                                <input type="text" class="form-control txt_line" name="luasSheetBox" id="luasSheetBox" required readonly>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="">
                            <div class="form-group">
                                <label>Panjang Dalam Box</label>
                                <input type="text" class="form-control txt_line" placeholder="" name="panjangDalamBox" id="panjangDalamBox" onchange="update_cress_corr()" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="">
                            <div class="form-group">
                                <label>Lebar Dalam Box</label>
                                <input type="text" class="form-control txt_line" placeholder="" name="lebarDalamBox" id="lebarDalamBox" onchange="update_cress_corr()" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="">
                            <div class="form-group">
                                <label>Tinggi Dalam Box</label>
                                <input type="text" class="form-control txt_line" placeholder="" name="tinggiDalamBox" id="tinggiDalamBox" onchange="update_cress_corr()" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="">
                            <div class="form-group">
                                <label>Creas Corr</label>
                                <input type="text" class="form-control txt_line" placeholder="" name="sizeCreasCorr" id="sizeCreasCorr" readonly>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="">
                            <div class="form-group">
                                <label>Creas Conv</label>
                                <input type="text" class="form-control txt_line" placeholder="" name="sizeCreasConv" id="sizeCreasConv" readonly>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <input type="hidden" class="form-control txt_line" name="createdBy" id="createdBy" value="{{ Auth::user()->name }}">
                        <div class="col-md-12">
                            <button type="submit" id="save" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Save">
                                <i class='far fa-check-square'></i>
                            </button>
                            <button type="button" id="cancel" class="btn" data-toggle="tooltip" data-placement="right" title="Cancel">
                                <a href="/admin/sheet">
                                    <i class='far fa-window-close' style='color:red'></i>
                                </a></button>
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
        
        function luas(){
            var panjang = document.getElementById("panjangSheetBox").value;
            var lebar = document.getElementById("lebarSheetBox").value;
            var tinggi = document.getElementById("tinggiSheetBox").value;
            var luas;
            luas = panjang * lebar * tinggi;

            document.getElementById("luasSheetBox").value =  luas;
        }
        
        function getNama(){
            var panjang = document.getElementById("panjangSheet").value;
            var lebar = document.getElementById("lebarSheet").value;
            
            document.getElementById("nama").value = panjang +' x '+ lebar;
        }

        function getFlute(){
        var data = document.getElementById('flute_id').value;
        var array = data.split(" ");
        
        document.getElementById('flute').value = array[3];
        // console.log(array);
        
        // return flute;
        // getGramKontrak();
    }

    function getTipe(){
        var tipe = document.getElementById('tipebox').value;

        if (tipe == 'B1') {
            document.getElementById('lebarSheetBox').disabled = true;
            document.getElementById('panjangSheetBox').disabled = true;
            document.getElementById('tinggiSheetBox').disabled = true;
            document.getElementById('lebarDalamBox').disabled = false;
            document.getElementById('panjangDalamBox').disabled = false;
            document.getElementById('tinggiDalamBox').disabled = false;
        } else {
            document.getElementById('lebarDalamBox').disabled = true;
            document.getElementById('panjangDalamBox').disabled = true;
            document.getElementById('tinggiDalamBox').disabled = true;
            document.getElementById('lebarSheetBox').disabled = false;
            document.getElementById('panjangSheetBox').disabled = false;
            document.getElementById('tinggiSheetBox').disabled = false;
        }
    }

    function update_cress_corr() {
        var box_p = document.getElementById("panjangDalamBox").value;
        var box_l = document.getElementById("lebarDalamBox").value;
        var box_t = document.getElementById("tinggiDalamBox").value;
        var flute = document.getElementById("flute").value;
        var cress_p, cress_l, kuping, flap, p1, p2, l1, l2, tinggi, sheet_p, sheet_l;
        var flap_trim, tinggi_trim, p1_trim, l1_trim, l2_trim;

        if (flute == "BF"){
            flap_trim = 2;
            tinggi_trim = 5;
            p1_trim = 3;
            l1_trim = 3;
            l2_trim = 0;
            kuping = 30;
        }
        if (flute == "CF"){
            flap_trim = 3;
            tinggi_trim = 7;
            p1_trim = 4;
            l1_trim = 4;
            l2_trim = 2;
            kuping = 30;
        }
        if (flute == "BCF"){
            flap_trim = 5;
            tinggi_trim = 13;
            p1_trim = 6;
            l1_trim = 6;
            l2_trim = 4;
            kuping = 35;
        }
        flap =  ((box_l / 2) + flap_trim);
        tinggi = ((box_t*1) + tinggi_trim);
        sheet_l = (flap*2) + tinggi;
        cress_p = flap+' - '+tinggi+' - '+flap+' = '+sheet_l+' MM';

        p1 = ((box_p*1) + p1_trim);
        l1 = ((box_l*1) + l1_trim);
        l2 = ((box_l*1) + l2_trim);
        sheet_p = (p1*2) + l1 + l2 + kuping;
        cress_l = kuping +' - '+ p1 + ' - ' + l1 + ' - ' + p1 + ' - ' + l2 + ' = ' + sheet_p + ' MM';

        document.getElementById("sizeCreasCorr").value = cress_p;
        document.getElementById("sizeCreasConv").value = cress_l;
    }

        
    </script>