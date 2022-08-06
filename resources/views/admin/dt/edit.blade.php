@extends('admin.templates.partials.default')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row" id="form_list_mc">
            <div class="col-md-5">
                <h4 class="modal-title"><strong>Edit Delivery Time</strong> </h4>
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

                <form action="../update/{{ $dt->id }}" method="POST">
                {{-- <form action="{{ route() }}" method="POST"> --}}
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Kode Kontrak</label>
                                {{-- <div class="row"> --}}
                                {{-- <input type="text" class="form-control txt_line col-md-2" name="kode" id="kode" value="STN" readonly> --}}
                                <input type="text" class="form-control txt_line" name="kontrak" id="kontrak" value="{{ $dt->kodeKontrak }}" readonly>
                                {{-- </div> --}}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Tanggal Kirim</label>
                                <?php 
                                    if ($dt->dt_perubahan == '') {
                                        $tgl = $dt->tglKirimDt;
                                    } else {
                                        $tgl = $dt->dt_perubahan;
                                    }
                                ?>
                                <input type="date" class="form-control txt_line" name="tglKirimDt" id="tglKirimDt" value="{{ $tgl }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>DT Perubahan</label>
                                <input type="date" class="form-control txt_line" name="dt_perubahan" id="dt_perubahan" value="{{ $dt->dt_perubahan }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>QTY</label>
                                <input type="text" class="form-control txt_line" name="pcsDt" id="pcsDt" value="{{ $dt->pcsDt }}">
                            </div>
                        </div>
                        <input type="hidden" class="form-control txt_line" name="lastUpdatedBy" id="lastUpdatedBy" value="{{ Auth::user()->name }}">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <button type="submit" id="save" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="save">
                                <i class='far fa-check-square'></i>
                            </button>
                            <button type="button" id="cancel" class="btn" data-toggle="tooltip" data-placement="right" title="cancel">
                                <a href="{{ route('dt') }}"> <i class='far fa-window-close' style='color:red'></i></a>
                            </button>

                        </div>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection