<div class="modal fade" id="historyModal{{ $mastercard->id }}" tabindex="-1" role="dialog" aria-labelledby="historyModalLabel{{ $mastercard->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="historyModalLabel{{ $mastercard->id }}">History Revisi Mastercard</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @php
                    $historyItems = $data->history ?? [];
                @endphp

                @if(count($historyItems))
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Revisi</th>
                                <th>Nama Barang</th>
                                <th>Parent ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($historyItems as $history)
                                <tr>
                                    <td>{{ $history->id }}</td>
                                    <td>{{ $history->kode }}</td>
                                    <td>{{ $history->revisi }}</td>
                                    <td>{{ $history->namaBarang }}</td>
                                    <td>{{ $history->parent_id }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-info mb-0">Tidak ada data history.</div>
                @endif
            </div>
        </div>
    </div>
