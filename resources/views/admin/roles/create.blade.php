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
                            <div class="mb-2">
                                <button type="button" class="btn btn-xs btn-secondary" onclick="checkAll()">Pilih Semua</button>
                                <button type="button" class="btn btn-xs btn-outline-secondary" onclick="uncheckAll()">Hapus Semua</button>
                            </div>

                            {{-- Group permissions by parent --}}
                            @php
                                $parents  = $permissions->whereNull('parent_slug')->keyBy('slug');
                                $children = $permissions->whereNotNull('parent_slug')->groupBy('parent_slug');
                                $standalone = $parents->filter(fn($p) => !isset($children[$p->slug]));
                                $grouped    = $parents->filter(fn($p) =>  isset($children[$p->slug]));
                            @endphp

                            {{-- Standalone menus (no sub-items) --}}
                            @if ($standalone->isNotEmpty())
                            <div class="card card-outline card-secondary mb-2">
                                <div class="card-header py-2">
                                    <strong>Menu Mandiri</strong>
                                    <button type="button" class="btn btn-xs btn-link float-right" onclick="toggleGroup('standalone')">Tampilkan/Sembunyikan</button>
                                </div>
                                <div id="group-standalone" class="card-body py-2">
                                    <div class="row">
                                        @foreach ($standalone as $perm)
                                        <div class="col-md-4 col-sm-6">
                                            <div class="custom-control custom-checkbox mb-2">
                                                <input type="checkbox" class="custom-control-input perm-check"
                                                       name="permissions[]" id="perm_{{ $perm->id }}"
                                                       value="{{ $perm->id }}"
                                                       {{ in_array($perm->id, old('permissions', [])) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="perm_{{ $perm->id }}">
                                                    <strong>{{ $perm->name }}</strong>
                                                    <small class="text-muted d-block">{{ $perm->slug }}</small>
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif

                            {{-- Grouped menus with children --}}
                            @foreach ($grouped as $parentPerm)
                            @php $groupSlug = $parentPerm->slug; $groupChildren = $children[$groupSlug] ?? collect(); @endphp
                            <div class="card card-outline card-primary mb-2">
                                <div class="card-header py-2">
                                    <div class="d-flex align-items-center">
                                        <div class="custom-control custom-checkbox mr-3">
                                            <input type="checkbox" class="custom-control-input perm-check parent-check"
                                                   name="permissions[]" id="perm_{{ $parentPerm->id }}"
                                                   value="{{ $parentPerm->id }}"
                                                   data-group="{{ $groupSlug }}"
                                                   {{ in_array($parentPerm->id, old('permissions', [])) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="perm_{{ $parentPerm->id }}">
                                                <strong>{{ $parentPerm->name }}</strong>
                                                <small class="text-muted ml-1">(akses semua sub-menu)</small>
                                            </label>
                                        </div>
                                        <div class="ml-auto">
                                            <button type="button" class="btn btn-xs btn-link" onclick="checkGroup('{{ $groupSlug }}')">Semua</button>
                                            <button type="button" class="btn btn-xs btn-link text-muted" onclick="uncheckGroup('{{ $groupSlug }}')">Kosong</button>
                                            <button type="button" class="btn btn-xs btn-link" onclick="toggleGroup('{{ $groupSlug }}')">&#9660;</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="group-{{ $groupSlug }}" class="card-body py-2">
                                    <div class="row">
                                        @foreach ($groupChildren as $child)
                                        <div class="col-md-4 col-sm-6">
                                            <div class="custom-control custom-checkbox mb-2">
                                                <input type="checkbox" class="custom-control-input perm-check child-check"
                                                       name="permissions[]" id="perm_{{ $child->id }}"
                                                       value="{{ $child->id }}"
                                                       data-group="{{ $groupSlug }}"
                                                       {{ in_array($child->id, old('permissions', [])) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="perm_{{ $child->id }}">
                                                    {{ $child->name }}
                                                    <small class="text-muted d-block">{{ $child->slug }}</small>
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endforeach
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
function checkGroup(group) {
    document.querySelectorAll('[data-group="' + group + '"]').forEach(cb => cb.checked = true);
}
function uncheckGroup(group) {
    document.querySelectorAll('[data-group="' + group + '"]').forEach(cb => cb.checked = false);
}
function toggleGroup(group) {
    const el = document.getElementById('group-' + group);
    if (el) el.style.display = el.style.display === 'none' ? '' : 'none';
}
</script>
@endpush
