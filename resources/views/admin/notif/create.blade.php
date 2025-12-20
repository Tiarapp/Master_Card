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
                <h4 class="modal-title">Request Buka Blok</h4>
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
                        
                        <div class="col-md-12">
                            <div id="listKontrak">    
                                <div class="col-md-2 mb-2">
                                    <button type="button" class="btn btn-icon btn-success btn-kontrak" data-toggle="modal" data-target="#modal-kontrak" title="Tambah Kontrak"><i class="fas fa-plus-circle fa-lg"></i></button>
                                </div>
                                <div class="row detail-kontrak">

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

                <!-- Modal Kontrak -->
                <div class="modal fade kontrak-list" id="modal-kontrak">
                    <div class="modal-dialog modal-xl">                                                    
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title">{{ __('Kontrak List') }}</h3>
                                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                                </div>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-6 mb-6">
                                        <form class="form-search-kontrak" action="">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control search-item" id="search" name="search" value="" placeholder="Cari item">
                                                <button type="submit" class="btn btn-light-primary keyword-search-item-button">Search</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="content-body">
                                    Please wait...
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

@endsection

<script type="text/javascript">
    $(document).ready(function() {
        $(document).on("click", ".btn-kontrak", function(e) {
            e.preventDefault();
            $(".kontrak-list .content-body").html("Please wait...");

            var url = "{{ route('kontrak.all') }}";

            $('.form-search-kontrak').attr('action', url);

            $.get(url, function(data) {
                $(".kontrak-list .content-body").html(data);
            });
        });

        $( ".kontrak-list .form-search-kontrak" ).submit(function( e ) {
            // Stop form from submitting normally
            e.preventDefault();

            // Get some values from elements on the page:
            var $form = $( this ),
            keyword = $form.find( "input[name='search']" ).val(),
            url = $form.attr( "action" );

            $(".kontrak-list .content-body" ).html( "Please wait..." );
            $.get( url, { search: keyword }, function( data ) {
                $( ".kontrak-list .content-body" ).html( data );
            });
        });

        $(document).on("click", ".modal-kontrak-list .btn-insert-contract", function(e) {
            e.preventDefault();

            var contract_id = $(this).closest('tr').find('.contract_id').val();
            var url = "{{ route('kontrak.single', ['id' => ':id']) }}";
            url = url.replace(':id', contract_id);
            $.get(url, function(data) {

                kontrakHTML = 
                    '<div class="col-md-4 mb-3">'+
                        '<input type="text" class="form-control" name="kontrak[]" value="'+data.kode+'" readonly>'+
                        '<input type="hidden" class="form-control" name="kontrak_id[]" value="'+data.id+'">'+
                    '</div>';

                $('#listKontrak .detail-kontrak').append(kontrakHTML);
                $('#modal-kontrak').modal('hide');
            });
        });
    });
</script>