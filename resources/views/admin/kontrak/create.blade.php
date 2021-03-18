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
                
                <form action="{{ route('sj_palet.store') }}"  method="POST">
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
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label>Susbtance Kontrak</label>
                        </div>
                        <div class="col-md-3">
                            <input type="hidden" class="form-control txt_line col-md-11" value="" id="substanceKontrak_id" name="substanceKontrak_id">
                            <input type="text" class="form-control txt_line col-md-11" value="" id="subskontrak" onchange="getGramKontrak()" readonly>
                            <!-- Modal -->
                            <div class="modal fade" id="SubstanceKontrak">
                                <div class="modal-dialog modal-xl">
                                    
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Mastercard Box</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body SubstanceKontrak">
                                            <div class="card-body">
                                                <table class="table table-bordered" id="data_substanceKontrak">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Kode MC</th>
                                                            <th scope="col">Nama Box</th>
                                                            <th scope="col">Tipe Box</th>
                                                            <th scope="col">Flute</th>
                                                            <th scope="col">Joint</th>
                                                            <th scope="col">Wax</th>
                                                            <th scope="col">Panjang Box</th>
                                                            <th scope="col">Lebar Box</th>
                                                            <th scope="col">Packing</th>
                                                            <th scope="col">box_id</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        foreach ($mc as $data) { ?>
                                                            <tr>
                                                                <td scope="row">{{ $data->kode }}</td>
                                                                <td>{{ $data->namaBarang }}</td>
                                                                <td>{{ $data->tipeBox }}</td>
                                                                <td>{{ $data->flute }}</td>
                                                                <td>{{ $data->joint }}</td>
                                                                <td>{{ $data->wax }}</td>
                                                                <td>{{ $data->panjangSheetBox }}</td>
                                                                <td>{{ $data->lebarSheetBox }}</td>
                                                                <td>{{ $data->koli }}</td>
                                                                <td>{{ $data->box_id }}</td>
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
                        </div>
                        <button type="button" data-toggle="modal" data-target="#SubstanceKontrak">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Pilih MC Pelengkap</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="hidden" name="namaCustomer" id="namaCustomer">
                                        <select class='js-example-basic-single col-md-12' name="listCust" id="listCust" onchange="getCustomer()">
                                            @foreach ($top as $data)
                                            <option value="{{ $data->Nama }}|{{ $data->AlamatKirim }}">{{ $data->Nama }}</option>
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
                                        <input type="text" class="form-control txt_line" name="noPolisi" id="noPolisi">
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
                                        <textarea class="form-control txt_line" name="alamatCustomer" id="alamatCustomer" cols="40" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Catatan</label>
                                {{-- <textarea name="keterangan" id="keterangan" cols="30" rows="10"></textarea> --}}
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <input type="text" class="form-control txt_line" name="catatan1" id="catatan1" value="PALET KAYU UNTUK MENGANGKUT BOX SJ NO : " readonly>
                                        </div>
                                        <div class="col-md 2">
                                            <input type="text" class="form-control txt_line" name="nosj" id="nosj" onchange="getCatatan()">
                                        </div>
                                    </div>
                                    <input type="hidden" name="catatan" id="catatan">
                                    {{-- <textarea class="form-control txt_line" name="catatan" id="catatan" cols="40" rows="3"></textarea> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    
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
                            
                            for ($i=1; $i<=$counts; $i++) { 
                                
                                echo "<tr>";
                                    echo    "<td>";
                                        echo   "<select class='js-example-basic-single col-md-12' name='nama_$i' id='nama_$i' onchange='getData();'>";
                                            echo   "<option value=''>---</option>";
                                            foreach ($mcpel as $data) {
                                                echo "<option value='$data->id|$data->kode|$data->panjangSheetBox|$data->lebarSheetBox|$data->substanceKontrak_id'>$data->nama|$data->ukuran</option>";
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
    
    $(".SubstanceKontrak").ready(function(){
        
        var table = $("#data_substanceKontrak").DataTable({
            select: true,
        });
        
        $('#data_substanceKontrak tbody').on( 'click', 'td', function () {
            var SubstanceKontrak = (table.row(this).data());
            
            document.getElementById('Katas').value = SubstanceKontrak[4]    ;
            document.getElementById('Kbf').value = SubstanceKontrak[5];
            document.getElementById('Ktengah').value = SubstanceKontrak[6];
            document.getElementById('Kcf').value = SubstanceKontrak[7];
            document.getElementById('Kbawah').value = SubstanceKontrak[8];
            
            document.getElementById('substanceKontrak_id').value = SubstanceKontrak[0];
            document.getElementById('subskontrak').value = SubstanceKontrak[2];
            
            getGramKontrak();
        } );
    } );
    
    function getCustomer() {
        var data = document.getElementById('listCust').value;
        
        var cust = data.split('|');
        var custNama = cust[0];
        var custAlamat = cust[1];
        
        document.getElementById('namaCustomer').value = custNama;
        document.getElementById('alamatCustomer').value = custAlamat;
    }
    
    function getCatatan() {
        var catatan1 = document.getElementById("catatan1").value;
        var nosj = document.getElementById("nosj").value;
        
        document.getElementById("catatan").value = catatan1 +nosj;
    }
    
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
            document.getElementById("idpalet[1]").value = idpalet1;
            document.getElementById("nama[1]").value = nama1;
            document.getElementById("ukuran[1]").value = ukuran1;
        } 
        if (data2 != '') {
            var arr2 = data2.split('|');
            var idpalet2 = arr2[0];
            var nama2 = arr2[1];
            var ukuran2 = arr2[2]; 
            document.getElementById("idpalet[2]").value = idpalet2;
            document.getElementById("nama[2]").value = nama2;
            document.getElementById("ukuran[2]").value = ukuran2;
        } 
        if (data3 != '') {
            var arr3 = data3.split('|');
            var idpalet3 = arr3[0];
            var nama3 = arr3[1];
            var ukuran3 = arr3[2]; 
            document.getElementById("idpalet[3]").value = idpalet3;
            document.getElementById("nama[3]").value = nama3;
            document.getElementById("ukuran[3]").value = ukuran3;
        }
        if (data4 != '') {
            var arr4 = data4.split('|');
            var idpalet4 = arr4[0];
            var nama4 = arr4[1];
            var ukuran4 = arr4[2]; 
            document.getElementById("idpalet[4]").value = idpalet4;
            document.getElementById("nama[4]").value = nama4;
            document.getElementById("ukuran[4]").value = ukuran4;                        
        }
        if (data5 != '') {
            var arr5 = data5.split('|');
            var idpalet5 = arr5[0];
            var nama5 = arr5[1];
            var ukuran5 = arr5[2]; 
            document.getElementById("idpalet[5]").value = idpalet5;
            document.getElementById("nama[5]").value = nama5;
            document.getElementById("ukuran[5]").value = ukuran5;
        }
        
    }
    
    
</script>

@endsection