@extends('admin.templates.partials.default')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<style>
    .row {
        margin-bottom: 10px;
    }
</style>

@section('content')
<div class="content-wrapper" style="height: auto !important">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row" id="form_list_mc">
            <div class="col-md-12">
                <h4 class="modal-title">Print Master Card</h4>
                <hr>
                
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Error!</strong> 
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if ($message = Session::get('danger'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                      </button>
                      <strong>{{ $message }}</strong>
                    </div>
                  @endif
                
                <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12" style="margin-top:10px;">
                                <div class="form-group">
                                    <h4 class="form-section"> Data Master Item</h4>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="control-label">Nama Item</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <input type="text" class="form-control txt_line" name="namaBarang" id="namaBarang" onchange="getKodeBarang()" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="control-label">Kode Box</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control txt_line" name="kodeBarang" id="kodeBarang" placeholder="Kode Barang" readonly>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="control-label">Tujuan</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <select class="js-example-basic-single col-md-12" name="tujuan" id="tujuan" onchange="getKodeBarang()">
                                                        <option value='L'>LOKAL</option>
                                                        <option value='E'>EXPORT</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="control-label">Eceran</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <select class="js-example-basic-single col-md-12" name="ecer" id="ecer" onchange="getKodeBarang()">
                                                        <option value='E'>Ya</option>
                                                        <option value='E'>Tidak</option>
                                                    </select>
                                                </div>         
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="control-label">Jenis Produksi</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <select class="js-example-basic-single col-md-12" name="tipebox" id="tipebox" onchange="getKodeBarang()">
                                                        @foreach ($box as $item)
                                                            <option value={{ $item->Kode }}>{{ $item->Nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="control-label">Jenis Box</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <select class="js-example-basic-single col-md-12" name="flute" id="flute" onchange="getKodeBarang()">
                                                        @foreach ($merk as $item)
                                                            <option value={{ $item->Kode }}>{{ $item->Merk }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="control-label">Design</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control txt_line" name="design" id="design" value="01" readonly>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="control-label">Weight / Sheet</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <select class="js-example-basic-single col-md-12" name="weight" id="weight" onchange="getKodeBarang()">
                                                        <option value='S'>Sheet</option>
                                                        <option value='W'>Weight</option>
                                                    </select>
                                                </div>         
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="control-label">Packing</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <select class="js-example-basic-single col-md-12" name="koli" id="koli" onchange="getKodeBarang();" >
                                                        <option value='00'>Tidak Ada</option>
                                                        <option value='05'>05 Koli</option>
                                                        <option value='10'>10 Koli</option>
                                                        <option value='20'>20 Koli</option>
                                                        <option value='25'>25 Koli</option>
                                                        <option value='50'>50 Koli</option>
                                                        <option value='60'>60 Koli</option>
                                                        <option value='00'>100 Koli</option>
                                                    </select>
                                                </div>
                                                /Koli
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="control-label">Value</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control txt_line" name="mcnumb" id="mcnumb" onchange="getKodeBarang()" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="control-label">Warna</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <select class="js-example-basic-single col-md-12" name="rev" id="rev" onchange="getKodeBarang()">
                                                        @foreach ($warna as $item)
                                                            <option value={{ $item->Kode }}>{{ $item->Warna }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="control-label">Golongan Customer</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <select class="js-example-basic-single col-md-12" name="golongan" id="golongan" onchange="getKodeBarang()">
                                                        <option value='001'>Food and Baverage</option>
                                                        <option value='002'>Keramik</option>
                                                        <option value='003'>Frozen Fish</option>
                                                        <option value='004'>Oil</option>
                                                        <option value='005'>Plastik</option>
                                                        <option value='006'>DOC</option>
                                                        <option value='007'>Tissue</option>
                                                        <option value='999'>Others</option>
                                                        <option value='OOO'>Sheet</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="control-label">Satuan</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <select class="js-example-basic-single col-md-12" name="satuan" id="satuan">
                                                        <option value='PCS'>PCS</option>
                                                        <option value='SET'>SET</option>
                                                        <option value='ROLL'>ROLL</option>
                                                        <option value='BDL'>BUNDEL</option>
                                                        <option value='CRT'>CRT</option>
                                                        <option value='SACK'>SACK</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="control-label">Isi Perkarton</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control txt_line" name="isi" id="isi" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="control-label">Berat Standart</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control txt_line" name="berat" id="berat" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="control-label">Berat Per-CRT</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control txt_line" name="beratcrt" id="beratcrt" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="control-label">Harga Jual</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="number" class="form-control txt_line" name="hargajual" id="hargajual">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="control-label">Harga USD</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="number" class="form-control txt_line" name="hargausd" id="hargausd">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
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

    function getKodeBarang() {
        var tujuan = document.getElementById("tujuan").value;
        var ecer = document.getElementById("ecer").value;
        var tipebox = document.getElementById("tipebox").value;
        var flute = document.getElementById("flute").value;
        var golongan = document.getElementById("golongan").value;
        var design = document.getElementById("design").value;
        var weight = document.getElementById("weight").value;
        var koli = document.getElementById("koli").value;
        var mcnumb = document.getElementById("mcnumb").value;
        var rev = document.getElementById("rev").value;

        kodebarang = tujuan+tipebox+ecer+"."+flute+"."+design+"."+weight+koli+"."+mcnumb+rev+"."+golongan;

        document.getElementById("kodeBarang").value = kodebarang;
        document.getElementById("hargajual").value = 0;
        document.getElementById("hargausd").value = 0;
    }
    
    
</script>