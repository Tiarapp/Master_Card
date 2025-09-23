@extends('admin.templates.partials.default')

@section('title', 'Profile Pengguna')

@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Profile Pengguna</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Profile</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle"
                                 src="{{ asset('asset/dist/img/user2-160x160.jpg') }}"
                                 alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center">{{ $user->name }}</h3>

                        <p class="text-muted text-center">{{ $user->level ?? 'User' }}</p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Email</b> <a class="float-right">{{ $user->email }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Bergabung</b> <a class="float-right">{{ $user->created_at->format('d M Y') }}</a>
                            </li>
                            @if($user->password_changed_at)
                            <li class="list-group-item">
                                <b>Password Terakhir Diubah</b> 
                                <a class="float-right">{{ \Carbon\Carbon::parse($user->password_changed_at)->format('d M Y') }}</a>
                            </li>
                            @endif
                        </ul>

                        <a href="{{ route('profile.change-password') }}" class="btn btn-primary btn-block">
                            <i class="fas fa-key mr-2"></i>
                            <b>Ubah Password</b>
                        </a>
                    </div>
                </div>

                <!-- Security Info -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Keamanan Akun</h3>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <h5><i class="icon fas fa-info"></i> Tips Keamanan:</h5>
                            <ul class="mb-0">
                                <li>Ubah password secara berkala</li>
                                <li>Gunakan password yang kuat</li>
                                <li>Jangan bagikan kredensial login</li>
                                <li>Logout setelah selesai bekerja</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#profile" data-toggle="tab">Profile</a></li>
                            <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Pengaturan</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="profile">
                                {{-- Success Message --}}
                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <i class="icon fas fa-check"></i>
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <form action="{{ route('profile.update') }}" method="POST" class="form-horizontal">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-2 col-form-label">Nama</label>
                                        <div class="col-sm-10">
                                            <input type="text" 
                                                   class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" 
                                                   name="name" 
                                                   value="{{ old('name', $user->name) }}"
                                                   placeholder="Masukkan nama lengkap">
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" 
                                                   class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" 
                                                   name="email" 
                                                   value="{{ old('email', $user->email) }}"
                                                   placeholder="Masukkan alamat email">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save mr-2"></i>
                                                Update Profile
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane" id="settings">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card card-outline card-primary">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    <i class="fas fa-key mr-2"></i>
                                                    Keamanan Password
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                <p>Jaga keamanan akun Anda dengan mengubah password secara berkala.</p>
                                                <a href="{{ route('profile.change-password') }}" class="btn btn-warning">
                                                    <i class="fas fa-key mr-2"></i>
                                                    Ubah Password
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="card card-outline card-info">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    <i class="fas fa-chart-line mr-2"></i>
                                                    Aktivitas Akun
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                <ul class="list-unstyled">
                                                    <li><strong>Terakhir Login:</strong> {{ $user->updated_at->diffForHumans() }}</li>
                                                    <li><strong>Akun Dibuat:</strong> {{ $user->created_at->format('d M Y H:i') }}</li>
                                                    @if($user->password_changed_at)
                                                    <li><strong>Password Diubah:</strong> {{ \Carbon\Carbon::parse($user->password_changed_at)->diffForHumans() }}</li>
                                                    @else
                                                    <li><strong>Password:</strong> <span class="text-warning">Belum pernah diubah</span></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="alert alert-warning">
                                            <h5><i class="icon fas fa-exclamation-triangle"></i> Peringatan!</h5>
                                            Selalu logout dari sistem setelah selesai bekerja untuk menjaga keamanan data.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </section>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Auto-hide success messages after 5 seconds
    setTimeout(function() {
        $('.alert-success').fadeOut('slow');
    }, 5000);

    // Form validation
    $('form').on('submit', function() {
        $(this).find('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...');
    });
});
</script>
@endpush

@push('styles')
<style>
.profile-user-img {
    width: 100px;
    height: 100px;
    border: 3px solid #adb5bd;
    margin: 0 auto;
    padding: 3px;
}

.card-outline.card-primary {
    border-top: 3px solid #007bff;
}

.card-outline.card-info {
    border-top: 3px solid #17a2b8;
}

.nav-pills .nav-link.active {
    background-color: #007bff;
}

.list-group-item {
    border: none;
    padding: 0.5rem 0;
}

.alert ul li {
    margin-bottom: 5px;
}

.tab-content {
    padding-top: 20px;
}
</style>
@endpush