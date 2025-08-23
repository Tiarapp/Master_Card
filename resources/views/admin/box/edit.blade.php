@extends('admin.templates.partials.default')

<!-- Load jQuery first before any other scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css" />

<!-- DataTables CSS for modal -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" />

<!-- DataTables JS after jQuery -->
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

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
                <h4 class="modal-title">Tambah Box</h4>
                <hr>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Error!</strong> 
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                <form action="{{ route('box.update', $box->id) }}" method="POST" class="inputSheet">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="row was-validated">
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Auto Generated">
                            <div class="form-group">
                                
                                <label>Nama Item</label>
                                {{-- <textarea name="nama" id="nama" cols="30" rows="10"></textarea> --}}
                                <div class="row">
                                    <div class="col-md-10">
                                        <input type="text" class="form-control txt_line" name="namaBarang" id="namaBarang" value="{{ $box->namaBarang }}">
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Pilih Tipe Box">
                            <div class="form-group">
                                <label>Tipe Box</label>
                                <select class="js-example-basic-single col-md-12" name="tipebox" id="tipebox" onchange="getTipe()">
                                    <option value="{{ $box->tipebox }}">{{ $box->tipebox }}</option>
                                    @foreach ($tipebox as $data)
                                    <option value="{{ $data->kode }}">{{ $data->kode }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input Flute">
                            <div class="form-group">
                                <label>Flute</label>
                                <select class="js-example-basic-single col-md-12" name="flute" id="flute" onchange="update_crease_corr()">
                                    <option value="{{ $box->flute }}">{{ $box->flute }}</option>
                                    @foreach ($flute as $data)
                                    <option value="{{ $data->kode }}">{{ $data->kode }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Pilih Tipe Crease Corr">
                            <div class="form-group">
                                <label>Tipe Crease Corr</label>
                                <select class="js-example-basic-single col-md-12" name="tipeCreasCorr" id="tipeCreasCorr">
                                    <option value="{{ $box->tipeCreasCorr }}">{{ $box->tipeCreasCorr }}</option>
                                    <option value="MALE-FLAT">MALE-FLAT</option>
                                    <option value="MALE-MALE">MALE-MALE</option>
                                    <option value="MALE-FEMALE">MALE-FEMALE</option>
                                    <option value="TANPA CREASE">TANPA CREASE</option>
                                </select>
                            </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Masukkan panjang dalam box (mm)">
                            <div class="form-group">
                                <label>Panjang Dalam Box</label>
                                <input type="text" class="form-control txt_line" placeholder="" name="panjangDalamBox" id="panjangDalamBox" value="{{ $box->panjangDalamBox }}" onkeyup="update_crease_corr(); getNama();" required>
                                <div class="valid-feedback">Terima kasih</div>
                                <div class="invalid-feedback">Masukkan panjang dalam box (mm)</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Masukkan lebar dalam box (mm)">
                            <div class="form-group">
                                <label>Lebar Dalam Box</label>
                                <input type="text" class="form-control txt_line" placeholder="" name="lebarDalamBox" id="lebarDalamBox" value="{{ $box->lebarDalamBox }}" onkeyup="update_crease_corr(); getNama();" required>
                                <div class="valid-feedback">Terima kasih</div>
                                <div class="invalid-feedback">Masukkan lebar dalam box (mm)</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Masukkan tinggi dalam box (mm)">
                            <div class="form-group">
                                <label>Tinggi Dalam Box</label>
                                <input type="text" class="form-control txt_line" placeholder="" name="tinggiDalamBox" id="tinggiDalamBox" value="{{ $box->tinggiDalamBox }}" onkeyup="update_crease_corr(); getNama();" required>
                                <div class="valid-feedback">Terima kasih</div>
                                <div class="invalid-feedback">Masukkan tinggi dalam box (mm)</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Masukkan tinggi dalam box (mm)">
                            <div class="form-group">
                                <label>Kondisi Tambahan</label>
                                <input type="text" class="form-control txt_line" placeholder="" name="kuping2" id="kuping2" value="{{ $box->kuping2 }}" onkeyup="update_crease_corr(); getNama();">
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="">
                            <div class="form-group">
                                <label>Creas Corr</label>
                                <input type="hidden" name="flapCrease" id="flapCrease" value="{{ $box->flapCrease }}">
                                <input type="hidden" name="tinggiCrease" id="tinggiCrease" value="{{ $box->tinggiCrease }}">
                                <input type="text" class="form-control txt_line" placeholder="" name="sizeCreasCorr" id="sizeCreasCorr" value="{{ $box->sizeCreasCorr }}" onchange="getNama();" readonly>
                                <div class="valid-feedback">Terima kasih</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="">
                            <div class="form-group">
                                <label>Creas Conv</label>
                                <input type="hidden" name="kuping" id="kuping" value="{{ $box->kuping }}">
                                <input type="hidden" name="panjangCrease" id="panjangCrease" value="{{ $box->panjangCrease }}">
                                <input type="hidden" name="lebarCrease1" id="lebarCrease1" value="{{ $box->lebarCrease1 }}">
                                <input type="hidden" name="lebarCrease2" id="lebarCrease2" value="{{ $box->lebarCrease2 }}">
                                <input type="text" class="form-control txt_line" placeholder="" name="sizeCreasConv" id="sizeCreasConv" value="{{ $box->sizeCreasConv }}" onchange="getNama();" readonly>
                                <div class="valid-feedback">Terima kasih</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
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
            
            // Initialize DataTable
            initializeDataTable();
            
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

        function initializeDataTable() {
            console.log('Initializing DataTable...');
            
            // Initialize DataTable for modal
            if (typeof $.fn.DataTable !== 'undefined') {
                try {
                    var table = $("#data_barang").DataTable({
                        select: true,
                    });
                    
                    $('#data_barang tbody').on('click', 'td', function () {
                        var item = (table.row(this).data());
                        
                        if (item && item.length > 1) {
                            document.getElementById('namaBarang').value = item[1];
                        }
                    });
                    
                    console.log('✓ DataTable initialized successfully');
                } catch (error) {
                    console.error('Error initializing DataTable:', error);
                }
            } else {
                console.warn('DataTable plugin not available');
            }
        }

        // Reinitialize Select2 after any dynamic content changes
        function reinitializeSelect2() {
            console.log('Reinitializing Select2...');
            initializeSelect2();
        }

        // Add event listeners for select changes to maintain functionality
        $(document).on('select2:select', '#tipebox', function (e) {
            console.log('Tipebox selection changed');
            if (typeof getTipe === 'function') {
                getTipe();
            }
        });

        $(document).on('select2:select', '#flute', function (e) {
            console.log('Flute selection changed');
            if (typeof update_crease_corr === 'function') {
                update_crease_corr();
            }
        });

        $(document).on('select2:select', '#tipeCreasCorr', function (e) {
            console.log('TipeCreasCorr selection changed');
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
    });        function luas(){
            var panjang = document.getElementById("panjangSheetBox").value;
            var lebar = document.getElementById("lebarSheetBox").value;
            // var kode = document.getElementById('kode').value;
            var luas;
            luas = panjang * lebar * tinggi;
            
            document.getElementById("luasSheetBox").value =  luas;
        }
        
        function getNama(){
            var kode = document.getElementById('namaBarang').value;
            tipe = getTipe();
            
            // var panjangbox = document.getElementById("panjangSheetBox").value;
            // var lebarbox = document.getElementById("lebarSheetBox").value;
            // var tinggibox = document.getElementById("tinggiSheetBox").value;
            // var luasbox = document.getElementById("luasSheetBox").value;
            
            var panjangdalam = document.getElementById("panjangDalamBox").value;
            var lebardalam = document.getElementById("lebarDalamBox").value;
            var tinggidalam = document.getElementById("tinggiDalamBox").value;
            
            var CreaseCorr = document.getElementById("sizeCreasCorr").value;
            var CreaseConv = document.getElementById("sizeCreasConv").value;
            
            // if (tipe == 'B1') {
            //     // document.getElementById("kode").value = panjangdalam+'x'+lebardalam+'x'+tinggidalam+' MM'+"\n"+CreaseCorr+"\n"+CreaseConv;
            //     document.getElementById("kode").value = kode;
            // }
            // if (tipe == 'DC') {
            //     // document.getElementById("kode").value = panjangdalam+'x'+lebardalam+'x'+tinggidalam+' MM';  
            //     document.getElementById("kode").value = kode;
            // }
            
        }
        
        function getTipe(){
            var tipe = document.getElementById('tipebox').value;
            
            
            if (tipe == 'B1' || tipe == 'B3') {
                document.getElementById('sizeCreasCorr').disabled = false;
                document.getElementById('sizeCreasConv').disabled = false;
            } else {
                document.getElementById('sizeCreasCorr').disabled = true;
                document.getElementById('sizeCreasConv').disabled = true;
            }
            
            return tipe;
        }
        
        function update_crease_corr() {
            var tipe = document.getElementById("tipebox").value;
            
            var box_p = document.getElementById("panjangDalamBox").value;
            var box_l = document.getElementById("lebarDalamBox").value;
            var box_t = document.getElementById("tinggiDalamBox").value;
            var add_condition = document.getElementById("kuping2").value;
            var flute = document.getElementById("flute").value;
            var crease_p, crease_l, kuping, flap, p1, l1, l2, tinggi, sheet_p, sheet_l;
            var flap_trim, tinggi_trim, p1_trim, l1_trim, l2_trim;
            
            if (tipe == "B1") {
                if (flute == "BF"){
                    flap_trim = 2;
                    tinggi_trim = 5;
                    p1_trim = 3;
                    l1_trim = 3;
                    l2_trim = 0;
                    kuping = 30;
                }
                if (flute == "CF"){
                    flap_trim = 3;
                    tinggi_trim = 7;
                    p1_trim = 4;
                    l1_trim = 4;
                    l2_trim = 2;
                    kuping = 30;
                }
                if (flute == "BCF"){
                    flap_trim = 5;
                    tinggi_trim = 13;
                    p1_trim = 6;
                    l1_trim = 6;
                    l2_trim = 4;
                    kuping = 35;
                }
                flap =  ((box_l / 2) + flap_trim);
                tinggi = ((box_t*1) + tinggi_trim);
                sheet_l = (flap*2) + tinggi ;
                crease_p = flap+' - '+tinggi+' - '+flap+' = '+sheet_l+' MM';
                
                p1 = ((box_p*1) + p1_trim);
                l1 = ((box_l*1) + l1_trim);
                l2 = ((box_l*1) + l2_trim);
                sheet_p = (p1*2) + l1 + l2 + kuping - add_condition;
                crease_l = kuping +' - '+ p1 + ' - ' + l1 + ' - ' + p1 + ' - ' + l2 +' - '+ add_condition +' = ' + sheet_p + ' MM';
                
                //CreaseCorr
                document.getElementById("sizeCreasCorr").value = crease_p;
                document.getElementById("kuping").value = kuping;
                document.getElementById("panjangCrease").value = p1;
                document.getElementById("lebarCrease1").value = l1;
                document.getElementById("lebarCrease2").value = l2;

                //CreaseConv
                document.getElementById("sizeCreasConv").value = crease_l;
                document.getElementById("flapCrease").value = flap;
                document.getElementById("tinggiCrease").value = tinggi;
                
            } 
            
        }
    </script>