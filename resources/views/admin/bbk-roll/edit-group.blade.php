@extends('admin.templates.partials.default')

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

.table th {
    background-color: #f8f9fa;
    font-weight: 600;
    border-bottom: 2px solid #dee2e6;
}

.form-control-sm {
    height: calc(1.5em + 0.5rem + 2px);
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    line-height: 1.5;
    border-radius: 0.2rem;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    line-height: 1.5;
    border-radius: 0.2rem;
}

.card {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    border: none;
}

.card-header {
    background-color: #f8f9fc;
    border-bottom: 1px solid #e3e6f0;
}

.form-control:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}

.btn-primary {
    background-color: #4e73df;
    border-color: #4e73df;
}

.btn-primary:hover {
    background-color: #2e59d9;
    border-color: #2653d4;
}

.btn-secondary {
    background-color: #858796;
    border-color: #858796;
}

.btn-secondary:hover {
    background-color: #717384;
    border-color: #6a6b7d;
}

.text-muted {
    color: #5a5c69 !important;
}

.table-responsive {
    border-radius: 0.375rem;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}

#bbk_number_display {
    font-weight: bold;
    color: #5a5c69;
    font-size: 16px;
    background-color: #f8f9fc;
    padding: 10px 15px;
    border-radius: 0.375rem;
    border: 1px solid #d1d3e2;
}

.total-summary {
    background-color: #f8f9fc;
    border: 1px solid #d1d3e2;
    border-radius: 0.375rem;
    padding: 15px;
    margin-top: 20px;
}

.total-summary h6 {
    color: #5a5c69;
    font-weight: 600;
    margin-bottom: 10px;
}

.total-summary .total-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 5px;
}

.total-summary .total-item:last-child {
    margin-bottom: 0;
    font-weight: bold;
    border-top: 1px solid #d1d3e2;
    padding-top: 10px;
    margin-top: 10px;
}

/* Modal styles */
.modal-lg {
    max-width: 900px;
}

.inventory-row:hover {
    background-color: #f8f9fa;
}

.inventory-row.selected {
    background-color: #e7f3ff;
}

.sticky-top {
    position: sticky;
    top: 0;
    z-index: 10;
}

.remove-row {
    opacity: 0.7;
}

.remove-row:hover {
    opacity: 1;
}

#selectedInventoryDetails {
    border-radius: 0.375rem;
    border: 1px solid #b3d7ff;
}

.form-check-input:checked {
    background-color: #4e73df;
    border-color: #4e73df;
}

/* Highlighting for inventory with potongan */
.inventory-with-potongan {
    background-color: #e3f2fd !important;
    border-left: 4px solid #2196f3 !important;
}

/* Highlight kode_internal specifically */
strong.inventory-with-potongan {
    background-color: #ffeb3b;
    padding: 2px 4px;
    border-radius: 3px;
    color: #1976d2;
    font-weight: bold;
}

.potongan-indicator {
    background-color: #4caf50;
    color: white;
    padding: 1px 6px;
    border-radius: 10px;
    font-size: 10px;
    margin-left: 5px;
    font-weight: bold;
}

.potongan-info {
    color: #666;
    font-style: italic;
}

/* Styling for Kembali + Rasio column */
.kembali-rasio-display {
    border: 2px solid #ffc107 !important;
}

.kembali-rasio-display:focus {
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25) !important;
}
</style>

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit BBK Roll Group</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('bbk-roll.index') }}">BBK Roll</a></li>
                        <li class="breadcrumb-item active">Edit Group</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-edit me-2"></i>Edit BBK Roll Group
                            </h5>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('bbk-roll.update-group', $bbkNumber) }}" method="POST" id="bbkRollGroupForm">
                                @csrf
                                @method('PUT')

                                <!-- BBK Number Display -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label">BBK Number</label>
                                        <div id="bbk_number_display">{{ $bbkNumber }}</div>
                                        <small class="text-muted">Nomor BBK tidak dapat diubah</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tanggal_bbk" class="form-label">Tanggal BBK <span class="text-danger">*</span></label>
                                        <input type="date" 
                                               class="form-control @error('tanggal_bbk') is-invalid @enderror" 
                                               id="tanggal_bbk" 
                                               name="tanggal_bbk" 
                                               value="{{ old('tanggal_bbk', $bbkRolls->first()->tanggal_bbk) }}" 
                                               required>
                                        @error('tanggal_bbk')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Current Inventories Table -->
                                <div class="table-responsive mb-4">
                                    <table class="table table-bordered table-striped">
                                        <thead v >
                                            <tr>
                                                <th width="5%" class="text-black" >No</th>
                                                <th width="16%" class="text-black" >Inventory</th>
                                                <th width="13%" class="text-black" >Details</th>
                                                <th width="8%" class="text-black" >Keluar</th>
                                                <th width="8%" class="text-black" >Kembali</th>
                                                <th width="10%" class="text-black" >Kembali + Rasio</th>
                                                <th width="8%" class="text-black" >Pakai</th>
                                                <th width="12%" class="text-black" >OPI</th>
                                                <th width="15%" class="text-black" >Keterangan</th>
                                                <th width="5%" class="text-black" >Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="inventoryTableBody">
                                            @foreach($bbkRolls as $index => $bbkRoll)
                                            <tr data-row="{{ $index }}" data-bbk-roll-id="{{ $bbkRoll->id }}" 
                                                class="{{ $bbkRoll->inventory->potongan_id ? 'inventory-with-potongan' : '' }}">
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <input type="hidden" name="bbk_roll_ids[]" value="{{ $bbkRoll->id }}">
                                                    <strong class="{{ $bbkRoll->inventory->potongan_id ? 'inventory-with-potongan' : '' }}">{{ $bbkRoll->inventory->kode_internal }}</strong>
                                                    @if($bbkRoll->inventory->potongan_id)
                                                        <span class="potongan-indicator">ADA POTONGAN</span>
                                                    @endif
                                                    <br>
                                                    <small class="text-muted">{{ $bbkRoll->inventory->kode_roll }}</small>
                                                    @if($bbkRoll->inventory->potongan_id)
                                                        <br><small class="potongan-info">Potongan ID: {{ $bbkRoll->inventory->potongan->lebar_potongan }}</small>
                                                        <br><small class="potongan-info">Rasio: {{ $bbkRoll->inventory->potongan->rasio }}%</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    <small>
                                                        <strong>Supplier:</strong> {{ $bbkRoll->inventory->supplier->name ?? '-' }}<br>
                                                        <strong>GSM:</strong> {{ $bbkRoll->inventory->gsm }}<br>
                                                        <strong>Lebar:</strong> {{ $bbkRoll->inventory->lebar }}
                                                    </small>
                                                </td>
                                                <td>
                                                    <span class="badge badge-info">{{ number_format($bbkRoll->keluar, 2) }}</span>
                                                </td>
                                                <td>
                                                    <input type="number" 
                                                           class="form-control form-control-sm kembali-input" 
                                                           name="inventory_kembali[{{ $index }}]" 
                                                           value="{{ $bbkRoll->kembali }}"
                                                           min="0" 
                                                           step="0.01"
                                                           data-has-potongan="{{ $bbkRoll->inventory->potongan_id ? 'true' : 'false' }}"
                                                           data-rasio="{{ $bbkRoll->inventory->potongan_id && $bbkRoll->inventory->potongan ? $bbkRoll->inventory->potongan->rasio : 0 }}">
                                                </td>
                                                <td>
                                                    <input type="text" 
                                                           class="form-control form-control-sm kembali-rasio-display" 
                                                           name="inventory_kembali_rasio[{{ $index }}]"
                                                           readonly 
                                                           value="{{ $bbkRoll->inventory->potongan_id && $bbkRoll->inventory->potongan ? number_format($bbkRoll->kembali + ($bbkRoll->kembali * $bbkRoll->inventory->potongan->rasio / 100), 2) : '-' }}"
                                                           style="{{ $bbkRoll->inventory->potongan_id ? 'background-color: #fff3cd; font-weight: bold;' : 'background-color: #f8f9fa;' }}"
                                                           data-calculated="true">
                                                </td>
                                                <td>
                                                    <input type="text" 
                                                           class="form-control form-control-sm pakai-display" 
                                                           name="inventory_sisa[{{ $index }}]"
                                                           readonly 
                                                           value="{{ number_format($bbkRoll->keluar - $bbkRoll->kembali, 2) }}">
                                                </td>
                                                <td>
                                                    <input type="text" 
                                                           class="form-control form-control-sm" 
                                                           name="inventory_opi[{{ $index }}]" 
                                                           value="{{ $bbkRoll->opi }}"
                                                           maxlength="100">
                                                </td>
                                                <td>
                                                    <textarea class="form-control form-control-sm" 
                                                              name="inventory_keterangan[{{ $index }}]" 
                                                              rows="2" 
                                                              maxlength="500">{{ $bbkRoll->keterangan }}</textarea>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm delete-existing-row" 
                                                            data-bbk-roll-id="{{ $bbkRoll->id }}" 
                                                            data-inventory-name="{{ $bbkRoll->inventory->kode_internal }}" 
                                                            title="Hapus dari BBK Roll">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Add New Inventory Button -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <button type="button" class="btn btn-success btn-sm" id="addInventoryBtn">
                                        <i class="fas fa-plus me-1"></i> Tambah Barang
                                    </button>
                                    <small class="text-muted">Klik tombol tambah untuk menambahkan inventory baru ke group BBK ini</small>
                                </div>

                                <!-- Total Summary -->
                                <div class="total-summary">
                                    <h6><i class="fas fa-calculator me-2"></i>Ringkasan Total</h6>
                                    <div class="total-item">
                                        <span>Total Keluar:</span>
                                        <span id="totalKeluar">{{ number_format($bbkRolls->sum('keluar'), 2) }}</span>
                                    </div>
                                    <div class="total-item">
                                        <span>Total Kembali:</span>
                                        <span id="totalKembali">0</span>
                                    </div>
                                    <div class="total-item">
                                        <span>Total Kembali + Rasio:</span>
                                        <span id="totalKembaliRasio" style="color: #856404; font-weight: bold;">0</span>
                                    </div>
                                    <div class="total-item">
                                        <span>Total Sisa:</span>
                                        <span id="totalSisa">0</span>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <a href="{{ route('bbk-roll.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-1"></i> Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Update BBK Roll Group
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<!-- Modal Add Inventory -->
<div class="modal fade" id="addInventoryModal" tabindex="-1" role="dialog" aria-labelledby="addInventoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addInventoryModalLabel">
                    <i class="fas fa-plus me-2"></i>Tambah Multiple Inventory ke BBK Group
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Search and Filter Section -->
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
                
                <!-- Inventory Selection Table -->
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-hover table-sm">
                        <thead class="thead-light sticky-top">
                            <tr>
                                <th width="5%">
                                    <input type="checkbox" id="selectAllInventories" class="form-check-input">
                                </th>
                                <th width="20%">Kode Internal</th>
                                <th width="15%">Kode Roll</th>
                                <th width="20%">Supplier</th>
                                <th width="10%">GSM</th>
                                <th width="10%">Lebar</th>
                                <th width="20%">Quantity Available</th>
                            </tr>
                        </thead>
                        <tbody id="inventoryList">
                            <tr>
                                <td colspan="7" class="text-center">
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
                
                <!-- Selected Items Summary -->
                <div id="selectedItemsSummary" class="mt-3" style="display: none;">
                    <div class="alert alert-info">
                        <h6><i class="fas fa-check-circle me-2"></i>Items Terpilih: <span id="selectedCount">0</span></h6>
                        <div id="selectedItemsList" class="mt-2"></div>
                    </div>
                </div>
                
                <!-- OPI Input -->
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="modalOpi" class="form-label">Nomor OPI <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="modalOpi" maxlength="100" required 
                               placeholder="Masukkan nomor OPI untuk semua inventory terpilih">
                        <small class="text-muted">Nomor OPI ini akan digunakan untuk semua inventory yang dipilih</small>
                    </div>
                    <div class="col-md-6">
                        <label for="modalKeterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="modalKeterangan" rows="3" maxlength="500" 
                                  placeholder="Keterangan tambahan (opsional)"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Batal
                </button>
                <button type="button" class="btn btn-primary" id="addSelectedInventories" disabled>
                    <i class="fas fa-plus me-1"></i>Tambah <span id="addButtonCount">0</span> Item
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascripts')
<script>
$(document).ready(function() {
    // Setup CSRF token for AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    let selectedInventories = [];
    let rowCounter = {{ count($bbkRolls) }};
    let currentPage = 1;
    let lastPage = 1;
    let isLoading = false;
    
    // Function to load inventory with pagination
    function loadInventoryWithPagination(page = 1, search = '', supplier = '') {
        if (isLoading) return;
        
        isLoading = true;
        currentPage = page;
        
        // Show loading state
        if (page === 1) {
            $('#inventoryList').html(`
                <tr>
                    <td colspan="7" class="text-center">
                        <div class="spinner-border spinner-border-sm" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <span class="ml-2">Loading inventory...</span>
                    </td>
                </tr>
            `);
        }
        
        // Get currently used inventory IDs to exclude them
        const usedInventoryIds = [];
        $('#inventoryTableBody tr').each(function() {
            const inventoryId = $(this).data('inventory-id');
            if (inventoryId) {
                usedInventoryIds.push(inventoryId);
            }
        });
        
        $.ajax({
            url: '{{ route("inventory.paginated") }}',
            method: 'GET',
            data: {
                page: page,
                search: search,
                supplier: supplier,
                per_page: 20,
                exclude: usedInventoryIds
            },
            success: function(response) {
                if (response.success) {
                    displayInventoriesForMultipleSelection(response.data);
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
                $('#inventoryList').html(`
                    <tr>
                        <td colspan="7" class="text-center text-danger">
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
            loadInventoryWithPagination(page, search, supplier);
        }
    });
    
    // Calculate sisa and kembali + rasio for existing rows
    function calculateSisa(row) {
        const keluarText = row.find('td:nth-child(4) .badge').text().replace(/,/g, '');
        const keluar = parseFloat(keluarText) || 0;
        const kembaliInput = row.find('.kembali-input');
        const kembali = parseFloat(kembaliInput.val()) || 0;
        const sisa = keluar - kembali;
        
        // Calculate Kembali + Rasio if inventory has potongan
        let hasPotongan = kembaliInput.data('has-potongan') === 'true';
        let rasio = parseFloat(kembaliInput.data('rasio')) || 0;
        
        // Fallback: check if row has potongan indicator and extract rasio from DOM
        if (!hasPotongan && row.find('.potongan-indicator').length > 0) {
            hasPotongan = true;
            const rasioText = row.find('.potongan-info:contains("Rasio:")').text();
            const rasioMatch = rasioText.match(/Rasio:\s*([\d.]+)%/);
            if (rasioMatch) {
                rasio = parseFloat(rasioMatch[1]);
            }
        }
        
        const kembaliRasioDisplay = row.find('.kembali-rasio-display');
        
        console.log('Debug calculation:', {
            hasPotongan: hasPotongan,
            rasio: rasio,
            kembali: kembali,
            field_found: kembaliRasioDisplay.length,
            row_has_potongan_class: row.hasClass('inventory-with-potongan')
        });
        
        if (hasPotongan && rasio > 0) {
            const kembaliPlusRasio = kembali + (kembali * rasio / 100);
            kembaliRasioDisplay.val(kembaliPlusRasio.toFixed(2));
        } else {
            kembaliRasioDisplay.val(hasPotongan ? '0.00' : '-');
        }
        
        row.find('.pakai-display').val(sisa.toFixed(2));
    }

    // Bind calculation for all input events on kembali-input
    $(document).on('input change keyup paste', '.kembali-input', function() {
        const row = $(this).closest('tr');
        calculateSisa(row);
        calculateTotals();
    });

    // Calculate totals
    function calculateTotals() {
        let totalKeluar = 0;
        let totalKembali = 0;
        let totalKembaliRasio = 0;
        let totalSisa = 0;

        $('#inventoryTableBody tr').each(function() {
            const keluarText = $(this).find('td:nth-child(4) .badge').text().replace(/,/g, '');
            const keluar = parseFloat(keluarText) || 0;
            const kembali = parseFloat($(this).find('.kembali-input').val()) || 0;
            const kembaliRasioText = $(this).find('.kembali-rasio-display').val();
            const kembaliRasio = kembaliRasioText !== '-' ? parseFloat(kembaliRasioText) || 0 : 0;
            const sisa = keluar - kembali;

            totalKeluar += keluar;
            totalKembali += kembali;
            totalKembaliRasio += kembaliRasio;
            totalSisa += sisa;
        });

        $('#totalKeluar').text(totalKeluar.toFixed(2));
        $('#totalKembali').text(totalKembali.toFixed(2));
        $('#totalKembaliRasio').text(totalKembaliRasio.toFixed(2));
        $('#totalSisa').text(totalSisa.toFixed(2));
    }

    // Form validation
    $('#bbkRollGroupForm').on('submit', function(e) {
        const rows = $('#inventoryTableBody tr').length;
        if (rows === 0) {
            e.preventDefault();
            alert('Tidak ada data BBK Roll untuk diupdate!');
            return false;
        }
        
        // Check if any new inventory has invalid quantities
        let hasError = false;
        $('.kembali-input').each(function() {
            const kembaliInput = $(this);
            const row = kembaliInput.closest('tr');
            const keluarText = row.find('td:nth-child(4) .badge').text().replace(/,/g, '');
            const keluar = parseFloat(keluarText) || 0;
            const kembali = parseFloat(kembaliInput.val()) || 0;
            
            if (kembali > keluar) {
                hasError = true;
                kembaliInput.addClass('is-invalid');
                if (!kembaliInput.next('.invalid-feedback').length) {
                    kembaliInput.after('<div class="invalid-feedback">Kembali tidak boleh lebih dari keluar</div>');
                }
            } else {
                kembaliInput.removeClass('is-invalid');
                kembaliInput.next('.invalid-feedback').remove();
                
                // Ensure kembali + rasio is calculated when validation passes
                calculateSisa(row);
            }
        });
        
        if (hasError) {
            e.preventDefault();
            alert('Terdapat data yang tidak valid. Mohon periksa kembali form.');
            return false;
        }
    });

    // Delete existing BBK Roll
    $(document).on('click', '.delete-existing-row', function() {
        const bbkRollId = $(this).data('bbk-roll-id');
        const inventoryName = $(this).data('inventory-name');
        const row = $(this).closest('tr');
        const deleteButton = $(this);
        
        if (confirm(`Apakah Anda yakin ingin menghapus inventory "${inventoryName}" dari BBK Roll ini?\\n\\nInventory akan dikembalikan ke stok tersedia.`)) {
            // Disable button and show loading
            deleteButton.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
            
            // Send AJAX delete request
            $.ajax({
                url: `{{ url('bbk-roll/delete-item') }}/${bbkRollId}`,
                method: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        // Remove row from table
                        row.remove();
                        
                        // Update row numbers and totals
                        updateRowNumbers();
                        calculateTotals();
                        
                        // Show success message
                        showAlert('success', response.message || `Inventory "${inventoryName}" berhasil dihapus dari BBK Roll.`);
                    } else {
                        // Re-enable button
                        deleteButton.prop('disabled', false).html('<i class="fas fa-trash"></i>');
                        showAlert('danger', response.message || 'Gagal menghapus inventory.');
                    }
                },
                error: function(xhr) {
                    // Re-enable button
                    deleteButton.prop('disabled', false).html('<i class="fas fa-trash"></i>');
                    
                    let errorMessage = 'Terjadi kesalahan saat menghapus inventory.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    showAlert('danger', errorMessage);
                }
            });
        }
    });
    
    // Show alert helper function
    function showAlert(type, message) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `;
        $('.card-body').prepend(alertHtml);
        
        // Auto remove after 3 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 3000);
    }

    // Add Inventory Button Click
    $('#addInventoryBtn').click(function() {
        selectedInventories = [];
        updateSelectedItemsDisplay();
        $('#addInventoryModal').modal('show');
        loadAvailableInventories();
    });
    
    // Load available inventories with pagination
    function loadAvailableInventories() {
        loadInventoryWithPagination(1, '', '');
    }
    
    // Display inventories with multiple selection
    function displayInventoriesForMultipleSelection(inventories) {
        // Store inventories data globally for selection
        window.currentPageInventories = inventories;
        
        let html = '';
        if (inventories.length === 0) {
            html = '<tr><td colspan="7" class="text-center text-muted">Tidak ada inventory tersedia</td></tr>';
        } else {
            inventories.forEach(function(inventory) {
                const isSelected = selectedInventories.some(sel => sel.id === inventory.id);
                const hasPotongan = inventory.potongan_id && inventory.potongan_id !== null;
                const rowClass = hasPotongan ? 'inventory-with-potongan' : '';
                html += `
                    <tr class="inventory-row ${isSelected ? 'selected' : ''} ${rowClass}" data-inventory-id="${inventory.id}" style="cursor: pointer;">
                        <td>
                            <div class="form-check">
                                <input class="form-check-input inventory-checkbox" type="checkbox" value="${inventory.id}" ${isSelected ? 'checked' : ''}>
                            </div>
                        </td>
                        <td>
                            <strong class="${hasPotongan ? 'inventory-with-potongan' : ''}">${inventory.kode_internal}</strong>
                            ${hasPotongan ? '<br><span class="potongan-indicator">ADA POTONGAN</span>' : ''}
                        </td>
                        <td><small>${inventory.kode_roll || '-'}</small></td>
                        <td><small>${inventory.supplier_name || '-'}</small></td>
                        <td><small>${inventory.gsm || '-'}</small></td>
                        <td><small>${inventory.lebar || '-'}</small></td>
                        <td>
                            <small><strong>${inventory.quantity || 0}</strong> kg</small>
                            ${hasPotongan && inventory.potongan ? '<br><small class="potongan-info">Potongan ID: ' + inventory.potongan.lebar_potongan + '</small>' : ''}
                            ${hasPotongan && inventory.potongan ? '<br><small class="potongan-info">Rasio: ' + inventory.potongan.rasio + '%</small>' : ''}
                        </td>
                    </tr>
                `;
            });
        }
        $('#inventoryList').html(html);
    }
    
    // Inventory search with debouncing
    let searchTimeout;
    $('#inventorySearch').on('input', function() {
        clearTimeout(searchTimeout);
        const searchTerm = $(this).val();
        
        searchTimeout = setTimeout(function() {
            const supplier = $('#supplierFilter').val();
            loadInventoryWithPagination(1, searchTerm, supplier);
        }, 500); // Debounce 500ms
    });
    
    $('#supplierFilter').on('change', function() {
        const supplier = $(this).val();
        const search = $('#inventorySearch').val();
        loadInventoryWithPagination(1, search, supplier);
    });
    
    $('#clearFilters').on('click', function() {
        $('#inventorySearch').val('');
        $('#supplierFilter').val('');
        loadInventoryWithPagination(1, '', '');
    });
    
    // Select All functionality
    $(document).on('change', '#selectAllInventories', function() {
        const isChecked = $(this).is(':checked');
        $('.inventory-checkbox').prop('checked', isChecked);
        
        if (isChecked) {
            // Add all visible inventories to selection
            $('.inventory-checkbox').each(function() {
                const inventoryId = $(this).val();
                const row = $(this).closest('tr');
                addInventoryToSelection(inventoryId, row);
            });
        } else {
            // Clear all selections
            selectedInventories = [];
        }
        
        updateSelectedItemsDisplay();
    });
    
    // Individual checkbox change
    $(document).on('change', '.inventory-checkbox', function() {
        const inventoryId = $(this).val();
        const row = $(this).closest('tr');
        
        if ($(this).is(':checked')) {
            addInventoryToSelection(inventoryId, row);
        } else {
            removeInventoryFromSelection(inventoryId);
        }
        
        updateSelectedItemsDisplay();
        updateSelectAllState();
    });
    
    // Add inventory to selection
    function addInventoryToSelection(inventoryId, row) {
        const existingIndex = selectedInventories.findIndex(inv => inv.id == inventoryId);
        if (existingIndex === -1) {
            // Get full inventory data from current page data
            const fullInventoryData = window.currentPageInventories ? 
                window.currentPageInventories.find(inv => inv.id == inventoryId) : null;
            
            if (fullInventoryData) {
                selectedInventories.push({
                    id: fullInventoryData.id,
                    kode_internal: fullInventoryData.kode_internal,
                    kode_roll: fullInventoryData.kode_roll,
                    supplier_name: fullInventoryData.supplier_name,
                    gsm: fullInventoryData.gsm,
                    lebar: fullInventoryData.lebar,
                    quantity: fullInventoryData.quantity,
                    potongan_id: fullInventoryData.potongan_id,
                    potongan: fullInventoryData.potongan
                });
            } else {
                // Fallback to DOM extraction if data not found
                const inventoryData = {
                    id: inventoryId,
                    kode_internal: row.find('td:nth-child(2) strong').first().text().trim(),
                    kode_roll: row.find('td:nth-child(3)').text().trim(),
                    supplier_name: row.find('td:nth-child(4)').text().trim(),
                    gsm: row.find('td:nth-child(5)').text().trim(),
                    lebar: row.find('td:nth-child(6)').text().trim(),
                    quantity: parseFloat(row.find('td:nth-child(7) strong').text()) || 0
                };
                selectedInventories.push(inventoryData);
            }
            row.addClass('selected');
        }
    }
    
    // Remove inventory from selection
    function removeInventoryFromSelection(inventoryId) {
        selectedInventories = selectedInventories.filter(inv => inv.id != inventoryId);
        $(`.inventory-row[data-inventory-id="${inventoryId}"]`).removeClass('selected');
    }
    
    // Update selected items display
    function updateSelectedItemsDisplay() {
        const count = selectedInventories.length;
        
        if (count === 0) {
            $('#selectedItemsSummary').hide();
            $('#addSelectedInventories').prop('disabled', true);
        } else {
            $('#selectedItemsSummary').show();
            $('#addSelectedInventories').prop('disabled', false);
            
            $('#selectedCount').text(count);
            $('#addButtonCount').text(count);
            
            let listHtml = '<div class="row">';
            selectedInventories.forEach((inv, index) => {
                listHtml += `
                    <div class="col-md-6 mb-2">
                        <div class="badge badge-info mr-1">
                            ${inv.kode_internal} (${inv.quantity} kg)
                        </div>
                    </div>
                `;
            });
            listHtml += '</div>';
            
            $('#selectedItemsList').html(listHtml);
        }
    }
    
    // Update select all checkbox state
    function updateSelectAllState() {
        const totalCheckboxes = $('.inventory-checkbox').length;
        const checkedCheckboxes = $('.inventory-checkbox:checked').length;
        
        if (checkedCheckboxes === 0) {
            $('#selectAllInventories').prop('indeterminate', false).prop('checked', false);
        } else if (checkedCheckboxes === totalCheckboxes) {
            $('#selectAllInventories').prop('indeterminate', false).prop('checked', true);
        } else {
            $('#selectAllInventories').prop('indeterminate', true);
        }
    }
    
    // Add selected inventories to table
    $('#addSelectedInventories').click(function() {
        if (selectedInventories.length === 0) return;
        
        const opi = $('#modalOpi').val().trim();
        const keterangan = $('#modalKeterangan').val().trim();
        
        if (!opi) {
            alert('Nomor OPI harus diisi!');
            $('#modalOpi').focus();
            return;
        }
        
        // Check for existing inventories
        const existingInventoryIds = [];
        $('#inventoryTableBody tr').each(function() {
            const existingInventoryId = $(this).data('inventory-id');
            if (existingInventoryId) {
                existingInventoryIds.push(existingInventoryId.toString());
            }
        });
        
        const conflictingInventories = selectedInventories.filter(inv => 
            existingInventoryIds.includes(inv.id.toString())
        );
        
        if (conflictingInventories.length > 0) {
            const conflictNames = conflictingInventories.map(inv => inv.kode_internal).join(', ');
            alert(`Inventory berikut sudah ada dalam BBK Roll: ${conflictNames}`);
            return;
        }
        
        // Add all selected inventories
        selectedInventories.forEach(inventory => {
            addInventoryRow(inventory, inventory.quantity, opi, keterangan);
        });
        
        // Close modal and reset
        $('#addInventoryModal').modal('hide');
        resetModal();
    });
    
    // Add new inventory row to table
    function addInventoryRow(inventory, keluar, opi, keterangan) {
        const rowNumber = $('#inventoryTableBody tr').length + 1;
        const hasPotongan = inventory.potongan_id && inventory.potongan_id !== null;
        const rowClass = hasPotongan ? 'inventory-with-potongan' : '';
        const newRowHtml = `
            <tr data-row="${rowCounter}" data-inventory-id="${inventory.id}" class="${rowClass}">
                <td>${rowNumber}</td>
                <td>
                    <input type="hidden" name="new_inventory_ids[]" value="${inventory.id}">
                    <strong class="${hasPotongan ? 'inventory-with-potongan' : ''}">${inventory.kode_internal}</strong>
                    ${hasPotongan ? '<span class="potongan-indicator">ADA POTONGAN</span>' : ''}
                    <br>
                    <small class="text-muted">${inventory.kode_roll || '-'}</small>
                    ${hasPotongan && inventory.potongan ? '<br><small class="potongan-info">Potongan ID: ' + inventory.potongan.lebar_potongan + '</small>' : ''}
                    ${hasPotongan && inventory.potongan ? '<br><small class="potongan-info">Rasio: ' + inventory.potongan.rasio + '%</small>' : ''}
                </td>
                <td>
                    <small>
                        <strong>Supplier:</strong> ${inventory.supplier_name || '-'}<br>
                        <strong>GSM:</strong> ${inventory.gsm || '-'}<br>
                        <strong>Lebar:</strong> ${inventory.lebar || '-'}
                    </small>
                </td>
                <td>
                    <input type="hidden" name="new_inventory_keluar[]" value="${keluar}">
                    <span class="badge badge-info">${parseFloat(keluar).toFixed(2)}</span>
                </td>
                <td>
                    <input type="number" 
                           class="form-control form-control-sm kembali-input" 
                           name="new_inventory_kembali[]" 
                           value="0"
                           min="0" 
                           step="0.01"
                           data-has-potongan="${hasPotongan ? 'true' : 'false'}"
                           data-rasio="${hasPotongan && inventory.potongan ? inventory.potongan.rasio : 0}">
                </td>
                <td>
                    <input type="text" 
                           class="form-control form-control-sm kembali-rasio-display" 
                           name="new_inventory_kembali_rasio[]"
                           readonly 
                           value="${hasPotongan ? '0.00' : '-'}"
                           style="${hasPotongan ? 'background-color: #fff3cd; font-weight: bold;' : 'background-color: #f8f9fa;'}"
                           data-calculated="true">
                </td>
                <td>
                    <input type="text" 
                           class="form-control form-control-sm pakai-display" 
                           name="new_inventory_sisa[]"
                           readonly 
                           value="${parseFloat(keluar).toFixed(2)}">
                </td>
                <td>
                    <input type="text" 
                           class="form-control form-control-sm" 
                           name="new_inventory_opi[]" 
                           value="${opi}"
                           maxlength="100">
                </td>
                <td>
                    <textarea class="form-control form-control-sm" 
                              name="new_inventory_keterangan[]" 
                              rows="2" 
                              maxlength="500">${keterangan}
                    </textarea>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm mt-1 remove-row" title="Hapus baris">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        
        $('#inventoryTableBody').append(newRowHtml);
        
        // Update row numbers
        updateRowNumbers();
        
        // Recalculate totals
        calculateTotals();
        
        rowCounter++;
    }
    
    // Remove inventory row
    $(document).on('click', '.remove-row', function() {
        if (confirm('Apakah Anda yakin ingin menghapus baris ini?')) {
            $(this).closest('tr').remove();
            updateRowNumbers();
            calculateTotals();
        }
    });
    
    // Update row numbers
    function updateRowNumbers() {
        $('#inventoryTableBody tr').each(function(index) {
            $(this).find('td:first').text(index + 1);
        });
    }
    
    // Reset modal form
    function resetModal() {
        selectedInventories = [];
        $('#selectedItemsSummary').hide();
        $('#addSelectedInventories').prop('disabled', true);
        $('#inventorySearch').val('');
        $('.inventory-row').removeClass('selected');
        $('.inventory-checkbox').prop('checked', false);
        $('#selectAllInventories').prop('checked', false).prop('indeterminate', false);
        $('#modalOpi').val('');
        $('#modalKeterangan').val('');
        $('#selectedCount').text('0');
        $('#addButtonCount').text('0');
    }
    
    // Modal hidden event
    $('#addInventoryModal').on('hidden.bs.modal', function () {
        resetModal();
    });
    
    // Initialize calculations and kembali + rasio for existing rows
    $('#inventoryTableBody tr').each(function() {
        calculateSisa($(this));
    });
    calculateTotals();
});
</script>
@endsection
