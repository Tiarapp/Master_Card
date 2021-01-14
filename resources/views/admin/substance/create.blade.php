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
                
                <form action="/admin/substance/store" method="POST" class="inputSubstance">
                    @csrf
                    <div class="row was-validated">
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input Liner Atas">
                            <div class="form-group">
                                <label>Pilih Flute</label>
                                <select class="js-example-basic-single col-md-12" name="flute" id="flute" onchange="getFlute()">
                                    <option value=''>--</option>
                                    @foreach ($flute as $data)
                                    <option value="{{ $data->id }}|{{ $data->nama }}">{{ $data->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input kode substance">
                            <div class="form-group">
                                <label>Kode</label>
                                <input type="text" class="form-control txt_line" placeholder="Input kode substance" name="kode" id="kode" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input nama substance">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control txt_line" placeholder="Input nama substance" name="nama" id="nama" required readonly>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input Liner Atas">
                            <div class="form-group">
                                <label>Gram Liner Atas</label>
                                <input type="hidden" id="jenisGramLinerAtas_id" name="jenisGramLinerAtas_id">
                                <select class="js-example-basic-single col-md-12" name="linerAtas" id="linerAtas" onchange="getNamaSubstance()" disabled>
                                    <option value=''>--</option>
                                    @foreach ($jenisgram as $data)
                                    <option value="{{ $data->id }}|{{ $data->nama }}">{{ $data->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input Liner Atas">
                            <div class="form-group">
                                <label>Gram BF</label>
                                <input type="hidden" id="jenisGramBf_id" name="jenisGramBf_id">
                                <select class="js-example-basic-single col-md-12" name="bf" id="bf" onchange=getNamaSubstance() disabled>
                                    <option value=''>--</option>
                                    @foreach ($jenisgram as $data)
                                    <option value="{{ $data->id }}|{{ $data->nama }}">{{ $data->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input Liner Atas">
                            <div class="form-group">
                                <label>Gram Liner Tengah</label>
                                <input type="hidden" id="jenisGramLinerTengah_id" name="jenisGramLinerTengah_id">
                                <select class="js-example-basic-single col-md-12" name="linerTengah" id="linerTengah" onchange="getNamaSubstance();" disabled>
                                    <option value=''>--</option>
                                    @foreach ($jenisgram as $data)
                                    <option value="{{ $data->id }}|{{ $data->nama }}">{{ $data->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input Liner Atas">
                            <div class="form-group">
                                <label>Gram CF</label>
                                <input type="hidden" id="jenisGramCf_id" name="jenisGramCf_id">
                                <select class="js-example-basic-single col-md-12" name="cf" id="cf" onchange="getNamaSubstance();" disabled>
                                    <option value=''>--</option>
                                    @foreach ($jenisgram as $data)
                                    <option value="{{ $data->id }}|{{ $data->nama }}">{{ $data->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input Liner Atas">
                            <div class="form-group">
                                <label>Gram Liner Bawah</label>
                                <input type="hidden" id="jenisGramLinerBawah_id" name="jenisGramLinerBawah_id">
                                <select class="js-example-basic-single col-md-12" name="linerBawah" id="linerBawah" onchange="getNamaSubstance();" disabled>
                                    <option value=''>--</option>
                                    @foreach ($jenisgram as $data)
                                    <option value="{{ $data->id }}|{{ $data->nama }}">{{ $data->nama }}</option>
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
                                <a href="/admin/substance">
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
        
        function getNama(a){
            var pos = a.indexOf('|');
            var panjang = a.length;
            var nama = a.substr(pos+1, panjang);

            return nama;
        }

        function getID(a){
            var pos = a.indexOf('|');
            var panjang = a.length;
            var id = a.substr(0, pos);

            return id;
        }

        function getFlute(){
            var flute = document.getElementById('flute').value;

            var namaflute = getNama(flute);
            

            if (namaflute == 'CF') {
                document.getElementById('linerAtas').disabled = false;
                document.getElementById('bf').disabled = false;
                document.getElementById('linerTengah').disabled = true;
                document.getElementById('cf').disabled = true;
                document.getElementById('linerBawah').disabled = false;
            } else if(namaflute == 'BF') {
                document.getElementById('linerAtas').disabled = false;
                document.getElementById('bf').disabled = true;
                document.getElementById('linerTengah').disabled = true;
                document.getElementById('cf').disabled = false;
                document.getElementById('linerBawah').disabled = false;
            } else if (namaflute == 'BCF') {
                document.getElementById('linerAtas').disabled = false;
                document.getElementById('bf').disabled = false;
                document.getElementById('linerTengah').disabled = false;
                document.getElementById('cf').disabled = false;
                document.getElementById('linerBawah').disabled = false;
            }
            
            document.getElementById('namaflute').value = namaflute;
        }
        
        function getNamaSubstance(){
            var atas = document.getElementById('linerAtas').value;
            var namaLinerAtas = getNama(atas);
            var idLinerAtas = getID(atas);



            var bf = document.getElementById('bf').value;
            var namabf = getNama(bf);
            var idbf = getID(bf);

            var tengah = document.getElementById('linerTengah').value;
            var namaLinerTengah = getNama(tengah);
            var idLinerTengah = getID(tengah);

            var cf = document.getElementById('cf').value;
            var namacf = getNama(cf);
            var idcf = getID(cf);

            var bawah = document.getElementById('linerBawah').value;
            var namaLinerBawah = getNama(bawah);
            var idLinerBawah = getID(bawah);
            
            
            
            if (bf == '') {
                namabf = '--';
                idbf = '';
            }
            if (tengah == '') {
                namaLinerTengah = '--';
                idLinerTengah = '';
            }
            if (cf == '') {
                namacf = '--';
                idcf = '';
            }
            

            document.getElementById("jenisGramLinerAtas_id").value = idLinerAtas;
            document.getElementById("jenisGramBf_id").value = idbf;
            document.getElementById("jenisGramLinerTengah_id").value = idLinerTengah;
            document.getElementById("jenisGramCf_id").value = idcf;
            document.getElementById("jenisGramLinerBawah_id").value = idLinerBawah;
            document.getElementById("nama").value = namaLinerAtas + '/' + namabf + '/' + namaLinerTengah + '/' + namacf + '/' + namaLinerBawah;
        }
        // atas.onchange = function() {
            //     var lineratas = atas.options[atas.selectedIndex].getAttribute('name');
            
            //     console.log(lineratas);
            // }
        </script>