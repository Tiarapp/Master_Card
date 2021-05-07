@extends('admin.templates.partials.default')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

{{-- <style>
    #data_barang_filter.dataTables_filter label, #data_box_filter.dataTables_filter label, #data_substanceKontrak_filter.dataTables_filter label, #data_substanceProduksi_filter.dataTables_filter label {
        float: right;
    }
</style> --}}

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
                
                <form action="{{ route('mastercard.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12" style="border: 2px solid black;  margin-top:10px;">
                                <div class="form-group">
                                    <h4 class="form-section"> Data Master Item</h4>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Kode</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control txt_line" name="kode" id="kode" placeholder="Kode">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">No Item</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control txt_line" name="kodeBarang" id="kodeBarang" readonly>
                                                </div>
                                                <button type="button" class="col-md-1" data-toggle="modal" data-target="#Box" id>
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                        {{--  --}}
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Nama Item</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" name="namaBarang" id="namaBarang" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="border: 2px solid black;  margin-top:10px;">
                                <div class="form-group">
                                    <h4 class="form-section">Ukuran Box</h4>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Tipe Box</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <input type="hidden" name="box_id" id="box_id">
                                                    <input type="text" class="form-control txt_line" name="tipebox" id="tipebox" readonly>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="Box">
                                                <div class="modal-dialog modal-xl">
                                                    
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Box</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body Box">
                                                            <div class="card-body">
                                                                <table class="table table-bordered" id="data_box">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">ID.</th>
                                                                            <th scope="col">Kode</th>
                                                                            <th scope="col">Kode Barang</th>
                                                                            <th scope="col">Nama</th>
                                                                            <th scope="col">Tipe Box</th>
                                                                            <th scope="col">flute</th>
                                                                            <th scope="col">Panjang Dalam Box</th>
                                                                            <th scope="col">Lebar Dalam Box</th>
                                                                            <th scope="col">Tinggi Dalam Box</th>
                                                                            <th scope="col">Ukuran Creas Corr</th>
                                                                            <th scope="col">Ukuran Creas Conv</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        $no = 1;
                                                                        foreach ($box as $data) { ?>
                                                                            <tr>
                                                                                <td>{{ $data->id }}</td>
                                                                                <td>{{ $data->kode }}</td>
                                                                                <td>{{ $data->kodeBarang }}</td>
                                                                                <td>{{ $data->namaBarang }}</td>
                                                                                <td>{{ $data->tipebox }}</td>
                                                                                <td>{{ $data->flute }}</td>
                                                                                <td>{{ $data->lebarDalamBox }}</td>
                                                                                <td>{{ $data->panjangDalamBox }}</td>
                                                                                <td>{{ $data->tinggiDalamBox }}</td>
                                                                                <td>{{ $data->sizeCreasCorr }}</td>
                                                                                <td>{{ $data->sizeCreasConv }}</td>
                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Ukuran Sheet Box</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control txt_line" name="panjangSheetBox" id="panjangSheetBox" onchange="getLuasDC()">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control txt_line" name="lebarSheetBox" id="lebarSheetBox" onchange="getLuasDC()">
                                        </div>
                                        <div class="col-md-1">
                                            <label class="control-label">Out Conv</label>
                                        </div>
                                        <div class="col-md-1">
                                            <input type="number" class="form-control txt_line" name="outConv" id="outConv">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2" style="margin-top: 30px;">
                                            <label class="control-label">Ukuran Dalam Box</label> 
                                        </div>
                                        <div class="col-md-1">
                                            <span class="x">P</span>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control txt_line" name="panjangbox" id="panjangbox" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <span class="x">L</span>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control txt_line" name="lebarbox" id="lebarbox" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <span class="x">T</span>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control txt_line" name="tinggibox" id="tinggibox" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Luas Sheet Box</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" name="luasSheetBox" id="luasSheetBox" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Berat Sheet Box Kontrak</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="hidden" name="gramSheetBoxKontrak2" id="gramSheetBoxKontrak2">
                                            <input type="text" class="form-control txt_line" name="gramSheetBoxKontrak" id="gramSheetBoxKontrak" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Berat Sheet Box Produksi</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="hidden" name="gramSheetBoxProduksi2" id="gramSheetBoxProduksi2">
                                            <input type="text" class="form-control txt_line" name="gramSheetBoxProduksi" id="gramSheetBoxProduksi" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Creas Corr</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" name="creasCorr" id="creasCorr" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Creas Conv</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" name="creasConv" id="creasConv" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12" style="border: 2px solid black;  margin-top:10px;">
                                <div class="form-group">
                                    <h4 class="form-section">Ukuran Sheet</h4>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Flute</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" name="flute" id="flute" onchange="getSheet()"  readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2" style="margin-top: 30px;">
                                            <label class="control-label">Ukuran Sheet</label> 
                                        </div>
                                        <div class="col-md-2">
                                            <span class="x">P</span>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control txt_line" name="panjangSheet" id="panjangSheet" onchange="getLuasDC()">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="x">L</span>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control txt_line" name="lebarSheet" id="lebarSheet" onchange="getLuasDC()">
                                                </div>
                                                <div class="col-md-2">
                                                    MM
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Luas Sheet Corr</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" name="luasSheet" id="luasSheet" readonly>
                                        </div>
                                        <div class="col-md-2">
                                            M<sup>2</sup>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Berat Sheet Corr Kontrak</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="hidden" name="gramSheetCorrKontrak2" id="gramSheetCorrKontrak2">
                                            <input type="text" class="form-control txt_line" name="gramSheetCorrKontrak" id="gramSheetCorrKontrak" readonly>
                                        </div>
                                        <div class="col-md-2">
                                            Gram
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Berat Sheet Corr Produksi</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="hidden" name="gramSheetCorrProduksi2" id="gramSheetCorrProduksi2">
                                            <input type="text" class="form-control txt_line" name="gramSheetCorrProduksi" id="gramSheetCorrProduksi" readonly>
                                        </div>
                                        <div class="col-md-2">
                                            Gram
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>Susbtance Kontrak</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="hidden" class="form-control txt_line col-md-11" value="" id="substanceKontrak_id" name="substanceKontrak_id">
                                            <input type="hidden" class="form-control txt_line col-md-11" value="" id="Katas" readonly>
                                            <input type="hidden" class="form-control txt_line col-md-11" value="" id="Kbf" readonly>
                                            <input type="hidden" class="form-control txt_line col-md-11" value="" id="Ktengah" readonly>
                                            <input type="hidden" class="form-control txt_line col-md-11" value="" id="Kcf" readonly>
                                            <input type="hidden" class="form-control txt_line col-md-11" value="" id="Kbawah" readonly>
                                            <input type="text" class="form-control txt_line col-md-11" value="" id="subskontrak" onchange="getGramKontrak()" readonly>
                                            <!-- Modal -->
                                            <div class="modal fade" id="SubstanceKontrak">
                                                <div class="modal-dialog modal-xl">
                                                    
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Substance</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body SubstanceKontrak">
                                                            <div class="card-body">
                                                                <table class="table table-bordered" id="data_substanceKontrak">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">ID</th>
                                                                            <th scope="col">Kode</th>
                                                                            <th scope="col">Nama MC</th>
                                                                            <th scope="col">Nama Logistik</th>
                                                                            <th scope="col">Liner Atas</th>
                                                                            <th scope="col">BF</th>
                                                                            <th scope="col">Liner Tengah</th>
                                                                            <th scope="col">CF</th>
                                                                            <th scope="col">Liner Bawah</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                        foreach ($substance as $data) { ?>
                                                                            <tr>
                                                                                <td scope="row">{{ $data->id }}</td>
                                                                                <td>{{ $data->kode }}</td>
                                                                                <td>{{ $data->namaMc }}</td>
                                                                                <td>{{ $data->namaLog }}</td>
                                                                                <td>{{ $data->linerAtas }}</td>
                                                                                <td>{{ $data->bf }}</td>
                                                                                <td>{{ $data->linerTengah }}</td>
                                                                                <td>{{ $data->cf }}</td>
                                                                                <td>{{ $data->linerBawah }}</td>
                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Simpan</button>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" data-toggle="modal" data-target="#SubstanceKontrak">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>Susbtance Produksi</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="hidden" class="form-control txt_line col-md-11" value="" id="substanceProduksi_id" name="substanceProduksi_id">
                                            <input type="hidden" class="form-control txt_line col-md-11" value="" id="Patas" readonly>
                                            <input type="hidden" class="form-control txt_line col-md-11" value="" id="Pbf" readonly>
                                            <input type="hidden" class="form-control txt_line col-md-11" value="" id="Ptengah" readonly>
                                            <input type="hidden" class="form-control txt_line col-md-11" value="" id="Pcf" readonly>
                                            <input type="hidden" class="form-control txt_line col-md-11" value="" id="Pbawah" readonly>
                                            <input type="text" class="form-control txt_line col-md-11" value="" id="subsProduksi" readonly>
                                            <!-- Modal -->
                                            <div class="modal fade" id="SubstanceProduksi">
                                                <div class="modal-dialog modal-xl">
                                                    
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Substance</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body SubstanceProduksi">
                                                            <div class="card-body">
                                                                <table class="table table-bordered" id="data_substanceProduksi">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">ID</th>
                                                                            <th scope="col">Kode</th>
                                                                            <th scope="col">Nama MC</th>
                                                                            <th scope="col">Nama Logistik</th>
                                                                            <th scope="col">Liner Atas</th>
                                                                            <th scope="col">BF</th>
                                                                            <th scope="col">Liner Tengah</th>
                                                                            <th scope="col">CF</th>
                                                                            <th scope="col">Liner Bawah</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        $no = 1;
                                                                        foreach ($substance as $data) { ?>
                                                                            <tr>
                                                                                <td scope="row">{{ $data->id }}</td>
                                                                                <td>{{ $data->kode }}</td>
                                                                                <td>{{ $data->namaMc }}</td>
                                                                                <td>{{ $data->namaLog }}</td>
                                                                                <td>{{ $data->linerAtas }}</td>
                                                                                <td>{{ $data->bf }}</td>
                                                                                <td>{{ $data->linerTengah }}</td>
                                                                                <td>{{ $data->cf }}</td>
                                                                                <td>{{ $data->linerBawah }}</td>
                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Simpan</button>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" data-toggle="modal" data-target="#SubstanceProduksi">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="border: 2px solid black;  margin-top:10px;">
                                <div class="form-group">
                                    <h4 class="form-section">Deskripsi Detail</h4>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Tipe MC</label>
                                        </div>
                                        <div class="col-md-4">
                                            <select class="js-example-basic-single col-md-12" name="tipeMc" id="tipeMc">
                                                <option value='BOX'>BOX</option>
                                                <option value='BOX TUMBU'>BOX TUMBU</option>
                                                <option value='BOX TUTUP'>BOX TUTUP</option>
                                                <option value='LAYER'>LAYER</option>
                                                <option value='PARTISI'>PARTISI</option>
                                                <option value='SHEET'>SHEET</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Warna</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="hidden" name="colorCombine_id" id="colorCombine_id">
                                            <select class="js-example-basic-single col-md-12" name="warna" id="warna" onchange="getColor()">
                                                <option value=''>--</option>
                                                @foreach ($colorcombine as $data)
                                                <option value="{{ $data->id }}|{{ $data->nama }}">{{ $data->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Wax</label>
                                        </div>
                                        <div class="col-md-4">
                                            <select class="js-example-basic-single col-md-12" name="wax" id="wax">
                                                <option value='INSIDE'>INSIDE</option>
                                                <option value='OUTSIDE'>OUTSIDE</option>
                                                <option value='IN & OUT'>IN & OUT</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Joint</label>
                                        </div>
                                        <div class="col-md-4">
                                            <select class="js-example-basic-single col-md-12" name="joint" id="joint" >
                                                <option value=''>--</option>
                                                @foreach ($joint as $data)
                                                <option value="{{ $data->nama }}">{{ $data->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Packing</label>
                                        </div>
                                        <div class="col-md-4">
                                            <select class="js-example-basic-single col-md-12" name="koli" id="koli" >
                                                <option value=''>--</option>
                                                @foreach ($koli as $data)
                                                <option value="{{ $data->qtyBox }}">{{ $data->qtyBox }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        /Koli
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Bungkus</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" name="bungkus" id="bungkus">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Mesin</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" name="mesin" id="mesin">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Keterangan</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" name="keterangan" id="keterangan">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Gambar</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="file" name="gambar" id="gambar">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" class="form-control txt_line" name="createdBy" id="createdBy" value="{{ Auth::user()->name }}">
            <div class="col-md-12">
                <button type="submit" id="save" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Save">
                    <i class='far fa-check-square'></i>
                </button>
                <button type="button" id="cancel" class="btn" data-toggle="tooltip" data-placement="right" title="Cancel">
                    <a href="{{ route('mastercard') }}">
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
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
    // Datatable Barang(Item)
    $(".Item").ready(function(){
        
        var table = $("#data_barang").DataTable({
            select: true,
        });
        
        $('#data_barang tbody').on( 'click', 'td', function () {
            var item = (table.row(this).data());
            
            // document.getElementById('bj_id').value = item[0];
            document.getElementById('kodeBarang').value = item[0];
            document.getElementById('namaBarang').value = item[1];
        } );
        //  alert.row();
    } );
    
    //Datatable Box
    $(".Box").ready(function(){
        
        var table = $("#data_box").DataTable({
            // "scrollX": true,
            // "autoWidth": true, 
            "initComplete": function (settings, json) {  
                $("#data_box").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
            },
            // "scrollY": "400px",
            select: true,
        });
        
        $('#data_box tbody').on( 'click', 'td', function () {
            var Box = (table.row(this).data());
            
            document.getElementById('kodeBarang').value = Box[2];
            document.getElementById('namaBarang').value = Box[3];
            document.getElementById('tipebox').value = Box[4];
            document.getElementById('box_id').value = Box[0];
            document.getElementById('panjangbox').value = Box[6];
            document.getElementById('lebarbox').value = Box[7];
            document.getElementById('tinggibox').value = Box[8];
            document.getElementById('creasCorr').value = Box[9];
            document.getElementById('creasConv').value = Box[10];
            document.getElementById('flute').value = Box[5];
            
            if (Box[4] == 'B1') {
                var resultP = getID(Box[9]);
                var resultL = getID(Box[10]);
                document.getElementById("lebarSheet").value = parseInt(resultP);
                document.getElementById("panjangSheet").value = parseInt(resultL);

                document.getElementById("lebarSheetBox").value = parseInt(resultP);
                document.getElementById("panjangSheetBox").value = parseInt(resultL);
                
                var luas = (parseInt(resultP) * parseInt(resultL))/1000000;
                document.getElementById("luasSheet").value = luas.toFixed(3);
                document.getElementById("luasSheetBox").value = luas.toFixed(3);
            } else {

                document.getElementById("panjangSheet").value = null;
                document.getElementById("lebarSheet").value = null;
                document.getElementById("luasSheet").value = null;
                document.getElementById("panjangSheetBox").value = null;
                document.getElementById("lebarSheetBox").value = null;
                document.getElementById("luasSheetBox").value = null;
                document.getElementById("substanceKontrak").value = null;
                document.getElementById("substanceProduksi").value = null;
            }
        } );
        
        
        //  alert.row();
    } );
    
    function getID(a){
        var pos = a.indexOf('=');
        var panjang = a.length;
        var creas = a.substr(pos+1);
        
        return creas;
    }

    function getColorCombine(a){
        var pos = a.indexOf('|');
        var panjang = a.length;
        var id = a.substr(0,pos);
        
        return id;
    }


    function getColor(){
        var color = document.getElementById("warna").value;

        var combine = getColorCombine(color);

        document.getElementById("colorCombine_id").value = combine;
    }
    
    
    $(".SubstanceKontrak").ready(function(){
        
        var table = $("#data_substanceKontrak").DataTable({
            select: true,
        });
        
        $('#data_substanceKontrak tbody').on( 'click', 'td', function () {
            var SubstanceKontrak = (table.row(this).data());
            
            document.getElementById('Katas').value = SubstanceKontrak[4]    ;
            document.getElementById('Kbf').value = SubstanceKontrak[5];
            document.getElementById('Ktengah').value = SubstanceKontrak[6];
            document.getElementById('Kcf').value = SubstanceKontrak[7];
            document.getElementById('Kbawah').value = SubstanceKontrak[8];
            
            document.getElementById('substanceKontrak_id').value = SubstanceKontrak[0];
            document.getElementById('subskontrak').value = SubstanceKontrak[2];
            
            getGramKontrak();
        } );
    } );
    
    $(".SubstanceProduksi").ready(function(){
        
        var table = $("#data_substanceProduksi").DataTable({
            select: true,
        });
        
        $('#data_substanceProduksi tbody').on( 'click', 'td', function () {
            var SubstanceProduksi = (table.row(this).data());
            
            document.getElementById('Patas').value = SubstanceProduksi[4];
            document.getElementById('Pbf').value = SubstanceProduksi[5];
            document.getElementById('Ptengah').value = SubstanceProduksi[6];
            document.getElementById('Pcf').value = SubstanceProduksi[7];
            document.getElementById('Pbawah').value = SubstanceProduksi[8];
            
            document.getElementById('substanceProduksi_id').value = SubstanceProduksi[0];
            document.getElementById('subsProduksi').value = SubstanceProduksi[2];
            
            getGramProduksi();
        } );
    } );
    
    function getGramKontrak(){
        
        var flutenama = document.getElementById('flute').value;
        var Katas = parseInt(document.getElementById('Katas').value);
        var Kbf = parseFloat(document.getElementById('Kbf').value);
        var Ktengah = parseFloat(document.getElementById('Ktengah').value);
        var Kcf = parseFloat(document.getElementById('Kcf').value);
        var Kbawah = parseFloat(document.getElementById('Kbawah').value);
        var luasSheet = parseFloat(document.getElementById('luasSheet').value);
        var luasSheetBox = parseFloat(document.getElementById('luasSheetBox').value);
        
        var result;
        var result2;
        
        if (flutenama == 'BF') {
            if (isNaN(Katas)) {
                Katas = 0;
            } 
            if (isNaN(Kbf)) {
                Kbf = 0;
            }
            if (isNaN(Ktengah)) {
                Ktengah = 0;
            }
            if (isNaN(Kcf)) {
                Kcf = 0;
            }
            if (isNaN(Kbawah)) {
                Kbawah = 0 ;
            }
            
            // result = Kbf*1.36;
            result = (luasSheet * (Katas + (Kbf*1.36) + Ktengah + (Kcf*0) + Kbawah)/1000);
            result2 = (luasSheetBox * (Katas + (Kbf*1.36) + Ktengah + (Kcf*0) + Kbawah)/1000);
            
            document.getElementById('gramSheetCorrKontrak').value = result.toFixed(2);
            document.getElementById('gramSheetCorrKontrak2').value = result.toFixed(2);
            document.getElementById('gramSheetBoxKontrak').value = result2.toFixed(2);
            document.getElementById('gramSheetBoxKontrak2').value = result2.toFixed(2);
        } else
        if (flutenama == 'CF') {
            if (isNaN(Katas)) {
                Katas = 0;
            } 
            if (isNaN(Kbf)) {
                Kbf = 0;
            }
            if (isNaN(Ktengah)) {
                Ktengah = 0;
            }
            if (isNaN(Kcf)) {
                Kcf = 0;
            }
            if (isNaN(Kbawah)) {
                Kbawah = 0 ;
            }
            
            result = (luasSheet * (Katas + (Kcf*1.46) + Ktengah + (Kbf*0) + Kbawah))/1000;
            result2 = (luasSheetBox * (Katas + (Kcf*1.46) + Ktengah + (Kbf*0) + Kbawah))/1000;

            document.getElementById('gramSheetCorrKontrak').value = result.toFixed(3);
            document.getElementById('gramSheetCorrKontrak2').value = result.toFixed(2);
            document.getElementById('gramSheetBoxKontrak').value = result2.toFixed(3);
            document.getElementById('gramSheetBoxKontrak2').value = result2.toFixed(2);
            
        } else {
            result = (luasSheet * (Katas + (Kbf*1.36) + Ktengah + (Kcf*1.46) + Kbawah))/1000;
            result2 = (luasSheetBox * (Katas + (Kbf*1.36) + Ktengah + (Kcf*1.46) + Kbawah))/1000;

            document.getElementById('gramSheetCorrKontrak').value = result.toFixed(3);
            document.getElementById('gramSheetCorrKontrak2').value = result.toFixed(2);
            document.getElementById('gramSheetBoxKontrak').value = result2.toFixed(3);
            document.getElementById('gramSheetBoxKontrak2').value = result2.toFixed(2);
        }
        
        return result;
    }
    
    function getLuasDC(){
        $panjang = document.getElementById("panjangSheet").value;
        $lebar = document.getElementById("lebarSheet").value;
        $panjangbox = document.getElementById("panjangSheetBox").value;
        $lebarbox = document.getElementById("lebarSheetBox").value;

        $result = ($panjang * $lebar)/1000000;
        $result2 = ($panjangbox * $lebarbox)/1000000;

        document.getElementById('luasSheet').value = $result;
        document.getElementById('luasSheetBox').value = $result2;
    }

    function getGramProduksi(){
        
        var flutenama = document.getElementById('flute').value;
        var Patas = parseInt(document.getElementById('Patas').value);
        var Pbf = parseFloat(document.getElementById('Pbf').value);
        var Ptengah = parseFloat(document.getElementById('Ptengah').value);
        var Pcf = parseFloat(document.getElementById('Pcf').value);
        var Pbawah = parseFloat(document.getElementById('Pbawah').value);
        var luasSheet = parseFloat(document.getElementById('luasSheet').value);
        var luasSheetBox = parseFloat(document.getElementById('luasSheetBox').value);
        
        var result, result2;
        
        if (flutenama == 'BF') {
            if (isNaN(Patas)) {
                Patas = 0;
            } 
            if (isNaN(Pbf)) {
                Pbf = 0;
            }
            if (isNaN(Ptengah)) {
                Ptengah = 0;
            }
            if (isNaN(Pcf)) {
                Pcf = 0;
            }
            if (isNaN(Pbawah)) {
                Pbawah = 0 ;
            }
            
            result = (luasSheet * (Patas + (Pbf*1.36) + Ptengah + (Pcf*0) + Pbawah))/1000;
            result2 = (luasSheetBox * (Patas + (Pbf*1.36) + Ptengah + (Pcf*0) + Pbawah))/1000;
            
            document.getElementById('gramSheetCorrProduksi').value = result.toFixed(3);
            document.getElementById('gramSheetBoxProduksi').value = result2.toFixed(3);
            document.getElementById('gramSheetCorrProduksi2').value = result.toFixed(2);
            document.getElementById('gramSheetBoxProduksi2').value = result2.toFixed(2);
        } else
        if (flutenama == 'CF') {
            if (isNaN(Patas)) {
                Patas = 0;
            } 
            if (isNaN(Pbf)) {
                Pbf = 0;
            }
            if (isNaN(Ptengah)) {
                Ptengah = 0;
            }
            if (isNaN(Pcf)) {
                Pcf = 0;
            }
            if (isNaN(Pbawah)) {
                Pbawah = 0 ;
            }
            
            result = (luasSheet * (Patas + (Pbf*0) + Ptengah + (Pcf*1.46) + Pbawah))/1000;
            result2 = (luasSheetBox * (Patas + (Pbf*1.36) + Ptengah + (Pcf*0) + Pbawah))/1000;

            document.getElementById('gramSheetCorrProduksi').value = result.toFixed(3);
            document.getElementById('gramSheetBoxProduksi').value = result2.toFixed(3);
            document.getElementById('gramSheetCorrProduksi2').value = result.toFixed(2);
            document.getElementById('gramSheetBoxProduksi2').value = result2.toFixed(2);
            
        } else {
            result = (luasSheet * (Patas + (Pbf*1.36) + Ptengah + (Pcf*1.46) + Pbawah))/1000;
            result2 = (luasSheetBox * (Patas + (Pbf*1.36) + Ptengah + (Pcf*0) + Pbawah))/1000;

            document.getElementById('gramSheetCorrProduksi').value = result.toFixed(3);
            document.getElementById('gramSheetBoxProduksi').value = result2.toFixed(3);
            document.getElementById('gramSheetCorrProduksi2').value = result.toFixed(2);
            document.getElementById('gramSheetBoxProduksi2').value = result2.toFixed(2);
        }
    }
    
    
</script>