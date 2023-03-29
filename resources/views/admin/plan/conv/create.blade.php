@extends('admin.templates.partials.default')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

{{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> --}}

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
                <h4 class="modal-title">Planning Converting</h4>
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
                
                <form action="{{ route('conv.store') }}"  method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Mesin</label>
                                        </div>
                                        <input type="hidden" name="mesin" id="mesin">
                                        <div class="col-md-8">
                                            <select class="js-example-basic-single col-md-12" name="tipemesin" id="tipemesin" onchange="getKode()">
                                                @foreach ($mesin as $item)
                                                <option value='{{ $item->id }}||{{ $item->nama }}||{{ $item->kode }}'>{{ $item->nama }}</option>    
                                                @endforeach
                                                
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Kode Planning</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control txt_line" name="kodeplan" id="kodeplan" onfocusout="getKode()" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Tanggal</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="date" class="form-control txt_line" name="tgl" id="tgl" autofocus onfocusout="getKode()">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Shift</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control txt_line" name="shift" id="shift" onfocusout="getKode()">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="row">
                                            
                                            <!-- Modal -->
                                            <div class="modal fade" id="modal_opi">
                                                <div class="modal-dialog modal-xl">
                                                    
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">List Hasil Corr</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body corr">
                                                            <div class="card-body">
                                                                <table class="table table-bordered" id="data_opi">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">Action</th>
                                                                            <th scope="col">Tanggal OPI</th>
                                                                            <th scope="col">Kode</th>
                                                                            <th scope="col">Delivery Time</th>
                                                                            <th scope="col">Customer</th>
                                                                            <th scope="col">Barang</th>
                                                                            <th scope="col">MC</th>
                                                                            <th scope="col">Sheet P</th>
                                                                            <th scope="col">Sheet L</th>
                                                                            <th scope="col">tipe Box</th>
                                                                            <th scope="col">Flute</th>
                                                                            <th scope="col">jumlah Order</th>
                                                                            <th scope="col">Warna</th>
                                                                            <th scope="col">Tipe Order</th>
                                                                            <th scope="col">Finishing</th>
                                                                            <th scope="col">opi</th>
                                                                            <th scope="col">Wax</th>
                                                                            <th scope="col">out Conv</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                        foreach ($opi as $data) { ?>
                                                                            <tr class="modal-opi-list">
                                                                                <td>
                                                                                    <input type="hidden" class="form-control opi-id" value="{{ $data->opiid }}">
                                                                                    <button class="btn btn-success btn-insert-opi" type="button">Add</button>
                                                                                </td>
                                                                                <td>{{ $data->tglopi }}</td>
                                                                                <td>{{ $data->noopi }}</td>
                                                                                <td>{{ $data->tglKirimDt }}</td>
                                                                                <td>{{ $data->Cust }}</td>
                                                                                <td>{{ $data->namaBarang }}</td>
                                                                                <td>
                                                                                    <?php
                                                                                        if ($data->revisimc !== 'R0') {
                                                                                        echo $data->mcKode."-".$data->revisimc;
                                                                                        } else {
                                                                                        echo $data->mcKode;
                                                                                        }
                                                                                    ?>
                                                                                </td>
                                                                                <td>{{ $data->panjangSheet }}</td>
                                                                                <td>{{ $data->lebarSheet }}</td>
                                                                                <td>{{ $data->tipeBox }}</td>
                                                                                <td>{{ $data->flute }}</td>
                                                                                <td>{{ $data->pcsDt }}</td>
                                                                                <td>{{ $data->ccnama }}</td>
                                                                                <td>{{ $data->tipeOrder }}</td>
                                                                                <td>{{ $data->joint }}</td>
                                                                                <td>{{ $data->opiid }}</td>
                                                                                <td>{{ $data->wax }}</td>
                                                                                <td>{{ $data->outConv }}</td>
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
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="card-body">
                        <div class="col-12 table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <th>Urutan</th>
                                    <th>OPI</th>
                                    <th>DT</th>
                                    <th>DT Perubahan</th>
                                    <th>Customer</th>
                                    <th>Item</th>
                                    <th>MC</th>
                                    <th>Panjang</th>
                                    <th>Lebar</th>
                                    <th>Tipe</th>
                                    <th>Berat Box</th>
                                    <th>Flute</th>
                                    <th>Order</th>
                                    {{-- <th>Out Corr</th> --}}
                                    <th>Out Conv</th>
                                    {{-- <th>Lebar Roll</th> --}}
                                    <th>Planning</th>
                                    <th>Berat Planning</th>
                                    <th>Warna</th>
                                    <th>Finishing</th>
                                    <th>Wax</th>
                                    <th>Tipe Order</th>
                                    <th>Bungkus</th>
                                    <th>Lain-Lain</th>
                                    <th>Keterangan</th>
                                    <th>Action</th>
                                </thead>
                                <tbody id="plan-list"></tbody>
                            </table>
                        </div> 
                    </div>
                    <div class="col-md-12" id="planconv" style="margin-bottom: 10px;">
                        
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <br>
                            <button type="button" data-toggle="modal" data-target="#modal_opi" class="btn btn-search">
                                Cari OPI  <i class="fas fa-search"></i>
                            </button>
                            <a class="btn btn-success" href="javascript:void(0);" id="add_button" title="Add field">TAMBAH</a>
                            <button class="btn btn-lg btn-primary" type="submit">SIMPAN
                        </div>
                    </div> 
            </div>
        </div>
    </div>    
</div>
@endsection

@section('javascripts')
<script type="text/javascript">
function getKode() {
    tgl = document.getElementById("tgl").value;
    mesin = document.getElementById("tipemesin").value;
    kode = new Date(tgl);
    kodemesin = mesin.split("||");

    console.log(kodemesin[2]);

    year = kode.getFullYear();
    month = kode.getMonth()+1;
    dd = kode.getDate();

    if (month <= 9 ) {
        month = "0"+ month;
    } 
    if (dd < 9 ) {
        dd =  "0"+dd;
    } 

    console.log(month);

    document.getElementById("kodeplan").value = kodemesin[2]+dd+""+month+""+year;
}

$("#modal_opi").ready(function(){
        
        var table = $("#data_opi").DataTable({
            select: true,
            "initComplete": function (settings, json) {  
            $("#data_opi").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
        },
        });
    });

$(document).on("click", "#modal_opi .btn-insert-opi", function(e) {
    opiid = $(this).closest(".modal-opi-list").find(".opi-id").val();
    var url = "../../opi/single/:opi_id";
    url = url.replace(':opi_id', opiid);

    $.get(url, function(data) {
        var json = (JSON.parse(data));

        console.log(json);

        var html = '';
        html += "<tr class='plan-list'>";
            html += "<td>";
                html += "<input type='hidden' name='opi_id["+ json.opiid +"]' value='"+ json.opiid +"'>";
                html += "<input class='col-md-12' type='text'  name='urutan["+ json.opiid +"]' value=''>";
            html += "</td>";
            html += "<td>"+ json.noopi +"</td>";
            html += "<td>"+ json.tglKirimDt +"</td>";
            html += "<td>";
                html += "<input type='date' name='dt_perubahan["+ json.opiid +"]' value=''>";
            html += "</td>";
            html += "<td>"+ json.Cust +"</td>";
            html += "<td>"+ json.namaBarang +"</td>";
            html += "<td>"+ json.mcKode +"-"+ json.revisimc +"</td>";
            html += "<td>";
                html += "<input type='text' class='col-md-12 panjangSheet' name='panjang["+ json.opiid +"]' value='"+ json.panjangSheet +"' readonly>";
            html += "</td>";
            html += "<td>";
                html += "<input type='text' class='col-md-12 lebarSheet' name='lebar["+ json.opiid +"]' value='"+ json.lebarSheet +"' readonly>";
            html += "</td>";
            html += "<td>";
                html += "<input type='text' class='col-md-12 tipebox' name='tipe["+ json.opiid +"]' value='"+ json.tipeBox +"' readonly>";
            html += "</td>";
            html += "<td>";
                html += "<input type='text' class='gram' name='gram["+ json.opiid +"]' value='"+ json.gram +"' readonly>";
            html += "</td>";
            html += "<td>";
                html += "<input type='text' class='col-md-12' name='flute["+ json.opiid +"]' value='"+ json.flute +"' readonly>";
            html += "</td>";
            html += "<td>";
                html += "<input type='text' class='jml-order' name='jumlahOrder["+ json.opiid +"]' value='"+ json.jumlahOrder +"' readonly>";
            html += "</td>";
            html += "<td>";
                html += "<input type='text' class='col-md-12 outconv' name='outConv["+ json.opiid +"]' value='"+ json.outConv +"' readonly>";
            html += "</td>";
            html += "<td>";
                html += "<input type='text' class='col-md-12 plan' name='plan["+ json.opiid +"]' value='' >";
            html += "</td>";
            html += "<td>";
                html += "<input type='text' class='berat-total' name='berat_total["+ json.opiid +"]' value='' >";
            html += "</td>";
            html += "<td>";
                html += "<input type='text' class='warna' name='warna["+ json.opiid +"]' value='"+ json.namacc +"' readonly>";
            html += "</td>";
            html += "<td>";
                html += "<input type='text' class='joint' name='joint["+ json.opiid +"]' value='"+ json.joint +"' readonly>";
            html += "</td>";
            html += "<td>";
                html += "<input type='text' class='wax' name='wax["+ json.opiid +"]' value='"+ json.wax +"' readonly>";
            html += "</td>";
            html += "<td>";
                html += "<input type='text' class='tipe-order' name='tipe-order["+ json.opiid +"]' value='"+ json.tipeOrder +"' readonly>";
            html += "</td>";
            html += "<td>";
                html += "<input type='text' class='bungkus' name='bungkus["+ json.opiid +"]' value='"+ json.bungkus +"' readonly>";
            html += "</td>";
            html += "<td>";
                html += "<input type='text' class='lain' name='lain["+ json.opiid +"]' value='"+ json.lain +"' readonly>";
            html += "</td>";
            html += "<td>";
                html += "<input type='text' name='keterangan["+ json.opiid +"]' value=''>";
            html += "</td>";
            html += "<td>";
                html += "<button type='button' class='remove-plan btn btn-danger'><i class='fa fa-trash' aria-hidden='true'></i></button>";
            html += "</td>";
        html += "</tr>";
        $("#plan-list").append(html);
    });
    $("#modal_opi").modal("hide");
});

$(document).on("keyup", ".plan", function(e) {
    plan = $(this).val();
    gram = $(this).closest('.plan-list').find('.gram').val();

    totalgram = plan * gram;
    
    $(this).closest(".plan-list").find('.berat-total').val(totalgram.toFixed(2));
});


$(document).on("click", ".remove-plan", function(e) {
    if (confirm('Yakin ingin menghapus OPI ini ?')) {
        $(this).closest(".plan-list").remove();
    }
});
</script>
@endsection