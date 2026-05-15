@extends('admin.templates.partials.default')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Activity Tracking</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                        <li class="breadcrumb-item active">Activity Tracking</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">

            {{-- Filter Card --}}
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-filter mr-1"></i> Filter</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form id="filter-form" method="GET" action="{{ route('admin.tracking.index') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Tipe</label>
                                    <select name="tipe" class="form-control select2" style="width: 100%;">
                                        <option value="">-- Semua Tipe --</option>
                                        @foreach($tipes as $tipe)
                                            <option value="{{ $tipe }}" {{ request('tipe') == $tipe ? 'selected' : '' }}>{{ $tipe }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>User</label>
                                    <select name="user" class="form-control select2" style="width: 100%;">
                                        <option value="">-- Semua User --</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user }}" {{ request('user') == $user ? 'selected' : '' }}>{{ $user }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Tanggal Dari</label>
                                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Tanggal Sampai</label>
                                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                                </div>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <div class="form-group w-100">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fas fa-search mr-1"></i> Cari
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{ route('admin.tracking.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-times mr-1"></i> Reset Filter
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Table Card --}}
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-history mr-1"></i> Semua Activity Tracking
                        <span class="badge badge-info ml-2">{{ $trackings->total() }} data</span>
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 50px;">#</th>
                                    <th>User</th>
                                    <th>Tipe</th>
                                    <th>Event</th>
                                    <th style="min-width: 200px;">Sebelum Perubahan</th>
                                    <th style="min-width: 200px;">Setelah Perubahan</th>
                                    <th style="white-space: nowrap;">Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($trackings as $i => $track)
                                    @php
                                        $beforeDecoded = json_decode($track->before, true);
                                        $afterDecoded  = json_decode($track->after, true);
                                        $tipeColorMap = [
                                            'Kontrak'         => 'badge-success',
                                            'OPI'             => 'badge-warning',
                                            'Mastercard'      => 'badge-danger',
                                            'Box'             => 'badge-info',
                                            'Realisasi Kirim' => 'badge-secondary',
                                            'Color Combine'   => 'badge-light',
                                            'Form MC'         => 'badge-dark',
                                            'Form Permintaan' => 'badge-primary',
                                            'Plan Produksi'   => 'badge-warning',
                                            'Profile'         => 'badge-secondary',
                                        ];
                                        $tipeColor = isset($tipeColorMap[$track->tipe]) ? $tipeColorMap[$track->tipe] : 'badge-secondary';

                                        $changedKeys = [];
                                        if ($beforeDecoded && is_array($beforeDecoded) && $afterDecoded && is_array($afterDecoded)) {
                                            foreach ($afterDecoded as $k => $v) {
                                                $oldVal = isset($beforeDecoded[$k]) ? $beforeDecoded[$k] : null;
                                                if ((string)$oldVal !== (string)$v) {
                                                    $changedKeys[] = $k;
                                                }
                                            }
                                        }
                                    @endphp
                                    <tr>
                                        <td class="text-muted text-center">
                                            {{ $trackings->firstItem() + $i }}
                                        </td>
                                        <td>
                                            <span class="badge badge-primary">{{ $track->user }}</span>
                                        </td>
                                        <td style="white-space: nowrap;">
                                            <span class="badge {{ $tipeColor }}">{{ $track->tipe ?? '-' }}</span>
                                        </td>
                                        <td>{{ $track->event }}</td>
                                        <td style="font-size: 0.82em;">
                                            @if($beforeDecoded && is_array($beforeDecoded) && count($changedKeys) > 0)
                                                @foreach($changedKeys as $key)
                                                    @if(isset($beforeDecoded[$key]))
                                                        <div><span class="text-muted">{{ $key }}:</span> {{ $beforeDecoded[$key] ?? '-' }}</div>
                                                    @endif
                                                @endforeach
                                            @elseif(!$beforeDecoded || !is_array($beforeDecoded))
                                                <span class="text-muted">{{ $track->before ?? '-' }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td style="font-size: 0.82em;">
                                            @if($afterDecoded && is_array($afterDecoded) && count($changedKeys) > 0)
                                                @foreach($changedKeys as $key)
                                                    @if(isset($afterDecoded[$key]))
                                                        <div class="font-weight-bold text-success">
                                                            <span class="text-muted">{{ $key }}:</span> {{ $afterDecoded[$key] ?? '-' }}
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @elseif(!$afterDecoded || !is_array($afterDecoded))
                                                <span class="text-muted">{{ $track->after ?? '-' }}</span>
                                            @else
                                                <span class="text-success">-</span>
                                            @endif
                                        </td>
                                        <td class="text-muted" style="white-space: nowrap; font-size: 0.85em;">
                                            {{ \Carbon\Carbon::parse($track->created_at)->format('d/m/Y H:i') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                            Tidak ada data tracking.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <div class="float-left">
                        Menampilkan {{ $trackings->firstItem() ?? 0 }} - {{ $trackings->lastItem() ?? 0 }} dari {{ $trackings->total() }} data
                    </div>
                    <div class="float-right">
                        {{ $trackings->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    $(function () {
        $('.select2').select2({
            theme: 'bootstrap4'
        });
    });
</script>
@endpush
