
@extends('admin.templates.partials.default')

<!-- Load jQuery first before any other scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css" />

<!-- DataTables and other scripts after jQuery -->
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>

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


{{-- <style>
  td, tr {
    border:1px solid black !important;
  }
</style> --}}

@section('content')
@if ($message = Session::get('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    <strong>{{ $message }}</strong>
  </div>
@endif
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Kontrak</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Kontrak</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="form-group">
        <div class="row">
          <div class="col-md-6">
            {{-- <form action="{{ route('filter') }}" method="get"> --}}
              <select class="js-example-basic-single" name="mesin" id="mesin">
                <option value="" selected disabled>Pilih Mesin</option>
                @foreach ($mesin as $m)
                    <option value="{{ $m->nama }}">{{ $m->nama }}</option>
                @endforeach
              </select>
              <input type="date" name="mulai" id="mulai">
              <input type="date" name="end" id="end">
              <button name="search" id="search"> Search </button>
            {{-- </form> --}}
          </div>
        </div>
      </div>

      <div class="card-body">
        <table class="table table-bordered" id="laporan">
          <thead>
            <tr>
              <th scope="col">Jam Mulai</th>
              <th scope="col">Jam Selesai</th>
              <th scope="col">Hasil Baik (pcs)</th>
              <th scope="col">OPI</th>
              <th scope="col">Mesin</th>
            </tr>
          </thead>
        </table>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
  @endsection

@section('javascripts')
<!-- DataTables -->
<script>
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
    });    $(function(){

      $('#search').click(function() {
        var mesin = document.getElementById("mesin").value;
        var mulai = document.getElementById("mulai").value;
        var end = document.getElementById("end").value;

        console.log(mulai);
        console.log(end);

        if (mulai == '' && end == '') {
          if (mesin) {
              $('#laporan').DataTable({
              "bDestroy": true,
              "searching": false,
              "processing":true,
              "serverSide":true,
              "ajax":{
                "url": "../produksi/filter?mesin="+mesin,
                "dataType": "json",
                "type": "GET",
                "data":{_token: "{{ csrf_token() }}"}
              },
              "columns": [
                {"data": "start_date"},
                {"data": "end_date"},
                {"data": "hasil_baik"},
                {"data": "noOpi"},
                {"data": "mesin"},
                
              ],
              "paging": false,
              dom: 'Bftrip',
              buttons: [
                'excel',
              ],
            });
          } 
        } 
        else {
          if (mesin == '') {
            
            $('#laporan').DataTable({
            "bDestroy": true,
            "searching": false,
            "processing":true,
            "serverSide":true,
            "ajax":{
              "url": "../produksi/filter?mulai="+mulai+"&end="+end,
              "dataType": "json",
              "type": "GET",
              "data":{_token: "{{ csrf_token() }}"}
            },
            "columns": [
              {"data": "start_date"},
              {"data": "end_date"},
              {"data": "hasil_baik"},
              {"data": "noOpi"},
              {"data": "mesin"},
              
            ],
            "paging": false,
              dom: 'Bftrip',
            buttons: [
              'excel',
            ],
          });
          } else {
            
            $('#laporan').DataTable({
            "bDestroy": true,
              "searching": false,
            "processing":true,
            "serverSide":true,
            "ajax":{
              "url": "../produksi/filter?mesin="+mesin+"&mulai="+mulai+"&end="+end,
              "dataType": "json",
              "type": "GET",
              "data":{_token: "{{ csrf_token() }}"}
            },
            "columns": [
              {"data": "start_date"},
              {"data": "end_date"},
              {"data": "hasil_baik"},
              {"data": "noOpi"},
              {"data": "mesin"},
              
            ],
            "paging": false,
              dom: 'Bftrip',
            buttons: [
              'excel',
            ],
          });
          }
        }
      })
    });
  </script>

  @endsection