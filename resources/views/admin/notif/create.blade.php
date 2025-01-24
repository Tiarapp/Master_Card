@extends('admin.templates.partials.default')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row" id="form_list_mc">
            <div class="col-md-5">
                <h4 class="modal-title">Tambah Koli</h4>
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

                <form action="{{ route('job.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="date" class="form-control txt_line" value="{{ date('Y-m-d') }}" name="tanggal" id="tanggal" readonly>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div id="listKontrak">    
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-icon btn-success" data-toggle="modal" data-target="#modal-kontrak" title="Tambah Kontrak"><i class="fas fa-plus-circle fa-lg"></i></button>
                                </div>
                            </div>
                        </div>
                        
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
                                                        <th scope="col">ID</th>
                                                        <th scope="col">Kode</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    foreach ($kontrak as $data) { ?>
                                                        <tr class="modal-plan-list">
                                                            <td>
                                                                {{ $data->id }}
                                                            </td>
                                                            <td scope="row">{{ $data->kode }}</td>
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
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Alasan</label>
                                <input type="text" class="form-control txt_line" name="alasan" id="alasan">
                            </div>
                        </div>
                        <input type="hidden" class="form-control txt_line" name="createdBy" id="createdBy" value="{{ Auth::user()->name }}">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>    
</div>

@endsection

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
</script>