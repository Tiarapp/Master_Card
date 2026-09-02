@extends('admin.templates.partials.default')

@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><h1>Material Requirement & Booking Roll</h1></div></section>
    <section class="content"><div class="container-fluid">
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
        <div class="card card-primary">
            <div class="card-header"><h3 class="card-title">Planning {{ $detail->corrMaster->kode_corr ?? '-' }}</h3></div>
            <div class="card-body">
                @foreach($detail->materialRequirements as $requirement)
                    <div class="border rounded p-3 mb-4 requirement" data-requirement="{{ $requirement->id }}">
                        <div class="row align-items-center mb-2">
                            <div class="col-md-5"><strong>Layer {{ $requirement->layer_no ?? '-' }}: {{ $requirement->jenis }}</strong> / {{ $requirement->gsm }} GSM / {{ $requirement->lebar_roll }} mm</div>
                            <div class="col-md-7 text-md-right">Required: <b>{{ number_format($requirement->qty_required, 3) }}</b> kg &nbsp; Booked: <b>{{ number_format($requirement->qty_booked, 3) }}</b> kg &nbsp; Remaining: <b>{{ number_format($requirement->remaining, 3) }}</b> kg</div>
                        </div>
                        <form method="POST" action="{{ route('admin.corr.material.book', $requirement) }}" class="booking-form">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered roll-table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Select</th>
                                            <th>Kode Internal</th>
                                            <th>Kode Roll</th>
                                            <th>Masuk</th>
                                            <th>GSM</th>
                                            <th>Lebar</th>
                                            <th>Stock</th>
                                            <th>Available</th>
                                            <th>Qty Booking</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="9" class="text-center">Klik LOAD ROLLS</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-load">
                                <i class="fas fa-search load-icon"></i>
                                <span class="load-label">LOAD ROLLS</span>
                            </button>
                            <button type="button" class="btn btn-outline-info btn-auto"><i class="fas fa-magic"></i> AUTO SELECT FIFO</button>
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> CONFIRM BOOKING</button>
                        </form>
                        @if($requirement->bookings->where('status', 'BOOKED')->count())
                            <h5 class="mt-4">BOOKED ROLLS</h5>
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Roll</th>
                                        <th>Qty</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                            @foreach($requirement->bookings as $booking)
                                @if($booking->status === 'BOOKED')
                                <tr>
                                    <td>{{ $booking->inventory->kode_internal ?? '-' }}</td>
                                    <td>{{ number_format($booking->qty_booked, 3) }} kg</td>
                                    <td>{{ $booking->status }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.corr.material.release', $booking) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-sm btn-warning" onclick="return confirm('Release booking ini?')">
                                                <i class="fas fa-undo"></i> RELEASE
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                @endforeach
                @if($detail->materialRequirements->isEmpty())<div class="alert alert-info">Belum ada material requirement untuk detail ini.</div>@endif
            </div>
        </div>
    </div></section>
</div>
@endsection

@section('javascripts')
<script>
$(function () {
    $('.requirement').each(function () {
        const box = $(this), id = box.data('requirement'), table = box.find('.roll-table tbody');
        function render(rows, selected) {
            table.empty();
            if (!rows.length) { table.append('<tr><td colspan="9" class="text-center">Tidak ada roll tersedia.</td></tr>'); return; }
            rows.forEach(function (roll) {
                const choice = selected && selected[roll.id] ? selected[roll.id] : '';
                table.append('\
                <tr>\
                    <td><input type="checkbox" class="roll-check"></td>\
                    <td>'+roll.kode_internal+'</td>\
                    <td>'+roll.kode_roll+'</td>\
                    <td>'+ (roll.tanggal_masuk || '-') +'</td>\
                    <td>'+roll.gsm+'</td>\
                    <td>'+roll.lebar+'</td>\
                    <td>'+roll.berat+'</td>\
                    <td>'+roll.available_qty+'</td>\
                    <td><input type="number" step="0.001" min="0.001" max="'+roll.available_qty+'" class="form-control form-control-sm qty" name="selections['+roll.id+'][qty_booked]" data-id="'+roll.id+'" value="'+choice+'" disabled><input type="hidden" name="selections['+roll.id+'][inventory_id]" value="'+roll.id+'" disabled></td>\
                </tr>');
            });
            table.find('.roll-check').on('change', function () { $(this).closest('tr').find('.qty, input[type=hidden]').prop('disabled', !this.checked); });
        }
        box.find('.btn-load').on('click', function () {
            const button = $(this);
            button.prop('disabled', true).find('.load-icon').removeClass('fa-search').addClass('fa-spinner fa-spin');
            button.find('.load-label').text('LOADING...');

            $.get('{{ url('/admin/plan/material-requirement') }}/'+id+'/rolls')
                .done(function (data) {
                    box.data('rolls', data);
                    render(data);
                })
                .fail(function () {
                    table.html('<tr><td colspan="9" class="text-center text-danger">Gagal memuat roll. Silakan coba lagi.</td></tr>');
                })
                .always(function () {
                    button.prop('disabled', false).find('.load-icon').removeClass('fa-spinner fa-spin').addClass('fa-search');
                    button.find('.load-label').text('LOAD ROLLS');
                });
        });
        box.find('.btn-auto').on('click', function () {
            $.get('{{ url('/admin/plan/material-requirement') }}/'+id+'/auto-select', function (data) {
                const selected = {};
                data.selected.forEach(function (item) { selected[item.inventory_id] = item.qty_booked; });
                render(box.data('rolls') || [], selected);
                table.find('.qty').each(function () {
                    if ($(this).val()) {
                        $(this).prop('disabled', false).closest('tr').find('.roll-check').prop('checked', true);
                    }
                });
            });
        });
    });
});
</script>
@endsection
