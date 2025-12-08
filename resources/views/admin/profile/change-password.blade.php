@extends('admin.templates.partials.default')

@section('title', 'Ubah Password')

@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Ubah Password</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('profile.index') }}">Profile</a></li>
            <li class="breadcrumb-item active">Ubah Password</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-key mr-2"></i>
                            Ubah Password
                        </h3>
                    </div>

                    <form action="{{ route('profile.update-password') }}" method="POST" id="changePasswordForm">
                        @csrf
                        <div class="card-body">
                            
                            {{-- Success Message --}}
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <i class="icon fas fa-check"></i>
                                    {{ session('success') }}
                                </div>
                            @endif

                            {{-- Error Messages --}}
                            @if($errors->any())
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <i class="icon fas fa-ban"></i>
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {{-- Password Requirements Info --}}
                            <div class="alert alert-info">
                                <h5><i class="icon fas fa-info"></i> Persyaratan Password:</h5>
                                <ul class="mb-0" id="passwordRequirements">
                                    <li>Minimal 8 karakter</li>
                                    <li>Mengandung huruf besar dan kecil</li>
                                    <li>Mengandung angka</li>
                                    <li>Mengandung simbol (!@#$%^&*)</li>
                                    <li>Tidak menggunakan password yang mudah ditebak</li>
                                </ul>
                            </div>

                            {{-- Current Password --}}
                            <div class="form-group">
                                <label for="current_password">Password Saat Ini <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control @error('current_password') is-invalid @enderror" 
                                           id="current_password" 
                                           name="current_password" 
                                           placeholder="Masukkan password saat ini"
                                           required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="toggleCurrentPassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('current_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- New Password --}}
                            <div class="form-group">
                                <label for="new_password">Password Baru <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control @error('new_password') is-invalid @enderror" 
                                           id="new_password" 
                                           name="new_password" 
                                           placeholder="Masukkan password baru"
                                           required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('new_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                {{-- Password Strength Indicator --}}
                                <div class="mt-2">
                                    <div class="progress" style="height: 5px;">
                                        <div class="progress-bar" id="passwordStrength" role="progressbar" style="width: 0%"></div>
                                    </div>
                                    <small class="text-muted" id="passwordStrengthText">Kekuatan password akan ditampilkan di sini</small>
                                </div>
                            </div>

                            {{-- Confirm New Password --}}
                            <div class="form-group">
                                <label for="new_password_confirmation">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control @error('new_password_confirmation') is-invalid @enderror" 
                                           id="new_password_confirmation" 
                                           name="new_password_confirmation" 
                                           placeholder="Ulangi password baru"
                                           required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('new_password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                {{-- Password Match Indicator --}}
                                <div class="mt-2">
                                    <small class="text-muted" id="passwordMatchText"></small>
                                </div>
                            </div>

                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                        <i class="fas fa-save mr-2"></i>
                                        Ubah Password
                                    </button>
                                    <button type="button" class="btn btn-secondary ml-2" onclick="window.location='{{ route('profile.index') }}'">
                                        <i class="fas fa-times mr-2"></i>
                                        Batal
                                    </button>
                                </div>
                                <div class="col-md-6 text-right">
                                    <small class="text-muted">
                                        <i class="fas fa-shield-alt mr-1"></i>
                                        Password akan dienkripsi dengan aman
                                    </small>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </section>
</div>
@endsection

@section('javascripts')
<script>
$(document).ready(function() {
    // Toggle password visibility
    $('#toggleCurrentPassword').on('click', function(e) {
        e.preventDefault();
        togglePasswordVisibility('current_password', this);
    });

    $('#toggleNewPassword').on('click', function(e) {
        e.preventDefault();
        togglePasswordVisibility('new_password', this);
    });

    $('#toggleConfirmPassword').on('click', function(e) {
        e.preventDefault();
        togglePasswordVisibility('new_password_confirmation', this);
    });

    // Password strength monitoring
    $('#new_password').on('input', function() {
        checkPasswordStrength($(this).val());
    });

    // Password match monitoring
    $('#new_password_confirmation').on('input', function() {
        checkPasswordMatch();
    });

    // Form validation
    $('#changePasswordForm').on('submit', function(e) {
        const currentPassword = $('#current_password').val();
        const newPassword = $('#new_password').val();
        const confirmPassword = $('#new_password_confirmation').val();
        
        let isValid = true;
        
        $('.form-control').removeClass('is-invalid');

        if (currentPassword === '') {
            $('#current_password').addClass('is-invalid');
            isValid = false;
        }

        if (newPassword === '' || newPassword.length < 8) {
            $('#new_password').addClass('is-invalid');
            isValid = false;
        }

        if (confirmPassword === '' || newPassword !== confirmPassword) {
            $('#new_password_confirmation').addClass('is-invalid');
            isValid = false;
        }

        if (currentPassword === newPassword && newPassword !== '') {
            $('#new_password').addClass('is-invalid');
            alert('Password baru harus berbeda dari password saat ini');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
            return false;
        }

        $('#submitBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...');
    });

    function togglePasswordVisibility(inputId, button) {
        const input = document.getElementById(inputId);
        const icon = button.querySelector('i');
        
        if (!input || !icon) return;
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'fas fa-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'fas fa-eye';
        }
    }

    function checkPasswordStrength(password) {
        let strength = 0;
        let text = '';
        let colorClass = '';

        if (password.length === 0) {
            text = 'Kekuatan password akan ditampilkan di sini';
            strength = 0;
            colorClass = '';
        } else {
            if (password.length >= 8) strength += 20;
            if (/[a-z]/.test(password)) strength += 20;
            if (/[A-Z]/.test(password)) strength += 20;
            if (/\d/.test(password)) strength += 20;
            if (/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) strength += 20;

            if (strength < 40) {
                text = 'Kekuatan password: Lemah';
                colorClass = 'bg-danger';
            } else if (strength < 60) {
                text = 'Kekuatan password: Sedang';
                colorClass = 'bg-warning';
            } else if (strength < 80) {
                text = 'Kekuatan password: Kuat';
                colorClass = 'bg-info';
            } else {
                text = 'Kekuatan password: Sangat Kuat';
                colorClass = 'bg-success';
            }
        }

        const $bar = $('#passwordStrength');
        const $text = $('#passwordStrengthText');
        
        if ($bar.length && $text.length) {
            $bar.css('width', strength + '%')
                .removeClass('bg-danger bg-warning bg-info bg-success')
                .addClass(colorClass);
            $text.text(text);
        }
    }

    function checkPasswordMatch() {
        const newPassword = $('#new_password').val();
        const confirmPassword = $('#new_password_confirmation').val();
        const $matchText = $('#passwordMatchText');

        if ($matchText.length === 0) return;

        if (confirmPassword === '') {
            $matchText.text('').removeClass('text-success text-danger');
        } else if (newPassword === confirmPassword) {
            $matchText.text('✓ Password cocok').removeClass('text-danger').addClass('text-success');
        } else {
            $matchText.text('✗ Password tidak cocok').removeClass('text-success').addClass('text-danger');
        }
    }
});
</script>
@endsection

@push('styles')
<style>
.progress {
    background-color: #e9ecef;
    height: 8px !important;
    border-radius: 4px;
}

.progress-bar {
    transition: width 0.3s ease;
    border-radius: 4px;
}

.input-group-append .btn {
    border-left: 0;
    z-index: 3;
}

.input-group-append .btn:hover {
    background-color: #e9ecef;
}

.alert ul {
    padding-left: 20px;
}

.card-footer .text-muted {
    font-size: 0.85em;
}

#passwordRequirements li {
    margin-bottom: 5px;
}

.form-control.is-invalid {
    border-color: #dc3545 !important;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

.text-success {
    color: #28a745 !important;
    font-weight: 500;
}

.text-danger {
    color: #dc3545 !important;
    font-weight: 500;
}

.text-muted {
    color: #6c757d !important;
}

/* Password strength indicator improvements */
.bg-danger {
    background-color: #dc3545 !important;
}

.bg-warning {
    background-color: #ffc107 !important;
}

.bg-info {
    background-color: #17a2b8 !important;
}

.bg-success {
    background-color: #28a745 !important;
}

/* Toggle button styling */
.input-group-append .btn-outline-secondary {
    border-color: #ced4da;
    color: #6c757d;
}

.input-group-append .btn-outline-secondary:hover {
    background-color: #e9ecef;
    border-color: #adb5bd;
    color: #495057;
}

.input-group-append .btn-outline-secondary:focus {
    box-shadow: 0 0 0 0.2rem rgba(108, 117, 125, 0.25);
}

/* Form spacing */
.form-group {
    margin-bottom: 1.5rem;
}

/* Password match indicator */
#passwordMatchText {
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

/* Progress text styling */
#passwordStrengthText {
    font-size: 0.875rem;
    margin-top: 0.25rem;
    min-height: 1.2rem;
}

/* Alert styling improvements */
.alert-info {
    border-left: 4px solid #17a2b8;
}

.alert-success {
    border-left: 4px solid #28a745;
}

.alert-danger {
    border-left: 4px solid #dc3545;
}
</style>
@endpush