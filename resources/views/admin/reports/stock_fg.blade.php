@extends('admin.templates.partials.default')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-boxes mr-2"></i>
                        Finish Goods Stock
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Reports</a></li>
                        <li class="breadcrumb-item active">Finish Goods</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-filter mr-1"></i>
                        Filter Periode
                    </h3>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.report.finish_goods') }}" class="form-inline">
                        <div class="form-group mr-3">
                            <label for="periode" class="mr-2">Periode:</label>
                            <input type="text" name="periode" id="periode" class="form-control" value="{{ $periode }}" placeholder="MM/YYYY" style="width: 140px;">
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">
                            <i class="fas fa-search mr-1"></i>Filter
                        </button>
                        <a href="{{ route('admin.report.finish_goods') }}" class="btn btn-secondary">
                            <i class="fas fa-refresh mr-1"></i>Reset
                        </a>
                        <a href="{{ route('admin.report.finish_goods.export', ['periode' => $periode]) }}" class="btn btn-success">
                            <i class="fas fa-file-excel mr-1"></i>Export
                        </a>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-table mr-1"></i>
                        Data Finish Goods - {{ $periode }}
                    </h3>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead class="thead-dark text-center ">
                            <tr>
                                <th rowspan="2">Kode Barang</th>
                                <th rowspan="2">Nama Barang</th>
                                <th rowspan="2">Periode</th>
                                <th colspan="2">Saldo Awal</th>
                                <th colspan="2">Masuk</th>
                                <th colspan="2">Keluar</th>
                                <th colspan="2">Adjustment Credit</th>
                                <th colspan="2">Adjustment Debet</th>
                                <th colspan="2">Saldo Akhir</th>
                            </tr>
                            <tr>
                                <th>PCS</th>
                                <th>Kg</th>
                                <th>PCS</th>
                                <th>Kg</th>
                                <th>PCS</th>
                                <th>Kg</th>
                                <th>PCS</th>
                                <th>Kg</th>
                                <th>PCS</th>
                                <th>Kg</th>
                                <th>PCS</th>
                                <th>Kg</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stockFG as $row)
                                <tr>
                                    <td>{{ $row->KodeBrg ?? '-' }}</td>
                                    <td>{{ $row->NamaBrg ?? '-' }}</td>
                                    <td>{{ $row->Periode ?? '-' }}</td>
                                    <td>{{ number_format((float)($row->SaldoAwalCrt ?? 0), 0) }}</td>
                                    <td>{{ number_format((float)($row->SaldoAwalKg ?? 0), 2) }}</td>
                                    <td>{{ number_format((float)($row->MasukCrt ?? 0), 0) }}</td>
                                    <td>{{ number_format((float)($row->MasukKg ?? 0), 2) }}</td>
                                    <td>{{ number_format((float)($row->KeluarCrt ?? 0), 0) }}</td>
                                    <td>{{ number_format((float)($row->KeluarKg ?? 0), 2) }}</td>
                                    <td>{{ number_format((float)($row->AdjCRCrt ?? 0), 0) }}</td>
                                    <td>{{ number_format((float)($row->AdjCRKg ?? 0), 2) }}</td>
                                    <td>{{ number_format((float)($row->AdjDBCrt ?? 0), 0) }}</td>
                                    <td>{{ number_format((float)($row->AdjDBKg ?? 0), 2) }}</td>
                                    <td>{{ number_format((float)($row->SaldoAkhirCrt ?? 0), 0) }}</td>
                                    <td>{{ number_format((float)($row->SaldoAkhirKg ?? 0), 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="14" class="text-center text-muted">Tidak ada data untuk periode ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                        <div class="row mt-3">
                            <div class="col-sm-12 col-md-5">
                                <div class="dataTables_info">
                                    Menampilkan {{ $stockFG->firstItem() }} sampai {{ $stockFG->lastItem() }} 
                                    dari {{ $stockFG->total() }} data
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate float-right">
                                    {{ $stockFG->appends(request()->query())->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
            </div>
        </div>
    </section>
</div>
@endsection
