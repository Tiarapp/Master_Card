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
    @if ($message = Session::get('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
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
            <i class="fas fa-check-circle text-primary mr-2"></i>
            Approve OPI
          </h1>
          <p class="text-muted mb-0">Approval Order Production Instruction (OPI)</p>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <a href="#" class="text-decoration-none">
                <i class="fas fa-home mr-1"></i>Home
              </a>
            </li>
            <li class="breadcrumb-item">
              <a href="#" class="text-decoration-none">Accounting</a>
            </li>
            <li class="breadcrumb-item active">Approve OPI</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      
      <!-- Search and Filter Card -->
      <div class="card card-primary card-outline mb-4">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-search mr-2"></i>
            Pencarian OPI
          </h3>
        </div>
        <div class="card-body">
          <form method="GET" action="{{ route('acc.opi') }}">
            <div class="row">
              <div class="col-md-8">
                <div class="form-group">
                  <label for="search">Cari No OPI:</label>
                  <input type="text" 
                         class="form-control" 
                         id="search" 
                         name="search" 
                         value="{{ $search }}" 
                         placeholder="Masukkan No OPI...">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>&nbsp;</label>
                  <div class="d-block">
                    <button type="submit" class="btn btn-primary">
                      <i class="fas fa-search mr-1"></i> Cari
                    </button>
                    <a href="{{ route('acc.opi') }}" class="btn btn-secondary ml-2">
                      <i class="fas fa-refresh mr-1"></i> Reset
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Data Table Card -->
      <div class="card card-success card-outline">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-list mr-2"></i>
            Data OPI Pending Approval
          </h3>
          <div class="card-tools">
            <span class="badge badge-warning badge-lg">
              <i class="fas fa-clock mr-1"></i>
              {{ $opi->total() }} OPI Menunggu Approval
            </span>
          </div>
        </div>
        <div class="card-body p-0">
          <!-- Bulk Actions Form - wraps entire table -->
          <form id="bulkApproveForm" action="{{ route('acc.opi.approve.bulk') }}" method="POST">
            @csrf
            <div class="px-3 py-2 bg-light border-bottom">
              <div class="row align-items-center">
                <div class="col-md-6">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="selectAll">
                    <label class="custom-control-label" for="selectAll">Pilih Semua</label>
                  </div>
                </div>
                <div class="col-md-6 text-right">
                  <button type="submit" class="btn btn-success btn-sm" id="bulkApproveBtn" disabled>
                    <i class="fas fa-check-double mr-1"></i> Approve Terpilih
                  </button>
                  <span class="ml-2 text-muted">
                    <span id="selectedCount">0</span> OPI dipilih
                  </span>
                </div>
              </div>
            </div>
          <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
              <thead class="thead-light">
                <tr>
                  <th scope="col" class="text-center" width="50">
                    <i class="fas fa-tasks mr-1"></i>
                    Pilih
                  </th>
                  <th scope="col" class="text-center">#</th>
                  <th scope="col" class="text-center">
                    <i class="fas fa-hashtag mr-1"></i>
                    No OPI
                  </th>
                  <th scope="col" class="text-center">
                    <i class="fas fa-calendar-alt mr-1"></i>
                    Tanggal Dibuat
                  </th>
                  <th scope="col" class="text-center">
                    <i class="fas fa-boxes mr-1"></i>
                    Qty Order (Pcs)
                  </th>
                  <th scope="col" class="text-center">
                    <i class="fas fa-file-contract mr-1"></i>
                    No Kontrak
                  </th>
                  <th scope="col" class="text-center">
                    <i class="fas fa-user mr-1"></i>
                    Customer
                  </th>
                  <th scope="col" class="text-center">
                    <i class="fas fa-info-circle mr-1"></i>
                    Status
                  </th>
                  <th scope="col" class="text-center">
                    <i class="fas fa-cogs mr-1"></i>
                    Action
                  </th>
                </tr>
              </thead>
              <tbody>
                @forelse ($opi as $index => $data)
                <tr class="animate-row">
                  <td class="text-center">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input opi-checkbox" 
                             id="opi_{{ $data->id }}" 
                             name="selected_opi[]" 
                             value="{{ $data->id }}">
                      <label class="custom-control-label" for="opi_{{ $data->id }}"></label>
                    </div>
                  </td>
                  <td class="text-center">{{ $opi->firstItem() + $index }}</td>
                  <td class="text-center font-weight-bold text-primary">
                    <i class="fas fa-file-alt mr-1"></i>
                    {{ $data->NoOPI }}
                  </td>
                  <td class="text-center">
                    <span class="badge badge-outline-secondary">
                      <i class="fas fa-calendar mr-1"></i>
                      {{ $data->created_at ? $data->created_at->format('d/m/Y') : '-' }}
                    </span>
                  </td>
                  <td class="text-center">
                    <span class="badge badge-info badge-lg">
                      <i class="fas fa-arrow-up mr-1"></i>
                      {{ number_format((int)$data->jumlahOrder) }}
                    </span>
                  </td>
                  <td class="text-center">
                    <span class="text-primary font-weight-bold">
                      {{ $data->kontrak_d_id ? $data->kontrakd->kontrakm->kode ?? 'N/A' : 'N/A' }}
                    </span>
                  </td>
                  <td class="text-center">
                    <span class="text-dark">
                      {{ $data->kontrak_d_id ? $data->kontrakd->kontrakm->customer_name ?? 'N/A' : 'N/A' }}
                    </span>
                  </td>
                  <td class="text-center">
                    <span class="badge badge-warning font-weight-bold">
                      <i class="fas fa-clock mr-1"></i>
                      {{ $data->status_opi }}
                    </span>
                  </td>
                  <td class="text-center">
                    <div class="btn-group" role="group">
                      <!-- Approve Button -->
                      <form action="{{ route('acc.opi.approve', $data->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin approve OPI {{ $data->NoOPI }}?')">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm" title="Approve OPI">
                          <i class="fas fa-check"></i> Approve
                        </button>
                      </form>
                      
                      {{-- <!-- View Detail Button -->
                      <a href="{{ route('opi.show', $data->id) }}" class="btn btn-info btn-sm ml-1" title="Lihat Detail">
                        <i class="fas fa-eye"></i>
                      </a> --}}
                    </div>
                  </td>
                </tr>
                @empty 
                <tr>
                  <td colspan="9" class="text-center py-5">
                    <div class="empty-state">
                      <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                      <h5 class="text-muted">Tidak Ada OPI Pending</h5>
                      <p class="text-muted">Semua OPI sudah disetujui atau belum ada data OPI yang perlu disetujui.</p>
                    </div>
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </form>
          </div>
        </div>
        @if($opi->count() > 0)
        <div class="card-footer bg-light">
          <div class="row">
            <div class="col-sm-6">
              <small class="text-muted">
                <i class="fas fa-info-circle mr-1"></i>
                Menampilkan {{ $opi->firstItem() }} - {{ $opi->lastItem() }} dari {{ $opi->total() }} data OPI
              </small>
            </div>
            <div class="col-sm-6">
              {{ $opi->links() }}
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
    // Auto-refresh every 30 seconds for new pending OPI
    setInterval(function() {
        if (document.visibilityState === 'visible') {
            location.reload();
        }
    }, 30000);
    
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // Highlight search term
    const searchTerm = '{{ $search }}';
    if (searchTerm) {
        $('td').each(function() {
            const text = $(this).text();
            if (text.toLowerCase().includes(searchTerm.toLowerCase())) {
                $(this).html(text.replace(new RegExp('(' + searchTerm + ')', 'gi'), '<mark>$1</mark>'));
            }
        });
    }
    
    // Bulk selection functionality
    $('#selectAll').change(function() {
        const isChecked = $(this).is(':checked');
        $('.opi-checkbox').prop('checked', isChecked);
        updateBulkActions();
    });
    
    // Individual checkbox change
    $('.opi-checkbox').change(function() {
        updateBulkActions();
        
        // Update select all checkbox
        const totalCheckboxes = $('.opi-checkbox').length;
        const checkedCheckboxes = $('.opi-checkbox:checked').length;
        
        $('#selectAll').prop('indeterminate', checkedCheckboxes > 0 && checkedCheckboxes < totalCheckboxes);
        $('#selectAll').prop('checked', checkedCheckboxes === totalCheckboxes);
    });
    
    // Bulk approve form submission
    $('#bulkApproveForm').on('submit', function(e) {
        const selectedCount = $('.opi-checkbox:checked').length;
        
        if (selectedCount === 0) {
            e.preventDefault();
            alert('Pilih minimal 1 OPI untuk di-approve');
            return false;
        }
        
        const confirmMsg = `Yakin ingin approve ${selectedCount} OPI yang dipilih?`;
        if (!confirm(confirmMsg)) {
            e.preventDefault();
            return false;
        }
    });
    
    function updateBulkActions() {
        const checkedCount = $('.opi-checkbox:checked').length;
        $('#selectedCount').text(checkedCount);
        $('#bulkApproveBtn').prop('disabled', checkedCount === 0);
    }
});
</script>
@endsection