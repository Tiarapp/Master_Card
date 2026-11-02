@foreach ($data as $item)
    @php
        $kg = $item->jumlahOrder * ($item->mc->gramSheetBoxKontrak2 ?? 0);
    @endphp
    <tr class="plan-row" draggable="true"
        data-id="{{ $item->id }}"
        data-sort="{{ $item->tglKirimDt }}|{{ $item->NoOPI }}"
        data-qty="{{ $item->jumlahOrder }}"
        data-kg="{{ $kg }}"
        data-customer="{{ $item->kontrakm->customer_name ?? '' }}"
        data-kode="{{ $item->mc->kodeBarang ?? '' }}">
        <td class="text-center"><i class="fas fa-grip-vertical drag-handle"></i></td>
        <td class="fw-bold col-num row-number"></td>
        <td>
            <span class="badge bg-info">{{ $item->tglKirimDt ? date('d M Y', strtotime($item->tglKirimDt)) : '-' }}</span>
        </td>
        <td>{{ $item->kontrakm->customer_name ?? '-' }}</td>
        <td>{{ $item->kontrakm->poCustomer ?? '-' }}</td>
        <td>{{ $item->kontrakm->kode ?? '-' }}</td>
        <td class="text-primary fw-bold">{{ $item->NoOPI }}</td>
        <td class="fw-bold text-success">{{ $item->mc->kodeBarang ?? '-' }}</td>
        <td>{{ $item->mc->namaBarang ?? '-' }}</td>
        <td class="text-end">
            <span class="badge bg-primary">{{ number_format($item->jumlahOrder) }} pcs</span>
        </td>
        <td class="text-end">
            <span class="badge bg-secondary">{{ number_format($item->mc->gramSheetBoxKontrak2 ?? 0, 2) }} kg/pcs</span>
        </td>
        <td class="text-end">
            <span class="fw-bold text-warning">{{ number_format($kg / 1000, 3) }} ton</span>
            <br><small class="text-muted">{{ number_format($kg, 2) }} kg</small>
        </td>
        <td>
            <small>{{ \Illuminate\Support\Str::limit($item->dt->keterangan ?? '-', 500) }}</small>
        </td>
        <td class="text-center text-nowrap">
            <button type="button" class="btn btn-sm btn-outline-success btn-add" title="Masukkan ke draft"><i class="fas fa-plus"></i></button>
            <button type="button" class="btn btn-sm btn-outline-danger btn-remove" title="Keluarkan dari draft"><i class="fas fa-times"></i></button>
        </td>
    </tr>
@endforeach
