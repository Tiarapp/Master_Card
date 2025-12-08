// Password Change Form JavaScript
// File: public/js/password-change.js

(function($) {
    'use strict';

    // Namespace untuk password change functionality
    window.PasswordChangeForm = {
        
        // Initialize function
        init: function() {
            this.bindEvents();
            this.initializeElements();
            console.log('PasswordChangeForm initialized successfully');
        },

        // Bind all events
        bindEvents: function() {
            var self = this;
            
            // Toggle password visibility events
            $('#toggleCurrentPassword').off('click.password').on('click.password', function(e) {
                e.preventDefault();
                self.togglePasswordVisibility('current_password', this);
            });

            $('#toggleNewPassword').off('click.password').on('click.password', function(e) {
                e.preventDefault();
                self.togglePasswordVisibility('new_password', this);
            });

            $('#toggleConfirmPassword').off('click.password').on('click.password', function(e) {
                e.preventDefault();
                self.togglePasswordVisibility('new_password_confirmation', this);
            });

            // Password strength checker
            $('#new_password').off('input.password').on('input.password', function() {
                self.checkPasswordStrength($(this).val());
            });

            // Password match checker
            $('#new_password_confirmation').off('input.password').on('input.password', function() {
                self.checkPasswordMatch();
            });

            // Form validation
            $('#changePasswordForm').off('submit.password').on('submit.password', function(e) {
                if (!self.validateForm()) {
                    e.preventDefault();
                    return false;
                }
                
                // Disable submit button to prevent double submission
                $('#submitBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...');
            });

            // Real-time validation
            $('.form-control').off('blur.password').on('blur.password', function() {
                self.validateField($(this));
            });
        },

        // Initialize elements and check availability
        initializeElements: function() {
            var elements = {
                currentPassword: $('#current_password'),
                newPassword: $('#new_password'),
                confirmPassword: $('#new_password_confirmation'),
                strengthBar: $('#passwordStrength'),
                strengthText: $('#passwordStrengthText'),
                matchText: $('#passwordMatchText'),
                form: $('#changePasswordForm')
            };

            // Log element availability
            console.log('Element check:');
            for (var key in elements) {
                var element = elements[key];
                console.log('- ' + key + ':', element.length > 0 ? 'Found' : 'Missing');
            }

            return elements;
        },

        // Toggle password visibility
        togglePasswordVisibility: function(inputId, button) {
            var input = document.getElementById(inputId);
            var icon = button.querySelector('i');
            
            if (!input || !icon) {
                console.error('Input atau icon tidak ditemukan untuk:', inputId);
                return;
            }
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = icon.className.replace('fa-eye', 'fa-eye-slash');
                console.log('Password shown for:', inputId);
            } else {
                input.type = 'password';
                icon.className = icon.className.replace('fa-eye-slash', 'fa-eye');
                console.log('Password hidden for:', inputId);
            }
        },

        // Check password strength
        checkPasswordStrength: function(password) {
            var strength = 0;
            var text = '';
            var colorClass = '';
            var criteria = {
                length: password.length >= 8,
                lowercase: /[a-z]/.test(password),
                uppercase: /[A-Z]/.test(password),
                numbers: /\d/.test(password),
                symbols: /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)
            };

            // Reset jika password kosong
            if (password.length === 0) {
                this.updateStrengthIndicator(0, 'Kekuatan password akan ditampilkan di sini', '');
                return;
            }

            // Hitung skor berdasarkan kriteria
            Object.keys(criteria).forEach(function(key) {
                if (criteria[key]) strength += 20;
            });

            // Tentukan kategori dan warna
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

            this.updateStrengthIndicator(strength, 'Kekuatan password: ' + text, colorClass);

            // Log untuk debugging
            console.log('Password strength analysis:', {
                length: password.length,
                criteria: criteria,
                strength: strength,
                category: text
            });
        },

        // Update strength indicator UI
        updateStrengthIndicator: function(percentage, text, colorClass) {
            var $progressBar = $('#passwordStrength');
            var $progressText = $('#passwordStrengthText');
            
            if ($progressBar.length && $progressText.length) {
                $progressBar
                    .css('width', percentage + '%')
                    .removeClass('bg-danger bg-warning bg-info bg-success')
                    .addClass('progress-bar ' + colorClass);
                $progressText.text(text);
            } else {
                console.error('Progress bar elements tidak ditemukan');
            }
        },

        // Check password match
        checkPasswordMatch: function() {
            var newPassword = $('#new_password').val();
            var confirmPassword = $('#new_password_confirmation').val();
            var $matchText = $('#passwordMatchText');

            if (!$matchText.length) {
                console.error('Password match text element tidak ditemukan');
                return;
            }

            if (confirmPassword === '') {
                $matchText.text('').removeClass('text-success text-danger');
                return;
            }

            if (newPassword === confirmPassword) {
                $matchText.text('✓ Password cocok').removeClass('text-danger').addClass('text-success');
            } else {
                $matchText.text('✗ Password tidak cocok').removeClass('text-success').addClass('text-danger');
            }
        },

        // Validate individual field
        validateField: function($field) {
            var fieldId = $field.attr('id');
            var value = $field.val();
            var isValid = true;

            $field.removeClass('is-invalid');

            switch(fieldId) {
                case 'current_password':
                    if (value === '') {
                        isValid = false;
                    }
                    break;
                case 'new_password':
                    if (value === '' || value.length < 8) {
                        isValid = false;
                    }
                    break;
                case 'new_password_confirmation':
                    if (value === '' || value !== $('#new_password').val()) {
                        isValid = false;
                    }
                    break;
            }

            if (!isValid) {
                $field.addClass('is-invalid');
            }

            return isValid;
        },

        // Validate entire form
        validateForm: function() {
            var isValid = true;
            var currentPassword = $('#current_password').val();
            var newPassword = $('#new_password').val();
            var confirmPassword = $('#new_password_confirmation').val();

            // Reset validation states
            $('.form-control').removeClass('is-invalid');

            // Validate current password
            if (currentPassword === '') {
                $('#current_password').addClass('is-invalid');
                isValid = false;
            }

            // Validate new password
            if (newPassword === '') {
                $('#new_password').addClass('is-invalid');
                isValid = false;
            } else if (newPassword.length < 8) {
                $('#new_password').addClass('is-invalid');
                this.showToast('Password baru minimal 8 karakter', 'error');
                isValid = false;
            }

            // Validate password confirmation
            if (confirmPassword === '') {
                $('#new_password_confirmation').addClass('is-invalid');
                isValid = false;
            } else if (newPassword !== confirmPassword) {
                $('#new_password_confirmation').addClass('is-invalid');
                this.showToast('Konfirmasi password tidak cocok', 'error');
                isValid = false;
            }

            // Check if new password is same as current
            if (currentPassword === newPassword && newPassword !== '') {
                $('#new_password').addClass('is-invalid');
                this.showToast('Password baru harus berbeda dari password saat ini', 'error');
                isValid = false;
            }

            return isValid;
        },

        // Show toast notification
        showToast: function(message, type) {
            var toastClass = type === 'success' ? 'bg-success' : 'bg-danger';
            
            // Cek apakah AdminLTE toast tersedia
            if (typeof $(document).Toasts === 'function') {
                $(document).Toasts('create', {
                    class: toastClass,
                    title: type === 'success' ? 'Berhasil' : 'Error',
                    autohide: true,
                    delay: 5000,
                    body: message
                });
            } else {
                // Fallback ke alert atau custom notification
                console.warn('AdminLTE Toasts not available, using fallback');
                
                // Create simple notification
                var alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
                var notification = $('<div class="alert ' + alertClass + ' alert-dismissible fade show" role="alert">' +
                    message +
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                    '<span aria-hidden="true">&times;</span>' +
                    '</button>' +
                    '</div>');
                
                // Insert notification at top of form
                $('#changePasswordForm').prepend(notification);
                
                // Auto remove after 5 seconds
                setTimeout(function() {
                    notification.fadeOut();
                }, 5000);
            }
        }
    };

    // Auto-initialize when document ready
    $(document).ready(function() {
        // Small delay to ensure all elements are loaded
        setTimeout(function() {
            window.PasswordChangeForm.init();
        }, 100);
    });

})(jQuery);