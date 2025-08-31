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
            <i class="fas fa-file-invoice-dollar mr-2"></i>Vendor Tanda Terima
          </h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Accounting</a></li>
            <li class="breadcrumb-item active">Vendor TT</li>
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
        <form method="GET" action="{{ url()->current() }}">
          <div class="card-body">
            <div class="row">
              <div class="col-md-8">
                <div class="form-group">
                  <label for="search">Pencarian</label>
                  <input type="text" class="form-control" id="search" name="search" 
                         placeholder="Cari berdasarkan No TT, BBM No, Invoice, atau PO Number..." 
                         value="{{ request('search') }}">
                  <small class="text-muted">Kosongkan untuk menampilkan semua data</small>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>&nbsp;</label>
                  <div class="d-block">
                    <button type="submit" class="btn btn-primary">
                      <i class="fas fa-search mr-1"></i>Cari
                    </button>
                    <a href="{{ url()->current() }}" class="btn btn-secondary ml-2">
                      <i class="fas fa-times mr-1"></i>Reset
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>

      <!-- Data Table -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-table mr-2"></i>Data Vendor Tanda Terima
          </h3>
          <div class="card-tools">
            @if($vendortt->total() > 0)
              <span class="badge badge-success">
                Total: {{ number_format($vendortt->total()) }} record
              </span>
            @else
              <span class="badge badge-secondary">
                Tidak ada data
              </span>
            @endif
          </div>
        </div>
        <div class="card-body table-responsive">
          <table class="table table-bordered table-striped" id="vendorTTTable">
            <thead class="bg-primary text-white">
              <tr>
                <th style="width: 5%">No</th>
                <th style="width: 10%">Tanggal TT</th>
                <th style="width: 15%">No TT</th>
                <th style="width: 15%">Invoice Number</th>
                <th style="width: 15%">PO Number</th>
                <th style="width: 12%">BBM No</th>
                <th style="width: 13%">Amount</th>
                <th style="width: 13%">BBM Amount</th>
                <th style="width: 7%">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($vendortt as $index => $data)
                  <tr>
                    <td>{{ $vendortt->firstItem() + $index }}</td>
                    <td>
                      @if($data->master_vend && $data->master_vend->Tglterima)
                        {{ \Carbon\Carbon::parse($data->master_vend->Tglterima)->format('d-m-Y') }}
                      @endif
                    </td>
                    <td>{{ $data->NoTT }}</td>
                    <td>{{ $data->InvNumber }}</td>
                    <td>{{ $data->PONumber }}</td>
                    <td>{{ $data->BBMNo }}</td>
                    <td class="text-right">{{ number_format($data->Amount, 2) }}</td>
                    <td class="text-right">{{ number_format($data->BBMAmount, 2) }}</td>
                    <td class="text-center">
                      <a href="#" 
                         class="btn btn-info btn-sm" 
                         data-toggle="tooltip" title="Lihat Detail">
                        <i class="fas fa-eye"></i>
                      </a>
                    </td>
                  </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        
        @if($vendortt->hasPages())
        <div class="card-footer">
          <div class="row align-items-center">
            <div class="col-md-6">
              <p class="text-muted mb-0">
                Menampilkan {{ $vendortt->firstItem() }} - {{ $vendortt->lastItem() }} 
                dari {{ $vendortt->total() }} hasil
              </p>
            </div>
            <div class="col-md-6">
              {{ $vendortt->appends(request()->query())->links() }}
            </div>
          </div>
        </div>
        @endif
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
@endsection

@section('javascripts')
<!-- DataTables -->
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
    
    // Handle modal display properly
    $('.modal').on('show.bs.modal', function() {
        var modal = $(this);
        
        // Ensure proper z-index
        modal.css('z-index', 1055);
        
        // Adjust modal body height
        modal.find('.modal-body').css({
            'max-height': '70vh',
            'overflow-y': 'auto'
        });
        
        // Remove any existing backdrop issues
        $('.modal-backdrop').css('z-index', 1045);
    });
    
    // Handle modal hide
    $('.modal').on('hidden.bs.modal', function() {
        // Ensure no leftover backdrop
        if ($('.modal:visible').length === 0) {
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open');
        }
    });
    
    // Format currency in real-time if needed
    $('.currency-format').each(function() {
        var value = $(this).text();
        if (value && !isNaN(value)) {
            $(this).text('Rp ' + Number(value).toLocaleString('id-ID'));
        }
    });
    
    // Fix any modal backdrop issues on page load
    if ($('.modal-backdrop').length > 0 && $('.modal:visible').length === 0) {
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');
    }
});
</script>

<style>
/* Custom styles for better appearance */
.table tbody tr:hover {
    background-color: rgba(0,123,255,.075) !important;
    cursor: pointer;
}

.badge {
    font-size: 0.85em;
    padding: 0.375rem 0.75rem;
}

.modal-body h6 {
    border-bottom: 2px solid #dee2e6;
    padding-bottom: 0.5rem;
    margin-bottom: 1rem;
}

.table-sm th {
    font-weight: 600;
    color: #495057;
}

.text-success {
    font-weight: 600;
}

.text-info {
    font-weight: 600;
}

/* Modal z-index fixes */
.modal {
    z-index: 1050 !important;
}

.modal-backdrop {
    z-index: 1040 !important;
}

.modal-dialog {
    z-index: 1060 !important;
}

/* Ensure modal appears correctly */
.modal.fade .modal-dialog {
    transform: translate(0, -50px);
    transition: transform 0.3s ease-out;
}

.modal.show .modal-dialog {
    transform: none;
}

/* Responsive improvements */
@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.85rem;
    }
    
    .badge {
        font-size: 0.75em;
        padding: 0.25rem 0.5rem;
    }
    
    .modal-dialog {
        margin: 0.5rem;
        max-width: calc(100% - 1rem);
    }
    
    .modal-body {
        padding: 1rem 0.75rem;
    }
}

/* Loading state */
.loading {
    opacity: 0.6;
    pointer-events: none;
}

/* Empty state styling */
.text-muted i.fa-inbox {
    color: #6c757d;
    opacity: 0.5;
}

/* Fix for AdminLTE sidebar overlap */
.content-wrapper .modal {
    z-index: 1055 !important;
}

.content-wrapper .modal-backdrop {
    z-index: 1045 !important;
}

/* Ensure modal is positioned correctly */
.modal.show {
    display: block !important;
    padding-right: 0 !important;
}

.modal-open {
    overflow: hidden;
}

/* Fix body scroll when modal is open */
body.modal-open {
    padding-right: 0 !important;
    overflow: hidden;
}

/* AdminLTE specific fixes */
.wrapper .modal {
    z-index: 1055 !important;
}

.main-sidebar {
    z-index: 1010 !important;
}

.navbar {
    z-index: 1020 !important;
}
</style>
@endsection