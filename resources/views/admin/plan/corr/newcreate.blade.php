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
                <h4 class="modal-title">Planning Corrugating</h4>
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
                
                <form action="{{ route('corr.newstore') }}"  method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Kode Planning</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control txt_line" name="kodeplan" id="kodeplan" onfocusout="getKode()" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Tanggal</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="date" class="form-control txt_line" name="tgl" id="tgl" autofocus onfocusout="getKode()">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Shift</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control txt_line" name="shift" id="shift">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Note</label>
                                        </div>
                                        <div class="col-md-6">
                                            <textarea name="note" id="note" cols="30" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>RM Total</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control txt_line rm-total" name="rmtotal" id="rmtotal">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Berat Total</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control txt_line berattotal" name="tonasetotal" id="tonasetotal">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="row">    
                                            <!-- Modal -->
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
                                                                            <th scope="col">Toleransi</th>
                                                                            <th scope="col">Jenis Atas</th>
                                                                            <th scope="col">Kertas Atas</th>
                                                                            <th scope="col">Jenis Flute 1</th>
                                                                            <th scope="col">Kertas Flute 1</th>
                                                                            <th scope="col">Jenis Tengah</th>
                                                                            <th scope="col">Kertas Tengah</th>
                                                                            <th scope="col">Jenis Flute 2</th>
                                                                            <th scope="col">Kertas Flute 2</th>
                                                                            <th scope="col">Jenis Bawah</th>
                                                                            <th scope="col">Kertas Bawah</th>
                                                                            <th scope="col">Berat Std Sheet</th>
                                                                            <th scope="col">opi</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                        foreach ($opi as $data) { ?>
                                                                            <tr class="modal-plan-list">
                                                                                <td>
                                                                                    <input type="hidden" class="form-control opi_id" value="{{ $data->opiid }}">
                                                                                    <button class="btn btn-success btn-insert-opi" type="button">Add</button>
                                                                                </td>
                                                                                <td scope="row">{{ $data->noopi }}</td>
                                                                                <td>{{ $data->tglKirimDt }}</td>
                                                                                <td>{{ $data->Cust }}</td>
                                                                                <td>{{ $data->namaBarang }}</td>
                                                                                <td>{{ $data->mcKode }}-{{ $data->revisimc }}</td>
                                                                                <td>{{ $data->panjangSheet }}</td>
                                                                                <td>{{ $data->lebarSheet }}</td>
                                                                                <td>{{ $data->tipeBox }}</td>
                                                                                <td>{{ $data->flute }}</td>
                                                                                <td>{{ $data->pcsDt }}</td>
                                                                                <td>{{ $data->toleransiLebih }}</td>
                                                                                <td>{{ $data->kertasMcAtas }}</td>
                                                                                <td>{{ $data->gramKertasAtas }}</td>
                                                                                <td>{{ $data->kertasMcflute1 }}</td>
                                                                                <td>{{ $data->gramKertasflute1 }}</td>
                                                                                <td>{{ $data->kertasMctengah }}</td>
                                                                                <td>{{ $data->gramKertastengah }}</td>
                                                                                <td>{{ $data->kertasMcflute2 }}</td>
                                                                                <td>{{ $data->gramKertasflute2 }}</td>
                                                                                <td>{{ $data->kertasMcbawah }}</td>
                                                                                <td>{{ $data->gramKertasbawah }}</td>
                                                                                <td>{{ $data->gramSheet }}</td>
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
                                    <th>Toleransi</th>
                                    <th>Panjang</th>
                                    <th>Lebar</th>
                                    <th>Tipe</th>
                                    <th>Flute</th>
                                    <th>Order</th>
                                    <th>Out Corr</th>
                                    <th>Out Conv</th>
                                    <th>Lebar Roll</th>
                                    <th>Planning</th>
                                    <th>Trim (MM)</th>
                                    <th>Cop</th>
                                    <th>Kualitas Atas</th>
                                    <th>Kualitas BF</th>
                                    <th>Kualitas Tengah</th>
                                    <th>Kualitas CF</th>
                                    <th>Kualitas Bawah</th>
                                    <th>Kebutuhan Atas</th>
                                    <th>Kebutuhan BF</th>
                                    <th>Kebutuhan Tengah</th>
                                    <th>Kebutuhan CF</th>
                                    <th>Kebutuhan Bawah</th>
                                    <th>Berat/PCS</th>
                                    <th>RM Order</th>
                                    <th>Berat Order</th>
                                    <th>Keterangan</th>
                                    <th>Action</th>
                                </thead>
                                <tbody id="plan-list"></tbody>
                            </table>
                        </div> 
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <br>
                            <button type="button" data-toggle="modal" data-target="#modal-opi" class="btn btn-search">
                                Cari OPI  <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-lg btn-primary" type="submit">SIMPAN
                        </div>
                    </div>
                </form> 
            </div>
        </div>
    </div>    
</div>
@endsection

@section('javascripts')
<script type="text/javascript">
function getKode() {
    tgl = document.getElementById("tgl").value;
    kode = new Date(tgl);

    year = kode.getFullYear();
    month = kode.getMonth()+1;
    dd = kode.getDate();

    if (month <= 9 ) {
        month = "0"+ month;
    } 
    if (dd < 9 ) {
        dd =  "0"+dd;
    } 

    document.getElementById("kodeplan").value = dd+""+month+""+year;
}

$("#modal-opi").ready(function(){
        
        var table = $("#data_opi").DataTable({
            select: true,
            "initComplete": function (settings, json) {  
            $("#data_opi").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
        },
        });
});

$(document).on("click", "#modal-opi .btn-insert-opi", function(e) {
    opi_id = $(this).closest(".modal-plan-list").find('.opi_id').val();
    var url = "../../opi/single/:opi_id";
    url = url.replace(':opi_id', opi_id);

    $.get(url, function(data) {
    
        var json = (JSON.parse(data));

        if (json.tipeBox == 'DC') {
            toleransi = 2;
        } else if (json.tipeBox == 'B1') {
            toleransi = 5;
        } else {
            toleransi = 0;
        }

        if (json.gramKertasAtas == null) {
            kertas_atas = '';
            gram_atas = 0;
        } else {
            gram_atas = json.gramKertasAtas;
            kertas_atas = json.kertasMcAtas;
        }
        
        if (json.gramKertasflute1 == null) {
            kertas_bf = '';
            gram_bf = 0;
        } else {
            kertas_bf = json.kertasMcflute1;
            gram_bf = json.gramKertasflute1;
        }

        if (json.gramKertastengah == null) {
            kertas_tengah = '';
            gram_tengah = 0;
        } else {
            kertas_tengah = json.kertasMctengah;
            gram_tengah = json.gramKertastengah;
        }

        if (json.gramKertasflute2 == null) {
            kertas_cf = '';
            gram_cf = 0;
        } else {
            kertas_cf = json.kertasMcflute2;
            gram_cf = json.gramKertasflute2;
        }

        if (json.gramKertasbawah == null) {
            kertas_bawah = '';
            gram_bawah = 0;
        } else {
            kertas_bawah = json.kertasMcbawah;
            gram_bawah = json.gramKertasbawah;
        }

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
                html += "<input type='text' class='col-md-12 toleransi' name='toleransi["+ json.opiid +"]' value='"+ toleransi +"'>";
            html += "</td>";
            html += "<td>";
                html += "<input type='text' class='col-md-12 panjangSheet' name='panjang["+ json.opiid +"]' value='"+ json.panjangSheet +"' >";
            html += "</td>";
            html += "<td>";
                html += "<input type='text' class='col-md-12 lebarSheet' name='lebar["+ json.opiid +"]' value='"+ json.lebarSheet +"' readonly>";
            html += "</td>";
            html += "<td>";
                html += "<input type='text' class='col-md-12 tipebox' name='tipe["+ json.opiid +"]' value='"+ json.tipeBox +"' readonly>";
            html += "</td>";
            html += "<td>";
                html += "<input type='text' class='col-md-12' name='flute["+ json.opiid +"]' value='"+ json.flute +"' readonly>";
            html += "</td>";
            html += "<td>";
                html += "<input type='text' class='jml-order' name='jumlahOrder["+ json.opiid +"]' value='"+ json.jumlahOrder +"'>";
            html += "</td>";
            html += "<td>";
                html += "<input type='text' class='col-md-12 out-corr' name='outCorr["+ json.opiid +"]' value=''>";
            html += "</td>";
            html += "<td>";
                html += "<input type='text' class='col-md-12 outconv' name='outConv["+ json.opiid +"]' value='"+ json.outConv +"' readonly>";
            html += "</td>";
            html += "<td>";
                html += "<input type='text' class='lebar-roll' name='lebarRoll["+ json.opiid +"]' value=''>";
            html += "</td>";
            html += "<td>";
                html += "<input type='text' class='col-md-12 plan' name='plan["+ json.opiid +"]' value=''>";
            html += "</td>";
            html += "<td>";
                html += "<input type='text' class='trim' name='trim["+ json.opiid +"]' value='' readonly>";
            html += "</td>";
            html += "<td>";
                html += "<input type='text' class='cop' name='cop["+ json.opiid +"]' value='' readonly>";
            html += "</td>";
            html += "<td>";
                html += "<div class='row' style='width:200px'>";
                    html += "<div class='col-md-6'>";
                        html += "<input class='col-md-12' type='text' name='jenis_atas["+ json.opiid +"]' value='"+ kertas_atas +"'>";
                    html += "</div>";
                    html += "<div class='col-6'>";
                        html += "<input class='col-md-12 gram_atas' type='text' name='gram_atas["+ json.opiid +"]' value='"+ gram_atas +"'>";
                    html += "</div>";
                html += "</div>";
            html += "</td>";
            html += "<td>";
                html += "<div class='row' style='width:200px'>";
                    html += "<div class='col-md-6'>";
                        html += "<input class='col-md-12' type='text' name='jenis_bf["+ json.opiid +"]' value='"+ kertas_bf +"'>";
                    html += "</div>";
                    html += "<div class='col-6'>";
                        html += "<input class='col-md-12 gram_bf' type='text' name='gram_bf["+ json.opiid +"]' value='"+ gram_bf +"'>";
                    html += "</div>";
                html += "</div>";
            html += "</td>";
            html += "<td>";
                html += "<div class='row' style='width:200px'>";
                    html += "<div class='col-md-6'>";
                        html += "<input class='col-md-12' type='text' name='jenis_tengah["+ json.opiid +"]' value='"+ kertas_tengah +"'>";
                    html += "</div>";
                    html += "<div class='col-6'>";
                        html += "<input class='col-md-12 gram_tengah' type='text' name='gram_tengah["+ json.opiid +"]' value='"+ gram_tengah +"'>";
                    html += "</div>";
                html += "</div>";
            html += "</td>";
            html += "<td>";
                html += "<div class='row' style='width:200px'>";
                    html += "<div class='col-md-6'>";
                        html += "<input class='col-md-12' type='text' name='jenis_cf["+ json.opiid +"]' value='"+ kertas_cf +"'>";
                    html += "</div>";
                    html += "<div class='col-6'>";
                        html += "<input class='col-md-12 gram_cf' type='text' name='gram_cf["+ json.opiid +"]' value='"+ gram_cf +"'>";
                    html += "</div>";
                html += "</div>";
            html += "</td>";
            html += "<td>";
                html += "<div class='row' style='width:200px'>";
                    html += "<div class='col-md-6'>";
                        html += "<input class='col-md-12' type='text' name='jenis_bawah["+ json.opiid +"]' value='"+ kertas_bawah +"'>";
                    html += "</div>";
                    html += "<div class='col-6'>";
                        html += "<input class='col-md-12 gram_bawah' type='text' name='gram_bawah["+ json.opiid +"]' value='"+ gram_bawah +"'>";
                    html += "</div>";
                html += "</div>";
            html += "</td>";
            html += "<td>";
                html += "<input type='text' class='col-md-12 line-atas' name='kebutuhan_atas["+ json.opiid +"]' value='' readonly>";
            html += "</td>";
            html += "<td>";
                html += "<input type='text' class='col-md-12 flute-bf' name='kebutuhan_bf["+ json.opiid +"]' value='' readonly>";
            html += "</td>";
            html += "<td>";
                html += "<input type='text' class='col-md-12 line-tengah' name='kebutuhan_tengah["+ json.opiid +"]' value='' readonly>";
            html += "</td>";
            html += "<td>";
                html += "<input type='text' class='col-md-12 flute-cf' name='kebutuhan_cf["+ json.opiid +"]' value='' readonly>";
            html += "</td>";
            html += "<td>";
                html += "<input type='text' class='col-md-12 line-bawah' name='kebutuhan_bawah["+ json.opiid +"]' value='' readonly>";
            html += "</td>";
            html += "<td>";
                html += "<input type='text' class='gram-box' name='gram["+ json.opiid +"]' value='"+ json.gramcorr.toFixed(2) +"' readonly>";
            html += "</td>";
            html += "<td>";
                html += "<input type='text' class='rm-order' name='rm_order["+ json.opiid +"]' value='' readonly>";
            html += "</td>";
            html += "<td>";
                html += "<input type='text' class='tonase' name='tonase["+ json.opiid +"]' value='' readonly>";
            html += "</td>";
            html += "<td>";
                html += "<textarea name='keterangan["+ json.opiid +"]' id='keterangan' cols='30' rows='5'></textarea>";
                // html += "<input type='text' name='keterangan["+ json.opiid +"]' value=''>";
            html += "</td>";
            html += "<td>";
                html += "<button type='button' class='remove-plan btn btn-danger'><i class='fa fa-trash' aria-hidden='true'></i></button>";
            html += "</td>";
        html += "</tr>";
        $("#plan-list").append(html);
    });
    $("#modal-opi").modal("hide");
});

$(document).on("keyup", ".out-corr", function(e) {
    outcorr = $(this).val();
    lebar = $(this).closest(".plan-list").find(".lebarSheet").val();
    panjang = $(this).closest(".plan-list").find(".panjangSheet").val();
    outconv = $(this).closest(".plan-list").find(".outconv").val();
    order = $(this).closest(".plan-list").find(".jml-order").val();
    toleransi = $(this).closest(".plan-list").find(".toleransi").val();
    gram = $(this).closest(".plan-list").find(".gram-box").val();
    tipebox = $(this).closest(".plan-list").find(".tipebox").val();
    gram_atas = $(this).closest(".plan-list").find(".gram_atas").val();
    gram_bf = $(this).closest(".plan-list").find(".gram_bf").val();
    gram_tengah = $(this).closest(".plan-list").find(".gram_tengah").val();
    gram_cf = $(this).closest(".plan-list").find(".gram_cf").val();
    gram_bawah = $(this).closest(".plan-list").find(".gram_bawah").val();

    rmtotal = document.getElementById("rmtotal").value;

    if (tipebox === 'DC') {
        UkRoll = Math.ceil(((outcorr*lebar)+20)/50)*50;
    } else {
        UkRoll =Math.ceil(((outcorr*lebar)+30)/50)*50;
    }

    qtyPlan =  (Math.round(order) + Math.round(order*(toleransi/100)))/outconv;
    cop = parseInt(qtyPlan)/ parseInt(outcorr);
    trim = (UkRoll - (lebar * outcorr));

    if (trim < 30 && tipebox === 'B1') {
        trim = trim + 50;
        UkRoll = UkRoll + 50;
    }
    if (trim < 20 && tipebox === 'DC') {
        trim = trim + 20;
        UkRoll = UkRoll + 50;
    }

    console.log(Math.round(order*(toleransi/100)));

    rmorder = ((panjang * cop) / 1000).toFixed(0);
    tonase = qtyPlan * gram;

    if (rmtotal === '') {
        rmtotal = rmorder
    } else {
        rmtotal = rmtotal + rmorder
    }

    KAtas = rmorder * (UkRoll/1000)*gram_atas/1000;
    $(this).closest(".plan-list").find(".line-atas").val(Math.round(KAtas));
    KFlute1 = rmorder*(UkRoll/1000)*(gram_bf/1000)*1.36;
    $(this).closest(".plan-list").find(".flute-bf").val(Math.round(KFlute1));
    KTengah = rmorder*(UkRoll/1000)*gram_tengah/1000;
    $(this).closest(".plan-list").find(".line-tengah").val(Math.round(KTengah));
    KFlute2 = rmorder*(UkRoll/1000)*(gram_cf/1000)*1.46;
    $(this).closest(".plan-list").find(".flute-cf").val(Math.round(KFlute2));
    KBawah = rmorder*(UkRoll/1000)*gram_bawah/1000;
    $(this).closest(".plan-list").find(".line-bawah").val(Math.round(KBawah));

    $(this).closest(".plan-list").find(".plan").val(qtyPlan);
    $(this).closest(".plan-list").find(".lebar-roll").val(UkRoll);
    $(this).closest(".plan-list").find(".cop").val(cop.toFixed(0));
    $(this).closest(".plan-list").find(".trim").val(trim.toFixed(0));
    $(this).closest(".plan-list").find(".rm-order").val(rmorder);
    $(this).closest(".plan-list").find(".tonase").val(tonase.toFixed(0));
    // document.getElementById("rmtotal").value = rmtotal;

})

$(document).on("keyup", ".panjangSheet", function(e) {
    panjang = $(this).val();
    plan = $(this).closest(".plan-list").find(".plan").val();
    outconv = $(this).closest(".plan-list").find(".outconv").val();
    outcorr = $(this).closest(".plan-list").find(".out-corr").val();
    UkRoll = $(this).closest(".plan-list").find(".lebar-roll").val();
    order = $(this).closest(".plan-list").find(".jml-order").val();
    toleransi = $(this).closest(".plan-list").find(".toleransi").val();
    lebar = $(this).closest(".plan-list").find(".lebarSheet").val();
    cop = $(this).closest(".plan-list").find(".cop").val();
    gram = $(this).closest(".plan-list").find(".gram-box").val();
    gram_atas = $(this).closest(".plan-list").find(".gram_atas").val();
    gram_bf = $(this).closest(".plan-list").find(".gram_bf").val();
    gram_tengah = $(this).closest(".plan-list").find(".gram_tengah").val();
    gram_cf = $(this).closest(".plan-list").find(".gram_cf").val();
    gram_bawah = $(this).closest(".plan-list").find(".gram_bawah").val();


    if (gram_atas == 'null') {
        gram_atas = 0;
    }
    if (gram_bf == 'null') {
        gram_bf = 0;
    }
    if (gram_tengah == 'null') {
        gram_tengah = 0;
    }
    if (gram_cf == 'null') {
        gram_cf = 0;
    }

    if (plan == 0) {
        qtyPlan =  (parseInt(order) + parseInt(order*(toleransi/100)))/outconv;
    } else {
        qtyPlan = $(this).closest(".plan-list").find(".plan").val();
    }

    if (outcorr == '') {
        outcorr = 0;
    }
    if (UkRoll == '') {
        if (tipebox === 'DC') {
            UkRoll = Math.ceil(((outcorr*lebar)+20)/50)*50;
        } else {
            UkRoll =Math.ceil(((outcorr*lebar)+30)/50)*50;
        }
    }

    if (cop == '') {
        cop = parseInt(qtyPlan)/ parseInt(outcorr);
    } else {
        cop = parseInt(cop);
    }

    brt_kualitas = (parseInt(gram_atas) + (parseInt(gram_bf) * 1.36) + parseInt(gram_tengah) + (parseInt(gram_cf) * 1.46) + parseInt(gram_bawah))/1000;
    luas = parseInt(panjang) * parseInt(lebar) / 1000000;
    gram = brt_kualitas * luas;

    tonase = qtyPlan * gram.toFixed(2) ;

    trim = (UkRoll - (lebar * outcorr));

    if (trim < 30 && tipebox === 'B1') {
        trim = trim + 30;
        UkRoll = UkRoll + 50;
    } else if (trim < 20 && tipebox === 'DC') {
        trim = trim + 20;
        UkRoll = UkRoll + 50;
    }

    rmorder = ((panjang * cop) / 1000).toFixed(0);

    KAtas = rmorder*(UkRoll/1000)*gram_atas/1000;
    $(this).closest(".plan-list").find(".line-atas").val(Math.round(KAtas));
    KFlute1 = rmorder*(UkRoll/1000)*(gram_bf/1000)*1.36;
    $(this).closest(".plan-list").find(".flute-bf").val(Math.round(KFlute1));
    KTengah = rmorder*(UkRoll/1000)*gram_tengah/1000;
    $(this).closest(".plan-list").find(".line-tengah").val(Math.round(KTengah));
    KFlute2 = rmorder*(UkRoll/1000)*(gram_cf/1000)*1.46;
    $(this).closest(".plan-list").find(".flute-cf").val(Math.round(KFlute2));
    KBawah = rmorder*(UkRoll/1000)*gram_bawah/1000;
    $(this).closest(".plan-list").find(".line-bawah").val(Math.round(KBawah));
        
    $(this).closest(".plan-list").find(".gram-box").val(gram.toFixed(2))
    $(this).closest(".plan-list").find(".plan").val(qtyPlan);
    $(this).closest(".plan-list").find(".lebar-roll").val(UkRoll);
    $(this).closest(".plan-list").find(".cop").val(cop.toFixed(0));
    $(this).closest(".plan-list").find(".trim").val(trim.toFixed(0));
    $(this).closest(".plan-list").find(".rm-order").val(rmorder);
    $(this).closest(".plan-list").find(".tonase").val(tonase.toFixed(0));
});

$(document).on("keyup", ".lebar-roll", function(e) {
    roll = $(this).val();
    lebar = $(this).closest(".plan-list").find(".lebarSheet").val();
    outcorr = $(this).closest(".plan-list").find(".out-corr").val();
    rmorder = $(this).closest(".plan-list").find(".rm-order").val();
    gram = $(this).closest(".plan-list").find(".gram-box").val();
    gram_atas = $(this).closest(".plan-list").find(".gram_atas").val();
    gram_bf = $(this).closest(".plan-list").find(".gram_bf").val();
    gram_tengah = $(this).closest(".plan-list").find(".gram_tengah").val();
    gram_cf = $(this).closest(".plan-list").find(".gram_cf").val();
    gram_bawah = $(this).closest(".plan-list").find(".gram_bawah").val();
    
    if (outcorr == '') {
        outcorr = 0;
    }

    trim = (roll - (lebar * outcorr));

    if (trim < 30 && tipebox === 'B1') {
        trim = trim + 50;
        UkRoll = UkRoll + 50;
    } else if (trim < 20 && tipebox === 'DC') {  
        trim = trim + 20;
        UkRoll = UkRoll + 50;
    }

    KAtas = rmorder*(roll/1000)*gram_atas/1000;
    $(this).closest(".plan-list").find(".line-atas").val(Math.round(KAtas));
    KFlute1 = rmorder*(roll/1000)*(gram_bf/1000)*1.36;
    $(this).closest(".plan-list").find(".flute-bf").val(Math.round(KFlute1));
    KTengah = rmorder*(roll/1000)*gram_tengah/1000;
    $(this).closest(".plan-list").find(".line-tengah").val(Math.round(KTengah));
    KFlute2 = rmorder*(roll/1000)*(gram_cf/1000)*1.46;
    $(this).closest(".plan-list").find(".flute-cf").val(Math.round(KFlute2));
    KBawah = rmorder*(roll/1000)*gram_bawah/1000;
    $(this).closest(".plan-list").find(".line-bawah").val(Math.round(KBawah));

    
    $(this).closest(".plan-list").find(".trim").val(trim.toFixed(2));
})

$(document).on("click", ".remove-plan", function(e) {
    if (confirm('Yakin ingin menghapus OPI ini ?')) {
        $(this).closest(".plan-list").remove();
    }
});

$(document).on("keyup", ".gram_atas", function(e) {
    gram_atas = $(this).val()
    plan = $(this).closest(".plan-list").find(".plan").val();
    gram_bf = $(this).closest(".plan-list").find(".gram_bf").val();
    gram_tengah = $(this).closest(".plan-list").find(".gram_tengah").val();
    gram_cf = $(this).closest(".plan-list").find(".gram_cf").val();
    gram_bawah = $(this).closest(".plan-list").find(".gram_bawah").val();
    lebar = $(this).closest(".plan-list").find(".lebarSheet").val();
    panjang = $(this).closest(".plan-list").find(".panjangSheet").val();
    rmorder = $(this).closest(".plan-list").find(".rm-order").val();
    roll = $(this).closest(".plan-list").find(".lebar-roll").val();
    
    berat_kualitas = ((Math.round(gram_atas)+(Math.round(gram_bf)*1.36)+Math.round(gram_tengah)+(Math.round(gram_cf)*1.46)+Math.round(gram_bawah))/1000)
    luas = (Math.round(panjang)*Math.round(lebar)/1000000)

    berat = (berat_kualitas * luas).toFixed(2)
    tonase = berat * plan

    KAtas = rmorder*(roll/1000)*gram_atas/1000;
    $(this).closest(".plan-list").find(".line-atas").val(Math.round(KAtas));
    $(this).closest(".plan-list").find(".gram-box").val(berat);
    $(this).closest(".plan-list").find(".tonase").val(Math.round(tonase));
})


$(document).on("keyup", ".gram_bf", function(e) {
    gram_bf = $(this).val()
    plan = $(this).closest(".plan-list").find(".plan").val();
    gram_atas = $(this).closest(".plan-list").find(".gram_atas").val();
    gram_tengah = $(this).closest(".plan-list").find(".gram_tengah").val();
    gram_cf = $(this).closest(".plan-list").find(".gram_cf").val();
    gram_bawah = $(this).closest(".plan-list").find(".gram_bawah").val();
    lebar = $(this).closest(".plan-list").find(".lebarSheet").val();
    panjang = $(this).closest(".plan-list").find(".panjangSheet").val();
    rmorder = $(this).closest(".plan-list").find(".rm-order").val();
    roll = $(this).closest(".plan-list").find(".lebar-roll").val();
    
    berat_kualitas = ((Math.round(gram_atas)+(Math.round(gram_bf)*1.36)+Math.round(gram_tengah)+(Math.round(gram_cf)*1.46)+Math.round(gram_bawah))/1000)
    luas = (Math.round(panjang)*Math.round(lebar)/1000000)

    berat = (berat_kualitas * luas).toFixed(2)
    tonase = berat * plan
    
    kebutuhan_bf = rmorder*(roll/1000)*gram_bf/1000*1.36;
    $(this).closest(".plan-list").find(".flute-bf").val(Math.round(kebutuhan_bf));
    $(this).closest(".plan-list").find(".gram-box").val(berat);
    $(this).closest(".plan-list").find(".tonase").val(Math.round(tonase));
})

$(document).on("keyup", ".gram_tengah", function(e) {
    gram_tengah = $(this).val()
    plan = $(this).closest(".plan-list").find(".plan").val();
    gram_atas = $(this).closest(".plan-list").find(".gram_atas").val();
    gram_bf = $(this).closest(".plan-list").find(".gram_bf").val();
    gram_cf = $(this).closest(".plan-list").find(".gram_cf").val();
    gram_bawah = $(this).closest(".plan-list").find(".gram_bawah").val();
    lebar = $(this).closest(".plan-list").find(".lebarSheet").val();
    panjang = $(this).closest(".plan-list").find(".panjangSheet").val();
    rmorder = $(this).closest(".plan-list").find(".rm-order").val();
    roll = $(this).closest(".plan-list").find(".lebar-roll").val();
    
    berat_kualitas = ((Math.round(gram_atas)+(Math.round(gram_bf)*1.36)+Math.round(gram_tengah)+(Math.round(gram_cf)*1.46)+Math.round(gram_bawah))/1000)
    luas = (Math.round(panjang)*Math.round(lebar)/1000000)

    berat = (berat_kualitas * luas).toFixed(2)
    tonase = berat * plan
    
    kebutuhan_tengah = rmorder*(roll/1000)*gram_tengah/1000;
    $(this).closest(".plan-list").find(".line-tengah").val(Math.round(kebutuhan_tengah));
    $(this).closest(".plan-list").find(".gram-box").val(berat);
    $(this).closest(".plan-list").find(".tonase").val(Math.round(tonase));
})

$(document).on("keyup", ".gram_cf", function(e) {
    gram_cf = $(this).val()
    plan = $(this).closest(".plan-list").find(".plan").val();
    gram_atas = $(this).closest(".plan-list").find(".gram_atas").val();
    gram_bf = $(this).closest(".plan-list").find(".gram_bf").val();
    gram_tengah = $(this).closest(".plan-list").find(".gram_tengah").val();
    gram_bawah = $(this).closest(".plan-list").find(".gram_bawah").val();
    lebar = $(this).closest(".plan-list").find(".lebarSheet").val();
    panjang = $(this).closest(".plan-list").find(".panjangSheet").val();
    rmorder = $(this).closest(".plan-list").find(".rm-order").val();
    roll = $(this).closest(".plan-list").find(".lebar-roll").val();
    
    berat_kualitas = ((Math.round(gram_atas)+(Math.round(gram_bf)*1.36)+Math.round(gram_tengah)+(Math.round(gram_cf)*1.46)+Math.round(gram_bawah))/1000)
    luas = (Math.round(panjang)*Math.round(lebar)/1000000)

    berat = (berat_kualitas * luas).toFixed(2)
    tonase = berat * plan
    
    kebutuhan_cf = rmorder*(roll/1000)*gram_cf/1000*1.46;
    $(this).closest(".plan-list").find(".flute-cf").val(Math.round(kebutuhan_cf));
    $(this).closest(".plan-list").find(".gram-box").val(berat);
    $(this).closest(".plan-list").find(".tonase").val(Math.round(tonase));
})

$(document).on("keyup", ".gram_bawah", function(e) {
    gram_bawah = $(this).val()
    plan = $(this).closest(".plan-list").find(".plan").val();
    gram_atas = $(this).closest(".plan-list").find(".gram_atas").val();
    gram_bf = $(this).closest(".plan-list").find(".gram_bf").val();
    gram_tengah = $(this).closest(".plan-list").find(".gram_tengah").val();
    gram_cf = $(this).closest(".plan-list").find(".gram_cf").val();
    lebar = $(this).closest(".plan-list").find(".lebarSheet").val();
    panjang = $(this).closest(".plan-list").find(".panjangSheet").val();
    rmorder = $(this).closest(".plan-list").find(".rm-order").val();
    roll = $(this).closest(".plan-list").find(".lebar-roll").val();
    
    berat_kualitas = ((Math.round(gram_atas)+(Math.round(gram_bf)*1.36)+Math.round(gram_tengah)+(Math.round(gram_cf)*1.46)+Math.round(gram_bawah))/1000)
    luas = (Math.round(panjang)*Math.round(lebar)/1000000)

    berat = (berat_kualitas * luas).toFixed(2)
    tonase = berat * plan
    
    kebutuhan_bawah = rmorder*(roll/1000)*gram_bawah/1000;
    $(this).closest(".plan-list").find(".line-bawah").val(Math.round(kebutuhan_bawah));
    $(this).closest(".plan-list").find(".gram-box").val(berat);
    $(this).closest(".plan-list").find(".tonase").val(Math.round(tonase));
})


$(document).on("keyup", ".jml-order", function(e) {
    order = $(this).val()
    lebar = $(this).closest(".plan-list").find(".lebarSheet").val();
    panjang = $(this).closest(".plan-list").find(".panjangSheet").val();
    outconv = $(this).closest(".plan-list").find(".outconv").val();
    outcorr = $(this).closest(".plan-list").find(".out-corr").val();
    toleransi = $(this).closest(".plan-list").find(".toleransi").val();
    gram = $(this).closest(".plan-list").find(".gram-box").val();
    tipebox = $(this).closest(".plan-list").find(".tipebox").val();
    gram_atas = $(this).closest(".plan-list").find(".gram_atas").val();
    gram_bf = $(this).closest(".plan-list").find(".gram_bf").val();
    gram_tengah = $(this).closest(".plan-list").find(".gram_tengah").val();
    gram_cf = $(this).closest(".plan-list").find(".gram_cf").val();
    gram_bawah = $(this).closest(".plan-list").find(".gram_bawah").val();
    roll = $(this).closest(".plan-list").find(".lebar-roll").val()

    qtyPlan =  (parseInt(order) + parseInt(order*(toleransi/100)))/outconv;
    cop = parseInt(qtyPlan)/ parseInt(outcorr);

    rmorder = ((panjang * cop) / 1000).toFixed(0);
    tonase = qtyPlan * gram;

    KAtas = rmorder * (roll/1000)*gram_atas/1000;
    $(this).closest(".plan-list").find(".line-atas").val(Math.round(KAtas));
    KFlute1 = rmorder*(roll/1000)*(gram_bf/1000)*1.36;
    $(this).closest(".plan-list").find(".flute-bf").val(Math.round(KFlute1));
    KTengah = rmorder*(roll/1000)*gram_tengah/1000;
    $(this).closest(".plan-list").find(".line-tengah").val(Math.round(KTengah));
    KFlute2 = rmorder*(roll/1000)*(gram_cf/1000)*1.46;
    $(this).closest(".plan-list").find(".flute-cf").val(Math.round(KFlute2));
    KBawah = rmorder*(roll/1000)*gram_bawah/1000;
    $(this).closest(".plan-list").find(".line-bawah").val(Math.round(KBawah));

    $(this).closest(".plan-list").find(".plan").val(qtyPlan);
    // $(this).closest(".plan-list").find(".lebar-roll").val(UkRoll);
    $(this).closest(".plan-list").find(".cop").val(cop.toFixed(0));
    // $(this).closest(".plan-list").find(".trim").val(trim.toFixed(2));
    $(this).closest(".plan-list").find(".rm-order").val(rmorder);
    $(this).closest(".plan-list").find(".tonase").val(tonase.toFixed(0));


})
</script>
@endsection