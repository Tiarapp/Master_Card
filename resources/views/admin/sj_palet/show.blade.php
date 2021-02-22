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
                <h4 class="modal-title">Surat Jalan Palet</h4>
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
                
                <form>
                    @csrf
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Tanggal</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="tanggal" id="tanggal" value="{{ $sj_Palet_M->tanggal }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>No. Surat Jalan</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="noSuratJalan" id="noSuratJalan" value="{{ $sj_Palet_M->noSuratJalan }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>No. Polisi</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="noPolisi" id="noPolisi" value="{{ $sj_Palet_M->noPolisi }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>No. PO Customer</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="noPoCustomer" id="noPoCustomer" value="{{ $sj_Palet_M->noPoCustomer }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Nama Customer</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="namaCustomer" id="namaCustomer" value="{{ $sj_Palet_M->namaCustomer }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Alamat Customer</label>
                                    </div>
                                    <div class="col-md-10">
                                        {{-- <input type="textarea" class="form-control txt_line" name="alamatCustomer" id="alamatCustomer"> --}}
                                        <textarea class="form-control txt_line" name="alamatCustomer" id="alamatCustomer" cols="40" rows="3">{{ $sj_Palet_M->alamatCustomer }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Catatan</label>
                            {{-- <textarea name="keterangan" id="keterangan" cols="30" rows="10"></textarea> --}}
                            <input type="text" class="form-control txt_line" name="catatan" id="catatan" value="{{ $sj_Palet_M->catatan }}">
                        </div>
                    </div>
                    
                    <table class="table table-bordered" id="">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Ukuran</th>
                                <th scope="col">Qty</th>
                                <th scope="col">No Kontrak</th>
                                <th scope="col">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no =1;
                            foreach ($sj_Palet_D as $data) {
                                ?>
                                <tr>
                                    <td scope="row">{{ $no++ }}</td>
                                    <td>{{ $data->item_palet_id }}</td>
                                    <td>{{ $data->ukuran }}</td>
                                    <td>{{ $data->qty }}</td>
                                    <td>{{ $data->noKontrak }}</td>
                                    <td>{{ $data->keterangan }}</td>
                                    
                                    <?php
                                }    
                                ?>
                                
                            </tbody>
                        </table>
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
    
    