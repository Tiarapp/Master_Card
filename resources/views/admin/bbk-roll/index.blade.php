@extends('admin.templates.partials.default')

<!-- Select2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css" />

<style>
.label {
  color: white;
}

.status {
  width: auto;
  height: auto;
  margin-top: 20px;
  text-align: center;
  padding: 8px;
  border-radius: 10%;
}

.success {background-color: #04AA6D;} /* Green */
.info {background-color: #2196F3;} /* Blue */
.warning {background-color: #ff9800;} /* Orange */
.danger {background-color: #f44336;} /* Red */
.other {background-color: #e7e7e7; color: black;} /* Gray */

/* Select2 Styling */
.select2-container {
    width: 100% !important;
}

.select2-container--bootstrap4 .select2-selection--single {
    height: 38px !important;
    border: 1px solid #ced4da !important;
    border-radius: 0.25rem !important;
    padding: 0 !important;
}

.select2-container--bootstrap4 .select2-selection__rendered {
    line-height: 36px !important;
    padding-left: 12px !important;
    padding-right: 20px !important;
    color: #495057 !important;
    font-size: 14px !important;
}

.select2-container--bootstrap4 .select2-selection__arrow {
    height: 36px !important;
    right: 10px !important;
    top: 1px !important;
}

.select2-container--bootstrap4 .select2-selection__arrow b {
    border-color: #999 transparent transparent transparent !important;
    border-style: solid !important;
    border-width: 5px 4px 0 4px !important;
    height: 0 !important;
    left: 50% !important;
    margin-left: -4px !important;
    margin-top: -2px !important;
    position: absolute !important;
    top: 50% !important;
    width: 0 !important;
}

.select2-container--bootstrap4.select2-container--open .select2-selection__arrow b {
    border-color: transparent transparent #999 transparent !important;
    border-width: 0 4px 5px 4px !important;
}

.select2-container--bootstrap4 .select2-dropdown {
    border: 1px solid #ced4da !important;
    border-radius: 0.25rem !important;
}

.select2-container--bootstrap4 .select2-search--dropdown .select2-search__field {
    border: 1px solid #ced4da !important;
    border-radius: 0.25rem !important;
    padding: 6px 12px !important;
}

.select2-container--bootstrap4 .select2-results__option {
    padding: 6px 12px !important;
}

.select2-container--bootstrap4 .select2-results__option--highlighted {
    background-color: #007bff !important;
    color: white !important;
}

/* BBK Group Styling */
.badge-light-primary {
    background-color: #e3f2fd;
    color: #1976d2;
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    font-size: 0.75rem;
    font-weight: 500;
}

.bbk-group-first {
    border-top: 3px solid #007bff;
}

.bbk-group-item {
    border-top: 1px solid #e9ecef;
}

.bbk-number-cell {
    position: relative;
    vertical-align: top !important;
}

.bbk-number-group {
    padding: 0.5rem 0;
}

.bbk-number-main {
    font-weight: bold;
    font-size: 1rem;
    color: #007bff;
}

/* Compact action buttons */
.btn-xs {
    padding: 0.125rem 0.375rem;
    font-size: 0.65rem;
    line-height: 1.2;
    border-radius: 0.2rem;
}

.bbk-number-group .btn-xs {
    font-size: 0.6rem;
    padding: 0.1rem 0.3rem;
}

.bbk-number-group .btn-xs i {
    font-size: 0.7rem;
}

@media (max-width: 576px) {
    .bbk-number-group .btn-xs span {
        display: none !important;
    }
    
    .bbk-number-group .btn-xs {
        padding: 0.1rem 0.25rem;
    }
}

.bbk-group-first .bbk-number-cell::after {
    content: '';
    position: absolute;
    left: 0;
    top: 100%;
    bottom: 0;
    width: 3px;
    background-color: #007bff;
    opacity: 0.3;
}

.bbk-group-item td:first-child {
    border-left: 3px solid #007bff;
    opacity: 0.3;
}

.table tr.bbk-group-item:hover {
    background-color: #f8f9fa;
}

.table tr.bbk-group-first:hover {
    background-color: #e3f2fd;
}

.inventory-item {
    padding: 0.75rem;
    border-left: 3px solid #007bff;
    margin-bottom: 0.75rem;
    background-color: #f8f9fa;
    border-radius: 0.375rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.inventory-item:last-child {
    margin-bottom: 0;
}

.inventory-item:hover {
    background-color: #e9ecef;
    transform: translateY(-1px);
    transition: all 0.2s ease;
}

.btn-group-vertical .btn {
    margin-bottom: 0.25rem;
}

.btn-group-vertical .btn:last-child {
    margin-bottom: 0;
}

.table td {
    vertical-align: top;
}

.bbk-details-column {
    max-width: 300px;
}

.action-buttons {
    min-width: 120px;
}
</style>

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">BBK Roll</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">BBK Roll</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
          <strong>{{ $message }}</strong>
        </div>
      @endif

      <!-- Filter Section -->
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
          <h6 class="mb-0"><i class="fas fa-filter me-2"></i>Filter Data</h6>
        </div>
        <div class="card-body">
          <form action="{{ route('bbk-roll.index') }}" method="GET" id="filterForm">
            <div class="row align-items-end">
              <div class="col-md-3">
                <label for="inventory_filter" class="form-label">Filter Inventory</label>
                <select class="form-control" id="inventory_filter" name="inventory_filter">
                  <option value="">Semua Inventory</option>
                  @foreach($inventories as $inventory)
                    <option value="{{ $inventory->id }}" {{ request('inventory_filter') == $inventory->id ? 'selected' : '' }}>
                      {{ $inventory->kode_internal }} - {{ $inventory->kode_roll }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-2">
                <label for="tanggal_from" class="form-label">Tanggal Dari</label>
                <input type="date" class="form-control" id="tanggal_from" name="tanggal_from" value="{{ request('tanggal_from') }}">
              </div>
              <div class="col-md-2">
                <label for="tanggal_to" class="form-label">Tanggal Sampai</label>
                <input type="date" class="form-control" id="tanggal_to" name="tanggal_to" value="{{ request('tanggal_to') }}">
              </div>
              <div class="col-md-5">
                <div class="d-flex gap-2">
                  <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter me-1"></i> Terapkan Filter
                  </button>
                  <a href="{{ route('bbk-roll.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-sync-alt me-1"></i> Reset
                  </a>
                </div>
              </div>
            </div>
            
            <!-- Hidden field to preserve search term when filtering -->
            @if(request('search'))
              <input type="hidden" name="search" value="{{ request('search') }}">
            @endif
          </form>
        </div>
      </div>

      <div class="row mb-4 align-items-center">
        <div class="col-auto d-flex align-items-center gap-3">
          <a href="{{ route('bbk-roll.create') }}" class="btn btn-primary d-flex align-items-center shadow-sm" style="margin-bottom: 20px;">
            <i class="fas fa-plus-circle me-2"></i>
            <span>{{ __('Tambah BBK Roll Baru') }}</span>
          </a>
          
          <!-- Export Button -->
          <button type="button" id="exportBtn" class="btn btn-success d-flex align-items-center shadow-sm" style="margin-bottom: 20px;">
            <i class="fas fa-file-excel me-2"></i>
            <span>{{ __('Export Excel') }}</span>
          </button>
        </div>
        <div class="col text-end">
          <form class="d-flex align-items-center justify-content-end gap-2" action="{{ route('bbk-roll.index') }}" method="GET" style="margin-bottom: 20px;">
            <div class="input-group" style="max-width: 350px;">
              <span class="input-group-text bg-white border-end-0" style="border-radius: 20px 0 0 20px; border-right: none;">
                <i class="fas fa-search text-muted"></i>
              </span>
              <input 
                type="text" 
                class="form-control border-start-0 shadow-none" 
                name="search" 
                placeholder="{{ __('Cari BBK Roll...') }}" 
                value="{{ request('search') }}" 
                style="border-radius: 0 20px 20px 0; border-left: none; min-width: 200px;"
                autocomplete="off"
              >
            </div>
            
            <!-- Hidden fields to preserve filter parameters when searching -->
            @if(request('inventory_filter'))
              <input type="hidden" name="inventory_filter" value="{{ request('inventory_filter') }}">
            @endif
            @if(request('tanggal_from'))
              <input type="hidden" name="tanggal_from" value="{{ request('tanggal_from') }}">
            @endif
            @if(request('tanggal_to'))
              <input type="hidden" name="tanggal_to" value="{{ request('tanggal_to') }}">
            @endif
            
            <button type="submit" class="btn btn-primary px-4 shadow-sm">
              <i class="fas fa-search me-1"></i> {{ __('Cari') }}
            </button>
            <a href="{{ route('bbk-roll.index') }}" class="btn btn-outline-secondary px-4 shadow-sm">
              <i class="fas fa-sync-alt me-1"></i> {{ __('Reset') }}
            </a>
          </form>
        </div>
      </div>

      <div class="table-responsive shadow rounded-3">
        <table class="table align-middle table-row-dashed table-row-bordered gy-5 gs-7 fs-6" style="background-color: #fff;">
            <thead>
                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                    <th class="min-w-125px">{{ __('BBK Number') }}</th>
                    <th class="min-w-125px">{{ __('Tanggal BBK') }}</th>
                    <th class="min-w-150px">{{ __('Kode Internal') }}</th>
                    <th class="min-w-150px">{{ __('Kode Roll') }}</th>
                    <th class="min-w-100px">{{ __('Supplier') }}</th>
                    <th class="min-w-100px">{{ __('Keluar') }}</th>
                    <th class="min-w-100px">{{ __('Kembali') }}</th>
                    <th class="min-w-100px">{{ __('Sisa') }}</th>
                    <th class="min-w-125px">{{ __('OPI') }}</th>
                    <th class="min-w-125px">{{ __('Keterangan') }}</th>
                </tr>
            </thead>
            <tbody class="text-gray-900 fw-semibold">
                @forelse ($bbkRolls as $bbkGroup)
                    @foreach($bbkGroup as $index => $bbkRoll)
                        <tr class="{{ $index == 0 ? 'bbk-group-first' : 'bbk-group-item' }}">
                            <td class="text-gray-800 bold bbk-number-cell">
                                @if($index == 0)
                                    <div class="bbk-number-group">
                                        <span class="bbk-number-main">{{ $bbkRoll->bbk_number }}</span>
                                        <small class="text-muted d-block">{{ $bbkGroup->count() }} items</small>
                                        <div class="d-flex gap-1 mt-2 flex-wrap">
                                            <button type="button" class="btn btn-outline-info btn-xs d-flex align-items-center gap-1" 
                                                    onclick="viewBbkRollDetails('{{ $bbkRoll->bbk_number }}')" title="View Details">
                                                <i class="fas fa-eye"></i>
                                                <span class="d-none d-sm-inline">Detail</span>
                                            </button>
                                            <button type="button" class="btn btn-outline-warning btn-xs d-flex align-items-center gap-1" 
                                                    onclick="editBbkRollGroup('{{ $bbkRoll->bbk_number }}')" title="Edit BBK Roll Group">
                                                <i class="fas fa-edit"></i>
                                                <span class="d-none d-sm-inline">Edit</span>
                                            </button>
                                            <button type="button" class="btn btn-outline-danger btn-xs d-flex align-items-center gap-1" 
                                                    onclick="deleteBbkRollGroup('{{ $bbkRoll->bbk_number }}')" title="Hapus BBK Roll Group">
                                                <i class="fas fa-trash"></i>
                                                <span class="d-none d-sm-inline">Hapus</span>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </td>
                            <td class="text-gray-800 bold">
                                @if($index == 0)
                                    {{ \Carbon\Carbon::parse($bbkRoll->tanggal_bbk)->format('d-m-Y') }}
                                @endif
                            </td>
                            <td class="text-gray-800 fw-semibold">{{ $bbkRoll->inventory->kode_internal ?? '-' }}</td>
                            <td class="text-gray-800 fw-semibold">{{ $bbkRoll->inventory->kode_roll ?? '-' }}</td>
                            <td class="text-gray-800 fw-semibold">{{ $bbkRoll->inventory->supplier->name ?? '-' }}</td>
                            <td class="text-gray-800 fw-semibold">{{ number_format($bbkRoll->keluar) }}</td>
                            <td class="text-gray-800 fw-semibold">{{ number_format($bbkRoll->kembali) }}</td>
                            <td class="text-gray-800 fw-semibold">{{ number_format($bbkRoll->keluar - $bbkRoll->kembali) }}</td>
                            <td class="text-gray-800 fw-semibold">{{ $bbkRoll->opi ?? '-' }}</td>
                            <td class="text-gray-800 fw-semibold">{{ $bbkRoll->keterangan ?? '-' }}</td>
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="11" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <p>Tidak ada data BBK Roll</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
      </div>

      <!-- Pagination -->
      @if($bbkRolls->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-4">
          <div class="text-muted">
            Menampilkan {{ $bbkRolls->firstItem() ?? 0 }} sampai {{ $bbkRolls->lastItem() ?? 0 }} 
            dari {{ $bbkRolls->total() }} data
          </div>
          <div>
            {{ $bbkRolls->appends(request()->query())->links() }}
          </div>
        </div>
      @endif

    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>

@endsection

@section('javascripts')
<!-- Select2 JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        // Initialize Select2 for filter dropdowns
        $('#inventory_filter').select2({
            theme: 'bootstrap4',
            width: '100%',
            allowClear: true,
            placeholder: 'Pilih Inventory...'
        });
    });

    // Export functionality
    document.getElementById('exportBtn').addEventListener('click', function() {
        const btn = this;
        const originalContent = btn.innerHTML;
        
        // Show loading state
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i><span>Mengexport...</span>';
        
        // Get current filter values
        const searchParam = '{{ request("search") }}';
        const inventoryFilter = '{{ request("inventory_filter") }}';
        const tanggalFrom = '{{ request("tanggal_from") }}';
        const tanggalTo = '{{ request("tanggal_to") }}';
        
        // Create form for export
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("bbk-roll.export") }}';
        form.style.display = 'none';
        
        // Add CSRF token
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        form.appendChild(csrfInput);
        
        // Add search parameter
        if (searchParam) {
            const searchInput = document.createElement('input');
            searchInput.type = 'hidden';
            searchInput.name = 'search';
            searchInput.value = searchParam;
            form.appendChild(searchInput);
        }
        
        // Add inventory filter
        if (inventoryFilter) {
            const inventoryInput = document.createElement('input');
            inventoryInput.type = 'hidden';
            inventoryInput.name = 'inventory_filter';
            inventoryInput.value = inventoryFilter;
            form.appendChild(inventoryInput);
        }
        
        // Add date filters
        if (tanggalFrom) {
            const fromInput = document.createElement('input');
            fromInput.type = 'hidden';
            fromInput.name = 'tanggal_from';
            fromInput.value = tanggalFrom;
            form.appendChild(fromInput);
        }
        
        if (tanggalTo) {
            const toInput = document.createElement('input');
            toInput.type = 'hidden';
            toInput.name = 'tanggal_to';
            toInput.value = tanggalTo;
            form.appendChild(toInput);
        }
        
        // Submit form
        document.body.appendChild(form);
        form.submit();
        
        // Restore button state after a delay
        setTimeout(() => {
            btn.disabled = false;
            btn.innerHTML = originalContent;
            document.body.removeChild(form);
        }, 3000);
    });

    function viewBbkRollDetails(bbkNumber) {
        // Create modal or redirect to details page for the BBK group
        window.location.href = '{{ route("bbk-roll.show-group", ":bbkNumber") }}'.replace(':bbkNumber', bbkNumber);
    }

    function editBbkRollGroup(bbkNumber) {
        // Redirect to edit page for BBK group
        window.location.href = '{{ route("bbk-roll.edit-group", ":bbkNumber") }}'.replace(':bbkNumber', bbkNumber);
    }

    function deleteBbkRollGroup(bbkNumber) {
        if (confirm('Apakah Anda yakin ingin menghapus semua BBK Roll dengan nomor ' + bbkNumber + '?')) {
            // Create and submit form for DELETE request
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("bbk-roll.destroy-group", ":bbkNumber") }}'.replace(':bbkNumber', bbkNumber);
            
            // Add CSRF token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            form.appendChild(csrfInput);
            
            // Add DELETE method
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(methodInput);
            
            // Submit form
            document.body.appendChild(form);
            form.submit();
        }
    }

    function editBbkRoll(id) {
        window.location.href = '{{ route("bbk-roll.edit", ":id") }}'.replace(':id', id);
    }
</script>
@endsection
