@extends('admin.templates.partials.default')

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    @if ($message = Session::get('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        <strong>{{ $message }}</strong>
      </div>
    @endif
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">
            <i class="fas fa-file-invoice-dollar mr-2"></i>Vendor Tanda Terima
          </h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Accounting</a></li>
            <li class="breadcrumb-item active">Vendor TT</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      
      <!-- Search Form -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-search mr-2"></i>Filter Data
          </h3>
        </div>
        <form method="GET" action="{{ url()->current() }}">          
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="search">Pencarian</label>
                  <input type="text" class="form-control" id="search" name="search" 
                         placeholder="Cari berdasarkan No TT, BBM No, Invoice, atau PO Number..." 
                         value="{{ request('search') }}">
                  <small class="text-muted">Kosongkan untuk menampilkan semua data</small>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="date_start">Tanggal Mulai</label>
                  <input type="date" class="form-control" id="date_start" name="date_start" 
                         value="{{ request('date_start') }}">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="date_end">Tanggal Akhir</label>
                  <input type="date" class="form-control" id="date_end" name="date_end" 
                         value="{{ request('date_end') }}">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>&nbsp;</label>
                  <div class="d-block">
                    <button type="submit" class="btn btn-primary btn-block">
                      <i class="fas fa-search mr-1"></i>Filter Data
                    </button>
                    <a href="{{ url()->current() }}" class="btn btn-secondary btn-block mt-2">
                      <i class="fas fa-times mr-1"></i>Reset Filter
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>

      <!-- Data Table -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-table mr-2"></i>Data Vendor Tanda Terima
          </h3>            
          <div class="card-tools">
            <button type="button" class="btn btn-warning btn-sm mr-2" data-toggle="modal" data-target="#customFilterModal">
              <i class="fas fa-cog mr-1"></i>Filter Custom
            </button>            
            @if($vendortt->total() > 0)
                <a href="{{ route('acc.vendor_tt.export', array_merge(request()->query(), ['page' => request()->get('page', 1)])) }}" class="btn btn-success mb-3">
                  <i class="fas fa-file-excel mr-1"></i>Export Excel
                </a>
              <span class="badge badge-success">
                Total: {{ number_format($vendortt->total()) }} record
              </span>
            @else
              <span class="badge badge-secondary">
                Tidak ada data
              </span>
            @endif</div>
        </div>

        @if(request()->hasAny(['search', 'date_start', 'date_end', 'periode_manual', 'gudang_filter']))
        <div class="card-body border-bottom bg-light">
          <div class="alert alert-info mb-0">
            <h6><i class="fas fa-info-circle mr-1"></i>Filter Aktif:</h6>
            <div class="row">
              @if(request('search'))
                <div class="col-md-3">
                  <small><strong>Pencarian:</strong> {{ request('search') }}</small>
                </div>
              @endif
              @if(request('date_start') && request('date_end'))
                <div class="col-md-3">
                  <small><strong>Tanggal:</strong> {{ request('date_start') }} s/d {{ request('date_end') }}</small>
                </div>
              @endif
              @if(request('periode_manual'))
                <div class="col-md-3">
                  <small><strong>Periode:</strong> {{ request('periode_manual') }}</small>
                </div>
              @endif
              @if(request('gudang_filter'))
                <div class="col-md-3">
                  <small><strong>Gudang:</strong> {{ request('gudang_filter') }}</small>
                </div>
              @endif
            </div>
          </div>
        </div>
        @endif

        <div class="card-body table-responsive">
          <table class="table table-bordered table-striped" id="vendorTTTable">
            <thead class="bg-primary text-white">
              <tr>
                <th style="width: 5%">No</th>
                <th style="width: 10%">Tanggal TT</th>
                <th style="width: 15%">No TT</th>
                <th style="width: 15%">Invoice Number</th>
                <th style="width: 15%">PO Number</th>
                <th style="width: 15%">Waktu Bayar</th>
                <th style="width: 12%">BBM No</th>
                <th style="width: 13%">Amount</th>
                <th style="width: 13%">BBM Amount</th>
                <th style="width: 7%">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($vendortt as $index => $data)
                  <tr>
                    <td>{{ $vendortt->firstItem() + $index }}</td>
                    <td>
                      @if($data->master_vend && $data->master_vend->Tglterima)
                        {{ \Carbon\Carbon::parse($data->master_vend->Tglterima)->format('d-m-Y') }}
                      @endif
                    </td>                      
                    <td>{{ $data->NoTT }}</td>
                    <td>{{ $data->InvNumber }}</td>
                    <td>{{ $data->PONumber }}</td>
                    <td>
                      @if($data->top)
                        {{ $data->top }} hari
                      @else
                        -
                      @endif
                    </td>
                    <td>{{ $data->BBMNo }}</td>
                    <td class="text-right">{{ number_format($data->Amount, 2) }}</td>
                    <td class="text-right">{{ number_format($data->BBMAmount, 2) }}</td>
                    <td class="text-center">
                      <a href="#" 
                         class="btn btn-info btn-sm" 
                         data-toggle="tooltip" title="Lihat Detail">
                        <i class="fas fa-eye"></i>
                      </a>
                    </td>
                  </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        
        @if($vendortt->hasPages())
        <div class="card-footer">
          <div class="row align-items-center">
            <div class="col-md-6">
              <p class="text-muted mb-0">
                Menampilkan {{ $vendortt->firstItem() }} - {{ $vendortt->lastItem() }} 
                dari {{ $vendortt->total() }} hasil
              </p>
            </div>
            <div class="col-md-6">
              {{ $vendortt->appends(request()->query())->links() }}
            </div>
          </div>
        </div>
        @endif
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->  </section>
  <!-- /.content -->
</div>

<!-- Custom Filter Modal -->
<div class="modal fade" id="customFilterModal" tabindex="-1" role="dialog" aria-labelledby="customFilterModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header bg-warning text-dark">
        <h5 class="modal-title" id="customFilterModalLabel">
          <i class="fas fa-cog mr-2"></i>Filter Custom
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="GET" action="{{ url()->current() }}" id="customFilterForm">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="periode_manual">
                  <i class="fas fa-keyboard mr-1"></i>Periode Manual
                </label>
                <input type="text" class="form-control" id="periode_manual" name="periode_manual" 
                       placeholder="Masukkan periode (contoh: 09-2020, 09/20)" 
                       value="{{ request('periode_manual') }}">
                <small class="text-muted">Format: MM-YYYY, MM/YY</small>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="gudang_filter">
                  <i class="fas fa-warehouse mr-1"></i>Pilihan Gudang
                </label>
                <select class="form-control" id="gudang_filter" name="gudang_filter">
                  <option value="">-- Semua Gudang --</option>
                  <option value="Teknik" {{ request('gudang_filter') == 'Teknik' ? 'selected' : '' }}>Teknik - Gudang Utama</option>
                  <option value="BP" {{ request('gudang_filter') == 'BP' ? 'selected' : '' }}>BP - Gudang Jakarta</option>
                  <option value="Stationary" {{ request('gudang_filter') == 'Stationary' ? 'selected' : '' }}>Stationary - Gudang Surabaya</option>
                </select>
                <small class="text-muted">Pilih gudang untuk filter data</small>
              </div>
            </div>
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <i class="fas fa-times mr-1"></i>Tutup
          </button>
          <button type="button" class="btn btn-danger" id="resetCustomFilter">
            <i class="fas fa-eraser mr-1"></i>Hapus Filter
          </button>
          <button type="submit" class="btn btn-warning">
            <i class="fas fa-filter mr-1"></i>Terapkan Filter
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('javascripts')
<!-- DataTables -->
<script>
$(document).ready(function() {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
      // Auto-focus search input if there's a search term
    @if(request('search'))
        $('#search').focus();
    @endif
      // Clear periode when manual dates are entered
    $('#date_start, #date_end').change(function() {
        if ($('#date_start').val() !== '' || $('#date_end').val() !== '') {
            $('#periode').val('');
        }
    });
      // Handle reset custom filter
    $('#resetCustomFilter').click(function() {
        $('#periode_manual').val('');
        $('#gudang_filter').val('');
    });
      // Handle export Excel
    $('#exportExcel').click(function() {
        var btn = $(this);
        var originalText = btn.html();
        
        // Show loading state
        btn.prop('disabled', true);
        btn.html('<i class="fas fa-spinner fa-spin mr-1"></i>Exporting...');
        
        // Build export URL with current filters
        var currentUrl = new URL(window.location.href);
        var exportUrl = new URL('{{ route("acc.vendor_tt.export") }}');
        
        // Copy all current query parameters to export URL
        currentUrl.searchParams.forEach(function(value, key) {
            exportUrl.searchParams.set(key, value);
        });
        
        // Add export parameter
        exportUrl.searchParams.set('export', 'excel');
        
        // Create temporary link for download
        var link = document.createElement('a');
        link.href = exportUrl.toString();
        link.download = 'vendor_tanda_terima_' + new Date().toISOString().slice(0,10) + '.xlsx';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        // Reset button after delay
        setTimeout(function() {
            btn.prop('disabled', false);
            btn.html(originalText);
            
            // Show success notification
            toastr.success('Export berhasil dimulai!', 'Success');
        }, 2000);
    });
    
    // Add validation for periode manual format
    $('#periode_manual').on('input', function() {
        var value = $(this).val();
        var isValid = true;
        var message = '';
        
        if (value.length > 0) {
            // Check for YYYYMM format (6 digits)
            if (/^\d{6}$/.test(value)) {
                message = 'Format: YYYYMM (contoh: 202409)';
            }
            // Check for YYYY-MM format
            else if (/^\d{4}-\d{2}$/.test(value)) {
                message = 'Format: YYYY-MM (contoh: 2024-09)';
            }
            // Free text format
            else {
                message = 'Format bebas diterima';
            }
        } else {
            message = 'Format: YYYYMM, YYYY-MM, atau teks bebas';
        }
        
        $(this).siblings('small').text(message);
    });
    
    // Add hover effects to table rows
    $('.table tbody tr').hover(
        function() {
            $(this).addClass('table-active');
        },
        function() {
            $(this).removeClass('table-active');
        }
    );
    
    // Handle modal display properly
    $('.modal').on('show.bs.modal', function() {
        var modal = $(this);
        
        // Ensure proper z-index
        modal.css('z-index', 1055);
        
        // Adjust modal body height
        modal.find('.modal-body').css({
            'max-height': '70vh',
            'overflow-y': 'auto'
        });
        
        // Remove any existing backdrop issues
        $('.modal-backdrop').css('z-index', 1045);
    });
    
    // Handle modal hide
    $('.modal').on('hidden.bs.modal', function() {
        // Ensure no leftover backdrop
        if ($('.modal:visible').length === 0) {
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open');
        }
    });
    
    // Format currency in real-time if needed
    $('.currency-format').each(function() {
        var value = $(this).text();
        if (value && !isNaN(value)) {
            $(this).text('Rp ' + Number(value).toLocaleString('id-ID'));
        }
    });
    
    // Fix any modal backdrop issues on page load
    if ($('.modal-backdrop').length > 0 && $('.modal:visible').length === 0) {
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');
    }
});
</script>

<style>
/* Custom styles for better appearance */
.table tbody tr:hover {
    background-color: rgba(0,123,255,.075) !important;
    cursor: pointer;
}

.badge {
    font-size: 0.85em;
    padding: 0.375rem 0.75rem;
}

.modal-body h6 {
    border-bottom: 2px solid #dee2e6;
    padding-bottom: 0.5rem;
    margin-bottom: 1rem;
}

.table-sm th {
    font-weight: 600;
    color: #495057;
}

.text-success {
    font-weight: 600;
}

.text-info {
    font-weight: 600;
}

/* Modal z-index fixes */
.modal {
    z-index: 1050 !important;
}

.modal-backdrop {
    z-index: 1040 !important;
}

.modal-dialog {
    z-index: 1060 !important;
}

/* Ensure modal appears correctly */
.modal.fade .modal-dialog {
    transform: translate(0, -50px);
    transition: transform 0.3s ease-out;
}

.modal.show .modal-dialog {
    transform: none;
}

/* Responsive improvements */
@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.85rem;
    }
    
    .badge {
        font-size: 0.75em;
        padding: 0.25rem 0.5rem;
    }
    
    .modal-dialog {
        margin: 0.5rem;
        max-width: calc(100% - 1rem);
    }
    
    .modal-body {
        padding: 1rem 0.75rem;
    }
}

/* Loading state */
.loading {
    opacity: 0.6;
    pointer-events: none;
}

/* Empty state styling */
.text-muted i.fa-inbox {
    color: #6c757d;
    opacity: 0.5;
}

/* Fix for AdminLTE sidebar overlap */
.content-wrapper .modal {
    z-index: 1055 !important;
}

.content-wrapper .modal-backdrop {
    z-index: 1045 !important;
}

/* Ensure modal is positioned correctly */
.modal.show {
    display: block !important;
    padding-right: 0 !important;
}

.modal-open {
    overflow: hidden;
}

/* Fix body scroll when modal is open */
body.modal-open {
    padding-right: 0 !important;
    overflow: hidden;
}

/* AdminLTE specific fixes */
.wrapper .modal {
    z-index: 1055 !important;
}

.main-sidebar {
    z-index: 1010 !important;
}

.navbar {
    z-index: 1020 !important;
}
</style>
@endsection