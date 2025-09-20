@extends('admin.templates.partials.default')

<!-- Load jQuery first before any other scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css" />

<!-- Select2 after jQuery -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
// jQuery conflict resolution and validation
(function() {
    // Ensure jQuery is available
    if (typeof jQuery === 'undefined') {
        console.error('jQuery is not available!');
        return;
    }
    
    // Create a safe reference to jQuery
    var $safe = jQuery.noConflict(true);
    
    // Make it available globally as $ and jQuery
    window.$ = window.jQuery = $safe;
    
    console.log('jQuery loaded successfully:', $safe.fn.jquery);
})();
</script>

<style>
/* Custom Select2 Styling */
.select2-container--bootstrap4 .select2-selection--single {
    height: calc(2.25rem + 2px) !important;
    border: 1px solid #ced4da !important;
    border-radius: 0.25rem !important;
    padding: 0.375rem 0.75rem !important;
}

.select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
    color: #495057 !important;
    line-height: 1.5 !important;
    padding-left: 0 !important;
    padding-right: 20px !important;
}

.select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow {
    height: calc(2.25rem + 2px) !important;
    right: 10px !important;
}

.select2-container--bootstrap4 .select2-dropdown {
    border: 1px solid #ced4da !important;
    border-radius: 0.25rem !important;
}

.select2-container {
    width: 100% !important;
}

.select2-container--bootstrap4.select2-container--focus .select2-selection--single {
    border-color: #80bdff !important;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
}
</style>
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row" id="form_list_mc">
            <div class="col-md-5">
                <h4 class="modal-title">Tambah Joint</h4>
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

                <form action="{{ route('joint.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Kode</label>
                                <input type="text" class="form-control txt_line" name="kode" id="kode">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control txt_line" name="nama" id="nama">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Branch</label>
                                <input type="text" class="form-control txt_line" name="branch" id="branch">
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
</script>