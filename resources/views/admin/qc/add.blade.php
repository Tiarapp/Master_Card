@extends('admin.templates.partials.default')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<style>
    th {
        text-align: center !important;
    }
</style>

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row" id="form_list_mc">
            <div class="col-md-12">
                <h4 class="modal-title">Tambah COA</h4>
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

                <form action="{{ route('qc.store') }}"  method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">No OPI</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="hidden" class="form-control txt_line" id="opiid" name="opiid">
                                                <input type="hidden" class="form-control txt_line" id="mc" name="mc">
                                                <input type="text" class="form-control txt_line" id="noopi" name="noopi" >
                                            </div>
                                            <div class="col-md-4">
                                                <button type="button" data-toggle="modal" data-target="#modal-opi" class="btn btn-search">
                                                    Cari OPI  <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="modal-opi">
                                            <div class="modal-dialog modal-xl">                                                    
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">List OPI</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body opi">
                                                        <div class="card-body">
                                                            <table class="table table-bordered" id="data_opi">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">Action</th>
                                                                        <th scope="col">No OPI</th>
                                                                        <th scope="col">Delivery Time</th>
                                                                        <th scope="col">Customer</th>
                                                                        <th scope="col">PO Customer</th>
                                                                        <th scope="col">Barang</th>
                                                                        <th scope="col">MC</th>
                                                                        <th scope="col">Panjang</th>
                                                                        <th scope="col">Lebar</th>
                                                                        <th scope="col">Tinggi</th>
                                                                        <th scope="col">Panjang Sheet</th>
                                                                        <th scope="col">Lebar Sheet</th>
                                                                        <th scope="col">Kwalitas</th>
                                                                        <th scope="col">Berat</th>
                                                                        <th scope="col">Joint</th>
                                                                        <th scope="col">Flute</th>
                                                                        <th scope="col">id</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                    foreach ($opi as $data) { ?>
                                                                        <tr class="modal-plan-list">
                                                                            <td>
                                                                                <button class="btn btn-success btn-insert-opi" type="button">Add</button>
                                                                            </td>
                                                                            <td scope="row">{{ $data->noopi }}</td>
                                                                            <td>{{ $data->tglKirimDt }}</td>
                                                                            <td>{{ $data->Cust }}</td>
                                                                            <td>{{ $data->poCustomer }}</td>
                                                                            <td>{{ $data->namaBarang }}</td>
                                                                            <td>{{ $data->mcKode }}-{{ $data->revisimc }}</td>
                                                                            <td>{{ $data->panjang }}</td>
                                                                            <td>{{ $data->lebar }}</td>
                                                                            <td>{{ $data->tinggi }}</td>
                                                                            <td>{{ $data->panjangSheet }}</td>
                                                                            <td>{{ $data->lebarSheet }}</td>
                                                                            <td>{{ $data->subsK }}</td>
                                                                            <td>{{ $data->gram }}</td>
                                                                            <td>{{ $data->joint }}</td>
                                                                            <td>{{ $data->flute }}</td>
                                                                            <td>{{ $data->opiid }}</td>
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
                                    <br>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">Tanggal Analisa</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="date" class="form-control txt_line" id="tgl_analisa" name="tgl_analisa">
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">Customer</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control txt_line" id="cust" name="cust" >
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">PO Customer</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control txt_line" id="po_cust" name="po_cust" >
                                            </div>
                                        </div>
                                    </div> 
                                    <br>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">Flute</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control txt_line" id="flute" name="flute" >
                                            </div>
                                        </div>
                                    </div> 
                                    <br>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">Jumlah Kirim</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="number" class="form-control txt_line" id="jumlah_kirim" name="jumlah_kirim" >
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">Nama Barang</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control txt_line" id="item" name="item" >
                                            </div>
                                        </div>
                                    </div> 
                                    <br>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">Kualitas</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control txt_line" id="kualitas" name="kualitas" >
                                            </div>
                                        </div>
                                    </div> 
                                    <br>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">Tanggal Kirim</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control txt_line" id="tglKirim" name="tglKirim" >
                                            </div>
                                        </div>
                                    </div> 
                                    <br>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">Berat Gram</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control txt_line" id="berat" name="berat" >
                                            </div>
                                        </div>
                                    </div> 
                                    <br>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">Joint</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control txt_line" id="joint" name="joint" >
                                            </div>
                                        </div>
                                    </div> 
                                    <br>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">No. Bacth</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control txt_line" id="nobatch" name="nobatch" >
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>    
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">Panjang Sheet</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="number" class="form-control txt_line" id="panjang_sheet" name="panjang_sheet" >
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">Lebar Sheet</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="number" class="form-control txt_line" id="lebar_sheet" name="lebar_sheet" >
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">Panjang</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="number" class="form-control txt_line" id="panjang" name="panjang" >
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">Lebar</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="number" class="form-control txt_line" id="lebar" name="lebar" >
                                            </div>
                                        </div>
                                    </div> 
                                    <br>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">Tinggi</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="number" class="form-control txt_line" id="tinggi" name="tinggi" >
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>    
                        </div>         
                        <div class="col-md-12">
                            <br>
                            <hr> 
                            <div class="col-md-8">
                                <table style="width:100%">
                                    <thead>
                                        <th rowspan="2">Parameter</th>
                                      <th colspan="6">Result</th>
                                    </thead>
                                    <tbody>
                                        <th></th>
                                        <th>1</th>
                                        <th>2</th>
                                        <th>3</th>
                                        <th>4</th>
                                        <th>5</th>
                                        <th>Average</th>
                                    </tbody>
                                    <tbody>
                                        <td style="width: 300px">Berat Box ( Gram/m2) +/-4%</td>
                                        <td>
                                            <input type="text" class="form-control txt_line berat1" name="berat1" id="berat1">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control txt_line berat2" name="berat2" id="berat2">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control txt_line berat3" name="berat3" id="berat3">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control txt_line berat4" name="berat4" id="berat4">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control txt_line berat5" name="berat5" id="berat5">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control txt_line avg_berat" name="avg_berat" id="avg_berat">
                                        </td>
                                    </tbody>
                                    <tbody>
                                        <td style="width: 300px">BST (Kgf/cm2)</td>
                                        <td>
                                            <input type="text" class="form-control txt_line bst1" name="bst1" id="bst1">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control txt_line bst2" name="bst2" id="bst2">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control txt_line bst3" name="bst3" id="bst3">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control txt_line bst4" name="bst4" id="bst4">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control txt_line bst5" name="bst5" id="bst5">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control txt_line avg_bst" name="avg_bst" id="avg_bst">
                                        </td>
                                    </tbody>
                                    <tbody>
                                        <td style="width: 300px">EST (Kgf/cm2)</td>
                                        <td>
                                            <input type="text" class="form-control txt_line ect1" name="ect1" id="ect1">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control txt_line ect2" name="ect2" id="ect2">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control txt_line ect3" name="ect3" id="ect3">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control txt_line ect4" name="ect4" id="ect4">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control txt_line ect5" name="ect5" id="ect5">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control txt_line avg_ect" name="avg_ect" id="avg_ect">
                                        </td>
                                    </tbody>
                                    <tbody>
                                        <td style="width: 300px">BCT (Kgf)</td>
                                        <td>
                                            <input type="text" class="form-control txt_line bct1" name="bct1" id="bct1">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control txt_line bct2" name="bct2" id="bct2">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control txt_line bct3" name="bct3" id="bct3">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control txt_line bct4" name="bct4" id="bct4">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control txt_line bct5" name="bct5" id="bct5">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control txt_line avg_bct" name="avg_bct" id="avg_bct">
                                        </td>
                                    </tbody>
                                </table>
                            </div>
                        </div>                      
                    </div>
                    <br>
                    <hr>
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
                
<script>
    $("#modal-opi").ready(function(){
        var table = $("#data_opi").DataTable({
            select: true,
            "initComplete": function (settings, json) {  
            $("#data_opi").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
        },
        });

        $('#data_opi tbody').on( 'click', 'td', function () {
            var opi = (table.row(this).data());

            document.getElementById("noopi").value = opi[1]
            document.getElementById("cust").value = opi[3]
            document.getElementById("po_cust").value = opi[4]
            document.getElementById("flute").value = opi[15]
            document.getElementById("item").value = opi[5]
            document.getElementById("kualitas").value = opi[12]
            document.getElementById("tglKirim").value = opi[2]
            document.getElementById("berat").value = opi[13]
            document.getElementById("panjang_sheet").value = opi[10]
            document.getElementById("lebar_sheet").value = opi[11]
            document.getElementById("panjang").value = opi[7]
            document.getElementById("lebar").value = opi[8]
            document.getElementById("tinggi").value = opi[9]
            document.getElementById("opiid").value = opi[16]
            document.getElementById("joint").value = opi[14]
            document.getElementById("mc").value = opi[6]

            
            document.getElementById("berat1").value = 0
            document.getElementById("berat2").value = 0
            document.getElementById("berat3").value = 0
            document.getElementById("berat4").value = 0
            document.getElementById("berat5").value = 0
            
            document.getElementById("bst1").value = 0
            document.getElementById("bst2").value = 0
            document.getElementById("bst3").value = 0
            document.getElementById("bst4").value = 0
            document.getElementById("bst5").value = 0
            
            document.getElementById("ect1").value = 0
            document.getElementById("ect2").value = 0
            document.getElementById("ect3").value = 0
            document.getElementById("ect4").value = 0
            document.getElementById("ect5").value = 0
            
            document.getElementById("bct1").value = 0
            document.getElementById("bct2").value = 0
            document.getElementById("bct3").value = 0
            document.getElementById("bct4").value = 0
            document.getElementById("bct5").value = 0
            

            $("#modal-opi").modal("hide")
        });
    });

    $(document).on("keyup", ".berat1, .berat2, .berat3, .berat4, .berat5", function () {
        berat1 = document.getElementById("berat1").value;
        berat2 = document.getElementById("berat2").value;
        berat3 = document.getElementById("berat3").value;
        berat4 = document.getElementById("berat4").value;
        berat5 = document.getElementById("berat5").value;

        avg = (parseFloat(berat1) + parseFloat(berat2) + parseFloat(berat3) + parseFloat(berat4) + parseFloat(berat5))/5

        document.getElementById("avg_berat").value = avg.toFixed(2)
    })

    
    $(document).on("keyup", ".bst1, .bst2, .bst3, .bst4, .bst5", function () {
        bst1 = document.getElementById("bst1").value;
        bst2 = document.getElementById("bst2").value;
        bst3 = document.getElementById("bst3").value;
        bst4 = document.getElementById("bst4").value;
        bst5 = document.getElementById("bst5").value;

        avg = (parseFloat(bst1) + parseFloat(bst2) + parseFloat(bst3) + parseFloat(bst4) + parseFloat(bst5))/5

        document.getElementById("avg_bst").value = avg.toFixed(1)
    })

    
    $(document).on("keyup", ".ect1, .ect2, .ect3, .ect4, .ect5", function () {
        ect1 = document.getElementById("ect1").value;
        ect2 = document.getElementById("ect2").value;
        ect3 = document.getElementById("ect3").value;
        ect4 = document.getElementById("ect4").value;
        ect5 = document.getElementById("ect5").value;

        avg = (parseFloat(ect1) + parseFloat(ect2) + parseFloat(ect3) + parseFloat(ect4) + parseFloat(ect5))/5

        document.getElementById("avg_ect").value = avg.toFixed(2)
    })

    
    $(document).on("keyup", ".bct1, .bct2, .bct3, .bct4, .bct5", function () {
        bct1 = document.getElementById("bct1").value;
        bct2 = document.getElementById("bct2").value;
        bct3 = document.getElementById("bct3").value;
        bct4 = document.getElementById("bct4").value;
        bct5 = document.getElementById("bct5").value;

        avg = (parseFloat(bct1) + parseFloat(bct2) + parseFloat(bct3) + parseFloat(bct4) + parseFloat(bct5))/5

        document.getElementById("avg_bct").value = avg.toFixed(0)
    })
</script>