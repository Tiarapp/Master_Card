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

            {{-- Password Compromise Warning --}}
            @if(session('password_warning'))
                <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fas fa-exclamation-triangle"></i>
                    <strong>Peringatan Keamanan:</strong><br>
                    {{ session('password_warning') }}
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
            @endif                            {{-- Password Requirements Info --}}
                            <div class="alert alert-info">
                                <h5><i class="icon fas fa-info"></i> Persyaratan Password:</h5>
                                <ul class="mb-0" id="passwordRequirements">
                                    <li>Minimal 8 karakter</li>
                                    <li>Mengandung huruf besar dan kecil</li>
                                    <li>Mengandung angka</li>
                                    <li>Mengandung simbol (!@#$%^&*)</li>
                                    <li>Tidak menggunakan password yang mudah ditebak</li>
                                    <li><strong>Tidak menggunakan password yang pernah bocor dalam data breach</strong></li>
                                </ul>
                                <div class="mt-2">
                                    <small class="text-muted">
                                        <i class="fas fa-lightbulb"></i>
                                        <strong>Contoh password kuat:</strong> MyStr0ng$P@ssw0rd2025! atau TiGA#Kata7Aman$
                                    </small>
                                </div>
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
<style>
.progress {
    background-color: #e9ecef;
}

.input-group-append .btn {
    border-left: 0;
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
    border-color: #dc3545;
}

.text-success {
    color: #28a745 !important;
}

.text-danger {
    color: #dc3545 !important;
}
</style>

<!-- Test Script for Debugging -->
<script src="{{ asset('js/test-password-features.js') }}"></script>

<script>
// Use vanilla JavaScript and jQuery together for better compatibility
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Content Loaded');
    
    // Wait for jQuery to be available
    function initPasswordFeatures() {
        if (typeof $ === 'undefined') {
            console.log('jQuery not ready, waiting...');
            setTimeout(initPasswordFeatures, 100);
            return;
        }
        
        console.log('jQuery ready, initializing password features');
        
        // Toggle password visibility with vanilla JS
        document.getElementById('toggleCurrentPassword')?.addEventListener('click', function(e) {
            e.preventDefault();
            togglePasswordVisibility('current_password', this);
        });

        document.getElementById('toggleNewPassword')?.addEventListener('click', function(e) {
            e.preventDefault();
            togglePasswordVisibility('new_password', this);
        });

        document.getElementById('toggleConfirmPassword')?.addEventListener('click', function(e) {
            e.preventDefault();
            togglePasswordVisibility('new_password_confirmation', this);
        });

        // Password strength checker
        const newPasswordInput = document.getElementById('new_password');
        if (newPasswordInput) {
            newPasswordInput.addEventListener('input', function() {
                checkPasswordStrength(this.value);
            });
            newPasswordInput.addEventListener('keyup', function() {
                checkPasswordStrength(this.value);
            });
        }

        // Password match checker
        const confirmPasswordInput = document.getElementById('new_password_confirmation');
        if (confirmPasswordInput) {
            confirmPasswordInput.addEventListener('input', function() {
                checkPasswordMatch();
            });
            confirmPasswordInput.addEventListener('keyup', function() {
                checkPasswordMatch();
            });
        }

        // Form validation
        const form = document.getElementById('changePasswordForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                if (!validateForm()) {
                    e.preventDefault();
                    return false;
                }
                
                // Disable submit button to prevent double submission
                const submitBtn = document.getElementById('submitBtn');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
                }
            });
        }
        
        console.log('Password features initialized');
    }
    
    initPasswordFeatures();

    // Form validation
    $('#changePasswordForm').on('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            return false;
        }
        
        // Disable submit button to prevent double submission
        $('#submitBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...');
    });

    function togglePasswordVisibility(inputId, button) {
        console.log('togglePasswordVisibility called for:', inputId);
        const input = document.getElementById(inputId);
        const icon = button.querySelector('i');
        
        if (!input) {
            console.error('Input not found:', inputId);
            return;
        }
        
        if (!icon) {
            console.error('Icon not found in button');
            return;
        }
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
            console.log('Password shown for:', inputId);
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
            console.log('Password hidden for:', inputId);
        }
    }

    function checkPasswordStrength(password) {
        console.log('Checking password strength for:', password ? password.length : 0, 'characters');
        let strength = 0;
        let text = '';
        let colorClass = '';

        // Get elements
        const progressBar = document.getElementById('passwordStrength');
        const progressText = document.getElementById('passwordStrengthText');
        
        if (!progressBar) {
            console.error('Password strength progress bar not found');
            return;
        }
        
        if (!progressText) {
            console.error('Password strength text not found');
            return;
        }

        // Reset if empty
        if (!password || password.length === 0) {
            progressBar.style.width = '0%';
            progressBar.className = 'progress-bar';
            progressText.textContent = 'Kekuatan password akan ditampilkan di sini';
            return;
        }

        // Calculate strength
        if (password.length >= 8) strength += 20;
        if (/[a-z]/.test(password)) strength += 20;
        if (/[A-Z]/.test(password)) strength += 20;
        if (/\d/.test(password)) strength += 20;
        if (/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) strength += 20;

        if (strength < 40) {
            text = 'Lemah';
            colorClass = 'bg-danger';
        } else if (strength < 60) {
            text = 'Sedang';
            colorClass = 'bg-warning';
        } else if (strength < 80) {
            text = 'Kuat';
            colorClass = 'bg-info';
        } else {
            text = 'Sangat Kuat';
            colorClass = 'bg-success';
        }

        console.log('Password strength:', strength, text);
        
        progressBar.style.width = strength + '%';
        progressBar.className = 'progress-bar ' + colorClass;
        progressText.textContent = 'Kekuatan password: ' + text;
    }

    function checkPasswordMatch() {
        const newPasswordInput = document.getElementById('new_password');
        const confirmPasswordInput = document.getElementById('new_password_confirmation');
        const matchText = document.getElementById('passwordMatchText');
        
        console.log('Checking password match');
        
        if (!newPasswordInput || !confirmPasswordInput || !matchText) {
            console.error('Password match elements not found');
            return;
        }

        const newPassword = newPasswordInput.value;
        const confirmPassword = confirmPasswordInput.value;

        if (confirmPassword === '') {
            matchText.textContent = '';
            matchText.className = '';
            return;
        }

        if (newPassword === confirmPassword) {
            matchText.textContent = '✓ Password cocok';
            matchText.className = 'text-success';
            console.log('Passwords match');
        } else {
            matchText.textContent = '✗ Password tidak cocok';
            matchText.className = 'text-danger';
            console.log('Passwords do not match');
        }
    }

    function validateForm() {
        let isValid = true;
        const currentPasswordInput = document.getElementById('current_password');
        const newPasswordInput = document.getElementById('new_password');
        const confirmPasswordInput = document.getElementById('new_password_confirmation');
        
        if (!currentPasswordInput || !newPasswordInput || !confirmPasswordInput) {
            console.error('Form inputs not found');
            return false;
        }
        
        const currentPassword = currentPasswordInput.value;
        const newPassword = newPasswordInput.value;
        const confirmPassword = confirmPasswordInput.value;

        // Reset validation states
        document.querySelectorAll('.form-control').forEach(function(el) {
            el.classList.remove('is-invalid');
        });

        // Validate current password
        if (currentPassword === '') {
            currentPasswordInput.classList.add('is-invalid');
            isValid = false;
        }

        // Validate new password
        if (newPassword === '') {
            newPasswordInput.classList.add('is-invalid');
            isValid = false;
        } else if (newPassword.length < 8) {
            newPasswordInput.classList.add('is-invalid');
            showToast('Password baru minimal 8 karakter', 'error');
            isValid = false;
        }

        // Validate password confirmation
        if (confirmPassword === '') {
            confirmPasswordInput.classList.add('is-invalid');
            isValid = false;
        } else if (newPassword !== confirmPassword) {
            confirmPasswordInput.classList.add('is-invalid');
            showToast('Konfirmasi password tidak cocok', 'error');
            isValid = false;
        }

        // Check if new password is same as current
        if (currentPassword === newPassword && newPassword !== '') {
            newPasswordInput.classList.add('is-invalid');
            showToast('Password baru harus berbeda dari password saat ini', 'error');
            isValid = false;
        }

        return isValid;
    }

    function showToast(message, type) {
        // Fallback to alert if AdminLTE toast is not available
        if (typeof $ !== 'undefined' && $.fn.Toasts) {
            const toastClass = type === 'success' ? 'bg-success' : 'bg-danger';
            
            $(document).Toasts('create', {
                class: toastClass,
                title: type === 'success' ? 'Berhasil' : 'Error',
                autohide: true,
                delay: 5000,
                body: message
            });
        } else {
            // Fallback to simple alert
            alert((type === 'success' ? 'Berhasil: ' : 'Error: ') + message);
        }
    }

    // Test function to verify all elements are working
    function testElements() {
        const elements = [
            'current_password',
            'new_password', 
            'new_password_confirmation',
            'toggleCurrentPassword',
            'toggleNewPassword',
            'toggleConfirmPassword',
            'passwordStrength',
            'passwordStrengthText',
            'passwordMatchText'
        ];
        
        console.log('Testing elements...');
        elements.forEach(function(id) {
            const el = document.getElementById(id);
            console.log(id + ':', el ? 'Found' : 'NOT FOUND');
        });
    }
    
<!-- Test Script for Debugging -->
<script src="{{ asset('js/test-password-features.js') }}"></script>
@endsection