@extends('admin.templates.partials.default')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Hardware Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Hardware</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold">Data Hardware</h6>
                    <div>
                        <button class="btn btn-custom btn-sm mr-2" onclick="downloadTemplate()">
                            <i class="fas fa-download"></i> Template
                        </button>
                        <button class="btn btn-success btn-sm mr-2" onclick="importExcel()">
                            <i class="fas fa-file-import"></i> Import
                        </button>
                        <button class="btn btn-info btn-sm mr-2" onclick="exportExcel()">
                            <i class="fas fa-file-export"></i> Export
                        </button>
                        <button class="btn btn-primary btn-sm" onclick="addHardware()">
                            <i class="fas fa-plus"></i> Tambah Hardware
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filter Section -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <select class="form-control form-control-sm" id="filterKategori" name="kategori">
                                <option value="">Semua Kategori</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control form-control-sm" id="filterStatus" name="status">
                                <option value="">Semua Status</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control form-control-sm" id="filterDivisi" name="divisi" placeholder="Filter Divisi" value="{{ request('divisi') }}">
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-secondary btn-sm" onclick="applyFilters()">Filter</button>
                            <button class="btn btn-light btn-sm" onclick="resetFilters()">Reset</button>
                        </div>
                    </div>

                    <!-- Search Section -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="searchInput" name="search" placeholder="Cari hardware..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" id="perPage" name="per_page">
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 per halaman</option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 per halaman</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 per halaman</option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 per halaman</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary btn-sm" onclick="searchHardware()">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </div>
                    </div>

                    <!-- Hardware List -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Kode</th>
                                    <th>Nama Hardware</th>
                                    <th>Merk</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                    <th>Lokasi</th>
                                    <th>PIC</th>
                                    <th>Divisi</th>
                                    <th>Harga</th>
                                    <th>Garansi</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($hardwares as $index => $hardware)
                                <tr>
                                    <td>{{ $hardwares->firstItem() + $index }}</td>
                                    <td>{{ $hardware->kode_hardware }}</td>
                                    <td>{{ $hardware->nama_hardware }}</td>
                                    <td>{{ $hardware->merk ?? '-' }}</td>
                                    <td>{{ $hardware->kategori }}</td>
                                    <td>
                                        <span class="badge badge-{{ $hardware->status_badge }}">{{ $hardware->status }}</span>
                                    </td>
                                    <td>{{ $hardware->lokasi ?? '-' }}</td>
                                    <td>{{ $hardware->pic_pengguna ?? '-' }}</td>
                                    <td>{{ $hardware->divisi ?? '-' }}</td>
                                    <td>{{ $hardware->harga_pembelian_formatted }}</td>
                                    <td>
                                        @php
                                            $status = $hardware->garansi_status;
                                            $badge = '';
                                            switch($status) {
                                                case 'Garansi Aktif':
                                                    $badge = 'success';
                                                    break;
                                                case 'Garansi Akan Habis':
                                                    $badge = 'warning';
                                                    break;
                                                case 'Garansi Habis':
                                                    $badge = 'danger';
                                                    break;
                                                default:
                                                    $badge = 'secondary';
                                            }
                                        @endphp
                                        <span class="badge badge-{{ $badge }}">{{ $status }}</span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-info btn-sm" onclick="showHardware({{ $hardware->id }})" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-warning btn-sm" onclick="editHardware({{ $hardware->id }})" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm" onclick="deleteHardware({{ $hardware->id }})" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="12" class="text-center">Tidak ada data hardware</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($hardwares->hasPages())
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <p class="text-muted">
                                Menampilkan {{ $hardwares->firstItem() }} sampai {{ $hardwares->lastItem() }} 
                                dari {{ $hardwares->total() }} hasil
                            </p>
                        </div>
                        <div class="col-md-6">
                            <div class="float-right">
                                {{ $hardwares->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah/Edit Hardware -->
<div class="modal fade" id="hardwareModal" tabindex="-1" role="dialog" aria-labelledby="hardwareModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hardwareModalLabel">Tambah Hardware</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="hardwareForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kode_hardware">Kode Hardware <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="kode_hardware" name="kode_hardware" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_hardware">Nama Hardware <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_hardware" name="nama_hardware" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="merk">Merk</label>
                                <input type="text" class="form-control" id="merk" name="merk">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="model">Model</label>
                                <input type="text" class="form-control" id="model" name="model">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="serial_number">Serial Number</label>
                                <input type="text" class="form-control" id="serial_number" name="serial_number">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kategori">Kategori <span class="text-danger">*</span></label>
                                <select class="form-control" id="kategori" name="kategori" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($kategoris as $kategori)
                                        <option value="{{ $kategori }}">{{ $kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="spesifikasi">Spesifikasi</label>
                                <textarea class="form-control" id="spesifikasi" name="spesifikasi" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status <span class="text-danger">*</span></label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="">Pilih Status</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status }}">{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lokasi">Lokasi</label>
                                <input type="text" class="form-control" id="lokasi" name="lokasi">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pic_pengguna">PIC Pengguna</label>
                                <input type="text" class="form-control" id="pic_pengguna" name="pic_pengguna">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="divisi">Divisi</label>
                                <input type="text" class="form-control" id="divisi" name="divisi">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_pembelian">Tanggal Pembelian</label>
                                <input type="date" class="form-control" id="tanggal_pembelian" name="tanggal_pembelian">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="harga_pembelian">Harga Pembelian</label>
                                <input type="number" class="form-control" id="harga_pembelian" name="harga_pembelian" step="0.01">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_garansi_mulai">Tanggal Garansi Mulai</label>
                                <input type="date" class="form-control" id="tanggal_garansi_mulai" name="tanggal_garansi_mulai">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_garansi_selesai">Tanggal Garansi Selesai</label>
                                <input type="date" class="form-control" id="tanggal_garansi_selesai" name="tanggal_garansi_selesai">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="vendor">Vendor</label>
                                <input type="text" class="form-control" id="vendor" name="vendor">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_invoice">No. Invoice</label>
                                <input type="text" class="form-control" id="no_invoice" name="no_invoice">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Import Excel -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Hardware dari Excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="importForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle"></i> Petunjuk Import:</h6>
                        <ul class="mb-0 small">
                            <li>Download template Excel terlebih dahulu untuk format yang benar</li>
                            <li>Isi data sesuai dengan kolom yang tersedia</li>
                            <li>Kolom yang wajib diisi ditandai dengan (*)</li>
                            <li>Format tanggal: YYYY-MM-DD (contoh: 2024-01-14)</li>
                            <li>Simpan sebagai format Excel (.xlsx) atau CSV</li>
                        </ul>
                    </div>
                    
                    <div class="form-group">
                        <label>Template Excel</label>
                        <div class="mb-3">
                            <a href="{{ route('hardware.template') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-download"></i> Download Template Excel
                            </a>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="file">Pilih File Excel <span class="text-danger">*</span></label>
                        <input type="file" class="form-control-file" id="file" name="file" accept=".xlsx,.xls,.csv" required>
                        <small class="form-text text-muted">Format yang didukung: Excel (.xlsx, .xls) dan CSV</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Detail Hardware -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Hardware</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="detailContent">
                <!-- Content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('javascripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .card-header {
        background-color: #4e73df;
        color: white;
    }
    .btn-custom {
        background-color: #4e73df;
        border-color: #4e73df;
        color: white;
    }
    .btn-custom:hover {
        background-color: #2e59d9;
        border-color: #2653d4;
        color: white;
    }
</style>

<script>
$(document).ready(function() {
    // Hardware Form Submit
    $('#hardwareForm').submit(function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        var url = $('#hardwareForm').data('action') || '{{ route("hardware.store") }}';
        var method = $('#hardwareForm').data('method') || 'POST';
        
        if (method === 'PUT') {
            formData.append('_method', 'PUT');
        }
        
        // Add CSRF token
        formData.append('_token', '{{ csrf_token() }}');
        
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    $('#hardwareModal').modal('hide');
                    Swal.fire('Berhasil!', response.message, 'success').then(() => {
                        location.reload(); // Reload page to show updated data
                    });
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').remove();
                    
                    $.each(errors, function(key, value) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).after('<div class="invalid-feedback">' + value[0] + '</div>');
                    });
                } else {
                    console.log('Error response:', xhr.responseJSON);
                    Swal.fire('Error!', xhr.responseJSON?.message || 'Terjadi kesalahan saat menyimpan data.', 'error');
                }
            }
        });
    });

    // Import Form Submit
    $('#importForm').submit(function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        
        // Add CSRF token
        formData.append('_token', '{{ csrf_token() }}');
        
        $.ajax({
            url: '{{ route("hardware.import") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    $('#importModal').modal('hide');
                    Swal.fire('Berhasil!', response.message, 'success').then(() => {
                        location.reload(); // Reload page to show imported data
                    });
                }
            },
            error: function(xhr) {
                console.log('Import error:', xhr.responseJSON);
                Swal.fire('Error!', xhr.responseJSON?.message || 'Terjadi kesalahan saat import data.', 'error');
            }
        });
    });

    // Search functionality
    $('#searchInput').on('keypress', function(e) {
        if (e.which === 13) { // Enter key
            searchHardware();
        }
    });

    // Per page change
    $('#perPage').change(function() {
        applyFilters();
    });
});

function addHardware() {
    $('#hardwareModalLabel').text('Tambah Hardware');
    $('#hardwareForm')[0].reset();
    $('#hardwareForm').removeData('action').removeData('method');
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();
    $('#hardwareModal').modal('show');
}

function editHardware(id) {
    $.get('{{ url("hardware") }}/' + id + '/edit', function(data) {
        $('#hardwareModalLabel').text('Edit Hardware');
        
        // Fill form with data
        $.each(data.hardware, function(key, value) {
            if (key === 'tanggal_pembelian' || key === 'tanggal_garansi_mulai' || key === 'tanggal_garansi_selesai') {
                // Format date for date input (YYYY-MM-DD)
                if (value && value !== null) {
                    var date = new Date(value);
                    if (!isNaN(date.getTime())) {
                        var formattedDate = date.getFullYear() + '-' + 
                                          String(date.getMonth() + 1).padStart(2, '0') + '-' + 
                                          String(date.getDate()).padStart(2, '0');
                        $('#' + key).val(formattedDate);
                    }
                }
            } else {
                $('#' + key).val(value);
            }
        });
        
        $('#hardwareForm').data('action', '{{ url("hardware") }}/' + id);
        $('#hardwareForm').data('method', 'PUT');
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();
        $('#hardwareModal').modal('show');
    });
}

function showHardware(id) {
    $.get('{{ url("hardware") }}/' + id, function(data) {
        var html = '<div class="row">';
        html += '<div class="col-md-6"><strong>Kode Hardware:</strong> ' + (data.kode_hardware || '-') + '</div>';
        html += '<div class="col-md-6"><strong>Nama Hardware:</strong> ' + (data.nama_hardware || '-') + '</div>';
        html += '<div class="col-md-6"><strong>Merk:</strong> ' + (data.merk || '-') + '</div>';
        html += '<div class="col-md-6"><strong>Model:</strong> ' + (data.model || '-') + '</div>';
        html += '<div class="col-md-6"><strong>Serial Number:</strong> ' + (data.serial_number || '-') + '</div>';
        html += '<div class="col-md-6"><strong>Kategori:</strong> ' + (data.kategori || '-') + '</div>';
        html += '<div class="col-md-12"><strong>Spesifikasi:</strong> ' + (data.spesifikasi || '-') + '</div>';
        html += '<div class="col-md-6"><strong>Status:</strong> ' + (data.status || '-') + '</div>';
        html += '<div class="col-md-6"><strong>Lokasi:</strong> ' + (data.lokasi || '-') + '</div>';
        html += '<div class="col-md-6"><strong>PIC Pengguna:</strong> ' + (data.pic_pengguna || '-') + '</div>';
        html += '<div class="col-md-6"><strong>Divisi:</strong> ' + (data.divisi || '-') + '</div>';
        html += '<div class="col-md-6"><strong>Tanggal Pembelian:</strong> ' + (data.tanggal_pembelian || '-') + '</div>';
        html += '<div class="col-md-6"><strong>Harga Pembelian:</strong> ' + (data.harga_pembelian ? 'Rp ' + Number(data.harga_pembelian).toLocaleString('id-ID') : '-') + '</div>';
        html += '<div class="col-md-6"><strong>Garansi Mulai:</strong> ' + (data.tanggal_garansi_mulai || '-') + '</div>';
        html += '<div class="col-md-6"><strong>Garansi Selesai:</strong> ' + (data.tanggal_garansi_selesai || '-') + '</div>';
        html += '<div class="col-md-6"><strong>Vendor:</strong> ' + (data.vendor || '-') + '</div>';
        html += '<div class="col-md-6"><strong>No. Invoice:</strong> ' + (data.no_invoice || '-') + '</div>';
        html += '<div class="col-md-12"><strong>Keterangan:</strong> ' + (data.keterangan || '-') + '</div>';
        html += '</div>';
        
        $('#detailContent').html(html);
        $('#detailModal').modal('show');
    });
}

function deleteHardware(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: 'Data hardware akan dihapus permanen!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '{{ url("hardware") }}/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        location.reload(); // Reload page to show updated data
                        Swal.fire('Berhasil!', response.message, 'success');
                    }
                },
                error: function(xhr) {
                    Swal.fire('Error!', 'Terjadi kesalahan saat menghapus data.', 'error');
                }
            });
        }
    });
}

function importExcel() {
    $('#importForm')[0].reset();
    $('#importModal').modal('show');
}

function exportExcel() {
    // Simple solution: direct download existing file and generate new one in background
    var today = new Date();
    var filename = 'hardware_export_' + today.getFullYear() + '-' + 
                  String(today.getMonth() + 1).padStart(2, '0') + '-' + 
                  String(today.getDate()).padStart(2, '0') + '.csv';
    
    // Trigger file generation in background
    $.get('{{ url("artisan/hardware-export") }}').always(function() {
        // Download regardless of generation result
        window.open('{{ url("") }}/' + filename, '_blank');
    });
}

function downloadTemplate() {
    window.location.href = '{{ route("hardware.template") }}';
}

function applyFilters() {
    var params = new URLSearchParams();
    
    var kategori = $('#filterKategori').val();
    if (kategori) params.append('kategori', kategori);
    
    var status = $('#filterStatus').val();
    if (status) params.append('status', status);
    
    var divisi = $('#filterDivisi').val();
    if (divisi) params.append('divisi', divisi);
    
    var perPage = $('#perPage').val();
    if (perPage) params.append('per_page', perPage);
    
    var search = $('#searchInput').val();
    if (search) params.append('search', search);
    
    var url = '{{ route("hardware.index") }}';
    if (params.toString()) {
        url += '?' + params.toString();
    }
    
    window.location.href = url;
}

function resetFilters() {
    $('#filterKategori').val('');
    $('#filterStatus').val('');
    $('#filterDivisi').val('');
    $('#searchInput').val('');
    $('#perPage').val('10');
    window.location.href = '{{ route("hardware.index") }}';
}

function searchHardware() {
    applyFilters();
}
</script>
@endsection
