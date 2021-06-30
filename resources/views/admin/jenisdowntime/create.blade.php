@extends('admin.templates.partials.default')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row" id="form_list_mc">
            <div class="col-md-5">
                <h4 class="modal-title">Tambah Jenis Downtime</h4>
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

                
                
                <form action="{{ route('downtime.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Mesin</label>
                                {{-- <div class="row"> --}}
                                    {{-- <input type="text" class="form-control txt_line col-md-2" name="kode" id="kode" value="STN" readonly> --}}
                                    <input type="text" class="form-control txt_line" name="mesin_id" id="mesin_id" autocomplete="off">
                                    {{-- </div> --}}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Downtime</label>
                                    <input type="text" class="form-control txt_line" name="downtime" id="downtime">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Category</label>
                                    <input type="text" class="form-control txt_line" name="category" id="category">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Menit yang diperbolehkan</label>
                                    <input type="text" class="form-control txt_line" name="allowedMinute" id="allowedMinute">
                                </div>
                            </div>
                            <div class="col-md-12">
                            <div class="form-group">
                                <label>Branch</label>
                                <input type="text" class="form-control txt_line" name="branch" id="branch">
                            </div>
                        </div>
                        <input type="hidden" class="form-control txt_line" name="createdBy" id="createdBy" value="{{ Auth::user()->name }}">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>    
</div>

@endsection