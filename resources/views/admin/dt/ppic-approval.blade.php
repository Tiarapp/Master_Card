@extends('admin.templates.partials.default')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Approval Perubahan DT - PPIC</h1>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            @foreach (['success', 'error'] as $type)
                @if (session($type))
                    <div class="alert alert-{{ $type === 'error' ? 'danger' : 'success' }}" role="alert">{{ session($type) }}</div>
                @endif
            @endforeach
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif
            <div class="row mb-3 justify-content-end">
                <div class="col-md-6">
                    <form method="GET" action="{{ route('ppic.dt.approval') }}" class="d-flex">
                        <input type="text" name="search" class="form-control" value="{{ $search }}"
                               placeholder="Cari kode kontrak, ID kontrak, atau nomor OPI...">
                        <button type="submit" class="btn btn-outline-secondary ml-2" aria-label="Cari"><i class="fas fa-search"></i></button>
                        @if ($search !== null && $search !== '')
                            <a href="{{ route('ppic.dt.approval') }}" class="btn btn-outline-danger ml-2" aria-label="Hapus pencarian"><i class="fas fa-times"></i></a>
                        @endif
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">OPI menunggu approval PPIC</h3>
                    <div class="card-tools"><span class="badge badge-info">{{ $dt->total() }} Total Records</span></div>
                </div>
                <div class="card-body p-0">
                    @if ($dt->count())
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No.</th><th>Kontrak</th><th>OPI</th><th>Delivery</th>
                                        <th>Qty Kirim</th><th>DT Perubahan</th><th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dt as $data)
                                        @php($deliveryTime = $data->dt)
                                        <tr>
                                            <td>{{ $dt->firstItem() + $loop->index }}</td>
                                            <td>{{ $deliveryTime->kodeKontrak ?? $data->kontrakm->kode ?? '-' }}</td>
                                            <td>{{ $data->NoOPI ?? $data->nama ?? '-' }}</td>
                                            <td>{{ $deliveryTime->tglKirimDt ?? '-' }}</td>
                                            <td>{{ $deliveryTime->pcsDt ?? '-' }}</td>
                                            <td>{{ $deliveryTime->dt_perubahan ?? '-' }}</td>
                                            <td class="text-center">
                                                @if ($deliveryTime && $deliveryTime->dt_perubahan !== null && $deliveryTime->approve_ppic == 0)
                                                <form method="POST" action="{{ route('ppic.dt.approve', $data->id) }}">
                                                    @csrf
                                                    <input type="hidden" name="dt_perubahan" value="{{ $deliveryTime->dt_perubahan }}">
                                                    <input type="hidden" name="updated_at" value="{{ $deliveryTime->getRawOriginal('updated_at') }}">
                                                    <input type="hidden" name="pcsDt" value="{{ $deliveryTime->pcsDt }}">
                                                    <button type="submit" class="btn btn-sm btn-success">Approve PPIC</button>
                                                </form>
                                                @else
                                                    <span class="text-muted">Data sudah berubah, muat ulang halaman.</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Tidak ada OPI yang menunggu approval PPIC</h5>
                            @if ($search !== null && $search !== '')
                                <p class="text-muted">untuk pencarian: "{{ $search }}"</p>
                                <a href="{{ route('ppic.dt.approval') }}" class="btn btn-primary">Lihat Semua Data</a>
                            @endif
                        </div>
                    @endif
                </div>
                @if ($dt->hasPages() || $dt->count())
                    <div class="card-footer">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                @if ($dt->count())
                                    <p class="text-muted mb-0">Menampilkan {{ $dt->firstItem() }} - {{ $dt->lastItem() }} dari {{ $dt->total() }} hasil</p>
                                @endif
                            </div>
                            <div class="col-md-6">{{ $dt->links() }}</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection
