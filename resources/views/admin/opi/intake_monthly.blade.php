@extends('admin.templates.partials.default')

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">
            <i class="fas fa-file-download text-primary me-2"></i>
            Export Intake Bulanan
          </h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('opinew') }}">OPI</a></li>
            <li class="breadcrumb-item active">Export Intake</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

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

      <!-- Export Form Card -->
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="card shadow-lg border-0">
            <div class="card-header bg-gradient-primary text-white">
              <h3 class="card-title mb-0">
                <i class="fas fa-calendar-alt me-2"></i>
                Export Data Intake OPI Per Bulan
              </h3>
            </div>
            <div class="card-body p-4">
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-4">
                    <h5 class="text-muted mb-3">
                      <i class="fas fa-info-circle me-2"></i>Informasi Export
                    </h5>
                    <ul class="list-unstyled">
                      <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Data OPI berdasarkan tanggal intake
                      </li>
                      <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Mencakup semua field detail kontrak
                      </li>
                      <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Kalkulasi tonase dan sisa kirim otomatis
                      </li>
                      <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Format Excel dengan styling profesional
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="col-md-6">
                  <form action="{{ route('opi.intake.export') }}" method="GET" id="exportForm">
                    <div class="mb-4">
                      <label for="year" class="form-label fw-bold">
                        <i class="fas fa-calendar me-1"></i>Pilih Tahun
                      </label>
                      <select class="form-select form-select-lg" id="year" name="year" required>
                        @for($y = date('Y'); $y >= 2020; $y--)
                          <option value="{{ $y }}" {{ $y == date('Y') ? 'selected' : '' }}>
                            {{ $y }}
                          </option>
                        @endfor
                      </select>
                    </div>

                    <div class="mb-4">
                      <label for="month" class="form-label fw-bold">
                        <i class="fas fa-calendar-alt me-1"></i>Pilih Bulan
                      </label>
                      <select class="form-select form-select-lg" id="month" name="month" required>
                        @php
                          $months = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                          ];
                        @endphp
                        @foreach($months as $num => $name)
                          <option value="{{ $num }}" {{ $num == date('n') ? 'selected' : '' }}>
                            {{ $name }}
                          </option>
                        @endforeach
                      </select>
                    </div>

                    <div class="d-grid gap-2">
                      <button type="submit" class="btn btn-success btn-lg shadow-sm" id="exportBtn">
                        <i class="fas fa-download me-2"></i>
                        Export ke Excel
                      </button>
                      <a href="{{ route('opinew') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Kembali ke OPI
                      </a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <!-- Field Information Card -->
          <div class="card shadow-sm border-0 mt-4">
            <div class="card-header bg-light">
              <h5 class="card-title mb-0">
                <i class="fas fa-list me-2"></i>Field yang Akan Di-export
              </h5>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <ol class="list-group list-group-flush">
                    <li class="list-group-item px-0 py-1">1. Tanggal Kontrak</li>
                    <li class="list-group-item px-0 py-1">2. Tanggal Kirim</li>
                    <li class="list-group-item px-0 py-1">3. Customer</li>
                    <li class="list-group-item px-0 py-1">4. PO Customer</li>
                    <li class="list-group-item px-0 py-1">5. Nomer Kontrak</li>
                    <li class="list-group-item px-0 py-1">6. OPI</li>
                    <li class="list-group-item px-0 py-1">7. Tipe Box</li>
                    <li class="list-group-item px-0 py-1">8. Wax</li>
                    <li class="list-group-item px-0 py-1">9. Tipe Order</li>
                    <li class="list-group-item px-0 py-1">10. Nama Barang</li>
                  </ol>
                </div>
                <div class="col-md-6">
                  <ol class="list-group list-group-flush" start="11">
                    <li class="list-group-item px-0 py-1">11. Qty OPI Pcs</li>
                    <li class="list-group-item px-0 py-1">12. Gram Kontrak</li>
                    <li class="list-group-item px-0 py-1">13. Tonase (qty × berat)</li>
                    <li class="list-group-item px-0 py-1">14. Qty Kirim</li>
                    <li class="list-group-item px-0 py-1">15. Ton Kirim</li>
                    <li class="list-group-item px-0 py-1">16. Tanggal Kirim</li>
                    <li class="list-group-item px-0 py-1">17. Kurang Kirim</li>
                    <li class="list-group-item px-0 py-1">18. Ton Kurang Kirim</li>
                    <li class="list-group-item px-0 py-1">19. Keterangan</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<style>
.bg-gradient-primary {
  background: linear-gradient(45deg, #4e73df 0%, #224abe 100%);
}

.card {
  border-radius: 15px;
}

.card-header {
  border-radius: 15px 15px 0 0 !important;
}

.form-select-lg, .btn-lg {
  border-radius: 10px;
}

.list-group-item {
  border: none;
  font-size: 0.9rem;
}

.shadow-lg {
  box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('exportForm');
    const exportBtn = document.getElementById('exportBtn');
    
    form.addEventListener('submit', function(e) {
        // Change button text to show loading
        const originalText = exportBtn.innerHTML;
        exportBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menggenerate File...';
        exportBtn.disabled = true;
        
        // Re-enable button after 10 seconds
        setTimeout(function() {
            exportBtn.innerHTML = originalText;
            exportBtn.disabled = false;
        }, 10000);
    });
    
    // Update button text based on selected month/year
    function updateButtonText() {
        const year = document.getElementById('year').value;
        const month = document.getElementById('month').value;
        const monthName = document.getElementById('month').selectedOptions[0].text;
        
        const btnText = `<i class="fas fa-download me-2"></i>Export ${monthName} ${year}`;
        if (!exportBtn.disabled) {
            exportBtn.innerHTML = btnText;
        }
    }
    
    document.getElementById('year').addEventListener('change', updateButtonText);
    document.getElementById('month').addEventListener('change', updateButtonText);
    
    // Initial button text update
    updateButtonText();
});
</script>
@endsection