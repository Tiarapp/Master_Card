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
                <h4 class="modal-title">Tambah Sheet</h4>
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

                <form action="{{ route('sheet.store') }}" method="POST" class="inputSheet">
                    @csrf
                    <div class="row was-validated">
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input kode sheet">
                            <div class="form-group">
                                <label>Kode</label>
                                <input type="text" class="form-control txt_line" placeholder="Input kode sheet" name="kode" id="kode" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input nama sheet">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control txt_line" placeholder="Input nama sheet" name="nama" id="nama" required readonly>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input lebar sheet">
                            <div class="form-group">
                                <label>Lebar</label>
                                <input type="text" class="form-control txt_line" placeholder="Input Lebar Sheet" name="lebarSheet" id="lebarSheet" onchange="luas()" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input panjang sheet">
                            <div class="form-group">
                                <label>Panjang</label>
                                <input type="text" class="form-control txt_line" placeholder="Input panjang sheet" name="panjangSheet" id="panjangSheet" onchange="luas(); getNama();" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input satuan size sheet">
                            <div class="form-group">
                                <label>Satuan Size</label>
                                <select class="js-example-basic-single col-md-12" name="satuanSizeSheet" id="satuanSizeSheet">
                                    @foreach ($satuan as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Luas sheet">
                            <div class="form-group">
                                <label>Luas</label>
                                <input type="text" class="form-control txt_line" name="luasSheet" id="luasSheet" required readonly>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input satuan luas sheet">
                            <div class="form-group">
                                <label>Satuan Luas</label>
                                <select class="js-example-basic-single col-md-12" name="satuanLuasSheet" id="satuanLuasSheet">
                                    @foreach ($satuan as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama }}</option>
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
    var panjang = document.getElementById("panjangSheet").value;
    var lebar = document.getElementById("lebarSheet").value;
    var luas;

        // panjang = document.getElementById("panjangSheet").value;
        // lebar = document.getElementById("lebarSheet").value;
        // if (panjang == ""){
        //     alert("Panjang Harus diisi !");
        //     return;
        // }else if (lebar == ""){
        //     alert("Lebar Harus diisi !");
        //     return;
        // }
        // if (isNaN(panjang)){
        //     alert("Panjang Harus diisi dengan angka !");
        //     return;
        // }if (isNaN(lebar)){
        //     alert("Lebar Harus diisi dengan angka !");
        //     return;
        // }
        luas = panjang * lebar;
        document.getElementById("luasSheet").value =  luas;
}

function getNama(){
    var panjang = document.getElementById("panjangSheet").value;
    var lebar = document.getElementById("lebarSheet").value;

    document.getElementById("nama").value = panjang +' x '+ lebar;
}

</script>