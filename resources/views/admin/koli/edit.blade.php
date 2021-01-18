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
                <h4 class="modal-title"><strong>Edit Koli</strong> </h4>
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

                <form action="/admin/koli/update/{{ $koli->id }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Kode</label>
                                <input type="text" class="form-control txt_line" name="kode" id="kode" value="{{ $koli->kode }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control txt_line" value="{{ $koli->nama }}" name="nama" id="nama">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Qty Box</label>
                                <input type="text" class="form-control txt_line" value="{{ $koli->qtyBox }}" name="qtyBox" id="qtyBox">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Satuan Box</label>
                                <select class="js-example-basic-single col-md-12" name="satuanBox" id="satuanBox">
                                    @foreach ($satuan as $data)
                                        <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                    @endforeach
                                </select>
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