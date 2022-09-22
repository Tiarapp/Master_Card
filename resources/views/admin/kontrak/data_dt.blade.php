@extends('admin.templates.partials.default')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<style>
    .select2 {
        width: 206px !important;
    }
    
    tr:nth-child(odd) {
        background-color:#bab9b9 !important;
        
    }
</style>


@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row" id="form_list_mc">
            <div class="col-md-12">
                <h4 class="modal-title">Input Delivery Time</h4>
                <hr>
                
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                <form action="{{ route('kontrak.store_dt') }}" method="POST"  >
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card-body">
                                <h3>Kapasitas B1 yang Sudah Ada</h3>
                                <table class="table table-bordered" id="data_b1">
                                  <thead>
                                    <tr>
                                      <th scope="col">Tanggal.</th>
                                      <th scope="col">Qty</th>
                                      <th scope="col">Sisa</th>
                                      <th scope="col">Status</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach ($b1 as $data)
                                      <tr>
                                        <td>{{ $data->tglKirimDt }}</td>
                                        <td>{{ $data->qty }}</td>
                                        <td>
                                            @if ($data->qty <= 100000)
                                                
                                            @elseif ($data->qty <=150000)
                                                Almost Full
                                            @else
                                                Melebihi Batas
                                            @endif
                                        </td>
                                        <td>
                                            @if ($data->qty <= 100000)
                                                Tersedia
                                            @elseif ($data->qty <=150000)
                                                Almost Full
                                            @else
                                                Melebihi Batas
                                            @endif
                                        </td>
                                      </tr>
                                    @endforeach
                                  </tbody>
                                </table>
                              </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-body">
                                <h3>Kapasitas DC yang Sudah Ada</h3>
                                <table class="table table-bordered" id="data_dc">
                                  <thead>
                                    <tr>
                                      <th scope="col">Tanggal.</th>
                                      <th scope="col">Qty</th>
                                      <th scope="col">Status</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach ($dc as $data)
                                      <tr>
                                        <td>{{ $data->tglKirimDt }}</td>
                                        <td>{{ $data->qty }}</td>
                                        <td>
                                            @if ($data->qty <= 40000)
                                                Tersedia
                                            @elseif ($data->qty <= 50000)
                                                Almost Full
                                            @else
                                                Melebihi Batas
                                            @endif
                                        </td>
                                      </tr>
                                    @endforeach
                                  </tbody>
                                </table>
                              </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>NO KONTRAK</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control txt_line" name="kodekontrak" id="kodekontrak" value="{{ $kontrak_M->kode }}">
                                                {{-- <input type="hidden" class="form-control txt_line" name="idkontrakm" id="idkontrakm" value="{{ $kontrak_M->id }}"> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Tanggal</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="date" class="form-control txt_line" name="tanggal" id="tanggal" value="{{ $kontrak_M->tglKontrak }}" autofocus >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Pilih Customer</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control txt_line col-md-11" name="namaCust" id="namaCust" value="{{ $kontrak_M->customer_name }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Alamat Kirim</label>
                                            </div>
                                            <div class="col-md-6">
                                                {{-- <input type="text" class="form-control txt_line" name="alamatKirim" id="alamatKirim"> --}}
                                                <textarea name="alamatKirim" id="alamatKirim" cols="30" rows="4" value="">{{ $kontrak_M->alamatKirim }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Jumlah Order</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control txt_line" name="telp" id="telp" value="{{ $kontrak_D->pcsKontrak }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Sisa Order</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control txt_line" name="sisa" id="sisa" value="{{ $kontrak_D->pcsSisaKontrak }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Tipe Box</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control txt_line" name="tipebox" id="tipebox" value="{{ $kontrak_D->tipebox }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Berat Box</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control txt_line" name="berat" id="berat" value="{{ $kontrak_D->berat }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h3>Tanggal Kirim DT dan OPI </h3>
                            <table class="table table-bordered" id="detail_kontrak">
                            <thead>
                                <tr>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">OPI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($opi as $o)
                                <tr>
                                    <td scope="col">{{ $o->tglKirimDt }}</td>
                                    <td scope="col">{{ $o->jumlahOrder }}</td>
                                    <td scope="col">{{ $o->nama }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            </table>
                            @include('admin.kontrak.adddt')
                            <br>
                            
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_dt">Tambah DT & OPI</button>
                                {{-- <button type="submit" class="btn btn-primary" >Tambah DT & OPI</button> --}}
                            </div>
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
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });

    $("#detail_kontrak").DataTable({
        "paging":   false,
        "ordering": false,
        "info":     false,
        "searching": false,
        // "scrollX": true,
        // "autoWidth": true, 
        "initComplete": function (settings, json) {  
            $("#detail_kontrak").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
        },
        // "scrollY": "400px",
        select: true,
    });

    $("#data_b1").DataTable({
        "paging":   true,
        "ordering": true,
        "info":     false,
        "searching": true,
        // "scrollX": true,
        // "autoWidth": true, 
        // "scrollY": "400px",
        select: true,
    });

    $("#data_dc").DataTable({
        "paging":   true,
        "ordering": true,
        "info":     false,
        "searching": true,
        // "scrollX": true,
        // "autoWidth": true, 
        // "scrollY": "400px",
        select: true,
    });
    
    function validateForm() {
        sisa = document.getElementById("sisa").value;
        x = document.getElementById("jumlahKirim").value;

        if (x > parseInt(sisa)) {
            alert("Masukkan Jumlah dibawah : "+sisa);
            return false;
        } 
    }
                        
</script>

@endsection 