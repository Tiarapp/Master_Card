@extends('admin.templates.partials.default')

<style>
.card {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    border: none;
}

.card-header {
    background-color: #f8f9fc;
    border-bottom: 1px solid #e3e6f0;
}

.table th {
    background-color: #f8f9fa;
    font-weight: 600;
    border-bottom: 2px solid #dee2e6;
}

.text-muted {
    color: #5a5c69 !important;
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

#bbk_number_display {
    font-weight: bold;
    color: #5a5c69;
    font-size: 18px;
    background-color: #f8f9fc;
    padding: 15px;
    border-radius: 0.375rem;
    border: 1px solid #d1d3e2;
    text-align: center;
}
</style>

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Detail BBK Roll Group</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('bbk-roll.index') }}">BBK Roll</a></li>
                        <li class="breadcrumb-item active">Detail Group</li>
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
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-eye me-2"></i>Detail BBK Roll Group
                            </h5>
                            <div>
                                <a href="{{ route('bbk-roll.edit-group', $bbkNumber) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit me-1"></i> Edit Group
                                </a>
                                <button type="button" class="btn btn-danger btn-sm" onclick="deleteGroup()">
                                    <i class="fas fa-trash me-1"></i> Hapus Group
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- BBK Number Display -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">BBK Number</label>
                                    <div id="bbk_number_display">{{ $bbkNumber }}</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal BBK</label>
                                    <div id="bbk_number_display">{{ \Carbon\Carbon::parse($bbkRolls->first()->tanggal_bbk)->format('d/m/Y') }}</div>
                                </div>
                            </div>

                            <!-- BBK Rolls Table -->
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
                                    <tbody>
                                        @foreach($bbkRolls as $index => $bbkRoll)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
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
                                                <span class="badge badge-warning">{{ number_format($bbkRoll->kembali, 2) }}</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-success">{{ number_format($bbkRoll->keluar - $bbkRoll->kembali, 2) }}</span>
                                            </td>
                                            <td>
                                                {{ $bbkRoll->opi ?: '-' }}
                                            </td>
                                            <td>
                                                {{ $bbkRoll->keterangan ?: '-' }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Total Summary -->
                            <div class="total-summary">
                                <h6><i class="fas fa-calculator me-2"></i>Ringkasan Total</h6>
                                <div class="total-item">
                                    <span>Total Keluar:</span>
                                    <span>{{ number_format($bbkRolls->sum('keluar'), 2) }}</span>
                                </div>
                                <div class="total-item">
                                    <span>Total Kembali:</span>
                                    <span>{{ number_format($bbkRolls->sum('kembali'), 2) }}</span>
                                </div>
                                <div class="total-item">
                                    <span>Total Sisa:</span>
                                    <span>{{ number_format($bbkRolls->sum('keluar') - $bbkRolls->sum('kembali'), 2) }}</span>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('bbk-roll.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
                                </a>
                                <div>
                                    <a href="{{ route('bbk-roll.edit-group', $bbkNumber) }}" class="btn btn-warning">
                                        <i class="fas fa-edit me-1"></i> Edit Group
                                    </a>
                                    <button type="button" class="btn btn-danger" onclick="deleteGroup()">
                                        <i class="fas fa-trash me-1"></i> Hapus Group
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<!-- Hidden form for delete -->
<form id="deleteForm" method="POST" action="{{ route('bbk-roll.destroy-group', $bbkNumber) }}" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@section('javascripts')
<script>
function deleteGroup() {
    if (confirm('Apakah Anda yakin ingin menghapus semua BBK Roll dengan nomor {{ $bbkNumber }}?')) {
        document.getElementById('deleteForm').submit();
    }
}
</script>
@endsection
