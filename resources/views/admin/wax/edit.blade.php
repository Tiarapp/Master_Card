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
                <h4 class="modal-title"><strong>Edit Wax</strong> </h4>
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

                <form action="../update/{{ $wax->id }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
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
                                <input type="text" class="form-control txt_line" name="nama" id="nama" value="{{ $wax->nama }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Luas</label>
                                <input type="text" class="form-control txt_line" name="luas" id="luas" value="{{ $wax->luas }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>In Out</label>
                                <select class="js-example-basic-single col-md-12" name="inOut" id="inOut">
                                    <option value="INSIDE">INSIDE</option>
                                    <option value="OUTSIDE">OUTSIDE</option>
                                    <option value="IN & OUT">IN & OUT</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Satuan Luas</label>
                                <select class="js-example-basic-single col-md-12" name="satuanLuas" id="satuanLuas">
                                    @foreach ($satuan as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Gram Wax</label>
                                <input type="text" class="form-control txt_line" name="gramWax" id="gramWax" value="{{ $wax->gramWax }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Satuan Gram Wax</label>
                                <select class="js-example-basic-single col-md-12" name="satuanGramWax" id="satuanGramWax">
                                    @foreach ($satuan as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                    @endforeach
                                </select>
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
                                <select class="js-example-basic-single col-md-12" name="mataUang" id="mataUang">
                                    @foreach ($matauang as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Branch</label>
                                <input type="text" class="form-control txt_line" name="branch" id="branch" value="{{ $wax->branch }}">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <input type="hidden" class="form-control txt_line" name="lastUpdatedBy" id="lastUpdatedBy" value="{{ Auth::user()->name }}">
                            <button type="submit" class="btn btn-primary">Simpan</button>
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
</script>