<div class="table-responsive table-scrollable">
    <table class="table align-middle table-row-dashed table-striped table-row-bordered gy-5 gs-7 fs-6">
        <thead>
            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                <th class="min-w-125px">Kontrak</th>
                <th class="min-w-125px">Customer</th>
                <th class="min-w-125px">Tanggal</th>
                <th class="min-w-100px">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contracts as $contract)
                <tr class="modal-kontrak-list">
                    <td class="fw-bold text-gray-800">{{ $contract->kode }}</td>
                    <td class="fw-semibold text-gray-800">{{ $contract->customer_name }}</td>
                    <td class="text-gray-600">{{ $contract->tglKontrak }}</td>
                    <td>
                        <div class="d-flex">
                            <input type="hidden" class="form-control contract_id" value="{{ $contract->id }}">
                            <button class="btn btn-primary btn-insert-contract" type="button">Add</button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="col-md-12 text-center clearfix">
    {{ $contracts->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
</div>
