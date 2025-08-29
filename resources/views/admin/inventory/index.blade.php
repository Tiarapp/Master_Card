@extends('admin.templates.partials.default')

<!-- Select2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css" />

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

/* Compact Action Buttons */
.btn-xs {
    padding: 0.25rem 0.4rem;
    font-size: 0.75rem;
    line-height: 1.2;
    border-radius: 0.2rem;
    min-width: 28px;
    min-height: 28px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-xs i {
    font-size: 0.75rem;
}

/* Action column width */
td:last-child {
    min-width: 120px;
    width: 120px;
}

/* Select2 Styling */
.select2-container {
    width: 100% !important;
}

.select2-container--bootstrap4 .select2-selection--single {
    height: 38px !important;
    border: 1px solid #ced4da !important;
    border-radius: 0.25rem !important;
    padding: 0 !important;
}

.select2-container--bootstrap4 .select2-selection__rendered {
    line-height: 36px !important;
    padding-left: 12px !important;
    padding-right: 20px !important;
    color: #495057 !important;
    font-size: 14px !important;
}

.select2-container--bootstrap4 .select2-selection__arrow {
    height: 36px !important;
    right: 10px !important;
    top: 1px !important;
}

.select2-container--bootstrap4 .select2-selection__arrow b {
    border-color: #999 transparent transparent transparent !important;
    border-style: solid !important;
    border-width: 5px 4px 0 4px !important;
    height: 0 !important;
    left: 50% !important;
    margin-left: -4px !important;
    margin-top: -2px !important;
    position: absolute !important;
    top: 50% !important;
    width: 0 !important;
}

.select2-container--bootstrap4.select2-container--open .select2-selection__arrow b {
    border-color: transparent transparent #999 transparent !important;
    border-width: 0 4px 5px 4px !important;
}

.select2-container--bootstrap4 .select2-dropdown {
    border: 1px solid #ced4da !important;
    border-radius: 0.25rem !important;
}

.select2-container--bootstrap4 .select2-search--dropdown .select2-search__field {
    border: 1px solid #ced4da !important;
    border-radius: 0.25rem !important;
    padding: 6px 12px !important;
}

.select2-container--bootstrap4 .select2-results__option {
    padding: 6px 12px !important;
}

.select2-container--bootstrap4 .select2-results__option--highlighted {
    background-color: #007bff !important;
    color: white !important;
}

.form-control:focus {
    box-shadow: none;
    border-color: #007bff;
    background-color: #f8f9fa;
}
.btn-primary:focus, .btn-primary:active {
    box-shadow: none !important;
}
.rounded-pill {
    border-radius: 50rem !important;
}
@media (max-width: 576px) {
    .ms-auto form {
        flex-direction: column;
        max-width: 100%;
    }
    .ms-auto input {
        width: 100% !important;
        margin-bottom: 8px;
    }
}
</style>

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Inventory</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Inventory</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

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

      <!-- Filter Section -->
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
          <h6 class="mb-0"><i class="fas fa-filter me-2"></i>Filter Data</h6>
        </div>
        <div class="card-body">
          <form action="{{ route('inventory.index') }}" method="GET" id="filterForm">
            <div class="row align-items-end">
              <div class="col-md-2">
                <label for="jenis_filter" class="form-label">Filter Jenis</label>
                <select class="form-control" id="jenis_filter" name="jenis_filter">
                  <option value="">Semua Jenis</option>
                  @foreach($jenisOptions as $jenis)
                    <option value="{{ $jenis }}" {{ request('jenis_filter') == $jenis ? 'selected' : '' }}>
                      {{ $jenis }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-2">
                <label for="gsm_filter" class="form-label">Filter GSM</label>
                <select class="form-control" id="gsm_filter" name="gsm_filter">
                  <option value="">Semua GSM</option>
                  @foreach($gsmOptions as $gsm)
                    <option value="{{ $gsm }}" {{ request('gsm_filter') == $gsm ? 'selected' : '' }}>
                      {{ $gsm }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-2">
                <label for="lebar_filter" class="form-label">Filter Lebar</label>
                <select class="form-control" id="lebar_filter" name="lebar_filter">
                  <option value="">Semua Lebar</option>
                  @foreach($lebarOptions as $lebar)
                    <option value="{{ $lebar }}" {{ request('lebar_filter') == $lebar ? 'selected' : '' }}>
                      {{ $lebar }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-3">
                <label for="supplier_filter" class="form-label">Filter Supplier</label>
                <select class="form-control" id="supplier_filter" name="supplier_filter">
                  <option value="">Semua Supplier</option>
                  @foreach($supplier as $sup)
                    <option value="{{ $sup->id }}" {{ request('supplier_filter') == $sup->id ? 'selected' : '' }}>
                      {{ $sup->name }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-3">
                <div class="d-flex gap-2">
                  <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter me-1"></i> Terapkan Filter
                  </button>
                  <a href="{{ route('inventory.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-sync-alt me-1"></i> Reset
                  </a>
                </div>
              </div>
            </div>
            
            <!-- Hidden field to preserve search term when filtering -->
            @if(request('search'))
              <input type="hidden" name="search" value="{{ request('search') }}">
            @endif
          </form>
        </div>
      </div>

      <div class="row mb-4 align-items-center">
        <div class="col-md-8 d-flex align-items-center gap-3">
            <a href="{{ route('inventory.create') }}" class="btn btn-primary d-flex align-items-center shadow-sm mb-2">
                <i class="fas fa-plus-circle me-2"></i>
                <span>{{ __('Tambah Inventory Baru') }}</span>
            </a>
            <a href="{{ route('admin.inventory.summary') }}" class="btn btn-warning d-flex align-items-center shadow-sm mb-2">
                <i class="fas fa-chart-bar me-2"></i>
                <span>{{ __('Summary (Jenis+GSM) x Lebar') }}</span>
            </a>
            <a href="{{ route('inventory.import.inventory.form') }}" class="btn btn-success d-flex align-items-center shadow-sm mb-2">
                <i class="fas fa-file-upload me-2"></i>
                <span>{{ __('Import Inventory') }}</span>
            </a>
            <a href="{{ route('inventory.import.update.form') }}" class="btn btn-info d-flex align-items-center shadow-sm mb-2">
                <i class="fas fa-file-import me-2"></i>
                <span>{{ __('Import Update') }}</span>
            </a>
        </div>
        <div class="col-md-4 ms-auto">
            <form action="{{ route('inventory.index') }}" method="GET" class="d-flex align-items-center shadow-sm rounded-pill bg-white px-2 py-1 mb-2" style="max-width: 250px; margin-left: auto;">
                <input 
                    type="text" 
                    name="search" 
                    class="form-control border-0 bg-transparent me-2 rounded-pill" 
                    placeholder="Cari kode internal, kode roll, supplier..." 
                    value="{{ request('search') }}" 
                    style="width: 200px; font-size: 15px; box-shadow: none;"
                >
                <button type="submit" class="btn btn-primary rounded-pill px-3 d-flex align-items-center" style="box-shadow: none;">
                    <i class="fas fa-search me-1"></i> Cari
                </button>
            </form>
        </div>
      </div>

      <div class="table-responsive shadow rounded-3">
        <table class="table align-middle table-row-dashed table-row-bordered gy-5 gs-7 fs-6" style="background-color: #fff;">
            <thead>
                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                    <th class="min-w-125px">{{ __('Tanggal') }}</th>
                    <th class="min-w-125px">{{ __('Kode Internal') }}</th>
                    <th class="min-w-100px">{{ __('Jenis') }}</th>
                    <th class="min-w-125px">{{ __('Kode Roll') }}</th>
                    <th class="min-w-100px">{{ __('GSM') }}</th>
                    <th class="min-w-100px">{{ __('Lebar') }}</th>
                    <th class="min-w-100px">{{ __('Berat SJ') }}</th>
                    <th class="min-w-100px">{{ __('Berat Timbang') }}</th>
                    <th class="min-w-100px">{{ __('Berat') }}</th>
                    <th class="min-w-100px">{{ __('Supplier') }}</th>
                    <th class="min-w-100px">{{ __('No PO') }}</th>
                    <th class="min-w-100px">{{ __('Warna') }}</th>
                    <th class="min-w-100px">{{ __('Keterangan') }}</th>
                    <th class="min-w-100px">{{ __('Potong') }}</th>
                    <th class="min-w-100px">{{ __('Rasio') }}</th>
                    {{-- <th class="min-w-100px">{{ __('Kolom') }}</th> --}}
                    <th class="min-w-100px">{{ __('GSM Act') }}</th>
                    <th class="min-w-100px">{{ __('GSM (%)') }}</th>
                    <th class="min-w-100px">{{ __('Cobsize Top') }}</th>
                    <th class="min-w-100px">{{ __('Cobsize Back') }}</th>
                    <th class="min-w-100px">{{ __('RCT CD') }}</th>
                    <th class="min-w-100px">{{ __('RCT MD') }}</th>
                    <th class="min-w-100px">{{ __('Tanggal Dibuat') }}</th>
                    <th class="min-w-125px">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody class="text-gray-900 fw-semibold">
                @forelse ($inventories as $inventory)
                    <tr>
                        <td class="text-gray-800 bold">{{ \Carbon\Carbon::parse($inventory->tanggal_masuk)->format('d-m-Y') }}</td>
                        @if ($inventory->kw == 1)
                            <td class="text-gray-800 fw-semibold">
                                <span class="badge badge-danger">{{ $inventory->kode_internal }}</span>
                            </td>
                        @else
                            <td class="text-gray-800 fw-semibold">{{ $inventory->kode_internal }}</td>
                        @endif
                        <td class="text-gray-800 fw-semibold">{{ $inventory->jenis ?? '-' }}{{ $inventory->gsm }}</td>
                        <td class="text-gray-800 fw-semibold">{{ $inventory->kode_roll }}</td>
                        <td class="text-gray-800 fw-semibold">{{ $inventory->gsm ?? '-' }}</td>
                        <td class="text-gray-800 fw-semibold">{{ $inventory->lebar ?? '-' }}</td>
                        <td class="text-gray-800 fw-semibold">{{ $inventory->berat_sj ?? '-' }}</td>
                        <td class="text-gray-800 fw-semibold">{{ $inventory->berat_timbang }}</td>
                        <td class="text-gray-800 fw-semibold">{{ $inventory->quantity }}</td>
                        <td class="text-gray-800 fw-semibold">{{ $inventory->supplier->name ?? '-' }}</td>
                        <td class="text-gray-800 fw-semibold">{{ $inventory->purchase_order ?? '-' }}</td>
                        <td>
                            @if($inventory->warna)
                                <span class="badge" style="background-color: {{ $inventory->warna }}; color: #000; font-size: 14px;">
                                    Sama
                                </span>
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-gray-800 fw-semibold">{{ $inventory->descoription ?? '-' }}</td>
                        <td class="text-gray-800 fw-semibold">{{ $inventory->potongan_id ? $inventory->potongan->lebar_potongan : '-' }}</td>
                        <td class="text-gray-800 fw-semibold">{{ $inventory->potongan_id ? $inventory->potongan->rasio : '-' }}</td>
                        {{-- <td class="text-gray-800 fw-semibold">{{ $inventory->kolom ?? '-' }}</td> --}}
                        <td class="text-gray-800 fw-semibold">{{ $inventory->gsm_actual ? number_format($inventory->gsm_actual) : '-' }}</td>
                        <td class="text-gray-800 fw-semibold">{{ $inventory->gsm_actual ? number_format(($inventory->gsm_actual - $inventory->gsm) / $inventory->gsm * 100) . '%' : '-' }}</td>
                        <td class="text-gray-800 fw-semibold">{{ $inventory->cobsize_top ?? '-' }}</td>
                        <td class="text-gray-800 fw-semibold">{{ $inventory->cobsize_back ?? '-' }}</td>
                        <td class="text-gray-800 fw-semibold">{{ $inventory->rct_cd ?? '-' }}</td>  
                        <td class="text-gray-800 fw-semibold">{{ $inventory->rct_md ?? '-' }}</td>
                        <td class="text-gray-800 fw-semibold">{{ \Carbon\Carbon::parse($inventory->created_at)->format('d-m-Y H:i') }}</td>
                        <td>
                            <div class="d-flex flex-wrap gap-1">
                                <button type="button" class="btn btn-outline-info btn-xs" 
                                        onclick="addKeterangan({{ $inventory->id }}, '{{ $inventory->descoription ?? '' }}')" 
                                        title="Tambah/Edit Keterangan">
                                    <i class="fas fa-comment"></i>
                                </button>
                                <button type="button" class="btn btn-outline-success btn-xs" 
                                        onclick="rollPotong({{ $inventory->id }}, '{{ $inventory->kode_internal }}', {{ $inventory->lebar ?? 0 }})" 
                                        title="Roll Potong">
                                    <i class="fas fa-cut"></i>
                                </button>
                                <button type="button" class="btn btn-outline-warning btn-xs" 
                                        onclick="editInventory({{ $inventory->id }})" 
                                        title="Edit Inventory">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('inventory.destroy', $inventory->id) }}" method="POST" class="d-inline" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-xs" 
                                            title="Hapus Inventory">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="21" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <p>Tidak ada data inventory</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($inventories->hasPages())
        <div class="mt-3">
            {{ $inventories->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    @endif

      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>

<!-- Modal untuk Edit Keterangan -->
<div class="modal fade" id="keteranganModal" tabindex="-1" role="dialog" aria-labelledby="keteranganModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title" id="keteranganModalLabel">
          <i class="fas fa-comment me-2"></i>Tambah/Edit Keterangan
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="keteranganForm" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="form-group">
            <label for="description_input" class="form-label">Keterangan:</label>
            <textarea class="form-control" id="description_input" name="description" rows="4" 
                      placeholder="Masukkan keterangan untuk inventory ini..."></textarea>
          </div>
          <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            <strong>Info:</strong> Keterangan akan disimpan untuk inventory yang dipilih.
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <i class="fas fa-times me-1"></i>Batal
          </button>
          <button type="submit" class="btn btn-info">
            <i class="fas fa-save me-1"></i>Simpan Keterangan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal untuk Roll Potong -->
<div class="modal fade" id="rollPotongModal" tabindex="-1" role="dialog" aria-labelledby="rollPotongModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="rollPotongModalLabel">
          <i class="fas fa-cut me-2"></i>Roll Potong
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="rollPotongForm" method="POST">
        @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 mb-3">
              <div class="alert alert-info">
                <strong>Inventory:</strong> <span id="inventory-info"></span>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="lebar_potongan" class="form-label">Lebar Potongan (cm) <span class="text-danger">*</span></label>
                <input type="hidden" name="lebar_roll" id="lebar_roll">
                <input type="number" class="form-control lebar-potongan" id="lebar_potongan" name="lebar_potongan" 
                       min="1" step="1" required placeholder="Masukkan lebar potongan">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="rasio" class="form-label">Rasio</label>
                <input type="number" class="form-control" id="rasio" name="rasio" 
                       min="0" step="0.01" placeholder="0.00">
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="keterangan_potongan" class="form-label">Keterangan</label>
                <textarea class="form-control" id="keterangan_potongan" name="keterangan" rows="3" 
                          placeholder="Masukkan keterangan potongan..."></textarea>
              </div>
            </div>
          </div>
          
          <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Perhatian:</strong> Data potongan akan tersimpan dan terhubung dengan inventory ini.
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <i class="fas fa-times me-1"></i>Batal
          </button>
          <button type="submit" class="btn btn-success">
            <i class="fas fa-cut me-1"></i>Simpan Potongan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@section('javascripts')
<!-- Select2 JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        // Initialize Select2 for filter dropdowns
        $('#gsm_filter, #lebar_filter, #jenis_filter, #supplier_filter').select2({
            theme: 'bootstrap4',
            width: '100%',
            allowClear: false,
            placeholder: function() {
                return $(this).find('option:first-child').text();
            }
        });

        // Initialize Select2
        $('.js-example-basic-single').select2({
            theme: 'bootstrap4',
            width: '100%',
            allowClear: false,
            placeholder: 'Pilih...',
            minimumResultsForSearch: 0
        });
        
        // Reinitialize Select2 when modal is shown
        $('#addInventoryModal').on('shown.bs.modal', function () {
            $('.js-example-basic-single').select2({
                theme: 'bootstrap4',
                width: '100%',
                allowClear: false,
                placeholder: 'Pilih...',
                minimumResultsForSearch: 0,
                dropdownParent: $('#addInventoryModal')
            });
        });

        $('.supplier').on('change', function() {
            var selectedSupplier = $(this).val();
            var url = '{{ route("supplier-roll.show", ":id") }}';
            var kw = $('.kw').val();
            // console.log(kw);
            
            url = url.replace(':id', selectedSupplier);
            
            $.get(url, function(data) {
                function strpad(str, length) {
                    str = String(str);
                    while (str.length < length) {
                        str = '0' + str;
                    }
                    return str;
                }

                if(kw == 1){
                    kodeInternal = data.code + 'GA' + strpad(data.number_seq, 5);
                } else {
                    kodeInternal = data.code + 'G' + strpad(data.number_seq, 5);
                }

                $('#kode_internal').val(kodeInternal);
            });
        });

        // Validasi lebar potongan tidak boleh lebih besar dari lebar roll
        $(document).on('input', '.lebar-potongan', function() {
            var lebarRoll = parseFloat($('#lebar_roll').val());
            var lebarPotongan = parseFloat($(this).val());
            if (lebarPotongan > lebarRoll) {
                alert('Lebar potongan tidak boleh lebih besar dari lebar roll (' + lebarRoll + ' cm).');
                $(this).val('');
            } else {
                // Hitung rasio secara otomatis
                if (lebarPotongan > 0) {
                    var rasio = (((lebarRoll - lebarPotongan) / lebarRoll) * 100).toFixed(2);
                    $('#rasio').val(rasio);
                } else {
                    $('#rasio').val('');
                }
            }
        });
        
    });

    function editInventory(id) {
        // Implementasi edit inventory
        alert('Edit inventory dengan ID: ' + id);
    }

    function rollPotong(inventoryId, kodeInternal, lebarRoll) {
        // Set form action URL to create potongan
        $('#rollPotongForm').attr('action', '{{ route("potongan.store") }}');
        
        // Add hidden input for inventory_id
        $('#rollPotongForm').find('input[name="inventory_id"]').remove();
        $('#rollPotongForm').append('<input type="hidden" name="inventory_id" value="' + inventoryId + '">');
        
        // Set inventory info
        $('#inventory-info').text(kodeInternal + ' (Lebar: ' + lebarRoll + ' cm)');
        
        // Reset form
        $('#lebar_roll').val(lebarRoll);
        $('#lebar_potongan').val('');
        $('#rasio').val('');
        $('#keterangan_potongan').val('');
        
        // Show modal
        $('#rollPotongModal').modal('show');
    }

    function addKeterangan(id, currentKeterangan) {
        // Set form action URL
        $('#keteranganForm').attr('action', '{{ route("inventory.update", ":id") }}'.replace(':id', id));
        
        // Set current keterangan value
        $('#description_input').val(currentKeterangan);
        
        // Show modal
        $('#keteranganModal').modal('show');
    }

    // Handle form submission untuk keterangan
    $('#keteranganForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = $(this).serialize();
        var url = $(this).attr('action');
        
        // Show loading state
        var submitBtn = $(this).find('button[type="submit"]');
        var originalText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...');
        submitBtn.prop('disabled', true);
        
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function(response) {
                $('#keteranganModal').modal('hide');
                
                // Reload page to show updated data
                setTimeout(function() {
                    location.reload();
                }, 1000);
            },
            error: function(xhr) {
                var errorMsg = 'Terjadi kesalahan saat menyimpan keterangan.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                
                $('<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                  '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                  '<span aria-hidden="true">&times;</span></button>' +
                  '<strong>Error!</strong> ' + errorMsg +
                  '</div>').prependTo('.container-fluid').delay(5000).fadeOut();
            },
            complete: function() {
                // Restore button state
                submitBtn.html(originalText);
                submitBtn.prop('disabled', false);
            }
        });
    });

    // Handle form submission untuk roll potong
    $('#rollPotongForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = $(this).serialize();
        var url = $(this).attr('action');

        console.log(formData, url);
        
        
        // Show loading state
        var submitBtn = $(this).find('button[type="submit"]');
        var originalText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...');
        submitBtn.prop('disabled', true);
        
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function(response) {
                $('#rollPotongModal').modal('hide');
                
                // Reload page to show updated data
                setTimeout(function() {
                    location.reload();
                }, 1000);
            },
            error: function(xhr) {
                var errorMsg = 'Terjadi kesalahan saat menyimpan data potongan.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    var errors = xhr.responseJSON.errors;
                    errorMsg = 'Validasi gagal: ';
                    Object.keys(errors).forEach(function(key) {
                        errorMsg += errors[key][0] + ' ';
                    });
                }
                
                $('<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                  '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                  '<span aria-hidden="true">&times;</span></button>' +
                  '<strong>Error!</strong> ' + errorMsg +
                  '</div>').prependTo('.container-fluid').delay(5000).fadeOut();
            },
            complete: function() {
                // Restore button state
                submitBtn.html(originalText);
                submitBtn.prop('disabled', false);
            }
        });
    });
</script>
@endsection
