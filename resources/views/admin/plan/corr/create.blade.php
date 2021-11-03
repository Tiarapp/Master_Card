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
                
                <form action="{{ route('corr.store') }}"  method="POST">
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
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="row">
                                            
                                            <!-- Modal -->
                                            <div class="modal fade" id="Opi">
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
                                                                            <tr>
                                                                                <td scope="row">{{ $data->nama }}</td>
                                                                                <td>{{ $data->tglKirimDt }}</td>
                                                                                <td>{{ $data->Cust }}</td>
                                                                                <td>{{ $data->namaBarang }}</td>
                                                                                <td>{{ $data->mcKode }}</td>
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
                    <div class="col-md-12" id="plancorr" style="margin-bottom: 10px;">
                        
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <br>
                            <button type="button" data-toggle="modal" data-target="#Opi" class="btn btn-search">
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


    console.log(month);

    document.getElementById("kodeplan").value = dd+""+month+""+year;
}

$(document).ready(function(){
    var countrow = 1; //Input fields increment limitation
    var countdata = 1; //Input fields increment limitation
    var addButton = $('#add_button'); //Add button selector

    //Once add button is clicked
    $(addButton).click(function(){
        $("#plancorr").append("<div class='row' style='margin-top:20px;'> <div class='col-md-12' style='border-top: 1px solid rgb(194, 175, 175); padding-top: 5px;'>  <div class='row'> <div class='col-md-1'>  <label>No Opi</label> </div> <div class='col-md-2'>  <input type='text' class='form-control txt_line' name='noOpi["+countrow+"]' id='noOpi["+countrow+"]'> <input type='hidden' class='form-control txt_line' name='toleransi["+countrow+"]' id='toleransi["+countrow+"]'> <input type='hidden' class='form-control txt_line' name='opi_id["+countrow+"]' id='opi_id["+countrow+"]'> </div> <div class='col-md-1'>  <label>DT</label> </div> <div class='col-md-2'>  <input type='date' class='form-control txt_line' name='dt["+countrow+"]' id='dt["+countrow+"]'> </div> <div class='col-md-1'>  <label>Customer</label> </div> <div class='col-md-2'>  <input type='text' class='form-control txt_line' name='customer["+countrow+"]' id='customer["+countrow+"]'> </div> <div class='col-md-1'>  <label>Item</label> </div> <div class='col-md-2'>  <input type='text' class='form-control txt_line' name='item["+countrow+"]' id='item["+countrow+"]'> </div> </div>  <div class='row'> <div class='col-md-1'>  <label>MC</label> </div> <div class='col-md-2'>  <input type='text' class='form-control txt_line' name='mc["+countrow+"]' id='mc["+countrow+"]'> </div> <div class='col-md-1'>  <label>P x L</label> </div> <div class='col-md-2'>  <div class='row'> <div class='col-md-5'> <input type='text' class='form-control txt_line' name='sheetp["+countrow+"]' id='sheetp["+countrow+"]'> </div> <div class='col-md-2'> <label for=''>X</label> </div> <div class='col-md-5'> <input type='text' class='form-control txt_line' name='sheetl["+countrow+"]' id='sheetl["+countrow+"]'> </div> </div> </div> <div class='col-md-1'> <label>Tipe / Flute</label> </div> <div class='col-md-2'> <div class='row'> <div class='col-md-5'> <input type='text' class='form-control txt_line' name='tipebox["+countrow+"]' id='tipebox["+countrow+"]'> </div> <div class='col-md-2'> <label for=''>/</label> </div> <div class='col-md-5'> <input type='text' class='form-control txt_line' name='flute["+countrow+"]' id='flute["+countrow+"]'> </div> </div> </div> <div class='col-md-1'> <label>Order</label> </div> <div class='col-md-2'>  <input type='text' class='form-control txt_line' name='order["+countrow+"]' id='order["+countrow+"]'> </div>  </div>  <div class='row'> <div class='col-md-1'>  <label>Out Corr / Out Flexo</label> </div> <div class='col-md-2'>  <div class='row'>   <div class='col-md-5'>  <input type='number' class='form-control txt_line' name='outCorr["+countrow+"]' id='outCorr["+countrow+"]'>   </div>   <div class='col-md-2'>  <label for=''>/</label>  </div>   <div class='col-md-5'>  <input type='number' class='form-control txt_line' name='outFlexo["+countrow+"]' id='outFlexo["+countrow+"]'>   </div>  </div> </div> <div class='col-md-1'>  <label>Lebar Roll</label> </div> <div class='col-md-2'>  <input type='text' class='form-control txt_line' name='roll["+countrow+"]' id='roll["+countrow+"]'> </div> <div class='col-md-1'>  <label>Plan</label> </div> <div class='col-md-2'>  <input type='text' class='form-control txt_line' name='plan["+countrow+"]' id='plan["+countrow+"]'> </div> <div class='col-md-1'>  <label>trim / cop</label> </div> <div class='col-md-2'>  <div class='row'>   <div class='col-md-5'>  <input type='text' class='form-control txt_line' name='trim["+countrow+"]' id='trim["+countrow+"]'>   </div>   <div class='col-md-2'>  <label for=''>/</label>  </div>   <div class='col-md-5'>  <input type='text' class='form-control txt_line' name='cop["+countrow+"]' id='cop["+countrow+"]'>   </div>  </div> </div>  </div>  <div class='row' style='margin-botton:5px;'> <div class='col-md-1'>  <label>K. Atas</label> </div> <div class='col-md-1'>  <input type='text' class='form-control txt_line' name='kertasAtas["+countrow+"]' id='kertasAtas["+countrow+"]'> <input type='hidden' class='form-control txt_line' name='gramAtas["+countrow+"]' id='gramAtas["+countrow+"]'> </div> <div class='col-md-1'>  <label>K. Flute1</label> </div> <div class='col-md-1'>  <input type='text' class='form-control txt_line' name='kertasFlute1["+countrow+"]' id='kertasFlute1["+countrow+"]'> <input type='hidden' class='form-control txt_line' name='gramFlute1["+countrow+"]' id='gramFlute1["+countrow+"]'> </div> <div class='col-md-1'>  <label>K. Tengah</label> </div> <div class='col-md-1'>  <input type='text' class='form-control txt_line' name='kertasTengah["+countrow+"]' id='kertasTengah["+countrow+"]'> <input type='hidden' class='form-control txt_line' name='gramTengah["+countrow+"]' id='gramTengah["+countrow+"]'> </div> <div class='col-md-1'>  <label>K. Flute2</label> </div> <div class='col-md-1'>  <input type='text' class='form-control txt_line' name='kertasFlute2["+countrow+"]' id='kertasFlute2["+countrow+"]'> <input type='hidden' class='form-control txt_line' name='gramFlute2["+countrow+"]' id='gramFlute2["+countrow+"]'> </div> <div class='col-md-1'>  <label>K. Bawah</label> </div> <div class='col-md-1'>  <input type='text' class='form-control txt_line' name='kertasBawah["+countrow+"]' id='kertasBawah["+countrow+"]'> <input type='hidden' class='form-control txt_line' name='gramBawah["+countrow+"]' id='gramBawah["+countrow+"]'> </div>  </div>  <div class='row'> <div class='col-md-1'>  <label>Kebutuhan Atas</label> </div> <div class='col-md-1'>  <input type='text' class='form-control txt_line' name='kebutuhanAtas["+countrow+"]' id='kebutuhanAtas["+countrow+"]'> </div> <div class='col-md-1'>  <label>Kebutuhan Flute1</label> </div> <div class='col-md-1'>  <input type='text' class='form-control txt_line' name='kebutuhanFlute1["+countrow+"]' id='kebutuhanFlute1["+countrow+"]'> </div> <div class='col-md-1'>  <label>Kebutuhan Tengah</label> </div> <div class='col-md-1'>  <input type='text' class='form-control txt_line' name='kebutuhanTengah["+countrow+"]' id='kebutuhanTengah["+countrow+"]'> </div> <div class='col-md-1'>  <label>Kebutuhan Flute2</label> </div> <div class='col-md-1'>  <input type='text' class='form-control txt_line' name='kebutuhanFlute2["+countrow+"]' id='kebutuhanFlute2["+countrow+"]'> </div> <div class='col-md-1'>  <label>Kebutuhan Bawah</label> </div> <div class='col-md-1'>  <input type='text' class='form-control txt_line' name='kebutuhanBawah["+countrow+"]' id='kebutuhanBawah["+countrow+"]'> </div>  </div>  <div class='row'> <div class='col-md-1'>  <label>Berat/Pcs</label> </div> <div class='col-md-1'>  <input type='text' class='form-control txt_line' name='beratSheet["+countrow+"]' id='beratSheet["+countrow+"]'> </div> <div class='col-md-1'>  <label>RM Order</label> </div> <div class='col-md-1'>  <input type='text' class='form-control txt_line' name='rmorder["+countrow+"]' id='rmorder["+countrow+"]'> </div> <div class='col-md-1'>  <label>Berat Order</label> </div> <div class='col-md-1'>  <input type='text' class='form-control txt_line' name='beratOrder["+countrow+"]' id='beratOrder["+countrow+"]'> </div> <div class='col-md-1'>  <label>urutan</label> </div> <div class='col-md-1'>  <input type='text' class='form-control txt_line' name='urutan["+countrow+"]' id='urutan["+countrow+"]'> </div> <div class='col-md-1'>  <a href='javascript:void(0);' class='btn btn-success' name='btn"+countrow+"' id='btn"+countrow+"'>Calculate</a> </div> </div> <div class='row' style='margin-top:10px'> <div class='col-md-1'>  <label>Keterangan</label> </div> <div class='col-md-10'> <input type='text' name='keterangan["+countrow+"]' id='keterangan["+countrow+"]' style='width:1000px'> </div> </div> </div> </div> </div>");


        $("#btn"+countdata).click(function() {
            // var data = countdata;
            var  outCorr = document.getElementById("outCorr["+countdata+"]").value;
            var  sheetl = document.getElementById("sheetl["+countdata+"]").value;
            var  sheetp = document.getElementById("sheetp["+countdata+"]").value;
            var  outConv = document.getElementById("outFlexo["+countdata+"]").value;
            var  order = document.getElementById("order["+countdata+"]").value;
            var  toleransi = document.getElementById("toleransi["+countdata+"]").value;
            var  gramSheet = document.getElementById("beratSheet["+countdata+"]").value;
            var  tipebox = document.getElementById("tipebox["+countdata+"]").value;
            var gAtas =document.getElementById("gramAtas["+countdata+"]").value
            var gFlute1 =document.getElementById("gramFlute1["+countdata+"]").value
            var gTengah =document.getElementById("gramTengah["+countdata+"]").value
            var gFlute2 =document.getElementById("gramFlute2["+countdata+"]").value
            var gBawah =document.getElementById("gramBawah["+countdata+"]").value


            qtyPlan =  parseInt(order) + (order*(toleransi/100)/outConv);
            
            if (tipebox = 'DC') {
                UkRoll = Math.ceil(((outCorr*sheetl)+20)/50)*50;
            } else {
                UkRoll =Math.ceil(((outCorr*sheetl)+30)/50)*50;
            }

            cop = qtyPlan/outCorr;

            trim = (UkRoll-(sheetl*outCorr))/UkRoll;

            rmorder = (sheetp*cop)/1000;

            tonase = qtyPlan*gramSheet;

            if (gAtas != '') {
                KAtas = rmorder*(UkRoll/1000)*gAtas/1000;
                document.getElementById("kebutuhanAtas["+countdata+"]").value = Math.round(KAtas);
            } 
            if (gFlute1 != '') {
                KFlute1 = rmorder*(UkRoll/1000)*(gFlute1/1000)*1.34;
                document.getElementById("kebutuhanFlute1["+countdata+"]").value = Math.round(KFlute1);
            } 
            if (gTengah != '') {
                KTengah = rmorder*(UkRoll/1000)*gTengah/1000;
                document.getElementById("kebutuhanTengah["+countdata+"]").value = Math.round(KTengah);
            } 
            if (gFlute2 != '') {
                KFlute2 = rmorder*(UkRoll/1000)*(gFlute2/1000)*1.42;
                document.getElementById("kebutuhanFlute2["+countdata+"]").value = Math.round(KFlute2);
            } 
            if (gBawah != '') {
                KBawah = rmorder*(UkRoll/1000)*gBawah/1000;
                document.getElementById("kebutuhanBawah["+countdata+"]").value = Math.round(KBawah);
            } 

            document.getElementById("plan["+countdata+"]").value = qtyPlan.toFixed(2);
            document.getElementById("roll["+countdata+"]").value = UkRoll.toFixed(2);
            document.getElementById("cop["+countdata+"]").value = cop.toFixed(2);
            document.getElementById("trim["+countdata+"]").value = trim.toFixed(2);
            document.getElementById("rmorder["+countdata+"]").value = rmorder.toFixed(0);
            document.getElementById("beratOrder["+countdata+"]").value = tonase.toFixed(2);

            // console.log(row); 
            // console.log(countrow);
            // console.log(countdata);
            // console.log(outCorr);
            // console.log(outConv);
            countrow++;
            countdata++;
            
            // console.log(countrow);
            // console.log(countdata);
        });
        // console.log(countrow);
    });
    
    // countrow++;
    

    $(".Opi").ready(function(){
        
        var table = $("#data_opi").DataTable({
            select: true,
            "initComplete": function (settings, json) {  
            $("#data_opi").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
        },
        });
        
        $('#data_opi tbody').on( 'click', 'td', function () {
            var cust = (table.row(this).data());
            
            if (countdata != 'null') {
                document.getElementById("noOpi["+countdata+"]").value = cust[0];
                document.getElementById("dt["+countdata+"]").value = cust[1];
                document.getElementById("customer["+countdata+"]").value = cust[2];
                document.getElementById("item["+countdata+"]").value = cust[3];
                document.getElementById("mc["+countdata+"]").value = cust[4];
                document.getElementById("sheetp["+countdata+"]").value = cust[5];
                document.getElementById("sheetl["+countdata+"]").value = cust[6];
                document.getElementById("tipebox["+countdata+"]").value = cust[7];
                document.getElementById("flute["+countdata+"]").value = cust[8];
                document.getElementById("order["+countdata+"]").value = cust[9];
                document.getElementById("opi_id["+countdata+"]").value = cust[22];
                document.getElementById("toleransi["+countdata+"]").value = cust[10];
                document.getElementById("gramAtas["+countdata+"]").value = cust[12];
                document.getElementById("gramFlute1["+countdata+"]").value = cust[14];
                document.getElementById("gramTengah["+countdata+"]").value = cust[16];
                document.getElementById("gramFlute2["+countdata+"]").value = cust[18];
                document.getElementById("gramBawah["+countdata+"]").value = cust[20];
                document.getElementById("beratSheet["+countdata+"]").value = cust[21];
                document.getElementById("kertasAtas["+countdata+"]").value = cust[11]+cust[12];
                document.getElementById("kertasFlute1["+countdata+"]").value = cust[13]+cust[14];
                document.getElementById("kertasTengah["+countdata+"]").value = cust[15]+cust[16];
                document.getElementById("kertasFlute2["+countdata+"]").value = cust[17]+cust[18];
                document.getElementById("kertasBawah["+countdata+"]").value = cust[19]+cust[20];

                // console.log(KAtas);
                // countdata++;
            }
            
        } );
    } );

        // countdata++;
    // var btn = $();

    
});
</script>
@endsection