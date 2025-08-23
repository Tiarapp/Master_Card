@extends('admin.templates.partials.default')

<!-- Select2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css" />

<style>
/* Custom Select2 Styling */
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

.select2-container--bootstrap4.select2-container--focus .select2-selection--single {
    border-color: #80bdff !important;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
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
                {{-- menampilkan error ketika ada field yang kosong, bersangkutan dengan controller --}}
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
                {{-- form untuk create --}}
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
                                        <input type="date" class="form-control txt_line" name="tanggal" id="tanggal" autofocus onfocusout="getCatatan1()">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Jenis Palet</label>
                                    </div>
                                    <div class="col-md-6">
                                        <select class='js-example-basic-single col-md-12' name="jenispalet" id="jenispalet" onchange="getCatatan1()">
                                            <option value="Kayu">Kayu</option>
                                            <option value="Plastik">Plastik</option>
                                        </select>
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
                                    {{-- dropdown customer, ambil dari controller untuk query selectnya --}}
                                    <div class="col-md-6">
                                        <input type="hidden" name="namaCustomer" id="namaCustomer">
                                        <select class='js-example-basic-single col-md-12' name="listCust" id="listCust" onchange="getCustomer()">
                                            <option value="PT. SUPRACOR SEJAHTERA">PT. SUPRACOR SEJAHTERA</option>
                                            @foreach ($customer as $data)
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
                                            <input type="text" class="form-control txt_line" name="catatan1" id="catatan1" readonly>
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
                            // perulangan untuk membuat input detail
                            for ($i=1; $i<=$counts; $i++) { 
                                
                                echo "<tr>";
                                    echo    "<td>";
                                        echo   "<select class='js-example-basic-single col-md-12' name='nama_$i' id='nama_$i' onchange='getData();'>";
                                            echo   "<option value=''>---</option>";
                                            // ambil data palet dari controller
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
<!-- Select2 JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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

    // Split data Customer
    function getCatatan1() {
        var jenis = document.getElementById("jenispalet").value;

        if (jenis === "Kayu") {
            document.getElementById("catatan1").value = "PALET KAYU UNTUK MENGANGKUT BOX SJ NO : ";
        } else if (jenis == "Plastik") {
            document.getElementById("catatan1").value = "PALET PLASTIK UNTUK MENGANGKUT BOX SJ NO : ";
        }
    }
    
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

        document.getElementById("catatan").value = catatan1 + nosj;
    }
    
    // fungsi untuk mengisi otomatis ke input
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