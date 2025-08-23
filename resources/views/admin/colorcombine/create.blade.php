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
            <div class="col-md-9">
                <h4 class="modal-title">Tambah Color Combine</h4>
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
                
                <form action="{{ route('colorcombine.store') }}" method="POST">
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
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {{-- <label>Warna 1</label> --}}
                                        <input type="hidden" name="idColor1" id="idColor1">
                                        <input type="hidden" name="warna1" id="warna1">
                                        <select class="js-example-basic-single col-md-12" name="wrn1" id="wrn1" onchange="getWarna();getNama()">
                                            <option value="Tidak Ada" disabled selected>Warna 1</option>
                                            <option value="Tidak Ada">Tidak Ada</option>
                                            @foreach ($color as $data)
                                            <option value="{{ $data->id }}|{{ $data->nama }}">{{ $data->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {{-- <label>Warna 2</label> --}}
                                        <input type="hidden" name="idColor2" id="idColor2">
                                        <input type="hidden" name="warna2" id="warna2">
                                        <select class="js-example-basic-single col-md-12" name="wrn2" id="wrn2" onchange="getWarna();getNama()">
                                            <option value="Tidak Ada" disabled selected>Warna 2</option>
                                            <option value="Tidak Ada">Tidak Ada</option>
                                            @foreach ($color as $data)
                                            <option value="{{ $data->id }}|{{ $data->nama }}">{{ $data->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {{-- <label>Warna 3</label> --}}
                                        <input type="hidden" name="idColor3" id="idColor3">
                                        <input type="hidden" name="warna3" id="warna3">
                                        <select class="js-example-basic-single col-md-12" name="wrn3" id="wrn3" onchange="getWarna();getNama()">
                                            <option value="Tidak Ada" disabled selected>Warna 3</option>
                                            <option value="Tidak Ada">Tidak Ada</option>
                                            @foreach ($color as $data)
                                            <option value="{{ $data->id }}|{{ $data->nama }}">{{ $data->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {{-- <label>Warna 4</label> --}}
                                        <input type="hidden" name="idColor4" id="idColor4">
                                        <input type="hidden" name="warna4" id="warna4">
                                        <select class="js-example-basic-single col-md-12" name="wrn4" id="wrn4" onchange="getWarna();getNama()">
                                            <option value="Tidak Ada" disabled selected>Warna 4</option>
                                            <option value="Tidak Ada">Tidak Ada</option>
                                            @foreach ($color as $data)
                                            <option value="{{ $data->id }}|{{ $data->nama }}">{{ $data->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {{-- <label>Warna 4</label> --}}
                                        <input type="hidden" name="idColor5" id="idColor5">
                                        <input type="hidden" name="warna5" id="warna5">
                                        <select class="js-example-basic-single col-md-12" name="wrn5" id="wrn5" onchange="getWarna();getNama()">
                                            <option value="Tidak Ada" disabled selected>Warna 5</option>
                                            <option value="Tidak Ada">Tidak Ada</option>
                                            @foreach ($color as $data)
                                            <option value="{{ $data->id }}|{{ $data->nama }}">{{ $data->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" id="new" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Add New Color">
                                        <i class='fas fa-plus-circle fa-2x'></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" class="form-control txt_line" name="createdBy" id="createdBy" value="{{ Auth::user()->name }}">
                        <div class="col-md-12">
                            <button type="submit" id="save" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="save">
                                <i class='far fa-check-square'></i>
                            </button>
                            <button type="button" id="cancel" class="btn" data-toggle="tooltip" data-placement="right" title="cancel">
                                <a href="{{ route('colorcombine') }}">
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

        // Reinitialize Select2 after any dynamic content changes
        function reinitializeSelect2() {
            console.log('Reinitializing Select2...');
            initializeSelect2();
        }

        // Add event listeners for select changes to maintain functionality
        $(document).on('select2:select', '#wrn1, #wrn2, #wrn3, #wrn4, #wrn5', function (e) {
            console.log('Select2 selection changed for', $(this).attr('id'));
            if (typeof getWarna === 'function') {
                getWarna();
            }
            if (typeof getNama === 'function') {
                getNama();
            }
        });

        // Test function to manually trigger Select2
        window.testSelect2 = function() {
            console.log('=== Testing Select2 ===');
            console.log('jQuery available:', typeof $ !== 'undefined');
            console.log('jQuery version:', $.fn.jquery);
            console.log('Select2 available:', typeof $.fn.select2 !== 'undefined');
            
            $('.js-example-basic-single').each(function() {
                var $this = $(this);
                console.log('Element:', $this.attr('id'), 'Has Select2:', $this.hasClass('select2-hidden-accessible'));
            });
            
            // Force reinitialize
            console.log('Force reinitializing...');
            reinitializeSelect2();
        };

        // Manual initialization function
        window.forceSelect2 = function() {
            console.log('=== Force Select2 Initialization ===');
            
            // Try direct initialization without destroy
            $('.js-example-basic-single').each(function() {
                var $element = $(this);
                var id = $element.attr('id');
                
                console.log('Processing element:', id);
                
                try {
                    $element.select2({
                        theme: 'bootstrap4',
                        width: '100%',
                        minimumResultsForSearch: 0,
                        placeholder: 'Pilih opsi...',
                        allowClear: true
                    });
                    console.log('✓ Success for', id);
                } catch (error) {
                    console.error('✗ Error for', id, ':', error);
                }
            });
        };

        // Global scope assignment for backward compatibility
        window.initializeSelect2 = initializeSelect2;
        window.reinitializeSelect2 = reinitializeSelect2;
    });        function getWarna(){
            var wrn1 = document.getElementById("wrn1").value;
            var wrn2 = document.getElementById("wrn2").value;
            var wrn3 = document.getElementById("wrn3").value;
            var wrn4 = document.getElementById("wrn4").value;
            var wrn5 = document.getElementById("wrn5").value;
            
            if (wrn1 == 'Tidak Ada') {
                document.getElementById("idColor1").value = null;
                document.getElementById("warna1").value = '-';
            } else {
                wrn1 = wrn1.split("|");
                document.getElementById("idColor1").value = wrn1[0];
                document.getElementById("warna1").value = wrn1[1];
            }
            
            if (wrn2 == 'Tidak Ada') {
                document.getElementById("idColor2").value = null;
                document.getElementById("warna2").value = '-';
            } else {
                wrn2 = wrn2.split("|");
                document.getElementById("idColor2").value = wrn2[0];
                document.getElementById("warna2").value = wrn2[1];
            }

            if (wrn3 == 'Tidak Ada') {
                document.getElementById("idColor3").value = null;
                document.getElementById("warna3").value = '-';
            } else {
                wrn3 = wrn3.split("|");
                document.getElementById("idColor3").value = wrn3[0];
                document.getElementById("warna3").value = wrn3[1];
            }

            if (wrn4 == 'Tidak Ada') {
                document.getElementById("idColor4").value = null;
                document.getElementById("warna4").value = '-';
            } else {
                wrn4 = wrn4.split("|");
                document.getElementById("idColor4").value = wrn4[0];
                document.getElementById("warna4").value = wrn4[1];
            }  
            
            if (wrn5 == 'Tidak Ada') {
                document.getElementById("idColor5").value = null;
                document.getElementById("warna5").value = '-';
            } else {
                wrn5 = wrn5.split("|");
                document.getElementById("idColor5").value = wrn5[0];
                document.getElementById("warna5").value = wrn5[1];
            }  
            
        }
        
        function getNama(){
            var wrn1 = document.getElementById("warna1").value;
            var wrn2 = document.getElementById("warna2").value;
            var wrn3 = document.getElementById("warna3").value;
            var wrn4 = document.getElementById("warna4").value;
            var wrn5 = document.getElementById("warna5").value;
            
            document.getElementById("nama").value = wrn1+' '+wrn2+' '+wrn3+' '+wrn4+' '+wrn5;
            document.getElementById("kode").value = wrn1+' '+wrn2+' '+wrn3+' '+wrn4+' '+wrn5;
        }
    </script>