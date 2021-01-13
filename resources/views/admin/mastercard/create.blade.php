@extends('admin.templates.partials.default')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>


@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row" id="form_list_mc">
            <div class="col-md-12">
                <h4 class="modal-title">Buat Master Card</h4>
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
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="control-label">No. MasterCard</label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="row">
                                                <input type="text" class="form-control txt_line" name="kode" id="kode" placeholder="No. MasterCard">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="control-label">No. Item</label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="row">
                                                <input type="text" class="form-control txt_line" name="noitem" id="noitem" placeholder="No. Item" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">                                    
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Nama Item</label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="row">
                                                <input type="hidden" class="form-control txt_line col-md-11" value="" id="bj_id" name="bj_id">
                                                <input type="text" class="form-control txt_line col-md-11" value="" id="namaitem" readonly>
                                                <button type="button" class="col-md-1" data-toggle="modal" data-target="#Item" id>
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                            <!-- Modal -->
                                            <div class="modal fade" id="Item">
                                                <div class="modal-dialog modal-xl">
                                                    
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Modal Header</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body Item">
                                                            <div class="card-body">
                                                                <table class="table table-bordered" id="data_barang">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">ID.</th>
                                                                            <th scope="col">Kode</th>
                                                                            <th scope="col">Nama</th>
                                                                            <th scope="col">MC ID</th>
                                                                            <th scope="col">Pcs</th>
                                                                            <th scope="col">Gram</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        $no = 1;
                                                                        foreach ($item as $data) { ?>
                                                                            <tr>
                                                                                <td scope="row">{{ $data->id }}</td>
                                                                                <td>{{ $data->kode }}</td>
                                                                                <td>{{ $data->nama }}</td>
                                                                                <td>{{ $data->mc_id }}</td>
                                                                                <td>{{ $data->pcs }}</td>
                                                                                <td>{{ $data->gram }}</td>
                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Flute</label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="row">
                                                <select class="js-example-basic-single col-md-12" name="flute" id="flute">
                                                    <option value="-">Select ...</option>
                                                    <option value="BF">BF</option>
                                                    <option value="CF">CF</option>
                                                    <option value="BCF">BCF</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>BOX</label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="row">
                                                <select class="js-example-basic-single col-md-12">
                                                    @foreach ($boxes as $box)
                                                    <option value="{{ $box->id }}">{{ $box->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Sheet</label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="row">
                                                <input type="hidden" class="form-control txt_line col-md-11" value="" id="sheet_id" name="sheet_id">
                                                <input type="text" class="form-control txt_line col-md-11" value="" id="namasheet" readonly>
                                                <button type="button" class="col-md-1" data-toggle="modal" data-target="#Sheet">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                            <!-- Modal -->
                                            <div class="modal fade" id="Sheet">
                                                <div class="modal-dialog modal-xl">
                                                    
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Modal Header</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body Item">
                                                            <div class="card-body">
                                                                <table class="table table-bordered" id="data_sheet">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">ID.</th>
                                                                            <th scope="col">Kode</th>
                                                                            <th scope="col">Nama</th>
                                                                            <th scope="col">Lebar</th>
                                                                            <th scope="col">Panjang</th>
                                                                            <th scope="col">Luas</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        $no = 1;
                                                                        foreach ($sheet as $data) { ?>
                                                                            <tr>
                                                                                <td scope="row">{{ $data->id }}</td>
                                                                                <td>{{ $data->kode }}</td>
                                                                                <td>{{ $data->nama }}</td>
                                                                                <td>{{ $data->lebarSheet }}</td>
                                                                                <td>{{ $data->panjangSheet }}</td>
                                                                                <td>{{ $data->luasSheet }}</td>
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="control-label">Luas Sheet</label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="row">
                                                <input type="text" class="form-control txt_line" name="luasSheet" id="luasSheet" placeholder="No. Item" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    // Datatable Barang(Item)
    $(".Item").ready(function(){
        
        var table = $("#data_barang").DataTable({
            select: true,
        });
        
        $('#data_barang tbody').on( 'click', 'td', function () {
            var item = (table.row(this).data());
            
            document.getElementById('bj_id').value = item[0];
            document.getElementById('noitem').value = item[1];
            document.getElementById('namaitem').value = item[2];
        } );
        //  alert.row();
    } );

    $(".Item").ready(function(){
        
        var table = $("#data_flute").DataTable({
            select: true,
        });
        
        $('#data_flute tbody').on( 'click', 'td', function () {
            var flute = (table.row(this).data());
            
            document.getElementById('flute_id').value = flute[0];
            document.getElementById('namaflute').value = flute[1];
            document.getElementById('tur').value = flute[3];
        } );
        //  alert.row();
    } );
    
    $(".Sheet").ready(function(){
        
        var table = $("#data_sheet").DataTable({
            select: true,
        });
        
        $('#data_sheet tbody').on( 'click', 'td', function () {
            var sheet = (table.row(this).data());
            
            document.getElementById('namasheet').value = sheet[2];
            document.getElementById('luasSheet').value = sheet[5];
        } );
        //  alert.row();
    } );

    
    
</script>