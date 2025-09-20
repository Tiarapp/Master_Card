<!-- Floating Feedback Button -->
<div id="feedbackFloat" class="feedback-float">
  <button type="button" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#quickFeedbackModal" title="Kirim Feedback">
    <i class="fas fa-comment-dots"></i>
  </button>
</div>

<!-- Quick Feedback Modal -->
<div class="modal fade" id="quickFeedbackModal" tabindex="-1" role="dialog" aria-labelledby="quickFeedbackModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="quickFeedbackModalLabel">
          <i class="fas fa-comment-dots mr-2"></i>Kirim Feedback Cepat
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="quickFeedbackForm">
        <div class="modal-body">
          <div class="alert alert-info">
            <i class="fas fa-info-circle mr-2"></i>
            <strong>Bantuan:</strong> Feedback Anda sangat berharga untuk meningkatkan sistem ini!
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="quick_type">Tipe Feedback <span class="text-danger">*</span></label>
                <select class="form-control" id="quick_type" name="type" required>
                  <option value="">Pilih Tipe</option>
                  <option value="suggestion">💡 Saran Perbaikan</option>
                  <option value="bug_report">🐛 Laporan Bug</option>
                  <option value="feature_request">✨ Permintaan Fitur</option>
                  <option value="complaint">😟 Keluhan</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="quick_category">Kategori <span class="text-danger">*</span></label>
                <select class="form-control" id="quick_category" name="category" required>
                  <option value="">Pilih Kategori</option>
                  <option value="system">🖥️ Sistem</option>
                  <option value="ui_ux">🎨 UI/UX</option>
                  <option value="inventory">📦 Inventory</option>
                  <option value="reports">📊 Laporan</option>
                  <option value="other">🔧 Lainnya</option>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="quick_priority">Prioritas <span class="text-danger">*</span></label>
                <select class="form-control" id="quick_priority" name="priority" required>
                  <option value="">Pilih Prioritas</option>
                  <option value="urgent" class="text-danger">🔥 Urgent</option>
                  <option value="high" class="text-warning">⚡ Tinggi</option>
                  <option value="medium" class="text-info">📋 Sedang</option>
                  <option value="low" class="text-success">📝 Rendah</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="quick_email">Email <small class="text-muted">(Opsional)</small></label>
                <input type="email" class="form-control" id="quick_email" name="email" 
                       placeholder="email@example.com"
                       value="{{ Auth::check() ? Auth::user()->email : '' }}">
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="quick_message">Pesan <span class="text-danger">*</span></label>
            <textarea class="form-control" id="quick_message" name="message" rows="5" required
                      placeholder="Ceritakan feedback Anda..."></textarea>
            <small class="form-text text-muted">Minimum 10 karakter</small>
          </div>

          <div class="form-group">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="includePageInfo" checked>
              <label class="custom-control-label" for="includePageInfo">
                Sertakan informasi halaman saat ini
              </label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <i class="fas fa-times mr-1"></i>Batal
          </button>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-paper-plane mr-1"></i>Kirim Feedback
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
.feedback-float {
  position: fixed;
  bottom: 30px;
  right: 30px;
  z-index: 1000;
}

.feedback-float .btn-circle {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  font-size: 20px;
  transition: all 0.3s ease;
}

.feedback-float .btn-circle:hover {
  transform: scale(1.1);
  box-shadow: 0 6px 20px rgba(0,0,0,0.2);
}

.feedback-float .btn-circle i {
  animation: pulse 2s infinite;
}

@keyframes pulse {
  0% { opacity: 1; }
  50% { opacity: 0.7; }
  100% { opacity: 1; }
}

@media (max-width: 768px) {
  .feedback-float {
    bottom: 20px;
    right: 20px;
  }
  
  .feedback-float .btn-circle {
    width: 50px;
    height: 50px;
    font-size: 16px;
  }
}

/* Form styling */
#quickFeedbackModal .form-group label {
  font-weight: 600;
  color: #495057;
}

#quickFeedbackModal .form-control:focus {
  border-color: #007bff;
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

#quickFeedbackModal .modal-body {
  max-height: 80vh;
  overflow-y: auto;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quick feedback form submission
    document.getElementById('quickFeedbackForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData();
        formData.append('type', document.getElementById('quick_type').value);
        formData.append('category', document.getElementById('quick_category').value);
        formData.append('priority', document.getElementById('quick_priority').value);
        formData.append('email', document.getElementById('quick_email').value);
        formData.append('message', document.getElementById('quick_message').value);
        
        // Add page info if checkbox is checked
        if (document.getElementById('includePageInfo').checked) {
            formData.append('page_url', window.location.href);
        }
        
        // Add CSRF token
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        
        // Validate
        const message = document.getElementById('quick_message').value;
        const type = document.getElementById('quick_type').value;
        const category = document.getElementById('quick_category').value;
        const priority = document.getElementById('quick_priority').value;
        
        if (!type) {
            alert('Silakan pilih tipe feedback');
            return;
        }
        
        if (!category) {
            alert('Silakan pilih kategori feedback');
            return;
        }
        
        if (!priority) {
            alert('Silakan pilih prioritas feedback');
            return;
        }
        
        if (message.length < 10) {
            alert('Pesan minimal harus 10 karakter');
            return;
        }
        
        // Show loading
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Mengirim...';
        submitBtn.disabled = true;
        
        // Submit via AJAX
        fetch('{{ route("admin.feedback.quick-submit") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                $('#quickFeedbackModal').modal('hide');
                
                // Reset form
                this.reset();
                
                // Show success notification
                showNotification('Terima kasih! Feedback Anda telah dikirim.', 'success');
            } else {
                showNotification('Gagal mengirim feedback. Silakan coba lagi.', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan. Silakan coba lagi.', 'error');
        })
        .finally(() => {
            // Restore button
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    });
    
    // Auto-focus message when modal opens
    $('#quickFeedbackModal').on('shown.bs.modal', function() {
        document.getElementById('quick_type').focus();
    });
    
    // Update placeholder based on feedback type
    document.getElementById('quick_type').addEventListener('change', function() {
        const messageField = document.getElementById('quick_message');
        const type = this.value;
        
        const placeholders = {
            'suggestion': 'Contoh: Saya menyarankan untuk menambahkan fitur...',
            'bug_report': 'Contoh: Saat saya mengklik tombol X, yang terjadi adalah... Padahal seharusnya...',
            'feature_request': 'Contoh: Saya membutuhkan fitur untuk... karena saat ini...',
            'complaint': 'Contoh: Saya mengalami masalah dengan... yang membuat...'
        };
        
        messageField.placeholder = placeholders[type] || 'Ceritakan feedback Anda...';
    });
    
    // Update priority color based on selection
    document.getElementById('quick_priority').addEventListener('change', function() {
        const priority = this.value;
        this.className = 'form-control';
        
        if (priority === 'urgent') {
            this.classList.add('border-danger');
        } else if (priority === 'high') {
            this.classList.add('border-warning');
        } else if (priority === 'medium') {
            this.classList.add('border-info');
        } else if (priority === 'low') {
            this.classList.add('border-success');
        }
    });
});

function showNotification(message, type = 'info') {
    const alertClass = type === 'success' ? 'alert-success' : (type === 'error' ? 'alert-danger' : 'alert-info');
    const icon = type === 'success' ? 'check-circle' : (type === 'error' ? 'exclamation-triangle' : 'info-circle');
    
    const notification = $(`
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
            <i class="fas fa-${icon} mr-2"></i>${message}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    `);
    
    $('body').append(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.alert('close');
    }, 5000);
}
</script>
