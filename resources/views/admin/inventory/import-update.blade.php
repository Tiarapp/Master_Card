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
    border: 1px solid #bbdefb;
}
</style>

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-file-import text-primary"></i>
                        Import Update Inventory
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('inventory.index') }}">Inventory</a></li>
                        <li class="breadcrumb-item active">Import Update</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
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
                            <p class="mb-4">Download template Excel untuk import update inventory</p>
                            <a href="{{ route('inventory.import.template') }}" class="btn btn-light btn-lg">
                                <i class="fas fa-file-excel me-2"></i>
                                Download Template
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Upload Section -->
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-cloud-upload-alt me-2"></i>
                                Upload File Import
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('inventory.import.update.rgb') }}" method="POST" enctype="multipart/form-data" id="importRgbForm">
                                @csrf
                                
                                <div class="upload-area" id="uploadArea">
                                    <i class="fas fa-palette fa-3x text-primary mb-3"></i>
                                    <h5>Import dengan RGB Code</h5>
                                    <p class="text-muted">
                                        Klik atau seret file Excel ke sini<br>
                                        Format yang didukung: .xlsx, .xls, .csv<br>
                                        Maksimal ukuran file: 10MB
                                    </p>
                                    <input type="file" name="file" id="fileInput" class="file-input" accept=".xlsx,.xls,.csv" required>
                                    <button type="button" class="btn btn-primary" onclick="document.getElementById('fileInput').click()">
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
                                        <i class="fas fa-code me-2"></i>
                                        Import RGB Code
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
                        <h5 class="text-primary mb-3">
                            <i class="fas fa-info-circle me-2"></i>
                            Informasi Import Update
                        </h5>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="font-weight-bold">Field yang dapat diupdate:</h6>
                                <div class="mb-3">
                                    <span class="field-tag">warna</span>
                                    <span class="field-tag">gsm_act</span>
                                    <span class="field-tag">cobsize_top</span>
                                    <span class="field-tag">cobsize_back</span>
                                    <span class="field-tag">rct_cd</span>
                                    <span class="field-tag">rct_md</span>
                                </div>
                                
                                <div class="alert alert-success mt-3">
                                    <h6><i class="fas fa-code me-2"></i>Import RGB Code</h6>
                                    <p class="mb-2">Kolom <code>warna</code> dapat diisi dengan 3 cara:</p>
                                    <ul class="mb-2">
                                        <li><strong>Teks:</strong> Ketik langsung (SAMA/BEDA/dll)</li>
                                        <li><strong>Background Color:</strong> Kosongkan cell, beri warna background</li>
                                        <li><strong>Background White:</strong> Kosongkan cell, beri background putih → tersimpan NULL</li>
                                    </ul>
                                    
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <h6 class="text-primary"><i class="fas fa-palette me-1"></i>Hasil RGB Code</h6>
                                            <small class="text-muted">
                                                • Cell merah → "#FF0000"<br>
                                                • Cell hijau → "#00FF00"<br>
                                                • Cell biru → "#0000FF"<br>
                                                • Cell kuning → "#FFFF00"<br>
                                                • <strong>Cell putih → NULL (kosong)</strong><br>
                                                • Dan warna lainnya sesuai kode hex
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="font-weight-bold">Ketentuan Import:</h6>
                                <ul class="text-muted">
                                    <li>Kolom <code>kode_internal</code> wajib ada dan terisi</li>
                                    <li>Field lain bersifat opsional</li>
                                    <li>Data akan diupdate berdasarkan kode internal</li>
                                    <li>Jika kode internal tidak ditemukan, baris akan diabaikan</li>
                                    <li>Field <code>rct_cd</code> dan <code>rct_md</code> akan diformat 2 angka desimal</li>
                                    <li><strong>Kolom warna:</strong> Bisa berisi teks atau menggunakan background color cell</li>
                                </ul>
                            </div>
                        </div>

                        <div class="alert alert-warning mt-3">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Perhatian:</strong> 
                            Pastikan format file sesuai dengan template yang disediakan. 
                            Data yang sudah ada akan ditimpa dengan data baru dari import.
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

    // RGB Form submission
    $('#importRgbForm').on('submit', function() {
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengimport RGB...';
        submitBtn.disabled = true;
    });
});
</script>
@endsection
