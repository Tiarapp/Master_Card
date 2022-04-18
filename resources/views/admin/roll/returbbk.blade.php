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
    @if ($message = Session::get('succes'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>{{ $message }}</strong>
        </div>
    @endif
    {{-- @include('sweetalert::alert') --}}
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
                <form action="../preturbbk/{{ $rolld->id }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Kode Roll</label>
                                        <input type="text" class="form-control txt_line" value="{{ $rolld->kode_roll }}" name="kode_roll" id="kode_roll" required readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Kode Internal</label>
                                        <input type="text" class="form-control txt_line" value="{{ $rolld->kode_internal }}" name="kode_roll" id="kode_roll" readonly required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tanggal Retur</label>
                                        <input type="date" class="form-control txt_line" name="tglretur" id="tglretur" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>QTY</label>
                                        <input type="text" class="form-control txt_line" name="qty" id="qty" required>
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


</script>

            
@endsection