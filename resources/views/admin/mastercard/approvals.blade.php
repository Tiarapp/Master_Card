@extends('admin.templates.partials.default')

@section('content')
<div class="content-wrapper">
    <section class="content pt-3">
        <div class="container-fluid">
            <h1>File Approval {{ $mastercard->kode }} {{ $mastercard->revisi }}</h1>
            <a href="{{ route('mastercard.index_new') }}" class="btn btn-secondary mb-3">Kembali</a>
            @if ($mastercard->approvals->isEmpty())
                <p>Belum ada file approval untuk Mastercard ini.</p>
            @else
                <ul class="list-group">
                    @foreach ($mastercard->approvals as $approval)
                        <li class="list-group-item">
                            {{ $approval->original_name }}
                            <a class="btn btn-primary btn-sm ml-2" href="{{ route('mastercard.approvals.show', [$mastercard->id, $approval->id]) }}" target="_blank" rel="noopener">Buka / Cetak</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </section>
</div>
@endsection
