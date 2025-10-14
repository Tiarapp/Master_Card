@extends('admin.templates.partials.default')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-edit mr-2"></i>Edit Retur Penjualan
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('barang.retur') }}">Retur Penjualan</a></li>
                        <li class="breadcrumb-item active">Edit</li>
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
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit mr-2"></i>Form Edit Retur Penjualan
                    </h3>
                    <div class="card-tools">
                        <span class="badge badge-info">{{ $retur->NoBukti }}</span>
                        <span class="badge {{ $retur->Blocked == 'Y' ? 'badge-success' : 'badge-danger' }}">
                            Blocked: {{ $retur->Blocked }}
                        </span>
                    </div>
                </div>
                
                <form action="{{ route('barang.retur.update', $retur->NoBukti) }}" method="POST">
                    @csrf
                    @method('PUT')
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
                                           value="{{ old('tanggal', $retur->TglRetur) }}"
                                           required>
                                    @error('tanggal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- No Bukti -->
                                <div class="form-group">
                                    <label for="kode">
                                        <i class="fas fa-barcode mr-1"></i>No Bukti
                                    </label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="kode" 
                                           value="{{ $retur->NoBukti }}"
                                           readonly>
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        No bukti tidak dapat diubah
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
                                               value="{{ old('KodeCust', $retur->KodeCust) }}"
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
                                           value="{{ old('NamaCust', $retur->NamaCust) }}"
                                           placeholder="Nama Customer"
                                           readonly
                                           required>
                                    @error('NamaCust')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Status Info -->
                                <div class="form-group">
                                    <label>Status Retur:</label>
                                    <div class="d-flex flex-wrap">
                                        <span class="badge badge-info mr-2">Aktif: {{ $retur->Aktif }}</span>
                                        <span class="badge badge-secondary mr-2">Print: {{ $retur->Print }}</span>
                                        <span class="badge {{ $retur->Blocked == 'Y' ? 'badge-success' : 'badge-danger' }}">
                                            Blocked: {{ $retur->Blocked }}
                                        </span>
                                    </div>
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Retur ini dapat diedit karena status Blocked = Y
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Surat Jalan Detail Section -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card card-outline card-warning">
                                    <div class="card-header">
                                        <h5 class="card-title">
                                            <i class="fas fa-truck mr-2"></i>Detail Retur Barang
                                        </h5>
                                        <div class="card-tools">
                                            <button type="button" 
                                                    class="btn btn-sm btn-warning" 
                                                    data-toggle="modal" 
                                                    data-target="#SuratJalanModal"
                                                    title="Tambah Detail Retur">
                                                <i class="fas fa-plus mr-1"></i>Tambah Detail
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
                                                    @if($returDetails && $returDetails->count() > 0)
                                                        @foreach($returDetails as $index => $detail)
                                                            <tr data-kode-brg="{{ $detail->KodeBrg }}" data-no-sj="{{ $detail->NomerSJ }}" data-counter="{{ $index + 1 }}">
                                                                <td>
                                                                    {{ $detail->NomerSJ }}
                                                                    <input type="hidden" name="sj_details[{{ $index + 1 }}][noSJ]" value="{{ $detail->NomerSJ }}">
                                                                </td>
                                                                <td>
                                                                    {{ $detail->KodeBrg }}
                                                                    <input type="hidden" name="sj_details[{{ $index + 1 }}][kodeBrg]" value="{{ $detail->KodeBrg }}">
                                                                </td>
                                                                <td>
                                                                    {{ $detail->NamaBrg }}
                                                                    <input type="hidden" name="sj_details[{{ $index + 1 }}][namaBrg]" value="{{ $detail->NamaBrg }}">
                                                                </td>
                                                                <td>
                                                                    <input type="number" 
                                                                           class="form-control form-control-sm qty-input" 
                                                                           name="sj_details[{{ $index + 1 }}][quantity]"
                                                                           value="{{ $detail->Quantity }}" 
                                                                           min="0.01" 
                                                                           step="0.01"
                                                                           data-counter="{{ $index + 1 }}"
                                                                           style="width: 80px;"
                                                                           required>
                                                                </td>
                                                                <td>
                                                                    <input type="text" 
                                                                           class="form-control form-control-sm keterangan-input" 
                                                                           name="sj_details[{{ $index + 1 }}][keterangan]"
                                                                           value="{{ $detail->Keterangan }}"
                                                                           placeholder="Masukkan keterangan retur..."
                                                                           data-counter="{{ $index + 1 }}"
                                                                           maxlength="200"
                                                                           required>
                                                                </td>
                                                                <td>
                                                                    <button type="button" class="btn btn-sm btn-danger remove-sj-detail" 
                                                                            data-counter="{{ $index + 1 }}"
                                                                            title="Hapus">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </td>
                                                                <input type="hidden" name="sj_details[{{ $index + 1 }}][reffNoUrut]" value="{{ $detail->ReffNoUrut }}">
                                                                <input type="hidden" name="sj_details[{{ $index + 1 }}][noUrut]" value="{{ $detail->ReffNoSJ }}">
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="6" class="text-center text-muted">
                                                                <i class="fas fa-info-circle mr-1"></i>
                                                                Belum ada detail retur yang ditambahkan
                                                            </td>
                                                        </tr>
                                                    @endif
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
                                    <div class="modal-header bg-warning text-dark">
                                        <h5 class="modal-title" id="SuratJalanModalLabel">
                                            <i class="fas fa-truck mr-2"></i>Tambah Detail Retur
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                                                            class="btn btn-outline-warning" 
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
                                                class="btn btn-warning" 
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
                                <div class="callout callout-warning">
                                    <h5><i class="fas fa-info mr-2"></i>Informasi Edit:</h5>
                                    <p class="mb-0">
                                        • <strong>Retur ini dapat diedit karena status Blocked = Y</strong><br>
                                        • No bukti tidak dapat diubah<br>
                                        • Tanggal dan customer dapat diubah<br>
                                        • Detail barang dapat ditambah, diubah, atau dihapus<br>
                                        • <strong>Quantity barang harus lebih dari 0</strong><br>
                                        • <strong>Keterangan detail wajib diisi untuk setiap barang</strong><br>
                                        • Data akan diupdate ke tabel TReturJual dan TDetReturJual
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
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save mr-1"></i>Update Retur
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
    if ($.fn.DataTable.isDataTable('#data_customer')) {
        $('#data_customer').DataTable().destroy();
    }
    
    $('#data_customer').DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "paging": true,
        "pageLength": 10,
        "drawCallback": function() {
            $('[data-toggle="tooltip"]').tooltip();
        },
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
    $(document).on('click', '.select-customer', function(e) {
        e.preventDefault();
        
        const button = $(this);
        const kode = button.data('kode');
        const nama = button.data('nama');

        if (!kode || !nama) {
            alert('Data customer tidak lengkap. Silakan coba lagi.');
            return;
        }

        $('#KodeCust').val(kode);
        $('#NamaCust').val(nama);

        $('#KodeCust').trigger('change');
        $('#NamaCust').trigger('change');

        $('#KodeCust').removeClass('is-invalid').addClass('is-valid');
        $('#NamaCust').removeClass('is-invalid').addClass('is-valid');

        $('#CustomerModal').modal('hide');
        
        if (typeof toastr !== 'undefined') {
            toastr.success('Customer berhasil dipilih: ' + nama);
        } else {
            alert('Customer berhasil dipilih: ' + nama);
        }
    });

    // Surat Jalan functionality
    let sjDetailsData = [];
    let sjDetailCounter = {{ $returDetails->count() }}; // Start from existing count

    // Load SJ Details
    $('#loadSJDetails').on('click', function() {
        const noSJ = $('#no_sj').val().trim();
        
        if (!noSJ) {
            alert('Silakan masukkan nomor surat jalan terlebih dahulu');
            return;
        }

        $('#sjLoadingMessage').show();
        $('#sjDetailsContainer').hide();
        $('#sjErrorMessage').hide();
        $('#addSelectedSJDetails').hide();

        const url = "{{ route('barang.get_sj', ['no_sj' => ':no_sj']) }}".replace(':no_sj', noSJ);

        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                $('#sjLoadingMessage').hide();
                
                if (response && response.length > 0) {
                    $('#sjDetailsTableBody').empty();
                    
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
                               min="0.01" 
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
                    <input type="hidden" name="sj_details[${sjDetailCounter}][reffNoUrut]" value="${reffNoUrut}">
                    <input type="hidden" name="sj_details[${sjDetailCounter}][noUrut]" value="${noUrut}">
                </tr>
            `;
            $('#sjDetailTableBody').append(row);
        });

        $('#SuratJalanModal').modal('hide');
        if (typeof toastr !== 'undefined') {
            toastr.success(`${selectedCheckboxes.length} detail barang berhasil ditambahkan`);
        } else {
            alert(`${selectedCheckboxes.length} detail barang berhasil ditambahkan`);
        }

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
            
            if ($('#sjDetailTableBody tr').length === 0) {
                const noDataRow = `
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            <i class="fas fa-info-circle mr-1"></i>
                            Belum ada detail retur yang ditambahkan
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
        if (e.which === 13) {
            $('#loadSJDetails').click();
        }
    });

    // Handle quantity input validation
    $(document).on('input', '.qty-input', function() {
        const value = parseFloat($(this).val());
        const minValue = parseFloat($(this).attr('min')) || 0.01;
        
        if (isNaN(value) || value < minValue) {
            $(this).addClass('is-invalid');
            $(this).attr('title', 'Quantity harus minimal ' + minValue);
        } else {
            $(this).removeClass('is-invalid');
            $(this).removeAttr('title');
        }
    });

    // Handle quantity input on blur
    $(document).on('blur', '.qty-input', function() {
        const value = parseFloat($(this).val());
        const minValue = parseFloat($(this).attr('min')) || 0.01;
        
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
        
        if (sjDetailRows.length === 0) {
            return { valid: false, message: 'Silakan tambahkan minimal satu detail retur!' };
        }

        let hasInvalidQty = false;
        let hasEmptyKeterangan = false;
        
        sjDetailRows.each(function() {
            const row = $(this);
            const qtyInput = row.find('.qty-input');
            const keteranganInput = row.find('.keterangan-input');
            
            // Validate quantity
            const qtyValue = parseFloat(qtyInput.val());
            const minValue = parseFloat(qtyInput.attr('min')) || 0.01;
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
                hasInvalidQty = true;
                keteranganInput.addClass('is-invalid');
            } else {
                keteranganInput.removeClass('is-invalid');
            }
        });

        if (hasInvalidQty) {
            return { valid: false, message: 'Pastikan semua quantity barang valid (minimal 0.01) dan keterangan tidak lebih dari 200 karakter!' };
        }

        if (hasEmptyKeterangan) {
            return { valid: false, message: 'Pastikan semua keterangan detail sudah diisi!' };
        }

        return { valid: true };
    }

    // Validasi form sebelum submit
    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const tanggal = document.getElementById('tanggal').value;
        const kodeCust = document.getElementById('KodeCust').value;
        const namaCust = document.getElementById('NamaCust').value;

        // Validate basic fields
        if (!tanggal || !kodeCust || !namaCust) {
            alert('Semua field yang wajib harus diisi! Pastikan Customer sudah dipilih.');
            return false;
        }

        // Validate SJ details
        const validation = validateSJDetailData();
        if (!validation.valid) {
            alert(validation.message);
            return false;
        }

        // Submit the form
        const form = document.querySelector('form');
        form.submit();
    });

    // Tooltip initialization
    $('[data-toggle="tooltip"]').tooltip();
    
    // Initialize toastr for notifications (if available)
    if (typeof toastr !== 'undefined') {
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000"
        };
    }
});
</script>

@endsection