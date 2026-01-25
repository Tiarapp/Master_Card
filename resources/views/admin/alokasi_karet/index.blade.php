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
                          {{-- <a class="dropdown-item" href="#">
                            <i class="fas fa-edit text-warning"></i> Edit
                          </a>
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item text-danger" href="#" 
                             onclick="return confirm('Yakin hapus data ini?')">
                            <i class="fas fa-trash"></i> Hapus
                          </a> --}}
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
</div>
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
});
</script>
@endsection