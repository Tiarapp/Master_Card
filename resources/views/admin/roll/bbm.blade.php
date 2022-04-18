@extends('admin.templates.partials.default')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<style>
    .select2 {
        width: 206px !important;
    }
</style>

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row" id="form_list_mc">
            <div class="col-md-12">
                <h4 class="modal-title"><strong>BBM Roll</strong> </h4>
                <hr>

                @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Error!</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- tampilan create start -->
                <!-- action untuk save data yang diinput -->
                <form action="{{ route('roll.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Kode Roll</label>
                                    <input type="text" class="form-control txt_line" name="kode_roll" id="kode_roll" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tanggal</label>
                                        <input type="date" class="form-control txt_line" name="tglbbm" id="tglbbm" required>
                                    </div>
                                </div><div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>Supplier</label>
                                        </div>
                                        <div class="col-md-12">
                                            <select class='js-example-basic-single col-md-12' name="supp" id="supp" required>
                                                <?php foreach ($suppliers as $supp) { ?>
                                                    <option value="{{ $supp->id }}">{{ $supp->name }}</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Berat SJ</label>
                                        <input type="text" class="form-control txt_line" name="beratsj" id="beratsj" required >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Berat Timbang</label>
                                        <input type="text" class="form-control txt_line" name="berattimbang" id="berattimbang" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>Jenis</label>
                                        </div>
                                        <div class="col-md-12">
                                            <select class='js-example-basic-single col-md-12' name="rollm" id="rollm" required>
                                                <?php foreach ($rollm as $data) { ?>
                                                    <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>No. PO</label>
                                        <input type="text" class="form-control txt_line" name="nopo" id="nopo" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>GSM Actual</label>
                                    <input type="text" class="form-control txt_line" name="gsm_actual" id="gsm_actual" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Cobsize Top</label>
                                        <input type="text" class="form-control txt_line" name="cobsizetop" id="cobsizetop" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Cobsize Back</label>
                                        <input type="text" class="form-control txt_line" name="cobsizeback" id="cobsizeback" required>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" class="form-control txt_line" name="createdBy" id="createdBy" value="{{ Auth::user()->name }}">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- tampilan create end -->
            </div>
        </div>
    </div>
</div>

@endsection
<!-- javascript untuk hitung otomatis saat input -->
@section('javascripts')

<script type="text/javascript">
    // javascript untuk search di dropdown
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });

    // fungsi untuk hitung PCS
    function getPcs(){
        var koli = document.getElementById('opnamekoli').value;
        var perkoli = document.getElementById('perkoli').value;
        var pcs;

        pcs = koli * perkoli;

        document.getElementById('opnamepcs').value = pcs;

    }

</script>

            
@endsection