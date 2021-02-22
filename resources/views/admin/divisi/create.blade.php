<!-- jQuery -->
<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>
@extends('admin.templates.partials.default')

@section('content')


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row" id="form_list_mc">
            <div class="col-md-5">
                <h4 class="modal-title">Tambah Divisi</h4>
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

                <form action="{{ route('divisi.store') }}" method="POST">
                    @csrf
                    <div class="row was-validated">
                        <div class="col-md-12" data-toggle="tooltip" data-placement="bottom" title="Input kode divisi">
                            <div class="form-group">
                                <label>Kode</label>
                                <input type="text" class="form-control txt_line" placeholder="Input kode divisi" name="kode" id="kode" required>
                                <div class="valid-feedback">Terima kasih</div>
                                <div class="invalid-feedback">Input kode divisi</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="bottom" title="Input nama divisi">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control txt_line" placeholder="Input nama divisi" name="nama" id="nama" required>
                                <div class="valid-feedback">Terima kasih</div>
                                <div class="invalid-feedback">Input nama divisi</div>
                            </div>
                        </div>
                        <input type="hidden" class="form-control txt_line" name="createdBy" id="createdBy" value="{{ Auth::user()->name }}">
                        <div class="col-md-12">
                            <button type="submit" id="save" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="save">
                                <i class='far fa-check-square'></i>
                            </button>
                            <button type="button" id="cancel" class="btn" data-toggle="tooltip" data-placement="right" title="cancel">
                                <a href="{{ route('divisi') }}">
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