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
                
                <form action="{{ route('hasil_produksi') }}"  method="POST">
                @csrf
                <div class="row" style="margin-bottom: 10px;">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label>OPI</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control txt_line" name="idurl" id="idurl" value="{{ $corr->plan_corr_m_id }}" readonly>
                                        <input type="hidden" class="form-control txt_line" name="plan_id" id="plan_id" value="{{ $corr->id }}" readonly>
                                        <input type="hidden" class="form-control txt_line" name="opi_id" id="opi_id" value="{{ $corr->opi_id }}" readonly>
                                        {{-- <input type="hidden" class="form-control txt_line" name="plandid" id="plandid" value="{{ $corrd->corrdid }}" readonly> --}}
                                        <input type="text" class="form-control txt_line" name="namaBarang" id="namaBarang" value="{{ $corr->barang }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label>Customer</label>
                                    </div>
                                    <div class="col-md-10">
                                        {{-- <input type="hidden" class="form-control txt_line" value="{{ $corrd->opi_id }}" name="opi_id" id="opi_id" readonly> --}}
                                        <input type="text" class="form-control txt_line" value="{{ $corr->customer }}" name="Cust" id="Cust" readonly>
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
                                        <label>Tanggal Kirim</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="date" class="form-control txt_line" value="{{ $corr->tglkirim }}" name="tanggal" id="tanggal" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Qty Plan</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control txt_line" value="{{ $corr->qtyOrder }}" name="plan" id="plan" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>No OPI</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control txt_line" value="{{ $corr->opikode }}" name="nama_opi" id="nama_opi" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Berat</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control txt_line" value="{{ $corr->gramSheet }}" name="berat" id="berat" readonly>
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
                                        <label>Mesin</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control txt_line" value="{{ $mesin }}" readonly>
                                    </div>
                                </div>
                            </div>
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
                            {{-- <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Out</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control txt_line" name="out_corr" id="out_corr" value="{{ $corrd->out_corr }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class='col-md-4'>
                                        <label>P x L</label>
                                    </div>
                                    <div class='col-md-8'>
                                        <div class='row'>
                                            <div class='col-md-5'>
                                                <input type='text' class='form-control txt_line' name='sheetp' id='sheetp' value="{{ $corrd->sheet_p }}" readonly>
                                            </div>
                                            <div class='col-md-2'>
                                                <label for=''>X</label>
                                            </div>
                                            <div class='col-md-5'>
                                                <input type='text' class='form-control txt_line' name='sheetl' id='sheetl' value="{{ $corrd->sheet_l }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
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
                                        <input type="number" class="form-control txt_line" name="baik" id="baik" onchange="getSisa()">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Hasil Jelek</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control txt_line" name="jelek" id="jelek" onchange="getSisa()">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Jumlah Palet</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control txt_line" name="palet" id="palet" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Downtime</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="number" class="form-control txt_line" name="downtime" id="downtime" > 
                                    </div>
                                    <div class="col-md-2">
                                        Menit
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
                                        <label>Tonase Hasil Baik</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="tonase_baik" id="tonase_baik">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Tonase Hasil Jelek</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="tonase_jelek" id="tonase_jelek">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label>Keterangan</label>
                                    </div>
                                    <div class="col-md-8">
                                        <textarea name="keterangan" id="keterangan" cols="50" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-md-3">
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
                            </div> --}}
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
        gram = document.getElementById('berat').value;
        baik = document.getElementById('baik').value;
        jelek = document.getElementById('jelek').value;

        gramBaik = gram*baik;
        gramJelek = gram*jelek;


        console.log(gramBaik);
        console.log(gramJelek);
        document.getElementById('tonase_baik').value = gramBaik;
        document.getElementById('tonase_jelek').value = gramJelek;

    }
</script>
@endsection