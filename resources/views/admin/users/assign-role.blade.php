@extends('admin.templates.partials.default')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Assign Role: {{ $user->name }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                        <li class="breadcrumb-item active">Assign Role</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- User Info Card -->
                <div class="col-md-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Info User</h3>
                        </div>
                        <div class="card-body">
                            <dl class="row mb-0">
                                <dt class="col-sm-4">Nama</dt>
                                <dd class="col-sm-8">{{ $user->name }}</dd>

                                <dt class="col-sm-4">Email</dt>
                                <dd class="col-sm-8">{{ $user->email }}</dd>

                                <dt class="col-sm-4">Divisi</dt>
                                <dd class="col-sm-8">{{ $user->divisi->name ?? '-' }}</dd>

                                <dt class="col-sm-4">Company</dt>
                                <dd class="col-sm-8">{{ $user->company->name ?? '-' }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Role Assignment Card -->
                <div class="col-md-8">
                    <form action="{{ route('users.update-role', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Pilih Role untuk User ini</h3>
                            </div>
                            <div class="card-body">
                                @if($roles->isEmpty())
                                    <div class="alert alert-warning">
                                        Belum ada role. <a href="{{ route('roles.create') }}">Buat role dulu</a>.
                                    </div>
                                @else
                                    <p class="text-muted">User dapat memiliki lebih dari satu role.</p>
                                    @foreach($roles as $role)
                                    <div class="custom-control custom-checkbox mb-3">
                                        <input type="checkbox" class="custom-control-input"
                                               name="roles[]" id="role_{{ $role->id }}"
                                               value="{{ $role->id }}"
                                               {{ in_array($role->id, $userRoleIds) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="role_{{ $role->id }}">
                                            <strong>{{ $role->name }}</strong>
                                            @if($role->description)
                                                <small class="text-muted"> — {{ $role->description }}</small>
                                            @endif
                                            <br>
                                            @foreach($role->permissions as $perm)
                                                <span class="badge badge-light border">{{ $perm->name }}</span>
                                            @endforeach
                                        </label>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Role
                                </button>
                                <a href="{{ route('users.index') }}" class="btn btn-secondary ml-2">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
