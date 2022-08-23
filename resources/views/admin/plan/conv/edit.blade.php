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
                
                <form action="../update/{{ $data2->id }}"  method="POST">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                              <div class="col-md-3">
                                  <div class="row">
                                      <div class="col-md-4">
                                          <label>Mesin</label>
                                      </div>
                                      <div class="col-md-6">
                                          <input type="text" class="form-control txt_line" name="mesin" id="mesin" value="{{ $mesin->mesin }}" onfocusout="getKode()" readonly>
                                      </div>
                                  </div>
                              </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Kode Planning</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control txt_line" name="kodeplan" id="kodeplan" value="{{ $data2->kode }}" onfocusout="getKode()" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Tanggal</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="date" class="form-control txt_line" name="tgl" id="tgl" value="{{ $data2->tanggal }}" autofocus onfocusout="getKode()" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Shift</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control txt_line" name="shift" id="shift" value="{{ $data2->shiftM }}" onfocusout="getKode()" readonly>
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
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                    foreach ($opi as $data) { ?>
                                                                        <tr>
                                                                          <td scope="row">{{ $data->noopi }}</td>
                                                                          <td>{{ $data->tglKirimDt }}</td>
                                                                          <td>{{ $data->Cust }}</td>
                                                                          <td>{{ $data->namaBarang }}</td>
                                                                          <td>
                                                                              <?php
                                                                                  if ($data->revisimc != '') {
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
                    <?php $count=1; ?>
                    @foreach ($data1 as $data)
                    <div class="col-md-12" style="margin-bottom: 10px;">
                        <div class='row' style='margin-top:20px;'>
                            <div class='col-md-12' style='border-top: 1px solid rgb(194, 175, 175); padding-top: 5px;'>
                              <div class='row'>
                                <div class='col-md-1'>
                                  <label>No Opi</label>
                                </div>
                                <div class='col-md-2'>
                                  <input type='text' class='form-control txt_line' name='noOpi[{{ $count }}]' id='noOpi[{{ $count }}]' value="{{ $data->noopi }}" readonly>
                                  <input type='hidden' class='form-control txt_line' name='wax[{{ $count }}]' id='wax[{{ $count }}]'>
                                  <input type='hidden' class='form-control txt_line' name='roll[{{ $count }}]' id='roll[{{ $count }}]'>
                                  <input type='hidden' class='form-control txt_line' name='bungkus[{{ $count }}]' id='bungkus[{{ $count }}]'>
                                  <input type='hidden' class='form-control txt_line' name='opi_id[{{ $count }}]' id='opi_id[{{ $count }}]'>
                                  <input type='hidden' class='form-control txt_line' name='detail[{{ $count }}]' id='detail[{{ $count }}]' value="{{ $data->id }}">
                                </div>  
                                <div class='col-md-1'>
                                  <label>DT</label>
                                </div>
                                <div class='col-md-2'>
                                  <input type='date' class='form-control txt_line' name='dt[{{ $count }}]' id='dt[{{ $count }}]' value="{{ $data->tgl_kirim }}" readonly>
                                </div>
                                <div class='col-md-1'>
                                  <label>Customer</label>
                                </div>
                                <div class='col-md-2'>
                                  <input type='text' class='form-control txt_line' name='customer[{{ $count }}]' id='customer[{{ $count }}]' value="{{ $data->customer }}" readonly>
                                </div>
                                <div class='col-md-1'>
                                  <label>Item</label>
                                </div>
                                <div class='col-md-2'>
                                  <input type='text' class='form-control txt_line' name='item[{{ $count }}]' id='item[{{ $count }}]' value="{{ $data->nama_item }}" readonly>
                                </div>
                              </div>
                              <div class='row'>
                                <div class='col-md-1'>
                                  <label>MC</label>
                                </div>
                                <div class='col-md-2'>
                                  <input type='text' class='form-control txt_line' name='mc[{{ $count }}]' id='mc[{{ $count }}]' value="{{ $data->nomc }}" readonly>
                                </div>
                                <div class='col-md-1'>
                                  <label>P x L</label>
                                </div>
                                <div class='col-md-2'>
                                  <div class='row'>
                                    <div class='col-md-5'>
                                      <input type='text' class='form-control txt_line' name='sheetp[{{ $count }}]' id='sheetp[{{ $count }}]' value="{{ $data->sheet_p }}" readonly>
                                    </div>
                                    <div class='col-md-2'>
                                      <label for=''>X</label>
                                    </div>
                                    <div class='col-md-5'>
                                      <input type='text' class='form-control txt_line' name='sheetl[{{ $count }}]' id='sheetl[{{ $count }}]' value="{{ $data->sheet_l }}" readonly>
                                    </div>
                                  </div>
                                </div>
                                <div class='col-md-1'>
                                  <label>Out Conv / Flute</label>
                                </div>
                                <div class='col-md-2'>
                                  <div class='row'>
                                    <div class='col-md-5'>
                                      <input type='text' class='form-control txt_line' name='outconv[{{ $count }}]' id='outconv[{{ $count }}]' value="{{ $data->out_flexo }}" >
                                    </div>
                                    <div class='col-md-2'>
                                      <label for=''>/</label>
                                    </div>
                                    <div class='col-md-5'>
                                      <input type='text' class='form-control txt_line' name='flute[{{ $count }}]' id='flute[{{ $count }}]' value="{{ $data->flute }}" readonly>
                                    </div>
                                  </div>
                                </div>
                                <div class='col-md-1'>
                                  <label>Order</label>
                                </div>
                                <div class='col-md-2'>
                                  <input type='text' class='form-control txt_line' name='order[{{ $count }}]' id='order[{{ $count }}]' value="{{ $data->qtyOrder }}" readonly>
                                </div>
                              </div>
                              <div class='row'>
                                <div class='col-md-1'>
                                  <label>Plan</label>
                                </div>
                                <div class='col-md-2'>
                                  <div class='row'>
                                    <div class='col-md-12'>
                                      <input type='text' class='form-control txt_line' name='plan[{{ $count }}]' id='plan[{{ $count }}]' value="{{ $data->jml_plan }}">
                                    </div>
                                  </div>
                                </div>
                                <div class='col-md-1'>
                                  <label> Warna </label>
                                </div>
                                <div class='col-md-2'>
                                  <input type='text' class='form-control txt_line' name='warna[{{ $count }}]' id='warna[{{ $count }}]' value="{{ $data->warna }}" readonly>
                                </div>
                                <div class='col-md-1'>
                                  <label>Finishing</label>
                                </div>
                                <div class='col-md-2'>
                                  <input type='text' class='form-control txt_line' name='finishing[{{ $count }}]' id='finishing[{{ $count }}]' value="{{ $data->joint }}" readonly>
                                </div><div class='col-md-1'>
                                  <label>Wax</label>
                                </div>
                                <div class='col-md-2'>
                                  <input type='text' class='form-control txt_line' name='wax[{{ $count }}]' id='wax[{{ $count }}]' value="{{ $data->wax }}" readonly>
                                </div>
                              </div>
                              <div class='row'>
                                <div class='col-md-1'>
                                  <label>Tipe Order</label>
                                </div>
                                <div class='col-md-2'>
                                  <div class='row'>
                                    <div class='col-md-12'>
                                      <input type='text' class='form-control txt_line' name='tipeOrder[{{ $count }}]' id='tipeOrder[{{ $count }}]' value="{{ $data->tipe_order }}" readonly>
                                    </div>
                                  </div>
                                </div>
                                <div class='col-md-1'>
                                  <label>Tipe Box</label>
                                </div>
                                <div class='col-md-2'>
                                  <div class='row'>
                                    <div class='col-md-12'>
                                      <input type='text' class='form-control txt_line' name='tipebox[{{ $count }}]' id='tipebox[{{ $count }}]' value="{{ $data->bentuk }}" readonly>
                                    </div>
                                  </div>
                                </div>
                                <div class='col-md-1'>
                                  <label>Urutan</label>
                                </div>
                                <div class='col-md-2'>
                                  <div class='row'>
                                    <div class='col-md-12'>
                                      <input type='text' class='form-control txt_line' name='urutan[{{ $count }}]' id='urutan[{{ $count }}]' value="{{ $data->urutan }}" >
                                    </div>
                                  </div>
                                </div>
                                <div class='row' style='margin-top:10px'>
                                  <div class='col-md-1'>
                                    <label>Keterangan</label>
                                  </div>
                                  <div class='col-md-10'>
                                    <input type='text' name='keterangan[{{ $count }}]' id='keterangan[{{ $count }}]' value="{{ $data->keterangan }}" style='width:1000px'>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                    </div>
                    <input type="hidden" id="count" name="count" value="{{ $count++ }}">
                        
                    @endforeach
                    <input type="hidden" id="countdata" name="countdata" value="{{ $count }}">

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
    var countrow = document.getElementById("countdata").value;; //Input fields increment limitation
    var countdata = document.getElementById("countdata").value; //Input fields increment limitation
    var addButton = $('#add_button'); //Add button selector

    //Once add button is clicked
    $(addButton).click(function(){
        $("#planconv").append("<div class='row' style='margin-top:20px;'> <div class='col-md-12' style='border-top: 1px solid rgb(194, 175, 175); padding-top: 5px;'>  <div class='row'> <div class='col-md-1'>  <label>No Opi</label> </div> <div class='col-md-2'>  <input type='text' class='form-control txt_line' name='noOpi["+countrow+"]' id='noOpi["+countrow+"]'> <input type='hidden' class='form-control txt_line' name='roll["+countrow+"]' id='roll["+countrow+"]'><input type='hidden' class='form-control txt_line' name='bungkus["+countrow+"]' id='bungkus["+countrow+"]'><input type='hidden' class='form-control txt_line' name='detail["+countrow+"]' id='detail["+countrow+"]'><input type='hidden' class='form-control txt_line' name='opi_id["+countrow+"]' id='opi_id["+countrow+"]'><input type='hidden' class='form-control txt_line' name='hasilcorrid["+countrow+"]' id='hasilcorrid["+countrow+"]'> </div> <div class='col-md-1'>  <label>DT</label> </div> <div class='col-md-2'>  <input type='date' class='form-control txt_line' name='dt["+countrow+"]' id='dt["+countrow+"]'> </div> <div class='col-md-1'>  <label>Customer</label> </div> <div class='col-md-2'>  <input type='text' class='form-control txt_line' name='customer["+countrow+"]' id='customer["+countrow+"]'> </div> <div class='col-md-1'>  <label>Item</label> </div> <div class='col-md-2'>  <input type='text' class='form-control txt_line' name='item["+countrow+"]' id='item["+countrow+"]'> </div>  </div>  <div class='row'> <div class='col-md-1'>  <label>MC</label> </div> <div class='col-md-2'>  <input type='text' class='form-control txt_line' name='mc["+countrow+"]' id='mc["+countrow+"]'> </div> <div class='col-md-1'>  <label>P x L</label> </div> <div class='col-md-2'>  <div class='row'> <div class='col-md-5'>  <input type='text' class='form-control txt_line' name='sheetp["+countrow+"]' id='sheetp["+countrow+"]'>   </div>   <div class='col-md-2'>  <label for=''>X</label>  </div>   <div class='col-md-5'>  <input type='text' class='form-control txt_line' name='sheetl["+countrow+"]' id='sheetl["+countrow+"]'>   </div>  </div> </div> <div class='col-md-1'>  <label>Out Conv / Flute</label> </div> <div class='col-md-2'>  <div class='row'>   <div class='col-md-5'>  <input type='text' class='form-control txt_line' name='outconv["+countrow+"]' id='outconv["+countrow+"]'>   </div>   <div class='col-md-2'>  <label for=''>/</label>  </div>   <div class='col-md-5'>  <input type='text' class='form-control txt_line' name='flute["+countrow+"]' id='flute["+countrow+"]'>   </div>  </div> </div> <div class='col-md-1'>  <label>Jumlah Order</label> </div> <div class='col-md-2'>  <input type='text' class='form-control txt_line' name='order["+countrow+"]' id='order["+countrow+"]'> </div>  </div>  <div class='row'> <div class='col-md-1'>  <label>Plan</label> </div> <div class='col-md-2'>  <div class='row'> <div class='col-md-12'>  <input type='text' class='form-control txt_line' name='plan["+countrow+"]' id='plan["+countrow+"]'>   </div>  </div> </div> <div class='col-md-1'>  <label> Warna </label> </div> <div class='col-md-2'>  <input type='text' class='form-control txt_line' name='warna["+countrow+"]' id='warna["+countrow+"]'> </div> <div class='col-md-1'>  <label>Finishing</label> </div> <div class='col-md-2'>  <input type='text' class='form-control txt_line' name='finishing["+countrow+"]' id='finishing["+countrow+"]'> </div><div class='col-md-1'>  <label>Wax</label> </div> <div class='col-md-2'>  <input type='text' class='form-control txt_line' name='wax["+countrow+"]' id='wax["+countrow+"]'> </div></div><div class='row'> <div class='col-md-1'>  <label>Tipe Order</label> </div> <div class='col-md-2'>  <input type='text' class='form-control txt_line' name='tipeOrder["+countrow+"]' id='tipeOrder["+countrow+"]'>   </div> <div class='col-md-1'>  <label>Tipe Box</label> </div> <div class='col-md-2'> <input type='text' class='form-control txt_line' name='tipebox["+countrow+"]' id='tipebox["+countrow+"]'> </div> <div class='col-md-1'>  <label>Urutan</label> </div> <div class='col-md-2'> <input type='text' class='form-control txt_line' name='urutan["+countrow+"]' id='urutan["+countrow+"]'> </div> </div> <div class='row' style='margin-top:10px'> <div class='col-md-1'>  <label>Keterangan</label> </div> <div class='col-md-10'> <input type='text' name='keterangan["+countrow+"]' id='keterangan["+countrow+"]' style='width:1000px'> </div> </div> </div> </div> </div>");

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
              document.getElementById("customer["+(countdata-1)+"]").value = cust[2];
              document.getElementById("item["+(countdata-1)+"]").value = cust[3];
              document.getElementById("mc["+(countdata-1)+"]").value = cust[4];
              document.getElementById("sheetp["+(countdata-1)+"]").value = cust[5];
              document.getElementById("sheetl["+(countdata-1)+"]").value = cust[6];
              document.getElementById("warna["+(countdata-1)+"]").value = cust[10];
              document.getElementById("tipebox["+(countdata-1)+"]").value = cust[7];
              document.getElementById("flute["+(countdata-1)+"]").value = cust[8];
              document.getElementById("order["+(countdata-1)+"]").value = cust[9];
              document.getElementById("tipeOrder["+(countdata-1)+"]").value = cust[11];
              document.getElementById("finishing["+(countdata-1)+"]").value = cust[12];
              document.getElementById("opi_id["+(countdata-1)+"]").value = cust[13];
              // document.getElementById("tipebox["+(countdata-1)+"]").value = cust[21];
              document.getElementById("wax["+(countdata-1)+"]").value = cust[14];
            }

            
        });
    });
    

    
});
</script>
@endsection