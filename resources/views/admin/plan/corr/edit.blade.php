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

    /* .content-wrapper {
        height: 0px;
    } */
</style>


@section('content')
<div class="content-wrapper" style="height: autopx !important">
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
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Kode Planning</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control txt_line" name="kodeplan" id="kodeplan" value="{{ $data2->kodeplanM }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Revisi</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control txt_line" name="revisi" id="revisi" value="{{ $data2->revisi + 1 }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Tanggal</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="date" class="form-control txt_line" value="{{ $data2->tglcorr }}" name="tgl" id="tgl" autofocus onfocusout="getKode()">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Shift</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control txt_line" value="{{ $data2->shift }}" name="shift" id="shift" autofocus onfocusout="getKode()">
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
                    
                     <?php $count= 1; ?>
                    @foreach ($data1 as $detail )
                    {{-- <input type="text" id="count" name="count" value="{{ $count }}"> --}}
                    <div class="col-md-12" style="margin-bottom: 10px;">
                        <div class='row' style='margin-top:20px;'> 
                            <div class='col-md-12' style='border-top: 1px solid rgb(194, 175, 175); padding-top: 5px;'>  
                                <div class='row'> 
                                    <div class='col-md-1'>  
                                        <label>No Opi</label> 
                                    </div> 
                                    <div class='col-md-2'> 
                                        <input type='hidden' class='form-control txt_line' value="{{ $detail->idcorr }}" name='detail[{{ $count }}]' id='detail[{{ $count }}]'>  
                                        <input type='text' class='form-control txt_line' value="{{ $detail->noopi }}" name="noOpi[{{ $count }}]" id='noOpi[{{ $count }}]'> 
                                        <input type='hidden' class='form-control txt_line' value="{{ $detail->opi_id }}" name='opi_id[{{ $count }}]' id='opi_id[{{ $count }}]'> 
                                    </div> 
                                    <div class='col-md-1'>  
                                        <label>DT</label> 
                                    </div> 
                                    <div class='col-md-2'>  
                                        <input type='date' class='form-control txt_line' value="{{ $detail->tglDt }}" name='dt[{{ $count }}]' id='dt[{{ $count }}]' readonly> 
                                    </div> <div class='col-md-1'>  
                                        <label>DT Perubahan</label> 
                                    </div> 
                                    <div class='col-md-2'>  
                                        <input type='date' class='form-control txt_line' value="{{ $detail->dt_perubahan }}" name='dtperubahan[{{ $count }}]' id='dtperubahan[{{ $count }}]'> 
                                    </div> 
                                    <div class='col-md-1'>  
                                        <label>Customer</label> 
                                    </div> 
                                    <div class='col-md-2'>  
                                        <input type='text' class='form-control txt_line' value="{{ $detail->customer }}" name='customer[{{ $count }}]' id='customer[{{ $count }}]'> 
                                    </div> 
                                    <div class='col-md-1'>  
                                        <label>Item</label> 
                                    </div> 
                                    <div class='col-md-2'>  
                                        <input type='text' class='form-control txt_line' value="{{ $detail->barang }}" name='item[{{ $count }}]' id='item[{{ $count }}]'> 
                                    </div>  
                                </div>  
                                <div class='row'> 
                                    <div class='col-md-1'>  
                                        <label>MC</label> 
                                    </div> 
                                    <div class='col-md-2'>  
                                        <input type='text' class='form-control txt_line' value="{{ $detail->mckode }}"  name='mc[{{ $count }}]' id='mc[{{ $count }}]'> 
                                    </div> 
                                    <div class='col-md-1'>  
                                        <label>P x L</label> 
                                    </div> 
                                    <div class='col-md-2'>  
                                        <div class='row'>   
                                            <div class='col-md-5'>  
                                                <input type='text' class='form-control txt_line' value="{{ $detail->panjangSheet }}" name='sheetp[{{ $count }}]' id='sheetp[{{ $count }}]'>   
                                            </div>   
                                            <div class='col-md-2'>  
                                                <label for=''>X</label>  
                                            </div>   
                                            <div class='col-md-5'>  
                                                <input type='text' class='form-control txt_line' value="{{ $detail->lebarSheet }}" name='sheetl[{{ $count }}]' id='sheetl[{{ $count }}]'>   
                                            </div>  
                                        </div> 
                                    </div> 
                                    <div class='col-md-1'>  
                                        <label>Tipe / Flute</label> 
                                    </div> 
                                    <div class='col-md-2'>  
                                        <div class='row'>   
                                            <div class='col-md-5'>  
                                                <input type='text' class='form-control txt_line' value="{{ $detail->tipebox }}" name='tipebox[{{ $count }}]' id='tipebox[{{ $count }}]'>   
                                            </div>   
                                            <div class='col-md-2'>  
                                                <label for=''>/</label>  
                                            </div>   
                                            <div class='col-md-5'>  
                                                <input type='text' class='form-control txt_line' value="{{ $detail->flute }}" name='flute[{{ $count }}]' id='flute[{{ $count }}]'>   
                                            </div>  
                                        </div> 
                                    </div> 
                                    <div class='col-md-1'>  
                                        <label>Order</label> 
                                    </div> 
                                    <div class='col-md-2'>  
                                        <input type='text' class='form-control txt_line' value="{{ $detail->order }}" name='order[{{ $count }}]' id='order[{{ $count }}]'> 
                                    </div>  
                                </div>  
                                <div class='row'> 
                                    <div class='col-md-1'>  
                                        <label>Out Corr / Out Flexo</label> 
                                    </div> 
                                    <div class='col-md-2'>  
                                        <div class='row'>   
                                            <div class='col-md-5'>  
                                                <input type='number' class='form-control txt_line' value="{{ $detail->out_corr }}" name='outCorr[{{ $count }}]' id='outCorr[{{ $count }}]'>   
                                            </div>   
                                            <div class='col-md-2'>  
                                                <label for=''>/</label>  
                                            </div>   
                                            <div class='col-md-5'>  
                                                <input type='number' class='form-control txt_line' value="{{ $detail->out_flexo }}" name='outFlexo[{{ $count }}]' id='outFlexo[{{ $count }}]'>   
                                            </div>  
                                        </div> 
                                    </div> 
                                    <div class='col-md-1'>  
                                        <label>Lebar Roll</label> 
                                    </div> 
                                    <div class='col-md-1'>  
                                        <input type='text' class='form-control txt_line' value="{{ $detail->ukuran_roll }}" name='roll[{{ $count }}]' id='roll[{{ $count }}]'> 
                                    </div> 
                                    <div class='col-md-1'>  
                                        <input type='text' class='form-control txt_line' value="{{ $detail->custom_roll }}" name='rollcustom[{{ $count }}]' id='rollcustom[{{ $count }}]'> 
                                    </div> 
                                    <div class='col-md-1'>  
                                        <label>Plan</label> 
                                    </div> 
                                    <div class='col-md-2'>  
                                        <input type='text' class='form-control txt_line' value="{{ $detail->qtyOrder }}" name='plan[{{ $count }}]' id='plan[{{ $count }}]'> 
                                    </div> 
                                    <div class='col-md-1'>  
                                        <label>trim / cop</label> 
                                    </div> 
                                    <div class='col-md-2'>  
                                        <div class='row'>   
                                            <div class='col-md-5'>  
                                                <input type='text' class='form-control txt_line' value="{{ $detail->trim_waste }}" name='trim[{{ $count }}]' id='trim[{{ $count }}]'>   
                                            </div>   
                                            <div class='col-md-2'>  
                                                <label for=''>/</label>  
                                            </div>   
                                            <div class='col-md-5'>  
                                                <input type='text' class='form-control txt_line' value="{{ $detail->cop }}" name='cop[{{ $count }}]' id='cop[{{ $count }}]'>   
                                            </div>  
                                        </div> 
                                    </div>  
                                </div>  
                                <div class='row' style='margin-botton:5px;'> 
                                    <div class='col-md-1'>  
                                        <label style="margin-top:20px">K. Atas</label> 
                                    </div> 
                                    <div class='col-md-1'>  
                                        <input type='text' class='form-control txt_line' value="{{ $detail->jenis_atas}}" name='kertasAtas[{{ $count }}]' id='kertasAtas[{{ $count }}]'> 
                                        <input type='text' class='form-control txt_line' value="{{ $detail->gram_atas }}" name='gramAtas[{{ $count }}]' id='gramAtas[{{ $count }}]'> 
                                    </div> 
                                    <div class='col-md-1'>  
                                        <label style="margin-top:20px">K. Flute1</label> 
                                    </div> 
                                    <div class='col-md-1'>  
                                        <input type='text' class='form-control txt_line' value="{{ $detail->jenis_bf}}" name='kertasFlute1[{{ $count }}]' id='kertasFlute1[{{ $count }}]'> 
                                        <input type='text' class='form-control txt_line' value="{{ $detail->gram_bf  }}" name='gramFlute1[{{ $count }}]' id='gramFlute1[{{ $count }}]'> 
                                    </div> 
                                    <div class='col-md-1'>  
                                        <label style="margin-top:20px">K. Tengah</label> 
                                    </div> 
                                    <div class='col-md-1'>  
                                        <input type='text' class='form-control txt_line' value="{{ $detail->jenis_tengah}}" name='kertasTengah[{{ $count }}]' id='kertasTengah[{{ $count }}]'> 
                                        <input type='text' class='form-control txt_line' value="{{ $detail->gram_tengah  }}" name='gramTengah[{{ $count }}]' id='gramTengah[{{ $count }}]'> 
                                    </div> 
                                    <div class='col-md-1'>  
                                        <label style="margin-top:20px">K. Flute2</label> 
                                    </div> <div class='col-md-1'>  
                                        <input type='text' class='form-control txt_line' value="{{ $detail->jenis_cf}}" name='kertasFlute2[{{ $count }}]' id='kertasFlute2[{{ $count }}]'> 
                                        <input type='text' class='form-control txt_line' value="{{ $detail->gram_cf }}" name='gramFlute2[{{ $count }}]' id='gramFlute2[{{ $count }}]'> 
                                    </div> 
                                    <div class='col-md-1'>  
                                        <label style="margin-top:20px">K. Bawah</label> 
                                    </div> 
                                    <div class='col-md-1'>  
                                        <input type='text' class='form-control txt_line' value="{{ $detail->jenis_bawah}}" name='kertasBawah[{{ $count }}]' id='kertasBawah[{{ $count }}]'> 
                                        <input type='text' class='form-control txt_line' value="{{ $detail->gram_bawah }}" name='gramBawah[{{ $count }}]' id='gramBawah[{{ $count }}]'> 
                                    </div>  
                                    <div class='col-md-1'>  
                                        <label style='margin-top:20px'>Toleransi(%)</label> 
                                    </div> 
                                    <div class='col-md-1'>  
                                        <input type='text' class='form-control txt_line' value="{{ $detail->toleransi }}" name='toleransi[{{ $count }}]' id='toleransi[{{ $count }}]'>  
                                    </div> 
                                </div>  
                                <div class='row'> 
                                    <div class='col-md-1'>  
                                        <label>Kebutuhan Atas</label> 
                                    </div> <div class='col-md-1'>  
                                        <input type='text' class='form-control txt_line' value="{{ $detail->kebutuhan_kertasAtas }}" name='kebutuhanAtas[{{ $count }}]' id='kebutuhanAtas[{{ $count }}]'> 
                                    </div> 
                                    <div class='col-md-1'>  
                                        <label>Kebutuhan Flute1</label> 
                                    </div> 
                                    <div class='col-md-1'>  
                                        <input type='text' class='form-control txt_line' value="{{ $detail->kebutuhan_kertasFlute1 }}" name='kebutuhanFlute1[{{ $count }}]' id='kebutuhanFlute1[{{ $count }}]'> 
                                    </div> 
                                    <div class='col-md-1'>  
                                        <label>Kebutuhan Tengah</label>
                                     </div> 
                                     <div class='col-md-1'>  
                                         <input type='text' class='form-control txt_line' value="{{ $detail->kebutuhan_kertasTengah }}" name='kebutuhanTengah[{{ $count }}]' id='kebutuhanTengah[{{ $count }}]'> 
                                        </div> 
                                        <div class='col-md-1'>  
                                            <label>Kebutuhan Flute2</label> 
                                        </div> 
                                        <div class='col-md-1'>  
                                            <input type='text' class='form-control txt_line' value="{{ $detail->kebutuhan_kertasFlute2 }}" name='kebutuhanFlute2[{{ $count }}]' id='kebutuhanFlute2[{{ $count }}]'> 
                                        </div> 
                                        <div class='col-md-1'>  
                                            <label>Kebutuhan Bawah</label> 
                                        </div> 
                                        <div class='col-md-1'>  
                                            <input type='text' class='form-control txt_line' value="{{ $detail->kebutuhan_kertasBawah }}" name='kebutuhanBawah[{{ $count }}]' id='kebutuhanBawah[{{ $count }}]'> 
                                        </div>  
                                    </div>  
                                    <div class='row'> 
                                        <div class='col-md-1'>  
                                            <label>Berat/Pcs</label> 
                                        </div> 
                                        <div class='col-md-1'>  
                                            <input type='text' class='form-control txt_line' value="{{ $detail->gramSheet }}" name='beratSheet[{{ $count }}]' id='beratSheet[{{ $count }}]'> 
                                        </div> 
                                        <div class='col-md-1'>  
                                            <label>RM Order</label> 
                                        </div> 
                                        <div class='col-md-1'>  
                                            <input type='text' class='form-control txt_line' value="{{ $detail->rm_order }}" name='rmorder[{{ $count }}]' id='rmorder[{{ $count }}]'> 
                                        </div> 
                                        <div class='col-md-1'>  
                                            <label>Berat Order</label> 
                                        </div> 
                                        <div class='col-md-1'>  
                                            <input type='text' class='form-control txt_line' value="{{ $detail->tonase }}" name='beratOrder[{{ $count }}]' id='beratOrder[{{ $count }}]'> 
                                        </div> 
                                        <div class='col-md-1'>  
                                            <label>urutan</label> 
                                        </div> 
                                        <div class='col-md-1'>  
                                            <input type='text' class='form-control txt_line' value="{{ $detail->urutan }}" name='urutan[{{ $count }}]' id='urutan[{{ $count }}]'> 
                                        </div> 
                                        
                                        <div class='col-md-1'>
                                            <a class="btn btn-success" href="../hapus/{{ $detail->idcorr }}" id="hapus" title="Add field">CANCEL</a>
                                        </div> 
                                    </div> 
                                    <div class='row' style='margin-top:10px'> 
                                        <div class='col-md-1'>  
                                            <label>Keterangan</label> 
                                        </div> 
                                        <div class='col-md-10'> 
                                            <input type='text' value="{{ $detail->keterangan }}" name='keterangan[{{ $count }}]' id='keterangan[{{ $count }}]' style='width:1000px'> 
                                        </div> 
                                    </div> 
                                </div> 
                            </div> 
                        </div>
                        <input type="hidden" id="count" name="count" value="{{ $count++ }}">
                        
                    @endforeach
                    <input type="hidden" id="countdata" name="countdata" value="{{ $count }}">
                    <div class="col-md-12" id="plancorr" style="margin-bottom: 10px;">
                    
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <br>
                            <button type="button" data-toggle="modal" data-target="#Opi" class="btn btn-search">
                                Cari OPI  <i class="fas fa-search"></i>
                            </button>
                            <a class="btn btn-success" href="javascript:void(0);" id="add_button" title="Add field">TAMBAH</a>
                            <a class="btn btn-success" href="javascript:void(0);" id="calc_button" title="Add field">HITUNG</a>
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


    // console.log(month);

    document.getElementById("kodeplan").value = dd+""+month+""+year;
}

$(document).ready(function(){
    var countrow = document.getElementById("countdata").value;; //Input fields increment limitation
    var countdata = document.getElementById("countdata").value; //Input fields increment limitation
    var addButton = $('#add_button'); //Add button selector

    //Once add button is clicked
    $(addButton).click(function(){
        $("#plancorr").append("<div class='row' style='margin-top:20px;'> <div class='col-md-12' style='border-top: 1px solid rgb(194, 175, 175); padding-top: 5px;'>  <div class='row'> <div class='col-md-1'>  <label>No Opi</label> </div> <div class='col-md-2'><input type='text' class='form-control txt_line' value='' name='detail["+countrow+"]' id='detail["+countrow+"]'>   <input type='text' class='form-control txt_line' name='noOpi["+countrow+"]' id='noOpi["+countrow+"]'> <input type='hidden' class='form-control txt_line' name='opi_id["+countrow+"]' id='opi_id["+countrow+"]'> </div> <div class='col-md-1'>  <label>DT</label> </div> <div class='col-md-2'>  <input type='date' class='form-control txt_line' name='dt["+countrow+"]' id='dt["+countrow+"]'> </div> <div class='col-md-1'>  <label>DT Perubahan</label> </div> <div class='col-md-2'>  <input type='date' class='form-control txt_line' name='dtperubahan["+countrow+"]' id='dtperubahan["+countrow+"]'> </div> <div class='col-md-1'>  <label>Customer</label> </div> <div class='col-md-2'>  <input type='text' class='form-control txt_line' name='customer["+countrow+"]' id='customer["+countrow+"]'> </div> <div class='col-md-1'>  <label>Item</label> </div> <div class='col-md-2'>  <input type='text' class='form-control txt_line' name='item["+countrow+"]' id='item["+countrow+"]'> </div> </div>  <div class='row'> <div class='col-md-1'>  <label>MC</label> </div> <div class='col-md-2'>  <input type='text' class='form-control txt_line' name='mc["+countrow+"]' id='mc["+countrow+"]'> </div> <div class='col-md-1'>  <label>P x L</label> </div> <div class='col-md-2'>  <div class='row'> <div class='col-md-5'> <input type='text' class='form-control txt_line' name='sheetp["+countrow+"]' id='sheetp["+countrow+"]'> </div> <div class='col-md-2'> <label for=''>X</label> </div> <div class='col-md-5'> <input type='text' class='form-control txt_line' name='sheetl["+countrow+"]' id='sheetl["+countrow+"]'> </div> </div> </div> <div class='col-md-1'> <label>Tipe / Flute</label> </div> <div class='col-md-2'> <div class='row'> <div class='col-md-5'> <input type='text' class='form-control txt_line' name='tipebox["+countrow+"]' id='tipebox["+countrow+"]'> </div> <div class='col-md-2'> <label for=''>/</label> </div> <div class='col-md-5'> <input type='text' class='form-control txt_line' name='flute["+countrow+"]' id='flute["+countrow+"]'> </div> </div> </div> <div class='col-md-1'> <label>Order</label> </div> <div class='col-md-2'>  <input type='text' class='form-control txt_line' name='order["+countrow+"]' id='order["+countrow+"]'> </div>  </div>  <div class='row'> <div class='col-md-1'>  <label>Out Corr / Out Flexo</label> </div> <div class='col-md-2'>  <div class='row'>   <div class='col-md-5'>  <input type='number' class='form-control txt_line' name='outCorr["+countrow+"]' id='outCorr["+countrow+"]' required>   </div>   <div class='col-md-2'>  <label for=''>/</label>  </div>   <div class='col-md-5'>  <input type='number' class='form-control txt_line' name='outFlexo["+countrow+"]' id='outFlexo["+countrow+"]' required>   </div>  </div> </div> <div class='col-md-1'>  <label>Lebar Roll / Custom Lebar</label> </div> <div class='col-md-1'>  <input type='text' class='form-control txt_line' name='roll["+countrow+"]' id='roll["+countrow+"]'> </div> <div class='col-md-1'>  <input type='text' class='form-control txt_line' name='rollcustom["+countrow+"]' id='rollcustom["+countrow+"]'> </div>  <div class='col-md-1'>  <label>Plan</label> </div> <div class='col-md-2'>  <input type='text' class='form-control txt_line' name='plan["+countrow+"]' id='plan["+countrow+"]'> </div> <div class='col-md-1'>  <label>trim / cop</label> </div> <div class='col-md-2'>  <div class='row'>   <div class='col-md-5'>  <input type='text' class='form-control txt_line' name='trim["+countrow+"]' id='trim["+countrow+"]'>   </div>   <div class='col-md-2'>  <label for=''>/</label>  </div>   <div class='col-md-5'>  <input type='text' class='form-control txt_line' name='cop["+countrow+"]' id='cop["+countrow+"]'>   </div>  </div> </div>  </div>  <div class='row' style='margin-botton:5px;'> <div class='col-md-1'>  <label style='margin-top:20px'>K. Atas</label> </div> <div class='col-md-1'>  <input type='text' class='form-control txt_line' name='kertasAtas["+countrow+"]' id='kertasAtas["+countrow+"]'> <input type='text' class='form-control txt_line' name='gramAtas["+countrow+"]' id='gramAtas["+countrow+"]'> </div> <div class='col-md-1'>  <label style='margin-top:20px'>K. Flute1</label> </div> <div class='col-md-1'>  <input type='text' class='form-control txt_line' name='kertasFlute1["+countrow+"]' id='kertasFlute1["+countrow+"]'> <input type='text' class='form-control txt_line' name='gramFlute1["+countrow+"]' id='gramFlute1["+countrow+"]'> </div> <div class='col-md-1'>  <label style='margin-top:20px'>K. Tengah</label> </div> <div class='col-md-1'>  <input type='text' class='form-control txt_line' name='kertasTengah["+countrow+"]' id='kertasTengah["+countrow+"]'> <input type='text' class='form-control txt_line' name='gramTengah["+countrow+"]' id='gramTengah["+countrow+"]'> </div> <div class='col-md-1'>  <label style='margin-top:20px'>K. Flute2</label> </div> <div class='col-md-1'>  <input type='text' class='form-control txt_line' name='kertasFlute2["+countrow+"]' id='kertasFlute2["+countrow+"]'> <input type='text' class='form-control txt_line' name='gramFlute2["+countrow+"]' id='gramFlute2["+countrow+"]'> </div> <div class='col-md-1'>  <label style='margin-top:20px'>K. Bawah</label> </div> <div class='col-md-1'>  <input type='text' class='form-control txt_line' name='kertasBawah["+countrow+"]' id='kertasBawah["+countrow+"]'> <input type='text' class='form-control txt_line' name='gramBawah["+countrow+"]' id='gramBawah["+countrow+"]'> </div> <div class='col-md-1'>  <label style='margin-top:20px'>Toleransi(%)</label> </div> <div class='col-md-1'>  <input type='text' class='form-control txt_line' name='toleransi["+countrow+"]' id='toleransi["+countrow+"]'>  </div>  <div class='row'> <div class='col-md-1'>  <label>Kebutuhan Atas</label> </div> <div class='col-md-1'>  <input type='text' class='form-control txt_line' name='kebutuhanAtas["+countrow+"]' id='kebutuhanAtas["+countrow+"]'> </div> <div class='col-md-1'>  <label>Kebutuhan Flute1</label> </div> <div class='col-md-1'>  <input type='text' class='form-control txt_line' name='kebutuhanFlute1["+countrow+"]' id='kebutuhanFlute1["+countrow+"]'> </div> <div class='col-md-1'>  <label>Kebutuhan Tengah</label> </div> <div class='col-md-1'>  <input type='text' class='form-control txt_line' name='kebutuhanTengah["+countrow+"]' id='kebutuhanTengah["+countrow+"]'> </div> <div class='col-md-1'>  <label>Kebutuhan Flute2</label> </div> <div class='col-md-1'>  <input type='text' class='form-control txt_line' name='kebutuhanFlute2["+countrow+"]' id='kebutuhanFlute2["+countrow+"]'> </div> <div class='col-md-1'>  <label>Kebutuhan Bawah</label> </div> <div class='col-md-1'>  <input type='text' class='form-control txt_line' name='kebutuhanBawah["+countrow+"]' id='kebutuhanBawah["+countrow+"]'> </div>  </div>  <div class='row'> <div class='col-md-1'>  <label>Berat/Pcs</label> </div> <div class='col-md-1'>  <input type='text' class='form-control txt_line' name='beratSheet["+countrow+"]' id='beratSheet["+countrow+"]'> </div> <div class='col-md-1'>  <label>RM Order</label> </div> <div class='col-md-1'>  <input type='text' class='form-control txt_line' name='rmorder["+countrow+"]' id='rmorder["+countrow+"]'> </div> <div class='col-md-1'>  <label>Berat Order</label> </div> <div class='col-md-1'>  <input type='text' class='form-control txt_line' name='beratOrder["+countrow+"]' id='beratOrder["+countrow+"]'> </div> <div class='col-md-1'>  <label>urutan</label> </div> <div class='col-md-1'>  <input type='text' class='form-control txt_line' name='urutan["+countrow+"]' id='urutan["+countrow+"]' required> </div> </div> <div class='row' style='margin-top:10px'> <div class='col-md-1'>  <label>Keterangan</label> </div> <div class='col-md-10'> <input type='text' name='keterangan["+countrow+"]' id='keterangan["+countrow+"]' style='width:1000px'> </div> </div> </div> </div> </div>");
          
        countrow++;
        countdata++;
    });

    $("#calc_button").click(function() {
            // var data = countdata;
            
        for (let i = 1; i < countdata; i++) {
            var  outCorr = document.getElementById("outCorr["+i+"]").value;
            var  sheetl = document.getElementById("sheetl["+i+"]").value;
            var  sheetp = document.getElementById("sheetp["+i+"]").value;
            var  outConv = document.getElementById("outFlexo["+i+"]").value;
            var  order = document.getElementById("order["+i+"]").value;
            var  toleransi = document.getElementById("toleransi["+i+"]").value;
            var  ukrollcustom = document.getElementById("rollcustom["+i+"]").value;
            var  gramSheet = document.getElementById("beratSheet["+i+"]").value;
            var  tipebox = document.getElementById("tipebox["+i+"]").value;
            var gAtas =document.getElementById("gramAtas["+i+"]").value
            var gFlute1 =document.getElementById("gramFlute1["+i+"]").value
            var gTengah =document.getElementById("gramTengah["+i+"]").value
            var gFlute2 =document.getElementById("gramFlute2["+i+"]").value
            var gBawah =document.getElementById("gramBawah["+i+"]").value

            // console.log(toleransi);
            
            if (tipebox = 'DC') {
                if (ukrollcustom != '') {
                    UkRoll = Math.ceil(((outCorr*sheetl)+20)/50)*50;
                    hitungroll = parseInt(ukrollcustom);
                } else {
                    UkRoll = Math.ceil(((outCorr*sheetl)+20)/50)*50;
                    hitungroll = UkRoll;
                }
            } else {
                if (ukrollcustom != '') {
                    UkRoll =Math.ceil(((outCorr*sheetl)+30)/50)*50;
                    hitungroll = parseInt(ukrollcustom);
                } else {
                    UkRoll =Math.ceil(((outCorr*sheetl)+30)/50)*50;
                    hitungroll = UkRoll;

                }
            }

            // console.log(UkRoll);
            
            qtyPlan =  parseInt(order) + (order*(toleransi/100)/outConv);

            cop = qtyPlan/outCorr;

            trim = (hitungroll-(sheetl*outCorr))/hitungroll;

            rmorder = (sheetp*cop)/1000;

            tonase = qtyPlan*gramSheet;

            if (gAtas != '') {
                KAtas = rmorder*(hitungroll/1000)*gAtas/1000;
                document.getElementById("kebutuhanAtas["+i+"]").value = Math.round(KAtas);
            } 
            if (gFlute1 != '') {
                KFlute1 = rmorder*(hitungroll/1000)*(gFlute1/1000)*1.34;
                document.getElementById("kebutuhanFlute1["+i+"]").value = Math.round(KFlute1);
            } 
            if (gTengah != '') {
                KTengah = rmorder*(hitungroll/1000)*gTengah/1000;
                document.getElementById("kebutuhanTengah["+i+"]").value = Math.round(KTengah);
            } 
            if (gFlute2 != '') {
                KFlute2 = rmorder*(hitungroll/1000)*(gFlute2/1000)*1.42;
                document.getElementById("kebutuhanFlute2["+i+"]").value = Math.round(KFlute2);
            } 
            if (gBawah != '') {
                KBawah = rmorder*(hitungroll/1000)*gBawah/1000;
                document.getElementById("kebutuhanBawah["+i+"]").value = Math.round(KBawah);
            } 

            

            console.log(hitungroll, UkRoll);

            document.getElementById("plan["+i+"]").value = qtyPlan.toFixed(2);
            document.getElementById("roll["+i+"]").value = UkRoll.toFixed(2);
            document.getElementById("cop["+i+"]").value = cop.toFixed(2);
            document.getElementById("trim["+i+"]").value = trim.toFixed(2);
            document.getElementById("rmorder["+i+"]").value = rmorder.toFixed(0);
            document.getElementById("beratOrder["+i+"]").value = tonase.toFixed(2);
        }
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
            x = countdata -1;
        
            if (x != 'null') {
                document.getElementById("noOpi["+x+"]").value = cust[0];
                document.getElementById("dt["+x+"]").value = cust[1];
                document.getElementById("customer["+x+"]").value = cust[2];
                document.getElementById("item["+x+"]").value = cust[3];
                document.getElementById("mc["+x+"]").value = cust[4];
                document.getElementById("sheetp["+x+"]").value = cust[5];
                document.getElementById("sheetl["+x+"]").value = cust[6];
                document.getElementById("tipebox["+x+"]").value = cust[7];
                document.getElementById("flute["+x+"]").value = cust[8];
                document.getElementById("order["+x+"]").value = cust[9];
                document.getElementById("opi_id["+x+"]").value = cust[22];
                document.getElementById("gramAtas["+x+"]").value = cust[12];
                document.getElementById("gramFlute1["+x+"]").value = cust[14];
                document.getElementById("gramTengah["+x+"]").value = cust[16];
                document.getElementById("gramFlute2["+x+"]").value = cust[18];
                document.getElementById("gramBawah["+x+"]").value = cust[20];
                document.getElementById("beratSheet["+x+"]").value = cust[21];
                document.getElementById("kertasAtas["+x+"]").value = cust[11];
                document.getElementById("kertasFlute1["+x+"]").value = cust[13];
                document.getElementById("kertasTengah["+x+"]").value = cust[15];
                document.getElementById("kertasFlute2["+x+"]").value = cust[17];
                document.getElementById("kertasBawah["+x+"]").value = cust[19];

                if (cust[7] == 'DC') {
                    toleransi = 2;
                } else if(cust[7] == 'B1'){
                    toleransi = 5;
                } else {
                    toleransi = 0;
                }

                
                document.getElementById("toleransi["+x+"]").value = toleransi;

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