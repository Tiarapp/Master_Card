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
                                <select class="js-example-basic-single col-md-12" name="jenisGramLinerAtas_id" id="jenisGramLinerAtas_id">
                                    @foreach ($jenisgram as $data)
                                    <option value=" {{ $data->id }}" name="{{ $data->nama }}">{{ $data->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input Liner Atas">
                            <div class="form-group">
                                <label>Gram BF</label>
                                <select class="js-example-basic-single col-md-12" name="jenisGramBf_id" id="jenisGramBf_id" onchange="getBf(this);">
                                    <option value=''>Select</option>
                                    @foreach ($jenisgram as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input Liner Atas">
                            <div class="form-group">
                                <label>Gram Liner Tengah</label>
                                <select class="js-example-basic-single col-md-12" name="jenisGramLinerTengah_id" id="jenisGramLinerTengah_id" onchange="getNama();">
                                    @foreach ($jenisgram as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input Liner Atas">
                            <div class="form-group">
                                <label>Gram CF</label>
                                <select class="js-example-basic-single col-md-12" name="jenisGramCf_id" id="jenisGramCf_id" onchange="getNama();">
                                    @foreach ($jenisgram as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                    <!-- <input type="hidden" name="cf" id="cf" value="{{ $data->nama }}"> -->
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input Liner Atas">
                            <div class="form-group">
                                <label>Gram Liner Bawah</label>
                                <select class="js-example-basic-single col-md-12" name="jenisGramLinerBawah_id" id="jenisGramLinerBawah_id" onchange="getNama();">
                                    @foreach ($jenisgram as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                    <!-- <input type="hidden" name="linerBawah" id="linerBawah" value="{{ $data->nama }}"> -->
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

    var atas = document.getElementById('jenisGramLinerAtas_id')
    atas.onchange = function() {
        var lineratas = atas.options[atas.selectedIndex].getAttribute('name');

        console.log(lineratas);
    }
</script>