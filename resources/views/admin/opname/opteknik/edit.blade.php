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
            <div class="col-md-5">
                <h4 class="modal-title"><strong>Tambah Opname</strong> </h4>
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

                <form action="{{ route('opteknik.store') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Kode</label>
                                <input type="text" class="form-control txt_line" name="kodebrg" id="kodebrg" value="{{ $teknik->KodeBrg }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nama</label>
                                <textarea class="form-control txt_line" name="namabrg" id="namabrg" readonly style="height: 100px" >
                                    {{ $teknik->NamaBrg." ".$teknik->Merk." ".$teknik->Tipe." ".$teknik->Spesifikasi }}
                                </textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Satuan</label>
                                <input type="text" class="form-control txt_line" name="satuan" id="satuan" value="{{ $teknik->SatuanP }}" readonly>                 
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Opname</label>
                                <input type="text" class="form-control txt_line" name="opnamepcs" id="opnamepcs" >
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="radio" id="simpan" name="simpan" value="save">
                                <label for="male">Simpan & Input Kode yg Sama</label><br>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="radio" id="simpan" name="simpan" value="back">
                                <label for="male">Simpan & Input Kode yg Lain</label><br>
                            </div>
                        </div>
                        <input type="hidden" class="form-control txt_line" name="createdBy" id="createdBy" value="{{ Auth::user()->name }}">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="submit" class="btn btn-primary"><a href="{{ route('opteknik.index') }}" style="color:white;">Back</a></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });

    function getPcs(){
        var flute = document.getElementById('flute').value;
        var ukuran = document.getElementById('opnamedm').value;
        var pcs;

        if (flute == 'BF') {
            pcs = ukuran * 30.8;
        }  
        if (flute == 'CF') {
            pcs = ukuran * 25;
        }
        if (flute == 'BCF') {
            pcs = ukuran * 15;
        }
        if (flute == 'EF') {
            pcs = ukuran * 1;
        }

        document.getElementById('opnamepcs').value = pcs;

    }

</script>

            
@endsection