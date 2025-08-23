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
                <h4 class="modal-title">Tambah Substance</h4>
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
                
                <form action="{{ route('substance.store') }}" method="POST" class="inputSubstance">
                    @csrf
                    <div class="row was-validated">
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input Liner Atas">
                            <div class="form-group">
                                <label>Pilih Flute</label>
                                <select class="js-example-basic-single col-md-12" name="flute" id="flute" onchange="getFlute()">
                                    <option value=''>--</option>
                                    @foreach ($flute as $data)
                                    <option value="{{ $data->kode }}">{{ $data->kode }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input kode substance">
                            <div class="form-group">
                                <label>Kode</label>
                                <input type="text" class="form-control txt_line" placeholder="Input kode substance" name="kode" id="kode" required readonly>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input nama substance">
                            <div class="form-group">
                                <label>NamaMc</label>
                                <input type="text" class="form-control txt_line" placeholder="Input nama substance" name="namaMc" id="namaMc" required readonly>
                                <label>NamaLog</label>
                                <input type="text" class="form-control txt_line" placeholder="Input nama substance" name="namaLog" id="namaLog" required readonly>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input Liner Atas">
                            <div class="form-group">
                                <label>Gram Liner Atas</label>
                                <input type="hidden" id="jenisGramLinerAtas_id" name="jenisGramLinerAtas_id">
                                <select class="js-example-basic-single col-md-12" name="atas" id="atas" onchange="getNamaSubstance()" disabled>
                                    <option value=''>--</option>
                                    @foreach ($jenisgram1 as $data)
                                    <option value="{{ $data->id }}|{{ $data->namaMc }}|{{ $data->namaLog }}">{{ $data->namaMc }}/{{ $data->namaLog }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input Liner Atas">
                            <div class="form-group">
                                <label>Flute 1</label>
                                <input type="hidden" id="jenisGramFlute1_id" name="jenisGramFlute1_id">
                                <select class="js-example-basic-single col-md-12" name="flute1" id="flute1" onchange=getNamaSubstance() disabled>
                                    <option value=''>--</option>
                                    @foreach ($jenisgram1 as $data)
                                    <option value="{{ $data->id }}|{{ $data->namaMc }}|{{ $data->namaLog }}">{{ $data->namaMc }}/{{ $data->namaLog }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input Liner Atas">
                            <div class="form-group">
                                <label>Gram Liner Tengah</label>
                                <input type="hidden" id="jenisGramLinerTengah_id" name="jenisGramLinerTengah_id">
                                <select class="js-example-basic-single col-md-12" name="tengah" id="tengah" onchange="getNamaSubstance();" disabled>
                                    <option value=''>--</option>
                                    @foreach ($jenisgram1 as $data)
                                    <option value="{{ $data->id }}|{{ $data->namaMc }}|{{ $data->namaLog }}">{{ $data->namaMc }}/{{ $data->namaLog }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input Liner Atas">
                            <div class="form-group">
                                <label>Gram CF</label>
                                <input type="hidden" id="jenisGramFlute2_id" name="jenisGramFlute2_id">
                                <select class="js-example-basic-single col-md-12" name="flute2" id="flute2" onchange="getNamaSubstance();" disabled>
                                    <option value=''>--</option>
                                    @foreach ($jenisgram1 as $data)
                                    <option value="{{ $data->id }}|{{ $data->namaMc }}|{{ $data->namaLog }}">{{ $data->namaMc }}/{{ $data->namaLog }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input Liner Atas">
                            <div class="form-group">
                                <label>Gram Liner Bawah</label>
                                <input type="hidden" id="jenisGramLinerBawah_id" name="jenisGramLinerBawah_id">
                                <select class="js-example-basic-single col-md-12" name="bawah" id="bawah" onchange="getNamaSubstance();" disabled>
                                    <option value=''>--</option>
                                    @foreach ($jenisgram1 as $data)
                                    <option value="{{ $data->id }}|{{ $data->namaMc }}|{{ $data->namaLog }}">{{ $data->namaMc }}/{{ $data->namaLog }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <input type="hidden" class="form-control txt_line" name="createdBy" id="createdBy" value="{{ Auth::user()->name }}">
                        <div class="col-md-12">
                            <button type="submit" id="save" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Save">
                                <i class='far fa-check-square'></i>
                            </button>
                            <button type="button" id="cancel" class="btn" data-toggle="tooltip" data-placement="right" title="Cancel">
                                <a href="{{ route('substance') }}">
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
        $(document).on('select2:select', '#flute', function (e) {
            console.log('Flute selection changed');
            if (typeof getFlute === 'function') {
                getFlute();
            }
            // Reinitialize Select2 for elements that might have been enabled/disabled
            setTimeout(function() {
                reinitializeSelect2();
            }, 100);
        });

        $(document).on('select2:select', '#atas, #flute1, #tengah, #flute2, #bawah', function (e) {
            console.log('Substance selection changed for', $(this).attr('id'));
            if (typeof getNamaSubstance === 'function') {
                getNamaSubstance();
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
                console.log('Element:', $this.attr('id'), 'Has Select2:', $this.hasClass('select2-hidden-accessible'), 'Disabled:', $this.prop('disabled'));
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
    });        function getFlute(){
            var namaflute = document.getElementById('flute').value;

            // var namaflute = getNama(flute);
            

            if (namaflute == 'BF') {
                document.getElementById('atas').disabled = false;
                document.getElementById('flute1').disabled = false;
                document.getElementById('tengah').disabled = true;
                document.getElementById('flute2').disabled = true;
                document.getElementById('bawah').disabled = false;
            } else if(namaflute == 'CF') {
                document.getElementById('atas').disabled = false;
                document.getElementById('flute1').disabled = true;
                document.getElementById('tengah').disabled = true;
                document.getElementById('flute2').disabled = false;
                document.getElementById('bawah').disabled = false;
            } else if (namaflute == 'BCF' || namaflute == 'EBF') {
                document.getElementById('atas').disabled = false;
                document.getElementById('flute1').disabled = false;
                document.getElementById('tengah').disabled = false;
                document.getElementById('flute2').disabled = false;
                document.getElementById('bawah').disabled = false;
            } else if (namaflute == 'NF') {
                document.getElementById('atas').disabled = false;
                document.getElementById('flute1').disabled = true;
                document.getElementById('tengah').disabled = true;
                document.getElementById('flute2').disabled = true;
                document.getElementById('bawah').disabled = true;
            }
            
        }
        
        function getNamaSubstance(){
            var namaflute = document.getElementById('flute').value;

            var atas = (document.getElementById('atas').value).split("|");
            var idAtas = atas[0]
            var namaMcAtas = atas[1];
            var namaLogAtas = atas[2];

            if(idAtas == ""){
                idAtas = "";
                namaMcAtas = "--";
                namaLogAtas = "--";
                console.log(idAtas);
            }


            console.log(atas);

            var flute1 = (document.getElementById('flute1').value).split("|");
            var idflute1 = flute1[0]
            var namaMcflute1 = flute1[1];
            var namaLogflute1 = flute1[2];

            var tengah = (document.getElementById('tengah').value).split("|");
            var idTengah = tengah[0]
            var namaMcTengah = tengah[1];
            var namaLogTengah = tengah[2];

            var flute2 = (document.getElementById('flute2').value).split("|");
            var idflute2 = flute2[0]
            var namaMcflute2 = flute2[1];
            var namaLogflute2 = flute2[2];

            var bawah = (document.getElementById('bawah').value).split("|");
            var idbawah = bawah[0]
            var namaMcbawah = bawah[1];
            var namaLogbawah = bawah[2];
                        
            if (flute1 == '') {
                namaMcflute1 = '--';
                namaLogflute1 = '--';
                idflute1 = '';
            }
            if (tengah == '') {
                namaMcTengah = '--';
                namaLogTengah = '--';
                idTengah = '';
            }
            if (flute2 == '') {
                namaMcflute2 = '--';
                namaLogflute2 = '--';
                idflute2 = '';
            }
            if (bawah == '') {
                namaMcbawah = '--';
                namaLogbawah = '--';
                idbawah = '';
            }
            

            document.getElementById("jenisGramLinerAtas_id").value = idAtas;
            document.getElementById("jenisGramFlute1_id").value = idflute1;
            document.getElementById("jenisGramLinerTengah_id").value = idTengah;
            document.getElementById("jenisGramFlute2_id").value = idflute2;
            document.getElementById("jenisGramLinerBawah_id").value = idbawah;
            document.getElementById("namaMc").value = namaMcAtas + '/' + namaMcflute1 + '/' + namaMcTengah + '/' + namaMcflute2 + '/' + namaMcbawah;
            document.getElementById("kode").value = namaMcAtas + '/' + namaMcflute1 + '/' + namaMcTengah + '/' + namaMcflute2 + '/' + namaMcbawah;
            document.getElementById("namaLog").value = namaLogAtas + '/' + namaLogflute1 + '/' + namaLogTengah + '/' + namaLogflute2 + '/' + namaLogbawah;
        }
        // atas.onchange = function() {
            //     var lineratas = atas.options[atas.selectedIndex].getAttribute('name');
            
            //     console.log(lineratas);
            // }
        </script>