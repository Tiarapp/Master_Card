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
                <h4 class="modal-title">Buat Master Card</h4>
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
                
                <form action="#" method="POST">
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="control-label">No. MasterCard</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control txt_line" name="kode" id="kode" placeholder="No. MasterCard">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Kode</label>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="js-example-basic-single col-md-12">
                                                @foreach ($item as $item)
                                                <option value="{{ $item->KodeBrg }}">{{ $item->KodeBrg }} || {{ $item->NamaBrg }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>BOX</label>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="js-example-basic-single col-md-12">
                                                @foreach ($boxes as $box)
                                                <option value="">{{ $box->id }} || {{ $box->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Substance Sheet</label>
                                    </div>
                                    <div class="col-md-6">
                                        <select class="js-example-basic-single col-md-12">
                                            @foreach ($substance_sheet as $sub)
                                            <option value="">{{ $sub->id }} || {{ $sub->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    });
</script>