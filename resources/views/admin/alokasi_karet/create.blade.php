@extends('admin.templates.partials.default')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Alokasi Karet</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('karet.index') }}">Alokasi Karet</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Form Tambah Alokasi Karet</h3>
                            <div class="card-tools">
                                <a href="{{ route('karet.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                        
                        <form action="{{ route('karet.store') }}" method="POST" id="alokasiForm">
                            @csrf
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tipe">Tipe</label>
                                            <select class="form-control" id="tipe" name="tipe" required>
                                                <option value="">-- Pilih Tipe --</option>
                                                <option value="Karet">Karet</option>
                                                <option value="Pisau">Pisau</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="nama_karet">Nama Karet</label>
                                            <input type="text" class="form-control" id="nama_karet" name="nama_karet" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="mc_kode">MC</label>
                                            <input type="text" class="form-control" id="mc_kode" name="mc_kode" required>
                                            <input type="hidden" id="mc_id" name="mc_id">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="sales_name">Sales Name</label>
                                            <select class="form-control" id="sales_name" name="sales_name" required>
                                                <option value="">-- Pilih Sales --</option>
                                                @foreach($sales as $sale)
                                                    <option value="{{ $sale->nama }}">{{ $sale->nama }} ({{ $sale->alias }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="kontrak">Kontrak M</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="kontrak" name="kontrak" placeholder="Pilih kontrak..." readonly required>
                                                <input type="hidden" id="kontrak_id" name="kontrak_id">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#kontrakModal">
                                                        <i class="fas fa-search"></i> Cari
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="customer_display">Customer (dari Kontrak)</label>
                                            <input type="text" class="form-control" id="customer_display" name="customer_display" placeholder="Akan terisi otomatis dari kontrak..." readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="bbm">Data BBM (Karet & Pisau)</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="bbm" name="bbm" placeholder="Pilih data BBM..." readonly required>
                                                <input type="hidden" id="bbm_id" name="bbm_id">
                                                <input type="hidden" id="kodebarang" name="kodebarang">
                                                <input type="hidden" id="namabarang" name="namabarang">
                                                <input type="hidden" id="nopo" name="nopo">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#bbmModal">
                                                        <i class="fas fa-search"></i> Pilih BBM
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tanggal">Tanggal</label>
                                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="subtotal">SubTotal</label>
                                            <input type="number" class="form-control" id="subtotal" name="subtotal" step="0.01" placeholder="0.00" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lokasi">Lokasi</label>
                                            <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Masukkan lokasi..." required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="gsm">GSM</label>
                                            <input type="number" class="form-control" id="gsm" name="gsm" step="0.001" placeholder="0.000" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="per_kg">PerKg</label>
                                            <input type="number" class="form-control" id="per_kg" name="per_kg" step="0.01" placeholder="0.00" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="alokasi">Alokasi</label>
                                            <input type="number" class="form-control" id="alokasi" name="alokasi" step="0.01" placeholder="0.00" required>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                                <a href="{{ route('karet.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Kontrak Modal -->
    <div class="modal fade" id="kontrakModal" tabindex="-1" role="dialog" aria-labelledby="kontrakModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kontrakModalLabel">Pilih Kontrak M</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <input type="text" id="kontrakSearch" class="form-control" placeholder="Cari kontrak...">
                        </div>
                        <div class="col-md-4">
                            <button type="button" id="searchKontrakBtn" class="btn btn-primary">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="kontrakTable">
                            <thead>
                                <tr>
                                    <th>No Kontrak</th>
                                    <th>Customer</th>
                                    <th>Nama Item</th>
                                    <th>Tanggal</th>
                                    <th>Harga Karet</th>
                                    <th>Harga Pisau</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data akan dimuat via AJAX -->
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div id="kontrakPagination" class="d-flex justify-content-between align-items-center mt-3" style="display: none !important;">
                        <div>
                            <span id="kontrakInfo">Menampilkan 0 dari 0 data</span>
                        </div>
                        <div>
                            <nav aria-label="Kontrak pagination">
                                <ul class="pagination pagination-sm mb-0" id="kontrakPaginationList">
                                    <!-- Pagination buttons will be generated here -->
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div id="kontrakLoading" class="text-center" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i> Loading...
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BBM Modal -->
    <div class="modal fade" id="bbmModal" tabindex="-1" role="dialog" aria-labelledby="bbmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bbmModalLabel">Pilih Data BBM (Karet & Pisau)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <input type="text" id="bbmSearch" class="form-control" placeholder="Cari data BBM..." style="text-transform: uppercase;">
                        </div>
                        <div class="col-md-4">
                            <button type="button" id="searchBbmBtn" class="btn btn-primary">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="bbmTable">
                            <thead>
                                <tr>
                                    <th>No Bukti</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>No OP</th>
                                    <th>No LC</th>
                                    <th>SubTotal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data akan dimuat via AJAX -->
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div id="bbmPagination" class="d-flex justify-content-between align-items-center mt-3" style="display: none !important;">
                        <div>
                            <span id="bbmInfo">Menampilkan 0 dari 0 data</span>
                        </div>
                        <div>
                            <nav aria-label="BBM pagination">
                                <ul class="pagination pagination-sm mb-0" id="bbmPaginationList">
                                    <!-- Pagination buttons will be generated here -->
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div id="bbmLoading" class="text-center" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i> Loading...
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>

$(document).ready(function() {
    let kontrakCurrentPage = 1;
    let kontrakCurrentSearch = '';
    let bbmCurrentPage = 1;
    let bbmCurrentSearch = '';
    
    // Function to format numbers with thousand separators
    function formatNumber(num) {
        if (num === null || num === undefined || num === '') return '0';
        return parseFloat(num).toLocaleString('id-ID');
    }
    
    // Add CSRF token to AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json'
        }
    });

    // Load Kontrak when modal is opened
    $('#kontrakModal').on('shown.bs.modal', function () {
        kontrakCurrentPage = 1;
        kontrakCurrentSearch = '';
        $('#kontrakSearch').val('');
        loadKontraks();
    });

    // Load BBM when modal is opened
    $('#bbmModal').on('shown.bs.modal', function () {
        bbmCurrentPage = 1;
        bbmCurrentSearch = '';
        $('#bbmSearch').val('');
        loadBbm();
    });

    // Search Kontrak functionality
    $('#searchKontrakBtn').click(function() {
        kontrakCurrentPage = 1;
        kontrakCurrentSearch = $('#kontrakSearch').val();
        loadKontraks(kontrakCurrentSearch);
    });

    // Search BBM functionality
    $('#searchBbmBtn').click(function() {
        bbmCurrentPage = 1;
        bbmCurrentSearch = $('#bbmSearch').val();
        loadBbm(bbmCurrentSearch);
    });

    // Search on enter key - Kontrak
    $('#kontrakSearch').keypress(function(e) {
        if(e.which == 13) {
            kontrakCurrentPage = 1;
            kontrakCurrentSearch = $(this).val();
            loadKontraks(kontrakCurrentSearch);
        }
    });

    // Search on enter key - BBM
    $('#bbmSearch').keypress(function(e) {
        if(e.which == 13) {
            bbmCurrentPage = 1;
            bbmCurrentSearch = $(this).val();
            loadBbm(bbmCurrentSearch);
        }
    });

    // Auto uppercase for BBM search
    $('#bbmSearch').on('input', function() {
        this.value = this.value.toUpperCase();
    });

    // Function to load Kontraks from API
    function loadKontraks(search = '', page = 1) {
        var tipe = $('#tipe').val();

        if (tipe === '') {
            alert('Silakan pilih tipe terlebih dahulu (Karet atau Pisau).');
            $('#kontrakLoading').hide();
            return;
        }

        $('#kontrakLoading').show();
        $('#kontrakTable tbody').empty();
        $('#kontrakPagination').hide();

        var apiUrl = window.location.origin + '/api/kontraks';

        $.ajax({
            url: apiUrl,
            method: 'GET',
            data: {
                search: search,
                page: page,
                per_page: 10
            },
            dataType: 'json',
            timeout: 10000,
            success: function(response) {
                // console.log('Kontrak API Response:', response);
                $('#kontrakLoading').hide();
                
                if(response.success && response.data && response.data.length > 0) {
                    // console.log('Found', response.data.length, 'kontraks');
                    $.each(response.data, function(index, kontrak) {
                        // console.log('Processing kontrak:', kontrak);
                        var row = '<tr>' +
                            '<td>' + (kontrak.NoKontrak || '-') + '</td>' +
                            '<td>' + (kontrak.Customer || '-') + '</td>' +
                            '<td>' + (kontrak.namaBarang || '-') + '</td>' +
                            '<td>' + (kontrak.TglKontrak || '-') + '</td>' +
                            '<td class="text-right">' + formatNumber(kontrak.HargaKaret || 0) + '</td>' +
                            '<td class="text-right">' + formatNumber(kontrak.HargaPisau || 0) + '</td>' +
                            '<td>' +
                                '<button type="button" class="btn btn-primary btn-sm select-kontrak" ' +
                                'data-id="' + (kontrak.id || kontrak.NoKontrak || '') + '" ' +
                                'data-nokontrak="' + (kontrak.NoKontrak || '') + '" ' +
                                'data-namabarang="' + (kontrak.namaBarang || '') + '" ' +
                                'data-mckode="' + (kontrak.mcKode || '') + '" ' +
                                'data-mc_id="' + (kontrak.mc_id || '') + '" ' +
                                'data-customer="' + (kontrak.Customer || '') + '" ' +
                                'data-tanggal="' + (kontrak.TglKontrak || '') + '" ' +
                                'data-karet="' + (kontrak.HargaKaret || 0) + '" ' +
                                'data-pisau="' + (kontrak.HargaPisau || 0) + '">' +
                                '<i class="fas fa-check"></i> Pilih' +
                                '</button>' +
                            '</td>' +
                        '</tr>';
                        $('#kontrakTable tbody').append(row);
                    });
                    
                    // Update pagination
                    updateKontrakPagination(response.pagination);
                } else {
                    console.log('No kontraks found or invalid response structure');
                    var message = response.message || 'Tidak ada data kontrak ditemukan';
                    if (!response.success) {
                        message = 'Error: ' + message;
                    }
                    $('#kontrakTable tbody').append(
                        '<tr><td colspan="6" class="text-center">' + message + '</td></tr>'
                    );
                    $('#kontrakPagination').hide();
                }
            },
            error: function(xhr, status, error) {
                console.error('Kontrak AJAX Error:', xhr, status, error);
                console.error('Response Text:', xhr.responseText);
                console.error('Status Code:', xhr.status);
                $('#kontrakLoading').hide();
                
                var errorMessage = 'Error loading kontraks: ' + error;
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.status === 0) {
                    errorMessage = 'Network error - please check if the server is running';
                } else if (xhr.status === 404) {
                    errorMessage = 'API endpoint not found (404)';
                } else if (xhr.status === 500) {
                    errorMessage = 'Server error (500) - check server logs';
                }
                
                $('#kontrakTable tbody').append(
                    '<tr><td colspan="6" class="text-center text-danger">' + errorMessage + '</td></tr>'
                );
                
                alert('Error loading kontraks: ' + errorMessage + '\nCheck browser console for more details.');
            }
        });
    }

    // Function to load BBM from API
    function loadBbm(search = '', page = 1) {
        $('#bbmLoading').show();
        $('#bbmTable tbody').empty();
        $('#bbmPagination').hide();

        var apiUrl = window.location.origin + '/api/bbm';

        $.ajax({
            url: apiUrl,
            method: 'GET',
            data: {
                search: search,
                page: page,
                per_page: 10
            },
            dataType: 'json',
            timeout: 10000,
            success: function(response) {
                // console.log('BBM API Response:', response);
                $('#bbmLoading').hide();
                
                if(response.success && response.data && response.data.length > 0) {
                    console.log('Found', response.data.length, 'BBM items');
                    $.each(response.data, function(index, bbm) {
                        console.log('Processing BBM:', bbm);
                        var row = '<tr>' +
                            '<td>' + (bbm.NoBukti || '-') + '</td>' +
                            '<td>' + (bbm.KodeBrg || '-') + '</td>' +
                            '<td>' + (bbm.NamaBrg || '-') + '</td>' +
                            '<td>' + (bbm.NoOP || '-') + '</td>' +
                            '<td>' + (bbm.NoLC || '-') + '</td>' +
                            '<td class="text-right">' + formatNumber(bbm.SubTotal || 0) + '</td>' +
                            '<td>' +
                                '<button type="button" class="btn btn-primary btn-sm select-bbm" ' +
                                'data-id="' + (bbm.id || '') + '" ' +
                                'data-nobukti="' + (bbm.NoBukti || '') + '" ' +
                                'data-kodebrg="' + (bbm.KodeBrg || '') + '" ' +
                                'data-namabrg="' + (bbm.NamaBrg || '') + '" ' +
                                'data-noop="' + (bbm.NoOP || '') + '" ' +
                                'data-nolc="' + (bbm.NoLC || '') + '" ' +
                                'data-subtotal="' + (bbm.SubTotal || 0) + '">' +
                                '<i class="fas fa-check"></i> Pilih' +
                                '</button>' +
                            '</td>' +
                        '</tr>';
                        $('#bbmTable tbody').append(row);
                    });
                    
                    // Update pagination
                    updateBbmPagination(response.pagination);
                } else {
                    console.log('No BBM found or invalid response structure');
                    var message = response.message || 'Tidak ada data BBM ditemukan';
                    if (!response.success) {
                        message = 'Error: ' + message;
                    }
                    $('#bbmTable tbody').append(
                        '<tr><td colspan="6" class="text-center">' + message + '</td></tr>'
                    );
                    $('#bbmPagination').hide();
                }
            },
            error: function(xhr, status, error) {
                console.error('BBM AJAX Error:', xhr, status, error);
                console.error('Response Text:', xhr.responseText);
                console.error('Status Code:', xhr.status);
                $('#bbmLoading').hide();
                
                var errorMessage = 'Error loading BBM: ' + error;
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.status === 0) {
                    errorMessage = 'Network error - please check if the server is running';
                } else if (xhr.status === 404) {
                    errorMessage = 'API endpoint not found (404)';
                } else if (xhr.status === 500) {
                    errorMessage = 'Server error (500) - check server logs';
                }
                
                $('#bbmTable tbody').append(
                    '<tr><td colspan="6" class="text-center text-danger">' + errorMessage + '</td></tr>'
                );
                
                alert('Error loading BBM: ' + errorMessage + '\nCheck browser console for more details.');
            }
        });
    }

    // Function to update Kontrak pagination
    function updateKontrakPagination(pagination) {
        if (!pagination || pagination.total === 0) {
            $('#kontrakPagination').hide();
            return;
        }

        // Update info
        $('#kontrakInfo').text(`Menampilkan ${pagination.from} sampai ${pagination.to} dari ${pagination.total} data`);

        // Generate pagination buttons
        var paginationHtml = '';
        
        // Previous button
        if (pagination.current_page > 1) {
            paginationHtml += '<li class="page-item">';
            paginationHtml += '<a class="page-link kontrak-page" href="#" data-page="' + (pagination.current_page - 1) + '">« Sebelumnya</a>';
            paginationHtml += '</li>';
        } else {
            paginationHtml += '<li class="page-item disabled">';
            paginationHtml += '<span class="page-link">« Sebelumnya</span>';
            paginationHtml += '</li>';
        }

        // Page numbers
        var startPage = Math.max(1, pagination.current_page - 2);
        var endPage = Math.min(pagination.total_pages, pagination.current_page + 2);

        if (startPage > 1) {
            paginationHtml += '<li class="page-item"><a class="page-link kontrak-page" href="#" data-page="1">1</a></li>';
            if (startPage > 2) {
                paginationHtml += '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
        }

        for (let i = startPage; i <= endPage; i++) {
            if (i === pagination.current_page) {
                paginationHtml += '<li class="page-item active"><span class="page-link">' + i + '</span></li>';
            } else {
                paginationHtml += '<li class="page-item"><a class="page-link kontrak-page" href="#" data-page="' + i + '">' + i + '</a></li>';
            }
        }

        if (endPage < pagination.total_pages) {
            if (endPage < pagination.total_pages - 1) {
                paginationHtml += '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
            paginationHtml += '<li class="page-item"><a class="page-link kontrak-page" href="#" data-page="' + pagination.total_pages + '">' + pagination.total_pages + '</a></li>';
        }

        // Next button
        if (pagination.current_page < pagination.total_pages) {
            paginationHtml += '<li class="page-item">';
            paginationHtml += '<a class="page-link kontrak-page" href="#" data-page="' + (pagination.current_page + 1) + '">Selanjutnya »</a>';
            paginationHtml += '</li>';
        } else {
            paginationHtml += '<li class="page-item disabled">';
            paginationHtml += '<span class="page-link">Selanjutnya »</span>';
            paginationHtml += '</li>';
        }

        $('#kontrakPaginationList').html(paginationHtml);
        $('#kontrakPagination').show();

        // Store current page
        kontrakCurrentPage = pagination.current_page;
    }

    // Function to update BBM pagination
    function updateBbmPagination(pagination) {
        if (!pagination || pagination.total === 0) {
            $('#bbmPagination').hide();
            return;
        }

        // Update info
        $('#bbmInfo').text(`Menampilkan ${pagination.from} sampai ${pagination.to} dari ${pagination.total} data`);

        // Generate pagination buttons
        var paginationHtml = '';
        
        // Previous button
        if (pagination.current_page > 1) {
            paginationHtml += '<li class="page-item">';
            paginationHtml += '<a class="page-link bbm-page" href="#" data-page="' + (pagination.current_page - 1) + '">« Sebelumnya</a>';
            paginationHtml += '</li>';
        } else {
            paginationHtml += '<li class="page-item disabled">';
            paginationHtml += '<span class="page-link">« Sebelumnya</span>';
            paginationHtml += '</li>';
        }

        // Page numbers
        var startPage = Math.max(1, pagination.current_page - 2);
        var endPage = Math.min(pagination.total_pages, pagination.current_page + 2);

        if (startPage > 1) {
            paginationHtml += '<li class="page-item"><a class="page-link bbm-page" href="#" data-page="1">1</a></li>';
            if (startPage > 2) {
                paginationHtml += '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
        }

        for (let i = startPage; i <= endPage; i++) {
            if (i === pagination.current_page) {
                paginationHtml += '<li class="page-item active"><span class="page-link">' + i + '</span></li>';
            } else {
                paginationHtml += '<li class="page-item"><a class="page-link bbm-page" href="#" data-page="' + i + '">' + i + '</a></li>';
            }
        }

        if (endPage < pagination.total_pages) {
            if (endPage < pagination.total_pages - 1) {
                paginationHtml += '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
            paginationHtml += '<li class="page-item"><a class="page-link bbm-page" href="#" data-page="' + pagination.total_pages + '">' + pagination.total_pages + '</a></li>';
        }

        // Next button
        if (pagination.current_page < pagination.total_pages) {
            paginationHtml += '<li class="page-item">';
            paginationHtml += '<a class="page-link bbm-page" href="#" data-page="' + (pagination.current_page + 1) + '">Selanjutnya »</a>';
            paginationHtml += '</li>';
        } else {
            paginationHtml += '<li class="page-item disabled">';
            paginationHtml += '<span class="page-link">Selanjutnya »</span>';
            paginationHtml += '</li>';
        }

        $('#bbmPaginationList').html(paginationHtml);
        $('#bbmPagination').show();

        // Store current page
        bbmCurrentPage = pagination.current_page;
    }

    // Handle pagination clicks - Kontrak
    $(document).on('click', '.kontrak-page[data-page]', function(e) {
        e.preventDefault();
        var page = $(this).data('page');
        kontrakCurrentPage = page;
        loadKontraks(kontrakCurrentSearch, page);
    });

    // Handle pagination clicks - BBM
    $(document).on('click', '.bbm-page[data-page]', function(e) {
        e.preventDefault();
        var page = $(this).data('page');
        bbmCurrentPage = page;
        loadBbm(bbmCurrentSearch, page);
    });

    // Handle Kontrak selection
    $(document).on('click', '.select-kontrak', function() {
        var tipe = document.getElementById('tipe').value;
        var kontrakId = $(this).data('id');
        var noKontrak = $(this).data('nokontrak');
        var customer = $(this).data('customer');
        var tanggal = $(this).data('tanggal');
        var pisau = $(this).data('pisau');
        var karet = $(this).data('karet');
        var namaBarang = $(this).data('namabarang');
        var mcKode = $(this).data('mckode');
        var mcId = $(this).data('mc_id');

        // console.log($(this).data);
        
        
        var kontrakDisplay = noKontrak + ' - ' + customer + ' (' + tanggal + ')';
        
        // console.log('Selected kontrak:', kontrakId, kontrakDisplay, 'Customer:', customer);

        if (tipe === 'Karet') {            
            $('#alokasi').val(karet);
        } else if (tipe === 'Pisau') {
            $('#alokasi').val(pisau);
        }
        
        $('#mc_kode').val(mcKode);
        
        $('#mc_id').val(mcId);
        $('#nama_karet').val(namaBarang);
        $('#kontrak_id').val(kontrakId);
        $('#kontrak').val(kontrakDisplay);
        $('#customer_display').val(customer);
        
        $('#kontrakModal').modal('hide');
    });

    // Handle BBM selection
    $(document).on('click', '.select-bbm', function() {
        var bbmId = $(this).data('id');
        var noBukti = $(this).data('nobukti');
        var kodeBrg = $(this).data('kodebrg');
        var namaBrg = $(this).data('namabrg');
        var noOP = $(this).data('noop');
        var noLC = $(this).data('nolc');
        var subTotal = $(this).data('subtotal');
        
        var bbmDisplay = noBukti + ' - ' + kodeBrg + ' (' + namaBrg + ') - SubTotal: ' + formatNumber(subTotal);
        
        console.log('Selected BBM:', bbmId, bbmDisplay);
        
        $('#bbm_id').val(bbmId);
        $('#bbm').val(bbmDisplay);
        $('#kodebarang').val(kodeBrg);
        $('#namabarang').val(namaBrg);
        $('#nopo').val(noOP);
        
        // Auto-fill subtotal field from BBM data
        $('#subtotal').val(subTotal);
        
        $('#bbmModal').modal('hide');
    });

    // Format number inputs on blur
    $('#subtotal, #per_kg, #alokasi').on('blur', function() {
        var value = parseFloat($(this).val()) || 0;
        $(this).val(value.toFixed(2));
    });
    
    // Format GSM with 3 decimal places
    $('#gsm').on('blur', function() {
        var value = parseFloat($(this).val()) || 0;
        $(this).val(value.toFixed(3));
    });
    
    // Form validation and submission
    $('#alokasiForm').on('submit', function(e) {
        e.preventDefault();
        
        // Validate required fields
        var tipe = $('#tipe').val();
        var namaKaret = $('#nama_karet').val();
        var mcKode = $('#mc_kode').val();
        var salesName = $('#sales_name').val();
        var kontrakId = $('#kontrak_id').val();
        var bbmId = $('#bbm_id').val();
        var tanggal = $('#tanggal').val();
        var subtotal = $('#subtotal').val();
        var lokasi = $('#lokasi').val();
        var gsm = $('#gsm').val();
        var perKg = $('#per_kg').val();
        var alokasi = $('#alokasi').val();
        
        // Check required fields
        if (!tipe) {
            alert('Pilih tipe terlebih dahulu!');
            return false;
        }
        if (!namaKaret) {
            alert('Masukkan nama karet!');
            return false;
        }
        if (!mcKode) {
            alert('Masukkan kode MC!');
            return false;
        }
        if (!salesName) {
            alert('Pilih sales name!');
            return false;
        }
        if (!kontrakId) {
            alert('Pilih kontrak terlebih dahulu!');
            return false;
        }
        if (!bbmId) {
            alert('Pilih data BBM terlebih dahulu!');
            return false;
        }
        if (!tanggal) {
            alert('Masukkan tanggal!');
            return false;
        }
        if (!subtotal || parseFloat(subtotal) <= 0) {
            alert('Masukkan subtotal yang valid!');
            return false;
        }
        if (!lokasi) {
            alert('Masukkan lokasi!');
            return false;
        }
        if (!gsm || parseFloat(gsm) <= 0) {
            alert('Masukkan GSM yang valid!');
            return false;
        }
        if (!perKg || parseFloat(perKg) <= 0) {
            alert('Masukkan PerKg yang valid!');
            return false;
        }
        if (!alokasi || parseFloat(alokasi) <= 0) {
            alert('Masukkan alokasi yang valid!');
            return false;
        }
        
        // Show loading state
        var submitBtn = $(this).find('button[type="submit"]');
        var originalText = submitBtn.html();
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
        
        // Debug: Log form data
        var formData = $(this).serializeArray();
        console.log('Form data being sent:', formData);
        
        // Submit form
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    alert('Data alokasi karet berhasil disimpan!');
                    window.location.href = '{{ route('karet.index') }}';
                } else {
                    alert('Error: ' + (response.message || 'Gagal menyimpan data'));
                    submitBtn.prop('disabled', false).html(originalText);
                }
            },
            error: function(xhr) {
                console.log('AJAX Error:', xhr.responseText);
                console.log('Status:', xhr.status);
                console.log('Response:', xhr.responseJSON);
                
                var errorMessage = 'Terjadi kesalahan saat menyimpan data.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    var errors = [];
                    $.each(xhr.responseJSON.errors, function(field, messages) {
                        errors.push(field + ': ' + messages.join(', '));
                    });
                    errorMessage = 'Validation Errors:\n' + errors.join('\n');
                }
                alert('Error: ' + errorMessage);
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });
    
    console.log('Alokasi Karet Create Page Loaded');
});
</script>
@endpush