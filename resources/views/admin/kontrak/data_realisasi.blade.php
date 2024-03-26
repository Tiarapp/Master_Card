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
                
                @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{{ $message }}</strong>
                </div>
                 @endif
                <form id="jquery-val-form" action="{{ route('kontrak.store_realisasi') }}" onsubmit="return validateForm()" method="post">
                {{csrf_field()}}
                    <div class="row">
                        <div class="col-md-3">
                            <div id="listKontrak">    
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>No Kontrak</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="hidden" class="form-control txt_line" name="idkontrak[{{ $kontrak_M->id }}]" id="idkontrak[{{ $kontrak_M->id }}]" value="{{ $kontrak_M->id }}" readonly>
                                                    <input type="text" class="form-control txt_line" name="noKontrak[{{ $kontrak_M->id }}]" id="noKontrak[{{ $kontrak_M->id }}]" value="{{ $kontrak_M->kode }}" readonly>
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-icon btn-success" data-toggle="modal" data-target="#modal-kontrak" title="Tambah Kontrak"><i class="fas fa-plus-circle fa-lg"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="modal-kontrak">
                                <div class="modal-dialog modal-xl">                                                    
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">List Kontrak</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body kontrak">
                                            <div class="card-body">
                                                <table class="table table-bordered" id="data_kontrak">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Kode</th>
                                                            <th scope="col">Customer</th>
                                                            <th scope="col">QTY</th>
                                                            <th scope="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        foreach ($kontrakMaster as $data) { ?>
                                                            <tr class="modal-plan-list">
                                                                <td>
                                                                    {{ $data->id }}
                                                                </td>
                                                                <td scope="row">{{ $data->kode }}</td>
                                                                <td>{{ $data->pcsKontrak }}</td>
                                                                <td><button class="btn btn-success" type="button">Add</button></td>
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
                            <!-- Modal -->
                            <div class="modal fade" id="modal-sj">
                                <div class="modal-dialog modal-xl">                                                    
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">List Surat Jalan</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body sj">
                                            <div class="card-body">
                                                <table class="table table-bordered" id="data_sj">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Surat Jalan</th>
                                                            <th scope="col">Tanggal</th>
                                                            <th scope="col">Customer</th>
                                                            <th scope="col">MOD</th>
                                                            <th scope="col">Qty</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        foreach ($sj as $data) { ?>
                                                            <tr class="modal-plan-list">
                                                                <td>
                                                                    {{ trim($data->nomer) }}
                                                                </td>
                                                                <td scope="row">{{ $data->TglSJ }}</td>
                                                                <td>{{ $data->NamaCust }}</td>
                                                                <td>{{ trim($data->NomerMOD) }}</td>
                                                                <td>{{ number_format($data->Quantity) }}</td>
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
                                            <div class="col-md-8">
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
                                            <div class="col-md-4">
                                                <input type="text" class="form-control txt_line" name="qtyOrder" id="qtyOrder" value="{{ $kontrak_D->pcsKontrak }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="message-text" class="col-form-label">Surat Jalan:</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="sj" id="sj" required readonly>
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
                                                <label for="message-text" class="col-form-label">Tanggal Kirim:</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="date" class="form-control" name="tglKirim" id="tglKirim" required readonly>
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
                                                <label for="message-text" class="col-form-label">MOD:</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="mod" id="mod" required readonly>
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
                                                <label for="message-text" class="col-form-label">Jumlah Kirim:</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="jumlahKirim" id="jumlahKirim" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" >Save</button>
                        </div>
                    </div>
                    
                </form>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-sj">Tambah</button>
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
                        @include('admin.kontrak.edit_kirim')
                        @endforeach
                    </tbody>
                    </table>
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

    $(".kontrak").ready(function(){            
        var table = $("#data_kontrak").DataTable({
            select: true,
            "order": [0, 'desc']
        });
        
        $('#data_kontrak tbody').on( 'click', 'td', function () {
            var kontrak = (table.row(this).data());
            var html = '';

            html += "<div id='listKontrak'>"  
                html += "<div class='row'>"
                    html += "<div class='col-md-12'>"
                        html += "<div class='form-group'>"
                            html += "<div class='row'>"
                                html += "<div class='col-md-4'>"
                                    html += "<label>No Kontrak</label>"
                                html += "</div>"
                                html += "<div class='col-md-6'>"
                                    html += "<input type='hidden' class='form-control txt_line' name='idkontrak["+kontrak[0]+"]' id='idkontrak["+kontrak[0]+"]' value='"+kontrak[0]+"' readonly>"
                                    html += "<input type='text' class='form-control txt_line' name='noKontrak["+kontrak[0]+"]' id='noKontrak["+kontrak[0]+"]' value='"+kontrak[1]+"' readonly>"
                                html += "</div>"
                                html += "<div class='col-md-2'>"
                                    html += "<button type='button' class='remove-kontrak btn btn-danger'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                                html += "</div>"
                            html += "</div>"
                        html += "</div>"
                    html += "</div>"
                html += "</div>"
            html += "</div>"

            $("#listKontrak").append(html)
            $("#modal-kontrak").modal("hide")
        });
    });
    
    $(document).on("click", ".remove-kontrak", function(e) {
        if (confirm('Yakin ingin menghapus Kontrak ini ?')) {
            $(this).closest("#listKontrak").remove();
        }
    });

    $("#detail_kontrak").DataTable({
        "paging":   false,
        "ordering": false,
        "info":     false,
        "searching": false,
        "initComplete": function (settings, json) {  
            $("#detail_kontrak").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
        },
        // "scrollY": "400px",
        select: true,
    });

    $(".sj").ready(function(){            
        var table = $("#data_sj").DataTable({
            select: true,
            "order": [0, 'desc']
        });
        
        $('#data_sj tbody').on( 'click', 'td', function () {
            var kontrak = (table.row(this).data());

            document.getElementById("tglKirim").value = kontrak[1]
            document.getElementById("jumlahKirim").value = kontrak[4]
            document.getElementById("sj").value = kontrak[0]
            document.getElementById("mod").value = kontrak[3]

            $("#modal-sj").modal("hide")
        });
    });
    
</script>

@endsection