<div class="row mt-3">
    <div class="col-md-2">
        <label for="approval_files">File Approval</label>
    </div>
    <div class="col-md-8">
        <input type="file" class="form-control-file" name="approval_files[]" id="approval_files"
               accept=".pdf,.jpg,.jpeg,application/pdf,image/jpeg" multiple>
        <small class="form-text text-muted">PDF atau JPEG/JPG; maksimal 5 MB per file dan 10 file setiap penyimpanan.</small>
        @if (isset($approvals) && $approvals->count())
            <p class="mt-2 mb-1">{{ !empty($copyApprovals) ? 'File yang akan disalin ke revisi baru:' : 'File yang sudah tersimpan:' }}</p>
            <ul>
                @foreach ($approvals as $approval)
                    <li>
                        {{ $approval->original_name }}
                        <a href="{{ route('mastercard.approvals.show', [$mc->id, $approval->id]) }}" target="_blank" rel="noopener">Buka / Cetak</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
