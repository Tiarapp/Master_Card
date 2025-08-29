@extends('admin.templates.partials.default')

@section('content')
<div class="content-wrapper">
  <!-- Content Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Kirim Feedback</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.feedback.index') }}">Feedback</a></li>
            <li class="breadcrumb-item active">Kirim Feedback</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      
      <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Form Feedback</h3>
            </div>
            <form id="feedbackForm" action="{{ route('admin.feedback.store') }}" method="POST">
              @csrf
              <div class="card-body">
                
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name">Nama <small class="text-muted">(Opsional)</small></label>
                      <input type="text" class="form-control" id="name" name="name" 
                             value="{{ old('name', Auth::user()->name ?? '') }}" 
                             placeholder="Masukkan nama Anda">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="email">Email <small class="text-muted">(Opsional)</small></label>
                      <input type="email" class="form-control" id="email" name="email" 
                             value="{{ old('email', Auth::user()->email ?? '') }}" 
                             placeholder="email@example.com">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="type">Tipe Feedback <span class="text-danger">*</span></label>
                      <select class="form-control" id="type" name="type" required>
                        <option value="">Pilih Tipe</option>
                        <option value="suggestion" {{ old('type') == 'suggestion' ? 'selected' : '' }}>
                          💡 Saran
                        </option>
                        <option value="bug_report" {{ old('type') == 'bug_report' ? 'selected' : '' }}>
                          🐛 Laporan Bug
                        </option>
                        <option value="feature_request" {{ old('type') == 'feature_request' ? 'selected' : '' }}>
                          ✨ Permintaan Fitur
                        </option>
                        <option value="complaint" {{ old('type') == 'complaint' ? 'selected' : '' }}>
                          😟 Keluhan
                        </option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="category">Kategori</label>
                      <select class="form-control" id="category" name="category">
                        <option value="">Pilih Kategori</option>
                        <option value="inventory" {{ old('category') == 'inventory' ? 'selected' : '' }}>
                          📦 Inventory
                        </option>
                        <option value="reports" {{ old('category') == 'reports' ? 'selected' : '' }}>
                          📊 Laporan
                        </option>
                        <option value="system" {{ old('category') == 'system' ? 'selected' : '' }}>
                          ⚙️ Sistem
                        </option>
                        <option value="ui_ux" {{ old('category') == 'ui_ux' ? 'selected' : '' }}>
                          🎨 UI/UX
                        </option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="priority">Prioritas <span class="text-danger">*</span></label>
                      <select class="form-control" id="priority" name="priority" required>
                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>
                          🟡 Sedang
                        </option>
                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>
                          🟢 Rendah
                        </option>
                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>
                          🔴 Tinggi
                        </option>
                        <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>
                          ⚫ Mendesak
                        </option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="subject">Subject <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="subject" name="subject" 
                         value="{{ old('subject') }}" required
                         placeholder="Ringkasan singkat feedback Anda">
                </div>

                <div class="form-group">
                  <label for="message">Pesan <span class="text-danger">*</span></label>
                  <textarea class="form-control" id="message" name="message" rows="6" required
                            placeholder="Jelaskan detail feedback Anda...">{{ old('message') }}</textarea>
                  <small class="form-text text-muted">
                    Minimum 10 karakter. Semakin detail, semakin membantu kami.
                  </small>
                </div>

                <!-- Hidden field untuk page URL -->
                <input type="hidden" name="page_url" value="{{ url()->previous() }}">

              </div>
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-paper-plane"></i> Kirim Feedback
                </button>
                <a href="{{ route('admin.feedback.index') }}" class="btn btn-secondary">
                  <i class="fas fa-arrow-left"></i> Kembali
                </a>
              </div>
            </form>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">💡 Tips Feedback yang Baik</h3>
            </div>
            <div class="card-body">
              <div class="mb-3">
                <h6>🐛 Untuk Laporan Bug:</h6>
                <ul class="list-unstyled small">
                  <li>• Jelaskan langkah-langkah yang dilakukan</li>
                  <li>• Sebutkan hasil yang diharapkan vs aktual</li>
                  <li>• Sertakan screenshot jika memungkinkan</li>
                </ul>
              </div>
              
              <div class="mb-3">
                <h6>💡 Untuk Saran:</h6>
                <ul class="list-unstyled small">
                  <li>• Jelaskan masalah yang ingin dipecahkan</li>
                  <li>• Berikan solusi yang spesifik</li>
                  <li>• Sebutkan manfaat yang diharapkan</li>
                </ul>
              </div>

              <div class="mb-3">
                <h6>✨ Untuk Permintaan Fitur:</h6>
                <ul class="list-unstyled small">
                  <li>• Jelaskan kebutuhan bisnis</li>
                  <li>• Berikan contoh penggunaan</li>
                  <li>• Sebutkan alternatif saat ini</li>
                </ul>
              </div>

              <div>
                <h6>😟 Untuk Keluhan:</h6>
                <ul class="list-unstyled small">
                  <li>• Jelaskan masalah secara objektif</li>
                  <li>• Berikan konteks situasi</li>
                  <li>• Sertakan saran perbaikan</li>
                </ul>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">📞 Kontak Alternatif</h3>
            </div>
            <div class="card-body">
              <p class="small text-muted">
                Jika feedback Anda bersifat mendesak atau memerlukan respons cepat, 
                Anda juga dapat menghubungi:
              </p>
              <ul class="list-unstyled small">
                <li><i class="fas fa-envelope"></i> it@saranapackaging.com</li>
                <li><i class="fas fa-phone"></i> +62 812-3290-3098</li>
                <li><i class="fab fa-whatsapp"></i> WhatsApp Support</li>
              </ul>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-update subject based on type
    document.getElementById('type').addEventListener('change', function() {
        const subject = document.getElementById('subject');
        const type = this.value;
        
        if (type && !subject.value) {
            const typeLabels = {
                'suggestion': 'Saran: ',
                'bug_report': 'Bug: ',
                'feature_request': 'Fitur: ',
                'complaint': 'Keluhan: '
            };
            subject.value = typeLabels[type] || '';
            subject.focus();
        }
    });

    // Form validation
    document.getElementById('feedbackForm').addEventListener('submit', function(e) {
        const message = document.getElementById('message').value;
        if (message.length < 10) {
            e.preventDefault();
            alert('Pesan minimal harus 10 karakter');
            return false;
        }
    });
});
</script>
@endsection
