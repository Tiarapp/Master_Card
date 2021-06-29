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
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Tanggal</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="date" class="form-control txt_line" name="tanggal" id="tanggal" value="{{ $kontrak_M->tglKontrak }}" autofocus onfocusout="getData();">
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
                                                <label>Telp</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control txt_line" name="telp" id="telp" value="{{ $kontrak_M->custTelp }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="border-bottom: 2px solid black">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Tipe Order</label>
                                            </div>
                                            <div class="col-md-6">
                                                <select class='js-example-basic-single col-md-12' name='tipeOrder' id='tipeOrder' onchange>
                                                    <option value="{{ $kontrak_M->tipeOrder }}">{{ $kontrak_M->tipeOrder }}</option>
                                                    <option value="OB">Order Baru</option>
                                                    <option value="OU">Order Ulang</option>
                                                    <option value="OUP">Order Ulang Perubahan</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
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
                            <div class="row" style="border-bottom: 2px solid black">
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
                    <?php
                        for ($i=0; $i <5 ; $i++) { 
                            echo "<input type='text' name='idmcpel[$i]' id='idmcpel[$i]' readonly>";
                        }
                    ?>
                    <table class="table table-bordered" id="detail_kontrak">
                        <thead>
                            <tr>
                                <th scope="col">Nama</th>
                                <th scope="col">Substance</th>
                                <th scope="col">Qty(Pcs)</th>
                                <th scope="col">Toleransi Lebih(%)</th>
                                <th scope="col">Toleransi Kurang(%)</th>
                                <th scope="col">Harga</th>
                                <th scope="col">PPN (%)</th>
                                <th scope="col">Tipe MC</th>
                                <th scope="col">Toleransi Lebih Pcs</th>
                                <th scope="col">Toleransi Lebih Kg</th>
                                <th scope="col">Toleransi Kurang Pcs</th>
                                <th scope="col">Toleransi Kurang Kg</th>
                                <th scope="col">Harga Belum PPN</th>
                                <th scope="col">PPN (Rp)</th>
                                <th scope="col">Qty(Kg)</th>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            
                            <?php 
                            $counts = 5;    
                            
                            $j=0;                        
                            for ($i=0; $i<$counts; $i++) { 
                                
                                // dd(isset($kontrak_D[$i]));

                                
                                
                                if (isset($kontrak_D[$i]) !== false) {
                                    # code...

                                    // dd($kontrak_D[$i]->mc)
                                    echo "<input type='text' name='detail[$i]' id='detail[$i]' style='color: rgb(0, 0, 0)' value='".$kontrak_D[$i]->id."'readonly>";
                                    echo "<tr>";
                                    echo    "<td>";
                                    echo   "<select class='js-example-basic-single col-md-12' name='nama_$i' id='nama_$i'>";
                                        echo "<option value='".$kontrak_D[$i]->mcid."|".$kontrak_D[$i]->gram."|".$kontrak_D[$i]->substance."|".$kontrak_D[$i]->tipe."' >".$kontrak_D[$i]->mc."|".$kontrak_D[$i]->tipe."</option>";
                                        foreach ($mc as $data) {
                                            echo "<option value='$data->id|$data->gramSheetBoxKontrak|$data->substance|$data->tipeMc'>$data->kode|$data->tipeMc</option>";
                                        }
                                    echo "</select>";
                                    echo "</td>";
                                    echo "<td><input type='text' name='substance[$i]' id='substance[$i]' value='".$kontrak_D[$i]->substance."'></td>";
                                    echo "<td><input type='text' name='qtyPcs[$i]' id='qtyPcs[$i]' value='".$kontrak_D[$i]->pcsKontrak."' onchange='getData();'></td>";
                                    echo "<td><input type='text' name='toleransiLebih[$i]' id='toleransiLebih[$i]' value='".$kontrak_D[$i]->pctToleransiLebihKontrak."' onchange='getData();'></td>";
                                    echo "<td><input type='text' name='toleransiKurang[$i]' id='toleransiKurang[$i]' value='".$kontrak_D[$i]->pctToleransiKurangKontrak."' onchange='getData();'></td>";
                                    echo "<td><input type='text' name='harga[$i]' id='harga[$i]' value='".$kontrak_D[$i]->harga."' onchange='getData();'></td>";
                                    echo "<td><input type='text' name='tax[$i]' id='tax[$i]' value='".$kontrak_D[$i]->tax."' onchange='getData();'></td>";
                                    echo "<td><input type='text' name='tipeBox[$i]' id='tipeBox[$i]' ></td>";
                                    echo "<td><input type='text' name='pcsToleransiLebih[$i]' id='pcsToleransiLebih[$i]' readonly ></td>";
                                    echo "<td><input type='text' name='kgToleransiLebih[$i]' id='kgToleransiLebih[$i]' readonly></td>";
                                    echo "<td><input type='text' name='pcsToleransiKurang[$i]' id='pcsToleransiKurang[$i]' readonly></td>";
                                    echo "<td><input type='text' name='kgToleransiKurang[$i]' id='kgToleransiKurang[$i]' readonly></td>";
                                    echo "<td><input type='text' name='totalSblTax[$i]' id='totalSblTax[$i]' readonly></td>";
                                    echo "<td><input type='text' name='hargaTax[$i]' id='hargaTax[$i]' readonly></td>";
                                    echo "<td><input type='text' name='qtyKg[$i]' id='qtyKg[$i]' readonly></td>";
                                    echo "<td><input type='text' name='Total[$i]' id='Total[$i]' readonly></td>";
                                    echo "</tr>";
                                    
                                    
                                } else 
                                {
                                    // echo "<input type='text' name='idmcpel[$i]' id='idmcpel[$i]' readonly style='color:rgb(255, 255, 255)'>";
                                    echo "<tr>";
                                    echo    "<td>";
                                    echo   "<select class='js-example-basic-single col-md-12' name='nama_$i' id='nama_$i'>";
                                        echo   "<option value=''>---</option>";
                                        foreach ($mc as $data) {
                                            echo "<option value='$data->id|$data->gramSheetBoxKontrak|$data->substance|$data->tipeMc'>$data->kode|$data->tipeMc</option>";
                                        }
                                    echo "</select>";
                                    echo "</td>";
                                    echo "<td><input type='text' name='substance[$i]' id='substance[$i]'></td>";
                                    echo "<td><input type='text' name='qtyPcs[$i]' id='qtyPcs[$i]' onchange='getData();'></td>";
                                    echo "<td><input type='text' name='toleransiLebih[$i]' id='toleransiLebih[$i]' onchange='getData();'></td>";
                                    echo "<td><input type='text' name='toleransiKurang[$i]' id='toleransiKurang[$i]' onchange='getData();'></td>";
                                    echo "<td><input type='text' name='harga[$i]' id='harga[$i]' onchange='getData();'></td>";
                                    echo "<td><input type='text' name='tax[$i]' id='tax[$i]' onchange='getData();'></td>";
                                    echo "<td><input type='text' name='tipeBox[$i]' id='tipeBox[$i]' ></td>";
                                    echo "<td><input type='text' name='pcsToleransiLebih[$i]' id='pcsToleransiLebih[$i]'></td>";
                                    echo "<td><input type='text' name='kgToleransiLebih[$i]' id='kgToleransiLebih[$i]'></td>";
                                    echo "<td><input type='text' name='pcsToleransiKurang[$i]' id='pcsToleransiKurang[$i]'></td>";
                                    echo "<td><input type='text' name='kgToleransiKurang[$i]' id='kgToleransiKurang[$i]'></td>";
                                    echo "<td><input type='text' name='totalSblTax[$i]' id='totalSblTax[$i]' ></td>";
                                    echo "<td><input type='text' name='hargaTax[$i]' id='hargaTax[$i]' ></td>";
                                    echo "<td><input type='text' name='qtyKg[$i]' id='qtyKg[$i]'></td>";
                                    echo "<td><input type='text' name='Total[$i]' id='Total[$i]' ></td>";
                                    echo "</tr>";
                                }   
                            }
                            ?>
                            
                            </tbody>
                        </table>
                        {{-- <div class="card-body" style="border-right: -20px"> 
                        
                            <table class="table table-bordered" id="detail_kontrak">
                                <thead>
                                    <tr>
                                        <th scope="col">Tanggal Kirim</th>
                                        <th scope="col">Qty(Pcs)</th>
                                        <th scope="col">Qty(Kg)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $counts = 5;
                                    
                                    for ($i=1; $i<=$counts; $i++) { 
                                        
                                        echo "<tr>";
                                        echo "<td><input type='date' name='tglKirim[$i]' id='tglKirim[$i]'></td>";
                                        echo "<td><input type='text' name='dtPcs[$i]' id='dtPcs[$i]' onchange='getData();'></td>";
                                        echo "<td><input type='text' name='dtKg[$i]' id='dtKg[$i]' onchange='getData();'></td>";
                                        echo "</tr>";
    
                                        
                                    }
                                    ?>
                                                
                                </tbody>
                            </table>
                        </div> --}}
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
                            
    function getData() {
        var data1 = document.getElementById("nama_0").value;
        var data2 = document.getElementById("nama_1").value;
        var data3 = document.getElementById("nama_2").value;
        var data4 = document.getElementById("nama_3").value;
        var data5 = document.getElementById("nama_4").value;
        
        if (data1 != '') {
            var arr1 = data1.split('|');
            var idmc = arr1[0];
            var beratBox = arr1[1];
            var substance = arr1[2];
            var tipeBox = arr1[3];
            var harga = document.getElementById('harga[0]').value;
            var taxpct = document.getElementById('tax[0]').value;
            var qty = document.getElementById('qtyPcs[0]').value;
            var lebihpct = document.getElementById('toleransiLebih[0]').value;
            var kurangpct = document.getElementById('toleransiKurang[0]').value;
            var totalKg = qty * beratBox;
            var lebihpcs =  qty * (lebihpct/100) ;
            var hargablmtax = qty * harga;
            var taxrp = (hargablmtax*taxpct)/100;
            var total = taxrp + hargablmtax ;
            var lebihkg = totalKg * (lebihpct/100);
            var kurangpcs =  qty * (kurangpct/100) ;
            var kurangkg = totalKg * (kurangpct/100);

            document.getElementById("qtyKg[0]").value = totalKg.toFixed(2);
            document.getElementById("pcsToleransiLebih[0]").value = lebihpcs.toFixed(2);
            document.getElementById("kgToleransiLebih[0]").value = lebihkg.toFixed(2);
            document.getElementById("pcsToleransiKurang[0]").value = kurangpcs.toFixed(2);
            document.getElementById("kgToleransiKurang[0]").value = kurangkg.toFixed(2);
            document.getElementById("totalSblTax[0]").value = hargablmtax.toFixed(2);
            document.getElementById("hargaTax[0]").value = taxrp.toFixed(2);
            document.getElementById("Total[0]").value = total.toFixed(2);
            document.getElementById("substance[0]").value = substance;
            document.getElementById("idmcpel[0]").value = idmc;
            document.getElementById("tipeBox[0]").value = tipeBox;

        } 
        if (data2 != '') {
            var arr1 = data1.split('|');
            var idmc = arr1[0];
            var beratBox = arr1[1];
            var substance = arr1[2];
            var tipeBox = arr1[3];
            var harga = document.getElementById('harga[1]').value;
            var taxpct = document.getElementById('tax[1]').value;
            var qty = document.getElementById('qtyPcs[1]').value;
            var lebihpct = document.getElementById('toleransiLebih[1]').value;
            var kurangpct = document.getElementById('toleransiKurang[1]').value;
            var totalKg = qty * beratBox;
            var lebihpcs =  qty * (lebihpct/100) ;
            var hargablmtax = qty * harga;
            var taxrp = (hargablmtax*taxpct)/100;
            var total = taxrp + hargablmtax ;
            var lebihkg = totalKg * (lebihpct/100);
            var kurangpcs =  qty * (kurangpct/100) ;
            var kurangkg = totalKg * (kurangpct/100);

            document.getElementById("qtyKg[1]").value = totalKg.toFixed(2);
            document.getElementById("pcsToleransiLebih[1]").value = lebihpcs.toFixed(2);
            document.getElementById("kgToleransiLebih[1]").value = lebihkg.toFixed(2);
            document.getElementById("pcsToleransiKurang[1]").value = kurangpcs.toFixed(2);
            document.getElementById("kgToleransiKurang[1]").value = kurangkg.toFixed(2);
            document.getElementById("totalSblTax[1]").value = hargablmtax.toFixed(2);
            document.getElementById("hargaTax[1]").value = taxrp.toFixed(2);
            document.getElementById("Total[1]").value = total.toFixed(2);
            document.getElementById("substance[1]").value = substance;
            document.getElementById("idmcpel[1]").value = idmc;
            document.getElementById("tipeBox[1]").value = tipeBox;
        } 
        if (data3 != '') {
            var arr1 = data1.split('|');
            var idmc = arr1[0];
            var beratBox = arr1[1];
            var substance = arr1[2];
            var tipeBox = arr1[3];
            var harga = document.getElementById('harga[2]').value;
            var taxpct = document.getElementById('tax[2]').value;
            var qty = document.getElementById('qtyPcs[2]').value;
            var lebihpct = document.getElementById('toleransiLebih[2]').value;
            var kurangpct = document.getElementById('toleransiKurang[2]').value;
            var totalKg = qty * beratBox;
            var lebihpcs =  qty * (lebihpct/100) ;
            var hargablmtax = qty * harga;
            var taxrp = (hargablmtax*taxpct)/100;
            var total = taxrp + hargablmtax ;
            var lebihkg = totalKg * (lebihpct/100);
            var kurangpcs =  qty * (kurangpct/100) ;
            var kurangkg = totalKg * (kurangpct/100);

            document.getElementById("qtyKg[2]").value = totalKg.toFixed(2);
            document.getElementById("pcsToleransiLebih[2]").value = lebihpcs.toFixed(2);
            document.getElementById("kgToleransiLebih[2]").value = lebihkg.toFixed(2);
            document.getElementById("pcsToleransiKurang[2]").value = kurangpcs.toFixed(2);
            document.getElementById("kgToleransiKurang[2]").value = kurangkg.toFixed(2);
            document.getElementById("totalSblTax[2]").value = hargablmtax.toFixed(2);
            document.getElementById("hargaTax[2]").value = taxrp.toFixed(2);
            document.getElementById("Total[2]").value = total.toFixed(2);
            document.getElementById("substance[2]").value = substance;
            document.getElementById("idmcpel[2]").value = idmc;
            document.getElementById("tipeBox[2]").value = tipeBox;
        }
        if (data4 != '') {
            var arr1 = data1.split('|');
            var idmc = arr1[0];
            var beratBox = arr1[1];
            var substance = arr1[2];
            var tipeBox = arr1[3];
            var harga = document.getElementById('harga[3]').value;
            var taxpct = document.getElementById('tax[3]').value;
            var qty = document.getElementById('qtyPcs[3]').value;
            var lebihpct = document.getElementById('toleransiLebih[3]').value;
            var kurangpct = document.getElementById('toleransiKurang[3]').value;
            var totalKg = qty * beratBox;
            var lebihpcs =  qty * (lebihpct/100) ;
            var hargablmtax = qty * harga;
            var taxrp = (hargablmtax*taxpct)/100;
            var total = taxrp + hargablmtax ;
            var lebihkg = totalKg * (lebihpct/100);
            var kurangpcs =  qty * (kurangpct/100) ;
            var kurangkg = totalKg * (kurangpct/100);

            document.getElementById("qtyKg[3]").value = totalKg.toFixed(2);
            document.getElementById("pcsToleransiLebih[3]").value = lebihpcs.toFixed(2);
            document.getElementById("kgToleransiLebih[3]").value = lebihkg.toFixed(2);
            document.getElementById("pcsToleransiKurang[3]").value = kurangpcs.toFixed(2);
            document.getElementById("kgToleransiKurang[3]").value = kurangkg.toFixed(2);
            document.getElementById("totalSblTax[3]").value = hargablmtax.toFixed(2);
            document.getElementById("hargaTax[3]").value = taxrp.toFixed(2);
            document.getElementById("Total[3]").value = total.toFixed(2);
            document.getElementById("substance[3]").value = substance;
            document.getElementById("idmcpel[3]").value = idmc;   
            document.getElementById("tipeBox[3]").value = tipeBox;                
        }
        if (data5 != '') {
            var arr1 = data1.split('|');
            var idmc = arr1[0];
            var beratBox = arr1[1];
            var substance = arr1[2];
            var tipeBox = arr1[3];
            var harga = document.getElementById('harga[4]').value;
            var taxpct = document.getElementById('tax[4]').value;
            var qty = document.getElementById('qtyPcs[4]').value;
            var lebihpct = document.getElementById('toleransiLebih[4]').value;
            var kurangpct = document.getElementById('toleransiKurang[4]').value;
            var totalKg = qty * beratBox;
            var lebihpcs =  qty * (lebihpct/100) ;
            var hargablmtax = qty * harga;
            var taxrp = (hargablmtax*taxpct)/100;
            var total = taxrp + hargablmtax ;
            var lebihkg = totalKg * (lebihpct/100);
            var kurangpcs =  qty * (kurangpct/100) ;
            var kurangkg = totalKg * (kurangpct/100);

            document.getElementById("qtyKg[4]").value = totalKg.toFixed(2);
            document.getElementById("pcsToleransiLebih[4]").value = lebihpcs.toFixed(2);
            document.getElementById("kgToleransiLebih[4]").value = lebihkg.toFixed(2);
            document.getElementById("pcsToleransiKurang[4]").value = kurangpcs.toFixed(2);
            document.getElementById("kgToleransiKurang[4]").value = kurangkg.toFixed(2);
            document.getElementById("totalSblTax[4]").value = hargablmtax.toFixed(2);
            document.getElementById("hargaTax[4]").value = taxrp.toFixed(2);
            document.getElementById("Total[4]").value = total.toFixed(2);
            document.getElementById("substance[4]").value = substance;
            document.getElementById("idmcpel[4]").value = idmc;
            document.getElementById("tipeBox[4]").value = tipeBox;
        }
        
    }
                    
                        
</script>

@endsection 