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
</style>

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
          <strong>{{ $message }}</strong>
        </div>
      @endif
      
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Notifikasi</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Notifikasi</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      
      <!-- Action Buttons & Search -->
      <div class="row mb-4 align-items-center">
        <div class="col-auto d-flex align-items-center gap-3">
          <a href="{{ route('job.create') }}" class="btn btn-success d-flex align-items-center shadow-sm" style="margin-bottom: 20px;">
            <i class="fas fa-plus-circle me-2"></i>
            <span>{{ __('Tambah Notifikasi') }}</span>
          </a>
        </div>
        <div class="col text-end">
          <form class="d-flex align-items-center justify-content-end gap-2" action="{{ route('job.index') }}" method="GET" style="margin-bottom: 20px;">
            <div class="input-group" style="max-width: 350px;">
              <span class="input-group-text bg-white border-end-0" style="border-radius: 20px 0 0 20px; border-right: none;">
                <i class="fas fa-search text-muted"></i>
              </span>
              <input 
                type="text" 
                class="form-control border-start-0 shadow-none" 
                name="search" 
                placeholder="{{ __('Cari Notifikasi...') }}" 
                value="{{ request('search') }}" 
                style="border-radius: 0 20px 20px 0; border-left: none; min-width: 200px;"
                autocomplete="off"
              >
            </div>
            <button type="submit" class="btn btn-primary px-4 shadow-sm">
              <i class="fas fa-search me-1"></i> {{ __('Cari') }}
            </button>
            <a href="{{ route('job.index') }}" class="btn btn-outline-secondary px-4 shadow-sm">
              <i class="fas fa-sync-alt me-1"></i> {{ __('Reset') }}
            </a>
          </form>
        </div>
      </div>

      <!-- Notifications Table -->
      <div class="table-responsive shadow rounded-3">
        <table class="table align-middle table-row-dashed table-row-bordered gy-5 gs-7 fs-6" style="background-color: #fff;">
          <thead>
            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
              <th class="min-w-125px">{{ __('Tanggal') }}</th>
              <th class="min-w-150px">{{ __('Kode Kontrak') }}</th>
              <th class="min-w-150px">{{ __('Pemohon') }}</th>
              <th class="min-w-200px">{{ __('Alasan') }}</th>
              <th class="min-w-100px">{{ __('Status') }}</th>
              <th class="min-w-100px">{{ __('PIC') }}</th>
              <th class="min-w-125px">{{ __('Action') }}</th>
            </tr>
          </thead>
          <tbody class="text-gray-900 fw-semibold">
            @forelse ($notifications as $notification)
              <tr>
                <td class="text-gray-800 fw-semibold">
                  {{ $notification->tanggal ? \Carbon\Carbon::parse($notification->tanggal)->format('d-m-Y') : '-' }}
                </td>
                <td class="text-primary fw-semibold">
                  {{ $notification->kontrak->kode ?? '-' }}
                </td>
                <td class="text-gray-800 fw-semibold">
                  <i class="fas fa-user text-info me-1"></i>
                  {{ $notification->pemohon ?? '-' }}
                </td>
                <td class="text-gray-800">
                  {{ $notification->alasan ?? '-' }}
                </td>
                <td class="p-10">
                  @php
                    $status = $notification->status;
                    switch ($status) {
                      case 'Proses':
                        $colorClass = 'warning';
                        $statusText = 'Proses';
                        break;
                      case 'Done':
                        $colorClass = 'success';
                        $statusText = 'Selesai';
                        break;
                      default:
                        $colorClass = 'other';
                        $statusText = $status ?? 'Unknown';
                    }
                  @endphp
                  <span class="label status {{ $colorClass }}">{{ $statusText }}</span>
                </td>
                <td class="text-gray-800 fw-semibold">
                  {{ $notification->pic ?? '-' }}
                </td>
                <td>
                  @if($notification->status == 'Proses')
                    <a href="{{ url('admin/kontrak/open/' . $notification->kontrak_id) }}" 
                       class="btn btn-success btn-sm d-flex align-items-center gap-1 shadow-sm"
                       title="Open Kontrak">
                      <i class="fas fa-external-link-alt"></i>
                      <span>OPEN</span>
                    </a>
                  @else
                    <button class="btn btn-success btn-sm d-flex align-items-center gap-1 shadow-sm" 
                            disabled 
                            title="Sudah Selesai">
                      <i class="fas fa-check"></i>
                      <span>Done</span>
                    </button>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center py-4">
                  <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                  <p class="text-muted">{{ request('search') ? 'Tidak ada hasil pencarian' : 'Tidak ada notifikasi' }}</p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      
      <!-- Pagination -->
      @if($notifications->hasPages())
        {{ $notifications->appends(request()->query())->links('pagination::bootstrap-4') }}
      @endif
      
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
@endsection
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
          <strong>{{ $message }}</strong>
        </div>
      @endif
      
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Notifikasi</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Notifikasi</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      
      <!-- Action Buttons -->
      <div class="row mb-3">
        <div class="col-12">
          <a href="{{ route('job.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Notifikasi
          </a>
          <button onclick="refreshData()" class="btn btn-secondary ml-2">
            <i class="fas fa-sync-alt"></i> Refresh
          </button>
        </div>
      </div>

      <!-- Search -->
      <div class="row mb-3">
        <div class="col-md-6">
          <div class="input-group">
            <input type="text" id="searchInput" class="form-control" placeholder="Cari notifikasi...">
            <div class="input-group-append">
              <button class="btn btn-outline-secondary" type="button" onclick="searchData()">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </div>
        <div class="col-md-6 text-right">
          <small class="text-muted">
            Menampilkan {{ $notifications->firstItem() ?? 0 }} - {{ $notifications->lastItem() ?? 0 }} 
            dari {{ $notifications->total() }} notifikasi
          </small>
        </div>
      </div>

      <!-- Notifications Card -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Daftar Notifikasi</h3>
        </div>
        <div class="card-body p-0">
          
          <!-- Table Header -->
          <div class="row bg-light font-weight-bold p-3 border-bottom d-none d-md-flex">
            <div class="col-md-2">Tanggal</div>
            <div class="col-md-2">Kode Kontrak</div>
            <div class="col-md-2">Pemohon</div>
            <div class="col-md-3">Alasan</div>
            <div class="col-md-1">Status</div>
            <div class="col-md-1">PIC</div>
            <div class="col-md-1">Action</div>
          </div>

          <!-- Data Container -->
          <div id="dataContainer">
            @if($notifications->count() > 0)
              @foreach($notifications as $index => $notification)
                <div class="notification-item row align-items-center p-3 border-bottom {{ $index % 2 == 0 ? 'bg-white' : 'bg-light' }}">
                  <!-- Mobile Layout -->
                  <div class="col-12 d-md-none">
                    <div class="card mb-2">
                      <div class="card-body p-3">
                        <div class="row">
                          <div class="col-8">
                            <h6 class="card-title mb-1">{{ $notification->kontrak->kode ?? 'N/A' }}</h6>
                            <p class="card-text small mb-1">{{ $notification->alasan ?? 'N/A' }}</p>
                            <small class="text-muted">
                              <i class="fas fa-user"></i> {{ $notification->pemohon ?? 'N/A' }} |
                              <i class="fas fa-calendar"></i> {{ $notification->tanggal ?? 'N/A' }}
                            </small>
                          </div>
                          <div class="col-4 text-right">
                            @if($notification->status == 'Proses')
                              <span class="badge badge-warning mb-2">
                                <i class="fas fa-clock"></i> {{ $notification->status }}
                              </span>
                              <br>
                              <a href="{{ url('admin/kontrak/open/' . $notification->kontrak_id) }}" 
                                 class="btn btn-success btn-sm">
                                <i class="fas fa-external-link-alt"></i> OPEN
                              </a>
                            @else
                              <span class="badge badge-success mb-2">
                                <i class="fas fa-check"></i> {{ $notification->status }}
                              </span>
                              <br>
                              <button class="btn btn-success btn-sm" disabled>
                                <i class="fas fa-check"></i> Done
                              </button>
                            @endif
                            @if($notification->pic)
                              <br><small class="text-muted">PIC: {{ $notification->pic }}</small>
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Desktop Layout -->
                  <div class="col-md-2 d-none d-md-block">
                    <small class="text-muted">
                      <i class="fas fa-calendar"></i> {{ $notification->tanggal ?? 'N/A' }}
                    </small>
                  </div>
                  <div class="col-md-2 d-none d-md-block">
                    <strong class="text-primary">{{ $notification->kontrak->kode ?? 'N/A' }}</strong>
                  </div>
                  <div class="col-md-2 d-none d-md-block">
                    <span class="text-info">
                      <i class="fas fa-user"></i> {{ $notification->pemohon ?? 'N/A' }}
                    </span>
                  </div>
                  <div class="col-md-3 d-none d-md-block">
                    <p class="mb-0 text-wrap">{{ $notification->alasan ?? 'N/A' }}</p>
                  </div>
                  <div class="col-md-1 d-none d-md-block">
                    @if($notification->status == 'Proses')
                      <span class="badge badge-warning">
                        <i class="fas fa-clock"></i> {{ $notification->status }}
                      </span>
                    @else
                      <span class="badge badge-success">
                        <i class="fas fa-check"></i> {{ $notification->status }}
                      </span>
                    @endif
                  </div>
                  <div class="col-md-1 d-none d-md-block">
                    <small class="text-muted">{{ $notification->pic ?? '-' }}</small>
                  </div>
                  <div class="col-md-1 d-none d-md-block">
                    @if($notification->status == 'Proses')
                      <a href="{{ url('admin/kontrak/open/' . $notification->kontrak_id) }}" 
                         class="btn btn-success btn-sm" 
                         title="OPEN">
                        <i class="fas fa-external-link-alt"></i>
                      </a>
                    @else
                      <button class="btn btn-success btn-sm" disabled title="Sudah selesai">
                        <i class="fas fa-check"></i>
                      </button>
                    @endif
                  </div>
                </div>
              @endforeach
            @else
              <div class="text-center p-4">
                <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                <p class="text-muted">Tidak ada notifikasi</p>
              </div>
            @endif
          </div>

          <!-- Loading State -->
          <div id="loadingState" class="text-center p-4" style="display: none;">
            <div class="spinner-border text-primary" role="status">
              <span class="sr-only">Loading...</span>
            </div>
            <p class="mt-2">Memuat data...</p>
          </div>

        </div>
        
        <!-- Pagination -->
        @if($notifications->hasPages())
        <div class="card-footer">
          <div class="row align-items-center">
            <div class="col-md-6">
              <small class="text-muted">
                Menampilkan {{ $notifications->firstItem() }} - {{ $notifications->lastItem() }} 
                dari {{ $notifications->total() }} total data
              </small>
            </div>
            <div class="col-md-6">
              <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm float-right mb-0">
                  {{-- Previous Page Link --}}
                  @if ($notifications->onFirstPage())
                    <li class="page-item disabled">
                      <span class="page-link">
                        <i class="fas fa-angle-left"></i>
                      </span>
                    </li>
                  @else
                    <li class="page-item">
                      <a class="page-link" href="{{ $notifications->previousPageUrl() }}" rel="prev">
                        <i class="fas fa-angle-left"></i>
                      </a>
                    </li>
                  @endif

                  {{-- Pagination Elements --}}
                  @foreach ($notifications->getUrlRange(1, $notifications->lastPage()) as $page => $url)
                    @if ($page == $notifications->currentPage())
                      <li class="page-item active">
                        <span class="page-link">{{ $page }}</span>
                      </li>
                    @else
                      <li class="page-item">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                      </li>
                    @endif
                  @endforeach

                  {{-- Next Page Link --}}
                  @if ($notifications->hasMorePages())
                    <li class="page-item">
                      <a class="page-link" href="{{ $notifications->nextPageUrl() }}" rel="next">
                        <i class="fas fa-angle-right"></i>
                      </a>
                    </li>
                  @else
                    <li class="page-item disabled">
                      <span class="page-link">
                        <i class="fas fa-angle-right"></i>
                      </span>
                    </li>
                  @endif
                </ul>
              </nav>
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
    // Real-time search
    $('#searchInput').on('keyup', function() {
        const searchTerm = $(this).val().toLowerCase();
        if (searchTerm.length > 2 || searchTerm.length === 0) {
            filterData(searchTerm);
        }
    });

    // Enter key search
    $('#searchInput').on('keypress', function(e) {
        if (e.which === 13) {
            searchData();
        }
    });
});

function filterData(searchTerm) {
    let visibleCount = 0;
    
    $('.notification-item').each(function() {
        const text = $(this).text().toLowerCase();
        if (searchTerm === '' || text.includes(searchTerm)) {
            $(this).show();
            visibleCount++;
        } else {
            $(this).hide();
        }
    });
    
    // Show/hide empty state for client-side filtering
    if (visibleCount === 0 && searchTerm !== '') {
        showEmptyState('Tidak ada hasil pencarian');
    } else if (searchTerm === '') {
        // Reset to original state
        $('.card-footer').show();
    }
}

function searchData(page = 1) {
    const searchTerm = $('#searchInput').val();
    
    if (searchTerm.length === 0) {
        location.reload();
        return;
    }
    
    $('#loadingState').show();
    $('#dataContainer').hide();
    $('.card-footer').hide(); // Hide pagination during search
    
    $.ajax({
        url: "{{ route('job.index') }}",
        type: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        data: {
            search: searchTerm,
            page: page
        },
        success: function(response) {
            $('#loadingState').hide();
            $('#dataContainer').show();
            
            if (response.status === 'success') {
                displaySearchResults(response.data);
                updatePaginationInfo(response.pagination, searchTerm);
                
                // Update counter info
                $('.col-md-6.text-right small').html(`
                    Menampilkan ${response.pagination.from || 0} - ${response.pagination.to || 0} 
                    dari ${response.pagination.total} hasil pencarian
                `);
            }
        },
        error: function(xhr, status, error) {
            $('#loadingState').hide();
            $('#dataContainer').show();
            console.error('Search error:', error);
            
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Gagal melakukan pencarian. Silakan coba lagi.'
                });
            } else {
                alert('Gagal melakukan pencarian. Silakan coba lagi.');
            }
        }
    });
}

function displaySearchResults(notifications) {
    let html = '';
    
    if (notifications.length === 0) {
        html = `
            <div class="text-center p-4">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <p class="text-muted">Tidak ada hasil pencarian</p>
            </div>
        `;
    } else {
        notifications.forEach(function(notification, index) {
            const bgClass = index % 2 === 0 ? 'bg-white' : 'bg-light';
            const statusClass = notification.status === 'Proses' ? 'badge-warning' : 'badge-success';
            const statusIcon = notification.status === 'Proses' ? 'fa-clock' : 'fa-check';
            
            html += `
                <div class="notification-item row align-items-center p-3 border-bottom ${bgClass}">
                    <!-- Mobile Layout -->
                    <div class="col-12 d-md-none">
                        <div class="card mb-2">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-8">
                                        <h6 class="card-title mb-1">${notification.kontrak ? notification.kontrak.kode : 'N/A'}</h6>
                                        <p class="card-text small mb-1">${notification.alasan || 'N/A'}</p>
                                        <small class="text-muted">
                                            <i class="fas fa-user"></i> ${notification.pemohon || 'N/A'} |
                                            <i class="fas fa-calendar"></i> ${notification.tanggal || 'N/A'}
                                        </small>
                                    </div>
                                    <div class="col-4 text-right">
                                        <span class="badge ${statusClass} mb-2">
                                            <i class="fas ${statusIcon}"></i> ${notification.status}
                                        </span>
                                        <br>
                                        ${getActionButton(notification)}
                                        ${notification.pic ? `<br><small class="text-muted">PIC: ${notification.pic}</small>` : ''}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Desktop Layout -->
                    <div class="col-md-2 d-none d-md-block">
                        <small class="text-muted">
                            <i class="fas fa-calendar"></i> ${notification.tanggal || 'N/A'}
                        </small>
                    </div>
                    <div class="col-md-2 d-none d-md-block">
                        <strong class="text-primary">${notification.kontrak ? notification.kontrak.kode : 'N/A'}</strong>
                    </div>
                    <div class="col-md-2 d-none d-md-block">
                        <span class="text-info">
                            <i class="fas fa-user"></i> ${notification.pemohon || 'N/A'}
                        </span>
                    </div>
                    <div class="col-md-3 d-none d-md-block">
                        <p class="mb-0 text-wrap">${notification.alasan || 'N/A'}</p>
                    </div>
                    <div class="col-md-1 d-none d-md-block">
                        <span class="badge ${statusClass}">
                            <i class="fas ${statusIcon}"></i> ${notification.status}
                        </span>
                    </div>
                    <div class="col-md-1 d-none d-md-block">
                        <small class="text-muted">${notification.pic || '-'}</small>
                    </div>
                    <div class="col-md-1 d-none d-md-block">
                        ${getActionButton(notification)}
                    </div>
                </div>
            `;
        });
    }
    
    $('#dataContainer').html(html);
}

function getActionButton(notification) {
    if (notification.status === 'Proses') {
        return `
            <a href="../admin/kontrak/open/${notification.kontrak_id}" 
               class="btn btn-success btn-sm" 
               title="OPEN">
                <i class="fas fa-external-link-alt"></i> OPEN
            </a>
        `;
    } else {
        return `
            <button class="btn btn-success btn-sm" disabled title="Sudah selesai">
                <i class="fas fa-check"></i> Done
            </button>
        `;
    }
}

function refreshData() {
    location.reload();
}

function updatePaginationInfo(pagination, searchTerm = '') {
    if (!pagination || pagination.last_page <= 1) {
        $('.card-footer').hide();
        return;
    }
    
    let paginationHtml = `
        <div class="row align-items-center">
            <div class="col-md-6">
                <small class="text-muted">
                    Menampilkan ${pagination.from} - ${pagination.to} 
                    dari ${pagination.total} ${searchTerm ? 'hasil pencarian' : 'total data'}
                </small>
            </div>
            <div class="col-md-6">
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm float-right mb-0">
    `;
    
    // Previous button
    if (pagination.current_page > 1) {
        paginationHtml += `
            <li class="page-item">
                <a class="page-link" href="#" onclick="searchData(${pagination.current_page - 1}); return false;">
                    <i class="fas fa-angle-left"></i>
                </a>
            </li>
        `;
    } else {
        paginationHtml += `
            <li class="page-item disabled">
                <span class="page-link">
                    <i class="fas fa-angle-left"></i>
                </span>
            </li>
        `;
    }
    
    // Page numbers
    let startPage = Math.max(1, pagination.current_page - 2);
    let endPage = Math.min(pagination.last_page, pagination.current_page + 2);
    
    for (let i = startPage; i <= endPage; i++) {
        if (i === pagination.current_page) {
            paginationHtml += `
                <li class="page-item active">
                    <span class="page-link">${i}</span>
                </li>
            `;
        } else {
            paginationHtml += `
                <li class="page-item">
                    <a class="page-link" href="#" onclick="searchData(${i}); return false;">${i}</a>
                </li>
            `;
        }
    }
    
    // Next button
    if (pagination.current_page < pagination.last_page) {
        paginationHtml += `
            <li class="page-item">
                <a class="page-link" href="#" onclick="searchData(${pagination.current_page + 1}); return false;">
                    <i class="fas fa-angle-right"></i>
                </a>
            </li>
        `;
    } else {
        paginationHtml += `
            <li class="page-item disabled">
                <span class="page-link">
                    <i class="fas fa-angle-right"></i>
                </span>
            </li>
        `;
    }
    
    paginationHtml += `
                    </ul>
                </nav>
            </div>
        </div>
    `;
    
    $('.card-footer').html(paginationHtml).show();
}

function showEmptyState(message) {
    $('#dataContainer').html(\`
        <div class="text-center p-4">
            <i class="fas fa-search fa-3x text-muted mb-3"></i>
            <p class="text-muted">\${message}</p>
        </div>
    \`);
    $('.card-footer').hide();
}

function hideEmptyState() {
    // This function can be used if needed
}
</script>
@endsection