@extends('admin.templates.partials.default')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-plus mr-2"></i>Tambah Retur Penjualan
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('barang.retur') }}">Retur Penjualan</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
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
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Error!</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Card -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit mr-2"></i>Form Retur Penjualan
                    </h3>
                </div>
                
                <form action="{{ route('barang.retur.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <!-- Kolom Kiri -->
                            <div class="col-md-6">
                                <!-- Tanggal -->
                                <div class="form-group">
                                    <label for="tanggal">
                                        <i class="fas fa-calendar-alt mr-1"></i>Tanggal <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" 
                                           class="form-control @error('tanggal') is-invalid @enderror" 
                                           id="tanggal" 
                                           name="tanggal" 
                                           value="{{ old('tanggal', date('Y-m-d')) }}"
                                           required>
                                    @error('tanggal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- No Bukti -->
                                <div class="form-group">
                                    <label for="kode">
                                        <i class="fas fa-barcode mr-1"></i>No Bukti <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('kode') is-invalid @enderror" 
                                           id="kode" 
                                           name="kode" 
                                           value="{{ old('kode') }}"
                                           readonly
                                           placeholder="No bukti akan dibuat otomatis">
                                    @error('kode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        No bukti akan dibuat otomatis berdasarkan tanggal
                                    </small>
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="col-md-6">
                                

                                <!-- Customer -->
                                <div class="form-group">
                                    <label for="customer">
                                        <i class="fas fa-user mr-1"></i>Customer <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input type="text" 
                                               class="form-control @error('KodeCust') is-invalid @enderror" 
                                               id="KodeCust" 
                                               name="KodeCust" 
                                               value="{{ old('KodeCust') }}"
                                               placeholder="Kode Customer"
                                               readonly
                                               required>
                                        <div class="input-group-append">
                                            <button type="button" 
                                                    class="btn btn-outline-secondary" 
                                                    data-toggle="modal" 
                                                    data-target="#CustomerModal"
                                                    title="Pilih Customer">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                        @error('KodeCust')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <input type="text" 
                                           class="form-control mt-2 @error('NamaCust') is-invalid @enderror" 
                                           id="NamaCust" 
                                           name="NamaCust" 
                                           value="{{ old('NamaCust') }}"
                                           placeholder="Nama Customer"
                                           readonly
                                           required>
                                    @error('NamaCust')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Surat Jalan Detail Section -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card card-outline card-info">
                                    <div class="card-header">
                                        <h5 class="card-title">
                                            <i class="fas fa-truck mr-2"></i>Detail Surat Jalan
                                        </h5>
                                        <div class="card-tools">
                                            <button type="button" 
                                                    class="btn btn-sm btn-primary" 
                                                    data-toggle="modal" 
                                                    data-target="#SuratJalanModal"
                                                    title="Tambah Detail Surat Jalan">
                                                <i class="fas fa-plus mr-1"></i>Tambah Detail SJ
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped" id="sjDetailTable">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th width="12%">No SJ</th>
                                                        <th width="12%">Kode Barang</th>
                                                        <th width="25%">Nama Barang</th>
                                                        <th width="8%">Qty</th>
                                                        <th width="25%">Keterangan</th>
                                                        <th width="8%">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="sjDetailTableBody">
                                                    <tr>
                                                        <td colspan="6" class="text-center text-muted">
                                                            <i class="fas fa-info-circle mr-1"></i>
                                                            Belum ada detail surat jalan yang ditambahkan
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Surat Jalan Modal -->
                        <div class="modal fade" id="SuratJalanModal" tabindex="-1" role="dialog" aria-labelledby="SuratJalanModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-info text-white">
                                        <h5 class="modal-title" id="SuratJalanModalLabel">
                                            <i class="fas fa-truck mr-2"></i>Tambah Detail Surat Jalan
                                        </h5>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="no_sj">
                                                <i class="fas fa-barcode mr-1"></i>Nomor Surat Jalan <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <input type="text" 
                                                       class="form-control" 
                                                       id="no_sj" 
                                                       placeholder="Masukkan nomor surat jalan">
                                                <div class="input-group-append">
                                                    <button type="button" 
                                                            class="btn btn-outline-primary" 
                                                            id="loadSJDetails"
                                                            title="Load Detail SJ">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <small class="form-text text-muted">
                                                <i class="fas fa-info-circle mr-1"></i>
                                                Masukkan nomor surat jalan dan klik tombol cari untuk memuat detail
                                            </small>
                                        </div>

                                        <div id="sjDetailsContainer" style="display: none;">
                                            <hr>
                                            <h6><i class="fas fa-list mr-1"></i>Detail Barang:</h6>
                                            <div class="table-responsive">
                                                <table class="table table-sm table-bordered">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Pilih</th>
                                                            <th>Kode Barang</th>
                                                            <th>Nama Barang</th>
                                                            <th>Qty</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="sjDetailsTableBody">
                                                        <!-- Detail akan dimuat di sini -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div id="sjLoadingMessage" style="display: none;">
                                            <div class="text-center">
                                                <i class="fas fa-spinner fa-spin mr-2"></i>Loading detail surat jalan...
                                            </div>
                                        </div>

                                        <div id="sjErrorMessage" style="display: none;">
                                            <div class="alert alert-warning">
                                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                                <span id="sjErrorText">Data surat jalan tidak ditemukan</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                            <i class="fas fa-times mr-1"></i>Tutup
                                        </button>
                                        <button type="button" 
                                                class="btn btn-primary" 
                                                id="addSelectedSJDetails"
                                                style="display: none;">
                                            <i class="fas fa-plus mr-1"></i>Tambah Detail Terpilih
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Selection Modal -->
                        <div class="modal fade" id="CustomerModal" tabindex="-1" role="dialog" aria-labelledby="CustomerModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="CustomerModalLabel">
                                            <i class="fas fa-users mr-2"></i>Pilih Customer
                                        </h5>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped" id="data_customer">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>Kode</th>
                                                        <th>Nama Customer</th>
                                                        <th>Alamat Kantor</th>
                                                        <th>Kota Kantor</th>
                                                        <th>Alamat Kirim</th>
                                                        <th>Kota Kirim</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($cust as $customer)
                                                        <tr>
                                                            <td>{{ $customer->Kode }}</td>
                                                            <td>{{ $customer->Nama }}</td>
                                                            <td>{{ $customer->AlamatKantor }}</td>
                                                            <td>{{ $customer->KotaKantor }}</td>
                                                            <td>{{ $customer->AlamatKirim }}</td>
                                                            <td>{{ $customer->KotaKirim }}</td>
                                                            <td>
                                                                <button type="button" 
                                                                        class="btn btn-sm btn-success select-customer"
                                                                        data-kode="{{ $customer->Kode }}"
                                                                        data-nama="{{ $customer->Nama }}"
                                                                        data-alamat-kantor="{{ $customer->AlamatKantor }}"
                                                                        data-kota-kantor="{{ $customer->KotaKantor }}"
                                                                        data-alamat-kirim="{{ $customer->AlamatKirim }}"
                                                                        data-kota-kirim="{{ $customer->KotaKirim }}"
                                                                        data-top="{{ $customer->WAKTUBAYAR }}">
                                                                    <i class="fas fa-check mr-1"></i>Pilih
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                            <i class="fas fa-times mr-1"></i>Tutup
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Info Box -->
                        <div class="row">
                            <div class="col-12">
                                <div class="callout callout-info">
                                    <h5><i class="fas fa-info mr-2"></i>Informasi:</h5>
                                    <p class="mb-0">
                                        • Tanggal akan menentukan format nomor bukti (RA-2YYMM###)<br>
                                        • Customer wajib dipilih dari daftar customer yang tersedia<br>
                                        • Gunakan tombol "Tambah Detail SJ" untuk menambahkan detail surat jalan yang akan diretur<br>
                                        • Masukkan nomor surat jalan dan pilih barang yang akan diretur<br>
                                        • <strong>Quantity barang bisa diedit sesuai kebutuhan (minimal 1)</strong><br>
                                        • <strong>Keterangan detail wajib diisi untuk setiap barang (maksimal 200 karakter)</strong><br>
                                        • Data akan disimpan ke tabel TReturJual
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-12 text-right">
                                <a href="{{ route('barang.retur') }}" class="btn btn-secondary mr-2">
                                    <i class="fas fa-times mr-1"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-1"></i>Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize DataTable for customer selection
    $('#data_customer').DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "paging": true,
        "pageLength": 10,
        "language": {
            "search": "Cari Customer:",
            "lengthMenu": "Tampilkan _MENU_ data per halaman",
            "zeroRecords": "Tidak ada data customer yang ditemukan",
            "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
            "infoEmpty": "Tidak ada data yang tersedia",
            "infoFiltered": "(difilter dari _MAX_ total data)",
            "paginate": {
                "first": "Pertama",
                "last": "Terakhir", 
                "next": "Selanjutnya",
                "previous": "Sebelumnya"
            }
        }
    });

    // Customer selection functionality
    $('.select-customer').on('click', function() {
        const kode = $(this).data('kode');
        const nama = $(this).data('nama');

        // Fill customer fields
        $('#KodeCust').val(kode);
        $('#NamaCust').val(nama);

        // Close modal
        $('#CustomerModal').modal('hide');
        
        // Show success message
        toastr.success('Customer berhasil dipilih: ' + nama);
    });

    // Auto generate kode saat tanggal berubah
    document.getElementById('tanggal').addEventListener('change', function(){
        const route = "{{ route('barang.retur.get_kode', ['tanggal' => ':tanggal']) }}"
        const tanggal = this.value;

        if (tanggal) {
            const finalRoute = route.replace(':tanggal', tanggal);

            fetch(finalRoute)
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    }
                    throw new Error('Network response was not ok');
                })
                .then(data => {
                    document.getElementById('kode').value = data['kode'];
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat membuat nomor bukti');
                });
        }
    });

    // Auto generate kode saat halaman dimuat jika tanggal sudah terisi
    const tanggalInput = document.getElementById('tanggal');
    if (tanggalInput.value) {
        tanggalInput.dispatchEvent(new Event('change'));
    }

    // Surat Jalan functionality
    let sjDetailsData = [];
    let sjDetailCounter = 0;

    // Load SJ Details
    $('#loadSJDetails').on('click', function() {
        const noSJ = $('#no_sj').val().trim();
        
        if (!noSJ) {
            alert('Silakan masukkan nomor surat jalan terlebih dahulu');
            return;
        }

        // Show loading
        $('#sjLoadingMessage').show();
        $('#sjDetailsContainer').hide();
        $('#sjErrorMessage').hide();
        $('#addSelectedSJDetails').hide();

        // Debug: Show the URL being called
        const url = "{{ route('barang.get_sj', ['no_sj' => ':no_sj']) }}".replace(':no_sj', noSJ);
        console.log('Calling URL:', url);

        // Make AJAX call to get SJ details
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                $('#sjLoadingMessage').hide();
                console.log('Response received:', response);
                
                if (response && response.length > 0) {
                    // Clear previous data
                    $('#sjDetailsTableBody').empty();
                    
                    // Populate table with SJ details
                    response.forEach(function(item, index) {
                        const row = `
                            <tr>
                                <td>
                                    <input type="checkbox" class="sj-detail-checkbox" 
                                           data-kode-brg="${item.KodeBrg}"
                                           data-nama-brg="${item.NamaBrg}"
                                           data-quantity="${item.Quantity}"
                                           data-no-urut="${item.NoUrut}"
                                           data-reff-no-urut="${item.ReffNoUrut}"
                                           value="${index}">
                                </td>
                                <td>${item.KodeBrg}</td>
                                <td>${item.NamaBrg}</td>
                                <td>${item.Quantity}</td>
                            </tr>
                        `;
                        $('#sjDetailsTableBody').append(row);
                    });
                    
                    sjDetailsData = response;
                    $('#sjDetailsContainer').show();
                    $('#addSelectedSJDetails').show();
                } else {
                    $('#sjErrorMessage').show();
                    if (response.message) {
                        $('#sjErrorText').text(response.message);
                    } else {
                        $('#sjErrorText').text('Data surat jalan tidak ditemukan atau tidak memiliki detail barang');
                    }
                }
            },
            error: function(xhr, status, error) {
                $('#sjLoadingMessage').hide();
                $('#sjErrorMessage').show();
                console.error('AJAX Error:', xhr.responseText);
                
                // Try to get error message from response
                let errorMsg = 'Terjadi kesalahan saat memuat data: ' + error;
                try {
                    const errorResponse = JSON.parse(xhr.responseText);
                    if (errorResponse.error) {
                        errorMsg = errorResponse.error;
                    }
                } catch (e) {
                    // Keep default error message
                }
                
                $('#sjErrorText').text(errorMsg);
            }
        });
    });

    // Add selected SJ details to main table
    $('#addSelectedSJDetails').on('click', function() {
        const selectedCheckboxes = $('.sj-detail-checkbox:checked');
        const noSJ = $('#no_sj').val().trim();
        
        if (selectedCheckboxes.length === 0) {
            alert('Silakan pilih minimal satu detail barang');
            return;
        }

        // Clear "no data" row if exists
        if ($('#sjDetailTableBody tr').length === 1 && $('#sjDetailTableBody tr').first().find('td').length === 1) {
            $('#sjDetailTableBody').empty();
        }

        selectedCheckboxes.each(function() {
            const checkbox = $(this);
            const kodeBrg = checkbox.data('kode-brg');
            const namaBrg = checkbox.data('nama-brg');
            const quantity = checkbox.data('quantity');
            const noUrut = checkbox.data('no-urut');
            const reffNoUrut = checkbox.data('reff-no-urut');

            // Check if this item is already added
            const existingRow = $(`#sjDetailTableBody tr[data-kode-brg="${kodeBrg}"][data-no-sj="${noSJ}"]`);
            if (existingRow.length > 0) {
                alert(`Barang ${kodeBrg} dari SJ ${noSJ} sudah ada dalam daftar`);
                return;
            }

            sjDetailCounter++;
            const row = `
                <tr data-kode-brg="${kodeBrg}" data-no-sj="${noSJ}" data-counter="${sjDetailCounter}">
                    <td>
                        ${noSJ}
                        <input type="hidden" name="sj_details[${sjDetailCounter}][noSJ]" value="${noSJ}">
                    </td>
                    <td>
                        ${kodeBrg}
                        <input type="hidden" name="sj_details[${sjDetailCounter}][kodeBrg]" value="${kodeBrg}">
                    </td>
                    <td>
                        ${namaBrg}
                        <input type="hidden" name="sj_details[${sjDetailCounter}][namaBrg]" value="${namaBrg}">
                    </td>
                    <td>
                        <input type="number" 
                               class="form-control form-control-sm qty-input" 
                               name="sj_details[${sjDetailCounter}][quantity]"
                               value="${quantity}" 
                               min="1" 
                               step="0.01"
                               data-counter="${sjDetailCounter}"
                               style="width: 80px;"
                               required>
                    </td>
                    <td>
                        <input type="text" 
                               class="form-control form-control-sm keterangan-input" 
                               name="sj_details[${sjDetailCounter}][keterangan]"
                               placeholder="Masukkan keterangan retur..."
                               data-counter="${sjDetailCounter}"
                               maxlength="200"
                               required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger remove-sj-detail" 
                                data-counter="${sjDetailCounter}"
                                title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            $('#sjDetailTableBody').append(row);
        });

        // Close modal and show success message
        $('#SuratJalanModal').modal('hide');
        if (typeof toastr !== 'undefined') {
            toastr.success(`${selectedCheckboxes.length} detail barang berhasil ditambahkan`);
        } else {
            alert(`${selectedCheckboxes.length} detail barang berhasil ditambahkan`);
        }

        // Clear modal form
        $('#no_sj').val('');
        $('#sjDetailsContainer').hide();
        $('#sjErrorMessage').hide();
        $('#addSelectedSJDetails').hide();
        sjDetailsData = [];
    });

    // Remove SJ detail from main table
    $(document).on('click', '.remove-sj-detail', function() {
        if (confirm('Apakah Anda yakin ingin menghapus detail ini?')) {
            $(this).closest('tr').remove();
            
            // Show "no data" message if table is empty
            if ($('#sjDetailTableBody tr').length === 0) {
                const noDataRow = `
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            <i class="fas fa-info-circle mr-1"></i>
                            Belum ada detail surat jalan yang ditambahkan
                        </td>
                    </tr>
                `;
                $('#sjDetailTableBody').append(noDataRow);
            }
            
            if (typeof toastr !== 'undefined') {
                toastr.success('Detail barang berhasil dihapus');
            }
        }
    });

    // Allow Enter key to trigger load SJ details
    $('#no_sj').on('keypress', function(e) {
        if (e.which === 13) { // Enter key
            $('#loadSJDetails').click();
        }
    });

    // Handle quantity input validation
    $(document).on('input', '.qty-input', function() {
        const value = parseFloat($(this).val());
        const minValue = parseFloat($(this).attr('min')) || 1;
        
        if (isNaN(value) || value < minValue) {
            $(this).addClass('is-invalid');
            $(this).attr('title', 'Quantity harus minimal ' + minValue);
        } else {
            $(this).removeClass('is-invalid');
            $(this).removeAttr('title');
        }
    });

    // Handle quantity input on blur (when user leaves the field)
    $(document).on('blur', '.qty-input', function() {
        const value = parseFloat($(this).val());
        const minValue = parseFloat($(this).attr('min')) || 1;
        
        if (isNaN(value) || value < minValue) {
            $(this).val(minValue);
            $(this).removeClass('is-invalid');
            if (typeof toastr !== 'undefined') {
                toastr.warning('Quantity telah disesuaikan ke nilai minimum: ' + minValue);
            }
        }
    });

    // Handle keterangan input validation
    $(document).on('input', '.keterangan-input', function() {
        const value = $(this).val().trim();
        
        if (value.length === 0) {
            $(this).addClass('is-invalid');
            $(this).attr('title', 'Keterangan tidak boleh kosong');
        } else if (value.length > 200) {
            $(this).addClass('is-invalid');
            $(this).attr('title', 'Keterangan maksimal 200 karakter');
        } else {
            $(this).removeClass('is-invalid');
            $(this).removeAttr('title');
        }
    });

    // Function to validate all SJ detail data
    function validateSJDetailData() {
        const sjDetailRows = $('#sjDetailTableBody tr:not(:has(td[colspan]))');
        console.log('Validating SJ Detail Data for', sjDetailRows.length, 'rows...');
        
        if (sjDetailRows.length === 0) {
            return { valid: false, message: 'Silakan tambahkan minimal satu detail surat jalan!' };
        }

        let hasInvalidQty = false;
        let hasEmptyKeterangan = false;
        
        sjDetailRows.each(function() {
            const row = $(this);
            const qtyInput = row.find('.qty-input');
            const keteranganInput = row.find('.keterangan-input');
            
            // Validate quantity
            const qtyValue = parseFloat(qtyInput.val());
            const minValue = parseFloat(qtyInput.attr('min')) || 1;
            if (isNaN(qtyValue) || qtyValue < minValue) {
                hasInvalidQty = true;
                qtyInput.addClass('is-invalid');
            } else {
                qtyInput.removeClass('is-invalid');
            }
            
            // Validate keterangan
            const keteranganValue = keteranganInput.val().trim();
            if (keteranganValue.length === 0) {
                hasEmptyKeterangan = true;
                keteranganInput.addClass('is-invalid');
            } else if (keteranganValue.length > 200) {
                hasInvalidQty = true; // Use same flag for simplicity
                keteranganInput.addClass('is-invalid');
            } else {
                keteranganInput.removeClass('is-invalid');
            }
        });

        if (hasInvalidQty) {
            return { valid: false, message: 'Pastikan semua quantity barang valid (minimal 1) dan keterangan tidak lebih dari 200 karakter!' };
        }

        if (hasEmptyKeterangan) {
            return { valid: false, message: 'Pastikan semua keterangan detail sudah diisi!' };
        }

        return { valid: true };
    }

    // Validasi form sebelum submit
    document.querySelector('form').addEventListener('submit', function(e) {
        // Always prevent default submission first
        e.preventDefault();
        console.log('Form submission started...');
        
        const tanggal = document.getElementById('tanggal').value;
        const kode = document.getElementById('kode').value;
        const kodeCust = document.getElementById('KodeCust').value;
        const namaCust = document.getElementById('NamaCust').value;

        console.log('Basic form fields:', { tanggal, kode, kodeCust, namaCust });

        // Validate basic fields
        if (!tanggal || !kode || !kodeCust || !namaCust) {
            alert('Semua field yang wajib harus diisi! Pastikan Customer sudah dipilih.');
            return false;
        }

        // Validate SJ details
        const validation = validateSJDetailData();
        if (!validation.valid) {
            alert(validation.message);
            return false;
        }

        // Debug: Log all form data before submission
        const form = document.querySelector('form');
        const formData = new FormData(form);
        console.log('=== FORM DATA BEFORE SUBMIT ===');
        for (let [key, value] of formData.entries()) {
            console.log(`${key}: ${value}`);
        }
        console.log('=== END FORM DATA ===');
        
        console.log('All validation passed, submitting form...');
        // Now submit the form
        form.submit();
    });

    // Tooltip initialization
    $('[data-toggle="tooltip"]').tooltip();
    
    // Initialize toastr for notifications (if available)
    if (typeof toastr !== 'undefined') {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
    }
});
</script>

@endsection