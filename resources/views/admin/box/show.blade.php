<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>
@extends('admin.templates.partials.default')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row" id="form_list_mc">
            <div class="col-md-5">
                <h4 class="modal-title"><strong>Divisi</strong> </h4>
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

                <form>
                    <div class="row was-validated">
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input kode sheet">
                            <div class="form-group">
                                <label>Kode</label>
                                <input type="text" class="form-control txt_line" placeholder="Input kode sheet" name="kode" id="kode" value="{{ $sheet->kode }}" readonly>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input nama sheet">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control txt_line" placeholder="Input nama sheet" name="nama" id="nama" value="{{ $sheet->nama }}" readonly>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input lebar sheet">
                            <div class="form-group">
                                <label>Lebar</label>
                                <input type="text" class="form-control txt_line" placeholder="Input Lebar Sheet" name="lebarSheet" id="lebarSheet" value="{{ $sheet->lebarSheet }}" readonly>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input panjang sheet">
                            <div class="form-group">
                                <label>Panjang</label>
                                <input type="text" class="form-control txt_line" placeholder="Input panjang sheet" name="panjangSheet" id="panjangSheet" value="{{ $sheet->panjangSheet }}" readonly>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input satuan size sheet">
                            <div class="form-group">
                                <label>Satuan Size</label>
                                <input type="text" class="form-control txt_line" placeholder="Input satuan size sheet" name="satuanSizeSheet" id="satuanSizeSheet" value="{{ $sheet->satuanSizeSheet }}" readonly>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Luas sheet">
                            <div class="form-group">
                                <label>Luas</label>
                                <input type="text" class="form-control txt_line" name="luasSheet" id="luasSheet" value="{{ $sheet->luasSheet }}" readonly>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input satuan luas sheet">
                            <div class="form-group">
                                <label>Satuan Luas</label>
                                <input type="text" class="form-control txt_line" placeholder="Input satauan luas sheet" name="satuanLuasSheet" id="satuanLuasSheet" value="{{ $sheet->satuanLuasSheet }}" readonly>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <input type="hidden" class="form-control txt_line" name="lastUpdatedBy" id="lastUpdatedBy" value="{{ Auth::user()->name }}">
                        <div class="col-md-12">
                            <button type="submit" id="save" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Save">
                                <i class='far fa-check-square'></i>
                            </button>
                            <button type="button" id="cancel" class="btn" data-toggle="tooltip" data-placement="right" title="Cancel">
                                <a href="{{ route('box') }}t">
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