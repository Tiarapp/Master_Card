@extends('admin.templates.partials.default')

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    @if ($message = Session::get('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        <strong>{{ $message }}</strong>
      </div>
    @endif
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">
            <i class="fas fa-undo mr-2"></i>Retur Penjualan
          </h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Barang</a></li>
            <li class="breadcrumb-item active">Retur Penjualan</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      
      <!-- Search Form -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-search mr-2"></i>Filter Data
          </h3>
        </div>
        <form method="GET" action="{{ route('barang.retur') }}">
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="search">Pencarian</label>
                  <input type="text" class="form-control" id="search" name="search" 
                         placeholder="Cari berdasarkan No Bukti, Customer..." 
                         value="{{ request('search') }}">
                  <small class="text-muted">Pencarian berdasarkan No Bukti, Kode/Nama Customer</small>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="date_start">Tanggal Mulai</label>
                  <input type="date" class="form-control" id="date_start" name="date_start" 
                         value="{{ request('date_start') }}">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="date_end">Tanggal Akhir</label>
                  <input type="date" class="form-control" id="date_end" name="date_end" 
                         value="{{ request('date_end') }}">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>&nbsp;</label>
                  <div class="d-flex flex-column">
                    <button type="submit" class="btn btn-primary mb-2">
                      <i class="fas fa-search mr-1"></i>Cari
                    </button>
                    @if(request()->hasAny(['search', 'date_start', 'date_end']))
                      <a href="{{ route('barang.retur') }}" class="btn btn-secondary">
                        <i class="fas fa-times mr-1"></i>Reset
                      </a>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>

      <!-- Data Table -->
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-table mr-2"></i>Data Retur Penjualan
          </h3>
          <div class="card-tools">
            <a href="{{ route('barang.retur.create') }}" class="btn btn-success btn-sm">
              <i class="fas fa-plus mr-1"></i>Tambah Retur
            </a>
            @if($retur->total() > 0)
              <span class="badge badge-success">
                Total: {{ number_format($retur->total()) }} record
              </span>
            @else
              <span class="badge badge-secondary">
                Tidak ada data
              </span>
            @endif
          </div>
        </div>

        @if(request()->hasAny(['search', 'date_start', 'date_end']))
        <div class="card-body border-bottom bg-light">
          <div class="alert alert-info mb-0">
            <h6><i class="fas fa-info-circle mr-1"></i>Filter Aktif:</h6>
            <div class="row">
              @if(request('search'))
                <div class="col-md-4">
                  <small><strong>Pencarian:</strong> {{ request('search') }}</small>
                </div>
              @endif
              @if(request('date_start') && request('date_end'))
                <div class="col-md-4">
                  <small><strong>Tanggal:</strong> {{ request('date_start') }} s/d {{ request('date_end') }}</small>
                </div>
              @endif
            </div>
          </div>
        </div>
        @endif

        <div class="card-body table-responsive">
          <table class="table table-bordered table-striped">
            <thead class="bg-info text-white">
              <tr>
                <th style="width: 5%">No</th>
                <th style="width: 12%">Tanggal Retur</th>
                <th style="width: 18%">No Bukti</th>
                <th style="width: 12%">Kode Customer</th>
                <th style="width: 20%">Nama Customer</th>
                <th style="width: 8%">Total Crt</th>
                <th style="width: 8%">Total Ecr</th>
                <th style="width: 7%">Status</th>
                <th style="width: 10%">Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($retur as $index => $data)
                <tr>
                  <td>{{ $retur->firstItem() + $index }}</td>
                  <td>
                    @if($data->TglRetur)
                      {{ \Carbon\Carbon::parse($data->TglRetur)->format('d-m-Y') }}
                    @else
                      -
                    @endif
                  </td>
                  <td>{{ $data->NoBukti ?? '-' }}</td>
                  <td>{{ $data->KodeCust ?? '-' }}</td>
                  <td>{{ $data->NamaCust ?? '-' }}</td>
                  <td class="text-right">{{ number_format($data->TotReturCrt ?? 0, 0) }}</td>
                  <td class="text-right">{{ number_format($data->TotReturEcr ?? 0, 0) }}</td>
                  <td class="text-center">
                    @if(str_contains($data->Blocked, 'Y'))
                      <span class="badge badge-success">Blocked</span>
                    @else
                      <span class="badge badge-secondary">Open</span>
                    @endif
                    <small class="d-block text-muted">{{ $data->Aktif }}</small>
                  </td>
                  <td class="text-center">
                    <div class="btn-group" role="group">
                      <a href="{{ route('barang.retur.show', $data->NoBukti) }}" 
                         class="btn btn-info btn-sm" 
                         data-toggle="tooltip" title="Lihat Detail">
                        <i class="fas fa-eye"></i>
                      </a>
                      @if(str_contains($data->Blocked, 'Y'))
                      
                        <button type="button" 
                                class="btn btn-secondary btn-sm disabled" 
                                data-toggle="tooltip" title="Tidak dapat diedit (Blocked ≠ Y)">
                          <i class="fas fa-lock"></i>
                        </button>
                      @else
                      
                        <a href="{{ route('barang.retur.edit', $data->NoBukti) }}" 
                           class="btn btn-warning btn-sm" 
                           data-toggle="tooltip" title="Edit (Blocked = N)">
                          <i class="fas fa-edit"></i>
                        </a>
                      @endif
                    </div>
                    @if(str_contains($data->Blocked, 'Y'))
                      <small class="text-muted d-block mt-1">
                        <i class="fas fa-lock"></i> Locked
                      </small>
                    @else
                      <small class="text-success d-block mt-1">
                        <i class="fas fa-check-circle"></i> Editable
                      </small>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="9" class="text-center text-muted">
                    <i class="fas fa-inbox fa-3x mb-3"></i><br>
                    Tidak ada data retur penjualan
                    @if(request()->hasAny(['search', 'date_start', 'date_end']))
                      dengan filter yang diterapkan
                    @endif
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        
        @if($retur->hasPages())
        <div class="card-footer">
          <div class="row align-items-center">
            <div class="col-md-6">
              <p class="text-muted mb-0">
                Menampilkan {{ $retur->firstItem() }} - {{ $retur->lastItem() }} 
                dari {{ $retur->total() }} hasil
              </p>
            </div>
            <div class="col-md-6">
              {{ $retur->appends(request()->query())->links() }}
            </div>
          </div>
        </div>
        @endif
      </div>
      
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
@endsection

@section('javascripts')
<script>
$(document).ready(function() {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // Auto-focus search input if there's a search term
    @if(request('search'))
        $('#search').focus();
    @endif
    
    // Add hover effects to table rows
    $('.table tbody tr').hover(
        function() {
            $(this).addClass('table-active');
        },
        function() {
            $(this).removeClass('table-active');
        }
    );
});
</script>
@endsection