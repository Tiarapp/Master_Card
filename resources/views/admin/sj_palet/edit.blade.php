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
                
                <form action="../update/{{ $sj_Palet_M->id }}" method="POST"  >
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Tanggal</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="date" class="form-control txt_line" name="tanggal" id="tanggal" value="{{ $sj_Palet_M->tanggal }}" autofocus onfocusout="getDefaultData()">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>No. Surat Jalan</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="noSuratJalan" id="noSuratJalan" value="{{ $sj_Palet_M->noSuratJalan }}">
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
                                        <label>Nama Customer</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="hidden" name="namaCustomer" id="namaCustomer" value="{{ $sj_Palet_M->namaCustomer }}">
                                        <select class='js-example-basic-single col-md-12' name="listCust" id="listCust" onchange="getCustomer()">
                                            <option value="{{ $sj_Palet_M->namaCustomer }}">{{ $sj_Palet_M->namaCustomer }}</option>
                                            @foreach ($customer as $data)
                                            <option value="{{ $data->Nama }}|{{ $data->AlamatKantor }}">{{ $data->Nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>No. Polisi</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="noPolisi" id="noPolisi" value="{{ $sj_Palet_M->noPolisi }}" onfocusout="getDefaultData()">
                                    </div> 
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-md-5">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>No. PO Customer</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="noPoCustomer" id="noPoCustomer">
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Alamat Customer</label>
                                    </div>
                                    <div class="col-md-10">
                                        {{-- <input type="textarea" class="form-control txt_line" name="alamatCustomer" id="alamatCustomer"> --}}
                                        <textarea class="form-control txt_line" name="alamatCustomer" id="alamatCustomer" cols="40" rows="3">{{ $sj_Palet_M->alamatCustomer }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Catatan</label>
                                {{-- <textarea name="keterangan" id="keterangan" cols="30" rows="10"></textarea> --}}
                                <div class="col-md-10">
                                    {{-- <input type="textarea" class="form-control txt_line" name="alamatCustomer" id="alamatCustomer"> --}}
                                    <textarea class="form-control txt_line" name="catatan" id="catatan" cols="40" rows="3">{{ $sj_Palet_M->catatan }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- <div class="col-md-2">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="button" class="form-control txt_line" value="Get Data" onclick="getDefaultData()">
                                </div> 
                            </div>
                        </div>
                    </div> --}}
                    <?php 
                    // dd($sj_Palet_D);
                    for ($i=0; $i < $count; $i++) {
                        // var_dump($sj_Palet_D[$i]->item_palet_id); 
                        // dd($sj_Palet_D);
                        echo '<input type="hidden" name="iddetail['.$i.']" id="iddetail['.$i.']" value="'.$sj_Palet_D[$i]->id.'" readonly >' ;
                        echo '<input type="hidden" name="idpaletdata['.$i.']" id="idpaletdata['.$i.']" value="'.$sj_Palet_D[$i]->item_palet_id.'" readonly >' ;
                        echo '<input type="hidden" name="namaBarangdata['.$i.']" id="namaBarangdata['.$i.']" value="'.$sj_Palet_D[$i]->namaBarang.'" readonly >' ;
                        echo '<input type="hidden" name="qtydata['.$i.']" id="qtydata['.$i.']" value="'.$sj_Palet_D[$i]->qty.'" readonly >' ;
                        echo '<input type="hidden" name="ukurandata['.$i.']" id="ukurandata['.$i.']" value="'.$sj_Palet_D[$i]->ukuran.'" readonly >' ;
                        echo '<input type="hidden" name="ketdata['.$i.']" id="ketdata['.$i.']" value="'.$sj_Palet_D[$i]->keterangan.'" readonly >' ;
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
                                            var namaBarang = document.getElementById("namaBarangdata["+index+"]").value;
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
                                        document.getElementById("qty[0]").value = '';
                                        document.getElementById("keterangan[0]").value = '';
                                    } 
                                    if (data2 != '') {
                                        var arr2 = data2.split('|');
                                        var idpalet2 = arr2[0];
                                        var nama2 = arr2[1];
                                        var ukuran2 = arr2[2]; 
                                        document.getElementById("idpalet[1]").value = idpalet2;
                                        document.getElementById("nama[1]").value = nama2;
                                        document.getElementById("ukuran[1]").value = ukuran2;
                                        document.getElementById("qty[1]").value = '';
                                        document.getElementById("keterangan[1]").value = '';
                                    } 
                                    if (data3 != '') {
                                        var arr3 = data3.split('|');
                                        var idpalet3 = arr3[0];
                                        var nama3 = arr3[1];
                                        var ukuran3 = arr3[2]; 
                                        document.getElementById("idpalet[2]").value = idpalet3;
                                        document.getElementById("nama[2]").value = nama3;
                                        document.getElementById("ukuran[2]").value = ukuran3;
                                        document.getElementById("qty[2]").value = '';
                                        document.getElementById("keterangan[2]").value = '';
                                    }
                                    if (data4 != '') {
                                        var arr4 = data4.split('|');
                                        var idpalet4 = arr4[0];
                                        var nama4 = arr4[1];
                                        var ukuran4 = arr4[2]; 
                                        document.getElementById("idpalet[3]").value = idpalet4;
                                        document.getElementById("nama[3]").value = nama4;
                                        document.getElementById("ukuran[3]").value = ukuran4;  
                                        document.getElementById("qty[3]").value = '';
                                        document.getElementById("keterangan[3]").value = '';                      
                                    }
                                    if (data5 != '') {
                                        var arr5 = data5.split('|');
                                        var idpalet5 = arr5[0];
                                        var nama5 = arr5[1];
                                        var ukuran5 = arr5[2]; 
                                        document.getElementById("idpalet[4]").value = idpalet5;
                                        document.getElementById("nama[4]").value = nama5;
                                        document.getElementById("ukuran[4]").value = ukuran5;
                                        document.getElementById("qty[4]").value = '';
                                        document.getElementById("keterangan[4]").value = '';
                                    }
                                    
                                }
                                
                                
                            </script>
                            
                            @endsection 