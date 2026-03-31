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
                    <h1 class="m-0">Kas Kecil</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">Accounting</li>
                        <li class="breadcrumb-item active">Kas Kecil</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Date Range Filter -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Filter Data</h3>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ route('acc.kaskecil') }}">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="date_start">Tanggal Mulai</label>
                                            <input type="date" class="form-control" id="date_start" name="date_start" value="{{ request('date_start') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="date_end">Tanggal Selesai</label>
                                            <input type="date" class="form-control" id="date_end" name="date_end" value="{{ request('date_end') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="coa">COA</label>
                                            <select class="form-control" id="coa" name="coa">
                                                <option value="">Pilih COA</option>
                                                @foreach($coa as $c)
                                                    <option value="{{ $c->Kode_Bukti }}" {{ request('coa') == $c->Kode_Bukti ? 'selected' : '' }}>{{ $c->kd_coa }} - {{ $c->nm_coa }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <br>
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="{{ route('acc.kaskecil') }}" class="btn btn-secondary">Reset</a>
                                            @if(!empty(request('date_start')) && !empty(request('date_end')) && !empty(request('coa')))
                                                <a href="{{ route('acc.kaskecil.export') }}?{{ http_build_query(request()->all()) }}" class="btn btn-success">
                                                    <i class="fas fa-file-excel"></i> Export Excel
                                                </a>
                                            @endif
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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data Kas Kecil</h3>
                        </div>
                        <div class="card-body">
                            @if($kasKecils->isEmpty())
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i>
                                    @if(empty(request('date_start')) || empty(request('date_end')) || empty(request('coa')))
                                        Silakan pilih tanggal mulai, tanggal selesai, dan COA untuk melihat data kas kecil.
                                    @else
                                        Tidak ada data kas kecil untuk filter yang dipilih.
                                    @endif
                                </div>
                            @else
                                <!-- Saldo Awal Info -->
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <div class="card card-info">
                                            <div class="card-header">
                                                <h5 class="card-title mb-0">
                                                    <i class="fas fa-info-circle"></i> Informasi Saldo
                                                </h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <strong>Periode:</strong> 
                                                        {{ request('date_start') ? date('d/m/Y', strtotime(request('date_start'))) : '-' }} 
                                                        s/d 
                                                        {{ request('date_end') ? date('d/m/Y', strtotime(request('date_end'))) : '-' }}
                                                    </div>
                                                    <div class="col-md-6">
                                                        <strong>Saldo Awal:</strong> 
                                                        <span class="text-primary">
                                                            Rp {{ number_format($saldoKasBulanLalu ? $saldoKasBulanLalu->SaldoAkhir : 0, 0, ',', '.') }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Nomor</th>
                                                <th>No. Invoice</th>
                                                <th>Deskripsi</th>
                                                <th>Debit</th>
                                                <th>Kredit</th>
                                                <th>Saldo</th>
                                                <th>COA</th>
                                                <th>Nama COA</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php 
                                                $saldoAwal = $saldoKasBulanLalu ? $saldoKasBulanLalu->SaldoAkhir : 0;
                                                $saldoBerjalan = $saldoAwal + $saldoSebelumHalaman;
                                            @endphp
                                            @foreach ($kasKecils as $index => $kas)
                                                @php
                                                    $saldoBerjalan -= ($kas->Nilai1);
                                                @endphp
                                                <tr>
                                                    <td>{{ $kasKecils->firstItem() + $index }}</td>
                                                    <td>{{ $kas->kasKecil && $kas->kasKecil->Tanggal ? date('d/m/Y', strtotime($kas->kasKecil->Tanggal)) : '-' }}</td>
                                                    <td>{{ $kas->Nomor ?? '-' }}</td>
                                                    <td>{{ $kas->{'Ref No'} ?? '-' }}</td>
                                                    <td>{{ $kas->Description ?? '-' }}</td>
                                                    <td class="text-right">{{ $kas->kasKecil && $kas->kasKecil->{'Jenis Transaksi'} == 'Kas Kecil Masuk' ? number_format(($kas->Nilai1 * -1) ?? 0, 0) : 0 }}</td>
                                                    <td class="text-right">{{ $kas->kasKecil && $kas->kasKecil->{'Jenis Transaksi'} == 'Kas Kecil Keluar' ? number_format($kas->Nilai1 ?? 0, 0) : 0 }}</td>
                                                    <td class="text-right">{{ number_format($saldoBerjalan, 0, ',', '.') }}</td>
                                                    <td>{{ $kas->COA ? $kas->COA : '-' }}</td>
                                                    <td>{{ $kas->coa && $kas->coa->nm_coa ? $kas->coa->nm_coa : '-' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- Pagination Info -->
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <p class="text-muted">
                                            Menampilkan {{ $kasKecils->firstItem() ?? 0 }} sampai {{ $kasKecils->lastItem() ?? 0 }} dari {{ $kasKecils->total() }} data
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-end">
                                            {{ $kasKecils->links('pagination::bootstrap-4') }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
{{-- No scripts needed for bootstrap pagination --}}
@endpush
@endsection