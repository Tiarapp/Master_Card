@extends('admin.templates.partials.default')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row" id="form_list_mc">
            <div class="col-md-9">
                <h4 class="modal-title">Tambah Color Combine</h4>
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
                
                <form action="{{ route('colorcombine.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Kode</label>
                                <input type="text" class="form-control txt_line" name="kode" id="kode">
                                
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control txt_line" name="nama" id="nama">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {{-- <label>Warna 1</label> --}}
                                        <input type="hidden" name="idColor1" id="idColor1">
                                        <input type="hidden" name="warna1" id="warna1">
                                        <select class="js-example-basic-single col-md-12" name="wrn1" id="wrn1" onchange="getWarna();getNama()">
                                            <option value="Tidak Ada" disabled selected>Warna 1</option>
                                            <option value="Tidak Ada">Tidak Ada</option>
                                            @foreach ($color as $data)
                                            <option value="{{ $data->id }} {{ $data->nama }}">{{ $data->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {{-- <label>Warna 2</label> --}}
                                        <input type="hidden" name="idColor2" id="idColor2">
                                        <input type="hidden" name="warna2" id="warna2">
                                        <select class="js-example-basic-single col-md-12" name="wrn2" id="wrn2" onchange="getWarna();getNama()">
                                            <option value="Tidak Ada" disabled selected>Warna 2</option>
                                            <option value="Tidak Ada">Tidak Ada</option>
                                            @foreach ($color as $data)
                                            <option value="{{ $data->id }} {{ $data->nama }}">{{ $data->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {{-- <label>Warna 3</label> --}}
                                        <input type="hidden" name="idColor3" id="idColor3">
                                        <input type="hidden" name="warna3" id="warna3">
                                        <select class="js-example-basic-single col-md-12" name="wrn3" id="wrn3" onchange="getWarna();getNama()">
                                            <option value="Tidak Ada" disabled selected>Warna 3</option>
                                            <option value="Tidak Ada">Tidak Ada</option>
                                            @foreach ($color as $data)
                                            <option value="{{ $data->id }} {{ $data->nama }}">{{ $data->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {{-- <label>Warna 4</label> --}}
                                        <input type="hidden" name="idColor4" id="idColor4">
                                        <input type="hidden" name="warna4" id="warna4">
                                        <select class="js-example-basic-single col-md-12" name="wrn4" id="wrn4" onchange="getWarna();getNama()">
                                            <option value="Tidak Ada" disabled selected>Warna 4</option>
                                            <option value="Tidak Ada">Tidak Ada</option>
                                            @foreach ($color as $data)
                                            <option value="{{ $data->id }} {{ $data->nama }}">{{ $data->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" id="new" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Add New Color">
                                        <i class='fas fa-plus-circle fa-2x'></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" class="form-control txt_line" name="createdBy" id="createdBy" value="{{ Auth::user()->name }}">
                        <div class="col-md-12">
                            <button type="submit" id="save" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="save">
                                <i class='far fa-check-square'></i>
                            </button>
                            <button type="button" id="cancel" class="btn" data-toggle="tooltip" data-placement="right" title="cancel">
                                <a href="{{ route('colorcombine') }}">
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
        
        function getWarna(){
            var wrn1 = document.getElementById("wrn1").value;
            var wrn2 = document.getElementById("wrn2").value;
            var wrn3 = document.getElementById("wrn3").value;
            var wrn4 = document.getElementById("wrn4").value;
            
            if (wrn1 == 'Tidak Ada') {
                document.getElementById("idColor1").value = null;
                document.getElementById("warna1").value = '-';
            } else {
                wrn1 = wrn1.split(" ");
                document.getElementById("idColor1").value = wrn1[0];
                document.getElementById("warna1").value = wrn1[1];
            }
            
            if (wrn2 == 'Tidak Ada') {
                document.getElementById("idColor2").value = null;
                document.getElementById("warna2").value = '-';
            } else {
                wrn2 = wrn2.split(" ");
                document.getElementById("idColor2").value = wrn2[0];
                document.getElementById("warna2").value = wrn2[1];
            }

            if (wrn3 == 'Tidak Ada') {
                document.getElementById("idColor3").value = null;
                document.getElementById("warna3").value = '-';
            } else {
                wrn3 = wrn3.split(" ");
                document.getElementById("idColor3").value = wrn3[0];
                document.getElementById("warna3").value = wrn3[1];
            }

            if (wrn4 == 'Tidak Ada') {
                document.getElementById("idColor4").value = null;
                document.getElementById("warna4").value = '-';
            } else {
                wrn4 = wrn4.split(" ");
                document.getElementById("idColor4").value = wrn4[0];
                document.getElementById("warna4").value = wrn4[1];
            }            
            
        }
        
        function getNama(){
            var wrn1 = document.getElementById("warna1").value;
            var wrn2 = document.getElementById("warna2").value;
            var wrn3 = document.getElementById("warna3").value;
            var wrn4 = document.getElementById("warna4").value;
            
            document.getElementById("nama").value = wrn1+' '+wrn2+' '+wrn3+' '+wrn4;
        }
    </script>