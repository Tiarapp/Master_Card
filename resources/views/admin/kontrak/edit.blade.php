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
</style>


@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row" id="form_list_mc">
            <div class="col-md-12">
                <h4 class="modal-title">Surat Jalan Palet</h4>
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
                <form action="../update/{{ $kontrak_M->id }}" method="POST"  >
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Pilih Customer</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line col-md-11" value="{{ $kontrak_M->customer_name }}" name="namaCust" id="namaCust" onchange="getGramKontrak()" readonly>
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
                                                                foreach ($customer1 as $data) { ?>
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
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Alamat Kirim</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" value="{{ $kontrak_M->alamatKirim }}" name="alamatKirim" id="alamatKirim">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Telp</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" value="{{ $customer->Nama }}" name="telp" id="telp">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="border-bottom: 2px solid black">
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Tipe Order</label>
                                    </div>
                                    <div class="col-md-6">
                                        <select class='js-example-basic-single col-md-12' name='tipeOrder' id='tipeOrder' onchange>
                                            <option value="OB">Order Baru</option>
                                            <option value="OU">Order Ulang</option>
                                            <option value="OUP">Order Ulang Perubahan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 20px">
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Tanggal</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="date" class="form-control txt_line" name="tanggal" id="tanggal">
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-md-5">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>No. Surat Jalan</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="noSuratJalan" id="noSuratJalan">
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Pilih MC Box</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line col-md-11" name="nomc" id="nomc" onchange readonly>
                                    </div>
                                    
                                    <!-- Modal -->
                                    <div class="modal fade" id="Mastercard">
                                        <div class="modal-dialog modal-xl">
                                            
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Mastercard Box</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body Mastercard">
                                                    <div class="card-body">
                                                        <table class="table table-bordered" id="data_mastercard">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">id</th>
                                                                    <th scope="col">Kode MC</th>
                                                                    <th scope="col">Nama Box</th>
                                                                    <th scope="col">Tipe Box</th>
                                                                    <th scope="col">Flute</th>
                                                                    <th scope="col">Joint</th>
                                                                    <th scope="col">Wax</th>
                                                                    <th scope="col">Substance</th>
                                                                    <th scope="col">Panjang Box</th>
                                                                    <th scope="col">Lebar Box</th>
                                                                    <th scope="col">Warna</th>
                                                                    <th scope="col">Packing</th>
                                                                    <th scope="col">box</th>
                                                                    <th scope="col">Tipe Crease</th>
                                                                    <th scope="col">Berat</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php 
                                                                foreach ($mastercard1 as $data) { ?>
                                                                    <tr>
                                                                        <td scope="row">{{ $data->id }}</td>
                                                                        <td>{{ $data->kode }}</td>
                                                                        <td>{{ $data->namaBarang }}</td>
                                                                        <td>{{ $data->tipeBox }}</td>
                                                                        <td>{{ $data->flute }}</td>
                                                                        <td>{{ $data->joint }}</td>
                                                                        <td>{{ $data->wax }}</td>
                                                                        <td>{{ $data->substance }}</td>
                                                                        <td>{{ $data->panjangSheetBox }}</td>
                                                                        <td>{{ $data->lebarSheetBox }}</td>
                                                                        <td>{{ $data->warna }}</td>
                                                                        <td>{{ $data->koli }}</td>
                                                                        <td>{{ $data->box_id }}</td>
                                                                        <td>{{ $data->tipeCrease }}</td>
                                                                        <td>{{ $data->gramSheetCorrKontrak }}</td>
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
                                    <button type="button" data-toggle="modal" data-target="#Mastercard">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Nama Item</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="hidden" name="mcid" id="mcid">
                                        <!-- <input type="hidden" name="beratBox" id="beratBox"> -->
                                        <input type="text" class="form-control txt_line" name="namaItem" id="namaItem">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Kualitas</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="kualitas" id="kualitas">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Warna</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="warna" id="warna">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Ukuran</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="ukuran" id="ukuran">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Berat (gram)</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="beratBox" id="beratBox">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Flute</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="flute" id="flute">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Type Box</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="bentuk" id="bentuk">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Packing</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="packing" id="packing">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Jumlah Order</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="jmlOrder" id="jmlOrder">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Harga (Pcs/Kg)</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="hargaSatuan" id="hargaSatuan" onchange="getHarga();">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Tax (%)</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="tax" id="tax" onchange="getHarga();">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Harga Belum Tax</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="hargaBlmTax" id="hargaBlmTax">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Berat Total</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="beratTotal" id="beratTotal">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Toleransi Lebih(%)</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="toleransiLebihPersen" id="toleransiLebihPersen" onchange="getToleransiLebih()">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Toleransi Lebih(pcs)</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="toleransiLebihPcs" id="toleransiLebihPcs">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Toleransi Lebih(kg)</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="toleransiLebihKg" id="toleransiLebihKg">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Toleransi Kurang(%)</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="toleransiKurangPersen" id="toleransiKurangPersen" onchange="getToleransiKurang()">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Toleransi Kurang(pcs)</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="toleransiKurangPcs" id="toleransiKurangPcs">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Toleransi Kurang(kg)</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="toleransiKurangKg" id="toleransiKurangKg">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Sales</label>
                                    </div>
                                    <div class="col-md-6">
                                        <select class='js-example-basic-single col-md-12' name="sales" id="sales">
                                            @foreach ($sales as $data)
                                                <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Term of Payment</label>
                                    </div>
                                    <div class="col-md-6">
                                        <select class='js-example-basic-single col-md-12' name="top_id" id="top_id">
                                            @foreach ($top as $data)
                                                <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Cara Kirim</label>
                                    </div>
                                    <div class="col-md-6">
                                        <select class='js-example-basic-single col-md-12' name="caraKirim" id="caraKirim">
                                            <option value="Kirim">Kirim</option>
                                            <option value="Ambil Sendiri">Ambil Sendiri</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Wax</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="wax" id="wax">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Tipe Crease</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="tipeCrease" id="tipeCrease">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Join</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="joint" id="joint">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Bungkus</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="bungkus" id="bungkus">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Tipe Harga</label>
                                    </div>
                                    <div class="col-md-6">
                                        <select class='js-example-basic-single col-md-12' name="tipe_harga" id="tipe_harga">
                                            <option value="PCS">PCS</option>
                                            <option value="KG">KG</option>
                                        </select>  
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Total Harga</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" id="totalHarga" name="totalHarga">  
                                    </div>
                                </div>
                            </div>

                        </div>
                    
                    <table class="table table-bordered" id="">
                        <thead>
                            <tr>
                                <th scope="col">Nama</th>
                                <th scope="col">Qty(Pcs)</th>
                                <th scope="col">Toleransi(%)</th>
                                <th scope="col">Qty(Kg)</th>
                                <th scope="col">Toleransi Pcs</th>
                                <th scope="col">Toleransi Kg</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $counts = 5;
                            
                            for ($i=1; $i<=$counts; $i++) { 
                                
                                echo "<tr>";
                                    echo    "<td>";
                                        echo   "<select class='js-example-basic-single col-md-12' name='nama_$i' id='nama_$i'>";
                                            echo   "<option value=''>---</option>";
                                            foreach ($mcpel as $data) {
                                                echo "<option value='$data->id|$data->gramSheetBoxKontrak'>$data->kode|$data->panjangSheetBox x $data->lebarSheetBox x 1</option>";
                                            }
                                            echo "</select>";
                                            echo "</td>";
                                            echo "<td><input type='text' name='qtyPcs[$i]' id='qtyPcs[$i]'></td>";
                                            echo "<td><input type='text' name='toleransi[$i]' id='toleransi[$i]' onchange='getData();'></td>";
                                            echo "<td><input type='text' name='qtyKg[$i]' id='qtyKg[$i]' readonly></td>";
                                            echo "<td><input type='text' name='pcsToleransi[$i]' id='pcsToleransi[$i]' readonly></td>";
                                            echo "<td><input type='text' name='kgToleransi[$i]' id='kgToleransi[$i]' readonly></td>";
                                            echo "</tr>";
                                            echo "<input type='hidden' name='idmcpel[$i]' id='idmcpel[$i]' readonly>";
                                        }
                                        ?>
                                        
                                    </tbody>
                                </table>
                                <input type="hidden" class="form-control txt_line" name="createdBy" id="createdBy" value="{{ Auth::user()->name }}">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php 
                    for ($i=0; $i < $count; $i++) {
                        echo '<input type="text" name="idkontrak_d['.$i.']" id="idkontrak_d['.$i.']" value="'.$kontrak_D[$i]->id.'" readonly >' ;
                        echo '<input type="text" name="idmcpel['.$i.']" id="idmcpel['.$i.']" value="'.$kontrak_D[$i]->mc_id.'" readonly >' ;
                        echo '<input type="text" name="qtyPcs['.$i.']" id="qtyPcs['.$i.']" value="'.$kontrak_D[$i]->pcsPelengkapKontrak.'" readonly >' ;
                        echo '<input type="text" name="qtykg['.$i.']" id="qtykg['.$i.']" value="'.$kontrak_D[$i]->kgPelengkapKontrak.'" readonly >' ;
                        echo '<input type="text" name="toleransi['.$i.']" id="toleransi['.$i.']" value="'.$kontrak_D[$i]->pctToleransiPelengkapKontrak.'" readonly >' ;
                        echo '<input type="text" name="pcstoleransi['.$i.']" id="pcstoleransi['.$i.']" value="'.$kontrak_D[$i]->pcsToleransiPelengkapKontrak.'" readonly >' ;
                        echo '<input type="text" name="kgtoleransi['.$i.']" id="kgtoleransi['.$i.']" value="'.$kontrak_D[$i]->kgToleransiPelengkapKontrak.'" readonly >' ;
                    }
                    ?>
                    <table class="table table-bordered" id="">
                        <thead>
                            <tr>
                                <th scope="col">Nama</th>
                                <th scope="col">Ukuran</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            
                            <?php 
                            $counts = 5;    
                            
                            $j=0;                        
                            for ($i=0; $i<$counts; $i++) { 
                                
                                // dd(isset($sj_Palet_D[$i]));
                                
                                if (isset($sj_Palet_D[$i]) !== false) {
                                    # code...
                                    echo "<tr>";
                                        echo    "<td>";
                                            echo   "<select class='js-example-basic-single col-md-12' name='nama_$i' id='nama_$i' onchange='getData();'>";
                                                echo   "<option value= >". $sj_Palet_D[$i]->namaBarang ."|". $sj_Palet_D[$i]->ukuran ."</option>";
                                                
                                                foreach ($palet as $data) {
                                                    echo "<option value='$data->id|$data->nama|$data->ukuran'>$data->nama|$data->ukuran</option>";
                                                }
                                                echo "</select>";
                                                echo "</td>";
                                                echo "<td><input type='text' name='ukuran[$i]' id='ukuran[$i]' readonly></td>";
                                                echo "<td><input type='text' name='qty[$i]' id='qty[$i]'></td>";
                                                echo "<td><input type='text' name='keterangan[$i]' id='keterangan[$i]'></td>";
                                                echo "</tr>";
                                                echo "<input type='hidden' name='idpalet[$i]' id='idpalet[$i]' readonly>";
                                                echo "<input type='hidden' name='nama[$i]' id='nama[$i]' readonly>";
                                                echo "<input type='hidden' name='detail[$i]' id='detail[$i]' readonly>";
                                            } else 
                                            {
                                                echo "<tr>";
                                                    echo    "<td>";
                                                        echo   "<select class='js-example-basic-single col-md-12' name='nama_$i' id='nama_$i' onchange='getData();'>";
                                                            echo   "<option value= >---</option>";
                                                            
                                                            foreach ($palet as $data) {
                                                                echo "<option value='$data->id|$data->nama|$data->ukuran'>$data->nama|$data->ukuran</option>";
                                                            }
                                                            echo "</select>";
                                                            echo "</td>";
                                                            echo "<td><input type='text' name='ukuran[$i]' id='ukuran[$i]' readonly></td>";
                                                            echo "<td><input type='text' name='qty[$i]' id='qty[$i]'></td>";
                                                            echo "<td><input type='text' name='keterangan[$i]' id='keterangan[$i]'></td>";
                                                            echo "</tr>";
                                                            echo "<input type='hidden' name='idpalet[$i]' id='idpalet[$i]' readonly>";
                                                            echo "<input type='hidden' name='nama[$i]' id='nama[$i]' readonly>";
                                                        }   
                                                    }
                                                    ?>
                                                    
                                                    {{-- @foreach ($sj_Palet_D as $data)
                                                        <td> <input type="text" name="nama[]" id="nama" value="{{ $data[0] }}"> </td>
                                                        <td> <input type="text" name="nama" id="nama" value="{{ $data->ukuran }}"> </td>
                                                        <td> <input type="text" name="nama" id="nama" value="{{ $data->qty }}"> </td>
                                                        <td> <input type="text" name="nama" id="nama" value="{{ $data->keterangan }}"> </td>
                                                        @endforeach --}}
                                                    </tbody>
                                                </table>
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
                                
                                function getCustomer() {
                                    var data = document.getElementById('listCust').value;
                                    
                                    var cust = data.split('|');
                                    var custNama = cust[0];
                                    var custAlamat = cust[1];
                                    
                                    document.getElementById('namaCustomer').value = custNama;
                                    document.getElementById('alamatCustomer').value = custAlamat;
                                }                                
                                function getDefaultData() {
                                    
                                    for (let index = 0; index < 5; index++) {
                                        // var iddet = document.getElementById("idpaletdata["+index+"]").value;
                                        
                                        // console.log(iddet)
                                        
                                        if (document.getElementById("idpaletdata["+index+"]") != null) {
                                            // console.log(document.getElementById("idpaletdata["+index+"]").value);
                                            var iddet = document.getElementById("iddetail["+index+"]").value;
                                            var idpalet = document.getElementById("idpaletdata["+index+"]").value;
                                            var namaBarang = document.getElementById("qty["+index+"]").value;
                                            var ukuran = document.getElementById("ukurandata["+index+"]").value;
                                            var qty = document.getElementById("qtydata["+index+"]").value;
                                            var keterangan = document.getElementById("ketdata["+index+"]").value;
                                            
                                            // console.log(iddet);
                                            document.getElementById("detail["+ index +"]").value = iddet;
                                            document.getElementById("idpalet["+ index +"]").value = idpalet;
                                            document.getElementById("nama["+ index +"]").value = namaBarang;
                                            document.getElementById("ukuran["+ index +"]").value = ukuran;
                                            document.getElementById("qty["+ index +"]").value = qty;
                                            document.getElementById("keterangan["+ index +"]").value = keterangan;
                                        }                                        
                                    }
                                }
                                
                                function getData() {
                                    var data1 = document.getElementById("nama_0").value;
                                    var data2 = document.getElementById("nama_1").value;
                                    var data3 = document.getElementById("nama_2").value;
                                    var data4 = document.getElementById("nama_3").value;
                                    var data5 = document.getElementById("nama_4").value;
                                    
                                    if (data1 != '') {
                                        var arr1 = data1.split('|');
                                        var idpalet1 = arr1[0];
                                        var nama1 = arr1[1];
                                        var ukuran1 = arr1[2]; 
                                        document.getElementById("idpalet[0]").value = idpalet1;
                                        document.getElementById("nama[0]").value = nama1;
                                        document.getElementById("ukuran[0]").value = ukuran1;
                                    } 
                                    if (data2 != '') {
                                        var arr2 = data2.split('|');
                                        var idpalet2 = arr2[0];
                                        var nama2 = arr2[1];
                                        var ukuran2 = arr2[2]; 
                                        document.getElementById("idpalet[1]").value = idpalet2;
                                        document.getElementById("nama[1]").value = nama2;
                                        document.getElementById("ukuran[1]").value = ukuran2;
                                    } 
                                    if (data3 != '') {
                                        var arr3 = data3.split('|');
                                        var idpalet3 = arr3[0];
                                        var nama3 = arr3[1];
                                        var ukuran3 = arr3[2]; 
                                        document.getElementById("idpalet[2]").value = idpalet3;
                                        document.getElementById("nama[2]").value = nama3;
                                        document.getElementById("ukuran[2]").value = ukuran3;
                                    }
                                    if (data4 != '') {
                                        var arr4 = data4.split('|');
                                        var idpalet4 = arr4[0];
                                        var nama4 = arr4[1];
                                        var ukuran4 = arr4[2]; 
                                        document.getElementById("idpalet[3]").value = idpalet4;
                                        document.getElementById("nama[3]").value = nama4;
                                        document.getElementById("ukuran[3]").value = ukuran4;                   
                                    }
                                    if (data5 != '') {
                                        var arr5 = data5.split('|');
                                        var idpalet5 = arr5[0];
                                        var nama5 = arr5[1];
                                        var ukuran5 = arr5[2]; 
                                        document.getElementById("idpalet[4]").value = idpalet5;
                                        document.getElementById("nama[4]").value = nama5;
                                        document.getElementById("ukuran[4]").value = ukuran5;
                                    }
                                    
                                }
                                
                                
                            </script>
                            
                            @endsection 