@extends('admin.templates.partials.default')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row" id="form_list_mc">
            <div class="col-md-5">
                <h4 class="modal-title"><strong>View Supplier</strong> </h4>
                <hr>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Error!</strong> 
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li></li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="#" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="hidden" name="id" value="{{ $supplier->id }}">                                
                            </div>
                            <div class="form-group">
                                <label>Kode</label>
                                {{-- <div class="row"> --}}
                                    {{-- <input type="text" class="form-control txt_line col-md-2" name="kode" id="kode" value="STN" readonly> --}}
                                <input type="text" class="form-control txt_line" name="kode" id="kode" value="{{ $supplier->Kode }}" readonly>
                                {{-- </div> --}}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control txt_line" name="nama" id="nama" value="{{ $supplier->Nama }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Kode Nama Acc</label>
                                <input type="text" class="form-control txt_line" name="branch" id="branch" value="{{ $supplier->KodeNamaAcc }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nama Acc</label>
                                <input type="text" class="form-control txt_line" name="branch" id="branch" value="{{ $supplier->NamaAcc }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Alamat</label>
                                <input type="text" class="form-control txt_line" name="branch" id="branch" value="{{ $supplier->AlamatKantor }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Kota</label>
                                <input type="text" class="form-control txt_line" name="branch" id="branch" value="{{ $supplier->KotaKantor }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Telpon</label>
                                <input type="text" class="form-control txt_line" name="branch" id="branch" value="{{ $supplier->TelpKantor }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Fax</label>
                                <input type="text" class="form-control txt_line" name="branch" id="branch" value="{{ $supplier->FaxKantor }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>PIC</label>
                                <input type="text" class="form-control txt_line" name="branch" id="branch" value="{{ $supplier->PIC }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Telpon PIC</label>
                                <input type="text" class="form-control txt_line" name="branch" id="branch" value="{{ $supplier->TelpPIC }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Plafond</label>
                                <input type="text" class="form-control txt_line" name="branch" id="branch" value="{{ $supplier->Plafond }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Waktu Bayar</label>
                                <input type="text" class="form-control txt_line" name="branch" id="branch" value="{{ $supplier->WaktuBayar }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Jenis Bayar</label>
                                <input type="text" class="form-control txt_line" name="branch" id="branch" value="{{ $supplier->JenisBayar }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Area</label>
                                <input type="text" class="form-control txt_line" name="branch" id="branch" value="{{ $supplier->Area }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>NPWP</label>
                                <input type="text" class="form-control txt_line" name="branch" id="branch" value="{{ $supplier->NPWP }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>NPPKP</label>
                                <input type="text" class="form-control txt_line" name="branch" id="branch" value="{{ $supplier->NPPKP }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>BANK</label>
                                <input type="text" class="form-control txt_line" name="branch" id="branch" value="{{ $supplier->Bank }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>No. Acc</label>
                                <input type="text" class="form-control txt_line" name="branch" id="branch" value="{{ $supplier->NoAcc }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Rek</label>
                                <input type="text" class="form-control txt_line" name="branch" id="branch" value="{{ $supplier->NamaRek }}">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>    
</div>

@endsection