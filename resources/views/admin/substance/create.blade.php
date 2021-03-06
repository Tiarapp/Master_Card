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
                <h4 class="modal-title">Tambah Substance</h4>
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
                
                <form action="{{ route('substance.store') }}" method="POST" class="inputSubstance">
                    @csrf
                    <div class="row was-validated">
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input Liner Atas">
                            <div class="form-group">
                                <label>Pilih Flute</label>
                                <select class="js-example-basic-single col-md-12" name="flute" id="flute" onchange="getFlute()">
                                    <option value=''>--</option>
                                    @foreach ($flute as $data)
                                    <option value="{{ $data->kode }}">{{ $data->kode }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input kode substance">
                            <div class="form-group">
                                <label>Kode</label>
                                <input type="text" class="form-control txt_line" placeholder="Input kode substance" name="kode" id="kode" required readonly>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input nama substance">
                            <div class="form-group">
                                <label>NamaMc</label>
                                <input type="text" class="form-control txt_line" placeholder="Input nama substance" name="namaMc" id="namaMc" required readonly>
                                <label>NamaLog</label>
                                <input type="text" class="form-control txt_line" placeholder="Input nama substance" name="namaLog" id="namaLog" required readonly>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input Liner Atas">
                            <div class="form-group">
                                <label>Gram Liner Atas</label>
                                <input type="hidden" id="jenisGramLinerAtas_id" name="jenisGramLinerAtas_id">
                                <select class="js-example-basic-single col-md-12" name="atas" id="atas" onchange="getNamaSubstance()" disabled>
                                    <option value=''>--</option>
                                    @foreach ($jenisgram1 as $data)
                                    <option value="{{ $data->id }}|{{ $data->namaMc }}|{{ $data->namaLog }}">{{ $data->namaMc }}/{{ $data->namaLog }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input Liner Atas">
                            <div class="form-group">
                                <label>Flute 1</label>
                                <input type="hidden" id="jenisGramFlute1_id" name="jenisGramFlute1_id">
                                <select class="js-example-basic-single col-md-12" name="flute1" id="flute1" onchange=getNamaSubstance() disabled>
                                    <option value=''>--</option>
                                    @foreach ($jenisgram2 as $data)
                                    <option value="{{ $data->id }}|{{ $data->namaMc }}|{{ $data->namaLog }}">{{ $data->namaMc }}/{{ $data->namaLog }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input Liner Atas">
                            <div class="form-group">
                                <label>Gram Liner Tengah</label>
                                <input type="hidden" id="jenisGramLinerTengah_id" name="jenisGramLinerTengah_id">
                                <select class="js-example-basic-single col-md-12" name="tengah" id="tengah" onchange="getNamaSubstance();" disabled>
                                    <option value=''>--</option>
                                    @foreach ($jenisgram1 as $data)
                                    <option value="{{ $data->id }}|{{ $data->namaMc }}|{{ $data->namaLog }}">{{ $data->namaMc }}/{{ $data->namaLog }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input Liner Atas">
                            <div class="form-group">
                                <label>Gram CF</label>
                                <input type="hidden" id="jenisGramFlute2_id" name="jenisGramFlute2_id">
                                <select class="js-example-basic-single col-md-12" name="flute2" id="flute2" onchange="getNamaSubstance();" disabled>
                                    <option value=''>--</option>
                                    @foreach ($jenisgram2 as $data)
                                    <option value="{{ $data->id }}|{{ $data->namaMc }}|{{ $data->namaLog }}">{{ $data->namaMc }}/{{ $data->namaLog }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input Liner Atas">
                            <div class="form-group">
                                <label>Gram Liner Bawah</label>
                                <input type="hidden" id="jenisGramLinerBawah_id" name="jenisGramLinerBawah_id">
                                <select class="js-example-basic-single col-md-12" name="bawah" id="bawah" onchange="getNamaSubstance();" disabled>
                                    <option value=''>--</option>
                                    @foreach ($jenisgram1 as $data)
                                    <option value="{{ $data->id }}|{{ $data->namaMc }}|{{ $data->namaLog }}">{{ $data->namaMc }}/{{ $data->namaLog }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <input type="hidden" class="form-control txt_line" name="createdBy" id="createdBy" value="{{ Auth::user()->name }}">
                        <div class="col-md-12">
                            <button type="submit" id="save" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Save">
                                <i class='far fa-check-square'></i>
                            </button>
                            <button type="button" id="cancel" class="btn" data-toggle="tooltip" data-placement="right" title="Cancel">
                                <a href="{{ route('substance') }}">
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
        
        // function getNama(a){
        //     var pos = a.indexOf('|');
        //     var panjang = a.length;
        //     var nama = a.substr(pos+1, panjang);

        //     return nama;
        //     // console.log(nama);
        // }

        // function getNama(a) {
        //     var array = a.split('|');
        //     var id = array[0];
        //     var namaMc = array[1];
        //     var namaLog = array[2];
        // }

        // function getID(a){
        //     var pos = a.indexOf('|');
        //     var panjang = a.length;
        //     var id = a.substr(0, pos);

        //     return id;
        // }

        function getFlute(){
            var namaflute = document.getElementById('flute').value;

            // var namaflute = getNama(flute);
            

            if (namaflute == 'BF') {
                document.getElementById('atas').disabled = false;
                document.getElementById('flute1').disabled = false;
                document.getElementById('tengah').disabled = true;
                document.getElementById('flute2').disabled = true;
                document.getElementById('bawah').disabled = false;
            } else if(namaflute == 'CF') {
                document.getElementById('atas').disabled = false;
                document.getElementById('flute1').disabled = true;
                document.getElementById('tengah').disabled = true;
                document.getElementById('flute2').disabled = false;
                document.getElementById('bawah').disabled = false;
            } else if (namaflute == 'BCF') {
                document.getElementById('atas').disabled = false;
                document.getElementById('flute1').disabled = false;
                document.getElementById('tengah').disabled = false;
                document.getElementById('flute2').disabled = false;
                document.getElementById('bawah').disabled = false;
            }
            
        }
        
        function getNamaSubstance(){
            var namaflute = document.getElementById('flute').value;

            var atas = (document.getElementById('atas').value).split("|");
            var idAtas = atas[0]
            var namaMcAtas = atas[1];
            var namaLogAtas = atas[2];

            console.log(atas);

            var flute1 = (document.getElementById('flute1').value).split("|");
            var idflute1 = flute1[0]
            var namaMcflute1 = flute1[1];
            var namaLogflute1 = flute1[2];

            var tengah = (document.getElementById('tengah').value).split("|");
            var idTengah = tengah[0]
            var namaMcTengah = tengah[1];
            var namaLogTengah = tengah[2];

            var flute2 = (document.getElementById('flute2').value).split("|");
            var idflute2 = flute2[0]
            var namaMcflute2 = flute2[1];
            var namaLogflute2 = flute2[2];

            var bawah = (document.getElementById('bawah').value).split("|");
            var idbawah = bawah[0]
            var namaMcbawah = bawah[1];
            var namaLogbawah = bawah[2];
            
            
            
            if (flute1 == '') {
                namaMcflute1 = '--';
                namaLogflute1 = '--';
                idflute1 = '';
            }
            if (tengah == '') {
                namaMcTengah = '--';
                namaLogTengah = '--';
                idTengah = '';
            }
            if (flute2 == '') {
                namaMcflute2 = '--';
                namaLogflute2 = '--';
                idflute2 = '';
            }
            

            document.getElementById("jenisGramLinerAtas_id").value = idAtas;
            document.getElementById("jenisGramFlute1_id").value = idflute1;
            document.getElementById("jenisGramLinerTengah_id").value = idTengah;
            document.getElementById("jenisGramFlute2_id").value = idflute2;
            document.getElementById("jenisGramLinerBawah_id").value = idbawah;
            document.getElementById("namaMc").value = namaflute + ' ' + namaMcAtas + '/' + namaMcflute1 + '/' + namaMcTengah + '/' + namaMcflute2 + '/' + namaMcbawah;
            document.getElementById("kode").value = namaflute + ' ' + namaMcAtas + '/' + namaMcflute1 + '/' + namaMcTengah + '/' + namaMcflute2 + '/' + namaMcbawah;
            document.getElementById("namaLog").value = namaflute + ' ' + namaLogAtas + '/' + namaLogflute1 + '/' + namaLogTengah + '/' + namaLogflute2 + '/' + namaLogbawah;
        }
        // atas.onchange = function() {
            //     var lineratas = atas.options[atas.selectedIndex].getAttribute('name');
            
            //     console.log(lineratas);
            // }
        </script>