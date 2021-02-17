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
                
                <form action="/admin/sj_palet/store"  method="POST">
                    @csrf
                    <div class="row">
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
                        <div class="col-md-5">
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
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>No. Polisi</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="noPolisi" id="noPolisi">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
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
                                        <input type="text" class="form-control txt_line" name="namaCustomer" id="namaCustomer">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Alamat Customer</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="alamatCustomer" id="alamatCustomer">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Catatan</label>
                            {{-- <textarea name="keterangan" id="keterangan" cols="30" rows="10"></textarea> --}}
                            <input type="text" class="form-control txt_line" name="catatan" id="catatan" onchange="getData()">
                        </div>
                    </div>
                    
                    <table class="table table-bordered" id="">
                        <thead>
                            <tr>
                                <th scope="col">Nama</th>
                                <th scope="col">Ukuran</th>
                                <th scope="col">No Kontrak</th>
                                <th scope="col">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $counts = 5;
                            
                            for ($i=1; $i<=$counts; $i++) { 
                                
                                echo "<tr>";
                                    echo    "<td>";
                                        echo   "<select class='js-example-basic-single col-md-12' name='nama_$i' id='nama_$i' onchange='getData();'>";
                                            echo   "<option value=''>---</option>";
                                            foreach ($palet as $data) {
                                                echo "<option value='$data->id|$data->nama|$data->ukuran'>$data->nama|$data->ukuran</option>";
                                            }
                                            echo "</select>";
                                            echo "</td>";
                                            echo "<td><input type='text' name='nama$i' id='nama$i' readonly></td>";
                                            echo "<td><input type='text' name='ukuran$i' id='ukuran$i' readonly></td>";
                                            echo "<td><input type='text' name='noKontrak$i' id='noKontrak$i'></td>";
                                            echo "<td><input type='text' name='keterangan$i' id='keterangan$i'></td>";
                                            echo "</tr>";
                                            echo "<td><input type='hidden' name='idpalet$i' id='idpalet$i' readonly></td>";
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
                
                function getData() {
                    var data1 = document.getElementById("nama_1").value;
                    var data2 = document.getElementById("nama_2").value;
                    var data3 = document.getElementById("nama_3").value;
                    var data4 = document.getElementById("nama_4").value;
                    var data5 = document.getElementById("nama_5").value;
                    
                    if (data1 != '') {
                        var arr1 = data1.split('|');
                        var idpalet1 = arr1[0];
                        var nama1 = arr1[1];
                        var ukuran1 = arr1[2]; 
                        document.getElementById("idpalet1").value = idpalet1;
                        document.getElementById("nama1").value = nama1;
                        document.getElementById("ukuran1").value = ukuran1;
                    } 
                    if (data2 != '') {
                        var arr2 = data2.split('|');
                        var idpalet2 = arr2[0];
                        var nama2 = arr2[1];
                        var ukuran2 = arr2[2]; 
                        document.getElementById("idpalet2").value = idpalet2;
                        document.getElementById("nama2").value = nama2;
                        document.getElementById("ukuran2").value = ukuran2;
                    } 
                    if (data3 != '') {
                        var arr3 = data3.split('|');
                        var idpalet3 = arr3[0];
                        var nama3 = arr3[1];
                        var ukuran3 = arr3[2]; 
                        document.getElementById("idpalet3").value = idpalet3;
                        document.getElementById("nama3").value = nama3;
                        document.getElementById("ukuran3").value = ukuran3;
                    }
                    if (data4 != '') {
                        var arr4 = data4.split('|');
                        var idpalet4 = arr4[0];
                        var nama4 = arr4[1];
                        var ukuran4 = arr4[2]; 
                        document.getElementById("idpalet4").value = idpalet4;
                        document.getElementById("nama4").value = nama4;
                        document.getElementById("ukuran4").value = ukuran4;                        
                    }
                    if (data5 != '') {
                        var arr5 = data5.split('|');
                        var idpalet5 = arr5[0];
                        var nama5 = arr5[1];
                        var ukuran5 = arr5[2]; 
                        document.getElementById("idpalet5").value = idpalet5;
                        document.getElementById("nama5").value = nama5;
                        document.getElementById("ukuran5").value = ukuran5;
                    }
                    
                }
                
                
            </script>
            
            @endsection