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
                <h4 class="modal-title">Tambah Form Permintaan</h4>
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
                
                <form action="{{ route('mkt.update.formpermintaan', $memo->id) }}" method="POST" class="inputSheet">
                    @csrf
                    @method('PUT')
                    <div class="row was-validated">
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Auto Generated">
                            <div class="form-group">
                                <label>Tanggal</label>
                                <div class="row">
                                    <div class="col-md-10">
                                        <input type="date" class="form-control txt_line" name="tanggal" id="tanggal" value="{{ old('tanggal', $memo->tanggal) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Pilih Tipe Box" valu>
                            <div class="form-group">
                                <label>Customer</label>
                                <div class="row">
                                    <div class="col-md-10">
                                        <input type="text" class="form-control txt_line" name="customer" id="customer" value="{{ old('customer', $memo->customer) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input Flute">
                            <div class="form-group">
                                <label>Barang</label>
                                <div class="row">
                                    <div class="col-md-10">
                                        <input type="text" class="form-control txt_line" name="barang" id="barang" value="{{ old('barang', $memo->barang) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input Flute">
                            <div class="form-group">
                                <label>Keterangan</label>
                                <div class="row">
                                    <div class="col-md-10">
                                        <select class="js-example-basic-single col-md-12" name="keterangan" id="keterangan">
                                            <option value='Design' {{ old('keterangan' , $memo->keterangan) == 'Design' ? 'selected' : ''}}>Design</option>
                                            <option value='Design Pisau' {{ old('keterangan' , $memo->keterangan) == 'Design Pisau' ? 'selected' : ''}}>Design Pisau</option>
                                            <option value='Revisi Design' {{ old('keterangan' , $memo->keterangan) == 'Revisi Design' ? 'selected' : ''}}>Revisi Design</option>
                                            <option value='Revisi Design Pisau' {{ old('keterangan' , $memo->keterangan) == 'Revisi Design Pisau' ? 'selected' : ''}}>Revisi Design Pisau</option>
                                            <option value='Dies Cetak' {{ old('keterangan' , $memo->keterangan) == 'Dies Cetak' ? 'selected' : ''}}>Dies Cetak</option>
                                            <option value='Pisau Punch' {{ old('keterangan' , $memo->keterangan) == 'Pisau Punch' ? 'selected' : ''}}>Pisau Punch</option>
                                            <option value='Contoh Polos' {{ old('keterangan' , $memo->keterangan) == 'Contoh Polos' ? 'selected' : ''}}>Contoh Polos</option>
                                            <option value='Contoh Cetakan' {{ old('keterangan' , $memo->keterangan) == 'Contoh Cetakan' ? 'selected' : ''}}>Contoh Cetakan</option>
                                            <option value='Contoh Tempelan' {{ old('keterangan' , $memo->keterangan) == 'Contoh Tempelan' ? 'selected' : ''}}>Contoh Tempelan</option>
                                        </select>
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

<script type="text/javascript">
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    })
</script>