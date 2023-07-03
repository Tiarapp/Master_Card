{{-- @extends('admin.templates.partials.default') --}}
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<style>
    .row {
        margin-top: 10px;
    }
    
    .modal-title {
        text-align: center;
    }
    
    h5,h6 {
        /* margin-bottom: 5px !important; */
        font-weight: bold;
    }
    
    span.x {
        display: inline-block;
        padding-left: 35px;
    }
    
    input[type="text"],
    select.form-control {
        background: transparent;
        border: none;
        /* border-bottom: 1px solid #000000; */
        -webkit-box-shadow: none;
        box-shadow: none;
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        border-radius: 0;
        font-size: 24px;
        margin-top: -10px;
        text-decoration-color: black;
        /* text-align: center; */
    }
    
    label,p {
        font-size: 20px;
        /* font-weight: bold; */
        font-family: 'Franklin Gothic Heavy';
    }
    
    .form-section{
        font-size: 18px;
        font-weight: bold;
    }
    .col-md {
        width: auto px !important;
    }
    
    /* @page {
        size: A4;
        margin: 0;
    }
    */
    @media print{
        html, body {
            width: 210mm;
            height: 297mm;
        }
    } 
    
    
</style>


<div class="content-wrapper" style="margin: 0px 50px; height: 297mm !important; width: 250mm !important">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row" id="form_list_mc">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <b><h4 class="modal-title">PT. SARANA PACKAGING AGRAPANA</h4></b>
                        <b><h4 class="modal-title">Master Card</h4></b>
                    </div>
                    <div class="col-md-6" style="padding-left: 100px">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">No. MC</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control txt_line" value="{{ $mc->kode }}" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">Tipe Box</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control txt_line" value="{{ $mc->tipeBox }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                
                <form action="#" method="POST">
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12" style="border: 2px solid black;  margin-top:10px;">
                                <div class="form-group">
                                    {{-- <h4 class="form-section"> Data Master Item</h4> --}}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="control-label">Tanggal MC</label>
                                                </div>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control txt_line" name="tglmc" id="tglmc"  value="{{ date('d-m-Y', strtotime($mc->created_at)) }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="control-label">No Item</label>
                                                </div>
                                                <div class="col-md-9" style="padding-left: 0px">
                                                    <div class="col-md-12">
                                                        <input type="text" class="form-control txt_line" value="{{ $mc->kodeBarang }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Nama Item</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control txt_line" value="{{ $mc->namaBarang }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="border: 2px solid black;  margin-top:1px;">
                                <div class="col-md-12" style="text-align: center; font-size: 20px; font-weight: bold;">S H E E T &nbsp; C O R R</div> 
                            </div>
                            <div class="col-md-12" style="border: 2px solid black;  margin-top:1px; padding-top:0px;">
                                <div class="row" style="
                                margin-left: -16;
                                margin-top: -1;
                            ">
                                    <div class="col-md-6" style="margin:0px; border: 2px solid black;">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="control-label">Ukuran</label>
                                            </div>
                                            <div class="col-md-3" style="padding-right:0px">
                                                <input type="text" class="form-control txt_line" value="{{ $mc->panjangSheetBox }}"> 
                                                
                                            </div> 
                                            <div class="col-md-1" style="padding-left:0px">
                                                <label for="" >X</label>        
                                            </div>  
                                            <div class="col-md-3">
                                                <input type="text" class="form-control txt_line" value="{{ $mc->lebarSheetBox }}">        
                                            </div>                                                
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="control-label">Luas</label>
                                            </div>  
                                            <div class="col-md-3">
                                                <input type="text" class="form-control txt_line" value="{{ $mc->luasSheet }}">        
                                            </div>
                                            <div class="col-md-3">
                                                <label for="" >MM<sup>2</sup></label>          
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2" style="margin-top: 30px;">
                                        <label class="control-label">Ukuran Dalam Box</label> 
                                    </div>
                                    <div class="col-md-1">
                                        <span class="x">P</span>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="text" class="form-control txt_line" value="{{ $mc->panjangDalamBox }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <span class="x">L</span>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="text" class="form-control txt_line" value="{{ $mc->lebarDalamBox }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <span class="x">T</span>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="text" class="form-control txt_line" value="{{ $mc->tinggiDalamBox }}" readonly>
                                            </div>
                                            {{-- <div class="col-md-2">
                                                <label class="control-label">Luas Sheet Box</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control txt_line" value="{{ $mc->luasSheetBox }}" readonly>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label">Luas Sheet Box</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control txt_line" value="{{ $mc->luasSheetBox }}" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label">Berat Sheet Box</label>
                                    </div>
                                    <div class="col-md-1">
                                        <input type="text" class="form-control txt_line" value="{{ $mc->gramSheetBoxKontrak }}" readonly>
                                    </div>
                                </div>
                                {{-- <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label">Berat Sheet Box</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control txt_line" value="{{ $mc->gramSheetBox }}" readonly>
                                    </div>
                                </div> --}}
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label">Creas Corr</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control txt_line" value="{{ $mc->CreasCorrP }}" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label">Creas Conv</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control txt_line" value="{{ $mc->CreasCorrL }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="border: 2px solid black;  margin-top:10px;">
                            <div class="form-group">
                                <h4 class="form-section">Ukuran Sheet</h4>
                                <div class="row">
                                    <div class="col-md-2" style="margin-top: 30px;">
                                        <label class="control-label">Ukuran Sheet Box</label> 
                                    </div>
                                    <div class="col-md-1">
                                        {{-- <span class="x">P</span> --}}
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="text" class="form-control txt_line" value="{{ $mc->panjangSheetBox }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        {{-- <span class="x">L</span> --}}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" class="form-control txt_line" value="{{ $mc->lebarSheetBox }}" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <p>MM</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        {{-- <span class="x">L</span> --}}
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label class="control-label">Flute</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control txt_line" value="{{ $mc->flute }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label">Luas Sheet Corr</label>
                                    </div>
                                    <div class="col-md-1">
                                        <input type="text" class="form-control txt_line" value="{{ $mc->luasSheet }}" readonly>
                                    </div>
                                    <div class="col-md-1">
                                        <p>M<sup>2</sup></p> 
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label">Berat Sheet Corr</label>
                                    </div>
                                    <div class="col-md-1">
                                        <input type="text" class="form-control txt_line" value="{{ $mc->gramSheetCorrKontrak }}" readonly>
                                    </div>
                                    <div class="col-md-1">
                                        <p> Gram </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label">Substance Kontrak</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control txt_line" value="{{ $mc->SubsKontrakNama }}" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label">Substance Produksi</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control txt_line" value="{{ $mc->SubsProduksiNama }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="border: 2px solid black;  margin-top:10px;">
                            <div class="form-group">
                                <h4 class="form-section">Deskripsi Detail</h4>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label">Warna</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control txt_line" value="{{ $mc->colComNama }}" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label">Wax</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control txt_line" value="{{ $mc->wax }}" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label">Packing</label>
                                    </div>
                                    <div class="col-md-1">
                                        <input type="text" class="form-control txt_line" value="{{ $mc->koli }}" readonly>
                                    </div>
                                </div>
                                {{-- <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label">Packing</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control txt_line" value="{{ $mc->koli }}" readonly>
                                    </div>
                                </div> --}}
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label">Bungkus</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control txt_line" value="{{ $mc->bungkus }}" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label">Keterangan</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control txt_line" value="{{ $mc->keterangan }}" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label">Gambar</label>
                                    </div>
                                    <div class="col-md-4">
                                        <img src="{{ url('/upload/'.$mc->gambar) }}" style="width: auto px; max-width: 500px">
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