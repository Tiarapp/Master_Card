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
                <h4 class="modal-title">Tambah Form Mastercard</h4>
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
                
                <form action="{{ route('mkt.store.formmc') }}" method="POST" class="inputSheet">
                    @csrf
                    <div class="row was-validated">
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Pilih Tipe Box">
                            <div class="form-group">
                                <label>Customer</label>
                                <div class="row">
                                    <div class="col-md-10">
                                        <input type="text" class="form-control txt_line" name="cust" id="cust">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input Flute">
                            <div class="form-group">
                                <label>Barang</label>
                                <div class="row">
                                    <div class="col-md-10">
                                        <input type="text" class="form-control txt_line" name="barang" id="barang">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input Flute">
                            <div class="form-group">
                                <label>Keterangan</label>
                                <div class="row">
                                    <div class="col-md-10">
                                        <input type="text" class="form-control txt_line" name="keterangan" id="keterangan">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" class="form-control txt_line" name="createdBy" id="createdBy" value="{{ Auth::user()->name }}">
                        <div class="col-md-12">
                            <button type="submit" id="save" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Save">
                                <i class='far fa-check-square'></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>    
</div>
    
    @endsection