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

.table th {
    background-color: #f8f9fa;
    font-weight: 600;
    border-bottom: 2px solid #dee2e6;
}

.form-control-sm {
    height: calc(1.5em + 0.5rem + 2px);
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    border-radius: 0.2rem;
}

#bbk_number_preview {
    font-weight: bold;
    color: #5a5c69;
    font-size: 16px;
    background-color: #f8f9fc;
    padding: 10px 15px;
    border-radius: 0.375rem;
    border: 1px solid #d1d3e2;
}

.keluar-input.is-invalid {
    border-color: #dc3545;
}

#selectedInventoryTable .btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}

#selectedInventoryTable td {
    vertical-align: middle;
}

.form-control-sm.keluar-input {
    font-size: 0.75rem;
}

/* Table input styling */
#selectedInventoryTable .form-control-sm {
    font-size: 0.75rem;
    padding: 0.25rem 0.4rem;
}

#selectedInventoryTable textarea.form-control-sm {
    resize: vertical;
    min-height: 60px;
}

#selectedInventoryTable td {
    padding: 0.5rem 0.25rem;
    vertical-align: top;
}

#selectedInventoryTable input[type="text"],
#selectedInventoryTable input[type="number"],
#selectedInventoryTable textarea {
    width: 100%;
}

#selectedInventoryTable .btn-sm {
    padding: 0.25rem 0.4rem;
    font-size: 0.7rem;
}

/* Modal Styling */
.modal-xl {
    max-width: 90%;
}

#inventoryTable thead {
    background-color: #f8f9fa;
}

#inventoryTable thead th {
    position: sticky;
    top: 0;
    z-index: 10;
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
}

.inventory-row-selected {
    background-color: #d4edda !important;
}

.inventory-row-selected .add-inventory-btn {
    background-color: #28a745;
    border-color: #28a745;
}

.inventory-row-selected .add-inventory-btn:hover {
    background-color: #218838;
    border-color: #1e7e34;
}

.badge {
    font-size: 0.75em;
}

.sticky-top {
    position: sticky;
    top: 0;
    z-index: 1020;
}

#inventorySearch:focus,
#supplierFilter:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.modal-body {
    padding: 1.5rem;
}

.input-group-text {
    background-color: #f8f9fa;
    border-color: #ced4da;
}

#selected_inventory_count {
    min-height: 20px;
}

.btn-outline-primary:hover {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
}

.modal-header {
    border-bottom: 1px solid #dee2e6;
}

.modal-footer {
    border-top: 1px solid #dee2e6;
}
</style>

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Tambah BBK Roll Baru</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('bbk-roll.index') }}">BBK Roll</a></li>
            <li class="breadcrumb-item active">Create</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('bbk-roll.store') }}" method="POST" id="bbkRollForm">
        @csrf
        
        <!-- Header Section -->
        <div class="card shadow-sm mb-4">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi BBK Roll</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <!-- BBK Number Preview -->
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label">BBK Number</label>
                  <div id="bbk_number_preview">Akan digenerate otomatis setelah tanggal dipilih</div>
                  <small class="text-muted">Nomor BBK akan digenerate otomatis berdasarkan tanggal BBK</small>
                  <input type="hidden" name="bbk_number" id="bbk_number">
                </div>
              </div>

              <!-- Tanggal BBK -->
              <div class="col-md-4">
                <div class="form-group">
                  <label for="tanggal_bbk">Tanggal BBK <span class="text-danger">*</span></label>
                  <input type="date" 
                         class="form-control @error('tanggal_bbk') is-invalid @enderror" 
                         id="tanggal_bbk" 
                         name="tanggal_bbk" 
                         value="{{ old('tanggal_bbk', date('Y-m-d')) }}" 
                         required>
                  @error('tanggal_bbk')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <!-- Inventory Selection Button -->
              <div class="col-md-4">
                <div class="form-group">
                  <label>Pilih Inventory <span class="text-danger">*</span></label>
                  <div class="d-flex align-items-center">
                    <button type="button" class="btn btn-outline-primary btn-block" data-toggle="modal" data-target="#inventoryModal">
                      <i class="fas fa-plus me-2"></i>Pilih Inventory
                    </button>
                  </div>
                  <div id="selected_inventory_count" class="mt-2">
                    <small class="text-muted">0 inventory terpilih</small>
                  </div>
                  @error('inventory_id')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Inventory Details Section -->
        <div class="card shadow-sm mb-4" id="inventory_details_card" style="display: none;">
          <div class="card-header bg-info text-white">
            <h5 class="mb-0"><i class="fas fa-warehouse me-2"></i>Detail Inventory Terpilih</h5>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-sm" id="selectedInventoryTable">
                <thead>
                  <tr>
                    <th width="10%" class="text-black">Kode Internal</th>
                    <th width="10%" class="text-black">Kode Roll</th>
                    <th width="10%" class="text-black">Supplier</th>
                    <th width="8%" class="text-black">GSM</th>
                    <th width="8%" class="text-black">Lebar</th>
                    <th width="8%" class="text-black">Quantity</th>
                    <th width="10%" class="text-black">Keluar</th>
                    <th width="12%" class="text-black">OPI</th>
                    <th width="17%" class="text-black">Keterangan</th>
                    <th width="7%" class="text-black">Action</th>
                  </tr>
                </thead>
                <tbody id="selectedInventoryBody">
                  <!-- Selected inventories will appear here -->
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Submit Section -->
        <div class="mt-4 text-right">
          <a href="{{ route('bbk-roll.index') }}" class="btn btn-secondary mr-2">
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Simpan BBK Roll
          </button>
        </div>
      </form>

      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>

<!-- Inventory Selection Modal -->
<div class="modal fade" id="inventoryModal" tabindex="-1" role="dialog" aria-labelledby="inventoryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="inventoryModalLabel">
          <i class="fas fa-warehouse me-2"></i>Pilih Inventory
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Search Filter -->
        <div class="row mb-3">
          <div class="col-md-4">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
              </div>
              <input type="text" class="form-control" id="inventorySearch" placeholder="Cari inventory...">
            </div>
          </div>
          <div class="col-md-4">
            <select class="form-control" id="supplierFilter">
              <option value="">Semua Supplier</option>
              <!-- Options will be loaded via AJAX -->
            </select>
          </div>
          <div class="col-md-4">
            <button type="button" class="btn btn-secondary" id="clearFilters">
              <i class="fas fa-times"></i> Clear Filters
            </button>
          </div>
        </div>
        
        <!-- Inventory Table -->
        <!-- Note: Inventory akan di-load via AJAX dengan pagination -->
        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
          <table class="table table-bordered table-sm table-striped" id="inventoryTable">
            <thead class="sticky-top">
              <tr>
                <th width="15%" class="text-black">Kode Internal</th>
                <th width="15%" class="text-black">Kode Roll</th>
                <th width="20%" class="text-black">Supplier</th>
                <th width="20%" class="text-black">Jenis</th>
                <th width="10%" class="text-black">GSM</th>
                <th width="10%" class="text-black">Lebar</th>
                <th width="10%" class="text-black">Quantity</th>
                <th width="10%" class="text-black">Status</th>
                <th width="10%" class="text-black">Action</th>
              </tr>
            </thead>
            <tbody id="inventoryTableBody">
              <tr>
                <td colspan="9" class="text-center">
                  <div class="spinner-border spinner-border-sm" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                  <span class="ml-2">Loading inventory...</span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        
        <!-- Pagination Controls -->
        <div class="d-flex justify-content-between align-items-center mt-3">
          <div>
            <small class="text-muted" id="inventoryInfo">Loading...</small>
          </div>
          <nav aria-label="Inventory pagination">
            <ul class="pagination pagination-sm mb-0" id="inventoryPagination">
              <!-- Pagination links will be loaded here -->
            </ul>
          </nav>
        </div>
        
        <!-- Selected Count -->
        <div class="mt-3">
          <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            <span id="modalSelectedCount">0</span> inventory terpilih
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <i class="fas fa-times"></i> Tutup
        </button>
        <button type="button" class="btn btn-success" id="confirmSelection">
          <i class="fas fa-check"></i> Konfirmasi Pilihan
        </button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('javascripts')
<!-- Select2 JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    // Global variables
    let selectedInventories = [];
    let currentPage = 1;
    let lastPage = 1;
    let isLoading = false;
    
    // Function to load inventory with pagination
    function loadInventory(page = 1, search = '', supplier = '') {
        if (isLoading) return;
        
        isLoading = true;
        currentPage = page;
        
        // Show loading state
        if (page === 1) {
            $('#inventoryTableBody').html(`
                <tr>
                    <td colspan="9" class="text-center">
                        <div class="spinner-border spinner-border-sm" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <span class="ml-2">Loading inventory...</span>
                    </td>
                </tr>
            `);
        }
        
        $.ajax({
            url: '{{ route("inventory.paginated") }}',
            method: 'GET',
            data: {
                page: page,
                search: search,
                supplier: supplier,
                per_page: 20
            },
            success: function(response) {
                if (response.success) {
                    renderInventoryTable(response.data);
                    updatePaginationInfo(response.pagination);
                    renderPagination(response.pagination);
                    
                    // Load suppliers for filter on first load
                    if (page === 1 && !search && !supplier) {
                        loadSuppliers(response.suppliers);
                    }
                }
            },
            error: function(xhr) {
                console.error('Error loading inventory:', xhr);
                $('#inventoryTableBody').html(`
                    <tr>
                        <td colspan="9" class="text-center text-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                            Error loading inventory. Please try again.
                        </td>
                    </tr>
                `);
            },
            complete: function() {
                isLoading = false;
            }
        });
    }
    
    function renderInventoryTable(inventories) {
        const tbody = $('#inventoryTableBody');
        tbody.empty();
        
        if (inventories.length === 0) {
            tbody.html(`
                <tr>
                    <td colspan="9" class="text-center text-muted">
                        <i class="fas fa-info-circle"></i>
                        Tidak ada inventory yang ditemukan
                    </td>
                </tr>
            `);
            return;
        }
        
        inventories.forEach(function(inventory) {
            const row = `
                <tr data-inventory-id="${inventory.id}" 
                    data-kode-internal="${inventory.kode_internal}"
                    data-kode-roll="${inventory.kode_roll}"
                    data-supplier="${inventory.supplier_name || ''}"
                    data-gsm="${inventory.gsm}"
                    data-lebar="${inventory.lebar}"
                    data-quantity="${inventory.quantity || 0}">
                    <td>${inventory.kode_internal}</td>
                    <td>${inventory.kode_roll}</td>
                    <td>${inventory.supplier_name || '-'}</td>
                    <td>${inventory.jenis}</td>
                    <td>${inventory.gsm}</td>
                    <td>${inventory.lebar}</td>
                    <td>${inventory.quantity || 0}</td>
                    <td>
                        <span class="badge badge-success">Available</span>
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm add-inventory-btn" 
                                data-inventory-id="${inventory.id}">
                            <i class="fas fa-plus"></i> Add
                        </button>
                    </td>
                </tr>
            `;
            tbody.append(row);
        });
        
        // Update visual indicators for selected items
        updateModalInventoryRows();
    }
    
    function updatePaginationInfo(pagination) {
        const info = `Showing ${pagination.from || 0} to ${pagination.to || 0} of ${pagination.total} entries`;
        $('#inventoryInfo').text(info);
        lastPage = pagination.last_page;
    }
    
    function renderPagination(pagination) {
        const paginationEl = $('#inventoryPagination');
        paginationEl.empty();
        
        if (pagination.last_page <= 1) return;
        
        // Previous button
        const prevDisabled = pagination.current_page <= 1 ? 'disabled' : '';
        paginationEl.append(`
            <li class="page-item ${prevDisabled}">
                <a class="page-link" href="#" data-page="${pagination.current_page - 1}">
                    <i class="fas fa-chevron-left"></i>
                </a>
            </li>
        `);
        
        // Page numbers
        const startPage = Math.max(1, pagination.current_page - 2);
        const endPage = Math.min(pagination.last_page, pagination.current_page + 2);
        
        if (startPage > 1) {
            paginationEl.append(`<li class="page-item"><a class="page-link" href="#" data-page="1">1</a></li>`);
            if (startPage > 2) {
                paginationEl.append(`<li class="page-item disabled"><span class="page-link">...</span></li>`);
            }
        }
        
        for (let i = startPage; i <= endPage; i++) {
            const active = i === pagination.current_page ? 'active' : '';
            paginationEl.append(`
                <li class="page-item ${active}">
                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                </li>
            `);
        }
        
        if (endPage < pagination.last_page) {
            if (endPage < pagination.last_page - 1) {
                paginationEl.append(`<li class="page-item disabled"><span class="page-link">...</span></li>`);
            }
            paginationEl.append(`<li class="page-item"><a class="page-link" href="#" data-page="${pagination.last_page}">${pagination.last_page}</a></li>`);
        }
        
        // Next button
        const nextDisabled = pagination.current_page >= pagination.last_page ? 'disabled' : '';
        paginationEl.append(`
            <li class="page-item ${nextDisabled}">
                <a class="page-link" href="#" data-page="${pagination.current_page + 1}">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </li>
        `);
    }
    
    function loadSuppliers(suppliers) {
        const select = $('#supplierFilter');
        select.find('option:not(:first)').remove();
        
        suppliers.forEach(function(supplier) {
            select.append(`<option value="${supplier.name}">${supplier.name}</option>`);
        });
    }
    
    // Pagination click handler
    $(document).on('click', '#inventoryPagination .page-link', function(e) {
        e.preventDefault();
        const page = $(this).data('page');
        if (page && page !== currentPage && !isLoading) {
            const search = $('#inventorySearch').val();
            const supplier = $('#supplierFilter').val();
            loadInventory(page, search, supplier);
        }
    });
    
    // Function to generate BBK number
    function generateBbkNumber() {
        const tanggal = $('#tanggal_bbk').val();
        if (tanggal) {
            $.ajax({
                url: '{{ route("bbk-roll.generate-number") }}',
                method: 'GET',
                data: { tanggal: tanggal },
                success: function(response) {
                    if (response.success) {
                        $('#bbk_number_preview').text(response.bbk_number);
                        $('#bbk_number').val(response.bbk_number);
                    }
                },
                error: function() {
                    $('#bbk_number_preview').text('Error generating BBK number');
                }
            });
        } else {
            $('#bbk_number_preview').text('Akan digenerate otomatis setelah tanggal dipilih');
        }
    }

    // Generate BBK number when date changes
    $('#tanggal_bbk').on('change', function() {
        generateBbkNumber();
    });

    // Generate BBK number on page load if date is already set
    generateBbkNumber();

    // Modal Inventory Selection Functions
    function updateSelectedCount() {
        const count = selectedInventories.length;
        $('#selected_inventory_count').html(`<small class="text-muted">${count} inventory terpilih</small>`);
        $('#modalSelectedCount').text(count);
        
        // Update visual indicators in modal
        updateModalInventoryRows();
    }

    function updateModalInventoryRows() {
        $('#inventoryTableBody tr').each(function() {
            const inventoryId = $(this).data('inventory-id');
            const isSelected = selectedInventories.some(inv => inv.id == inventoryId);
            
            if (isSelected) {
                $(this).addClass('inventory-row-selected');
                $(this).find('.add-inventory-btn')
                    .removeClass('btn-primary')
                    .addClass('btn-success')
                    .html('<i class="fas fa-check"></i> Added');
            } else {
                $(this).removeClass('inventory-row-selected');
                $(this).find('.add-inventory-btn')
                    .removeClass('btn-success')
                    .addClass('btn-primary')
                    .html('<i class="fas fa-plus"></i> Add');
            }
        });
    }

    // Add inventory to selection
    $(document).on('click', '.add-inventory-btn', function() {
        const row = $(this).closest('tr');
        const inventoryId = row.data('inventory-id');
        
        // Check if already selected
        const existingIndex = selectedInventories.findIndex(inv => inv.id == inventoryId);
        
        if (existingIndex === -1) {
            // Add to selection
            const inventoryData = {
                id: inventoryId,
                kode_internal: row.data('kode-internal'),
                kode_roll: row.data('kode-roll'),
                supplier: row.data('supplier'),
                gsm: row.data('gsm'),
                lebar: row.data('lebar'),
                quantity: row.data('quantity')
            };
            
            selectedInventories.push(inventoryData);
        } else {
            // Remove from selection
            selectedInventories.splice(existingIndex, 1);
        }
        
        updateSelectedCount();
    });

    // Modal search functionality with debouncing
    let searchTimeout;
    $('#inventorySearch').on('keyup', function() {
        clearTimeout(searchTimeout);
        const searchTerm = $(this).val();
        
        searchTimeout = setTimeout(function() {
            const supplier = $('#supplierFilter').val();
            loadInventory(1, searchTerm, supplier);
        }, 500); // Debounce 500ms
    });

    $('#supplierFilter').on('change', function() {
        const supplier = $(this).val();
        const search = $('#inventorySearch').val();
        loadInventory(1, search, supplier);
    });

    $('#clearFilters').on('click', function() {
        $('#inventorySearch').val('');
        $('#supplierFilter').val('');
        loadInventory(1, '', '');
    });

    // Confirm selection and close modal
    $('#confirmSelection').on('click', function() {
        addNewSelectedInventories();
        $('#inventoryModal').modal('hide');
    });

    // Function to add only new inventories without affecting existing ones
    function addNewSelectedInventories() {
        const tbody = $('#selectedInventoryBody');
        const existingIds = [];
        
        // Get list of existing inventory IDs in the table
        tbody.find('tr').each(function() {
            const id = $(this).data('inventory-id');
            if (id) {
                existingIds.push(parseInt(id));
            }
        });
        
        // Show the card if it's hidden and we have selections
        if (selectedInventories.length > 0) {
            $('#inventory_details_card').show();
        }
        
        // Add only new inventories that aren't already in the table
        selectedInventories.forEach(function(inventory) {
            if (!existingIds.includes(inventory.id)) {
                const row = `
                    <tr data-inventory-id="${inventory.id}">
                        <td>${inventory.kode_internal}</td>
                        <td>${inventory.kode_roll}</td>
                        <td>${inventory.supplier}</td>
                        <td>${inventory.gsm}</td>
                        <td>${inventory.lebar}</td>
                        <td>${inventory.quantity}</td>
                        <td>
                            <input type="number" 
                                   class="form-control form-control-sm keluar-input" 
                                   name="inventory_keluar[${inventory.id}]" 
                                   value="${inventory.quantity}" 
                                   min="0" 
                                   max="${inventory.quantity}"
                                   step="0.01"
                                   data-max="${inventory.quantity}">
                            <input type="hidden" name="inventory_id[]" value="${inventory.id}">
                            <small class="text-muted">Max: ${inventory.quantity}</small>
                        </td>
                        <td>
                            <input type="text" 
                                   class="form-control form-control-sm" 
                                   name="inventory_opi[${inventory.id}]" 
                                   placeholder="OPI..." 
                                   maxlength="100">
                        </td>
                        <td>
                            <textarea class="form-control form-control-sm" 
                                      name="inventory_keterangan[${inventory.id}]" 
                                      placeholder="Keterangan..." 
                                      rows="2" 
                                      maxlength="255"></textarea>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove-inventory" data-inventory-id="${inventory.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                tbody.append(row);
            }
        });

        // Add event listeners for new keluar inputs
        $('.keluar-input').off('input').on('input', function() {
            const max = parseFloat($(this).data('max'));
            const value = parseFloat($(this).val()) || 0;
            
            if (value > max) {
                $(this).val(max);
            }
        });

        // Add event listeners for new remove buttons
        $('.remove-inventory').off('click').on('click', function() {
            const inventoryId = $(this).data('inventory-id');
            
            // Remove from selected inventories array
            selectedInventories = selectedInventories.filter(inv => inv.id != inventoryId);
            
            // Remove the row from table
            $(this).closest('tr').remove();
            
            // Hide card if no more inventories
            if (selectedInventories.length === 0) {
                $('#inventory_details_card').hide();
            }
            
            // Update count display
            updateSelectedCount();
        });
        
        // Hide card if no inventories selected
        if (selectedInventories.length === 0) {
            $('#inventory_details_card').hide();
        }
    }

    // Function to save current form values before re-rendering
    function saveCurrentFormValues() {
        const savedValues = {};
        
        $('#selectedInventoryBody tr').each(function() {
            const inventoryId = $(this).data('inventory-id');
            if (inventoryId) {
                savedValues[inventoryId] = {
                    keluar: $(this).find(`input[name="inventory_keluar[${inventoryId}]"]`).val(),
                    opi: $(this).find(`input[name="inventory_opi[${inventoryId}]"]`).val(),
                    keterangan: $(this).find(`textarea[name="inventory_keterangan[${inventoryId}]"]`).val()
                };
            }
        });
        
        return savedValues;
    }
    
    // Function to restore saved form values after re-rendering
    function restoreFormValues(savedValues) {
        $('#selectedInventoryBody tr').each(function() {
            const inventoryId = $(this).data('inventory-id');
            if (inventoryId && savedValues[inventoryId]) {
                const values = savedValues[inventoryId];
                
                // Restore keluar value
                if (values.keluar !== undefined && values.keluar !== '') {
                    $(this).find(`input[name="inventory_keluar[${inventoryId}]"]`).val(values.keluar);
                }
                
                // Restore OPI value
                if (values.opi !== undefined && values.opi !== '') {
                    $(this).find(`input[name="inventory_opi[${inventoryId}]"]`).val(values.opi);
                }
                
                // Restore keterangan value
                if (values.keterangan !== undefined && values.keterangan !== '') {
                    $(this).find(`textarea[name="inventory_keterangan[${inventoryId}]"]`).val(values.keterangan);
                }
            }
        });
    }

    // Function to update selected inventory table
    // Function to update selected inventory table
    function updateSelectedInventoryTable() {
        // Save current form values before re-rendering
        const savedValues = saveCurrentFormValues();
        
        const tbody = $('#selectedInventoryBody');
        tbody.empty();
        
        if (selectedInventories.length === 0) {
            $('#inventory_details_card').hide();
            return;
        }

        $('#inventory_details_card').show();

        selectedInventories.forEach(function(inventory, index) {
            const row = `
                <tr data-inventory-id="${inventory.id}">
                    <td>${inventory.kode_internal}</td>
                    <td>${inventory.kode_roll}</td>
                    <td>${inventory.supplier}</td>
                    <td>${inventory.gsm}</td>
                    <td>${inventory.lebar}</td>
                    <td>${inventory.quantity}</td>
                    <td>
                        <input type="number" 
                               class="form-control form-control-sm keluar-input" 
                               name="inventory_keluar[${inventory.id}]" 
                               value="${inventory.quantity}" 
                               min="0" 
                               max="${inventory.quantity}"
                               step="0.01"
                               data-max="${inventory.quantity}">
                        <input type="hidden" name="inventory_id[]" value="${inventory.id}">
                        <small class="text-muted">Max: ${inventory.quantity}</small>
                    </td>
                    <td>
                        <input type="text" 
                               class="form-control form-control-sm" 
                               name="inventory_opi[${inventory.id}]" 
                               placeholder="OPI..." 
                               maxlength="100">
                    </td>
                    <td>
                        <textarea class="form-control form-control-sm" 
                                  name="inventory_keterangan[${inventory.id}]" 
                                  placeholder="Keterangan..." 
                                  rows="2" 
                                  maxlength="255"></textarea>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-inventory" data-inventory-id="${inventory.id}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            tbody.append(row);
        });

        // Restore previously saved form values
        restoreFormValues(savedValues);

        // Add event listeners for keluar inputs
        $('.keluar-input').on('input', function() {
            const max = parseFloat($(this).data('max'));
            const value = parseFloat($(this).val()) || 0;
            
            if (value > max) {
                $(this).val(max);
            }
        });

        // Add event listeners for remove buttons
        $('.remove-inventory').on('click', function() {
            const inventoryId = $(this).data('inventory-id');
            
            // Remove from selected inventories array
            selectedInventories = selectedInventories.filter(inv => inv.id != inventoryId);
            
            // Update displays
            updateSelectedCount();
            updateSelectedInventoryTable();
        });
    }

    // Initialize modal when it's shown
    $('#inventoryModal').on('shown.bs.modal', function() {
        // Load inventory on first show
        loadInventory(1, '', '');
        $('#inventorySearch').focus();
    });

    // Submit form validation
    $('#bbkRollForm').submit(function(e) {
        if (selectedInventories.length === 0) {
            e.preventDefault();
            alert('Silakan pilih minimal satu inventory');
            return false;
        }

        // Validate individual keluar values
        let hasError = false;
        $('.keluar-input').each(function() {
            const value = parseFloat($(this).val()) || 0;
            const max = parseFloat($(this).data('max'));
            
            if (value > max) {
                hasError = true;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        if (hasError) {
            e.preventDefault();
            alert('Ada nilai keluar yang melebihi quantity inventory');
            return false;
        }
    });

    // Initialize displays
    updateSelectedCount();
});
</script>
@endsection
