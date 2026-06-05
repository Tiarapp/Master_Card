@extends('admin.templates.partials.default')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manajemen Role</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                        <li class="breadcrumb-item active">Roles</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ session('error') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Daftar Role</h3>
                    <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Role
                    </a>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Role</th>
                                <th>Slug</th>
                                <th>Deskripsi</th>
                                <th>Permissions</th>
                                <th>Users</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($roles as $role)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $role->name }}</strong></td>
                                <td><code>{{ $role->slug }}</code></td>
                                <td>{{ $role->description ?? '-' }}</td>
                                <td>
                                    @foreach($role->permissions as $perm)
                                        <span class="badge badge-info">{{ $perm->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <span class="badge badge-secondary">{{ $role->users_count }} user</span>
                                </td>
                                <td>
                                    <a href="{{ route('roles.edit', $role) }}" class="btn btn-warning btn-xs">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('roles.destroy', $role) }}" method="POST" style="display:inline;"
                                          onsubmit="return confirm('Hapus role {{ $role->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada role. <a href="{{ route('roles.create') }}">Tambah sekarang</a></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
