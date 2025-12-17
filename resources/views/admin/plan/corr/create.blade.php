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
    .opi-result {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 15px;
        margin-top: 15px;
        display: none;
    }
    .opi-result.show {
        display: block;
        animation: fadeIn 0.3s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
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
    /* Specific column widths */
    .selected-opis-table th:nth-child(1) { min-width: 60px; } /* No */
    .selected-opis-table th:nth-child(2) { min-width: 110px; } /* OPI */
    .selected-opis-table th:nth-child(3) { min-width: 130px; } /* Tgl Kirim */
    .selected-opis-table th:nth-child(4) { min-width: 130px; } /* Tgl Perubahan */
    .selected-opis-table th:nth-child(5) { min-width: 160px; } /* Customer */
    .selected-opis-table th:nth-child(6) { min-width: 220px; } /* Nama Barang */
    .selected-opis-table th:nth-child(7) { min-width: 90px; } /* Kode */
    .selected-opis-table th:nth-child(8) { min-width: 130px; } /* Sheet */
    .selected-opis-table th:nth-child(9) { min-width: 100px; } /* Tipe/Flute */
    .selected-opis-table th:nth-child(10) { min-width: 90px; } /* Order */
    .selected-opis-table th:nth-child(11) { min-width: 80px; } /* Out Corr */
    .selected-opis-table th:nth-child(12) { min-width: 80px; } /* Out Flexo */
    .selected-opis-table th:nth-child(13) { min-width: 80px; } /* Toleransi */
    .selected-opis-table th:nth-child(14) { min-width: 90px; } /* Berat Sheet */
    .selected-opis-table th:nth-child(15) { min-width: 70px; } /* Roll */
    .selected-opis-table th:nth-child(16) { min-width: 80px; } /* Plan */
    .selected-opis-table th:nth-child(17) { min-width: 70px; } /* Cop */
    .selected-opis-table th:nth-child(18) { min-width: 90px; } /* RM Order */
    .selected-opis-table th:nth-child(19) { min-width: 120px; } /* Jenis Atas */
    .selected-opis-table th:nth-child(20) { min-width: 80px; } /* Gram Atas */
    .selected-opis-table th:nth-child(21) { min-width: 90px; } /* Kertas Atas */
    .selected-opis-table th:nth-child(22) { min-width: 120px; } /* Jenis Flute 1 */
    .selected-opis-table th:nth-child(23) { min-width: 80px; } /* Gram Flute 1 */
    .selected-opis-table th:nth-child(24) { min-width: 90px; } /* Flute 1 */
    .selected-opis-table th:nth-child(25) { min-width: 120px; } /* Jenis Tengah */
    .selected-opis-table th:nth-child(26) { min-width: 80px; } /* Gram Tengah */
    .selected-opis-table th:nth-child(27) { min-width: 90px; } /* Kertas Tengah */
    .selected-opis-table th:nth-child(28) { min-width: 120px; } /* Jenis Flute 2 */
    .selected-opis-table th:nth-child(29) { min-width: 80px; } /* Gram Flute 2 */
    .selected-opis-table th:nth-child(30) { min-width: 90px; } /* Flute 2 */
    .selected-opis-table th:nth-child(31) { min-width: 120px; } /* Jenis Bawah */
    .selected-opis-table th:nth-child(32) { min-width: 80px; } /* Gram Bawah */
    .selected-opis-table th:nth-child(33) { min-width: 90px; } /* Kertas Bawah */
    .selected-opis-table th:nth-child(34) { min-width: 140px; } /* Keterangan */
    .selected-opis-table th:nth-child(35) { min-width: 90px; } /* Action */
    
    /* Styling khusus untuk kolom kebutuhan kertas */
    .selected-opis-table .kebutuhan-result {
        font-weight: 600;
        text-align: center;
        color: #333;
    }
    
    /* Hover effects */
    .selected-opis-table tr:hover {
        background-color: #f8f9fa;
    }
    
    /* Better spacing */
    .selected-opis-table input.form-control-sm[readonly] {
        cursor: default;
        font-weight: 600;
    }
    
    /* Paper type styling */
    .selected-opis-table input[name*="jenis"] {
        font-size: 10px !important;
        font-weight: 500;
        color: #495057 !important;
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
    }
    
    /* Gram input styling */
    .selected-opis-table .gramatas-input,
    .selected-opis-table .gramflute1-input,
    .selected-opis-table .gramtengah-input,
    .selected-opis-table .gramflute2-input,
    .selected-opis-table .grambawah-input {
        font-weight: 600;
        text-align: center;
    }
    
    /* Responsive adjustments */
    @media (max-width: 1200px) {
        .selected-opis-table {
            font-size: 11px;
        }
        .selected-opis-table input.form-control-sm {
            width: 60px !important;
            font-size: 11px;
            padding: 2px 4px;
        }
    }
    
    /* Scrollbar styling */
    .selected-opis-table::-webkit-scrollbar {
        height: 8px;
    }
    .selected-opis-table::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    .selected-opis-table::-webkit-scrollbar-thumb {
        background: linear-gradient(45deg, #007bff, #0056b3);
        border-radius: 4px;
    }
    .selected-opis-table::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(45deg, #0056b3, #004085);
    }
</style>

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Planning Corrugating</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('indexcorr') }}">Plan Corrugating</a></li>
                        <li class="breadcrumb-item active">Create</li>
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
                        <i class="fas fa-plus"></i> Buat Planning Corrugating Baru
                    </h3>
                </div>
                <form action="#" method="POST" id="corrugatingForm">
                    @csrf
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
                                    <input type="text" class="form-control" name="kodeplan" id="kodeplan" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tanggal Produksi</label>
                                    <input type="date" class="form-control" name="tgl" id="tgl" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Shift</label>
                                    <select class="form-control" name="shift" id="shift" required>
                                        <option value="">Pilih Shift</option>
                                        <option value="1">Shift 1</option>
                                        <option value="2">Shift 2</option>
                                        <option value="3">Shift 3</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- OPI Search -->
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Cari OPI</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-search-opi" id="findOpiBtn">
                                                <i class="fas fa-search"></i> Find OPI
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Notes</label>
                                    <input type="text" class="form-control" name="notes" id="notes" placeholder="Catatan planning">
                                </div>
                            </div>
                        </div>

                        <!-- OPI Selection Info -->
                        <div class="alert alert-info" id="opiSelectionInfo" style="display: none;">
                            <h6><i class="fas fa-info-circle"></i> Petunjuk Pemilihan OPI:</h6>
                            <ul class="mb-0">
                                <li>Klik tombol <strong>"Find OPI"</strong> untuk membuka modal pemilihan OPI</li>
                                <li>Pilih beberapa OPI dengan mengklik tombol <i class="fas fa-check text-success"></i> pada setiap OPI yang diinginkan</li>
                                <li>OPI yang sudah dipilih akan ditandai dengan <i class="fas fa-check-circle text-secondary"></i> dan tidak dapat dipilih lagi</li>
                                <li>Untuk menghapus OPI dari planning, klik tombol <strong>"Hapus"</strong> pada item planning yang bersangkutan</li>
                            </ul>
                        </div>

                        <!-- Planning Items -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h5><i class="fas fa-list"></i> Daftar Item Planning</h5>
                                <div class="table-responsive mt-3" style="overflow-x: auto;">
                                    <table class="table table-bordered table-striped table-nowrap" id="planningTable" style="display: none; min-width: 2000px;">
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
                                            <!-- Planning items will be added here -->
                                        </tbody>
                                    </table>
                                </div>
                                <div id="noPlanningMessage" class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted"></i>
                                    <p class="mt-2 text-muted">Belum ada OPI yang dipilih untuk planning</p>
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
                                    <i class="fas fa-save"></i> Simpan Planning
                                </button>
                                <a href="{{ route('indexcorr') }}" class="btn btn-secondary">
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
    let itemCounter = 0;
    let currentOpiData = null;
    let selectedOpis = []; // Track selected OPI IDs

    // Helper functions untuk mengambil data kertas
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

    // Show OPI selection info on page load
    $('#opiSelectionInfo').show();

    // Generate kode planning from date
    $('#tgl').on('change', function() {
        const tgl = new Date(this.value);
        const year = tgl.getFullYear();
        const month = String(tgl.getMonth() + 1).padStart(2, '0');
        const day = String(tgl.getDate()).padStart(2, '0');
        $('#kodeplan').val(day + month + year);
    });

    // OPI Modal variables
    let currentPage = 1;
    let totalPages = 1;
    let opiData = [];

    // Open OPI Modal
    $('#findOpiBtn').on('click', function(e) {
        e.preventDefault();
        console.log('Find OPI button clicked');
        
        // Show modal first
        $('#opiModal').modal('show');
        
        // Load data after modal is shown
        setTimeout(function() {
            loadOpiData(1);
        }, 300);
    });

    // Search OPI in modal
    $('#searchOpiBtn').on('click', function() {
        currentPage = 1;
        loadOpiData(currentPage);
    });

    // Reset OPI search
    $('#resetOpiBtn').on('click', function() {
        $('#modalOpiSearch').val('');
        $('#modalStatusFilter').val('Proses');
        currentPage = 1;
        loadOpiData(currentPage);
    });

    // Enter key search
    $('#modalOpiSearch').on('keypress', function(e) {
        if (e.which === 13) {
            $('#searchOpiBtn').click();
        }
    });

    // Load OPI Data function
    function loadOpiData(page = 1) {
        const search = $('#modalOpiSearch').val().trim();
        
        console.log('Loading OPI data - Page:', page, 'Search:', search);
        
        // Show loading
        $('#opiLoading').show();
        $('#opiTable').hide();
        $('#opiNoData').hide();
        $('#opiPagination').empty();
        $('#opiInfo').empty();

        // AJAX call to get OPI data with proper pagination
        $.ajax({
            url: '/admin/opi/json-paginated',
            method: 'GET',
            data: {
                page: page,
                search: search
            },
            dataType: 'json',
            success: function(response) {
                console.log('OPI Response:', response);
                $('#opiLoading').hide();
                
                if (response.success && response.data && response.data.length > 0) {
                    displayOpiTableAndStore(response.data);
                    updatePaginationFromResponse(response.pagination);
                    $('#opiTable').show();
                } else {
                    console.log('No OPI data found');
                    $('#opiNoData').show();
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', {
                    status: xhr.status,
                    statusText: xhr.statusText,
                    responseText: xhr.responseText,
                    error: error
                });
                $('#opiLoading').hide();
                $('#opiNoData').show();
                
                // Show error message
                $('#opiNoData').html(`
                    <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
                    <p class="mt-2 text-danger">Error loading OPI data: ${xhr.status} ${xhr.statusText}</p>
                    <button class="btn btn-sm btn-primary" onclick="loadOpiData(1)">Retry</button>
                `);
            }
        });
    }

    // Display OPI table
    function displayOpiTable(data) {
        let tableRows = '';
        
        data.forEach(function(opi) {
            // Handle status display
            let statusBadge = 'primary';
            let statusText = 'PROSES';
            
            if (opi.NoOPI && opi.NoOPI.includes('CANCEL')) {
                statusBadge = 'danger';
                statusText = 'CANCELLED';
            } else if (opi.status_opi === 'Selesai') {
                statusBadge = 'success';
                statusText = 'SELESAI';
            }
            
            // Check if OPI is already selected
            const isSelected = selectedOpis.includes(opi.id);
            const buttonClass = isSelected ? 'btn-secondary' : 'btn-success';
            const buttonDisabled = isSelected ? 'disabled' : '';
            const buttonIcon = isSelected ? 'fa-check-circle' : 'fa-check';
            const buttonTitle = isSelected ? 'OPI sudah dipilih' : 'Pilih OPI ini';
            
            tableRows += `
                <tr ${isSelected ? 'class="table-secondary"' : ''}>
                    <td>
                        <button type="button" class="btn btn-sm ${buttonClass} select-opi-btn" 
                                data-opi-id="${opi.id}" title="${buttonTitle}" ${buttonDisabled}>
                            <i class="fas ${buttonIcon}"></i>
                        </button>
                    </td>
                    <td>${opi.NoOPI || '-'}</td>
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
            loadOpiData(page);
        }
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
                // Debug: log the data to see structure
                console.log('OPI Data received:', data);
                console.log('MC Data:', data.mc);
                console.log('Substance Data:', data.mc?.substanceproduksi);
                if (data.mc?.substanceproduksi) {
                    console.log('Liner Atas:', data.mc.substanceproduksi.lineratas);
                    console.log('Flute 1:', data.mc.substanceproduksi.flute1);
                    console.log('Liner Tengah:', data.mc.substanceproduksi.linertengah);
                    console.log('Flute 2:', data.mc.substanceproduksi.flute2);
                    console.log('Liner Bawah:', data.mc.substanceproduksi.linerbawah);
                }
                
                // Add to planning directly
                addPlanningItem(data);
                
                // Add to selected list
                selectedOpis.push(opiId);
                
                // Hide selection info after first OPI is selected
                if (selectedOpis.length === 1) {
                    $('#opiSelectionInfo').fadeOut();
                }
                
                // Update counter
                updateSelectedCounter();
                
                // Refresh table to show updated status
                displayOpiTable(window.currentOpiTableData);
            },
            error: function(xhr) {
                alert('Error loading OPI data');
                $(this).prop('disabled', false).html('<i class="fas fa-check"></i>');
            }
        });
    });

    // Store current table data for refresh
    window.currentOpiTableData = [];
    
    // Update the success handler to store table data
    function displayOpiTableAndStore(data) {
        window.currentOpiTableData = data;
        displayOpiTable(data);
    }
    
    // Update selected OPI counter
    function updateSelectedCounter() {
        const count = selectedOpis.length;
        $('#selectedOpiCount').text(`${count} dipilih`);
    }

    // Add planning item
    function addPlanningItem(opiData) {
        itemCounter++;
        
        // Calculate toleransi based on tipe box
        let toleransi = 0;
        if (opiData.mc?.tipeBox === 'DC') toleransi = 2;
        else if (opiData.mc?.tipeBox === 'B1') toleransi = 5;
        
        // Get paper data from OPI using eager loaded relations
        const kertasAtas = opiData.mc?.substanceproduksi?.lineratas?.jenisKertasMc || '';
        const kertasFlute1 = opiData.mc?.substanceproduksi?.flute1?.jenisKertasMc || '';
        const kertasTengah = opiData.mc?.substanceproduksi?.linertengah?.jenisKertasMc || '';
        const kertasFlute2 = opiData.mc?.substanceproduksi?.flute2?.jenisKertasMc || '';
        const kertasBawah = opiData.mc?.substanceproduksi?.linerbawah?.jenisKertasMc || '';
        
        // Get gram data from OPI using eager loaded relations
        const gramAtas = opiData.mc?.substanceproduksi?.lineratas?.gramKertas || '';
        const gramFlute1 = opiData.mc?.substanceproduksi?.flute1?.gramKertas || '';
        const gramTengah = opiData.mc?.substanceproduksi?.linertengah?.gramKertas || '';
        const gramFlute2 = opiData.mc?.substanceproduksi?.flute2?.gramKertas || '';
        const gramBawah = opiData.mc?.substanceproduksi?.linerbawah?.gramKertas || '';
        
        // Add table row
        const tableRow = `
            <tr id="planRow${itemCounter}" data-opi-id="${opiData.id}">
                <td>
                    <input type="number" class="form-control form-control-sm" name="urutan[${itemCounter}]" value="${itemCounter}" required>
                </td>
                <td>${opiData.NoOPI || '-'}</td>
                <td>
                    <input type="date" class="form-control form-control-sm" name="dt[${itemCounter}]" value="${opiData.dt?.tglKirimDt || ''}">
                </td>
                <td>
                    <input type="date" class="form-control form-control-sm" name="dtperubahan[${itemCounter}]">
                </td>
                <td title="${opiData.kontrakm?.customer_name || '-'}">${opiData.kontrakm?.customer_name || '-'}</td>
                <td title="${opiData.mc?.namaBarang || '-'}">${opiData.mc?.namaBarang || '-'}</td>
                <td>${opiData.mc?.kode || '-'}</td>
                <td>
                    <input type="number" class="form-control form-control-sm" name="sheetp[${itemCounter}]" value="${opiData.mc?.panjangSheet || ''}" step="0.01" style="width:100px;display:inline-block;">
                    <span class="mx-1">×</span>
                    <input type="number" class="form-control form-control-sm" name="sheetl[${itemCounter}]" value="${opiData.mc?.lebarSheet || ''}" step="0.01" style="width:100px;display:inline-block;">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" name="tipebox[${itemCounter}]" value="${opiData.mc?.tipeBox || ''}" style="width:60px;display:inline-block;">
                    <span class="mx-1">/</span>
                    <input type="text" class="form-control form-control-sm" name="flute[${itemCounter}]" value="${opiData.mc?.flute || ''}" style="width:60px;display:inline-block;">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm order-input" name="order[${itemCounter}]" value="${opiData.jumlahOrder || ''}">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm outcorr-input" name="outCorr[${itemCounter}]" required>
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm outflexo-input" name="outFlexo[${itemCounter}]" value="${opiData.mc?.outConv || ''}" required>
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm toleransi-input" name="toleransi[${itemCounter}]" value="${toleransi}" step="0.1">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm beratsheet-input" name="beratSheet[${itemCounter}]" value="${opiData.mc?.gramSheetBoxProduksi || ''}" step="0.01">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm roll-result" name="roll[${itemCounter}]" readonly>
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm plan-result" name="plan[${itemCounter}]" readonly step="0.01">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm trim-result" name="trim[${itemCounter}]" readonly step="0.01">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm cop-result" name="cop[${itemCounter}]" readonly step="0.01">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm rmorder-result" name="rmorder[${itemCounter}]" readonly>
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" name="jenisAtas[${itemCounter}]" value="${getJenisKertas(opiData, 'lineratas')}" readonly style="background: #d4edda; border-color: #28a745; font-size: 10px;" title="${getJenisKertas(opiData, 'lineratas')}">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm gramatas-input" name="gramAtas[${itemCounter}]" value="${getGramKertas(opiData, 'lineratas')}" step="1" style="width: 60px; background: #d4edda; border-color: #28a745;">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm kebutuhan-result" name="kebutuhanAtas[${itemCounter}]" readonly style="background: #d4edda; border-color: #28a745; font-weight: bold;">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" name="jenisFlute1[${itemCounter}]" value="${getJenisKertas(opiData, 'flute1')}" readonly style="background: #ffeaa7; border-color: #fd7e14; font-size: 10px;" title="${getJenisKertas(opiData, 'flute1')}">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm gramflute1-input" name="gramFlute1[${itemCounter}]" value="${getGramKertas(opiData, 'flute1')}" step="1" style="width: 60px; background: #ffeaa7; border-color: #fd7e14;">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm kebutuhan-result" name="kebutuhanFlute1[${itemCounter}]" readonly style="background: #ffeaa7; border-color: #fd7e14; font-weight: bold;">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" name="jenisTengah[${itemCounter}]" value="${getJenisKertas(opiData, 'linertengah')}" readonly style="background: #d1ecf1; border-color: #20c997; font-size: 10px;" title="${getJenisKertas(opiData, 'linertengah')}">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm gramtengah-input" name="gramTengah[${itemCounter}]" value="${getGramKertas(opiData, 'linertengah')}" step="1" style="width: 60px; background: #d1ecf1; border-color: #20c997;">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm kebutuhan-result" name="kebutuhanTengah[${itemCounter}]" readonly style="background: #d1ecf1; border-color: #20c997; font-weight: bold;">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" name="jenisFlute2[${itemCounter}]" value="${getJenisKertas(opiData, 'flute2')}" readonly style="background: #f3e2f3; border-color: #e83e8c; font-size: 10px;" title="${getJenisKertas(opiData, 'flute2')}">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm gramflute2-input" name="gramFlute2[${itemCounter}]" value="${getGramKertas(opiData, 'flute2')}" step="1" style="width: 60px; background: #f3e2f3; border-color: #e83e8c;">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm kebutuhan-result" name="kebutuhanFlute2[${itemCounter}]" readonly style="background: #f3e2f3; border-color: #e83e8c; font-weight: bold;">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" name="jenisBawah[${itemCounter}]" value="${getJenisKertas(opiData, 'linerbawah')}" readonly style="background: #e2d9f3; border-color: #6f42c1; font-size: 10px;" title="${getJenisKertas(opiData, 'linerbawah')}">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm grambawah-input" name="gramBawah[${itemCounter}]" value="${getGramKertas(opiData, 'linerbawah')}" step="1" style="width: 60px; background: #e2d9f3; border-color: #6f42c1;">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm kebutuhan-result" name="kebutuhanBawah[${itemCounter}]" readonly style="background: #e2d9f3; border-color: #6f42c1; font-weight: bold;">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" name="keterangan[${itemCounter}]" placeholder="Catatan">
                </td>
                <td>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-info" onclick="showDetails(${itemCounter})" title="Detail Kertas & Kalkulasi">
                            <i class="fas fa-cog"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" onclick="removePlanItem(${itemCounter})" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
        
        // Add detail form (hidden)
        const detailForm = `
            <div id="planDetail${itemCounter}" style="display: none;" class="mt-3 border p-3">
                <h6><i class="fas fa-cog"></i> Detail & Kalkulasi - ${opiData.NoOPI}</h6>
                
                <!-- Hidden fields for form submission -->
                <input type="hidden" name="urutan[${itemCounter}]" value="${itemCounter}">
                <input type="hidden" name="noOpi[${itemCounter}]" value="${opiData.NoOPI || ''}">
                <input type="hidden" name="opi_id[${itemCounter}]" value="${opiData.id || ''}">
                <input type="hidden" name="dt[${itemCounter}]" value="${opiData.dt?.tglKirimDt || ''}">
                <input type="hidden" name="customer[${itemCounter}]" value="${opiData.kontrakm?.customer_name || ''}">
                <input type="hidden" name="item[${itemCounter}]" value="${opiData.mc?.namaBarang || ''}">
                <input type="hidden" name="mc[${itemCounter}]" value="${opiData.mc?.kode || ''}">
                
                <!-- Info Summary -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="alert alert-light">
                            <strong>Info:</strong> No OPI: ${opiData.NoOPI} | Customer: ${opiData.kontrakm?.customer_name || '-'} | Item: ${opiData.mc?.namaBarang || '-'}
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>DT Perubahan</label>
                            <input type="date" class="form-control" name="dtperubahan[${itemCounter}]">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Berat/Pcs (g)</label>
                            <input type="number" class="form-control beratsheet-input" name="beratSheet[${itemCounter}]" value="${opiData.mc?.gramSheetBoxProduksi || ''}" step="0.01">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" class="form-control" name="keterangan[${itemCounter}]" placeholder="Catatan tambahan">
                        </div>
                    </div>
                </div>
                
                <!-- Jenis Kertas dan Gram -->
                <h6 class="text-primary mt-3"><i class="fas fa-layer-group"></i> Jenis Kertas & Gramasi</h6>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>K. Atas</label>
                            <input type="text" class="form-control form-control-sm" name="kertasAtas[${itemCounter}]" value="${kertasAtas}" placeholder="Jenis kertas">
                            <input type="number" class="form-control form-control-sm mt-1" name="gramAtas[${itemCounter}]" value="${gramAtas}" placeholder="Gram" step="0.01">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>K. Flute1</label>
                            <input type="text" class="form-control form-control-sm" name="kertasFlute1[${itemCounter}]" value="${kertasFlute1}" placeholder="Jenis kertas">
                            <input type="number" class="form-control form-control-sm mt-1" name="gramFlute1[${itemCounter}]" value="${gramFlute1}" placeholder="Gram" step="0.01">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>K. Tengah</label>
                            <input type="text" class="form-control form-control-sm" name="kertasTengah[${itemCounter}]" value="${kertasTengah}" placeholder="Jenis kertas">
                            <input type="number" class="form-control form-control-sm mt-1" name="gramTengah[${itemCounter}]" value="${gramTengah}" placeholder="Gram" step="0.01">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>K. Flute2</label>
                            <input type="text" class="form-control form-control-sm" name="kertasFlute2[${itemCounter}]" value="${kertasFlute2}" placeholder="Jenis kertas">
                            <input type="number" class="form-control form-control-sm mt-1" name="gramFlute2[${itemCounter}]" value="${gramFlute2}" placeholder="Gram" step="0.01">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>K. Bawah</label>
                            <input type="text" class="form-control form-control-sm" name="kertasBawah[${itemCounter}]" value="${kertasBawah}" placeholder="Jenis kertas">
                            <input type="number" class="form-control form-control-sm mt-1" name="gramBawah[${itemCounter}]" value="${gramBawah}" placeholder="Gram" step="0.01">
                        </div>
                    </div>
                </div>
                
                <!-- Kebutuhan Kertas -->
                <h6 class="text-success mt-3"><i class="fas fa-calculator"></i> Kebutuhan Kertas (kg)</h6>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Kebutuhan Atas</label>
                            <input type="number" class="form-control form-control-sm kebutuhan-result" name="kebutuhanAtas[${itemCounter}]" readonly step="0.01">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Kebutuhan Flute1</label>
                            <input type="number" class="form-control form-control-sm kebutuhan-result" name="kebutuhanFlute1[${itemCounter}]" readonly step="0.01">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Kebutuhan Tengah</label>
                            <input type="number" class="form-control form-control-sm kebutuhan-result" name="kebutuhanTengah[${itemCounter}]" readonly step="0.01">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Kebutuhan Flute2</label>
                            <input type="number" class="form-control form-control-sm kebutuhan-result" name="kebutuhanFlute2[${itemCounter}]" readonly step="0.01">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Kebutuhan Bawah</label>
                            <input type="number" class="form-control form-control-sm kebutuhan-result" name="kebutuhanBawah[${itemCounter}]" readonly step="0.01">
                        </div>
                    </div>
                </div>
                
                <!-- Hasil Kalkulasi -->
                <h6 class="text-info mt-3"><i class="fas fa-chart-line"></i> Hasil Kalkulasi</h6>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Lebar Roll</label>
                            <input type="number" class="form-control form-control-sm roll-result" name="roll[${itemCounter}]" readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Plan</label>
                            <input type="number" class="form-control form-control-sm plan-result" name="plan[${itemCounter}]" readonly step="0.01">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Trim</label>
                            <input type="number" class="form-control form-control-sm trim-result" name="trim[${itemCounter}]" readonly step="0.01">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Cop</label>
                            <input type="number" class="form-control form-control-sm cop-result" name="cop[${itemCounter}]" readonly step="0.01">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>RM Order</label>
                            <input type="number" class="form-control form-control-sm rmorder-result" name="rmorder[${itemCounter}]" readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Berat Order (kg)</label>
                            <input type="number" class="form-control form-control-sm beratorder-result" name="beratOrder[${itemCounter}]" readonly step="0.01">
                        </div>
                    </div>
                </div>
                
                <div class="mt-3">
                    <button type="button" class="btn btn-sm btn-secondary" onclick="hideDetails(${itemCounter})">
                        <i class="fas fa-eye-slash"></i> Sembunyikan Detail
                    </button>
                </div>
            </div>
        `;
        
        // Add to table and details
        $('#planningTableBody').append(tableRow);
        $('#planningDetails').append(detailForm);
        
        // Show table and hide no data message
        $('#noPlanningMessage').hide();
        $('#planningTable').show();
        
        // Auto calculate if basic data exists
        setTimeout(function() {
            const outCorr = parseFloat($(`input[name="outCorr[${itemCounter}]"]`).val());
            if (outCorr && outCorr > 0) {
                calculateItemRequirements(itemCounter);
            }
        }, 100);
    }

    // Auto calculate when Out Corr or other key fields change
    $(document).on('input change', '.outcorr-input, .order-input, .toleransi-input, .outflexo-input, .beratsheet-input', function() {
        // Get the item ID from the input name
        const inputName = $(this).attr('name');
        const itemId = inputName.match(/\[(\d+)\]/)[1];
        
        // Only calculate if Out Corr has value
        const outCorr = parseFloat($(`input[name="outCorr[${itemId}]"]`).val());
        if (outCorr && outCorr > 0) {
            calculateItemRequirements(itemId);
        }
    });

    // Auto calculate when sheet dimensions change
    $(document).on('input change', 'input[name^="sheetp["], input[name^="sheetl["], input[name^="tipebox["]', function() {
        // Get the item ID from the input name
        const inputName = $(this).attr('name');
        const itemId = inputName.match(/\[(\d+)\]/)[1];
        
        // Only calculate if Out Corr has value
        const outCorr = parseFloat($(`input[name="outCorr[${itemId}]"]`).val());
        if (outCorr && outCorr > 0) {
            calculateItemRequirements(itemId);
        }
    });

    // Auto calculate when gram inputs change (affects paper requirements)
    $(document).on('input change', '.gramatas-input, .gramflute1-input, .gramtengah-input, .gramflute2-input, .grambawah-input', function() {
        // Get the item ID from the input name
        const inputName = $(this).attr('name');
        const itemId = inputName.match(/\[(\d+)\]/)[1];
        
        // Only calculate if Out Corr has value
        const outCorr = parseFloat($(`input[name="outCorr[${itemId}]"]`).val());
        if (outCorr && outCorr > 0) {
            calculateItemRequirements(itemId);
        }
    });

    // Calculate requirements
    $('#calculateBtn').on('click', function() {
        $('.card[id^="planItem"]').each(function() {
            const itemId = $(this).attr('id').replace('planItem', '');
            calculateItemRequirements(itemId);
        });
        
        alert('Perhitungan selesai! Silakan periksa hasil perhitungan.');
    });

    // Calculate individual item requirements
    function calculateItemRequirements(itemId) {
        const outCorr = parseFloat($(`input[name="outCorr[${itemId}]"]`).val()) || 0;
        const sheetl = parseFloat($(`input[name="sheetl[${itemId}]"]`).val()) || 0;
        const sheetp = parseFloat($(`input[name="sheetp[${itemId}]"]`).val()) || 0;
        const outFlexo = parseFloat($(`input[name="outFlexo[${itemId}]"]`).val()) || 0;
        const order = parseFloat($(`input[name="order[${itemId}]"]`).val()) || 0;
        const toleransi = parseFloat($(`input[name="toleransi[${itemId}]"]`).val()) || 0;
        const beratSheet = parseFloat($(`input[name="beratSheet[${itemId}]"]`).val()) || 0;
        const tipebox = $(`input[name="tipebox[${itemId}]"]`).val();
        const flute = $(`input[name="flute[${itemId}]"]`).val();

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
            flute2 = 1.36;
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

        // Calculate paper requirements
        const gramAtas = parseFloat($(`input[name="gramAtas[${itemId}]"]`).val()) || 0;
        const gramFlute1 = parseFloat($(`input[name="gramFlute1[${itemId}]"]`).val()) || 0;
        const gramTengah = parseFloat($(`input[name="gramTengah[${itemId}]"]`).val()) || 0;
        const gramFlute2 = parseFloat($(`input[name="gramFlute2[${itemId}]"]`).val()) || 0;
        const gramBawah = parseFloat($(`input[name="gramBawah[${itemId}]"]`).val()) || 0;

        // Calculate kebutuhan kertas (paper requirements in kg)
        let kebutuhanAtas = 0, kebutuhanFlute1 = 0, kebutuhanTengah = 0, kebutuhanFlute2 = 0, kebutuhanBawah = 0;
        
        if (gramAtas > 0) {
            kebutuhanAtas = rmorder * (UkRoll / 1000) * gramAtas / 1000;
        }
        if (gramFlute1 > 0) {
            kebutuhanFlute1 = rmorder * (UkRoll / 1000) * (gramFlute1 / 1000) * flute1; // Flute factor
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
        $(`input[name="roll[${itemId}]"]`).val(UkRoll);
        $(`input[name="plan[${itemId}]"]`).val(qtyPlan.toFixed(0));
        $(`input[name="cop[${itemId}]"]`).val(cop.toFixed(0));
        $(`input[name="rmorder[${itemId}]"]`).val(Math.round(rmorder));
        
        // Also update detail fields if they exist
        $(`input[name="trim[${itemId}]"]`).val(trim.toFixed(0));
        $(`input[name="beratOrder[${itemId}]"]`).val(tonase.toFixed(2));
        
        // Update paper requirements
        $(`input[name="kebutuhanAtas[${itemId}]"]`).val(Math.round(kebutuhanAtas));
        $(`input[name="kebutuhanFlute1[${itemId}]"]`).val(Math.round(kebutuhanFlute1));
        $(`input[name="kebutuhanTengah[${itemId}]"]`).val(Math.round(kebutuhanTengah));
        $(`input[name="kebutuhanFlute2[${itemId}]"]`).val(Math.round(kebutuhanFlute2));
        $(`input[name="kebutuhanBawah[${itemId}]"]`).val(Math.round(kebutuhanBawah));
    }

    // Form validation
    $('#corrugatingForm').on('submit', function(e) {
        e.preventDefault();
        
        if (!$('#tgl').val()) {
            alert('Tanggal produksi harus diisi');
            return;
        }
        
        if (!$('#shift').val()) {
            alert('Shift harus dipilih');
            return;
        }
        
        if ($('.card[id^="planItem"]').length === 0) {
            alert('Minimal harus ada 1 item planning');
            return;
        }
        
        // If validation passes, submit the form
        // this.submit(); // Uncomment when ready to implement backend
        alert('Form valid! Ready to implement backend submission.');
    });
});

// Show/Hide detail functions
function showDetails(itemId) {
    $(`#planDetail${itemId}`).slideDown();
    $(`button[onclick="showDetails(${itemId})"]`).html('<i class="fas fa-eye-slash"></i>').attr('onclick', `hideDetails(${itemId})`).attr('title', 'Sembunyikan Detail');
}

function hideDetails(itemId) {
    $(`#planDetail${itemId}`).slideUp();
    $(`button[onclick="hideDetails(${itemId})"]`).html('<i class="fas fa-eye"></i>').attr('onclick', `showDetails(${itemId})`).attr('title', 'Detail & Kalkulasi');
}

// Remove planning item
function removePlanItem(itemId) {
    if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
        // Get OPI ID from the item
        const opiId = parseInt($(`#planDetail${itemId} input[name="opi_id[${itemId}]"]`).val());
        
        // Remove from selected list
        const index = selectedOpis.indexOf(opiId);
        if (index > -1) {
            selectedOpis.splice(index, 1);
        }
        
        // Update counter
        updateSelectedCounter();
        
        // Remove the table row and detail form
        $(`#planRow${itemId}`).remove();
        $(`#planDetail${itemId}`).remove();
        
        // Hide table if no more items
        if ($('#planningTableBody tr').length === 0) {
            $('#planningTable').hide();
            $('#noPlanningMessage').show();
        }
        
        // Refresh OPI table if modal is open
        if ($('#opiModal').hasClass('show') && window.currentOpiTableData.length > 0) {
            displayOpiTable(window.currentOpiTableData);
        }
        
        if (typeof toastr !== 'undefined') {
            toastr.info('Item planning dihapus. OPI dapat dipilih kembali.');
        }
    }
}
</script>
@endsection