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
                <form action="{{ route('kontrak.store_dt') }}" method="POST"  >
                    {{ csrf_field() }}

                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>NO KONTRAK</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control txt_line" name="kode" id="kode" value="{{ $kontrak_M->kode }}">
                                                <input type="text" class="form-control txt_line" name="idkontrakm" id="idkontrakm" value="{{ $kontrak_M->id }}">
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
                                                <label>Jumlah Order</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control txt_line" name="telp" id="telp" value="{{ $kontrak_D->pcsKontrak }}">
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
                                <th scope="col">Tanggal</th>
                                <th scope="col">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $dt = 15;    
                             for ($i=1; $i <= $dt; $i++) { 
                            
                            echo "<tr>
                                <td><input type='date' name='tglKirim[$i]' id='tglKirim[$i]'></td>
                                <td><input type='number' name='jumlahKirim[$i]' id='jumlahKirim[$i]'></td>
                            </tr>";
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
            var hargaKg = hargablmtax/totalKg;
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
            document.getElementById("hargaKg[0]").value = hargaKg.toFixed(2);
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
            var hargaKg = hargablmtax/totalKg;
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
            document.getElementById("hargaKg[1]").value = hargaKg.toFixed(2);
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
            var hargaKg = hargablmtax/totalKg;
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
            document.getElementById("hargaKg[2]").value = hargaKg.toFixed(2);
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
            var hargaKg = hargablmtax/totalKg;
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
            document.getElementById("hargaKg[3]").value = hargaKg.toFixed(2);
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
            var hargaKg = hargablmtax/totalKg;
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
            document.getElementById("hargaKg[4]").value = hargaKg.toFixed(2);
            document.getElementById("substance[4]").value = substance;
            document.getElementById("idmcpel[4]").value = idmc;
            document.getElementById("tipeBox[4]").value = tipeBox;
        }
        
    }
                    
                        
</script>

@endsection 