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
            <div class="col-md-12">
                <h4 class="modal-title">Tambah Sheet</h4>
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

                <form action="{{ route('sheet.store') }}" method="POST" class="inputSheet">
                    @csrf
                    <div class="row was-validated">
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input kode sheet">
                            <div class="form-group">
                                <label>Kode Gudang</label>
                                <input type="text" class="form-control txt_line" placeholder="Input kode sheet" name="kode" id="kode" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input nama sheet">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control txt_line" placeholder="Input nama sheet" name="nama" id="nama" required readonly>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input lebar sheet">
                            <div class="form-group">
                                <label>Lebar</label>
                                <input type="text" class="form-control txt_line" placeholder="Input Lebar Sheet" name="lebarSheet" id="lebarSheet" onchange="luas()" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input panjang sheet">
                            <div class="form-group">
                                <label>Panjang</label>
                                <input type="text" class="form-control txt_line" placeholder="Input panjang sheet" name="panjangSheet" id="panjangSheet" onchange="luas(); getNama();" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input satuan size sheet">
                            <div class="form-group">
                                <label>Satuan Size</label>
                                <select class="js-example-basic-single col-md-12" name="satuanSizeSheet" id="satuanSizeSheet">
                                    {{-- @foreach ($satuan as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Luas sheet">
                            <div class="form-group">
                                <label>Luas</label>
                                <input type="text" class="form-control txt_line" name="luasSheet" id="luasSheet" required readonly>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input satuan luas sheet">
                            <div class="form-group">
                                <label>Satuan Luas</label>
                                <select class="js-example-basic-single col-md-12" name="satuanLuasSheet" id="satuanLuasSheet">
                                    {{-- @foreach ($satuan as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                        <input type="hidden" class="form-control txt_line" name="createdBy" id="createdBy" value="{{ Auth::user()->name }}">
                        <div class="col-md-12">
                            <button type="submit" id="save" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Save">
                                <i class='far fa-check-square'></i>
                            </button>
                            <button type="button" id="cancel" class="btn" data-toggle="tooltip" data-placement="right" title="Cancel">
                                <a href="/admin/sheet">
                                    <i class='far fa-window-close' style='color:red'></i>
                                </a></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>    
</div>

@endsection

<script type="text/javascript">
    // Ensure jQuery is loaded before proceeding
    function waitForJQuery(callback) {
        if (typeof jQuery !== 'undefined') {
            callback(jQuery);
        } else {
            setTimeout(function() {
                waitForJQuery(callback);
            }, 50);
        }
    }

    // Initialize everything after jQuery is ready
    waitForJQuery(function($) {
        console.log('jQuery is ready:', $.fn.jquery);
        
        // Document ready handler
        $(document).ready(function() {
            console.log('Document ready, preparing Select2...');
            
            // Initialize immediately
            initializeSelect2();
            
            // Fallback initialization after a delay
            setTimeout(function() {
                if (!$('.js-example-basic-single').hasClass('select2-hidden-accessible')) {
                    console.log('Select2 not initialized yet, forcing initialization...');
                    initializeSelect2();
                }
            }, 1000);
        });

        // Window load handler for final initialization
        $(window).on('load', function() {
            console.log('Window loaded, final Select2 check...');
            
            // Final initialization attempt
            setTimeout(function() {
                initializeSelect2();
            }, 500);
        });

        function initializeSelect2() {
            console.log('Initializing Select2...');
            
            // Check if Select2 is available
            if (typeof $.fn.select2 === 'undefined') {
                console.error('Select2 plugin not available!');
                return;
            }
            
            // Find all select elements
            var selectElements = $('.js-example-basic-single');
            console.log('Found', selectElements.length, 'select elements');
            
            if (selectElements.length === 0) {
                console.error('No select elements found with class js-example-basic-single');
                return;
            }
            
            // Destroy existing instances safely
            selectElements.each(function() {
                var $this = $(this);
                if ($this.hasClass('select2-hidden-accessible')) {
                    console.log('Destroying existing Select2 for', $this.attr('id'));
                    try {
                        $this.select2('destroy');
                    } catch (e) {
                        console.warn('Error destroying Select2:', e);
                    }
                }
            });
            
            // Initialize Select2 with error handling
            try {
                selectElements.select2({
                    theme: 'bootstrap4',
                    width: '100%',
                    placeholder: function() {
                        return $(this).data('placeholder') || 'Pilih opsi...';
                    },
                    allowClear: true,
                    minimumResultsForSearch: 0, // Always show search box
                    escapeMarkup: function(markup) {
                        return markup;
                    },
                    language: {
                        noResults: function() {
                            return "Tidak ada hasil ditemukan";
                        },
                        searching: function() {
                            return "Mencari...";
                        },
                        inputTooShort: function() {
                            return "Masukkan minimal 1 karakter untuk mencari";
                        }
                    }
                });
                
                // Verify initialization
                var initializedCount = 0;
                selectElements.each(function() {
                    if ($(this).hasClass('select2-hidden-accessible')) {
                        initializedCount++;
                        console.log('✓ Select2 initialized for', $(this).attr('id'));
                    } else {
                        console.error('✗ Select2 failed for', $(this).attr('id'));
                    }
                });
                
                console.log('Select2 initialized for', initializedCount, 'out of', selectElements.length, 'elements');
                
            } catch (error) {
                console.error('Error initializing Select2:', error);
            }
        }

        // Global scope assignment for backward compatibility
        window.initializeSelect2 = initializeSelect2;
    });

function luas(){
    var panjang = document.getElementById("panjangSheet").value;
    var lebar = document.getElementById("lebarSheet").value;
    var luas;

        // panjang = document.getElementById("panjangSheet").value;
        // lebar = document.getElementById("lebarSheet").value;
        // if (panjang == ""){
        //     alert("Panjang Harus diisi !");
        //     return;
        // }else if (lebar == ""){
        //     alert("Lebar Harus diisi !");
        //     return;
        // }
        // if (isNaN(panjang)){
        //     alert("Panjang Harus diisi dengan angka !");
        //     return;
        // }if (isNaN(lebar)){
        //     alert("Lebar Harus diisi dengan angka !");
        //     return;
        // }
        luas = panjang * lebar;
        document.getElementById("luasSheet").value =  luas;
}

function getNama(){
    var panjang = document.getElementById("panjangSheet").value;
    var lebar = document.getElementById("lebarSheet").value;

    document.getElementById("nama").value = panjang +' x '+ lebar;
}

</script>