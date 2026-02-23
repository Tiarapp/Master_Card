@extends('admin.templates.partials.default')

<style>
    .card-header {
        background: linear-gradient(45deg, #007bff, #0056b3);
        color: white;
    }
    .btn-search-opi {
        background: #17a2b8;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 5px;
        transition: all 0.3s;
    }
    .btn-search-opi:hover {
        background: #138496;
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    .form-group label {
        font-weight: 600;
        color: #495057;
    }
    .selected-opis-table {
        overflow-x: auto;
        min-width: 100%;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        margin-top: 15px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .selected-opis-table table {
        min-width: 3600px;
        margin-bottom: 0;
        font-size: 13px;
    }
    .selected-opis-table th {
        background: linear-gradient(45deg, #007bff, #0056b3);
        color: white;
        position: sticky;
        top: 0;
        z-index: 10;
        vertical-align: middle;
        text-align: center;
        font-size: 12px;
        font-weight: 600;
        padding: 10px 6px;
        white-space: nowrap;
        border-bottom: 2px solid #0056b3;
        text-shadow: 0 1px 2px rgba(0,0,0,0.2);
    }
    .selected-opis-table td {
        vertical-align: middle;
        padding: 6px 4px;
        font-size: 12px;
        border-right: 1px solid #e9ecef;
    }
    .selected-opis-table input.form-control-sm {
        width: 70px !important;
        font-size: 12px;
        padding: 4px 6px;
        border: 1px solid #ced4da;
        border-radius: 4px;
    }
    .selected-opis-table .readonly-cell {
        background-color: #f8f9fa;
    }
    .selected-opis-table input[readonly] {
        background-color: #e9ecef !important;
        color: #495057 !important;
        cursor: default;
    }
    .selected-opis-table .roll-result,
    .selected-opis-table .plan-result,
    .selected-opis-table .cop-result,
    .selected-opis-table .rmorder-result {
        background-color: #e9ecef !important;
        color: #495057 !important;
        cursor: default;
        font-weight: bold;
    }
</style>

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Planning Corrugating</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.corrplan.index') }}">Plan Corrugating</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit"></i> Edit Planning Corrugating
                    </h3>
                </div>
                <form action="{{ route('admin.corrplan.update', $corrMaster->id) }}" method="POST" id="corrugatingForm">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Error!</strong> 
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Header Form -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Kode Planning</label>
                                    <input type="text" class="form-control" name="kodeplan" id="kodeplan" value="{{ $corrMaster->kode_plan }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tanggal Produksi</label>
                                    <input type="date" class="form-control" name="tgl" id="tgl" value="{{ $corrMaster->tgl }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Shift</label>
                                    <select class="form-control" name="shift" id="shift" required>
                                        <option value="">Pilih Shift</option>
                                        <option value="A" {{ $corrMaster->shift == 'A' ? 'selected' : '' }}>Shift A</option>
                                        <option value="B" {{ $corrMaster->shift == 'B' ? 'selected' : '' }}>Shift B</option>
                                        <option value="C" {{ $corrMaster->shift == 'C' ? 'selected' : '' }}>Shift C</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- OPI Search -->
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Tambah OPI</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-search-opi" id="findOpiBtn">
                                                <i class="fas fa-plus"></i> Add OPI
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Notes</label>
                                    <input type="text" class="form-control" name="notes" id="notes" value="{{ $corrMaster->notes }}" placeholder="Catatan planning">
                                </div>
                            </div>
                        </div>

                        <!-- OPI Selection Info -->
                        <div class="alert alert-info" id="opiSelectionInfo">
                            <h6><i class="fas fa-info-circle"></i> Petunjuk Edit Planning:</h6>
                            <ul class="mb-0">
                                <li>Klik tombol <strong>"Add OPI"</strong> untuk menambah OPI baru ke planning</li>
                                <li>Edit jumlah <strong>Out Corr</strong> dan <strong>Out Flexo</strong> sesuai kebutuhan</li>
                                <li>Untuk menghapus OPI dari planning, klik tombol <strong>"Hapus"</strong> pada item planning yang bersangkutan</li>
                                <li>Pastikan urutan planning sudah benar sebelum menyimpan</li>
                            </ul>
                        </div>

                        <!-- Planning Items -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h5><i class="fas fa-list"></i> Daftar Item Planning</h5>
                                <div class="table-responsive mt-3" style="overflow-x: auto;">
                                    <table class="table table-bordered table-striped table-nowrap" id="planningTable" style="min-width: 2000px;">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th style="min-width: 80px;">No</th>
                                                <th style="min-width: 100px;">No OPI</th>
                                                <th style="min-width: 110px;">DT</th>
                                                <th style="min-width: 110px;">DT Perubahan</th>
                                                <th style="min-width: 150px;">Customer</th>
                                                <th style="min-width: 200px;">Item</th>
                                                <th style="min-width: 80px;">MC</th>
                                                <th style="min-width: 250px;">P x L</th>
                                                <th style="min-width: 200px;">Tipe/Flute</th>
                                                <th style="min-width: 120px;">Order</th>
                                                <th style="min-width: 80px;">Out Corr</th>
                                                <th style="min-width: 80px;">Out Flexo</th>
                                                <th style="min-width: 80px;">Toleransi</th>
                                                <th style="min-width: 100px;">Berat/Pcs</th>
                                                <th style="min-width: 120px;">Roll</th>
                                                <th style="min-width: 120px;">Plan</th>
                                                <th style="min-width: 120px;">Trim</th>
                                                <th style="min-width: 120px;">Cop</th>
                                                <th style="min-width: 120px;">RM Order</th>
                                                <th style="min-width: 120px; background: #28a745; color: white;">Jenis Atas</th>
                                                <th style="min-width: 80px; background: #28a745; color: white;">Gram Atas</th>
                                                <th style="min-width: 90px; background: #28a745; color: white;">Kertas Atas (Kg)</th>
                                                <th style="min-width: 120px; background: #fd7e14; color: white;">Jenis Flute 1</th>
                                                <th style="min-width: 80px; background: #fd7e14; color: white;">Gram Flute 1</th>
                                                <th style="min-width: 90px; background: #fd7e14; color: white;">Flute 1 (Kg)</th>
                                                <th style="min-width: 120px; background: #20c997; color: white;">Jenis Tengah</th>
                                                <th style="min-width: 80px; background: #20c997; color: white;">Gram Tengah</th>
                                                <th style="min-width: 90px; background: #20c997; color: white;">Kertas Tengah (Kg)</th>
                                                <th style="min-width: 120px; background: #e83e8c; color: white;">Jenis Flute 2</th>
                                                <th style="min-width: 80px; background: #e83e8c; color: white;">Gram Flute 2</th>
                                                <th style="min-width: 90px; background: #e83e8c; color: white;">Flute 2 (Kg)</th>
                                                <th style="min-width: 120px; background: #6f42c1; color: white;">Jenis Bawah</th>
                                                <th style="min-width: 80px; background: #6f42c1; color: white;">Gram Bawah</th>
                                                <th style="min-width: 90px; background: #6f42c1; color: white;">Kertas Bawah (Kg)</th>
                                                <th style="min-width: 200px;">Keterangan</th>
                                                <th style="min-width: 100px;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="planningTableBody">
                                            @foreach($corrMaster->details as $index => $detail)
                                            <tr data-item-id="{{ $loop->iteration }}">
                                                <input type="hidden" name="detail_id[]" value="{{ $detail->id }}">
                                                <input type="hidden" name="opi_id[]" value="{{ $detail->opi_id }}">
                                                <input type="hidden" name="flute[]" value="{{ $detail->opi->mc->flute ?? '' }}">
                                                <td>
                                                    <input type="number" name="urutan[]" value="{{ $detail->urutan }}" class="form-control form-control-sm" required>
                                                </td>
                                                <td>{{ $detail->opi->noopi ?? $detail->opi->NoOPI ?? 'N/A' }}</td>
                                                <td>
                                                    <input type="date" class="form-control form-control-sm" name="dt[]" value="{{ $detail->opi->tglKirimDt ?? '' }}">
                                                </td>
                                                <td>
                                                    <input type="date" class="form-control form-control-sm" name="dtPerubahan[]" value="{{ $detail->opi->dt_perubahan ?? '' }}">
                                                </td>
                                                <td>{{ $detail->opi->Cust ?? $detail->opi->kontrakm->customer_name ?? 'N/A' }}</td>
                                                <td>{{ $detail->opi->namaBarang ?? $detail->opi->mc->namaBarang ?? 'N/A' }}</td>
                                                <td>{{ $detail->opi->mc->revisi === 'R0' ? $detail->opi->mc->kode : $detail->opi->mc->kode.'-'.$detail->opi->mc->revisi }}</td>
                                                <td>
                                                    <input type="number" class="form-control form-control-sm" name="sheetp[]" value="{{$detail->sheet_p ?? ''}}" step="0.01" style="width:100px;display:inline-block;" readonly>
                                                    <span class="mx-1">×</span>
                                                    <input type="number" class="form-control form-control-sm" name="sheetl[]" value="{{$detail->sheet_l ?? ''}}" step="0.01" style="width:100px;display:inline-block;" readonly>
                                                </td>
                                                <td>{{ ($detail->opi->mc->tipeBox ?? $detail->opi->tipeBox ?? 'N/A') . '/' . ($detail->opi->mc->flute ?? $detail->opi->flute ?? 'N/A') }}</td>
                                                <td>
                                                    <input type="number" name="order[]" value="{{ $detail->order_qty ?? 0 }}" class="form-control form-control-sm" required>
                                                </td>
                                                <td>
                                                    <input type="number" name="outCorr[]" value="{{ $detail->out_corr }}" class="form-control form-control-sm" step="0.001" required>
                                                </td>
                                                <td>
                                                    <input type="number" name="outFlexo[]" value="{{ $detail->out_flx }}" class="form-control form-control-sm" required>
                                                </td>
                                                <td>{{ $detail->opi->mc->tipeBox === 'B1' ? 1 : 0 }}%</td>
                                                <td>{{ number_format($detail->opi->gramSheet ?? $detail->opi->mc->gramSheetBoxProduksi ?? 0, 3) }}</td>
                                                <td>
                                                    <input type="number" class="form-control form-control-sm roll-result" name="roll[]" value="{{ $detail->lebar_roll }}">
                                                </td>
                                                <td><input type="number" class="form-control form-control-sm" name="sheetl[]" step="0.001" value="{{ $detail->plan_plus ?? 0 }}"></td>
                                                <td><input type="number" class="form-control form-control-sm" name="trim[]" step="0.001" value="{{ $detail->trim_waste }}"></td>
                                                <td><input type="number" class="form-control form-control-sm cop-result" name="cop[]" step="0.001" value="{{ $detail->cop_plus }}" readonly></td>
                                                <td><input type="number" class="form-control form-control-sm rmorder-result" name="rmorder[]" step="0.001" value="{{ $detail->rm_total }}" readonly></td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm" name="jenisAtas[]" value="{{ $detail->jenis_kertas1 ?? '' }}" readonly style="background: #d4edda; border-color: #28a745; font-size: 10px;" title="${getJenisKertas(opi, 'lineratas')}">
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control form-control-sm gramatas-input" name="gramAtas[]" value="{{ $detail->gram_kertas1 }}" step="1" style="width: 60px; background: #d4edda; border-color: #28a745;">
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control form-control-sm kebutuhan-result" name="kebutuhanAtas[]" value="{{ $detail->kebutuhan_kertas1 }}" readonly style="background: #d4edda; border-color: #28a745; font-weight: bold;">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm" name="jenisFlute1[]" value="{{ $detail->jenis_kertas2 ?? '' }}" readonly style="background: #ffeaa7; border-color: #fd7e14; font-size: 10px;" title="${getJenisKertas(opi, 'flute1')}">
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control form-control-sm gramflute1-input" name="gramFlute1[]" value="{{ $detail->gram_kertas2 }}" step="1" style="width: 60px; background: #ffeaa7; border-color: #fd7e14;">
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control form-control-sm kebutuhan-result" name="kebutuhanFlute1[]" value="{{ $detail->kebutuhan_kertas2 }}" readonly style="background: #ffeaa7; border-color: #fd7e14; font-weight: bold;">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm" name="jenisTengah[]" value="{{ $detail->jenis_kertas3 ?? '' }}" readonly style="background: #d1ecf1; border-color: #20c997; font-size: 10px;" title="${getJenisKertas(opi, 'linertengah')}">
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control form-control-sm gramtengah-input" name="gramTengah[]" value="{{ $detail->gram_kertas3 }}" step="1" style="width: 60px; background: #d1ecf1; border-color: #20c997;">
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control form-control-sm kebutuhan-result" name="kebutuhanTengah[]" value="{{ $detail->kebutuhan_kertas3 }}" readonly style="background: #d1ecf1; border-color: #20c997; font-weight: bold;">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm" name="jenisFlute2[]" value="{{ $detail->jenis_kertas4 ?? '' }}" readonly style="background: #f3e2f3; border-color: #e83e8c; font-size: 10px;" title="${getJenisKertas(opi, 'flute2')}">
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control form-control-sm gramflute2-input" name="gramFlute2[]" value="{{ $detail->gram_kertas4 }}" step="1" style="width: 60px; background: #f3e2f3; border-color: #e83e8c;">
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control form-control-sm kebutuhan-result" name="kebutuhanFlute2[]" value="{{ $detail->kebutuhan_kertas4 }}" readonly style="background: #f3e2f3; border-color: #e83e8c; font-weight: bold;">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm" name="jenisBawah[]" value="{{ $detail->jenis_kertas5 ?? '' }}" readonly style="background: #e2d9f3; border-color: #6f42c1; font-size: 10px;" title="${getJenisKertas(opi, 'linerbawah')}">
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control form-control-sm grambawah-input" name="gramBawah[]" value="{{ $detail->gram_kertas5 }}" step="1" style="width: 60px; background: #e2d9f3; border-color: #6f42c1;">
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control form-control-sm kebutuhan-result" name="kebutuhanBawah[]" value="{{ $detail->kebutuhan_kertas5 }}" readonly style="background: #e2d9f3; border-color: #6f42c1; font-weight: bold;">
                                                </td>
                                                <td><input type="text" class="form-control form-control-sm" name="keterangan[]" value="{{ $detail->keterangan ?? '' }}" placeholder="Keterangan"></td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm remove-planning-item">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- Detail Forms Container (Hidden) -->
                                <div id="planningDetails" style="display: none;">
                                    <!-- Detail forms will be added here -->
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Planning
                                </button>
                                <a href="{{ route('admin.corrplan.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<!-- Modal OPI Selection -->
<div class="modal fade" id="opiModal" tabindex="-1" role="dialog" aria-labelledby="opiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="opiModalLabel">
                    <i class="fas fa-search"></i> Pilih OPI
                    <span class="badge badge-light ml-2" id="selectedOpiCount">0 dipilih</span>
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Search Filter -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Search OPI:</label>
                            <input type="text" class="form-control" id="modalOpiSearch" placeholder="No OPI, Customer, atau Item">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Status:</label>
                            <select class="form-control" id="modalStatusFilter">
                                <option value="">Semua Status</option>
                                <option value="Proses" selected>Proses</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <button type="button" class="btn btn-primary form-control" id="searchOpiBtn">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <button type="button" class="btn btn-secondary form-control" id="resetOpiBtn">
                                <i class="fas fa-refresh"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>

                <!-- OPI Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="opiTable">
                        <thead class="thead-dark">
                            <tr>
                                <th width="5%">Aksi</th>
                                <th width="10%">No OPI</th>
                                <th width="20%">Customer</th>
                                <th width="25%">Item</th>
                                <th width="10%">MC Kode</th>
                                <th width="10%">Tipe Box</th>
                                <th width="5%">Flute</th>
                                <th width="10%">Order</th>
                                <th width="5%">Status</th>
                            </tr>
                        </thead>
                        <tbody id="opiTableBody">
                            <!-- Data will be loaded via AJAX -->
                        </tbody>
                    </table>
                </div>

                <!-- Loading State -->
                <div id="opiLoading" class="text-center py-4" style="display: none;">
                    <i class="fas fa-spinner fa-spin fa-2x"></i>
                    <p class="mt-2">Loading data OPI...</p>
                </div>

                <!-- No Data State -->
                <div id="opiNoData" class="text-center py-4" style="display: none;">
                    <i class="fas fa-inbox fa-2x text-muted"></i>
                    <p class="mt-2 text-muted">Tidak ada data OPI ditemukan</p>
                </div>

                <!-- Pagination -->
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div id="opiInfo"></div>
                    </div>
                    <div class="col-md-6">
                        <nav aria-label="OPI pagination">
                            <ul class="pagination pagination-sm justify-content-end" id="opiPagination">
                                <!-- Pagination will be generated via JavaScript -->
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascripts')
<script type="text/javascript">
$(document).ready(function(){
    let itemCounter = {{ $corrMaster->details->count() }}; // Start from existing items count
    let currentopi = null;
    let selectedOpis = []; // Track selected OPI IDs

    function getJenisKertas(opiData, layer) {
        try {
            const substance = opiData?.mc?.substanceproduksi;
            if (!substance || !substance[layer]) {
                console.log(`No substance data for layer: ${layer}`);
                return '';
            }
            
            // Try multiple possible field names
            const layerData = substance[layer];
            let jenisKertas = '';
            
            // Check direct fields first
            if (layerData.jenisKertasMc) {
                jenisKertas = layerData.jenisKertasMc;
            } else if (layerData.jenis_gram) {
                jenisKertas = layerData.jenis_gram;
            } else if (layerData.jenisKertasLog) {
                jenisKertas = layerData.jenisKertasLog;
            }
            
            console.log(`Found jenis kertas for ${layer}:`, jenisKertas);
            return jenisKertas ? jenisKertas.substring(0, 15) : '';
        } catch (e) {
            console.error(`Error getting jenis kertas for ${layer}:`, e);
            return '';
        }
    }

    function getGramKertas(opiData, layer) {
        try {
            const substance = opiData?.mc?.substanceproduksi;
            if (!substance || !substance[layer]) {
                console.log(`No substance data for layer: ${layer}`);
                return '';
            }
            
            // Try multiple possible field names
            const layerData = substance[layer];
            let gram = '';
            
            // Check direct fields first
            if (layerData.gramKertas) {
                gram = layerData.gramKertas;
            } else if (layerData.gram) {
                gram = layerData.gram;
            } else if (layerData.gramKertas) {
                gram = layerData.gramKertas;
            }
            
            console.log(`Found gram for ${layer}:`, gram);
            return gram || '';
        } catch (e) {
            console.error(`Error getting gram kertas for ${layer}:`, e);
            return '';
        }
    }
    
    // Initialize selected OPIs from existing data
    @foreach($corrMaster->details as $detail)
        selectedOpis.push({{ $detail->opi_id }});
    @endforeach

    // Open OPI Modal
    $('#findOpiBtn').on('click', function() {
        $('#opiModal').modal('show');
        loadopi();
    });

    // Variables for pagination
    let currentPage = 1;
    let totalPages = 1;

    // Load OPI data from API
    function loadopi(page = 1, search = '', status = 'Proses') {
        $('#opiLoading').show();
        $('#opiTable').hide();
        $('#opiNoData').hide();
        
        // Build API URL with parameters
        const apiUrl = '/admin/opi/json-paginated';
        const params = new URLSearchParams({
            page: page,
            per_page: 10,
            search: search,
            status: status,
            plan_corr: 0  // Only show OPI that haven't been planned for corrugated
        });
        
        console.log('Loading OPI data with params:', Object.fromEntries(params));
        
        $.ajax({
            url: `${apiUrl}?${params.toString()}`,
            method: 'GET',
            success: function(response) {
                console.log('OPI API Response:', response);
                
                if (response.success && response.data && response.data.length > 0) {
                    populateOpiTable(response.data);
                    updatePaginationFromResponse(response.pagination);
                    $('#opiTable').show();
                } else {
                    $('#opiNoData').show();
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading OPI data:', error);
                $('#opiNoData').show();
            },
            complete: function() {
                $('#opiLoading').hide();
            }
        });
    }

    // Populate OPI table with data
    function populateOpiTable(data) {
        let tableRows = '';
        
        data.forEach(function(opi) {
            const isSelected = selectedOpis.includes(opi.opiid || opi.id);
            const statusText = opi.status === 'Proses' ? 'Proses' : 'Selesai';
            const statusBadge = opi.status === 'Proses' ? 'warning' : 'success';
            const buttonText = isSelected ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-check"></i>';
            const buttonClass = isSelected ? 'btn-secondary' : 'btn-success';
            const buttonDisabled = isSelected ? 'disabled' : '';
            
            tableRows += `
                <tr>
                    <td>
                        <button type="button" class="btn ${buttonClass} btn-sm select-opi-btn" 
                                data-opi-id="${opi.opiid || opi.id}" ${buttonDisabled}>
                            ${buttonText}
                        </button>
                    </td>
                    <td>${opi.noopi || opi.NoOPI || '-'}</td>
                    <td>${opi.Cust || '-'}</td>
                    <td>${opi.namaBarang || '-'}</td>
                    <td>${opi.kode || '-'}</td>
                    <td>${opi.tipeBox || '-'}</td>
                    <td>${opi.flute || '-'}</td>
                    <td>${Number(opi.jumlahOrder).toLocaleString() || '-'}</td>
                    <td>
                        <span class="badge badge-${statusBadge}">
                            ${statusText}
                        </span>
                    </td>
                </tr>
            `;
        });
        
        $('#opiTableBody').html(tableRows);
        console.log('OPI table populated with', data.length, 'rows');
    }

    // Update pagination from API response
    function updatePaginationFromResponse(pagination) {
        currentPage = pagination.current_page;
        totalPages = pagination.total_pages;
        
        // Update info
        $('#opiInfo').html(`Showing ${pagination.from} to ${pagination.to} of ${pagination.total} entries`);
        
        // Generate pagination
        let paginationHtml = '';
        
        // Previous button
        paginationHtml += `
            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${currentPage - 1}">&laquo;</a>
            </li>
        `;
        
        // Page numbers
        const startPage = Math.max(1, currentPage - 2);
        const endPage = Math.min(totalPages, currentPage + 2);
        
        for (let i = startPage; i <= endPage; i++) {
            paginationHtml += `
                <li class="page-item ${i === currentPage ? 'active' : ''}">
                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                </li>
            `;
        }
        
        // Next button
        paginationHtml += `
            <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${currentPage + 1}">&raquo;</a>
            </li>
        `;
        
        $('#opiPagination').html(paginationHtml);
    }

    // Pagination click handler
    $(document).on('click', '#opiPagination .page-link', function(e) {
        e.preventDefault();
        const page = parseInt($(this).data('page'));
        if (page && page !== currentPage && page > 0 && page <= totalPages) {
            loadopi(page, $('#modalOpiSearch').val(), $('#modalStatusFilter').val());
        }
    });

    // Search functionality
    $('#searchOpiBtn').on('click', function() {
        loadopi(1, $('#modalOpiSearch').val(), $('#modalStatusFilter').val());
    });

    $('#resetOpiBtn').on('click', function() {
        $('#modalOpiSearch').val('');
        $('#modalStatusFilter').val('Proses');
        loadopi(1, '', 'Proses');
    });

    // Select OPI from modal
    $(document).on('click', '.select-opi-btn', function() {
        const opiId = parseInt($(this).data('opi-id'));
        
        // Check if already selected
        if (selectedOpis.includes(opiId)) {
            return;
        }
        
        // Show loading on button
        $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        
        // Get single OPI data
        $.ajax({
            url: `/admin/opi/single/${opiId}`,
            method: 'GET',
            success: function(data) {
                console.log('OPI Data received:', data);
                
                // Add to planning directly
                addPlanningItem(data);
                
                // Add to selected list
                selectedOpis.push(opiId);
                
                // Update button state
                $(`.select-opi-btn[data-opi-id="${opiId}"]`)
                    .removeClass('btn-success')
                    .addClass('btn-secondary')
                    .html('<i class="fas fa-check-circle"></i>')
                    .prop('disabled', true);
                
                // Update selected count
                $('#selectedOpiCount').text(`${selectedOpis.length} dipilih`);
                
                console.log('OPI added to planning:', data);
            },
            error: function(xhr, status, error) {
                console.error('Error loading OPI data:', error);
                $(this).prop('disabled', false).html('<i class="fas fa-check"></i>');
            }
        });
    });

    // Add planning item to table
    function addPlanningItem(opi) {
        itemCounter++;
        
        let toleransi = 0;
        if (opi.mc?.tipeBox === 'B1') {
            toleransi = 1;
        } else {
            toleransi = 0;
        }
        
        // Get paper data from OPI using eager loaded relations
        const kertasAtas = opi.mc?.substanceproduksi?.lineratas?.jenisKertasMc || '';
        const kertasFlute1 = opi.mc?.substanceproduksi?.flute1?.jenisKertasMc || '';
        const kertasTengah = opi.mc?.substanceproduksi?.linertengah?.jenisKertasMc || '';
        const kertasFlute2 = opi.mc?.substanceproduksi?.flute2?.jenisKertasMc || '';
        const kertasBawah = opi.mc?.substanceproduksi?.linerbawah?.jenisKertasMc || '';
        
        // Get gram data from OPI using eager loaded relations
        const gramAtas = opi.mc?.substanceproduksi?.lineratas?.gramKertas || '';
        const gramFlute1 = opi.mc?.substanceproduksi?.flute1?.gramKertas || '';
        const gramTengah = opi.mc?.substanceproduksi?.linertengah?.gramKertas || '';
        const gramFlute2 = opi.mc?.substanceproduksi?.flute2?.gramKertas || '';
        const gramBawah = opi.mc?.substanceproduksi?.linerbawah?.gramKertas || '';
        
        const newRow = `
            <tr id="planRow${itemCounter}" data-opi-id="${opi.id}">
                <td>
                    <input type="hidden" name="opi_id[]" value="${opi.id}">
                    <input type="hidden" name="mc_id[]" value="${opi.mc?.id || ''}">
                    <input type="text" name="flute[]" value="${opi.mc?.flute || ''}">
                    <input type="number" class="form-control form-control-sm" name="urutan[]" value="${itemCounter}" required>
                </td>
                <td>${opi.NoOPI || '-'}</td>
                <td>
                    <input type="date" class="form-control form-control-sm" name="dt[]" value="${opi.dt?.tglKirimDt || ''}">
                </td>
                <td>
                    <input type="date" class="form-control form-control-sm" name="dtperubahan[]">
                </td>
                <td title="${opi.kontrakm?.customer_name || '-'}">${opi.kontrakm?.customer_name || '-'}</td>
                <td title="${opi.mc?.namaBarang || '-'}">${opi.mc?.namaBarang || '-'}</td>
                <td>${opi.mc?.kode || '-'}</td>
                <td>
                    <input type="number" class="form-control form-control-sm" name="sheetp[]" value="${opi.mc?.panjangSheet || ''}" step="0.01" style="width:100px;display:inline-block;">
                    <span class="mx-1">×</span>
                    <input type="number" class="form-control form-control-sm" name="sheetl[]" value="${opi.mc?.lebarSheet || ''}" step="0.01" style="width:100px;display:inline-block;">
                </td>
                <td>
                    ${opi.mc?.tipeBox || ''} / ${opi.mc?.flute || ''}
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm order-input" name="order[]" value="${opi.jumlahOrder || ''}">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm outcorr-input" name="outCorr[]" required>
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm outflexo-input" name="outFlexo[]" value="${opi.mc?.outConv || ''}" required>
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm toleransi-input" name="toleransi[]" value="${toleransi}" step="0.1">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm beratsheet-input" name="beratSheet[]" value="${opi.mc?.gramSheetBoxProduksi || ''}" step="0.01">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm roll-result" name="roll[]" readonly>
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm plan-result" name="plan[]" readonly step="0.01">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm trim-result" name="trim[]" readonly step="0.01">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm cop-result" name="cop[]" readonly step="0.01">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm rmorder-result" name="rmorder[]" readonly>
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" name="jenisAtas[]" value="${getJenisKertas(opi, 'lineratas')}" readonly style="background: #d4edda; border-color: #28a745; font-size: 10px;" title="${getJenisKertas(opi, 'lineratas')}">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm gramatas-input" name="gramAtas[]" value="${getGramKertas(opi, 'lineratas')}" step="1" style="width: 60px; background: #d4edda; border-color: #28a745;">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm kebutuhan-result" name="kebutuhanAtas[]" readonly style="background: #d4edda; border-color: #28a745; font-weight: bold;">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" name="jenisFlute1[]" value="${getJenisKertas(opi, 'flute1')}" readonly style="background: #ffeaa7; border-color: #fd7e14; font-size: 10px;" title="${getJenisKertas(opi, 'flute1')}">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm gramflute1-input" name="gramFlute1[]" value="${getGramKertas(opi, 'flute1')}" step="1" style="width: 60px; background: #ffeaa7; border-color: #fd7e14;">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm kebutuhan-result" name="kebutuhanFlute1[]" readonly style="background: #ffeaa7; border-color: #fd7e14; font-weight: bold;">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" name="jenisTengah[]" value="${getJenisKertas(opi, 'linertengah')}" readonly style="background: #d1ecf1; border-color: #20c997; font-size: 10px;" title="${getJenisKertas(opi, 'linertengah')}">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm gramtengah-input" name="gramTengah[]" value="${getGramKertas(opi, 'linertengah')}" step="1" style="width: 60px; background: #d1ecf1; border-color: #20c997;">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm kebutuhan-result" name="kebutuhanTengah[]" readonly style="background: #d1ecf1; border-color: #20c997; font-weight: bold;">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" name="jenisFlute2[]" value="${getJenisKertas(opi, 'flute2')}" readonly style="background: #f3e2f3; border-color: #e83e8c; font-size: 10px;" title="${getJenisKertas(opi, 'flute2')}">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm gramflute2-input" name="gramFlute2[]" value="${getGramKertas(opi, 'flute2')}" step="1" style="width: 60px; background: #f3e2f3; border-color: #e83e8c;">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm kebutuhan-result" name="kebutuhanFlute2[]" readonly style="background: #f3e2f3; border-color: #e83e8c; font-weight: bold;">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" name="jenisBawah[]" value="${getJenisKertas(opi, 'linerbawah')}" readonly style="background: #e2d9f3; border-color: #6f42c1; font-size: 10px;" title="${getJenisKertas(opi, 'linerbawah')}">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm grambawah-input" name="gramBawah[]" value="${getGramKertas(opi, 'linerbawah')}" step="1" style="width: 60px; background: #e2d9f3; border-color: #6f42c1;">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm kebutuhan-result" name="kebutuhanBawah[]" readonly style="background: #e2d9f3; border-color: #6f42c1; font-weight: bold;">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" name="keterangan[]" placeholder="Catatan">
                </td>
                <td>
                    <div class="btn-group">
                        <button type="button" class="btn btn-danger btn-sm remove-planning-item">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </div>
                </td>
            </tr>
        `;
        
        $('#planningTableBody').append(newRow);
        $('#planningTable').show();
    }

    // Remove planning item
    $(document).on('click', '.remove-planning-item', function() {
        const row = $(this).closest('tr');
        const opiId = parseInt(row.find('input[name="opi_id[]"]').val());
        
        // Remove from selected list
        const index = selectedOpis.indexOf(opiId);
        if (index > -1) {
            selectedOpis.splice(index, 1);
        }
        
        // Update button state in modal if exists
        $(`.select-opi-btn[data-opi-id="${opiId}"]`)
            .removeClass('btn-secondary')
            .addClass('btn-success')
            .html('<i class="fas fa-check"></i>')
            .prop('disabled', false);
        
        // Remove the row
        row.remove();
        
        // Update selected count
        $('#selectedOpiCount').text(`${selectedOpis.length} dipilih`);
        
        // Hide table if no items
        if ($('#planningTableBody tr').length === 0) {
            $('#planningTable').hide();
        }
    });

    // Auto-generate planning code when date or shift changes
    $('#tgl, #shift').on('change', function() {
        generatePlanningCode();
    });

    function generatePlanningCode() {
        const tgl = $('#tgl').val();
        const shift = $('#shift').val();
        
        if (tgl && shift) {
            const date = new Date(tgl);
            const year = date.getFullYear().toString().substr(-2);
            const month = ('0' + (date.getMonth() + 1)).slice(-2);
            const day = ('0' + date.getDate()).slice(-2);
            
            const code = `CORR${year}${month}${day}${shift}`;
            $('#kodeplan').val(code);
        }
    }

    // Auto calculate when Out Corr or other key fields change
    $(document).on('input change', 'input[name="outCorr[]"], input[name="jumlahOrder[]"], input[name="outFlexo[]"]', function() {
        const row = $(this).closest('tr');
        const outCorr = parseFloat(row.find('input[name="outCorr[]"]').val());
        if (outCorr && outCorr > 0) {
            calculateRowRequirements(row);
        }
    });

    // Auto calculate when sheet dimensions change
    $(document).on('input change', 'input[name="sheetp[]"], input[name="sheetl[]"], input[name="trim[]"]', function() {
        const row = $(this).closest('tr');
        const outCorr = parseFloat(row.find('input[name="outCorr[]"]').val());
        if (outCorr && outCorr > 0) {
            calculateRowRequirements(row);
        }
    });

    // Auto calculate when gram inputs change (affects paper requirements)
    $(document).on('input change', 'input[name="kertas_atas[]"], input[name="kertas_flute1[]"], input[name="kertas_tengah[]"], input[name="kertas_flute2[]"], input[name="kertas_bawah[]"]', function() {
        const row = $(this).closest('tr');
        const outCorr = parseFloat(row.find('input[name="outCorr[]"]').val());
        if (outCorr && outCorr > 0) {
            calculateRowRequirements(row);
        }
    });

    // Calculate individual row requirements
    function calculateRowRequirements(row) {
        // const row = $(`#planRow${itemId}`);
        const outCorr = parseFloat(row.find('input[name="outCorr[]"]').val()) || 0;
        const sheetl = parseFloat(row.find('input[name="sheetl[]"]').val()) || 0;
        const sheetp = parseFloat(row.find('input[name="sheetp[]"]').val()) || 0;
        const outFlexo = parseFloat(row.find('input[name="outFlexo[]"]').val()) || 0;
        const order = parseFloat(row.find('input[name="order[]"]').val()) || 0;
        const toleransi = parseFloat(row.find('input[name="toleransi[]"]').val()) || 0;
        const beratSheet = parseFloat(row.find('input[name="beratSheet[]"]').val()) || 0;
        const tipebox = row.find('input[name="tipebox[]"]').val();
        const flute = row.find('input[name="flute[]"]').val();
        

        // Calculate UkRoll
        let UkRoll;
        if (tipebox === 'DC') {
            UkRoll = Math.ceil(((outCorr * sheetl) + 20) / 50) * 50;
        } else {
            UkRoll = Math.ceil(((outCorr * sheetl) + 30) / 50) * 50;
        }

        let flute1, flute2;

        if(flute == 'BF'){
            flute1 = 1.36;
            flute2 = 0;
        } else if(flute == 'CF'){
            flute1 = 0;
            flute2 = 1.46;
        } else if (flute == 'BCF') {
            flute1 = 1.36;
            flute2 = 1.46;  
        } else if (flute == 'EF') {
            flute1 = 1.2;
            flute2 = 0;
        } else if (flute == 'EBF') {
            flute1 = 1.46;
            flute2 = 1.2;
        } else if (flute == 'EF') {
            flute1 = 1.2;
            flute2 = 0;
        }

        // Calculate other values
        const qtyPlan = (order + (order * (toleransi / 100))) / outFlexo;
        const cop = qtyPlan / outCorr;
        const trim = (UkRoll - (sheetl * outCorr));
        const rmorder = (sheetp * cop) / 1000;
        const tonase = qtyPlan * beratSheet / 1000; // Convert to kg

        console.log(qtyPlan, cop, trim, rmorder, tonase);
        

        // Calculate paper requirements
        const gramAtas = parseFloat(row.find('input[name="gramAtas[]"]').val()) || 0;
        const gramFlute1 = parseFloat(row.find('input[name="gramFlute1[]"]').val()) || 0;
        const gramTengah = parseFloat(row.find('input[name="gramTengah[]"]').val()) || 0;
        const gramFlute2 = parseFloat(row.find('input[name="gramFlute2[]"]').val()) || 0;
        const gramBawah = parseFloat(row.find('input[name="gramBawah[]"]').val()) || 0;

        

        // Calculate kebutuhan kertas (paper requirements in kg)
        let kebutuhanAtas = 0, kebutuhanFlute1 = 0, kebutuhanTengah = 0, kebutuhanFlute2 = 0, kebutuhanBawah = 0;
        
        if (gramAtas > 0) {
            kebutuhanAtas = rmorder * (UkRoll / 1000) * gramAtas / 1000;
        }
        if (gramFlute1 > 0) {
            kebutuhanFlute1 =  rmorder * (UkRoll / 1000) * (gramFlute1 / 1000) * flute1; // Flute factor

            console.log(kebutuhanFlute1);
        }
        if (gramTengah > 0) {
            kebutuhanTengah = rmorder * (UkRoll / 1000) * gramTengah / 1000;
        }
        if (gramFlute2 > 0) {
            kebutuhanFlute2 = rmorder * (UkRoll / 1000) * (gramFlute2 / 1000) * flute2; // Flute factor
        }
        if (gramBawah > 0) {
            kebutuhanBawah = rmorder * (UkRoll / 1000) * gramBawah / 1000;
        }

        // Update calculated fields in table
        row.find('input[name="roll[]"]').val(UkRoll);
        row.find('input[name="plan[]"]').val(qtyPlan.toFixed(0));
        row.find('input[name="cop[]"]').val(cop.toFixed(0));
        row.find('input[name="rmorder[]"]').val(Math.round(rmorder));
        
        // Also update detail fields if they exist
        row.find('input[name="trim[]"]').val(trim.toFixed(0));
        
        // Update paper requirements
        row.find('input[name="kebutuhanAtas[]"]').val(Math.round(kebutuhanAtas));
        row.find('input[name="kebutuhanFlute1[]"]').val(Math.round(kebutuhanFlute1));
        row.find('input[name="kebutuhanTengah[]"]').val(Math.round(kebutuhanTengah));
        row.find('input[name="kebutuhanFlute2[]"]').val(Math.round(kebutuhanFlute2));
        row.find('input[name="kebutuhanBawah[]"]').val(Math.round(kebutuhanBawah));
    }

    // Form validation and submission
    $('#corrugatingForm').on('submit', function(e) {
        if (!$('#tgl').val()) {
            alert('Tanggal produksi harus diisi');
            e.preventDefault();
            return false;
        }
        
        if (!$('#shift').val()) {
            alert('Shift harus dipilih');
            e.preventDefault();
            return false;
        }
        
        if ($('#planningTableBody tr').length === 0) {
            alert('Minimal harus ada 1 item planning');
            e.preventDefault();
            return false;
        }

        // Show loading
        $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Updating...');
        
        return true; // Allow form submission
    });
});
</script>
@endsection