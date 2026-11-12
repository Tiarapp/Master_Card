<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Approval - {{ $approval->original_name }}</title>
    <style>
        body { font-family: sans-serif; margin: 1rem; }
        img { display: block; max-width: 100%; max-height: 85vh; margin: 1rem auto; }
        iframe { width: 100%; height: 85vh; border: 0; }
        @media print {
            .actions { display: none; }
            img { max-height: none; }
        }
    </style>
</head>
<body>
    <div class="actions">
        <strong>{{ $approval->original_name }}</strong>
        @if ($approval->mime_type === 'application/pdf')
            <p>Untuk mencetak PDF, gunakan tombol cetak pada penampil PDF browser.
                <a href="{{ route('mastercard.approvals.file', [$mastercard->id, $approval->id]) }}" target="_blank" rel="noopener">Buka PDF di tab baru</a>
            </p>
        @else
            <button type="button" onclick="window.print()">Cetak</button>
        @endif
    </div>
    @if ($approval->mime_type === 'application/pdf')
        <iframe src="{{ route('mastercard.approvals.file', [$mastercard->id, $approval->id]) }}" title="File approval PDF"></iframe>
    @else
        <img src="{{ route('mastercard.approvals.file', [$mastercard->id, $approval->id]) }}" alt="{{ $approval->original_name }}">
    @endif
</body>
</html>
