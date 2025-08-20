<div class="table-responsive table-scrollable">
    <table class="table table-row-bordered">
        <thead>
            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                <th class="min-w-100px">{{ __('MC') }}</th>
                <th class="min-w-150px">{{ __('Nama Barang') }}</th>
                <th class="min-w-125px">{{ __('Tipe Box') }}</th>
                <th class="min-w-125px">{{ __('Flute') }}</th>
                <th class="min-w-125px">{{ __('Kualitas') }}</th>
                <th class="min-w-100px">{{ __('Gram') }}</th>
                <th class="min-w-100px">{{ __('Warna') }}</th>
                <th class="min-w-100px">{{ __('Action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mastercards as $mastercard)
                <tr class="modal-mastercard-list fw-semibold">
                    <td class="fw-bold text-gray-800">{{ $mastercard->kode }}</td>
                    <td class="fw-bold">{{ $mastercard->namaBarang??'-' }}</td>
                    <td class="fw-bold text-gray-600">{{ $mastercard->tipeBox??'-' }}</td>
                    <td class="text-gray-800">{{ $mastercard->flute??'-' }}</td>
                    <td class="text-gray-600">{{ $mastercard->substancekontrak->kode??'-' }}</td>
                    <td class="text-gray-800">{{ $mastercard->gramSheetBoxKontrak2??'-' }}</td>
                    <td class="text-gray-600">{{ $mastercard->colorcombine->kode??'-' }}</td>
                    <td>
                        <input type="hidden" class="form-control mastercard_id" value="{{ $mastercard->id }}">
                        <button class="btn btn-primary btn-insert-mastercard" type="button">Add</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="col-md-12 text-center clearfix">
    {{ $mastercards->appends(request()->query())->links('pagination::bootstrap-4') }}
</div>
