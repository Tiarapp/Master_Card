@extends('admin.templates.partials.default')

<style>
.upload-area {
    border: 2px dashed #007bff;
    border-radius: 10px;
    padding: 40px;
    text-align: center;
    background-color: #f8f9fa;
    transition: all 0.3s ease;
    cursor: pointer;
}

.upload-area:hover {
    border-color: #0056b3;
    background-color: #e3f2fd;
}

.upload-area.drag-over {
    border-color: #28a745;
    background-color: #d4edda;
}

.file-input {
    display: none;
}

.template-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 15px;
    padding: 30px;
}

.info-card {
    background: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.field-tag {
    display: inline-block;
    background: #e3f2fd;
    color: #1976d2;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.875rem;
    margin: 3px;
}
</style>

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Import Inventory</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('inventory.index') }}">Inventory</a></li>
                        <li class="breadcrumb-item active">Import Inventory</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>Berhasil!</strong> {{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Error!</strong> {{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row">
                <!-- Template Download Section -->
                <div class="col-lg-4">
                    <div class="template-section">
                        <div class="text-center">
                            <i class="fas fa-download fa-3x mb-3"></i>
                            <h4>Download Template</h4>
                            <p class="mb-4">Download template Excel untuk import inventory baru</p>
                            <a href="{{ route('inventory.import.inventory.template') }}" class="btn btn-light btn-lg">
                                <i class="fas fa-file-excel me-2"></i>
                                Download Template
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Upload Section -->
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-upload me-2"></i>
                                Upload File Import Inventory
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('inventory.import.inventory') }}" method="POST" enctype="multipart/form-data" id="importInventoryForm">
                                @csrf
                                
                                <div class="upload-area" id="uploadArea">
                                    <i class="fas fa-boxes fa-3x text-success mb-3"></i>
                                    <h5>Import Inventory Baru</h5>
                                    <p class="text-muted">
                                        Klik atau seret file Excel ke sini<br>
                                        Format yang didukung: .xlsx, .xls, .csv<br>
                                        Maksimal ukuran file: 10MB
                                    </p>
                                    <input type="file" name="file" id="fileInput" class="file-input" accept=".xlsx,.xls,.csv" required>
                                    <button type="button" class="btn btn-success" onclick="document.getElementById('fileInput').click()">
                                        <i class="fas fa-folder-open me-2"></i>Pilih File
                                    </button>
                                </div>

                                <div id="fileInfo" class="mt-3" style="display: none;">
                                    <div class="alert alert-info">
                                        <i class="fas fa-file me-2"></i>
                                        <span id="fileName"></span>
                                        <button type="button" class="btn btn-sm btn-outline-danger float-right" onclick="removeFile()">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-success btn-lg" id="submitBtn" disabled>
                                        <i class="fas fa-upload me-2"></i>
                                        Import Inventory
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Information Section -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="info-card">
                        <h5 class="text-success mb-3">
                            <i class="fas fa-info-circle me-2"></i>
                            Informasi Import Inventory
                        </h5>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="font-weight-bold">Field yang tersedia:</h6>
                                <div class="mb-3">
                                    <span class="field-tag">tanggal_masuk</span>
                                    <span class="field-tag">kode_internal</span>
                                    <span class="field-tag">kw</span>
                                    <span class="field-tag">jenis</span>
                                    <span class="field-tag">gsm</span>
                                    <span class="field-tag">kode_roll</span>
                                    <span class="field-tag">lebar</span>
                                    <span class="field-tag">berat_sj</span>
                                    <span class="field-tag">berat_timbang</span>
                                    <span class="field-tag">quantity</span>
                                    <span class="field-tag">supplier_id</span>
                                    <span class="field-tag">purchase_order</span>
                                    <span class="field-tag">description</span>
                                </div>
                                
                                <div class="alert alert-warning mt-3">
                                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Field Wajib</h6>
                                    <ul class="mb-0">
                                        <li><strong>tanggal_masuk:</strong> Format YYYY-MM-DD</li>
                                        <li><strong>kode_internal:</strong> Kode unik inventory</li>
                                        <li><strong>supplier_id:</strong> ID supplier yang valid</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="font-weight-bold">Ketentuan Import:</h6>
                                <ul class="text-muted">
                                    <li>Inventory dengan <code>kode_internal</code> yang sudah ada akan dilewati</li>
                                    <li>Field <code>supplier_id</code> bisa berupa ID atau nama supplier</li>
                                    <li>Jika <code>quantity</code> kosong, akan diisi dari <code>berat_timbang</code></li>
                                    <li>Field <code>status_roll_id</code> otomatis diset ke 1 (aktif)</li>
                                    <li>Format tanggal bisa: YYYY-MM-DD, DD/MM/YYYY, atau DD-MM-YYYY</li>
                                    <li>Field numerik: <code>gsm</code>, <code>lebar</code>, <code>berat_sj</code>, <code>berat_timbang</code>, <code>quantity</code></li>
                                </ul>
                            </div>
                        </div>

                        <div class="alert alert-info mt-3">
                            <i class="fas fa-lightbulb me-2"></i>
                            <strong>Tips:</strong> 
                            Download template terlebih dahulu untuk melihat format yang benar dan contoh data.
                            File template sudah berisi contoh data dari supplier yang ada di sistem.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('javascripts')
<script>
$(document).ready(function() {
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('fileInput');
    const fileInfo = document.getElementById('fileInfo');
    const fileName = document.getElementById('fileName');
    const submitBtn = document.getElementById('submitBtn');

    // Click to upload
    uploadArea.addEventListener('click', () => {
        fileInput.click();
    });

    // Drag and drop
    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('drag-over');
    });

    uploadArea.addEventListener('dragleave', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('drag-over');
    });

    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('drag-over');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            showFileInfo(files[0]);
        }
    });

    // File input change
    fileInput.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            showFileInfo(e.target.files[0]);
        }
    });

    function showFileInfo(file) {
        fileName.textContent = file.name + ' (' + formatFileSize(file.size) + ')';
        fileInfo.style.display = 'block';
        submitBtn.disabled = false;
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    window.removeFile = function() {
        fileInput.value = '';
        fileInfo.style.display = 'none';
        submitBtn.disabled = true;
    }

    // Form submission
    $('#importInventoryForm').on('submit', function() {
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengimport...';
        submitBtn.disabled = true;
    });
});
</script>
@endsection
