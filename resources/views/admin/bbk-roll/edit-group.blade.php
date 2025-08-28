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
                                        <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="20%">Inventory</th>
                                                <th width="15%">Details</th>
                                                <th width="10%">Keluar</th>
                                                <th width="10%">Kembali</th>
                                                <th width="10%">Sisa</th>
                                                <th width="15%">OPI</th>
                                                <th width="15%">Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody id="inventoryTableBody">
                                            @foreach($bbkRolls as $index => $bbkRoll)
                                            <tr data-row="{{ $index }}" data-bbk-roll-id="{{ $bbkRoll->id }}">
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <input type="hidden" name="bbk_roll_ids[]" value="{{ $bbkRoll->id }}">
                                                    <strong>{{ $bbkRoll->inventory->kode_internal }}</strong><br>
                                                    <small class="text-muted">{{ $bbkRoll->inventory->kode_roll }}</small>
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
                                                           step="0.01">
                                                </td>
                                                <td>
                                                    <input type="text" 
                                                           class="form-control form-control-sm sisa-display" 
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
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Remove Add New Inventory Button Section -->

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
@endsection

@section('javascripts')
<script>
$(document).ready(function() {
    // Calculate sisa for existing rows
    function calculateSisa(row) {
        const keluarText = row.find('td:nth-child(4) .badge').text().replace(/,/g, '');
        const keluar = parseFloat(keluarText) || 0;
        const kembali = parseFloat(row.find('.kembali-input').val()) || 0;
        const sisa = keluar - kembali;
        row.find('.sisa-display').val(sisa.toFixed(2));
    }

    // Bind calculation for existing rows
    $(document).on('input', '.kembali-input', function() {
        const row = $(this).closest('tr');
        calculateSisa(row);
        calculateTotals();
    });

    // Calculate totals
    function calculateTotals() {
        let totalKeluar = 0;
        let totalKembali = 0;
        let totalSisa = 0;

        $('#inventoryTableBody tr').each(function() {
            const keluarText = $(this).find('td:nth-child(4) .badge').text().replace(/,/g, '');
            const keluar = parseFloat(keluarText) || 0;
            const kembali = parseFloat($(this).find('.kembali-input').val()) || 0;
            const sisa = keluar - kembali;

            totalKeluar += keluar;
            totalKembali += kembali;
            totalSisa += sisa;
        });

        $('#totalKeluar').text(totalKeluar.toFixed(2));
        $('#totalKembali').text(totalKembali.toFixed(2));
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
    });

    // Initialize calculations
    calculateTotals();
});
</script>
@endsection
