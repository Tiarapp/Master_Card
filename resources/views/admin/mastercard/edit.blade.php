@extends('admin.templates.partials.default')

<!-- Load jQuery first before any other scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css" />

<!-- DataTables and other scripts after jQuery -->
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>

<!-- Select2 after jQuery -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
// jQuery conflict resolution and validation
(function() {
    // Ensure jQuery is available
    if (typeof jQuery === 'undefined') {
        console.error('jQuery is not available!');
        return;
    }
    
    // Create a safe reference to jQuery
    var $safe = jQuery.noConflict(true);
    
    // Make it available globally as $ and jQuery
    window.$ = window.jQuery = $safe;
    
    console.log('jQuery loaded successfully:', $safe.fn.jquery);
})();
</script>

<style>
/* Custom Select2 Styling */
.select2-container--bootstrap4 .select2-selection--single {
    height: calc(2.25rem + 2px) !important;
    border: 1px solid #ced4da !important;
    border-radius: 0.25rem !important;
    padding: 0.375rem 0.75rem !important;
}

.select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
    color: #495057 !important;
    line-height: 1.5 !important;
    padding-left: 0 !important;
    padding-right: 20px !important;
}

.select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow {
    height: calc(2.25rem + 2px) !important;
}

.select2-container--bootstrap4 .select2-dropdown {
    border: 1px solid #ced4da !important;
    border-radius: 0.25rem !important;
}

.select2-container {
    width: 100% !important;
}

/* Focus states */
.select2-container--bootstrap4.select2-container--focus .select2-selection--single {
    border-color: #80bdff !important;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
}

/* Search box styling */
.select2-search--dropdown {
    padding: 8px !important;
}

.select2-search--dropdown .select2-search__field {
    width: 100% !important;
    border: 1px solid #ced4da !important;
    border-radius: 0.25rem !important;
    padding: 0.375rem 0.75rem !important;
    font-size: 14px !important;
}

.select2-search--dropdown .select2-search__field:focus {
    border-color: #80bdff !important;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
    outline: none !important;
}

/* Results styling */
.select2-results__option {
    padding: 8px 12px !important;
    font-size: 14px !important;
}

.select2-results__option--highlighted {
    background-color: #007bff !important;
    color: white !important;
}

/* Ensure dropdown is visible */
.select2-dropdown {
    z-index: 9999 !important;
}

/* Force search box to always show */
.select2-search--dropdown {
    display: block !important;
}
</style>

@section('content')
<div class="content-wrapper" style="height: auto !important">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row" id="form_list_mc">
            <div class="col-md-12">
                <h4 class="modal-title">Edit Master Card</h4>
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
                
                <form action="{{ route('mastercard.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12" style="border: 2px solid black;  margin-top:10px;">
                                <div class="form-group">
                                    <h4 class="form-section"> Data Master Item</h4>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Kode Box</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control txt_line" name="kodeBarang" id="kodeBarang" value="{{ $mc->kodeBarang }}" placeholder="Kode Barang">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Golongan Customer</label>
                                        </div>
                                        <div class="col-md-4">
                                            <select class="js-example-basic-single col-md-12" name="golongan" id="golongan" onchange="getKodeBarang()">
                                                <option value={{ $mc->tipeCust }}>{{ $tipe }}</option>
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
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <label>Pilih Customer</label>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input type="text" class="form-control txt_line col-md-11" name="customer" id="customer" value="{{ $mc->customer }}" onchange="getGramKontrak()" readonly>
                                                    </div>
                                                    
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="List-Customer">
                                                        <div class="modal-dialog modal-xl">
                                                            
                                                            <!-- Modal content-->
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">List Customer</h4>
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>
                                                                <div class="modal-body customer">
                                                                    <div class="card-body">
                                                                        <table class="table table-bordered" id="data_customer">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th scope="col">Kode</th>
                                                                                    <th scope="col">Nama Customer</th>
                                                                                    <th scope="col">Alamat Kantor</th>
                                                                                    <th scope="col">Telp</th>
                                                                                    <th scope="col">Fax</th>
                                                                                    <th scope="col">Alamat Kirim</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php 
                                                                                foreach ($cust as $data) { ?>
                                                                                    <tr>
                                                                                        <td scope="row">{{ $data->Kode }}</td>
                                                                                        <td>{{ $data->Nama }}</td>
                                                                                        <td>{{ $data->AlamatKantor }}</td>
                                                                                        <td>{{ $data->TelpKantor }}</td>
                                                                                        <td>{{ $data->FaxKantor }}</td>
                                                                                        <td>{{ $data->AlamatKirim }}</td>
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
                                                    <button type="button" data-toggle="modal" data-target="#List-Customer">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Kode</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control txt_line" name="kode" id="kode" value="{{ $mc->kode }}" placeholder="Kode" onchange="getKodeBarang()">
                                        </div>
                                        <div class="col-md-1">
                                            <label class="control-label">Revisi</label>
                                        </div>
                                        <div class="col-md-1">
                                            <input type="text" class="form-control txt_line" name="revisi" id="revisi" value="{{ $revisi }}" placeholder="Kode">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Nama Item</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control txt_line" name="namaBarang" id="namaBarang" value="{{ $mc->namaBarang }}">
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
                                            <label class="control-label">Tujuan</label>
                                        </div>
                                        <div class="col-md-4">
                                            <select class="js-example-basic-single col-md-12" name="tujuan" id="tujuan" onchange="getKodeBarang();">
                                                <option value='L'>LOKAL</option>
                                                <option value='E'>EXPORT</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Double Joint</label>
                                        </div>
                                        <div class="col-md-4">
                                            <select class="js-example-basic-single col-md-12" name="doublejoint" id="doublejoint">
                                                <option value='{{ $mc->doubleJoint }}'>{{ $mc->doubleJoint }}</option>
                                                <option value='Tidak'>Tidak</option>
                                                <option value='Ya'>Ya</option>
                                            </select>
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
                                                    <input type="hidden" name="box_id" id="box_id" value="{{ $mc->box_id }}">
                                                    <input type="text" class="form-control txt_line" value="{{ $mc->tipeBox }}" name="tipebox" id="tipebox" onchange="getKodeBarang();">
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
                                                                            <th scope="col">Nama</th>
                                                                            <th scope="col">Tipe Box</th>
                                                                            <th scope="col">flute</th>
                                                                            <th scope="col">Panjang Dalam Box</th>
                                                                            <th scope="col">Lebar Dalam Box</th>
                                                                            <th scope="col">Tinggi Dalam Box</th>
                                                                            <th scope="col">Ukuran Creas Corr</th>
                                                                            <th scope="col">Ukuran Creas Conv</th>
                                                                            <th scope="col">Creasing</th>
                                                                        </tr>
                                                                    </thead>
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
                                            <input type="text" class="form-control txt_line" value="{{ $mc->panjangSheetBox }}" name="panjangSheetBox" id="panjangSheetBox" onchange="getLuasDC();getKodeBarang();">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control txt_line" value="{{ $mc->lebarSheetBox }}" name="lebarSheetBox" id="lebarSheetBox" onchange="getLuasDC();getKodeBarang();">
                                        </div>
                                        <div class="col-md-1">
                                            <label class="control-label">Gram Kualitas</label>
                                        </div>
                                        <div class="col-md-1">
                                            <input type="text" class="form-control txt_line" value="{{ $mc->brt_kualitas }}" name="gram_kualitas" id="gram_kualitas" onchange="getKodeBarang();">
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
                                                    <input type="text" class="form-control txt_line" value="{{ $mc->panjangDalam }}" name="panjangbox" id="panjangbox" onchange="getKodeBarang();">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <span class="x">L</span>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control txt_line" name="lebarbox" id="lebarbox"  value="{{ $mc->lebarDalam }}" onchange="getKodeBarang();">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <span class="x">T</span>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control txt_line" value="{{ $mc->tinggiDalam }}" name="tinggibox" id="tinggibox" onchange="getKodeBarang();">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Luas Sheet Box</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" value="{{ $mc->luasSheetBox }}" name="luasSheetBox" id="luasSheetBox" onchange="getKodeBarang();">
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Luas Sheet Box Prod</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" name="luasSheetBoxProd" id="luasSheetBoxProd" value="{{ $mc->luasSheetBoxProd }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Berat Sheet Box Kontrak</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="hidden" value="{{ $mc->gramSheetBoxKontrak2 }}" name="gramSheetBoxKontrak2" id="gramSheetBoxKontrak2">
                                            <input type="text" class="form-control txt_line" value="{{ $mc->gramSheetBoxKontrak2 }}"  name="gramSheetBoxKontrak" id="gramSheetBoxKontrak" onchange="getKodeBarang();">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Berat Sheet Box Produksi</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="hidden" value="{{ $mc->gramSheetBoxProduksi2 }}"  name="gramSheetBoxProduksi2" id="gramSheetBoxProduksi2">
                                            <input type="text" class="form-control txt_line" value="{{ $mc->gramSheetBoxProduksi }}"  name="gramSheetBoxProduksi" id="gramSheetBoxProduksi" onchange="getKodeBarang();">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Creas Corr</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" value="{{ $mc->CreasCorrP }}"  name="creasCorr" id="creasCorr" onchange="getKodeBarang();">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Creas Conv</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" value="{{ $mc->CreasCorrL }}"  name="creasConv" id="creasConv" onchange="getKodeBarang();">
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
                                            <input type="text" class="form-control txt_line" value="{{ $mc->flute }}"  name="flute" id="flute" onchange="getSheet();getKodeBarang();" >
                                        </div>
                                        <div class="col-md-1">
                                            <label class="control-label">Out Conv</label>
                                        </div>
                                        <div class="col-md-1">
                                            <input type="number" class="form-control txt_line" value="{{ $mc->outConv }}" name="outConv" id="outConv" onchange="getKodeBarang();">
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
                                                    <input type="text" class="form-control txt_line" value="{{ $mc->panjangSheet }}"  name="panjangSheet" id="panjangSheet" onchange="getLuasDC(); getKodeBarang();">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="x">L</span>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control txt_line" value="{{ $mc->lebarSheet }}"  name="lebarSheet" id="lebarSheet" onchange="getLuasDC(); getKodeBarang();">
                                                </div>
                                                <div class="col-md-2">
                                                    MM
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row berat-roll">
                                            <div class="col-md-2">
                                                <label class="control-label">Berat Roll</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control txt_line qty-roll" name="berat_roll" id="berat_roll">
                                            </div>
                                        </div>
                                        <div class="row text">
                                            <div class="col-md-2">
                                                <label class="control-label">Text</label>
                                            </div>
                                            <div class="col-md-4">
                                                <select class="js-example-basic-single col-md-12" name="text_block" id="text_block">
                                                    <option value='{{ $mc->text }}'>{{ $mc->text }}</option>
                                                    <option value='Non Block'>Non Block</option>
                                                    <option value='Block'>Block</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Luas Sheet Corr</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line"  value="{{ $mc->luasSheet }}" name="luasSheet" id="luasSheet" onchange="getKodeBarang();">
                                        </div>
                                        <div class="col-md-2">
                                            M<sup>2</sup>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Luas Sheet Corr Prod</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" name="luasSheetProd" id="luasSheetProd" value="{{ $mc->luasSheetProd }}" readonly>
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
                                            <input type="hidden" value="{{ $mc->gramSheetCorrKontrak2 }}"  name="gramSheetCorrKontrak2" id="gramSheetCorrKontrak2">
                                            <input type="text" class="form-control txt_line" value="{{ $mc->gramSheetCorrKontrak2 }}"  name="gramSheetCorrKontrak" id="gramSheetCorrKontrak" onchange="getKodeBarang();">
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
                                            <input type="hidden" value="{{ $mc->gramSheetCorrProduksi2 }}"  name="gramSheetCorrProduksi2" id="gramSheetCorrProduksi2">
                                            <input type="text" class="form-control txt_line" value="{{ $mc->gramSheetCorrProduksi }}"  name="gramSheetCorrProduksi" id="gramSheetCorrProduksi" onchange="getKodeBarang();">
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
                                            <input type="hidden" class="form-control txt_line col-md-11" value="{{ $mc->substanceKontrak_id }}" id="substanceKontrak_id" name="substanceKontrak_id">
                                            <input type="hidden" class="form-control txt_line col-md-11" value="" id="Katas">
                                            <input type="hidden" class="form-control txt_line col-md-11" value="" id="Kbf">
                                            <input type="hidden" class="form-control txt_line col-md-11" value="" id="Ktengah">
                                            <input type="hidden" class="form-control txt_line col-md-11" value="" id="Kcf">
                                            <input type="hidden" class="form-control txt_line col-md-11" value="" id="Kbawah">
                                            <input type="text" class="form-control txt_line col-md-11" value="{{ $mc->subsKontrak }}" id="subskontrak" onchange="getGramKontrak(); getKodeBarang();">
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
                                            <input type="hidden" class="form-control txt_line col-md-11" value="{{ $mc->substanceProduksi_id }}" id="substanceProduksi_id" name="substanceProduksi_id">
                                            <input type="hidden" class="form-control txt_line col-md-11" value="" id="Patas">
                                            <input type="hidden" class="form-control txt_line col-md-11" value="" id="Pbf">
                                            <input type="hidden" class="form-control txt_line col-md-11" value="" id="Ptengah">
                                            <input type="hidden" class="form-control txt_line col-md-11" value="" id="Pcf">
                                            <input type="hidden" class="form-control txt_line col-md-11" value="" id="Pbawah">
                                            <input type="text" class="form-control txt_line col-md-11" value="{{ $mc->subsProduksi }}" id="subsProduksi">
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
                                            <select class="js-example-basic-single col-md-12" name="tipeMc" id="tipeMc" onchange="getKodeBarang();">
                                                <option value='{{ $mc->tipeMc }}'>{{ $mc->tipeMc }}</option>
                                                <option value='B1'>B1</option>
                                                <option value='B1 Terbalik'>B1 Terbalik</option>
                                                <option value='B3'>B3</option>
                                                <option value='DC'>DC</option>
                                                <option value='LAYER'>LAYER</option>
                                                <option value='SHEET'>SHEET</option>
                                                <option value='ROLL'>ROLL</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Warna</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="hidden" value="{{ $mc->ccid }}" name="colorCombine_id" id="colorCombine_id">
                                            <select class="js-example-basic-single col-md-12" name="warna" id="warna" onchange="getColor(); getKodeBarang();">
                                                <option value='{{ $mc->ccid }}|{{ $mc->ccnama }}'>{{ $mc->ccnama }}</option>
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
                                                <option value='{{ $mc->wax }}'>{{ $mc->wax }}</option>
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
                                                <option value='{{ $mc->joint }}'>{{ $mc->joint }}</option>
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
                                        <?php
                                            if ($mc->koli < 10) {
                                                $koli = '0'.$mc->koli;
                                            } else {
                                                $koli = $mc->koli;
                                            }
                                        ?>
                                        <div class="col-md-4">
                                            <select class="js-example-basic-single col-md-12" name="koli" id="koli" onchange="getKodeBarang();" >
                                                <option value='{{ $koli }}'>{{ $koli }}</option>
                                                <option value='00'>Tidak Ada</option>
                                                <option value='05'>05 Koli</option>
                                                <option value='10'>10 Koli</option>
                                                <option value='20'>20 Koli</option>
                                                <option value='25'>25 Koli</option>
                                                <option value='40'>40 Koli</option>
                                                <option value='50'>50 Koli</option>
                                                <option value='60'>60 Koli</option>
                                                <option value='100'>100 Koli</option>
                                            </select>
                                        </div>
                                        /Koli
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Bungkus</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" value="{{ $mc->bungkus }}" name="bungkus" id="bungkus">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Lain-lain</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" value="{{ $mc->lain }}" name="lain" id="lain">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Mesin</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" value="{{ $mc->mesin }}" name="mesin" id="mesin">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Keterangan</label>
                                        </div>
                                        <div class="col-md-4" style="margin: 10 0 10 0;">
                                            <textarea name="keterangan" id="keterangan" cols="60" rows="5">{{ $mc->keterangan }}</textarea>
                                            {{-- <input type="text" class="form-control txt_line" value="{{ $mc->keterangan }}" name="keterangan" id="keterangan" onchange="getKodeBarang()"> --}}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Gambar</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="file" name="gambar" id="gambar">
                                            <input type="hidden" name="old" id="old" value="{{ $mc->gambar }}">
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
                    <a href="{{ route('mastercard.b1') }}">
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
    // Ensure jQuery is loaded before proceeding
    function waitForJQuery(callback) {
        if (typeof jQuery !== 'undefined') {
            callback(jQuery);
        } else {
            setTimeout(function() {
                waitForJQuery(callback);
            }, 50);
        }
    }

    // Initialize everything after jQuery is ready
    waitForJQuery(function($) {
        console.log('jQuery is ready:', $.fn.jquery);
        
        // Document ready handler
        $(document).ready(function() {
            console.log('Document ready, preparing Select2...');
            
            // Initialize immediately
            initializeSelect2();
            
            // Fallback initialization after a delay
            setTimeout(function() {
                if (!$('.js-example-basic-single').hasClass('select2-hidden-accessible')) {
                    console.log('Select2 not initialized yet, forcing initialization...');
                    initializeSelect2();
                }
            }, 1000);

            // Handle tipebox visibility
            var tipebox = document.getElementById('tipebox');
            if (tipebox && tipebox.value == 'SF') {
                $('.berat-roll').show();
            } else {
                $('.berat-roll').hide();
            }
        });

        // Window load handler for final initialization
        $(window).on('load', function() {
            console.log('Window loaded, final Select2 check...');
            
            // Final initialization attempt
            setTimeout(function() {
                initializeSelect2();
            }, 500);
        });

        function initializeSelect2() {
            console.log('Initializing Select2...');
            
            // Check if Select2 is available
            if (typeof $.fn.select2 === 'undefined') {
                console.error('Select2 plugin not available!');
                return;
            }
            
            // Find all select elements
            var selectElements = $('.js-example-basic-single');
            console.log('Found', selectElements.length, 'select elements');
            
            if (selectElements.length === 0) {
                console.error('No select elements found with class js-example-basic-single');
                return;
            }
            
            // Destroy existing instances safely
            selectElements.each(function() {
                var $this = $(this);
                if ($this.hasClass('select2-hidden-accessible')) {
                    console.log('Destroying existing Select2 for', $this.attr('id'));
                    try {
                        $this.select2('destroy');
                    } catch (e) {
                        console.warn('Error destroying Select2:', e);
                    }
                }
            });
            
            // Initialize Select2 with error handling
            try {
                selectElements.select2({
                    theme: 'bootstrap4',
                    width: '100%',
                    placeholder: function() {
                        return $(this).data('placeholder') || 'Pilih opsi...';
                    },
                    allowClear: true,
                    minimumResultsForSearch: 0, // Always show search box
                    escapeMarkup: function(markup) {
                        return markup;
                    },
                    language: {
                        noResults: function() {
                            return "Tidak ada hasil ditemukan";
                        },
                        searching: function() {
                            return "Mencari...";
                        },
                        inputTooShort: function() {
                            return "Masukkan minimal 1 karakter untuk mencari";
                        }
                    }
                });
                
                // Verify initialization
                var initializedCount = 0;
                selectElements.each(function() {
                    if ($(this).hasClass('select2-hidden-accessible')) {
                        initializedCount++;
                        console.log('✓ Select2 initialized for', $(this).attr('id'));
                    } else {
                        console.error('✗ Select2 failed for', $(this).attr('id'));
                    }
                });
                
                console.log('Select2 initialized for', initializedCount, 'out of', selectElements.length, 'elements');
                
            } catch (error) {
                console.error('Error initializing Select2:', error);
            }
        }

        // Reinitialize Select2 after any dynamic content changes
        function reinitializeSelect2() {
            console.log('Reinitializing Select2...');
            initializeSelect2();
        }

        // Handle form resets
        $(document).on('reset', 'form', function() {
            setTimeout(function() {
                reinitializeSelect2();
            }, 100);
        });

        // Add event listeners for select changes to maintain functionality
        $(document).on('select2:select', '#golongan, #tujuan, #tipeMc, #koli', function (e) {
            console.log('Select2 selection changed for', $(this).attr('id'));
            if (typeof getKodeBarang === 'function') {
                getKodeBarang();
            }
        });

        $(document).on('select2:select', '#warna', function (e) {
            console.log('Color selection changed');
            if (typeof getColor === 'function') {
                getColor();
            }
        });

        // Fix for Select2 inside modals
        $('#List-Customer, #Box, #Substance').on('shown.bs.modal', function() {
            var $modal = $(this);
            setTimeout(function() {
                $modal.find('.js-example-basic-single').select2({
                    theme: 'bootstrap4',
                    width: '100%',
                    minimumResultsForSearch: 0,
                    dropdownParent: $modal
                });
            }, 100);
        });

        // Test function to manually trigger Select2
        window.testSelect2 = function() {
            console.log('=== Testing Select2 ===');
            console.log('jQuery available:', typeof $ !== 'undefined');
            console.log('jQuery version:', $.fn.jquery);
            console.log('Select2 available:', typeof $.fn.select2 !== 'undefined');
            
            $('.js-example-basic-single').each(function() {
                var $this = $(this);
                console.log('Element:', $this.attr('id'), 'Has Select2:', $this.hasClass('select2-hidden-accessible'));
            });
            
            // Force reinitialize
            console.log('Force reinitializing...');
            reinitializeSelect2();
            
            // Check again after reinit
            setTimeout(function() {
                console.log('=== After Reinitialize ===');
                $('.js-example-basic-single').each(function() {
                    var $this = $(this);
                    console.log('Element:', $this.attr('id'), 'Has Select2:', $this.hasClass('select2-hidden-accessible'));
                });
            }, 500);
        };

        // Manual initialization function
        window.forceSelect2 = function() {
            console.log('=== Force Select2 Initialization ===');
            
            // Try direct initialization without destroy
            $('.js-example-basic-single').each(function() {
                var $element = $(this);
                var id = $element.attr('id');
                
                console.log('Processing element:', id);
                
                try {
                    $element.select2({
                        theme: 'bootstrap4',
                        width: '100%',
                        minimumResultsForSearch: 0,
                        placeholder: 'Pilih opsi...',
                        allowClear: true
                    });
                    console.log('✓ Success for', id);
                } catch (error) {
                    console.error('✗ Error for', id, ':', error);
                }
            });
        };

        // Global scope assignment for backward compatibility
        window.initializeSelect2 = initializeSelect2;
        window.reinitializeSelect2 = reinitializeSelect2;
    });
    // Datatable Barang(Item)
    
    $(document).on("keyup", ".lebar-box", function() {
            lebar = $(this).val();
            panjang = document.getElementById("panjangSheet").value;

            luas = panjang * lebar / 1000000

            document.getElementById("luasSheet").value = luas
    });

    $(document).on("keyup", ".lebar-sheet", function() {
            lebar = $(this).val();
            panjang = $('.panjang-sheet').val();

            luas = panjang * lebar / 1000000

            document.getElementById("luasSheet").value = luas
    });

    $(document).on("keyup", ".qty-roll", function() {
        if (document.getElementById("tipebox").value == "SF") {
            berat = $(this).val();
            lebar = document.getElementById("lebarSheet").value;
            kualitas = document.getElementById("gram_kualitas").value;

            panjang = berat / (lebar*kualitas/1000);

            document.getElementById("panjangSheet").value = panjang.toFixed(0);


        }
    });

    $(".customer").ready(function(){
        
        var table = $("#data_customer").DataTable({
            select: true,
        });
        
        $('#data_customer tbody').on( 'click', 'td', function () {
            var cust = (table.row(this).data());
            
            // document.getElementById('customer_id').value = cust[0]    ;
            document.getElementById('customer').value = cust[1];
            // document.getElementById('alamatKirim').value = cust[5];
            // document.getElementById('telp').value = cust[3];
            // document.getElementById('fax').value = cust[4];
            
            console.log(cust);
        } );
    } );

    function getKodeBarang() {
        var tujuan = document.getElementById("tujuan").value;
        var tipebox = document.getElementById("tipebox").value;
        var flute = document.getElementById("flute").value;
        var tipemc = document.getElementById("tipeMc").value;
        var golongan = document.getElementById("golongan").value;
        var koli = document.getElementById("koli").value;
        var kode = document.getElementById("kode").value;
        var revisi = document.getElementById("revisi").value;

        nomc = kode.substring(2,6);

        if(koli == "100") {
            kodeKoli = "00";
        } else if (koli == "00"){
            kodeKoli = "00";
        } else {
            kodeKoli = koli;
        }


        if (tipemc == 'B1' || tipemc == 'B1 Terbalik') {
            tipemc = 'B';
        } else if (tipemc == 'DC') {
            tipemc = 'D';
        } else if (tipemc == 'LAYER') {
            tipemc = 'L';
        } else if(tipemc == 'SINGLEFACE') {
            tipemc = 'F';
        } else if (tipemc == 'ROLL') {
            tipemc = 'R';
        } else if (tipemc == 'SHEET') {
            tipemc = 'S';
        } else if (tipemc == 'REJECT') {
            tipemc = 'X';
        } else if (tipemc == 'RMG') {
            tipemc = 'Z';
        }

        console.log(tipemc);
        

        if (flute == 'BF') {
            flute = '01';
        } else if (flute == 'CF') {
            flute = '02';
        } else if (flute == 'BCF') {
            flute = '03';
        } else if (flute == 'EBF') {
            flute = '05';
        } else if (flute == 'EF') {
            flute = '04';
        } else if (flute == 'Roll') {
            flute = '50';
        }

        if (tipemc == 'F' || tipebox == 'R') {  
            kodebarang = tujuan+tipemc+"E."+flute+".01.W01."+nomc+"0."+golongan;
        } else {
            kodebarang = tujuan+tipemc+"E."+flute+".01.S"+kodeKoli+"."+nomc+revisi+"."+golongan;
        }

        // console.log(kodebarang);

        document.getElementById("kodeBarang").value = kodebarang;
    }


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
            processing: true,
            serverSide: true,
            // scrollX: true,
            // scrollY: "auto",
            ajax: {
                url: "{{ route('box') }}"
            },
            columns: [
            { data: 'id', name: 'id' },
            { data: 'kode', name: 'kode' },
            { data: 'namaBarang', name: 'namaBarang' },
            { data: 'tipebox', name: 'tipebox' },
            { data: 'flute', name: 'flute' },
            { data: 'panjangDalamBox', name: 'panjangDalamBox' },
            { data: 'lebarDalamBox', name: 'lebarDalamBox' },
            { data: 'tinggiDalamBox', name: 'tinggiDalamBox' },
            { data: 'sizeCreasCorr', name: 'sizeCreasCorr' },
            { data: 'sizeCreasConv', name: 'sizeCreasConv' },
            { data: 'tipeCreasCorr', name: 'tipeCreasCorr' },
            ],
            select: true
        });
        
        $('#data_box tbody').on( 'click', 'td', function () {
            var Box = (table.row(this).data());
            
            // document.getElementById('kodeBarang').value = Box[2];
            document.getElementById('namaBarang').value = Box['namaBarang'];
            document.getElementById('tipebox').value = Box['tipebox'];
            document.getElementById('box_id').value = Box['id'];
            document.getElementById('panjangbox').value = Box['panjangDalamBox'];
            document.getElementById('lebarbox').value = Box['lebarDalamBox'];
            document.getElementById('tinggibox').value = Box['tinggiDalamBox'];
            document.getElementById('creasCorr').value = Box['sizeCreasCorr'];
            document.getElementById('creasConv').value = Box['sizeCreasConv'];
            document.getElementById('flute').value = Box['flute'];
            
            $('.berat-roll').hide();
            
            if (Box['tipebox'] == 'B1' || Box['tipebox'] == 'B3') {
                var resultP = getID(Box['sizeCreasCorr']);
                var resultL = getID(Box['sizeCreasConv']);
                if (Box['flute'] == "BF") {
                    faktorp = 43;
                    faktorl = 10;
                } else if(Box['flute'] == "CF"){
                    faktorp = 47;
                    faktorl = 13;
                } else if (Box['flute'] == "BCF") {
                    faktorp = 63;
                    faktorl = 27;
                }
                var panjang = Box['panjangDalamBox'];
                var lebar = Box['lebarDalamBox'];
                var tinggi = Box['tinggiDalamBox'];
                document.getElementById("lebarSheet").value = parseInt(resultP);
                document.getElementById("panjangSheet").value = parseInt(resultL);

                document.getElementById("lebarSheetBox").value = parseInt(resultP);
                document.getElementById("panjangSheetBox").value = parseInt(resultL);
                
                var luasmkt =(((panjang*2)+(lebar*2)+faktorp)/1000) * (parseInt(faktorl)+parseInt(lebar)+parseInt(tinggi))/1000;
                var luasProd = (parseInt(resultL)*parseInt(resultP))/1000000;
                // var luas = parseInt(resultL)*parseInt(resultP)/1000000;

                // console.log(luas);
                document.getElementById("luasSheet").value = luasmkt.toFixed(3);
                document.getElementById("luasSheetBox").value = luasmkt.toFixed(3);
                document.getElementById("luasSheetProd").value = luasProd.toFixed(3);
                document.getElementById("luasSheetBoxProd").value = luasProd.toFixed(3);
            } else if (Box['tipebox'] == 'DC') {
                $('.berat-roll').hide();
                document.getElementById("panjangSheet").value = null;
                document.getElementById("lebarSheet").value = null;
                document.getElementById("luasSheet").value = null;
                document.getElementById("panjangSheetBox").value = null;
                document.getElementById("lebarSheetBox").value = null;
                document.getElementById("luasSheetBox").value = null;
                document.getElementById("subsKontrak").value = null;
                document.getElementById("subsProduksi").value = null;
            } else {
                $('.berat-roll').show();
                document.getElementById("panjangSheet").value = null;
                document.getElementById("lebarSheet").value = null;
                document.getElementById("luasSheet").value = null;
                document.getElementById("panjangSheetBox").value = null;
                document.getElementById("lebarSheetBox").value = null;
                document.getElementById("luasSheetBox").value = null;
                document.getElementById("subsKontrak").value = null;
                document.getElementById("subsProduksi").value = null;
                
                getKodeBarang();
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
            // getLuasDC();
            getKodeBarang()
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
            getKodeBarang()
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
        var doublejoint = document.getElementById('doublejoint').value;
        
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
            
            gramKualitas = (parseInt(Katas) + (parseInt(Kbf)*1.36) + parseInt(Ktengah) + (parseInt(Kcf)*0) + parseInt(Kbawah))/1000;

            if (doublejoint == 'Ya') {
                result = parseFloat(luasSheet) * gramKualitas.toFixed(3) * 2;
                result2 = parseFloat(luasSheetBox) * gramKualitas.toFixed(3) * 2;
            } else {
                result = parseFloat(luasSheet) * gramKualitas.toFixed(3);
                result2 = parseFloat(luasSheetBox) * gramKualitas.toFixed(3);
            }
            
            document.getElementById('gramSheetCorrKontrak').value = result.toFixed(3);
            document.getElementById('gramSheetCorrKontrak2').value = result.toFixed(3);
            document.getElementById('gramSheetBoxKontrak').value = result2.toFixed(3);
            document.getElementById('gramSheetBoxKontrak2').value = result2.toFixed(3);
            document.getElementById('gram_kualitas').value = gramKualitas.toFixed(3);
        } else if (flutenama == 'EF') {
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
            
            gramKualitas = (parseInt(Katas) + (parseInt(Kbf)*1.21) + parseInt(Ktengah) + (parseInt(Kcf)*0) + parseInt(Kbawah))/1000;

            if (doublejoint == 'Ya') {
                result = parseFloat(luasSheet) * gramKualitas.toFixed(3) * 2;
                result2 = parseFloat(luasSheetBox) * gramKualitas.toFixed(3) * 2;
            } else {
                result = parseFloat(luasSheet) * gramKualitas.toFixed(3);
                result2 = parseFloat(luasSheetBox) * gramKualitas.toFixed(3);
            }
            
            document.getElementById('gramSheetCorrKontrak').value = result.toFixed(3);
            document.getElementById('gramSheetCorrKontrak2').value = result.toFixed(3);
            document.getElementById('gramSheetBoxKontrak').value = result2.toFixed(3);
            document.getElementById('gramSheetBoxKontrak2').value = result2.toFixed(3);
            document.getElementById('gram_kualitas').value = gramKualitas.toFixed(3);
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
            
            gramKualitas = (parseInt(Katas) + (parseInt(Kcf)*1.46) + parseInt(Ktengah) + (parseInt(Kbf)*0) + parseInt(Kbawah))/1000;
            
            if (doublejoint == 'Ya') {
                result = parseFloat(luasSheet) * gramKualitas.toFixed(3) * 2;
                result2 = parseFloat(luasSheetBox) * gramKualitas.toFixed(3) * 2;
            } else {
                result = parseFloat(luasSheet) * gramKualitas.toFixed(3);
                result2 = parseFloat(luasSheetBox) * gramKualitas.toFixed(3);
            }

            document.getElementById('gramSheetCorrKontrak').value = result.toFixed(3);
            document.getElementById('gramSheetCorrKontrak2').value = result.toFixed(3);
            document.getElementById('gramSheetBoxKontrak').value = result2.toFixed(3);
            document.getElementById('gramSheetBoxKontrak2').value = result2.toFixed(3);
            document.getElementById('gram_kualitas').value = gramKualitas.toFixed(3);
            getKodeBarang()
            
        } else 
        if (flutenama == 'EBF') {
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
            
            gramKualitas = (parseInt(Katas) + (parseInt(Kcf)*1.21) + parseInt(Ktengah) + (parseInt(Kbf)*1.36) + parseInt(Kbawah))/1000;
            
            if (doublejoint == 'Ya') {
                result = parseFloat(luasSheet) * gramKualitas.toFixed(3) * 2;
                result2 = parseFloat(luasSheetBox) * gramKualitas.toFixed(3) * 2;
            } else {
                result = parseFloat(luasSheet) * gramKualitas.toFixed(3);
                result2 = parseFloat(luasSheetBox) * gramKualitas.toFixed(3);
            }

            document.getElementById('gramSheetCorrKontrak').value = result.toFixed(3);
            document.getElementById('gramSheetCorrKontrak2').value = result.toFixed(3);
            document.getElementById('gramSheetBoxKontrak').value = result2.toFixed(3);
            document.getElementById('gramSheetBoxKontrak2').value = result2.toFixed(3);
            document.getElementById('gram_kualitas').value = gramKualitas.toFixed(3);
            console.log(result.toFixed(3), result2.toFixed(3), gramKualitas);
            
        } else {
            
            gramKualitas = (parseInt(Katas) + (parseInt(Kbf)*1.36) + parseInt(Ktengah) + (parseInt(Kcf)*1.46) + parseInt(Kbawah))/1000;

            if (doublejoint == 'Ya') {
                result = parseFloat(luasSheet) * gramKualitas.toFixed(3) * 2;
                result2 = parseFloat(luasSheetBox) * gramKualitas.toFixed(3) * 2;
            } else {
                result = parseFloat(luasSheet) * gramKualitas.toFixed(3);
                result2 = parseFloat(luasSheetBox) * gramKualitas.toFixed(3);
            }

            document.getElementById('gramSheetCorrKontrak').value = result.toFixed(3);
            document.getElementById('gramSheetCorrKontrak2').value = result.toFixed(3);
            document.getElementById('gramSheetBoxKontrak').value = result2.toFixed(3);
            document.getElementById('gramSheetBoxKontrak2').value = result2.toFixed(3);
            document.getElementById('gram_kualitas').value = gramKualitas.toFixed(3);
            getKodeBarang()
        }
        
        return result;
    }
    
    function getLuasDC(){
        $panjang = document.getElementById("panjangSheet").value;
        $lebar = document.getElementById("lebarSheet").value;
        $panjangbox = document.getElementById("panjangSheetBox").value;
        $lebarbox = document.getElementById("lebarSheetBox").value;
        $tipebox = document.getElementById("tipebox").value;

        if ($tipebox == 'DC' || $tipebox == 'SH') {
            $result = ($panjang * $lebar)/1000000;
        $result2 = ($panjangbox * $lebarbox)/1000000;

        $out = $result/$result2;

        document.getElementById('outConv').value = $out.toFixed(0);
        document.getElementById('luasSheet').value = $result.toFixed(3);
        document.getElementById('luasSheetBox').value = $result2.toFixed(3);
        document.getElementById('luasSheetProd').value = $result.toFixed(3);
        document.getElementById('luasSheetBoxProd').value = $result2.toFixed(3);
        getKodeBarang();
        } else { 
        $result = ($panjang * $lebar)/1000000;
            $result2 = ($panjangbox * $lebarbox)/1000000;

            $out = $result/$result2;
            document.getElementById('outConv').value = $out.toFixed(0); 
            document.getElementById('luasSheet').value = $result.toFixed(3);
            document.getElementById('luasSheetBox').value = $result2.toFixed(3);
            document.getElementById('luasSheetProd').value = $result.toFixed(3);
            document.getElementById('luasSheetBoxProd').value = $result2.toFixed(3);
            getKodeBarang();
        }
    }

    function getGramProduksi(){
        
        var flutenama = document.getElementById('flute').value;
        var Patas = parseInt(document.getElementById('Patas').value);
        var Pbf = parseFloat(document.getElementById('Pbf').value);
        var Ptengah = parseFloat(document.getElementById('Ptengah').value);
        var Pcf = parseFloat(document.getElementById('Pcf').value);
        var Pbawah = parseFloat(document.getElementById('Pbawah').value);
        var luasSheet = parseFloat(document.getElementById('luasSheetProd').value);
        var luasSheetBox = parseFloat(document.getElementById('luasSheetBoxProd').value);
        var doublejoint = document.getElementById('doublejoint').value;
        
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
            
            gramKualitas = (parseInt(Patas) + (parseInt(Pbf)*1.36) + parseInt(Ptengah) + (parseInt(Pcf)*0) + parseInt(Pbawah))/1000;

            if (doublejoint == 'Ya') {
                result = parseFloat(luasSheet) * gramKualitas.toFixed(3) * 2;
                result2 = parseFloat(luasSheetBox) * gramKualitas.toFixed(3) * 2;
            } else {
                result = parseFloat(luasSheet) * gramKualitas.toFixed(3);
                result2 = parseFloat(luasSheetBox) * gramKualitas.toFixed(3);
            }
            
            document.getElementById('gramSheetCorrProduksi').value = result.toFixed(3);
            document.getElementById('gramSheetBoxProduksi').value = result2.toFixed(3);
            document.getElementById('gramSheetCorrProduksi2').value = result.toFixed(3);
            document.getElementById('gramSheetBoxProduksi2').value = result2.toFixed(3);
            document.getElementById('gram_kualitas').value = gramKualitas.toFixed(3);
        } else if (flutenama == 'EF') {
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
            
            gramKualitas = (parseInt(Patas) + (parseInt(Pbf)*1.21) + parseInt(Ptengah) + (parseInt(Pcf)*0) + parseInt(Pbawah))/1000;

            if (doublejoint == 'Ya') {
                result = parseFloat(luasSheet) * gramKualitas.toFixed(3) * 2;
                result2 = parseFloat(luasSheetBox) * gramKualitas.toFixed(3) * 2;
            } else {
                result = parseFloat(luasSheet) * gramKualitas.toFixed(3);
                result2 = parseFloat(luasSheetBox) * gramKualitas.toFixed(3);
            }
            
            document.getElementById('gramSheetCorrProduksi').value = result.toFixed(3);
            document.getElementById('gramSheetBoxProduksi').value = result2.toFixed(3);
            document.getElementById('gramSheetCorrProduksi2').value = result.toFixed(3);
            document.getElementById('gramSheetBoxProduksi2').value = result2.toFixed(3);
            document.getElementById('gram_kualitas').value = gramKualitas.toFixed(3);
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
            
            gramKualitas = (parseInt(Patas) + (parseInt(Pbf)*0) + parseInt(Ptengah) + (parseInt(Pcf)*1.46) + parseInt(Pbawah))/1000;
            
            if (doublejoint == 'Ya') {
                result = parseFloat(luasSheet) * gramKualitas.toFixed(3) * 2;
                result2 = parseFloat(luasSheetBox) * gramKualitas.toFixed(3) * 2;
            } else {
                result = parseFloat(luasSheet) * gramKualitas.toFixed(3);
                result2 = parseFloat(luasSheetBox) * gramKualitas.toFixed(3);
            }

            document.getElementById('gramSheetCorrProduksi').value = result.toFixed(3);
            document.getElementById('gramSheetBoxProduksi').value = result2.toFixed(3);
            document.getElementById('gramSheetCorrProduksi2').value = result.toFixed(3);
            document.getElementById('gramSheetBoxProduksi2').value = result2.toFixed(3);
            document.getElementById('gram_kualitas').value = gramKualitas.toFixed(3);
            getKodeBarang()
            
        } else
        if (flutenama == 'EBF') {
            
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

            console.log(Patas, Pbf, Ptengah, Pcf, Pbawah);
            
            
            gramKualitas = (parseInt(Patas) + (parseInt(Pcf)*1.21) + parseInt(Ptengah) + (parseInt(Pbf)*1.36) + parseInt(Pbawah))/1000;
            
            
            if (doublejoint == 'Ya') {
                result = parseFloat(luasSheet) * gramKualitas.toFixed(3) * 2;
                result2 = parseFloat(luasSheetBox) * gramKualitas.toFixed(3) * 2;
            } else {
                result = parseFloat(luasSheet) * gramKualitas.toFixed(3);
                result2 = parseFloat(luasSheetBox) * gramKualitas.toFixed(3);
            }

            document.getElementById('gramSheetCorrProduksi').value = result.toFixed(3);
            document.getElementById('gramSheetBoxProduksi').value = result2.toFixed(3);
            document.getElementById('gramSheetCorrProduksi2').value = result.toFixed(3);
            document.getElementById('gramSheetBoxProduksi2').value = result2.toFixed(3);
            document.getElementById('gram_kualitas').value = gramKualitas.toFixed(3);

            console.log(result.toFixed(3), result2.toFixed(3), gramKualitas);
            
            
        } else {

            gramKualitas = (parseInt(Patas) + (parseInt(Pbf)*1.36) + parseInt(Ptengah) + (parseInt(Pcf)*1.46) + parseInt(Pbawah))/1000;

            if (doublejoint == 'Ya') {
                result = parseFloat(luasSheet) * gramKualitas.toFixed(3) * 2;
                result2 = parseFloat(luasSheetBox) * gramKualitas.toFixed(3) * 2;
            } else {
                result = parseFloat(luasSheet) * gramKualitas.toFixed(3);
                result2 = parseFloat(luasSheetBox) * gramKualitas.toFixed(3);
            }

            document.getElementById('gramSheetCorrProduksi').value = result.toFixed(3);
            document.getElementById('gramSheetBoxProduksi').value = result2.toFixed(3);
            document.getElementById('gramSheetCorrProduksi2').value = result.toFixed(3);
            document.getElementById('gramSheetBoxProduksi2').value = result2.toFixed(3);
            document.getElementById('gram_kualitas').value = gramKualitas.toFixed(3);
            getKodeBarang()
        }
    }
    
    
</script>