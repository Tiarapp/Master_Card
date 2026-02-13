<!-- jQuery -->
<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>

@extends('admin.templates.partials.default')

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

.table td, .table th {
    vertical-align: middle;
    padding: 8px;
}

.badge-sisa {
    font-size: 0.9em;
    padding: 0.5em 0.8em;
}

.hidden-row {
    display: none;
}
</style>

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Alokasi Karet</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Alokasi Karet</li>
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

      @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
          <strong>{{ $message }}</strong>
        </div>
      @endif

      <!-- Control Panel -->
      <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
          <!-- Header Actions Row -->
          <div class="row mb-3">
            <div class="col-12">
              <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <!-- Action Buttons -->
                <div class="d-flex flex-wrap gap-2">
                  <a href="{{ route('karet.create') }}" class="btn btn-success d-flex align-items-center shadow-sm">
                    <i class="fas fa-plus-circle me-2"></i>
                    <span>Tambah Alokasi Karet</span>
                  </a>
                  <a href="{{ route('karet.export', request()->query()) }}" class="btn btn-primary d-flex align-items-center shadow-sm">
                    <i class="fas fa-file-excel me-2"></i>
                    <span>Export Excel</span>
                  </a>
                </div>
                
                <!-- Status Indicators -->
                <div class="d-flex align-items-center gap-2">
                  @if(request('search') || request('sales_name'))
                    <span class="badge bg-primary">
                      <i class="fas fa-filter me-1"></i>
                      Filter Aktif
                    </span>
                  @endif
                </div>
              </div>
            </div>
          </div>

          <!-- Search Controls Row -->
          <div class="row g-3">
            <!-- Search Section -->
            <div class="col-lg-8">
              <form method="GET" class="d-flex gap-3">
                <div class="flex-fill">
                  <div class="input-group">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Cari berdasarkan customer atau nama karet..."
                           value="{{ request('search') }}">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
                
                <div class="flex-shrink-0">
                  <select name="sales_name" class="form-control">
                    <option value="">Semua Sales</option>
                    @foreach($alokasi->pluck('sales_name')->unique() as $sales)
                      <option value="{{ $sales }}" {{ request('sales_name') == $sales ? 'selected' : '' }}>
                        {{ $sales }}
                      </option>
                    @endforeach
                  </select>
                </div>

                @if(request('search') || request('sales_name'))
                  <div class="flex-shrink-0">
                    <a href="{{ route('karet.index') }}" class="btn btn-outline-secondary">
                      <i class="fas fa-times"></i> Reset
                    </a>
                  </div>
                @endif
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Data Table -->
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-dark">
              <i class="fas fa-table text-primary me-2"></i>
              Data Alokasi Karet per Bulan
            </h5>
            <div class="d-flex align-items-center gap-2">
              <span class="text-muted small">Total: {{ $alokasi->total() }} data</span>
            </div>
          </div>
        </div>

        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
              <thead class="table-light">
                <tr>
                  <th class="text-center" width="50">#</th>
                  <th>Customer</th>
                  <th>Sales</th>
                  <th>Nama Karet</th>
                  <th>Kode Barang</th>
                  <th>No. PO</th>
                  <th>GSM</th>
                  <th>Harga/KG</th>
                  <th>Lokasi Kirim</th>
                  <th>Tanggal Masuk</th>
                  <th>Alokasi</th>
                  <th>Total Harga</th>
                  <th>Sisa Karet</th>
                  <th class="text-center" width="150">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($alokasi as $index => $item)
                  {{-- Hide row if sisa karet < 0 --}}
                  @if($item->sisa < 0)
                    @continue
                  @endif
                  
                  <tr>
                    <td class="text-center">{{ $alokasi->firstItem() + $index }}</td>
                    <td>
                      <div class="fw-bold">{{ $item->customer }}</div>
                      @if($item->mastercard)
                        <small class="text-muted">MC: {{ $item->mastercard->kode }}</small>
                      @endif
                    </td>
                    <td>
                      <span class="badge bg-primary" style="font-size: 12px">{{ $item->sales_name }}</span>
                    </td>
                    <td>
                      <div class="fw-bold">{{ $item->nama_karet }}</div>
                      @if($item->type)
                        <small class="text-muted">{{ $item->type }}</small>
                      @endif
                    </td>
                    <td>{{ $item->kode_barang ?? '-' }}</td>
                    <td>{{ $item->no_po ?? '-' }}</td>
                    <td>{{ number_format($item->gsm, 3) }}</td>
                    <td>Rp {{ number_format($item->harga_per_kg, 0, ',', '.') }}</td>
                    <td>{{ $item->lokasi_kirim }}</td>
                    <td>
                      {{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d/m/Y') }}
                      <br>
                      <small class="text-muted">
                        {{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('F Y') }}
                      </small>
                    </td>
                    <td>
                      <span class="badge bg-info badge-sisa" style="font-size: 12px">
                        {{ number_format($item->alokasi, 0) }}
                      </span>
                    </td>
                    <td>
                      <strong>Rp {{ number_format($item->harga, 0, ',', '.') }}</strong>
                    </td>
                    <td>
                      @if($item->sisa > 0)
                        <span class="badge bg-success badge-sisa" style="font-size: 12px">
                          {{ number_format($item->sisa, 0) }}
                        </span>
                      @elseif($item->sisa == 0)
                        <span class="badge bg-warning badge-sisa" style="font-size: 12px">
                          Habis
                        </span>
                      @else
                        <span class="badge bg-danger badge-sisa" style="font-size: 12px">
                          -{{ number_format(abs($item->sisa), 0) }}
                        </span>
                      @endif
                    </td>
                    <td class="text-center">
                      <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle" 
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fas fa-cog"></i>
                        </button>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" href="{{ route('karet.show', $item->id) }}">
                            <i class="fas fa-eye text-info"></i> Detail
                          </a>
                          
                          <a class="dropdown-item" href="#" 
                             onclick="openEditModal({{ $item->id }}, '{{ $item->customer }}', '{{ $item->nama_karet }}', {{ $item->alokasi }})">
                            <i class="fas fa-edit text-warning"></i> Edit Alokasi
                          </a>
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item text-danger" href="#" 
                             onclick="return confirm('Yakin hapus data ini?')">
                            <i class="fas fa-trash"></i> Hapus
                          </a>
                        </div>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="14" class="text-center py-5">
                      <div class="d-flex flex-column align-items-center">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h6 class="text-muted">Tidak ada data alokasi karet</h6>
                        <p class="text-muted mb-3">
                          @if(request('search') || request('sales_name'))
                            Tidak ditemukan data yang sesuai dengan pencarian.
                          @else
                            Belum ada data alokasi karet yang tersedia.
                          @endif
                        </p>
                        @if(!request('search') && !request('sales_name'))
                          <a href="{{ route('karet.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Alokasi Pertama
                          </a>
                        @endif
                      </div>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          @if($alokasi->hasPages())
          <div class="card-footer bg-white border-0">
            <div class="d-flex justify-content-between align-items-center">
              <div class="text-muted small">
                Menampilkan {{ $alokasi->firstItem() }} sampai {{ $alokasi->lastItem() }} 
                dari {{ $alokasi->total() }} data
              </div>
              {{ $alokasi->appends(request()->query())->links() }}
            </div>
          </div>
          @endif
        </div>
      </div>

      <!-- Summary Cards -->
      <div class="row mt-4">
        <div class="col-lg-3 col-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{ $alokasi->where('sisa', '>', 0)->count() }}</h3>
              <p>Karet Tersedia</p>
            </div>
            <div class="icon">
              <i class="fas fa-box"></i>
            </div>
          </div>
        </div>
        
        <div class="col-lg-3 col-6">
          <div class="small-box bg-success">
            <div class="inner">
              <h3>{{ number_format($alokasi->where('sisa', '>', 0)->sum('sisa'), 0) }}</h3>
              <p>Total Sisa (KG)</p>
            </div>
            <div class="icon">
              <i class="fas fa-weight"></i>
            </div>
          </div>
        </div>
        
        <div class="col-lg-3 col-6">
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{ $alokasi->where('sisa', '=', 0)->count() }}</h3>
              <p>Karet Habis</p>
            </div>
            <div class="icon">
              <i class="fas fa-exclamation-triangle"></i>
            </div>
          </div>
        </div>
        
        <div class="col-lg-3 col-6">
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>Rp {{ number_format($alokasi->where('sisa', '>', 0)->sum('harga'), 0, ',', '.') }}</h3>
              <p>Total Nilai Tersedia</p>
            </div>
            <div class="icon">
              <i class="fas fa-dollar-sign"></i>
            </div>
          </div>
        </div>
      </div>

    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->

  <!-- Modal Edit Alokasi -->
  <div class="modal fade" id="editAlokasiModal" tabindex="-1" role="dialog" aria-labelledby="editAlokasiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="editAlokasiModalLabel">
            <i class="fas fa-edit"></i> Edit Alokasi Karet
          </h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
        <form id="editAlokasiForm" method="POST">
          @csrf
          @method('PUT')
          
          <div class="modal-body">
            <!-- Info Karet -->
            <div class="card bg-light mb-4">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <h6 class="text-primary mb-2">
                      <i class="fas fa-info-circle"></i> Informasi Karet
                    </h6>
                    <div class="mb-2">
                      <strong>Customer:</strong>
                      <span id="modal-customer"></span>
                    </div>
                    <div>
                      <strong>Nama Karet:</strong>
                      <span id="modal-nama-karet"></span>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <h6 class="text-success mb-2">
                      <i class="fas fa-weight"></i> Alokasi Saat Ini
                    </h6>
                    <div class="display-4 text-success font-weight-bold" id="modal-alokasi-awal">0</div>
                    <small class="text-muted">Kilogram</small>
                  </div>
                </div>
              </div>
            </div>

            <!-- Input Alokasi Baru -->
            <div class="card border-warning">
              <div class="card-header bg-warning text-dark">
                <h6 class="mb-0">
                  <i class="fas fa-edit"></i> Alokasi Baru
                </h6>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label for="new-alokasi" class="font-weight-bold">
                    Masukkan Alokasi Baru (KG) <span class="text-danger">*</span>
                  </label>
                  <div class="input-group input-group-lg">
                    <div class="input-group-prepend">
                      <span class="input-group-text bg-warning">
                        <i class="fas fa-weight"></i>
                      </span>
                    </div>
                    <input type="number" 
                           class="form-control form-control-lg" 
                           id="new-alokasi" 
                           name="alokasi" 
                           step="0.01" 
                           min="0" 
                           placeholder="Contoh: 1000.50" 
                           required>
                    <div class="input-group-append">
                      <span class="input-group-text">KG</span>
                    </div>
                  </div>
                  <small class="text-muted">
                    <i class="fas fa-info-circle"></i> 
                    Gunakan titik (.) untuk desimal. Contoh: 1000.50
                  </small>
                </div>

                <!-- Perbandingan -->
                <div class="mt-4 p-3 bg-light rounded">
                  <h6 class="text-primary mb-3">
                    <i class="fas fa-chart-line"></i> Perbandingan
                  </h6>
                  <div class="row text-center">
                    <div class="col-md-4">
                      <div class="text-success">
                        <strong>Alokasi Awal</strong><br>
                        <span class="h4" id="comparison-awal">0</span> KG
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="text-primary">
                        <i class="fas fa-arrow-right fa-2x"></i>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="text-warning">
                        <strong>Alokasi Baru</strong><br>
                        <span class="h4" id="comparison-baru">0</span> KG
                      </div>
                    </div>
                  </div>
                  <div class="mt-3 text-center">
                    <div id="selisih-container" style="display: none;">
                      <strong>Selisih: </strong>
                      <span id="selisih" class="badge badge-lg"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Keterangan Tambahan -->
            <div class="form-group mt-3">
              <label for="keterangan" class="font-weight-bold">
                <i class="fas fa-comment"></i> Keterangan Perubahan
              </label>
              <textarea class="form-control" 
                        id="keterangan" 
                        name="keterangan" 
                        rows="3" 
                        placeholder="Masukkan alasan atau keterangan perubahan alokasi..."></textarea>
            </div>
          </div>
          
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">
              <i class="fas fa-times"></i> Batal
            </button>
            <button type="submit" class="btn btn-primary" id="save-button">
              <i class="fas fa-save"></i> Simpan Perubahan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

</div>

<script>
// Global functions that need to be accessible from onclick attributes
function openEditModal(id, customer, namaKaret, alokasiAwal) {
    // Set form action URL
    $('#editAlokasiForm').attr('action', `/admin/marketing/karet_report/${id}`);
    
    // Fill modal data
    $('#modal-customer').text(customer);
    $('#modal-nama-karet').text(namaKaret);
    $('#modal-alokasi-awal').text(numberFormat(alokasiAwal));
    $('#comparison-awal').text(numberFormat(alokasiAwal));
    
    // Store original allocation for comparison
    $('#editAlokasiForm').data('alokasi-awal', alokasiAwal);
    
    // Reset form
    $('#new-alokasi').val('');
    $('#keterangan').val('');
    $('#comparison-baru').text('0');
    $('#selisih-container').hide();
    
    // Reset button state
    $('#save-button').html('<i class="fas fa-save"></i> Simpan Perubahan').prop('disabled', false);
    
    // Show modal
    $('#editAlokasiModal').modal('show');
    
    // Focus on input after modal is shown
    $('#editAlokasiModal').on('shown.bs.modal', function() {
        $('#new-alokasi').focus();
    });
}

function updateComparison() {
    const alokasiAwal = parseFloat($('#editAlokasiForm').data('alokasi-awal')) || 0;
    const alokasiBaru = parseFloat($('#new-alokasi').val()) || 0;
    
    // Update display
    $('#comparison-baru').text(numberFormat(alokasiBaru));
    
    if (alokasiBaru > 0) {
        const selisih = alokasiBaru - alokasiAwal;
        const selisihAbs = Math.abs(selisih);
        
        $('#selisih-container').show();
        
        if (selisih > 0) {
            $('#selisih').removeClass('badge-danger badge-secondary')
                       .addClass('badge-success')
                       .html(`<i class="fas fa-arrow-up"></i> +${numberFormat(selisihAbs)} KG`);
        } else if (selisih < 0) {
            $('#selisih').removeClass('badge-success badge-secondary')
                       .addClass('badge-danger')
                       .html(`<i class="fas fa-arrow-down"></i> -${numberFormat(selisihAbs)} KG`);
        } else {
            $('#selisih').removeClass('badge-success badge-danger')
                       .addClass('badge-secondary')
                       .html('<i class="fas fa-equals"></i> Tidak Berubah');
        }
    } else {
        $('#selisih-container').hide();
    }
}

function numberFormat(number) {
    return new Intl.NumberFormat('id-ID', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 2
    }).format(number);
}
</script>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Auto submit form when sales filter changes
    $('select[name="sales_name"]').change(function() {
        $(this).closest('form').submit();
    });

    // Add confirmation for delete actions
    $('.delete-confirm').click(function(e) {
        e.preventDefault();
        
        if (confirm('Apakah Anda yakin ingin menghapus data alokasi ini?')) {
            // Add actual delete functionality here
            console.log('Delete confirmed');
        }
    });

    // Real-time calculation for comparison
    $('#new-alokasi').on('input', function() {
        updateComparison();
    });

    // Form validation
    $('#editAlokasiForm').on('submit', function(e) {
        const newAlokasi = parseFloat($('#new-alokasi').val());
        
        if (!newAlokasi || newAlokasi < 0) {
            e.preventDefault();
            alert('Mohon masukkan nilai alokasi yang valid (minimal 0)');
            $('#new-alokasi').focus();
            return false;
        }

        // Add loading state
        $('#save-button').html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...').prop('disabled', true);
        
        return true;
    });
});
</script>
@endsection