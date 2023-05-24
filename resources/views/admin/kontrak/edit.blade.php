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
                <form action="../update/{{ $kontrak_M->id }}" method="POST"  >
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

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
                                                    <label>Tanggal</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="date" class="form-control txt_line" name="tanggal" id="tanggal" value="{{ $kontrak_M->tglKontrak }}">
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
                                                    <label>Telp</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control txt_line" name="telp" id="telp" value="{{ $kontrak_M->custTelp }}">
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
                                                    <input type="text" name="komisi" id="komisi" value="{{ $kontrak_M->komisi }}">
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
                                                        <option value="{{ $kontrak_M->top }}">{{ $kontrak_M->top }}</option>
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
                                                        <option value="{{ $kontrak_M->sales }}">{{ $kontrak_M->sales }}</option>
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
                                                    <label>Pilih Customer</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control txt_line col-md-11" name="namaCust" id="namaCust" value="{{ $kontrak_M->customer_name }}" readonly>
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
                                                    <label>PO Customer</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control txt_line" value="{{ $kontrak_M->poCustomer }}" name="poCustomer" id="poCustomer">
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
                                                        <option value="{{ $kontrak_M->tipeOrder }}">{{ $kontrak_M->tipeOrder }}</option>
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
                                                    <select class='js-example-basic-single col-md-12' name="caraKirim" id="caraKirim">
                                                        <option value="{{ $kontrak_M->caraKirim }}">{{ $kontrak_M->caraKirim }}</option>
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
                                                    <input type="date" class="form-control txt_line" name="tglkirim" id="tglkirim" value="{{ $kontrak_M->min_tgl_kirim }}">
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
                                                    <textarea name="alamatKirim" id="alamatKirim" cols="30" rows="4" value="">{{ $kontrak_M->alamatKirim }}</textarea>
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
                                                    <textarea name="keterangan" id="keterangan" cols="30" rows="4" value="">{{ $kontrak_M->keterangan }}</textarea>
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
                                                <input type="number" name="biaya_exp" id="biaya_exp" value="{{ $kontrak_M->biaya_exp }}">
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
                                                    <input type="number" name="biaya_glue" id="biaya_glue" value="{{ $kontrak_M->biaya_glue }}">
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
                                                    <input type="number" name="biaya_wax" id="biaya_wax" value="{{ $kontrak_M->biaya_wax }}">
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
                                                <input type="hidden" name="kontrakd_id" id="kontrakd_id" value="{{ $kontrak_D->id }}">
                                                <input type="text" class="form-control txt_line col-md-11" name="namamc" id="namamc" value="{{ $kontrak_D->mc }}" readonly>
                                                <input type="hidden" class="form-control txt_line col-md-11" name="mcid" id="mcid" value="{{ $kontrak_D->mc_id }}" readonly>
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
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        $no = 1;
                                                                        foreach ($mc as $data) { 
                                                                            if ($data->revisi == 'R0') {
                                                                                $mc = $data->kode.'-'.$data->revisi;
                                                                            } else {
                                                                                $mc = $data->kode;
                                                                            }
                                                                            ?>
                                                                            <tr>
                                                                                <td scope="row">{{ $data->id }}</td>
                                                                                <td>{{ $mc }}</td>
                                                                                <td>{{ $data->box }}</td>
                                                                                <td>{{ $data->tipeBox }}</td>
                                                                                <td>{{ $data->flute }}</td>
                                                                                <td>{{ $data->substance }}</td>
                                                                                <td>{{ $data->gramSheetBoxKontrak2 }}</td>
                                                                                <td>{{ $data->warna }}</td>
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
                                                        <input type="text" class="form-control txt_line col-md-11" name="flute" id="flute" value="{{ $kontrak_D->flute }}" readonly>
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
                                                        <input type="text" class="form-control txt_line col-md-11" name="warna" id="warna" value="{{ $kontrak_D->warna }}" readonly>
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
                                                <textarea name="namaBarang" id="namaBarang" cols="30" rows="3">{{ $kontrak_D->box }}</textarea>
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
                                                <input type="text" class="form-control txt_line col-md-11" name="gram" id="gram" value="{{ $kontrak_D->gram }}" readonly>
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
                                                <input type="text" class="form-control txt_line col-md-11" name="tipeBox" id="tipeBox" value="{{ $kontrak_D->tipeBox }}" readonly>
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
                                                <input type="text" class="form-control txt_line col-md-11" name="kualitas" id="kualitas" value="{{ $kontrak_D->substance }}" readonly>
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
                                                <input type="text" class="form-control txt_line col-md-11 qty" name="qtyPcs" id="qtyPcs" value="{{ $kontrak_D->pcsKontrak }}">
                                            </div>
                                            <div class="col-md-1">
                                                <label>Pcs</label>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control txt_line col-md-11" name="qtyKg" id="qtyKg" value="{{ $kontrak_D->kgKontrak }}" readonly>
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
                                                <input type="text" class="form-control txt_line col-md-11 toleransi-lebih" name="toleransiLebih" id="toleransiLebih" value="{{ $kontrak_D->pctToleransiLebihKontrak }}" >
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control txt_line col-md-11 toleransi-kurang" name="toleransiKurang" id="toleransiKurang" value="{{ $kontrak_D->pctToleransiKurangKontrak }}" >
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
                                                <label>PPN</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control txt_line col-md-11 ppn" name="ppn" id="ppn" value="{{ $kontrak_D->ppn }}">
                                            </div>
                                            <div class="col-md-1">
                                                <label>%</label>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control txt_line col-md-11" name="hargappn" id="hargappn" value="{{ $kontrak_D->tax }}" readonly>
                                            </div>
                                            <div class="col-md-1">
                                                <label></label>
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
                                                <label>Harga pcs</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control txt_line col-md-11 harga" name="harga" id="harga" value="{{ $kontrak_D->harga_pcs }}" onchange="getData();">
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
                                                <input type="text" class="form-control txt_line col-md-11" name="toleransiLebihPcs" id="toleransiLebihPcs" value="{{ $kontrak_D->pcsLebihToleransiKontrak }}" readonly>
                                            </div>
                                            <div class="col-md-1">
                                                <label>pcs</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control txt_line col-md-11" name="toleransiLebihKg" id="toleransiLebihKg" value="{{ $kontrak_D->kgLebihToleransiKontrak }}" readonly>
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
                                                <input type="text" class="form-control txt_line col-md-11" name="total" id="total" value="{{ $kontrak_D->amountTotal }}" readonly>
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
                                                <input type="text" class="form-control txt_line col-md-11" name="hargakg" id="hargakg" value="{{ $kontrak_D->harga_kg }}" >
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
                                                <input type="text" class="form-control txt_line col-md-11" name="toleransiKurangPcs" id="toleransiKurangPcs" value="{{ $kontrak_D->pcsKurangToleransiKontrak }}" readonly>
                                            </div>
                                            <div class="col-md-1">
                                                <label>pcs</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control txt_line col-md-11" name="toleransiKurangKg" id="toleransiKurangKg" value="{{ $kontrak_D->pcsKurangToleransiKontrak }}" readonly>
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
            
            // document.getElementById('customer_id').value = cust[0]    ;
            document.getElementById('namaCust').value = cust[1];
            document.getElementById('alamatKirim').value = cust[5];
            document.getElementById('telp').value = cust[3];
            // document.getElementById('fax').value = cust[4];
            
            // getGramKontrak();
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
        kg = document.getElementById("qtyKg").value;

        total = parseFloat(harga) * parseInt(qty);
        hargakg = total / parseFloat(kg)

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