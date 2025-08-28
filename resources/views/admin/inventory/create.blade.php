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

.inventory-row {
    border-bottom: 1px solid #dee2e6;
}

.inventory-row:last-child {
    border-bottom: none;
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
</style>

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Tambah Inventory Baru</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('inventory.index') }}">Inventory</a></li>
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

      <form action="{{ route('inventory.store') }}" method="POST" id="inventoryForm">
        @csrf
        
        <!-- Header Section -->
        <div class="card shadow-sm mb-4">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Header</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="supplier_id">Supplier <span class="text-danger">*</span></label>
                  <select class="form-control js-example-basic-single" id="supplier_id" name="supplier_id" required>
                    <option value="">Pilih Supplier</option>
                    @foreach($supplier as $item)
                      <option value="{{ $item->id }}" {{ old('supplier_id') == $item->id ? 'selected' : '' }}>
                        {{ $item->name }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="tanggal_masuk">Tanggal Masuk <span class="text-danger">*</span></label>
                  <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk" 
                         value="{{ old('tanggal_masuk', date('Y-m-d')) }}" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="jumlah_roll">Jumlah Roll <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input type="number" class="form-control" id="jumlah_roll" name="jumlah_roll" 
                           value="{{ old('jumlah_roll', 1) }}" min="1" max="100" required>
                    <div class="input-group-append">
                      <button class="btn btn-success" type="button" id="addRowsBtn">
                        <i class="fas fa-plus"></i> Add
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Inventory Items Section -->
        <div class="card shadow-sm">
          <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="fas fa-list me-2"></i>Detail Inventory Roll</h5>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="inventoryTable">
                <thead>
                  <tr>
                    <th width="3%" class="text-black">No</th>
                    <th width="10%" class="text-black">Kode Internal <span class="text-danger">*</span></th>
                    <th width="15%" class="text-black">Kode Roll <span class="text-danger">*</span></th>
                    <th width="10%" class="text-black">No. PO <span class="text-danger">*</span></th>
                    <th width="5%" class="text-black">Jenis <span class="text-danger">*</span></th>
                    <th width="5%" class="text-black">GSM <span class="text-danger">*</span></th>
                    <th width="10%" class="text-black">Lebar Roll <span class="text-danger">*</span></th>
                    <th width="5%" class="text-black">KW <span class="text-danger">*</span></th>
                    <th width="10%" class="text-black">Berat SJ <span class="text-danger">*</span></th>
                    <th width="10%" class="text-black">Berat Timbang <span class="text-danger">*</span></th>
                    <th width="5%" class="text-black">Action</th>
                  </tr>
                </thead>
                <tbody id="inventoryTableBody">
                  <!-- Rows will be added dynamically -->
                </tbody>
              </table>
            </div>
            
            <div class="text-center mt-3" id="emptyState">
              <div class="text-muted">
                <i class="fas fa-inbox fa-3x mb-3"></i>
                <p>Silakan tentukan jumlah roll dan klik tombol "Add" untuk menambahkan baris input</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Submit Section -->
        <div class="mt-4 text-right">
          <a href="{{ route('inventory.index') }}" class="btn btn-secondary mr-2">
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
          <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
            <i class="fas fa-save"></i> Simpan Inventory
          </button>
        </div>
      </form>

      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>

@endsection

@section('javascripts')
<!-- Select2 JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
    let rowCounter = 0;

    $(document).ready(function() {
        // Initialize Select2
        $('.js-example-basic-single').select2({
            theme: 'bootstrap4',
            width: '100%',
            allowClear: false,
            placeholder: 'Pilih...',
            minimumResultsForSearch: 0
        });

        // Add rows button click
        $('#addRowsBtn').click(function() {
            const jumlahRoll = parseInt($('#jumlah_roll').val());
            const supplierId = $('#supplier_id').val();

            var url = "{{ route('supplier-roll.show', ':id') }}";
            url = url.replace(':id', supplierId);
            
            if (!jumlahRoll || jumlahRoll < 1 || jumlahRoll > 100) {
                alert('Jumlah roll harus antara 1-100');
                return;
            }

            $.get(url, function(data) {

                function strpad(str, length) {
                    str = String(str);
                    while (str.length < length) {
                        str = '0' + str;
                    }
                    return str;
                }
                var number = data.number_seq;
    
                $('#inventoryTableBody').empty();
                rowCounter = 0;

                for (let i = number; i < (number + jumlahRoll); i++) {
                    var code = data.code + 'G';
                    code = code + strpad(i, 5);
                    
                    addInventoryRow(code);
                }
            })

            // Add new rows
            

            // Hide empty state and enable submit button
            $('#emptyState').hide();
            $('#submitBtn').prop('disabled', false);
        });

        // Submit form validation
        $('#inventoryForm').submit(function(e) {
            const rows = $('#inventoryTableBody tr').length;
            if (rows === 0) {
                e.preventDefault();
                alert('Silakan tambahkan minimal 1 baris inventory');
                return false;
            }
        });
    });

    function addInventoryRow(code) {
        rowCounter++;
        
        const rowHtml = `
            <tr class="inventory-row">
                <td class="text-center">${rowCounter}</td>
                <td>
                    <input type="text" class="form-control form-control-sm" 
                           name="inventories[${rowCounter-1}][kode_internal]" 
                           placeholder="Kode Internal" value="${code}" required readonly>
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" 
                           name="inventories[${rowCounter-1}][kode_roll]" 
                           placeholder="Kode Roll" required>
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" 
                           name="inventories[${rowCounter-1}][purchase_order]" 
                           placeholder="No PO" required>
                </td>
                <td>
                    <select class="form-control form-control-sm jenis-select" 
                        name="inventories[${rowCounter-1}][jenis]" required>
                        <option value="">Pilih Jenis</option>
                        <option value="BK">BK</option>
                        <option value="TL">TL</option>
                        <option value="ML">ML</option>
                        <option value="MF">MF</option>
                        <option value="MFA">MFA</option>
                        <option value="PL">PL</option>
                        <option value="WK">WK</option>
                        <option value="WS">WS</option>
                        <option value="CME">CME</option>
                    </select>
                </td> 
                <td>
                    <input type="text" class="form-control form-control-sm" 
                           name="inventories[${rowCounter-1}][gsm]" 
                           placeholder="GSM" required>
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" 
                           name="inventories[${rowCounter-1}][lebar]" 
                           placeholder="Lebar Roll" required>
                </td>
                <td>
                    <select class="form-control form-control-sm kw-select" 
                            name="inventories[${rowCounter-1}][jenis_kw]" required>
                        <option value="" selected disable>Pilih KW</option>
                        <option value="0">Tidak</option>
                        <option value="1">Ya</option>
                    </select>
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm" 
                           name="inventories[${rowCounter-1}][berat_sj]" 
                           placeholder="Berat SJ" step="0.01" min="0" required>
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm" 
                           name="inventories[${rowCounter-1}][berat_timbang]" 
                           placeholder="Berat Timbang" step="0.01" min="0" required>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        
        $('#inventoryTableBody').append(rowHtml);
        
        // Initialize Select2 for new selects
        $(`#inventoryTableBody tr:last-child .jenis-select, #inventoryTableBody tr:last-child .lebar-select, #inventoryTableBody tr:last-child .kw-select`).select2({
            theme: 'bootstrap4',
            width: '100%',
            allowClear: false,
            placeholder: 'Pilih...',
            minimumResultsForSearch: 0
        });
    }

    function removeRow(button) {
        $(button).closest('tr').remove();
        
        // Renumber rows
        $('#inventoryTableBody tr').each(function(index) {
            $(this).find('td:first').text(index + 1);
            
            // Update input names
            $(this).find('input, select').each(function() {
                const name = $(this).attr('name');
                if (name) {
                    const newName = name.replace(/\[\d+\]/, '[' + index + ']');
                    $(this).attr('name', newName);
                }
            });
        });
        
        rowCounter = $('#inventoryTableBody tr').length;
        
        // Show empty state if no rows left
        if (rowCounter === 0) {
            $('#emptyState').show();
            $('#submitBtn').prop('disabled', true);
        }
    }
</script>
@endsection
