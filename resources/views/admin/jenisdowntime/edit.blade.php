@extends('admin.templates.partials.default')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row" id="form_list_mc">
            <div class="col-md-5">
                <h4 class="modal-title"><strong>Edit Jenis Downtime</strong> </h4>
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
                
                <form action="../update/{{ $JenisDowntime->id }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Mesin</label>
                                {{-- <div class="row"> --}}
                                    {{-- <input type="text" class="form-control txt_line col-md-2" name="kode" id="kode" value="STN" readonly> --}}
                                    <select class="js-example-basic-single col-md-12" name="mesinId" id="mesinId" onchange="update_crease_corr()">
                                        <option value="">Pilih Mesin ..</option>
                                        @foreach ($mesin as $data)
                                        <option value="{{ $data->kode }}">{{ $data->kode }}</option>
                                        @endforeach
                                    </select>
                                    {{-- </div> --}}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                <label>Downtime</label>
                                <input type="text" class="form-control txt_line" name="downtime" id="downtime" value="{{ $JenisDowntime->nama }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>PIC</label>
                                <input type="text" class="form-control txt_line" name="pic" id="pic" value="{{ $JenisDowntime->category }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Downtime yang diperbolehkan (menit)</label>
                                <input type="text" class="form-control txt_line" name="allowedMinute" id="allowedMinute" value="{{ $JenisDowntime->allowedMinute }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Branch</label>
                                <input type="text" class="form-control txt_line" name="branch" id="branch" value="{{ $JenisDowntime->branch }}">
                            </div>
                        </div>
                        <input type="hidden" class="form-control txt_line" name="lastUpdatedBy" id="lastUpdatedBy" value="{{ Auth::user()->name }}">
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