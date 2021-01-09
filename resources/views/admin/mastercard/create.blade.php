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
                                            <label>Item</label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="row">
                                                <input type="text" class="form-control txt_line col-md-11" value="" id="bj_id" readonly>
                                                <button type="button" class="col-md-1" data-toggle="modal" data-target="#Item">
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
                                                                            <th scope="col">No.</th>
                                                                            <th scope="col">Kode</th>
                                                                            <th scope="col">Nama</th>
                                                                            <th scope="col">Satuan</th>
                                                                            <th scope="col">Berat Standart</th>
                                                                            <th scope="col">Harga Jual</th>
                                                                            <th scope="col">Berat CRT</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        $no = 1;
                                                                        foreach ($item as $data) { ?>
                                                                            <tr>
                                                                                <td scope="row">{{ $no++ }}</td>
                                                                                <td>{{ $data->KodeBrg }}</td>
                                                                                <td>{{ $data->NamaBrg }}</td>
                                                                                <td>{{ $data->Satuan }}</td>
                                                                                <td>{{ $data->BeratStandart }}</td>
                                                                                <td>{{ $data->HargaJualRp }}</td>
                                                                                <td>{{ $data->BeratCRT }}</td>
                                                                                {{-- <td>
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-append" id="button-addon4">
                                                                                            <a href="/admin/divisi/show/{{ $data->KodeBrg }}" class="btn btn-outline-secondary" type="button">View</a>
                                                                                            <a href="/admin/divisi/edit/{{ $data->KodeBrg }}" class="btn btn-outline-secondary" type="button">Edit</a>
                                                                                            <a href="/admin/divisi/delete/{{ $data->KodeBrg }}" class="btn btn-outline-danger" type="button">Delete</a>
                                                                                        </div>
                                                                                    </div>
                                                                                </td> --}}
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
                                            {{-- <select class="js-example-basic-single col-md-12">
                                                @foreach ($item as $item)
                                                <option value="{{ $item->KodeBrg }}">{{ $item->KodeBrg }} || {{ $item->NamaBrg }}</option>
                                                @endforeach
                                            </select> --}}
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
                                                    <option value="">{{ $box->id }} || {{ $box->nama }}</option>
                                                    @endforeach
                                                </select>
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
    $(".itemSearch").click(function() {
        $("#Item").modal('show');
    });
    // Datatable Barang(Item)
    $(".Item").ready(function(){
        
        var table = $("#data_barang").DataTable({
            select: true,
        });
        
        $('#data_barang tbody').on( 'click', 'td', function () {
            var kodeBrg = (table.row(this).data());
            var namaBrg = (table.row(this).data())
            
            document.getElementById('bj_id').value = kodeBrg[1];
            console.log(kodeBrg[1],namaBrg[2]);
        } );
        //  alert.row();
    } );
    
    
</script>