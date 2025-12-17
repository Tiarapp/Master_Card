<!-- jQuery -->
<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>

@extends('admin.templates.partials.default')


{{-- <style>
  td, tr {
    border:1px solid black !important;
  }
</style> --}}

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Plan Corrugating</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Plan Corrugating</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->

      <!-- Filter Section -->
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="card-title mb-0">Filter & Search</h5>
        </div>
        <div class="card-body">
          <form method="GET" action="{{ route('indexcorr') }}">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="search">Cari Kode/Notes:</label>
                  <input type="text" name="search" id="search" class="form-control" 
                         placeholder="Masukkan kode atau notes" 
                         value="{{ $request->search ?? '' }}">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="tanggal">Tanggal Produksi:</label>
                  <input type="date" name="tanggal" id="tanggal" class="form-control" 
                         value="{{ $request->tanggal ?? '' }}">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="shift">Shift:</label>
                  <select name="shift" id="shift" class="form-control">
                    <option value="">Semua Shift</option>
                    <option value="1" {{ ($request->shift ?? '') == '1' ? 'selected' : '' }}>Shift 1</option>
                    <option value="2" {{ ($request->shift ?? '') == '2' ? 'selected' : '' }}>Shift 2</option>
                    <option value="3" {{ ($request->shift ?? '') == '3' ? 'selected' : '' }}>Shift 3</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>&nbsp;</label><br>
                  <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Cari
                  </button>
                  <a href="{{ route('indexcorr') }}" class="btn btn-secondary">
                    <i class="fas fa-refresh"></i> Reset
                  </a>
                  <a href="{{ route('createcorr') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Tambah Baru
                  </a>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Data Table -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Daftar Plan Corrugating</h3>
          <div class="card-tools">
            <span class="badge badge-info">Total: {{ $plans->total() }} data</span>
          </div>
        </div>
        <div class="card-body p-0">
          @if($plans->count() > 0)
            <div class="table-responsive">
              <table class="table table-striped table-hover mb-0">
                <thead class="thead-light">
                  <tr>
                    <th width="5%">#</th>
                    <th width="15%">Kode Corr</th>
                    <th width="12%">Tanggal Produksi</th>
                    <th width="8%">Shift</th>
                    <th width="10%">Revisi</th>
                    <th width="12%">Total RM (Kg)</th>
                    <th width="12%">Total Kg</th>
                    <th width="15%">Created By</th>
                    <th width="11%">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($plans as $index => $plan)
                  <tr>
                    <td>{{ ($plans->currentPage() - 1) * $plans->perPage() + $index + 1 }}</td>
                    <td>
                      <strong>{{ $plan->kode_corr }}</strong>
                      @if($plan->notes)
                        <br><small class="text-muted">{{ Str::limit($plan->notes, 30) }}</small>
                      @endif
                    </td>
                    <td>
                      <span class="badge badge-info">
                        {{ \Carbon\Carbon::parse($plan->tanggal_produksi)->format('d/m/Y') }}
                      </span>
                    </td>
                    <td>
                      <span class="badge badge-{{ $plan->shift == '1' ? 'primary' : ($plan->shift == '2' ? 'warning' : 'success') }}">
                        Shift {{ $plan->shift }}
                      </span>
                    </td>
                    <td>{{ $plan->revisi ?? '-' }}</td>
                    <td class="text-right">{{ number_format($plan->total_rm) }}</td>
                    <td class="text-right">{{ number_format($plan->total_kg) }}</td>
                    <td>
                      @if($plan->user_create)
                        {{ $plan->user_create->name }}
                        <br><small class="text-muted">{{ $plan->created_at->format('d/m/Y H:i') }}</small>
                      @else
                        -
                      @endif
                    </td>
                    <td>
                      <div class="btn-group" role="group">
                        <a href="#" class="btn btn-sm btn-info" title="View">
                          <i class="fas fa-eye"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-primary" title="Edit">
                          <i class="fas fa-edit"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-success" title="Print">
                          <i class="fas fa-print"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-danger" title="Delete"
                           onclick="return confirm('Yakin ingin menghapus data ini?')">
                          <i class="fas fa-trash"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <div class="text-center py-5">
              <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
              <h5 class="text-muted">Tidak ada data</h5>
              <p class="text-muted">Belum ada plan corrugating yang dibuat.</p>
            </div>
          @endif
        </div>
        @if($plans->hasPages())
        <div class="card-footer">
          <div class="row">
            <div class="col-md-6">
              <p class="text-sm text-muted mb-0">
                Menampilkan {{ $plans->firstItem() }} sampai {{ $plans->lastItem() }} 
                dari {{ $plans->total() }} data
              </p>
            </div>
            <div class="col-md-6">
              {{ $plans->links() }}
            </div>
          </div>
        </div>
        @endif
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
  @endsection

  @section('javascripts')
  <script>
    $(document).ready(function() {
      // Auto-submit form when date or shift changes
      $('#tanggal, #shift').change(function() {
        $(this).closest('form').submit();
      });
      
      // Enable tooltips
      $('[data-toggle="tooltip"]').tooltip();
      
      // Confirm delete actions
      $('.btn-danger').click(function(e) {
        e.preventDefault();
        if (confirm('Yakin ingin menghapus data ini?')) {
          window.location.href = $(this).attr('href');
        }
      });
      
      // Highlight search results
      var searchTerm = '{{ $request->search ?? '' }}';
      if (searchTerm) {
        $('td').each(function() {
          var text = $(this).text();
          if (text.toLowerCase().includes(searchTerm.toLowerCase())) {
            $(this).css('background-color', '#fff3cd');
          }
        });
      }
    });
  </script>
  @endsection