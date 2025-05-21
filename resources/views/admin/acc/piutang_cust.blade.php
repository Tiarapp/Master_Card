@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Detail Piutang Customer</h2>
    <div class="card mb-4">
        <div class="card-header">
            <strong>Informasi Customer</strong>
        </div>
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $customer->nama }}</p>
            <p><strong>Kode Customer:</strong> {{ $customer->kode }}</p>
            <p><strong>Alamat:</strong> {{ $customer->alamat }}</p>
            <p><strong>No. Telepon:</strong> {{ $customer->telepon }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <strong>Daftar Piutang</strong>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No. Faktur</th>
                        <th>Tanggal</th>
                        <th>Jatuh Tempo</th>
                        <th>Total</th>
                        <th>Sisa Piutang</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($piutangs as $piutang)
                    <tr>
                        <td>{{ $piutang->no_faktur }}</td>
                        <td>{{ \Carbon\Carbon::parse($piutang->tanggal)->format('d-m-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($piutang->jatuh_tempo)->format('d-m-Y') }}</td>
                        <td>Rp {{ number_format($piutang->total, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($piutang->sisa_piutang, 0, ',', '.') }}</td>
                        <td>
                            @if($piutang->sisa_piutang == 0)
                                <span class="badge bg-success">Lunas</span>
                            @else
                                <span class="badge bg-warning text-dark">Belum Lunas</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data piutang.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection