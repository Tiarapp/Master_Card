
<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>

@extends('admin.templates.partials.default')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>

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
                <h4 class="modal-title">Realisasi Kirim</h4>
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
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>No Kontrak</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control txt_line" name="noKontrak" id="noKontrak" value="{{ $kontrak_M->kode }}" readonly>
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
                                            <label>Customer</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control txt_line" name="noKontrak" id="noKontrak" value="{{ $kontrak_M->customer_name }}" readonly>
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
                                            <label>Nama Barang</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control txt_line" name="barang" id="barang" value="{{ $kontrak_D->mc->namaBarang }}" readonly>
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
                                            <label>QTY Order</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control txt_line" name="qtyOrder" id="qtyOrder" value="{{ $kontrak_D->pcsKontrak }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
                
                {{-- <input type="hidden" class="form-control txt_line" name="createdBy" id="createdBy" value="{{ Auth::user()->name }}"> --}}
                @include('admin.kontrak.add_kirim')


                <div class="col-xs-12 col-sm-12 col-md-12">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_kirim">Tambah</button>
                </div>

                <div class="col-md-6">
                    <h3>DT</h3>
                    <table class="table table-bordered" id="detail_kontrak">
                    <thead>
                        <tr>
                            <th scope="col">Tanggal Kirim</th>
                            <th scope="col">Jumlah Kirim</th>
                            <th scope="col">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kontrak_M->realisasi as $o)
                        <tr>
                            <td scope="col">{{ $o->tanggal_kirim }}</td>
                            <td scope="col">{{ $o->qty_kirim }}</td>
                            <td>
                                <button type="button" class="btn btn-icon btn-success" data-toggle="modal" data-target="#edit_kirim{{ $o->id }}">Edit</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                    @include('admin.kontrak.edit_kirim')
                    <br>
                </div>
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
    
</script>

@endsection