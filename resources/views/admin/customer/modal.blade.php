<div class="table-responsive table-scrollable">
    <table class="table table-row-bordered">
        <thead>
            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                <th class="min-w-100px">{{ __('Kode') }}</th>
                <th class="min-w-150px">{{ __('Nama Customer') }}</th>
                <th class="min-w-125px">{{ __('Alamat Kantor') }}</th>
                <th class="min-w-125px">{{ __('Telp') }}</th>
                <th class="min-w-125px">{{ __('Fax') }}</th>
                <th class="min-w-100px">{{ __('Alamat Kirim') }}</th>
                <th class="min-w-100px">{{ __('Action') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cust as $customer)
                <tr class="modal-customer-list fw-semibold">
                    <td class="fw-bold text-gray-800">{{ $customer->Kode }}</td>
                    <td class="fw-bold">{{ $customer->Nama??'-' }}</td>
                    <td class="fw-bold text-gray-600">{{ $customer->AlamatKantor??'-' }}</td>
                    <td class="text-gray-800">{{ $customer->TelpKantor??'-' }}</td>
                    <td class="text-gray-600">{{ $customer->FaxKantor??'-' }}</td>
                    <td class="text-gray-800">{{ $customer->AlamatKirim??'-' }}</td>
                    <td>
                        <input type="hidden" class="form-control customer_id" value="{{ $customer->Kode }}">
                        <button class="btn btn-primary btn-insert-customer" type="button">Add</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">
                        @if(request()->has('search'))
                            Tidak ada customer yang ditemukan dengan kata kunci "{{ request()->search }}"
                        @else
                            Tidak ada data customer
                        @endif
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="col-md-12 text-center clearfix">
    {{ $cust->appends(request()->query())->links('pagination::bootstrap-4') }}
</div>
