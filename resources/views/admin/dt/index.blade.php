@extends('admin.templates.partials.default')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Delivery Time</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Delivery Time</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>{{ session('success') }}</strong>
                </div>
            @endif

            <div class="row mb-3 justify-content-end">
                <div class="col-md-6">
                    <form method="GET" action="{{ route('dt') }}" class="d-flex">
                        <input type="text" name="search" class="form-control"
                               placeholder="Cari kode kontrak, ID kontrak, atau nomor OPI..."
                               value="{{ $search }}">
                        <button type="submit" class="btn btn-outline-secondary ml-2" aria-label="Cari">
                            <i class="fas fa-search"></i>
                        </button>
                        @if($search !== null && $search !== '')
                            <a href="{{ route('dt') }}" class="btn btn-outline-danger ml-2" aria-label="Hapus pencarian">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Delivery Time - OPI Proses</h3>
                    <div class="card-tools">
                        <span class="badge badge-info">{{ $dt->total() }} Total Records</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($dt->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="dt-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No.</th>
                                        <th>Kontrak</th>
                                        <th>OPI</th>
                                        <th>Delivery</th>
                                        <th>Qty Kirim</th>
                                        <th>DT Perubahan</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dt as $data)
                                        @php($deliveryTime = $data->dt)
                                        <tr>
                                            <td>{{ $dt->firstItem() + $loop->index }}</td>
                                            <td>{{ $deliveryTime->kodeKontrak ?? $data->kontrakm->kode ?? '-' }}</td>
                                            <td>{{ $data->NoOPI ?? $data->nama ?? '-' }}</td>
                                            <td>{{ $deliveryTime->tglKirimDt ?? '-' }}</td>
                                            <td>{{ $deliveryTime->pcsDt ?? '-' }}</td>
                                            <td>{{ $deliveryTime->dt_perubahan ?? '-' }}</td>
                                            <td class="text-center">
                                                @if($deliveryTime)
                                                <div class="btn-group" role="group">
                                                    @if($deliveryTime->dt_perubahan !== null && $deliveryTime->approve_ppic == 0)
                                                        @if(in_array(Auth::user()->divisi_id, [2, 5]) && hasMenuAccess('ppic.dt_approval'))
                                                            <a href="{{ route('ppic.dt.approval', ['search' => $data->NoOPI ?? $data->nama]) }}" class="btn btn-sm btn-success">Need Approve PPIC</a>
                                                        @else
                                                            <span class="badge badge-warning align-self-center">Need Approve PPIC</span>
                                                        @endif
                                                    @endif
                                                    @if($deliveryTime->dt_perubahan === null || $deliveryTime->approve_ppic != 0)
                                                        <a href="{{ route('dt.edit', $deliveryTime->id) }}"
                                                           class="btn btn-sm btn-warning" title="Edit"
                                                           data-toggle="modal" data-target="#edit-dt-modal"
                                                           data-update-url="{{ route('dt.update', $deliveryTime->id) }}"
                                                           data-kontrak="{{ $deliveryTime->kodeKontrak }}"
                                                           data-tanggal="{{ $deliveryTime->dt_perubahan ?: $deliveryTime->tglKirimDt }}"
                                                           data-perubahan="{{ $deliveryTime->dt_perubahan }}"
                                                           data-qty="{{ $deliveryTime->pcsDt }}">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                    @endif
                                                </div>
                                                @else
                                                    <span class="text-muted">DT tidak tersedia</span>
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
                            <h5 class="text-muted">Tidak ada OPI berstatus proses ditemukan</h5>
                            @if($search !== null && $search !== '')
                                <p class="text-muted">untuk pencarian: "{{ $search }}"</p>
                                <a href="{{ route('dt') }}" class="btn btn-primary">Lihat Semua Data</a>
                            @endif
                        </div>
                    @endif
                </div>
                @if($dt->hasPages() || $dt->count() > 0)
                    <div class="card-footer">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                @if($dt->count() > 0)
                                    <p class="text-muted mb-0">
                                        Menampilkan {{ $dt->firstItem() }} - {{ $dt->lastItem() }} dari {{ $dt->total() }} hasil
                                    </p>
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

<div class="modal fade" id="edit-dt-modal" tabindex="-1" role="dialog" aria-labelledby="edit-dt-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="edit-dt-form" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="from_dt_list" value="1">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit-dt-title">Edit Delivery Time</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit-dt-kontrak">Kode Kontrak</label>
                        <input type="text" class="form-control" name="kontrak" id="edit-dt-kontrak" readonly>
                    </div>
                    <div class="form-group">
                        <label for="edit-dt-tanggal">Tanggal Kirim Saat Ini</label>
                        <input type="date" class="form-control" id="edit-dt-tanggal" readonly>
                        <small class="form-text text-muted">Gunakan DT Perubahan untuk mengubah tanggal kirim.</small>
                    </div>
                    <div class="form-group">
                        <label for="edit-dt-perubahan">DT Perubahan</label>
                        <input type="date" class="form-control" name="dt_perubahan" id="edit-dt-perubahan">
                    </div>
                    <div class="form-group">
                        <label for="edit-dt-qty">QTY</label>
                        <input type="text" class="form-control" name="pcsDt" id="edit-dt-qty">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('javascripts')
<script>
    $(function () {
        $('#edit-dt-modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('#edit-dt-form').attr('action', button.attr('data-update-url'));
            modal.find('#edit-dt-kontrak').val(button.attr('data-kontrak'));
            modal.find('#edit-dt-tanggal').val(button.attr('data-tanggal'));
            modal.find('#edit-dt-perubahan').val(button.attr('data-perubahan'));
            modal.find('#edit-dt-qty').val(button.attr('data-qty'));
        });

        $('#dt-table').DataTable({
            // dom: 'Bt',
            paging: false,
            searching: false,
            // ordering: false,
            // info: false,
            // buttons: [
            //     { extend: 'copy', text: 'Salin halaman ini', exportOptions: { columns: ':not(:last-child)' } },
            //     { extend: 'csv', text: 'CSV halaman ini', exportOptions: { columns: ':not(:last-child)' } },
            //     { extend: 'excel', text: 'Excel halaman ini', exportOptions: { columns: ':not(:last-child)' } },
            //     { extend: 'pdf', text: 'PDF halaman ini', exportOptions: { columns: ':not(:last-child)' } },
            //     'colvis',
            //     { extend: 'print', text: 'Print halaman ini', exportOptions: { columns: ':not(:last-child)' } }
            // ]
        });
    });
</script>
@endsection
