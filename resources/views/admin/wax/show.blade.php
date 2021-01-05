@extends('admin.templates.partials.default')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row" id="form_list_mc">
            <div class="col-md-5">
                <h4 class="modal-title"><strong>Show Mata Uang</strong> </h4>
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Kode</label>
                                <input type="text" class="form-control txt_line" name="kode" id="kode" value="{{ $wax->kode }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control txt_line" name="nama" id="nama" value="{{ $wax->nama }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Luas</label>
                                <input type="text" class="form-control txt_line" name="luas" id="luas" value="{{ $wax->luas }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>In Out</label>
                                <input type="text" class="form-control txt_line" name="inOut" id="inOut" value="{{ $wax->inOut }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Satuan Luas</label>
                                <input type="text" class="form-control txt_line" name="satuanLuas" id="satuanLuas" value="{{ $wax->satuanLuas }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Gram Wax</label>
                                <input type="text" class="form-control txt_line" name="gramWax" id="gramWax" value="{{ $wax->gramWax }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Satuan Gram Wax</label>
                                <input type="text" class="form-control txt_line" name="satuanGramWax" id="satuanGramWax" value="{{ $wax->satuanGramWax }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Average Price</label>
                                <input type="text" class="form-control txt_line" name="avgPrice" id="avgPrice" value="{{ $wax->avgPrice }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Mata Uang</label>
                                <input type="text" class="form-control txt_line" name="mataUang" id="mataUang" value="{{ $wax->mataUang }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Branch</label>
                                <input type="text" class="form-control txt_line" name="branch" id="branch" value="{{ $wax->branch }}" readonly>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <button type="submit" class="btn btn-primary">Back</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection