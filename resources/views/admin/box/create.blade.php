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
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                <form action="{{ route('box.store') }}" method="POST" class="inputSheet">
                    @csrf
                    <div class="row was-validated">
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Auto Generated">
                            <div class="form-group">
                                
                                <label>Nama Item</label>
                                {{-- <textarea name="nama" id="nama" cols="30" rows="10"></textarea> --}}
                                <div class="row">
                                    <div class="col-md-10">
                                        <input type="text" class="form-control txt_line" name="namaBarang" id="namaBarang">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="col-md-1" data-toggle="modal" data-target="#Item" id>
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                
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
                                                        <th scope="col">Kode Barang.</th>
                                                        <th scope="col">Nama</th>
                                                        <th scope="col">Satuan</th>
                                                        <th scope="col">MC ID</th>
                                                        <th scope="col">Tgl Jadi</th>
                                                        <th scope="col">Gram</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no = 1;
                                                    foreach ($item as $data) { ?>
                                                        <tr>
                                                            <td scope="row">{{ $data->KodeBrg }}</td>
                                                            <td>{{ $data->NamaBrg }}</td>
                                                            <td>{{ $data->Satuan }}</td>
                                                            <td>{{ $data->WeightValue }}</td>
                                                            <td>{{ $data->TglKeluar }}</td>
                                                            <td>{{ $data->BeratStandart }}</td>
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
                        {{-- <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Auto Generated">
                            <div class="form-group">
                                <label>Kode Item</label>
                                <textarea name="nama" id="nama" cols="30" rows="10"></textarea>
                                <input type="text" class="form-control txt_line" name="kodeBarang" id="kodeBarang">
                            </div>
                        </div> --}}
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Pilih Tipe Box">
                            <div class="form-group">
                                <label>Tipe Box</label>
                                <select class="js-example-basic-single col-md-12" name="tipebox" id="tipebox" onchange="getTipe()">
                                    <option value="">Pilih Tipe ..</option>
                                    @foreach ($tipebox as $data)
                                    <option value="{{ $data->kode }}">{{ $data->kode }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input Flute">
                            <div class="form-group">
                                <label>Flute</label>
                                <select class="js-example-basic-single col-md-12" name="flute" id="flute" onchange="update_crease_corr()">
                                    <option value="">Pilih Flute ..</option>
                                    @foreach ($flute as $data)
                                    <option value="{{ $data->kode }}">{{ $data->kode }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Pilih Tipe Crease Corr">
                            <div class="form-group">
                                <label>Tipe Crease Corr</label>
                                <select class="js-example-basic-single col-md-12" name="tipeCreasCorr" id="tipeCreasCorr">
                                    <option value="MALE-FLAT">MALE-FLAT</option>
                                    <option value="MALE-MALE">MALE-MALE</option>
                                    <option value="MALE-FEMALE">MALE-FEMALE</option>
                                    <option value="TANPA CREASE">TANPA CREASE</option>
                                </select>
                            </div>
                        {{-- </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="input Lebar Sheet Box (mm)">
                            <div class="form-group">
                                <label>Lebar</label>
                                <input type="text" class="form-control txt_line" placeholder="in milimeters" name="lebarSheetBox" id="lebarSheetBox" onchange="luas(); getNama();" required>
                                <div class="valid-feedback">Terima kasih</div>
                                <div class="invalid-feedback">Masukkan Lebar Sheet Box (mm)</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="">
                            <div class="form-group">
                                <label>Panjang</label>
                                <input type="text" class="form-control txt_line" placeholder="in milimeters" name="panjangSheetBox" id="panjangSheetBox" onchange="luas(); getNama();" required>
                                <div class="valid-feedback">Terima kasih</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="">
                            <div class="form-group">
                                <label>Tinggi</label>
                                <input type="text" class="form-control txt_line" placeholder="in milimeters" name="tinggiSheetBox" id="tinggiSheetBox" onchange="luas(); getNama();" required>
                                <div class="valid-feedback">Terima kasih</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Luas sheet">
                            <div class="form-group">
                                <label>Luas</label>
                                <input type="text" class="form-control txt_line" name="luasSheetBox" id="luasSheetBox" required readonly>
                            </div>
                        </div> --}}
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Masukkan panjang dalam box (mm)">
                            <div class="form-group">
                                <label>Panjang Dalam Box</label>
                                <input type="text" class="form-control txt_line" placeholder="" name="panjangDalamBox" id="panjangDalamBox" onchange="update_crease_corr(); getNama();" required>
                                <div class="valid-feedback">Terima kasih</div>
                                <div class="invalid-feedback">Masukkan panjang dalam box (mm)</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Masukkan lebar dalam box (mm)">
                            <div class="form-group">
                                <label>Lebar Dalam Box</label>
                                <input type="text" class="form-control txt_line" placeholder="" name="lebarDalamBox" id="lebarDalamBox" onchange="update_crease_corr(); getNama();" required>
                                <div class="valid-feedback">Terima kasih</div>
                                <div class="invalid-feedback">Masukkan lebar dalam box (mm)</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Masukkan tinggi dalam box (mm)">
                            <div class="form-group">
                                <label>Tinggi Dalam Box</label>
                                <input type="text" class="form-control txt_line" placeholder="" name="tinggiDalamBox" id="tinggiDalamBox" onchange="update_crease_corr(); getNama();" required>
                                <div class="valid-feedback">Terima kasih</div>
                                <div class="invalid-feedback">Masukkan tinggi dalam box (mm)</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Masukkan tinggi dalam box (mm)">
                            <div class="form-group">
                                <label>Kondisi Tambahan</label>
                                <input type="text" class="form-control txt_line" placeholder="" name="kuping2" id="kuping2" onchange="update_crease_corr(); getNama();">
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="">
                            <div class="form-group">
                                <label>Creas Corr</label>
                                <input type="hidden" name="flapCrease" id="flapCrease">
                                <input type="hidden" name="tinggiCrease" id="tinggiCrease">
                                <input type="text" class="form-control txt_line" placeholder="" name="sizeCreasCorr" id="sizeCreasCorr" onchange="getNama();" readonly>
                                <div class="valid-feedback">Terima kasih</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="">
                            <div class="form-group">
                                <label>Creas Conv</label>
                                <input type="hidden" name="kuping" id="kuping">
                                <input type="hidden" name="panjangCrease" id="panjangCrease">
                                <input type="hidden" name="lebarCrease1" id="lebarCrease1">
                                <input type="hidden" name="lebarCrease2" id="lebarCrease2">
                                <input type="hidden" name="kuping2" id="kuping2">
                                <input type="text" class="form-control txt_line" placeholder="" name="sizeCreasConv" id="sizeCreasConv" onchange="getNama();" readonly>
                                <div class="valid-feedback">Terima kasih</div>
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

        $(".Item").ready(function(){
        
        var table = $("#data_barang").DataTable({
            select: true,
        });
        
        $('#data_barang tbody').on( 'click', 'td', function () {
            var item = (table.row(this).data());
            
            // document.getElementById('bj_id').value = item[0];
            // document.getElementById('kodeBarang').value = item[0];
            document.getElementById('namaBarang').value = item[1];
        } );
        //  alert.row();
    } );
        
        function luas(){
            var panjang = document.getElementById("panjangSheetBox").value;
            var lebar = document.getElementById("lebarSheetBox").value;
            // var kode = document.getElementById('kode').value;
            var luas;
            luas = panjang * lebar * tinggi;
            
            document.getElementById("luasSheetBox").value =  luas;
        }
        
        function getNama(){
            var kode = document.getElementById('namaBarang').value;
            tipe = getTipe();
            
            // var panjangbox = document.getElementById("panjangSheetBox").value;
            // var lebarbox = document.getElementById("lebarSheetBox").value;
            // var tinggibox = document.getElementById("tinggiSheetBox").value;
            // var luasbox = document.getElementById("luasSheetBox").value;
            
            var panjangdalam = document.getElementById("panjangDalamBox").value;
            var lebardalam = document.getElementById("lebarDalamBox").value;
            var tinggidalam = document.getElementById("tinggiDalamBox").value;
            
            var CreaseCorr = document.getElementById("sizeCreasCorr").value;
            var CreaseConv = document.getElementById("sizeCreasConv").value;
            
            // if (tipe == 'B1') {
            //     // document.getElementById("kode").value = panjangdalam+'x'+lebardalam+'x'+tinggidalam+' MM'+"\n"+CreaseCorr+"\n"+CreaseConv;
            //     document.getElementById("kode").value = kode;
            // }
            // if (tipe == 'DC') {
            //     // document.getElementById("kode").value = panjangdalam+'x'+lebardalam+'x'+tinggidalam+' MM';  
            //     document.getElementById("kode").value = kode;
            // }
            
        }
        
        function getTipe(){
            var tipe = document.getElementById('tipebox').value;
            
            
            if (tipe == 'B1') {
                document.getElementById('sizeCreasCorr').disabled = false;
                document.getElementById('sizeCreasConv').disabled = false;
            } else {
                document.getElementById('sizeCreasCorr').disabled = true;
                document.getElementById('sizeCreasConv').disabled = true;
            }
            
            return tipe;
        }
        
        function update_crease_corr() {
            var tipe = document.getElementById("tipebox").value;
            
            var box_p = document.getElementById("panjangDalamBox").value;
            var box_l = document.getElementById("lebarDalamBox").value;
            var box_t = document.getElementById("tinggiDalamBox").value;
            var add_condition = document.getElementById("kuping2").value;
            var flute = document.getElementById("flute").value;
            var crease_p, crease_l, kuping, flap, p1, l1, l2, tinggi, sheet_p, sheet_l;
            var flap_trim, tinggi_trim, p1_trim, l1_trim, l2_trim;
            
            if (tipe == "B1") {
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
                sheet_l = (flap*2) + tinggi ;
                crease_p = flap+' - '+tinggi+' - '+flap+' = '+sheet_l+' MM';
                
                p1 = ((box_p*1) + p1_trim);
                l1 = ((box_l*1) + l1_trim);
                l2 = ((box_l*1) + l2_trim);
                sheet_p = (p1*2) + l1 + l2 + kuping - add_condition;
                crease_l = kuping +' - '+ p1 + ' - ' + l1 + ' - ' + p1 + ' - ' + l2 +' - '+ add_condition +' = ' + sheet_p + ' MM';
                
                //CreaseCorr
                document.getElementById("sizeCreasCorr").value = crease_p;
                document.getElementById("kuping").value = kuping;
                document.getElementById("panjangCrease").value = p1;
                document.getElementById("lebarCrease1").value = l1;
                document.getElementById("lebarCrease2").value = l2;

                //CreaseConv
                document.getElementById("sizeCreasConv").value = crease_l;
                document.getElementById("flapCrease").value = flap;
                document.getElementById("tinggiCrease").value = tinggi;
                
            } 
            
        }
        
        
        
    </script>