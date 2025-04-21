@extends('admin.templates.partials.default')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<style>
    .select2 {
        width: 206px !important;
    }
    
    tr:nth-child(odd) {
        background-color:#bab9b9 !important;
        
    }
    .bg {
        background-color: rgba(255, 255, 255, 0.733) !important; 
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
                                                
                                                <!-- Modal -->
                                                <div class="modal fade" id="Customer">
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
                                                <button type="button" data-toggle="modal" data-target="#Customer">
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
                                            <div class="modal fade" id="Mastercard">
                                                <div class="modal-dialog modal-xl">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title mastercard">Mastercard</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body Mastercard">
                                                            <div class="card-body">
                                                                <table class="table table-bordered" id="data_mc">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">ID</th>
                                                                            <th scope="col">No MC</th>
                                                                            <th scope="col">Nama Barang</th>
                                                                            <th scope="col">Tipe Box</th>
                                                                            <th scope="col">Flute</th>
                                                                            <th scope="col">Kualitas</th>
                                                                            <th scope="col">Gram</th>
                                                                            <th scope="col">Warna</th>
                                                                            <th scope="col">Keterangan</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        $no = 1;
                                                                        foreach ($mc as $data) { 
                                                                            if ($data->revisi == 'R0' || $data->revisi == '') {
                                                                                $result = $data->kode;
                                                                            } else {
                                                                                $result = $data->kode.'-'.$data->revisi;
                                                                            }
                                                                            ?>
                                                                            <tr>
                                                                                <td scope="row">{{ $data->id }}</td>
                                                                                <td>{{ $result }}</td>
                                                                                <td>{{ $data->box }}</td>
                                                                                <td>{{ $data->tipeBox }}</td>
                                                                                <td>{{ $data->flute }}</td>
                                                                                <td>{{ $data->substance }}</td>
                                                                                <td>{{ $data->gramSheetBoxKontrak2 }}</td>
                                                                                <td>{{ $data->warna }}</td>
                                                                                <td>{{ $data->keterangan }}</td>
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
                                            
                                            <button type="button" data-toggle="modal" data-target="#Mastercard">
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

    $("#detail_kontrak").DataTable({
        "paging":   false,
        "ordering": false,
        "info":     false,
        "searching": false,
        // "scrollX": true,
        // "autoWidth": true, 
        "initComplete": function (settings, json) {  
            $("#detail_kontrak").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
        },
        // "scrollY": "400px",
        select: true,
    });

    $(".Customer").ready(function(){
                
        var table = $("#data_customer").DataTable({
            select: true,
        });
        
        $('#data_customer tbody').on( 'click', 'td', function () {
            var cust = (table.row(this).data());

            cust_name = cust[1]
            name = cust_name.replace('&amp;', '&')

            document.getElementById('namaCust').value = name;
            document.getElementById('alamatKirim').value = cust[5];
            document.getElementById('telp').value = cust[3];
        } );
    } );

    $(".mastercard").ready(function(){
                
                var table = $("#data_mc").DataTable({
                    select: true,
                });
                
                $('#data_mc tbody').on( 'click', 'td', function () {
                    var mc = (table.row(this).data());
                    
                    document.getElementById('mcid').value = mc[0];
                    document.getElementById('namamc').value = mc[1];
                    document.getElementById('namaBarang').value = mc[2];
                    document.getElementById('tipeBox').value = mc[3];
                    document.getElementById('flute').value = mc[4];
                    document.getElementById('kualitas').value = mc[5];
                    document.getElementById('gram').value = mc[6];
                    document.getElementById('warna').value = mc[7];
                    document.getElementById('keterangan').value = mc[8];
                    document.getElementById('qtyPcs').value = 0;
                    document.getElementById('qtyKg').value = 0;
                    document.getElementById('hargakg').value = 0;
                    document.getElementById('harga').value = 0;
                    document.getElementById('toleransiLebih').value = 0;
                    document.getElementById('toleransiKurang').value = 0;
                    document.getElementById('toleransiLebihPcs').value = 0;
                    document.getElementById('toleransiLebihKg').value = 0;
                    document.getElementById('toleransiKurangPcs').value = 0;
                    document.getElementById('toleransiKurangKg').value = 0;
                    document.getElementById('hargappn').value = 0;
                    document.getElementById('total').value = 0;
                    
                    // getGramKontrak();
                } );
            } );

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