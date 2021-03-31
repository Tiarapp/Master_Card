@extends('admin.templates.partials.default')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<style>
    .select2 {
        width: 206px !important;
    }
</style>


@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row" id="form_list_mc">
            <div class="col-md-12">
                <h4 class="modal-title">Kontrak</h4>
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
                
                <form action="{{ route('kontrak.store') }}"  method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Pilih Customer</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line col-md-11" name="namaCust" id="namaCust" onchange="getGramKontrak()" readonly>
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
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Alamat Kirim</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="alamatKirim" id="alamatKirim">
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
                                        <input type="text" class="form-control txt_line" name="telp" id="telp">
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
                                                                foreach ($mc as $data) { ?>
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
                </div>    
            </div>
            
            @endsection
            
            @section('javascripts')
            
            <script type="text/javascript">
                $(document).ready(function() {
                    $('.js-example-basic-single').select2();
                });
                
                $(".Mastercard").ready(function(){
                    
                    var table = $("#data_mastercard").DataTable({
                        select: true,
                        scrollX: "200px",
                    });
                    
                    $('#data_mastercard tbody').on( 'click', 'td', function () {
                        var mc = (table.row(this).data());
                        
                        
                        document.getElementById('mcid').value = mc[0];
                        document.getElementById('namaItem').value = mc[2];
                        document.getElementById('nomc').value = mc[1];

                        substance = mc[7].split(" ");
                        document.getElementById('kualitas').value = substance[1];

                        document.getElementById('warna').value = mc[10];
                        document.getElementById('ukuran').value = mc[8] +' x '+ mc[9] +' x 1';
                        document.getElementById('flute').value = mc[4];
                        
                        document.getElementById('bentuk').value = mc[3];
                        document.getElementById('packing').value = mc[11];
                        document.getElementById('wax').value = mc[6];
                        document.getElementById('tipeCrease').value = mc[13];
                        document.getElementById('joint').value = mc[5];
                        document.getElementById('bungkus').value = mc[7];

                        document.getElementById('beratBox').value = mc[14];
                    } );
                } );

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
                
                function getToleransiLebih() {
                    var jumlahOrder = document.getElementById('jmlOrder').value;
                    var persen = document.getElementById('toleransiLebihPersen').value;
                    var totalBerat = document.getElementById('beratTotal').value;
                    
                    var hasilpcs = jumlahOrder * (persen/100);
                    var hasilkg = totalBerat * (persen/100);

                    document.getElementById('toleransiLebihPcs').value = hasilpcs;
                    document.getElementById('toleransiLebihKg').value = hasilkg;
                }

                function getToleransiKurang() {
                    var jumlahOrder = document.getElementById('jmlOrder').value;
                    var persen = document.getElementById('toleransiKurangPersen').value;
                    var totalBerat = document.getElementById('beratTotal').value;
                    
                    var hasilpcs = jumlahOrder * (persen/100);
                    var hasilkg = totalBerat *(persen/100);

                    document.getElementById('toleransiKurangPcs').value = hasilpcs;
                    document.getElementById('toleransiKurangKg').value = hasilkg;
                }

                function getHarga(){
                    var jumlahOrder = document.getElementById('jmlOrder').value;
                    var hargaSatuan = document.getElementById('hargaSatuan').value;
                    var tax = document.getElementById('tax').value / 100;
                    var gram = document.getElementById('beratBox').value;

                    var totalSblTax = jumlahOrder * hargaSatuan;
                    var totalSdhTax = totalSblTax - (totalSblTax * tax);
                    var berattotal = jumlahOrder * gram;
                    
                    document.getElementById('hargaBlmTax').value = totalSblTax;
                    document.getElementById('totalHarga').value = totalSdhTax;
                    document.getElementById('beratTotal').value = berattotal;

                }
                
                // function getCatatan() {
                //     var catatan1 = document.getElementById("catatan1").value;
                //     var nosj = document.getElementById("nosj").value;
                    
                //     document.getElementById("catatan").value = catatan1 +nosj;
                // }
                
                function getData() {
                    var data1 = document.getElementById("nama_1").value;
                    var data2 = document.getElementById("nama_2").value;
                    var data3 = document.getElementById("nama_3").value;
                    var data4 = document.getElementById("nama_4").value;
                    var data5 = document.getElementById("nama_5").value;
                    
                    if (data1 != '') {
                        var arr1 = data1.split('|');
                        var idmc = arr1[0];
                        var beratBox = arr1[1];
                        var qty = document.getElementById('qtyPcs[1]').value;
                        var toleransipct = document.getElementById('toleransi[1]').value;
                        var totalKg = qty * beratBox;
                        var toleransipcs =  qty * (toleransipct/100) ;
                        var toleransikg = totalKg * (toleransipct/100);

                        document.getElementById("qtyKg[1]").value = totalKg;
                        document.getElementById("pcsToleransi[1]").value = toleransipcs;
                        document.getElementById("kgToleransi[1]").value = toleransikg;
                        document.getElementById("idmcpel[1]").value = idmc;

                    } 
                    if (data2 != '') {
                        var arr2 = data2.split('|');
                        var idmc = arr2[0];
                        var beratBox = arr2[1];
                        var qty = document.getElementById('qtyPcs[2]').value;
                        var toleransipct = document.getElementById('toleransi[2]').value;
                        var totalKg = qty * beratBox;
                        var toleransipcs =  qty * (toleransipct/100) ;
                        var toleransikg = totalKg * (toleransipct/100);

                        document.getElementById("qtyKg[2]").value = totalKg;
                        document.getElementById("pcsToleransi[2]").value = toleransipcs;
                        document.getElementById("kgToleransi[2]").value = toleransikg;
                        document.getElementById("idmcpel[2]").value = idmc;
                    } 
                    if (data3 != '') {
                        var arr3 = data3.split('|');
                        var idmc = arr3[0];
                        var beratBox = arr3[1];
                        var qty = document.getElementById('qtyPcs[3]').value;
                        var toleransipct = document.getElementById('toleransi[3]').value;
                        var totalKg = qty * beratBox;
                        var toleransipcs =  qty * (toleransipct/100) ;
                        var toleransikg = totalKg * (toleransipct/100);

                        document.getElementById("qtyKg[3]").value = totalKg;
                        document.getElementById("pcsToleransi[3]").value = toleransipcs;
                        document.getElementById("kgToleransi[3]").value = toleransikg;
                        document.getElementById("idmcpel[3]").value = idmc;
                    }
                    if (data4 != '') {
                        var arr4 = data4.split('|');
                        var idmc = arr4[0];
                        var beratBox = arr4[1];
                        var qty = document.getElementById('qtyPcs[4]').value;
                        var toleransipct = document.getElementById('toleransi[4]').value;
                        var totalKg = qty * beratBox;
                        var toleransipcs =  qty * (toleransipct/100) ;
                        var toleransikg = totalKg * (toleransipct/100);

                        document.getElementById("qtyKg[4]").value = totalKg;
                        document.getElementById("pcsToleransi[4]").value = toleransipcs;
                        document.getElementById("kgToleransi[4]").value = toleransikg;
                        document.getElementById("idmcpel[4]").value = idmc;                      
                    }
                    if (data5 != '') {
                        var arr5 = data5.split('|');
                        var idmc = arr5[0];
                        var beratBox = arr5[1];
                        var qty = document.getElementById('qtyPcs[5]').value;
                        var toleransipct = document.getElementById('toleransi[5]').value;
                        var totalKg = qty * beratBox;
                        var toleransipcs =  qty * (toleransipct/100);
                        var toleransikg = totalKg * (toleransipct/100);

                        document.getElementById("qtyKg[5]").value = totalKg;
                        document.getElementById("pcsToleransi[5]").value = toleransipcs;
                        document.getElementById("kgToleransi[5]").value = toleransikg;
                        document.getElementById("idmcpel[5]").value = idmc;
                    }
                    
                }
                
                
            </script>
            
            @endsection