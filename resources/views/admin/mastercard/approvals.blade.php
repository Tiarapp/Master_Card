@extends('admin.templates.partials.default')

@section('content')
<div class="content-wrapper">
    <section class="content pt-3">
        <div class="container-fluid">
            <h1>File Approval {{ $mastercard->kode }} {{ $mastercard->revisi }}</h1>
            <a href="{{ route('mastercard.index_new') }}" class="btn btn-secondary mb-3">Kembali</a>
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('mastercard.approvals.store', $mastercard->id) }}" method="POST" enctype="multipart/form-data" class="mb-4">
                @csrf
                <div class="form-group">
                    <label for="approval_files">Tambah File Approval</label>
                    <input type="file" class="form-control-file" name="approval_files[]" id="approval_files"
                           accept=".pdf,.jpg,.jpeg,application/pdf,image/jpeg" multiple required>
                    <small class="form-text text-muted">PDF atau JPEG/JPG; maksimal 5 MB per file dan 10 file setiap penyimpanan.</small>
                </div>
                <button type="submit" class="btn btn-primary">Simpan File Approval</button>
            </form>
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
