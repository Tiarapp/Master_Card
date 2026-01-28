<!-- jQuery -->
<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>
@extends('admin.templates.partials.default')

<style>
.badge-sm {
    font-size: 0.7em;
    padding: 0.2em 0.4em;
}
.table td, .table th {
    vertical-align: middle;
}
.text-success {
    color: #28a745 !important;
}
.text-warning {
    color: #ffc107 !important;
}
.text-danger {
    color: #dc3545 !important;
}
.text-info {
    color: #17a2b8 !important;
}
.pagination {
    margin-bottom: 0;
}
.page-link {
    color: #007bff;
}
.page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
}
</style>

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Forecast Tonase Customer</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Marketing</a></li>
              <li class="breadcrumb-item active">Forecast Tonase</li>
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
      
      <div class="row mb-3">
        <div class="col-md-6">
          <a href="{{ route('forecast.tonase.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Forecast
          </a>
          <a href="{{ route('forecast.tonase.import.form') }}" class="btn btn-success ml-2">
            <i class="fas fa-upload"></i> Import Excel
          </a>
          <a href="{{ route('forecast.tonase.template') }}" class="btn btn-info ml-2">
            <i class="fas fa-download"></i> Download Template
          </a>
        </div>
        <div class="col-md-6">
          <div class="form-group mb-0">
            <label for="year-selector" class="mb-1">Pilih Tahun:</label>
            <select id="year-selector" class="form-control" onchange="changeYear(this.value)">
              @foreach($availableYears ?? [date('Y')] as $year)
                <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>
                  {{ $year }}
                </option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
      
      <!-- Search Form -->
      <div class="row mb-3">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body py-2">
              <form method="GET" action="{{ route('forecast.tonase.index') }}" class="form-inline">
                <input type="hidden" name="year" value="{{ $currentYear }}">
                <div class="form-group mr-3">
                  <label for="search_customer" class="mr-2">Customer:</label>
                  <input type="text" class="form-control" id="search_customer" name="search_customer" 
                         value="{{ $searchCustomer ?? '' }}" placeholder="Cari customer...">
                </div>
                <div class="form-group mr-3">
                  <label for="search_sales" class="mr-2">Sales:</label>
                  <input type="text" class="form-control" id="search_sales" name="search_sales" 
                         value="{{ $searchSales ?? '' }}" placeholder="Cari sales...">
                </div>
                <button type="submit" class="btn btn-primary mr-2">
                  <i class="fas fa-search"></i> Search
                </button>
                @if($searchCustomer || $searchSales)
                <a href="{{ route('forecast.tonase.index', ['year' => $currentYear]) }}" class="btn btn-secondary">
                  <i class="fas fa-times"></i> Clear
                </a>
                @endif
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Data Forecast Tonase Customer</h3>
          <div class="card-tools">
            <span class="badge badge-info mr-2">
              Menampilkan {{ $customerSalesCombinations->firstItem() ?? 0 }} - {{ $customerSalesCombinations->lastItem() ?? 0 }} 
              dari {{ $customerSalesCombinations->total() }} data
            </span>
            <span class="badge badge-success">
              Loading: {{ $timingInfo['execution_time'] ?? 0 }}ms | Queries: {{ $timingInfo['query_count'] ?? 0 }}
            </span>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-striped">
              <thead class="thead-light">
                <tr>
                  <th rowspan="3" class="align-middle">No</th>
                  <th rowspan="3" class="align-middle">Customer</th>
                  <th rowspan="3" class="align-middle">Sales</th>
                  <th colspan="36" class="text-center">Data Tonase {{ $currentYear ?? date('Y') }}</th>
                  <th rowspan="3" class="align-middle">Action</th>
                </tr>
                <tr>
                  <th colspan="3" class="text-center">Januari</th>
                  <th colspan="3" class="text-center">Februari</th>
                  <th colspan="3" class="text-center">Maret</th>
                  <th colspan="3" class="text-center">April</th>
                  <th colspan="3" class="text-center">Mei</th>
                  <th colspan="3" class="text-center">Juni</th>
                  <th colspan="3" class="text-center">Juli</th>
                  <th colspan="3" class="text-center">Agustus</th>
                  <th colspan="3" class="text-center">September</th>
                  <th colspan="3" class="text-center">Oktober</th>
                  <th colspan="3" class="text-center">November</th>
                  <th colspan="3" class="text-center">Desember</th>
                </tr>
                <tr>
                  @for($i = 1; $i <= 12; $i++)
                    <th class="text-center">Target</th>
                    <th class="text-center">Intake</th>
                    <th class="text-center">Realisasi</th>
                  @endfor
                </tr>
              </thead>
              <tbody>
                @php $no = (($customerSalesCombinations->currentPage() - 1) * $customerSalesCombinations->perPage()) + 1; @endphp
                @forelse($paginatedForecasts ?? [] as $groupKey => $groupedForecasts)
                @php
                  list($customerName, $salesName) = explode('|', $groupKey);
                  // Create array for 12 months
                  $monthlyData = [];
                  foreach($groupedForecasts as $forecast) {
                    $monthlyData[$forecast->bulan] = $forecast;
                  }
                @endphp
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>
                    {{ $customerName }}
                  </td>
                  <td>{{ $salesName != 'No Sales' ? $salesName : '-' }}</td>
                  
                  @for($month = 1; $month <= 12; $month++)
                    @if(isset($monthlyData[$month]))
                      @php 
                        $forecast = $monthlyData[$month];
                        $realisasi = $forecast->realisasi_calculated ?? 0;  // Use pre-calculated data
                        $intake = $forecast->intake_calculated ?? 0;        // Use pre-calculated data
                        $percentage = $forecast->target_tonase > 0 ? ($realisasi / $forecast->target_tonase) * 100 : 0;
                        $intakePercentage = $forecast->target_tonase > 0 ? ($intake / $forecast->target_tonase) * 100 : 0;
                      @endphp
                      <!-- Target -->
                      <td class="text-center">
                        <strong class="text-primary">{{ number_format($forecast->target_tonase, 1) }}</strong>
                      </td>
                      <!-- Intake -->
                      <td class="text-center">
                        <span class="font-weight-bold {{ $intake > 0 ? 'text-info' : 'text-muted' }}">
                          {{ number_format($intake, 1) }}
                        </span>
                        @if($forecast->target_tonase > 0)
                        <br>
                        <span class="badge badge-sm
                          @if($intakePercentage >= 100) badge-info
                          @elseif($intakePercentage >= 75) badge-secondary  
                          @else badge-light
                          @endif
                        " title="Intake vs Target">
                          {{ number_format($intakePercentage, 0) }}%
                        </span>
                        @endif
                      </td>
                      <!-- Realisasi -->
                      <td class="text-center">
                        <span class="font-weight-bold {{ $realisasi > 0 ? 'text-success' : 'text-muted' }}">
                          {{ number_format($realisasi, 1) }}
                        </span>
                        @if($forecast->target_tonase > 0)
                        <br>
                        <span class="badge badge-sm 
                          @if($percentage >= 100) badge-success
                          @elseif($percentage >= 75) badge-warning  
                          @else badge-danger
                          @endif
                        " title="Realisasi vs Target">
                          {{ number_format($percentage, 0) }}%
                        </span>
                        @endif
                      </td>
                    @else
                      <!-- No data for this month -->
                      <td class="text-center"><span class="text-muted">-</span></td>
                      <td class="text-center"><span class="text-muted">-</span></td>
                      <td class="text-center"><span class="text-muted">-</span></td>
                    @endif
                  @endfor
                  
                  <td class="text-center">
                    <div class="btn-group-vertical btn-group-sm" role="group">
                      <button type="button" class="btn btn-info btn-sm mb-1" onclick="viewDetails('{{ $groupKey }}')">
                        <i class="fas fa-eye"></i>
                      </button>
                      <button type="button" class="btn btn-success btn-sm" onclick="addMonthlyForecast('{{ $customerName }}', '{{ $salesName }}')">
                        <i class="fas fa-plus"></i>
                      </button>
                    </div>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="40" class="text-center">Tidak ada data forecast tonase</td>
                </tr>
                @endforelse
              </tbody>

              <tfoot class="thead-dark">
                <tr>
                  <th colspan="3" class="text-center align-middle">
                    <strong>TOTAL</strong>
                  </th>
                  
                  @php
                    $monthlyTotals = [];
                    $grandTotals = ['target' => 0, 'intake' => 0, 'realisasi' => 0];
                    
                    // Initialize monthly totals
                    for($month = 1; $month <= 12; $month++) {
                      $monthlyTotals[$month] = ['target' => 0, 'intake' => 0, 'realisasi' => 0];
                    }
                    
                    // Calculate totals from ALL forecasts (not just current page)
                    // Check if allForecastsFlat variable exists, if not try to get all data
                    $allData = [];
                    
                    if(isset($allForecastsFlat)) {
                      $allData = $allForecastsFlat;
                    } elseif(isset($allForecasts)) {
                      $allData = $allForecasts;
                    } elseif(isset($totalForecasts)) {
                      $allData = $totalForecasts;  
                    } else {
                      // Fallback: if controller doesn't provide all data, show message
                      // Controller needs to provide $allForecastsFlat variable
                      // containing all forecast data without pagination
                    }
                    
                    // Calculate totals from all data
                    if(!empty($allData)) {
                      foreach($allData as $forecast) {
                        if(isset($forecast->bulan) && isset($forecast->target_tonase)) {
                          $monthlyTotals[$forecast->bulan]['target'] += $forecast->target_tonase ?? 0;
                          $monthlyTotals[$forecast->bulan]['intake'] += $forecast->intake_calculated ?? 0;  // Use pre-calculated data
                          $monthlyTotals[$forecast->bulan]['realisasi'] += $forecast->realisasi_calculated ?? 0;  // Use pre-calculated data
                          
                          $grandTotals['target'] += $forecast->target_tonase ?? 0;
                          $grandTotals['intake'] += $forecast->intake_calculated ?? 0;  // Use pre-calculated data
                          $grandTotals['realisasi'] += $forecast->realisasi_calculated ?? 0;  // Use pre-calculated data
                        }
                      }
                    }
                  @endphp
                  
                  @for($month = 1; $month <= 12; $month++)
                    <!-- Target Total -->
                    <th class="text-center">
                      <strong class="text-white">{{ number_format($monthlyTotals[$month]['target'], 1) }}</strong>
                    </th>
                    <!-- Intake Total -->
                    <th class="text-center">
                      <strong class="text-info">{{ number_format($monthlyTotals[$month]['intake'], 1) }}</strong>
                    </th>
                    <!-- Realisasi Total -->
                    <th class="text-center">
                      <strong class="text-success">{{ number_format($monthlyTotals[$month]['realisasi'], 1) }}</strong>
                    </th>
                  @endfor
                  
                  <th class="text-center align-middle">
                    <div class="text-white">
                      <small>Target: <strong>{{ number_format($grandTotals['target'], 1) }}</strong></small><br>
                      <small>Intake: <strong class="text-info">{{ number_format($grandTotals['intake'], 1) }}</strong></small><br>
                      <small>Real: <strong class="text-success">{{ number_format($grandTotals['realisasi'], 1) }}</strong></small>
                    </div>
                  </th>
                </tr>
              </tfoot>
              
            </table>
          </div>
          
          <!-- Pagination -->
          <div class="d-flex justify-content-center mt-4">
            {{ $customerSalesCombinations->appends(request()->only(['year', 'search_customer', 'search_sales']))->links() }}
          </div>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
</div>

<script>
function viewDetails(groupKey) {
    // Implementation for viewing customer forecast details
    alert('View details for: ' + groupKey.replace('|', ' - '));
}

function addMonthlyForecast(customerName, salesName) {
    // Redirect to create forecast for this customer
    let createUrl = "{{ route('forecast.tonase.create') }}";
    createUrl += `?customer=${encodeURIComponent(customerName)}&sales=${encodeURIComponent(salesName)}`;
    window.location.href = createUrl;
}

function changeYear(selectedYear) {
    // Redirect to same page with selected year parameter and preserve search
    let currentUrl = new URL(window.location.href);
    currentUrl.searchParams.set('year', selectedYear);
    window.location.href = currentUrl.toString();
}
</script>

@endsection
