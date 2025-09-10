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

/* Ensure sidebar is not hidden */
.main-sidebar {
  display: block !important;
  visibility: visible !important;
  z-index: 1050;
}

/* Fix content wrapper positioning */
.content-wrapper {
  margin-left: 250px;
  transition: margin-left 0.3s ease-in-out;
}

/* When sidebar is collapsed */
body.sidebar-collapse .content-wrapper {
  margin-left: 0;
}

@media (max-width: 767.98px) {
  .content-wrapper {
    margin-left: 0;
  }
}
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
              <th class="min-w-100px">{{ __('Waktu Di Buka') }}</th>
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
                <td class="text-gray-800 fw-semibold">
                  {{ $notification->updated_at ? \Carbon\Carbon::parse($notification->updated_at)->format('d-m-Y H:i') : '-' }}
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

@section('javascripts')
<script>
$(document).ready(function() {
    console.log('Notifikasi page loaded');
    console.log('jQuery version:', $.fn.jquery);
    console.log('Body classes:', $('body').attr('class'));
    console.log('Sidebar exists:', $('.main-sidebar').length > 0);
    console.log('Sidebar visible:', $('.main-sidebar').is(':visible'));
    
    // Debug sidebar state
    function debugSidebar() {
        console.log('=== SIDEBAR DEBUG ===');
        console.log('Sidebar element:', $('.main-sidebar')[0]);
        console.log('Sidebar CSS display:', $('.main-sidebar').css('display'));
        console.log('Sidebar CSS visibility:', $('.main-sidebar').css('visibility'));
        console.log('Body has sidebar-collapse:', $('body').hasClass('sidebar-collapse'));
        console.log('Pushmenu button exists:', $('[data-widget="pushmenu"]').length > 0);
    }
    
    // Ensure sidebar is visible and functional
    function ensureSidebarWorks() {
        // Debug first
        debugSidebar();
        
        // Force show sidebar if hidden
        $('.main-sidebar').show().css('visibility', 'visible');
        
        // Remove any inline styles that might hide it
        $('.main-sidebar').attr('style', function(i, style) {
            if (style) {
                return style.replace(/display\s*:\s*none/g, 'display: block');
            }
            return style;
        });
        
        // Ensure body has proper AdminLTE classes
        if (!$('body').hasClass('hold-transition')) {
            $('body').addClass('hold-transition sidebar-mini layout-fixed');
        }
        
        // Re-initialize sidebar toggle functionality
        $('[data-widget="pushmenu"]').off('click.notif').on('click.notif', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $('body').toggleClass('sidebar-collapse');
            console.log('Sidebar toggled from notifikasi page - collapsed:', $('body').hasClass('sidebar-collapse'));
        });
        
        // Initialize AdminLTE sidebar functionality if available
        if (typeof $.AdminLTE !== 'undefined' && $.AdminLTE.layout) {
            $.AdminLTE.layout.activate();
            console.log('AdminLTE layout activated');
        }
        
        // Force sidebar to be visible
        setTimeout(function() {
            $('.main-sidebar').show();
            debugSidebar();
        }, 500);
    }
    
    // Run on page load
    ensureSidebarWorks();
    
    // Also run after a short delay to ensure DOM is fully loaded
    setTimeout(ensureSidebarWorks, 100);
    
    // Add click handler to debug button if needed
    if (window.location.search.includes('debug=1')) {
        $('body').append('<button id="debugSidebar" style="position:fixed;top:10px;right:10px;z-index:9999;background:red;color:white;padding:10px;">Debug Sidebar</button>');
        $('#debugSidebar').click(function() {
            debugSidebar();
            ensureSidebarWorks();
        });
    }
});
</script>
@endsection
