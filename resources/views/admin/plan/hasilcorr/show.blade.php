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
                <h4 class="modal-title">Detail OPI</h4>
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
                                        <label>No OPI</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="noopi" id="noopi" value="{{ $opi->nama }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Nama Barang</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control txt_line" name="" id="" value="{{ $opi->namaBarang }}">
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
                                        <label>Customer</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="noPolisi" id="noPolisi" value="{{ $opi->Cust }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Mastercard</label>
                                    </div>
                                    <div class="col-md-6">
                                        <?php
                                        if ($opi->revisimc == 'R0') {
                                            $mckode = $opi->mcKode;
                                        } else {
                                            $mckode = $opi->mcKode.'-'.$opi->revisimc;
                                            
                                        } 

                                        // dd($mckode);
                                        ?>
                                        <input type="text" class="form-control txt_line" name="noPoCustomer" id="noPoCustomer" value="{{ $mckode }}">
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
                                        <label>Kontrak</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="" id="" value="{{ $opi->kode }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Ukuran</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="alamatCustomer" id="alamatCustomer" value="{{ $opi->panjang.'x'.$opi->lebar.'x'.$opi->tinggi }}">
                                        {{-- <textarea class="form-control txt_line" name="alamatCustomer" id="alamatCustomer" cols="40" rows="3"></textarea> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Catatan</label>
                            <input type="text" class="form-control txt_line" name="catatan" id="catatan" value="{{ $opi->keterangan }}">
                        </div>
                    </div>
                    
                    <table class="table table-bordered" id="">
                        <thead>
                            <tr>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Mesin</th>
                                <th scope="col">Waktu Produksi</th>
                                <th scope="col">Hasil Baik</th>
                                <th scope="col">Hasil Jelek</th>
                                <th scope="col">Downtime</th>
                                <th scope="col">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no =1;
                            foreach ($detail as $data) {
                                ?>
                                <tr>
                                    <td scope="row">{{ date('d-m-Y H:i:s', strtotime($data->start_date, )) }}</td>
                                    <td>{{ $data->mesin }}</td>
                                    <td>{{ $data->durasi }}</td>
                                    <td>{{ $data->hasil_baik }}</td>
                                    <td>{{ $data->hasil_jelek }}</td>
                                    <td>{{ $data->downtime }} menit</td>
                                    <td>{{ $data->keterangan }}</td>
                                    
                                    <?php
                                }    
                                ?>
                                
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>    
    </div>
    
    @endsection
    
    