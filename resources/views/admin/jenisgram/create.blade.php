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
            <div class="col-md-12">
                <h4 class="modal-title">Tambah Jenis Gram</h4>
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
                
                <form action="{{ route('jenisgram.store') }}" method="POST" class="inputJenisGram">
                    @csrf
                    <div class="col-md-12" style="margin-top: 10px; margin-bot: 10px;">
                        <div class="row">
                            <div class="col-md-1" >
                                <label>Kode</label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control txt_line" data-toggle="tooltip" data-placement="right" title="Input kode jenis gram" placeholder="Input kode jenis gram" name="kode" id="kode" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2"  style="margin-top: 10px; margin-bot: 10px;">
                        <div class="form-group">
                            <label>Gram Kertas</label>
                            <input type="text" class="form-control txt_line" placeholder="Input gram kertas" name="gramKertas" id="gramKertas" data-toggle="tooltip" data-placement="right" title="Input gram kertas" onchange="getNama();" required>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 10px; margin-bot: 10px;">
                        <div class="row">
                            <div class="col-md-2">
                                <label>Jenis Kertas di MC</label>
                                <input type="text" class="form-control txt_line" data-toggle="tooltip" data-placement="right" title="Input kode jenis gram" placeholder="Input kode jenis gram" name="jenisKertasMc" id="jenisKertasMc" onchange="getNama();"required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                            <div class="col-md-2">
                                <label>Jenis Kertas di Log</label>
                                <input type="text" class="form-control txt_line" data-toggle="tooltip" data-placement="right" title="Input kode jenis gram" placeholder="Input kode jenis gram" name="jenisKertasLog" id="jenisKertasLog" onchange="getNama();" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 10px; margin-bot: 10px;">
                        <div class="row">
                            <div class="col-md-2">
                                <label>Nama di MC</label>
                                <input type="text" class="form-control txt_line" data-toggle="tooltip" data-placement="right" title="Input kode jenis gram" placeholder="Input kode jenis gram" name="namaMc" id="namaMc" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                            <div class="col-md-2">
                                <label>Nama di Log</label>
                                <input type="text" class="form-control txt_line" data-toggle="tooltip" data-placement="right" title="Input kode jenis gram" placeholder="Input kode jenis gram" name="namaLog" id="namaLog" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" class="form-control txt_line" name="createdBy" id="createdBy" value="{{ Auth::user()->name }}">
                    <div class="col-md-12">
                        <button type="submit" id="save" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Save">
                            <i class='far fa-check-square'></i>
                        </button>
                        <button type="button" id="cancel" class="btn" data-toggle="tooltip" data-placement="right" title="Cancel">
                            <a href="{{ route('jenisgram') }}">
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
    
    function getNama(){
        var jenisMc = document.getElementById("jenisKertasMc").value;
        var jenisLog = document.getElementById("jenisKertasLog").value;
        var gram = document.getElementById("gramKertas").value;
        
        document.getElementById("namaMc").value = jenisMc + gram;
        document.getElementById("namaLog").value = jenisLog + gram;
    }
    
</script>