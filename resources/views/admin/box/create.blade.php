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
                                <label>Berat Sheet Box</label>
                                <input type="text" class="form-control txt_line" placeholder="" name="gramSheetBox" id="gramSheetBox" onchange="luas(); getNama();" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="">
                            <div class="form-group">
                                <label>Panjang Dalam Box</label>
                                <input type="text" class="form-control txt_line" placeholder="" name="panjangDalamBox" id="panjangDalamBox" onchange="luas(); getNama();" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="">
                            <div class="form-group">
                                <label>Lebar Dalam Box</label>
                                <input type="text" class="form-control txt_line" placeholder="" name="lebarDalamBox" id="lebarDalamBox" onchange="luas(); getNama();" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="">
                            <div class="form-group">
                                <label>Tinggi Dalam Box</label>
                                <input type="text" class="form-control txt_line" placeholder="" name="tinggiDalamBox" id="tinggiDalamBox" onchange="luas(); getNama();" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="">
                            <div class="form-group">
                                <label>Creas Corr</label>
                                <input type="text" class="form-control txt_line" placeholder="" name="sizeCreasCorr" id="sizeCreasCorr" onchange="luas(); getNama();" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="">
                            <div class="form-group">
                                <label>Creas Conv</label>
                                <input type="text" class="form-control txt_line" placeholder="" name="sizeCreasConv" id="sizeCreasConv" onchange="luas(); getNama();" required>
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
    var panjang = document.getElementById("panjangSheet").value;
    var lebar = document.getElementById("lebarSheet").value;
    var luas;
        luas = panjang * lebar;
        document.getElementById("luasSheet").value =  luas;
}

function getNama(){
    var panjang = document.getElementById("panjangSheet").value;
    var lebar = document.getElementById("lebarSheet").value;

    document.getElementById("nama").value = panjang +' x '+ lebar;
}

</script>