@extends('admin.templates.partials.default')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

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
                
                <form action="/admin/sj_palet/store"  method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Tanggal</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="date" class="form-control txt_line" name="tanggal" id="tanggal">
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
                                        <input type="text" class="form-control txt_line" name="noSuratJalan" id="noSuratJalan">
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
                                        <input type="text" class="form-control txt_line" name="noPolisi" id="noPolisi">
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
                                        <input type="text" class="form-control txt_line" name="noPoCustomer" id="noPoCustomer">
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
                                        <input type="text" class="form-control txt_line" name="namaCustomer" id="namaCustomer">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Alamat Customer</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control txt_line" name="alamatCustomer" id="alamatCustomer">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Catatan</label>
                            {{-- <textarea name="keterangan" id="keterangan" cols="30" rows="10"></textarea> --}}
                            <input type="text" class="form-control txt_line" name="catatan" id="catatan">
                        </div>
                    </div>
                    
                    <table class="table table-bordered" id="">
                        <thead>
                            <tr>
                                <th scope="col">Nama</th>
                                <th scope="col">Ukuran</th>
                                <th scope="col">No Kontrak</th>
                                <th scope="col">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class='tr_input'>
                                <td>
                                    {{-- <select class="js-example-basic-single col-md-12" name="warna" id="warna">
                                        <option value=''>--</option>
                                        @foreach ($palet as $data)
                                        <option value="{{ $data->id }}|{{ $data->nama }}">{{ $data->nama }}</option>
                                        @endforeach
                                    </select> --}}
                                    <input type="text" class="nama" id="nama_1">
                                </td>
                                <td><input type="text" class="ukuran" id="ukuran_1" readonly></td>
                                <td><input type="text" class="noKontrak" id="noKontrak_1"></td>
                                <td><input type="text" class="keterangan" id="keterangan_1"></td>
                            </tr>
                        </tbody>
                    </table>
                    
                    
                    <input type="hidden" class="form-control txt_line" name="createdBy" id="createdBy" value="{{ Auth::user()->name }}">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
                
                <br>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <button type="submit" class="btn btn-primary" name="addmore" id="addmore">Add More</button>
                </div>
                <br>
                <br>
            </div>
        </div>
    </div>    
</div>

@endsection

@section('javascripts')

<script type="text/javascript">
    // $(document).ready(function() {
    //     $('.js-example-basic-single').select2();
    // });

    $(document).ready(function() {
        $(document).on('keydown', '.nama', function() {
            var id = this.id
            var split_id = id.split('_');
            var index = split_id[1];

            $( '#'+id ).autocomplete({
                    source: function( request, response ) {
                        $.ajax({
                            url: "{{ route('palet.getPalet') }}",
                            type: 'get',
                            dataType: "json",
                            data: {
                                search: request.term,
                                request:1
                            },
                            success: function( data ) {
                                response( data );
                            }
                        });
                    },
                    select: function (event, ui) {
                        $(this).val(ui.item.label); // display the selected text
                        var userid = ui.item.value; // selected id to input

                        // AJAX
                        $.ajax({
                            url: 'getDetails.php',
                            type: 'post',
                            data: {userid:userid,request:2},
                            dataType: 'json',
                            success:function(response){
                                
                                var len = response.length;

                                if(len > 0){
                                    var id = response[0]['id'];
                                    var name = response[0]['name'];
                                    var email = response[0]['email'];
                                    var age = response[0]['age'];
                                    var salary = response[0]['salary'];

                                    document.getElementById('name_'+index).value = name;
                                    document.getElementById('age_'+index).value = age;
                                    document.getElementById('email_'+index).value = email;
                                    document.getElementById('salary_'+index).value = salary;
                                    
                                }
                                
                            }
                        });

                        return false;
                    }
                });
        });
    });
    // Add more
    $('#addmore').click(function(){
        
        // Get last id 
        var lastname_id = $('.tr_input input[type=text]:nth-child(1)').last().attr('id');
        var split_id = lastname_id.split('_');
        
        // New index
        var index = Number(split_id[1]) + 1;
        
        // Create row with input elements
        var html = "<tr class='tr_input'> <select class='js-example-basic-single col-md-12' name='warna' id='warna'><option value=''>--</option></select><td><input type='text' name='ukuran_"+index+"' id='ukuran_"+index+"'></td><td><input type='text' name='noKontrak_"+index+"' id='noKontrak_"+index+"'></td><td><input type='text' name='keterangan_"+index+"' id='keterangan_"+index+"'></td></tr>";
        
        // Append data
        $('tbody').append(html);
        
    });
</script>

@endsection