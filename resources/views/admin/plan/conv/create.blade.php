@extends('admin.templates.partials.default')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>

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
                <h4 class="modal-title">OPI</h4>
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
                
                <form action="{{ route('opi.store') }}"  method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">
                                        <!-- Modal -->
                                        <div class="modal fade" id="Opi">
                                            <div class="modal-dialog modal-xl">
                                                
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">OPI</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body opi">
                                                        <div class="card-body">
                                                            <table class="table table-bordered" id="data_opi">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">No. Kontrak</th>
                                                                        <th scope="col">Tanggal Order</th>
                                                                        <th scope="col">No. MC</th>
                                                                        <th scope="col">Kode Barang</th>
                                                                        <th scope="col">Product Item</th>
                                                                        <th scope="col">Tipe Order</th>
                                                                        <th scope="col">PO Customer</th>
                                                                        <th scope="col">Nama Customer</th>
                                                                        <th scope="col">Alamat Kirim</th>
                                                                        <th scope="col">Keterangan</th>
                                                                        <th scope="col">Toleransi</th>
                                                                        <th scope="col">Ukuran</th>
                                                                        <th scope="col">Substance</th>
                                                                        <th scope="col">Flute</th>
                                                                        <th scope="col">Warna</th>
                                                                        <th scope="col">Out</th>
                                                                        <th scope="col">Berat</th>
                                                                        <th scope="col">Koli</th>
                                                                        <th scope="col">Finishing</th>
                                                                        <th scope="col">Bentuk</th>
                                                                        <th scope="col">MC ID</th>
                                                                        <th scope="col">KontrakM ID</th>
                                                                        <th scope="col">KotrakD ID</th>
                                                                        {{-- <th scope="col">Jadwal Kirim</th> --}}
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $no = 1;
                                                                    foreach ($kontrak_d as $data) { ?>
                                                                        <tr>
                                                                            <td scope="row">{{ $data->noKontrak }}</td>
                                                                            <td>{{ $data->tglOrder }}</td>
                                                                            <td>{{ $data->nomc }}</td>
                                                                            <td>{{ $data->kodeBarang }}</td>
                                                                            <td>{{ $data->namaBarang }}</td>
                                                                            <td>{{ $data->tipeOrder }}</td>
                                                                            <td>{{ $data->poCust }}</td>
                                                                            <td>{{ $data->namaCust }}</td>
                                                                            <td>{{ $data->alamatKirim }}</td>
                                                                            <td>{{ $data->keterangan }}</td>
                                                                            <td>{{ $data->pctToleransiLebihKontrak }}</td>
                                                                            <td>{{ $data->panjang }} x {{ $data->lebar }} x {{ $data->tinggi }}</td>
                                                                            <td>{{ $data->substance }}</td>
                                                                            <td>{{ $data->flute }}</td>
                                                                            <td>{{ $data->warna }}</td>
                                                                            <td>{{ $data->outConv }}</td>
                                                                            <td>{{ $data->berat }}</td>
                                                                            <td>{{ $data->koli }}</td>
                                                                            <td>{{ $data->joint }}</td>
                                                                            <td>{{ $data->bentuk }}</td>
                                                                            <td>{{ $data->mcid }}</td>
                                                                            <td>{{ $data->kontrakmid }}</td>
                                                                            <td>{{ $data->id }}</td>
                                                                            {{-- <td>{{ $data->tglKirim }}</td> --}}
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
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>No OPI</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <input type="text" class="form-control txt_line" value="{{ $numb_opi }}" name="noOpi" id="noOpi">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" data-toggle="modal" data-target="#Opi">
                                                    <i class="fas fa-search" style="
                                                    height: 20px;
                                                    margin-top: 15px;
                                                    width: 20px;
                                                "></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>No Kontrak</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="noKontrak" id="noKontrak">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Tipe Order</label>
                                    </div>
                                    <div class="col-md-6">
                                        {{-- <input type="hidden" name="mcid" id="mcid"> --}}
                                        <!-- <input type="hidden" name="beratBox" id="beratBox"> -->
                                        <input type="text" class="form-control txt_line" name="tipeOrder" id="tipeOrder">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Tanggal Order</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="date" class="form-control txt_line" name="tanggalOrder" id="tanggalOrder">
                                        {{-- <textarea name="tanggalOrder" id="tanggalOrder" cols="30" rows="4"></textarea> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>No MC</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="hidden" class="form-control txt_line" name="mcid" id="mcid">
                                        <input type="hidden" class="form-control txt_line" name="kontrakmid" id="kontrakmid">
                                        <input type="hidden" class="form-control txt_line" name="kontrakdid" id="kontrakdid">
                                        <input type="text" class="form-control txt_line" name="nomc" id="nomc">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>PO Customer</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="poCust" id="poCust">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Nama Customer</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="namaCust" id="namaCust">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Alamat Kirim</label>
                                    </div>
                                    <div class="col-md-6">
                                        {{-- <input type="text" class="form-control txt_line" name="kodeBarang" id="kodeBarang"> --}}
                                        <textarea name="alamatKirim" id="alamatKirim" cols="30" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Jadwal Kirim</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="hidden" class="form-control txt_line" name="tglKirim" id="tglKirim">
                                        <input type="hidden" class="form-control txt_line" name="dtid" id="dtid">
                                        <select class="js-example-basic-single col-md-12" name="dt" id="dt" onchange="getDataDt()">
                                            <option value=''>--</option>
                                            @foreach ($dt as $data)
                                            <option value="{{ $data->id }}|{{ $data->tglKirimDt }}|{{ $data->pcsDt }}">{{ $data->kodeKontrak }} || {{ $data->tglKirimDt }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Keterangan OPI</label>
                                    </div>
                                    <div class="col-md-6">
                                        {{-- <input type="text" class="form-control txt_line" name="keterangan" id="keterangan"> --}}
                                        <textarea name="keterangan" id="keterangan" cols="30" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Jumlah Order (Pcs)</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="jumlahOrder" id="jumlahOrder" onchange="getHarga();">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Toleransi (%)</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="toleransi" id="toleransi" onchange="getHarga();">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Product Item</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="item" id="item">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Kode Barang</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="kodeBarang" id="kodeBarang">
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
                                        <label>Subs Produksi</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="substance" id="substance" onchange="getToleransiKurang()">
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
                                        <label>Out</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="outConv" id="outConv">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Berat Box (kg)</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="berat" id="berat">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Isi Colly</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="koli" id="koli">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Finishing</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="finishing" id="finishing">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Bentuk</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="bentuk" id="bentuk">
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    {{-- <table class="table table-bordered" id="">
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
                                
                                echo "<input type='hidden' name='idmcpel[$i]' id='idmcpel[$i]' readonly>";
                                echo "<tr>";
                                    echo    "<td>";
                                        echo   "<select class='js-example-basic-single col-md-12' name='nama_$i' id='nama_$i'>";
                                            echo   "<option value=''>---</option>";
                                            // foreach ($mcpel as $data) {
                                            //     echo "<option value='$data->id|$data->gramSheetBoxKontrak'>$data->kode|$data->panjangSheetBox x $data->lebarSheetBox x 1</option>";
                                            // }
                                            echo "</select>";
                                            echo "</td>";
                                            echo "<td><input type='text' name='qtyPcs[$i]' id='qtyPcs[$i]'></td>";
                                            echo "<td><input type='text' name='toleransi[$i]' id='toleransi[$i]' onchange='getData();'></td>";
                                            echo "<td><input type='text' name='qtyKg[$i]' id='qtyKg[$i]' readonly></td>";
                                            echo "<td><input type='text' name='pcsToleransi[$i]' id='pcsToleransi[$i]' readonly></td>";
                                            echo "<td><input type='text' name='kgToleransi[$i]' id='kgToleransi[$i]' readonly></td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                        
                                    </tbody>
                                </table> --}}
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
                
                $(".opi").ready(function(){
                    
                    var table = $("#data_opi").DataTable({
                        select: true,
                        "initComplete": function (settings, json) {  
                            $("#data_opi").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
                        },
                    });
                    
                    $('#Opi tbody').on( 'click', 'td', function () {
                        var opi = (table.row(this).data());
                        
                        
                        document.getElementById('noKontrak').value = opi[0];
                        document.getElementById('tipeOrder').value = opi[5];
                        document.getElementById('tanggalOrder').value = opi[1];
                        document.getElementById('nomc').value = opi[2];
                        document.getElementById('poCust').value = opi[6];
                        document.getElementById('namaCust').value = opi[7];
                        document.getElementById('alamatKirim').value = opi[8];
                        document.getElementById('keterangan').value = opi[9];
                        // document.getElementById('jumlahOrder').value = opi[ ];
                        document.getElementById('toleransi').value = opi[10];
                        document.getElementById('item').value = opi[4];
                        document.getElementById('kodeBarang').value = opi[3];
                        document.getElementById('ukuran').value = opi[11];
                        document.getElementById('substance').value = opi[12];
                        document.getElementById('flute').value = opi[13];
                        document.getElementById('warna').value = opi[14];
                        document.getElementById('outConv').value = opi[15];
                        document.getElementById('berat').value = opi[16];
                        document.getElementById('koli').value = opi[17];
                        document.getElementById('finishing').value = opi[18];
                        document.getElementById('bentuk').value = opi[19];
                        document.getElementById('mcid').value = opi[20];
                        document.getElementById('kontrakmid').value = opi[21];
                        document.getElementById('kontrakdid').value = opi[22];
                        
                    } );
                } );
                
                function getDataDt() {
                    var dt = document.getElementById('dt').value;

                    var dt = dt.split("|");

                    document.getElementById('dtid').value = dt[0];
                    document.getElementById('tglKirim').value = dt[1];
                    document.getElementById('jumlahOrder').value = dt[2];
                
                }                
            </script>
            
            @endsection