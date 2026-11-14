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
                                        <th>No.</th>
                                        <th>Customer</th>
                                        <th>OPI</th>
                                        <th>Nama Barang</th>
                                        <th>Delivery</th>
                                        <th>Qty Kirim</th>
                                        <th>DT Perubahan</th>
                                        <th>Alasan Perubahan</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dt as $data)
                                        @php($deliveryTime = $data->dt)
                                        <tr>
                                            <td>{{ $dt->firstItem() + $loop->index }}</td>
                                            <td>{{ $data->kontrakm->customer_name ?? '-' }}</td>
                                            <td>{{ $data->NoOPI ?? $data->nama ?? '-' }}</td>
                                            <td>{{ $data->mc->namaBarang ?? '-' }}</td>
                                            <td>{{ $deliveryTime->tglKirimDt ?? '-' }}</td>
                                            <td>{{ $deliveryTime->pcsDt ?? '-' }}</td>
                                            <td>{{ $deliveryTime->dt_perubahan ?? '-' }}</td>
                                            <td>
                                                @if ($deliveryTime && $deliveryTime->keterangan)
                                                    <div class="text-danger"><strong>Alasan Perubahan:</strong> {{ $deliveryTime->keterangan }}</div>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($deliveryTime && $deliveryTime->dt_perubahan !== null && $deliveryTime->approve_ppic == 0)
                                                <form method="POST" action="{{ route('ppic.dt.approve', $data->id) }}">
                                                    @csrf
                                                    <input type="hidden" name="dt_perubahan" value="{{ $deliveryTime->dt_perubahan }}">
                                                    <input type="hidden" name="updated_at" value="{{ $deliveryTime->getRawOriginal('updated_at') }}">
                                                    <input type="hidden" name="pcsDt" value="{{ $deliveryTime->pcsDt }}">
                                                    <input type="hidden" name="keterangan" value="{{ $deliveryTime->keterangan }}">
                                                    <button type="submit" class="btn btn-sm btn-success">Approve PPIC</button>
                                                </form>
                                                <button type="button" class="btn btn-sm btn-danger mt-1"
                                                        data-toggle="modal" data-target="#reject-dt-modal"
                                                        data-id="{{ $data->id }}"
                                                        data-url="{{ route('ppic.dt.reject', $data->id) }}"
                                                        data-opi="{{ $data->NoOPI ?? $data->nama }}"
                                                        data-perubahan="{{ $deliveryTime->dt_perubahan }}"
                                                        data-updated="{{ $deliveryTime->getRawOriginal('updated_at') }}"
                                                        data-qty="{{ $deliveryTime->pcsDt }}">Reject PPIC</button>
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
<div class="modal fade" id="reject-dt-modal" tabindex="-1" role="dialog" aria-labelledby="reject-dt-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" id="reject-dt-form">
                @csrf
                <input type="hidden" name="reject_opi_id" id="reject-dt-id">
                <input type="hidden" name="dt_perubahan" id="reject-dt-perubahan">
                <input type="hidden" name="updated_at" id="reject-dt-updated">
                <input type="hidden" name="pcsDt" id="reject-dt-qty">
                <div class="modal-header">
                    <h5 class="modal-title" id="reject-dt-title">Tolak Perubahan DT</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>OPI: <strong id="reject-dt-opi"></strong></p>
                    <p>Tanggal perubahan akan dibatalkan dan pengajuan dapat diperbaiki.</p>
                    <div class="form-group">
                        <label for="reject-dt-reason">Alasan penolakan</label>
                        <textarea class="form-control" name="alasan_reject" id="reject-dt-reason" rows="4" maxlength="2000" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak Perubahan DT</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('javascripts')
<script>
    $(function () {
        var oldId = @json(old('reject_opi_id'));
        var oldReason = @json(old('alasan_reject'));
        $('#reject-dt-modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('#reject-dt-form').attr('action', button.attr('data-url'));
            modal.find('#reject-dt-id').val(button.attr('data-id'));
            modal.find('#reject-dt-opi').text(button.attr('data-opi'));
            modal.find('#reject-dt-perubahan').val(button.attr('data-perubahan'));
            modal.find('#reject-dt-updated').val(button.attr('data-updated'));
            modal.find('#reject-dt-qty').val(button.attr('data-qty'));
            modal.find('#reject-dt-reason').val(String(oldId) === button.attr('data-id') ? oldReason : '');
            oldId = null;
        });
        if (oldId) {
            $('#reject-dt-modal').parent().find('button[data-target="#reject-dt-modal"]').filter(function () {
                return $(this).attr('data-id') === String(oldId);
            }).first().trigger('click');
        }
    });
</script>
@endsection
