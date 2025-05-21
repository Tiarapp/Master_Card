
<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>
@extends('admin.templates.partials.default')

@section('content')
<div class="container mt-4">
    <h2>Detail Piutang Customer</h2>
    <div class="card mb-4">
        <div class="card-header">
            <strong>Informasi Customer</strong>
        </div>
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $cust->Nama }}</p>
            <p id="kode"><strong>Kode Customer:</strong> {{ $cust->Kode }}  </p>
            <p><strong>Alamat:</strong> {{ $cust->AlamatKantor }} </p>
            <p><strong>No. Telepon:</strong> {{ $cust->TelpKantor }} </p>
            <p><strong>Term of Payment:</strong> {{ $cust->WAKTUBAYAR }} </p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <strong>Daftar Piutang</strong>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="data_faktur">
                <thead>
                    <tr>
                        <th>No. Faktur</th>
                        <th>Tanggal</th>
                        <th>Jatuh Tempo</th>
                        <th>Total Bayar</th>
                        <th>Total Terima</th>
                        <th>Sisa Piutang</th>
                        {{-- <th>Status</th> --}}
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var kodeCustomer = $('#kode').text();
        console.log(kodeCustomer);
        $('#data_faktur').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('acc.piutang.cust', $cust->Kode) }}",
                type: 'GET'
            },
            columns: [
                { data: 'NoBukti', name: 'NoBukti' },
                { data: 'tanggal', name: 'tanggal' },
                { data: 'tgljt', name: 'tgljt' },
                { data: 'totalrp', name: 'totalrp' },
                { data: 'terima', name: 'terima' },
                { data: 'total', name: 'total' },
            ],
            pageLength: 50,
            order: [[1, 'desc']],
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        });
    });
</script>
@endsection