@extends('admin.templates.partials.default')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row" id="form_list_mc">
            <div class="col-md-5">
                <h4 class="modal-title"><strong>Show Jenis Downtime</strong> </h4>
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
                
                <form>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Mesin</label>
                                {{-- <div class="row"> --}}
                                {{-- <input type="text" class="form-control txt_line col-md-2" name="kode" id="kode" value="STN" readonly> --}}
                                <input type="text" class="form-control txt_line" name="mesin" id="mesin" value="{{ $jenisdowntime->mesin }}" readonly>
                                {{-- </div> --}}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Downtime</label>
                                <input type="text" class="form-control txt_line" name="downtime" id="downtime" value="{{ $jenisdowntime->downtime }}"readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Category</label>
                                <input type="text" class="form-control txt_line" name="category" id="category" value="{{ $jenisdowntime->category }}"readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Downtime yang diperbolehkan (menit)</label>
                                <input type="text" class="form-control txt_line" name="allowedMinute" id="allowedMinute" value="{{ $jenisdowntime->allowedMinute }}"readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Branch</label>
                                <input type="text" class="form-control txt_line" name="branch" id="branch" value="{{ $jenisdowntime->branch }}"readonly>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <button type="submit" class="btn btn-primary">Back</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection