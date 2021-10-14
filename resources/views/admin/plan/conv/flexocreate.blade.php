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
                                            <div class="modal fade" id="Corr">
                                                <div class="modal-dialog modal-xl">
                                                    
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">List Hasil Corr</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body corr">
                                                            <div class="card-body">
                                                                <table class="table table-bordered" id="data_corr">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">No Opi</th>
                                                                            <th scope="col">Delivery Time</th>
                                                                            <th scope="col">MC</th>
                                                                            <th scope="col">Customer</th>
                                                                            <th scope="col">Barang</th>
                                                                            <th scope="col">Tipe Order</th>
                                                                            <th scope="col">Flute</th>
                                                                            <th scope="col">Warna</th>
                                                                            <th scope="col">Type</th>
                                                                            <th scope="col">Lebar</th>
                                                                            <th scope="col">Panjang</th>
                                                                            <th scope="col">jumlah Order</th>
                                                                            <th scope="col">Out</th>
                                                                            <th scope="col">jumlah Plan</th>
                                                                            <th scope="col">Finishing</th>
                                                                            <th scope="col">opiid</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                        foreach ($corr as $data) { ?>
                                                                            <tr>
                                                                                <td scope="row">{{ $data->noopi }}</td>
                                                                                <td>{{ $data->tglDt }}</td>
                                                                                <td>{{ $data->mckode }}</td>
                                                                                <td>{{ $data->customer }}</td>
                                                                                <td>{{ $data->barang }}</td>
                                                                                <td>{{ $data->tipeorder }}</td>
                                                                                <td>{{ $data->flute }}</td>
                                                                                <td>{{ $data->warna }}</td>
                                                                                <td>{{ $data->tipebox }}</td>
                                                                                <td>{{ $data->lebar }}</td>
                                                                                <td>{{ $data->panjang }}</td>
                                                                                <td>{{ $data->order }}</td>
                                                                                <td>{{ $data->out_flexo }}</td>
                                                                                <td>{{ $data->totalhasil }}</td>
                                                                                <td>{{ $data->joint }}</td>
                                                                                <td>{{ $data->opi_id }}</td>
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
                    <div class="col-md-12" id="planconv" style="margin-bottom: 10px;">
                        
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <br>
                            <button type="button" data-toggle="modal" data-target="#Corr" class="btn btn-search">
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

    document.getElementById("kodeplan").value = "COVPA"+dd+""+month+""+year;
}

$(document).ready(function(){
    $('.js-example-basic-single').select2();
    var countrow = 1; //Input fields increment limitation
    var countdata = 1; //Input fields increment limitation
    var addButton = $('#add_button'); //Add button selector

    //Once add button is clicked
    $(addButton).click(function(){
        $("#planconv").append("<div class='row' style='margin-top:20px;'> <div class='col-md-12' style='border-top: 1px solid rgb(194, 175, 175); padding-top: 5px;'>  <div class='row'> <div class='col-md-1'>  <label>No Opi</label> </div> <div class='col-md-2'>  <input type='text' class='form-control txt_line' name='noOpi["+countrow+"]' id='noOpi["+countrow+"]'> <input type='hidden' class='form-control txt_line' name='opi_id["+countrow+"]' id='opi_id["+countrow+"]'> </div> <div class='col-md-1'>  <label>DT</label> </div> <div class='col-md-2'>  <input type='date' class='form-control txt_line' name='dt["+countrow+"]' id='dt["+countrow+"]'> </div> <div class='col-md-1'>  <label>Customer</label> </div> <div class='col-md-2'>  <input type='text' class='form-control txt_line' name='customer["+countrow+"]' id='customer["+countrow+"]'> </div> <div class='col-md-1'>  <label>Item</label> </div> <div class='col-md-2'>  <input type='text' class='form-control txt_line' name='item["+countrow+"]' id='item["+countrow+"]'> </div>  </div>  <div class='row'> <div class='col-md-1'>  <label>MC</label> </div> <div class='col-md-2'>  <input type='text' class='form-control txt_line' name='mc["+countrow+"]' id='mc["+countrow+"]'> </div> <div class='col-md-1'>  <label>P x L</label> </div> <div class='col-md-2'>  <div class='row'>   <div class='col-md-5'>  <input type='text' class='form-control txt_line' name='sheetp["+countrow+"]' id='sheetp["+countrow+"]'>   </div>   <div class='col-md-2'>  <label for=''>X</label>  </div>   <div class='col-md-5'>  <input type='text' class='form-control txt_line' name='sheetl["+countrow+"]' id='sheetl["+countrow+"]'>   </div>  </div> </div> <div class='col-md-1'>  <label>Out Conv / Flute</label> </div> <div class='col-md-2'>  <div class='row'>   <div class='col-md-5'>  <input type='text' class='form-control txt_line' name='outconv["+countrow+"]' id='outconv["+countrow+"]'>   </div>   <div class='col-md-2'>  <label for=''>/</label>  </div>   <div class='col-md-5'>  <input type='text' class='form-control txt_line' name='flute["+countrow+"]' id='flute["+countrow+"]'>   </div>  </div> </div> <div class='col-md-1'>  <label>Order</label> </div> <div class='col-md-2'>  <input type='text' class='form-control txt_line' name='order["+countrow+"]' id='order["+countrow+"]'> </div>  </div>  <div class='row'> <div class='col-md-1'>  <label>Plan</label> </div> <div class='col-md-2'>  <div class='row'> <div class='col-md-12'>  <input type='text' class='form-control txt_line' name='plan["+countrow+"]' id='plan["+countrow+"]'>   </div>  </div> </div> <div class='col-md-1'>  <label> Warna </label> </div> <div class='col-md-2'>  <input type='text' class='form-control txt_line' name='warna["+countrow+"]' id='warna["+countrow+"]'> </div> <div class='col-md-1'>  <label>Finishing</label> </div> <div class='col-md-2'>  <input type='text' class='form-control txt_line' name='finishing["+countrow+"]' id='finishing["+countrow+"]'> </div><div class='col-md-1'><label>Status Corr</label></div><div class='col-md-2'><select class='js-example-basic-single col-md-12' name='status' id='status'><option value='Proses'>Proses</option><option value='Belum Selesai'>Belum Selesai</option><option value='Selesai'>Selesai</option></select></div> </div> <div class='row' style='margin-top:10px'> <div class='col-md-1'>  <label>Keterangan</label> </div> <div class='col-md-10'> <input type='text' name='keterangan["+countrow+"]' id='keterangan["+countrow+"]' style='width:1000px'> </div> </div> </div> </div> </div>");

        countrow++;
                countdata++;
                console.log(countdata);
    });
    
    // countrow++;
    

    $(".Corr").ready(function(){
        
        var table = $("#data_corr").DataTable({
            select: true,
            "initComplete": function (settings, json) {  
            $("#data_corr").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
        },
        });
        
        $('#data_corr tbody').on( 'click', 'td', function () {
            var cust = (table.row(this).data());
            
            if (countdata-1 != 'null') {
                document.getElementById("noOpi["+(countdata-1)+"]").value = cust[0];
                document.getElementById("dt["+(countdata-1)+"]").value = cust[1];
                document.getElementById("customer["+(countdata-1)+"]").value = cust[3];
                document.getElementById("item["+(countdata-1)+"]").value = cust[4];
                document.getElementById("mc["+(countdata-1)+"]").value = cust[2];
                document.getElementById("sheetp["+(countdata-1)+"]").value = cust[10];
                document.getElementById("sheetl["+(countdata-1)+"]").value = cust[9];
                document.getElementById("warna["+(countdata-1)+"]").value = cust[7];
                document.getElementById("flute["+(countdata-1)+"]").value = cust[6];
                document.getElementById("order["+(countdata-1)+"]").value = cust[13];
                document.getElementById("finishing["+(countdata-1)+"]").value = cust[14];
                document.getElementById("outconv["+(countdata-1)+"]").value = cust[12];
                document.getElementById("opi_id["+(countdata-1)+"]").value = cust[15];

            }

            
        });
    });
    

    
});
</script>
@endsection