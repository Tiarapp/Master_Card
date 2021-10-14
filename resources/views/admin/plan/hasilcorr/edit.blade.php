@extends('admin.templates.partials.default')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

{{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> --}}

<style>
    .select2 {
        width: 206px !important;
    }

    /* .content-wrapper {
        height: 0px;
    } */
</style>


@section('content')
<div class="content-wrapper" style="height: autopx !important">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row" id="form_list_mc">
            <div class="col-md-12">
                <h4 class="modal-title">Planning Corrugating</h4>
                <hr>
                
                @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Error!</strong> 
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $errors }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                <form action="../update/{{ $corrd->corrdid }}"  method="POST">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                    @csrf
                <div class="row" style="margin-bottom: 10px;">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Kode Planning</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="hidden" class="form-control txt_line" name="planmid" id="planmid" value="{{ $corrd->corrmid }}" readonly>
                                        <input type="hidden" class="form-control txt_line" name="plandid" id="plandid" value="{{ $corrd->corrdid }}" readonly>
                                        <input type="text" class="form-control txt_line" name="kodeplan" id="kodeplan" value="{{ $corrd->kodeplanM }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Tanggal</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="date" class="form-control txt_line" value="{{ $corrd->tglcorr }}" name="tglcorr" id="tglcorr" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>OPI</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control txt_line" value="{{ $corrd->opikode }}" name="noopi" id="noopi" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Qty Plan</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control txt_line" value="{{ $corrd->sisa }}" name="plan" id="plan" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="row" style="margin-bottom: 10px;">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Start</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="datetime-local" class="form-control txt_line" name="start" id="start" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>End</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="datetime-local" class="form-control txt_line" name="end" id="end" onfocusout="diffTime();">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Durasi</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control txt_line" name="durasi" id="durasi">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="row" style="margin-bottom: 10px;">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Hasil Baik</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control txt_line" name="baik" id="baik" onchange="getSisa()">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Hasil Jelek</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control txt_line" name="jelek" id="jelek" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Jumlah Palet</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control txt_line" name="jml_palet" id="jml_palet" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Sisa</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control txt_line" name="sisa" id="sisa" >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 10px;">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Produksi Meter</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control txt_line" name="prod_meter" id="prod_meter">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>M2</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control txt_line" name="meter_persegi" id="meter_persegi">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Status Corr</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="js-example-basic-single col-md-12" name="status" id="status">
                                            <option value='Proses'>Proses</option>
                                            <option value='Belum Selesai'>Belum Selesai</option>
                                            <option value='Selesai'>Selesai</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Mesin Selanjutnya</label>
                                            </div>
                                            <div class="col-md-8">
                                                <select class="js-example-basic-single col-md-12" name="mesin" id="mesin">
                                                    <option value='Flexo A'>Flexo A</option>
                                                    <option value='Flexo B'>Flexo B</option>
                                                    <option value='Flexo C'>Flexo C</option>
                                                    <option value='Stiching'>Stiching</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-lg btn-primary" type="submit">SIMPAN
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

    function diffTime() {
        start = Date.parse(document.getElementById("start").value);
        end = Date.parse(document.getElementById("end").value);

        hasil = end - start;

        hari = Math.floor(hasil / (24*60*60*1000));
        diffjam = Math.floor(hasil -(hari*(24*3600*1000)));
        jam = Math.floor(diffjam /(3600*1000));
        diffmenit =(diffjam - (jam*3600*1000));
        menit = Math.floor(diffmenit / (60*1000));

        console.log(hasil,hari,diffjam,jam,diffmenit,menit);

        if (jam <= 9) {
            jam = "0"+jam;
        }
        if (menit <= 9) {
            menit = "0"+menit;
        }

        if (hari != 0) {
            document.getElementById("durasi").value = hari+" hari "+jam+" jam "+menit+" menit";
        } else if (jam != 0) {
            document.getElementById("durasi").value = jam+" jam "+menit+" menit";
        } else if (jam == 0) {
            document.getElementById("durasi").value = menit+" menit";
        }
    }

    function getSisa() {
        plan = document.getElementById("plan").value;
        hasilbaik = document.getElementById("baik").value;
        // hasiljelek = document.getElementById("jelek").value;

        sisa = plan - hasilbaik ;

        document.getElementById("sisa").value = sisa;
    }
</script>
@endsection