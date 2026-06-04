@extends('admin.templates.partials.default')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Role</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Form Role Baru</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nama Role <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}" placeholder="contoh: Marketing Manager">
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <input type="text" name="description" id="description"
                                   class="form-control @error('description') is-invalid @enderror"
                                   value="{{ old('description') }}" placeholder="Deskripsi singkat role ini">
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Permissions (Akses Menu)</label>
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <button type="button" class="btn btn-xs btn-secondary" onclick="checkAll()">Pilih Semua</button>
                                    <button type="button" class="btn btn-xs btn-secondary" onclick="uncheckAll()">Hapus Semua</button>
                                </div>
                                @foreach($permissions as $permission)
                                <div class="col-md-4 col-sm-6">
                                    <div class="custom-control custom-checkbox mb-2">
                                        <input type="checkbox" class="custom-control-input perm-check"
                                               name="permissions[]" id="perm_{{ $permission->id }}"
                                               value="{{ $permission->id }}"
                                               {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="perm_{{ $permission->id }}">
                                            <strong>{{ $permission->name }}</strong>
                                            <br><small class="text-muted">{{ $permission->description }}</small>
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Role
                        </button>
                        <a href="{{ route('roles.index') }}" class="btn btn-secondary ml-2">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
function checkAll() {
    document.querySelectorAll('.perm-check').forEach(cb => cb.checked = true);
}
function uncheckAll() {
    document.querySelectorAll('.perm-check').forEach(cb => cb.checked = false);
}
</script>
@endpush
