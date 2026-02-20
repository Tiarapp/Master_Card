@extends('admin.templates.partials.default')

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Data BBM (Bahan Baku Masuk)</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Stellar BP</a></li>
            <li class="breadcrumb-item active">BBM</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      
      <!-- Search Section -->
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Filter Data</h3>
            </div>
            <div class="card-body">
              <form method="GET" action="{{ request()->url() }}">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="period">Periode (MM/YYYY)</label>
                      <input type="month" class="form-control" id="period" name="period" 
                             value="{{ request('period') }}">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="search">Cari (No BBM / Nama Barang)</label>
                      <input type="text" class="form-control" id="search" name="search" 
                             value="{{ request('search') }}" placeholder="Masukkan No BBM atau Nama Barang">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>&nbsp;</label><br>
                      <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Filter
                      </button>
                      <a href="{{ request()->url() }}" class="btn btn-secondary">
                        <i class="fas fa-refresh"></i> Reset
                      </a>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Data Table -->
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                Data BBM
                @if(request('period'))
                  - Periode: {{ date('m/Y', strtotime(request('period') . '-01')) }}
                @endif
              </h3>
              <div class="card-tools">
                @if($bbm->count() > 0)
                  <a href="{{ route('stellar.bp.export', request()->query()) }}" 
                     class="btn btn-success btn-sm mr-2" 
                     title="Export ke Excel">
                    <i class="fas fa-file-excel"></i> Export Excel
                  </a>
                @endif
                <span class="badge badge-info">Total: {{ $bbm->total() }} record</span>
              </div>
            </div>
            <div class="card-body table-responsive">
              @if($bbm->count() > 0)
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th style="width: 5%">No</th>
                      <th>Tanggal BBM</th>
                      <th>No BBM</th>
                      <th>Kode Barang</th>
                      <th>Nama Barang</th>
                      <th style="width: 10%">No PO</th>
                      <th style="width: 10%">Qty P</th>
                      <th style="width: 10%">Qty S</th>
                      <th style="width: 12%">Harga</th>
                      <th style="width: 15%">Subtotal</th>
                      <th>Keterangan</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                      $no = ($bbm->currentPage() - 1) * $bbm->perPage() + 1;
                    @endphp
                    @foreach($bbm as $item)
                      <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item->master_bbm->TglMasuk ?? '-' }}</td>
                        <td>{{ $item->master_bbm->NoBukti ?? '-' }}</td>
                        <td>{{ $item->barang->KodeBrg ?? '-' }}</td>
                        <td>{{ $item->barang->NamaBrg ?? '-' }}</td>
                        <td>{{ $item->NoOP ?? '-' }}</td>
                        <td class="text-right">{{ number_format($item->QtyP ?? 0, 2) }}</td>
                        <td class="text-right">{{ number_format($item->QtyS ?? 0, 2) }}</td>
                        <td class="text-right">Rp {{ number_format($item->Harga ?? 0, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format(($item->QtyP ?? 0) * ($item->Harga ?? 0), 0, ',', '.') }}</td>
                        <td>{{ $item->Keterangan ?? '-' }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="6">Total</th>
                      <th class="text-right">{{ number_format($bbm->sum('QtyP'), 2) }}</th>
                      <th class="text-right">{{ number_format($bbm->sum('QtyS'), 2) }}</th>
                      <th></th>
                      <th class="text-right">Rp {{ number_format($bbm->sum(function($item) { 
                        return ($item->QtyP ?? 0) * ($item->Harga ?? 0); 
                      }), 0, ',', '.') }}</th>
                      <th></th>
                    </tr>
                  </tfoot>
                </table>
              @else
                <div class="alert alert-info">
                  <i class="fas fa-info-circle"></i> Tidak ada data BBM yang ditemukan.
                  @if(request('period'))
                    <br>Periode: <strong>{{ date('m/Y', strtotime(request('period') . '-01')) }}</strong>
                  @endif
                  @if(request('search'))
                    <br>Kata kunci pencarian: <strong>{{ request('search') }}</strong>
                  @endif
                  @if(!request('period') && !request('search'))
                    <br>Silakan pilih periode atau gunakan pencarian untuk menampilkan data.
                  @endif
                </div>
              @endif
            </div>
            <!-- /.card-body -->
            
            <!-- Pagination -->
            @if($bbm->hasPages())
              <div class="card-footer">
                <div class="row">
                  <div class="col-md-6">
                    <span class="text-muted">
                      Menampilkan {{ $bbm->firstItem() }} - {{ $bbm->lastItem() }} dari {{ $bbm->total() }} data
                    </span>
                  </div>
                  <div class="col-md-6">
                    <div class="float-right">
                      {{ $bbm->appends(request()->query())->links() }}
                    </div>
                  </div>
                </div>
              </div>
            @endif
          </div>
          <!-- /.card -->
        </div>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
@endsection

@section('scripts')
<script>
  $(document).ready(function() {
    // Set default period to current month if not already set
    if (!$('#period').val()) {
      const currentDate = new Date();
      const currentMonth = currentDate.toISOString().slice(0, 7); // YYYY-MM format
      $('#period').attr('placeholder', 'Bulan ini: ' + currentMonth);
    }
    
    // Auto focus on search input if period is already set
    if ($('#period').val()) {
      $('#search').focus();
    }
    
    // Enable tooltip
    $('[data-toggle="tooltip"]').tooltip();
    
    // Auto submit when period changes
    $('#period').on('change', function() {
      $(this).closest('form').submit();
    });
  });
</script>
@endsection