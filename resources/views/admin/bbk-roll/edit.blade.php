@extends('admin.templates.partials.default')

<!-- Select2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css" />

<style>
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

#bbk_number_display {
    font-weight: bold;
    color: #5a5c69;
    font-size: 16px;
    background-color: #f8f9fc;
    padding: 10px 15px;
    border-radius: 0.375rem;
    border: 1px solid #d1d3e2;
}
</style>

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit BBK Roll</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('bbk-roll.index') }}">BBK Roll</a></li>
            <li class="breadcrumb-item active">Edit BBK Roll</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
              <h5 class="mb-0">
                <i class="fas fa-edit me-2"></i>Form Edit BBK Roll
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

              <form action="{{ route('bbk-roll.update', $bbkRoll->id) }}" method="POST" id="bbkRollForm">
                @csrf
                @method('PUT')

                <!-- BBK Number Display -->
                <div class="mb-3">
                  <label class="form-label">BBK Number</label>
                  <div id="bbk_number_display">{{ $bbkRoll->bbk_number }}</div>
                  <small class="text-muted">Nomor BBK tidak dapat diubah</small>
                </div>

                <!-- Tanggal BBK -->
                <div class="mb-3">
                  <label for="tanggal_bbk" class="form-label">Tanggal BBK <span class="text-danger">*</span></label>
                  <input type="date" 
                         class="form-control @error('tanggal_bbk') is-invalid @enderror" 
                         id="tanggal_bbk" 
                         name="tanggal_bbk" 
                         value="{{ old('tanggal_bbk', $bbkRoll->tanggal_bbk) }}" 
                         required>
                  @error('tanggal_bbk')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <!-- Inventory -->
                <div class="mb-3">
                  <label for="inventory_id" class="form-label">Pilih Inventory <span class="text-danger">*</span></label>
                  <select class="form-control @error('inventory_id') is-invalid @enderror" 
                          id="inventory_id" 
                          name="inventory_id" 
                          required>
                    <option value="">Pilih Inventory...</option>
                    @foreach($inventories as $inventory)
                      <option value="{{ $inventory->id }}" 
                              data-kode-internal="{{ $inventory->kode_internal }}"
                              data-kode-roll="{{ $inventory->kode_roll }}"
                              data-supplier="{{ $inventory->supplier->name ?? '' }}"
                              data-gsm="{{ $inventory->gsm }}"
                              data-lebar="{{ $inventory->lebar }}"
                              {{ old('inventory_id', $bbkRoll->inventory_id) == $inventory->id ? 'selected' : '' }}>
                        {{ $inventory->kode_internal }} - {{ $inventory->kode_roll }} ({{ $inventory->supplier->name ?? '' }})
                      </option>
                    @endforeach
                  </select>
                  @error('inventory_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <!-- Inventory Details (Read-only) -->
                <div class="row mb-3" id="inventory_details">
                  <div class="col-md-6">
                    <label class="form-label">Kode Internal</label>
                    <input type="text" class="form-control" id="kode_internal_display" readonly>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Kode Roll</label>
                    <input type="text" class="form-control" id="kode_roll_display" readonly>
                  </div>
                </div>

                <div class="row mb-3" id="inventory_details_2">
                  <div class="col-md-4">
                    <label class="form-label">Supplier</label>
                    <input type="text" class="form-control" id="supplier_display" readonly>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">GSM</label>
                    <input type="text" class="form-control" id="gsm_display" readonly>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Lebar</label>
                    <input type="text" class="form-control" id="lebar_display" readonly>
                  </div>
                </div>

                <!-- Keluar -->
                <div class="mb-3">
                  <label for="keluar" class="form-label">Keluar <span class="text-danger">*</span></label>
                  <input type="number" 
                         class="form-control @error('keluar') is-invalid @enderror" 
                         id="keluar" 
                         name="keluar" 
                         value="{{ old('keluar', $bbkRoll->keluar) }}" 
                         min="0" 
                         step="0.01" 
                         required>
                  @error('keluar')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <!-- Kembali -->
                <div class="mb-3">
                  <label for="kembali" class="form-label">Kembali</label>
                  <input type="number" 
                         class="form-control @error('kembali') is-invalid @enderror" 
                         id="kembali" 
                         name="kembali" 
                         value="{{ old('kembali', $bbkRoll->kembali) }}" 
                         min="0" 
                         step="0.01">
                  @error('kembali')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <!-- Sisa (Auto calculated) -->
                <div class="mb-3">
                  <label class="form-label">Sisa</label>
                  <input type="text" class="form-control" id="sisa_display" readonly>
                  <small class="text-muted">Dihitung otomatis: Keluar - Kembali</small>
                </div>

                <!-- OPI -->
                <div class="mb-3">
                  <label for="opi" class="form-label">OPI</label>
                  <input type="text" 
                         class="form-control @error('opi') is-invalid @enderror" 
                         id="opi" 
                         name="opi" 
                         value="{{ old('opi', $bbkRoll->opi) }}" 
                         maxlength="100">
                  @error('opi')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <!-- Keterangan -->
                <div class="mb-3">
                  <label for="keterangan" class="form-label">Keterangan</label>
                  <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                            id="keterangan" 
                            name="keterangan" 
                            rows="3" 
                            maxlength="500">{{ old('keterangan', $bbkRoll->keterangan) }}</textarea>
                  @error('keterangan')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                  <small class="text-muted">Maksimal 500 karakter</small>
                </div>

                <div class="d-flex justify-content-between">
                  <a href="{{ route('bbk-roll.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                  </a>
                  <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Update BBK Roll
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
@endsection

@section('javascripts')
<!-- Select2 JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Select2
    $('#inventory_id').select2({
        theme: 'bootstrap4',
        width: '100%',
        allowClear: true,
        placeholder: 'Pilih Inventory...'
    });

    // Show inventory details when inventory is selected
    $('#inventory_id').on('change', function() {
        const selectedOption = $(this).find('option:selected');
        
        if (selectedOption.val()) {
            $('#kode_internal_display').val(selectedOption.data('kode-internal'));
            $('#kode_roll_display').val(selectedOption.data('kode-roll'));
            $('#supplier_display').val(selectedOption.data('supplier'));
            $('#gsm_display').val(selectedOption.data('gsm'));
            $('#lebar_display').val(selectedOption.data('lebar'));
            
            $('#inventory_details').show();
            $('#inventory_details_2').show();
        } else {
            $('#inventory_details').hide();
            $('#inventory_details_2').hide();
        }
    });

    // Calculate sisa when keluar or kembali changes
    function calculateSisa() {
        const keluar = parseFloat($('#keluar').val()) || 0;
        const kembali = parseFloat($('#kembali').val()) || 0;
        const sisa = keluar - kembali;
        $('#sisa_display').val(sisa.toFixed(2));
    }

    $('#keluar, #kembali').on('input', function() {
        calculateSisa();
    });

    // Trigger inventory details display and sisa calculation on page load
    $('#inventory_id').trigger('change');
    calculateSisa();
});
</script>
@endsection
