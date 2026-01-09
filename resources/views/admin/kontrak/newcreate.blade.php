@extends('admin.templates.partials.default')

<!-- Select2 4.1.0-rc.0 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css" rel="stylesheet" />

<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">

<style>
    .select2-container {
        width: 100% !important;
    }
    
    .select2-container--bootstrap4 .select2-selection--single {
        height: 38px !important;
        border: 1px solid #ced4da !important;
        border-radius: 0.25rem !important;
        padding: 0 !important;
    }
    
    .select2-container--bootstrap4 .select2-selection__rendered {
        line-height: 36px !important;
        padding-left: 12px !important;
        padding-right: 20px !important;
        color: #495057 !important;
        font-size: 14px !important;
    }
    
    .select2-container--bootstrap4 .select2-selection__arrow {
        height: 36px !important;
        right: 10px !important;
        top: 1px !important;
    }
    
    .select2-container--bootstrap4 .select2-selection__arrow b {
        border-color: #999 transparent transparent transparent !important;
        border-style: solid !important;
        border-width: 5px 4px 0 4px !important;
        height: 0 !important;
        left: 50% !important;
        margin-left: -4px !important;
        margin-top: -2px !important;
        position: absolute !important;
        top: 50% !important;
        width: 0 !important;
    }
    
    .select2-container--bootstrap4.select2-container--open .select2-selection__arrow b {
        border-color: transparent transparent #999 transparent !important;
        border-width: 0 4px 5px 4px !important;
    }
    
    .select2-container--bootstrap4 .select2-dropdown {
        border: 1px solid #ced4da !important;
        border-radius: 0.25rem !important;
    }
    
    .select2-container--bootstrap4 .select2-search--dropdown .select2-search__field {
        border: 1px solid #ced4da !important;
        border-radius: 0.25rem !important;
        padding: 6px 12px !important;
    }
    
    .select2-container--bootstrap4 .select2-results__option {
        padding: 6px 12px !important;
    }
    
    .select2-container--bootstrap4 .select2-results__option--highlighted {
        background-color: #007bff !important;
        color: white !important;
    }
</style>


@section('content')
<div class="bg content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row" id="form_list_mc">
            <div class="col-md-12">                
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
                <form action="{{ route('kontrak.store') }}" method="POST">
                    {{ csrf_field() }}

                    <h4 class="modal-title"><b>Master Kontrak</b></h4>
                    <hr>
                    <div style="border-bottom: 2px solid black">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>Pilih Customer</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control txt_line col-md-11" name="namaCust" id="namaCust" readonly>
                                                </div>
                                                <button type="button" class="modal-customer" data-toggle="modal" data-target="#modal-customer">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>Tanggal</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="date" class="form-control txt_line" name="tanggal" id="tanggal" value="{{ date("Y-m-d") }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" >
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>Komisi</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" name="komisi" id="komisi">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>Term of Payment</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <select class='js-example-basic-single col-md-12' name="top" id="top">
                                                        @foreach ($top as $data)
                                                            <option value="{{ $data->nama }}">{{ $data->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>Sales</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <select class='js-example-basic-single col-md-12' name="sales" id="sales">
                                                        @foreach ($sales as $data)
                                                            <option value="{{ $data->nama }}">{{ $data->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>Piutang</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control txt_line" name="piutang" id="piutang" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>Telp</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control txt_line" name="telp" id="telp">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>PO Customer</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control txt_line"name="poCustomer" id="poCustomer" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>Tipe Order</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <select class='js-example-basic-single col-md-12' name='tipeOrder' id='tipeOrder' onchange>
                                                        <option value="Order Baru">Order Baru</option>
                                                        <option value="Order Ulang">Order Ulang</option>
                                                        <option value="OUP Design">OUP Design</option>
                                                        <option value="OUP Ukuran">OUP Ukuran</option>
                                                        <option value="OUP Kualitas">OUP Kualitas</option>
                                                        <option value="OUP Warna">OUP Warna</option>
                                                        <option value="OUP Nama Item">OUP Nama Item</option>
                                                        <option value="OUP Nama & Design">OUP Nama & Design</option>
                                                        <option value="OUP Kupingan">OUP Kupingan</option>
                                                        <option value="OUP Joint">OUP Joint</option>
                                                        <option value="OUP Ukuran & Kualitas">OUP Ukuran & Kualitas</option>
                                                        <option value="OUP Nama & Ukuran">OUP Nama & Ukuran</option>
                                                        <option value="OUP Nama & Warna">OUP Nama & Warna</option>  
                                                        <option value="OUP Nama & Kualitas">OUP Nama & Kualitas</option>
                                                        <option value="OUP Design, Nama & Kualitas">OUP Design, Nama & Kualitas</option>
                                                        <option value="OUP Ukuran & Design">OUP Ukuran & Design</option>
                                                        <option value="OUP Nama Item & Flute">OUP Nama Item & Flute</option>
                                                        <option value="OUP Design & Warna">OUP Design & Warna</option>
                                                        <option value="OUP Ukuran, Design & Warna">OUP Ukuran, Design & Warna</option>
                                                        <option value="OUP Ukuran Sheet & Warna">OUP Ukuran Sheet & Warna</option>
                                                        <option value="OUP Design dan Kode Warna">OUP Design dan Kode Warna</option>
                                                        <option value="OUP Design - Kualitas">OUP Design - Kualitas</option>
                                                        <option value="OUP Koli">OUP Koli</option>
                                                        <option value="OUP Pisau">OUP Pisau</option>
                                                        <option value="OUP Pisau & Nama Item">OUP Pisau & Nama Item</option>
                                                        <option value="OUP Proses">OUP Proses</option>
                                                        <option value="OUP Kualitas - Warna">OUP Kualitas - Warna</option>
                                                        <option value="OUP Nama Item, Ukuran & Koli">OUP Nama Item, Ukuran & Koli</option>
                                                        <option value="OUP Nama Item & Proses">OUP Nama Item & Proses</option>
                                                        <option value="OUP Arah Flute">OUP Arah Flute</option>
                                                        <option value="OUP Design, Kualitas, Creasing">OUP Design, Kualitas, Creasing</option>  
                                                        <option value="OUP Nama, Ukuran, Design">OUP Nama, Ukuran, Design</option>
                                                        <option value="OUP Kualitas, Ukuran, Design">OUP Kualitas, Ukuran, Design</option>
                                                        <option value="OUP Design, Warna, Nama Item">OUP Design, Warna, Nama Item</option>
                                                        <option value="OUP Customer, Design, Kualitas">OUP Customer, Design, Kualitas</option>
                                                        <option value="OUP Berat">OUP Berat</option>
                                                        <option value="OUP Design & Koli">OUP Design & Koli</option>
                                                        <option value="OUP Pisau & Design">OUP Pisau & Design</option>
                                                        <option value="OUP Design & Kualitas Produksi">OUP Design & Kualitas Produksi</option>
                                                        <option value="OUP Ukuran Tinggi">OUP Ukuran Tinggi</option>
                                                        <option value="OUP Warna & Kupingan">OUP Warna & Kupingan</option>
                                                        <option value="OUP Warna & Ukuran">OUP Warna & Ukuran</option>
                                                        <option value="OUP Joint & Kualitas">OUP Joint & Kualitas</option>
                                                        <option value="OUP Creasing">OUP Creasing</option>
                                                        <option value="OUP Ukuran, Creasing, Arah Serat">OUP Ukuran, Creasing, Arah Serat</option>
                                                        <option value="OUP Design, Kualitas, Nama Item, Ukuran">OUP Design, Kualitas, Nama Item, Ukuran</option>
                                                        <option value="OUP Type Box, Koli, Ukuran & Kualitas">OUP Type Box, Koli, Ukuran & Kualitas</option> 
                                                        <option value="OUP Nama, Ukuran, Kualitas">OUP Nama, Ukuran, Kualitas</option>
                                                        <option value="OUP Ukuran & Koli">OUP Ukuran & Koli</option>
                                                        <option value="OUP FLUTE, JOIN, CREASING DAN COLLY">OUP FLUTE, JOIN, CREASING DAN COLLY</option>
                                                        <option value="OUP Design, Kualitas, Ukuran, Creasing">OUP Design, Kualitas, Ukuran, Creasing</option>
                                                        <option value="OUP Nama Item, Ukuran, Design, Kualitas, Warna">OUP Nama Item, Ukuran, Design, Kualitas, Warna</option>
                                                        <option value="OUP Nama Item, Creasing">OUP Nama Item, Creasing</option>
                                                        <option value="OUP Nama Item, Design, Creasing">OUP Nama Item, Design, Creasing</option>
                                                        <option value="OUP Nama Item, Kualitas, Creasing">OUP Nama Item, Kualitas, Creasing</option>
                                                        <option value="OUP Palet">OUP Palet</option>
                                                        <option value="OUP Creasing dan OUP Kwalitas">OUP Creasing dan OUP Kwalitas</option>
                                                        <option value="OUP Design, Warna, Kwalitas">OUP Design, Warna, Kwalitas</option>
                                                        <option value="OUP Kwalitas & Kupingan">OUP Kwalitas & Kupingan</option>
                                                        <option value="OUP Ukuran & Arah Flute">OUP Ukuran & Arah Flute</option>
                                                        <option value="OUP Lipatan">OUP Lipatan</option>
                                                        <option value="OUP Kwalitas Produksi & Proses">OUP Kwalitas Produksi & Proses</option>
                                                        <option value="OUP Ukuran & Joint">OUP Ukuran & Joint</option>
                                                        <option value="OUP Nama Item, Design, Proses">OUP Nama Item, Design, Proses</option>
                                                        <option value="OUP Design & Creasing">OUP Design & Creasing</option>
                                                        <option value="OUP Proses, Nama Item dan Kwalitas">OUP Proses, Nama Item dan Kwalitas</option>
                                                        <option value="OUP Proses & Kwalitas">OUP Proses & Kwalitas</option>
                                                        <option value="OUP Nama, Ukuran, Desain & Warna">OUP Nama, Ukuran, Desain & Warna</option>
                                                        <option value="OUP Creasing & OUP Warna">OUP Creasing & OUP Warna</option>
                                                        <option value="OUP Design, OUP Creasing, & OUP Ukuran">OUP Design, OUP Creasing, & OUP Ukuran</option>
                                                        <option value="OUP Warna, Kualitas & Creasing">OUP Warna, Kualitas & Creasing</option>
                                                        <option value="OUP Nama, Ukuran & Desain">OUP Nama, Ukuran & Desain </option>
                                                        <option value="OUP Nama Item, OUP Proses dan OUP Design">OUP Nama Item, OUP Proses dan OUP Design</option>
                                                        <option value="OUP Proses dan OUP Design">OUP Proses dan OUP Design</option>
                                                        <option value="OUP Ukuran, OUP Nama, OUP Design, OUP Warna dan OUP Kualitas">OUP Ukuran, OUP Nama, OUP Design, OUP Warna dan OUP Kualitas</option>
                                                        <option value="OUP Proses dan Joint">OUP Proses dan Joint</option>
                                                        <option value="OUP Proses, OUP Ukuran dan OUP Design">OUP Proses, OUP Ukuran dan OUP Design</option>
                                                        <option value="OUP Flute">OUP Flute</option>
                                                        <option value="OUP Nama Item, OUP Design dan OUP Pisau">OUP Nama Item, OUP Design dan OUP Pisau</option>
                                                        <option value="OUP Nama, Design, Warna dan Kwalitas">OUP Nama, Design, Warna dan Kwalitas</option>
                                                        <option value="OUP Warna, Kualitas, dan Ukuran">OUP Warna, Kualitas, dan Ukuran</option>
                                                        <option value="OUP Nama dan OUP Kupingan">OUP Nama dan OUP Kupingan</option>
                                                        <option value="OUP Design, OUP Warna dan OUP UK Palet">OUP Design, OUP Warna dan OUP UK Palet</option>
                                                        <option value="OUP Nama, Kupingan dan Desain">OUP Nama, Kupingan dan Desain</option>
                                                        <option value="OUP Nama, Kupingan, Ukuran dan Desain">OUP Nama, Kupingan, Ukuran dan Desain</option>
                                                        <option value="OUP Proses, Kualitas, dan Ukuran">OUP Proses, Kualitas, dan Ukuran</option>
                                                        <option value="OUP Flute, Kualitas, dan Ukuran">OUP Flute, Kualitas, dan Ukuran</option>
                                                        <option value="OUP Flute, Kualitas">OUP Flute, Kualitas</option>
                                                        <option value="OUP Warna, Kualitas, dan Nama Item">OUP Warna, Kualitas, dan Nama Item</option>
                                                        <option value="OUP Nama, Desain, Ukuran dan Proses">OUP Nama, Desain, Ukuran dan Proses</option>
                                                    </select>
                                                </div>
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>Cara Kirim</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <select class='js-example-basic-single col-md-12' name="caraKirim" id="caraKirim" required>
                                                        <option value="Kirim">Kirim</option>
                                                        <option value="Ambil Sendiri">Ambil Sendiri</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>Tanggal Kirim</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="date" class="form-control txt_line" name="tglkirim" id="tglkirim" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>Alamat Kirim</label>
                                                </div>
                                                <div class="col-md-6">
                                                    {{-- <input type="text" class="form-control txt_line" name="alamatKirim" id="alamatKirim"> --}}
                                                    <textarea name="alamatKirim" id="alamatKirim" cols="30" rows="4"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>Keterangan</label>
                                                </div>
                                                <div class="col-md-6">
                                                    {{-- <input type="text" class="form-control txt_line" name="alamatKirim" id="alamatKirim"> --}}
                                                    <textarea name="keterangan" id="keterangan" cols="30" rows="4"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h4 class="modal-title" style="margin-top: 20px;"><b>Biaya</b></h4>
                    <hr>
                    <div style="border-bottom: 2px solid black">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Expedisi(Rp/Kg)</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="number" name="biaya_exp" id="biaya_exp">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>Glue Manual(Rp/Pcs)</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="number" name="biaya_glue" id="biaya_glue">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>Wax(Rp/Pcs)</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="number" name="biaya_wax" id="biaya_wax">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h4 class="modal-title" style="margin-top: 20px;"><b>Mastercard</b></h4>
                    <hr>
                    <div class="row" style="margin-top: 20px; border-bottom: 2px solid black">
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Pilih Mastercard</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="hidden" name="kontrakd_id" id="kontrakd_id">
                                                <input type="text" class="form-control txt_line col-md-11" name="namamc" id="namamc" readonly>
                                                <input type="hidden" class="form-control txt_line col-md-11" name="mcid" id="mcid" readonly>
                                            </div>

                                            <button type="button" class="modal-mastercard" data-toggle="modal" data-target="#modal-mastercard">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Flute</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control txt_line col-md-11" name="flute" id="flute" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Warna</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control txt_line col-md-11" name="warna" id="warna" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Nama Barang</label>
                                            </div>
                                            <div class="col-md-6">
                                                {{-- <input type="text" class="form-control txt_line col-md-11" name="namaBarang" id="namaBarang" value="{{ $kontrak_D->box }}" readonly> --}}
                                                <textarea name="namaBarang" id="namaBarang" cols="30" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Gramatur</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control txt_line col-md-11" name="gram" id="gram" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Tipe Box</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control txt_line col-md-11" name="tipeBox" id="tipeBox" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Kualitas</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control txt_line col-md-11" name="kualitas" id="kualitas" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h4 class="modal-title" style="margin-top: 20px;"><b>QTY & Harga</b></h4>
                    <hr>
                    <div class="row" style="margin: 20px 0px; border-bottom: 2px solid black">
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Quantity</label>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control txt_line col-md-11 qty" name="qtyPcs" id="qtyPcs" required>
                                            </div>
                                            <div class="col-md-1">
                                                <label>Pcs</label>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control txt_line col-md-11" name="qtyKg" id="qtyKg" readonly>
                                            </div>
                                            <div class="col-md-1">
                                                <label>Kg</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Toleransi</label>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control txt_line col-md-11 toleransi-lebih" name="toleransiLebih" id="toleransiLebih" required>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control txt_line col-md-11 toleransi-kurang" name="toleransiKurang" id="toleransiKurang" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Harga pcs</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control txt_line col-md-11 harga" name="harga" id="harga" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>PPN</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control txt_line col-md-11 ppn" name="ppn" id="ppn" value="11" readonly>
                                            </div>
                                            <div class="col-md-1">
                                                <label>%</label>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control txt_line col-md-11" name="hargappn" id="hargappn" readonly>
                                            </div>
                                            <div class="col-md-1">
                                                <label></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Toleransi Lebih</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control txt_line col-md-11" name="toleransiLebihPcs" id="toleransiLebihPcs" readonly>
                                            </div>
                                            <div class="col-md-1">
                                                <label>pcs</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control txt_line col-md-11" name="toleransiLebihKg" id="toleransiLebihKg" readonly>
                                            </div>
                                            <div class="col-md-1">
                                                <label>Kg</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Total</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control txt_line col-md-11" name="total" id="total" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Harga kg</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control txt_line col-md-11" name="hargakg" id="hargakg" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Toleransi Kurang</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control txt_line col-md-11" name="toleransiKurangPcs" id="toleransiKurangPcs" readonly>
                                            </div>
                                            <div class="col-md-1">
                                                <label>pcs</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control txt_line col-md-11" name="toleransiKurangKg" id="toleransiKurangKg" readonly>
                                            </div>
                                            <div class="col-md-1">
                                                <label>Kg</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                        <input type="hidden" class="form-control txt_line" name="createdBy" id="createdBy" value="{{ Auth::user()->name }}">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>

                    <div class="modal fade customer-list" tabindex="-1" id="modal-customer">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title">Cari Customer</h3>
                                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                                    </div>
                                </div>
                    
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-6 mb-6">
                                            <form class="form-search-customer" action="">
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control search-customer" id="search" name="search" value="" placeholder="Cari nama customer" style="text-transform: uppercase;">
                                                    <button type="submit" class="btn btn-light-primary keyword-search-customer-button">Search</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="content-body">
                                        Please wait...
                                    </div>
                                </div>
                    
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light btn-active-light-primary me-2" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade mastercard-list" tabindex="-1" id="modal-mastercard">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title">Cari Mastercard</h3>
                                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                                    </div>
                                </div>
                    
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-6 mb-6">
                                            <form class="form-search-mastercard" action="">
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control search-mastercard" id="search" name="search" value="" placeholder="Cari nama mastercard">
                                                    <button type="submit" class="btn btn-light-primary keyword-search-mastercard-button">Search</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="content-body">
                                        Please wait...
                                    </div>
                                </div>
                    
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light btn-active-light-primary me-2" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
    
@endsection

@section('javascripts')

<!-- Load external JavaScript libraries AFTER AdminLTE's jQuery -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        // Initialize Select2
        $('.js-example-basic-single').select2({
            theme: 'bootstrap4',
            width: '100%',
            allowClear: false,
            placeholder: 'Pilih...',
            minimumResultsForSearch: 0
        });
    });

    $(document).on("click", ".modal-customer", function(e) {
        e.preventDefault();
        $(".customer-list .content-body").html("Please wait...");
        var url = "{{ route('kontrak.cust') }}";
        
        $('.form-search-customer').attr('action', url);

        $.get(url, function(data) {
            $(".customer-list .content-body").html(data);
        }).fail(function(xhr, status, error) {
            console.error('Failed to load customer data:', error);
            $(".customer-list .content-body").html("Error loading customer data: " + error);
        });
    });

    $(document).on("submit", ".form-search-customer", function(e) {
        e.preventDefault();
        var submit = $(this).attr('action');
        var search = $('.search-customer').val().toUpperCase();

        $(".customer-list .content-body").html("Please wait...");
        $.get(submit, { search: search }, function(data) {
            console.log('Search completed');
            $(".customer-list .content-body").html(data);
        }).fail(function(xhr, status, error) {
            console.error('Search failed:', error);
            $(".customer-list .content-body").html("Error loading data: " + error);
        });
    });

    // Handle Enter key press on search input
    $(document).on("keypress", ".search-customer", function(e) {
        if (e.which == 13) { // Enter key
            e.preventDefault();
            $('.form-search-customer').trigger('submit');
        }
    });

    $(document).on("click", ".customer-list .pagination a", function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        $(".customer-list .content-body").html("Please wait...");
        $.get(url, function(data) {
            $(".customer-list .content-body").html(data);
        });
    });

    $(document).on("click", ".btn-insert-customer", function(e) {
        e.preventDefault();
        var $row = $(this).closest('tr');
        var customer_id = $row.find('.customer_id').val() || $row.find('input[type=hidden]').val();
        var customer_name = $row.find('td').eq(1).text().trim();
        var alamat_kirim = $row.find('td').eq(5).text().trim();
        var telp = $row.find('td').eq(3).text().trim();

        $('#namaCust').val(customer_name);
        $('#alamatKirim').val(alamat_kirim);
        $('#telp').val(telp);
        if ($('#customer_id').length) {
            $('#customer_id').val(customer_id);
        }

        $('#modal-customer').modal('hide');
    });

    $(document).on("click", ".modal-mastercard", function(e) {
        console.log("test");
        
        e.preventDefault();
        $(".mastercard-list .content-body").html("Please wait...");

            var url = "{{ route('mastercard.select') }}";

            console.log(url);
            

            $('.form-search-mastercard').attr('action', url);

            $.get(url, function(data) {
                $(".mastercard-list .content-body").html(data);
            });
    });

    $(document).on("submit", ".form-search-mastercard", function(e) {
        e.preventDefault();
        var url = $(this).attr('action');
        var search = $('.search-mastercard').val();

        $.get(url, { search: search }, function(data) {
            $(".mastercard-list .content-body").html(data);
        });
    });

    $(document).on("click", ".mastercard-list .pagination a", function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        $(".mastercard-list .content-body").html("Please wait...");
        $.get(url, function(data) {
            $(".mastercard-list .content-body").html(data);
        });
    });

    $(document).on("click", ".btn-insert-mastercard", function(e) {
        e.preventDefault();
        mc_id = $(this).closest(".modal-mastercard-list").find('.mastercard_id').val();
        
        var url = "{{ route('mastercard.show', ':id') }}"
        url = url.replace(':id', mc_id);

        $.get(url, function(data) {
            document.getElementById('mcid').value = data.mc.id;
            document.getElementById('namamc').value = data.mc.kode + '-' + data.mc.revisi;
            document.getElementById('namaBarang').value = data.mc.namaBarang;
            document.getElementById('tipeBox').value = data.mc.tipeBox;
            document.getElementById('flute').value = data.mc.flute;
            document.getElementById('kualitas').value = data.mc.substance_kontrak.kode;
            document.getElementById('gram').value = data.mc.gramSheetBoxKontrak2;
            document.getElementById('warna').value = data.mc.color_combine.kode;
            document.getElementById('keterangan').value = data.mc.keterangan;

            $('#modal-mastercard').modal('hide');
        });
        
    });

    $(document).on("keyup", ".qty", function(e) {
        qty = $(this).val();
        gramatur = document.getElementById('gram').value;
        harga = document.getElementById("harga").value;
        ppn = document.getElementById("ppn").value;

        kg = parseInt(qty) * parseFloat(gramatur);

        document.getElementById('qtyKg').value = kg.toFixed(2);

        if (harga != '' || harga != 0) {
            hargakg = parseInt(qty) * parseFloat(harga) / kg;
            
            if (ppn != '') {
                total = (parseInt(qty) * parseFloat(harga)) + (parseInt(qty) * parseFloat(harga) * ppn / 100);
            } else {
                total = (parseInt(qty) * parseFloat(harga)) ;
            } 
        }

        document.getElementById('total').value = total;
        document.getElementById('hargakg').value = hargakg.toFixed(2);

    });

    $(document).on("keyup", ".toleransi-lebih", function(e) {
        toleransi = $(this).val();
        qty = document.getElementById("qtyPcs").value;
        qtyKg = document.getElementById("qtyKg").value;

        pcs = parseInt(qty) * parseInt(toleransi) / 100 ;
        kg = parseInt(qtyKg) * parseInt(toleransi) / 100 ;

        document.getElementById("toleransiLebihPcs").value = pcs.toFixed(0);
        document.getElementById("toleransiLebihKg").value = kg.toFixed(2);
    });

    $(document).on("keyup", ".toleransi-kurang", function(e) {
        toleransi = $(this).val();
        qty = document.getElementById("qtyPcs").value;
        qtyKg = document.getElementById("qtyKg").value;

        pcs = parseInt(qty) * parseInt(toleransi) / 100 ;
        kg = parseInt(qtyKg) * parseInt(toleransi) / 100 ;

        document.getElementById("toleransiKurangPcs").value = pcs.toFixed(0);
        document.getElementById("toleransiKurangKg").value = kg.toFixed(2);
    });

    $(document).on("keyup", ".harga", function(e) {
        harga = $(this).val();
        qty = document.getElementById("qtyPcs").value;
        kg = document.getElementById("gram").value;
        ppn = document.getElementById("ppn").value;

        total = parseFloat(harga) * parseInt(qty);
        hargakg = parseFloat(harga) / parseFloat(kg);
        hargappn = parseFloat(total) * parseInt(ppn) / 100;


        document.getElementById("hargappn").value = hargappn.toFixed(2);
        document.getElementById("total").value = total.toFixed(0);
        document.getElementById("hargakg").value = hargakg.toFixed(2);
    });

    $(document).on("keyup", ".ppn", function(e) {
        ppn = $(this).val();
        total = document.getElementById("total").value;

        if (total != 0 || total != null) {
            hargappn = parseFloat(total) * parseInt(ppn) / 100;
        } else {
            hargappn = 0;
        }

        document.getElementById("hargappn").value = hargappn.toFixed(2);
    });
                            
                        
</script>

@endsection 