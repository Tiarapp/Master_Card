@extends('admin.templates.partials.default')

@section('content')
<div class="content-wrapper">
  <!-- Content Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Detail Feedback #{{ $feedback->id }}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.feedback.index') }}">Feedback</a></li>
            <li class="breadcrumb-item active">Detail #{{ $feedback->id }}</li>
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
          <!-- Feedback Detail -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">{{ $feedback->subject }}</h3>
              <div class="card-tools">
                <span class="badge badge-{{ $feedback->getStatusColor() }} badge-lg">
                  {{ $feedback->getStatusLabel() }}
                </span>
              </div>
            </div>
            <div class="card-body">
              <div class="row mb-3">
                <div class="col-sm-6">
                  <strong>Tipe:</strong>
                  <span class="badge badge-info ml-1">{{ $feedback->getTypeLabel() }}</span>
                </div>
                <div class="col-sm-6">
                  <strong>Prioritas:</strong>
                  <span class="badge badge-{{ $feedback->getPriorityColor() }} ml-1">
                    {{ $feedback->getPriorityLabel() }}
                  </span>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-sm-6">
                  <strong>Kategori:</strong>
                  @if($feedback->category)
                    <span class="badge badge-secondary ml-1">{{ $feedback->getCategoryLabel() }}</span>
                  @else
                    <span class="text-muted">-</span>
                  @endif
                </div>
                <div class="col-sm-6">
                  <strong>Tanggal:</strong>
                  {{ $feedback->created_at->format('d F Y, H:i') }}
                </div>
              </div>

              <div class="mb-4">
                <strong>Pesan:</strong>
                <div class="mt-2 p-3 bg-light rounded">
                  {!! nl2br(e($feedback->message)) !!}
                </div>
              </div>

              @if($feedback->page_url)
                <div class="mb-3">
                  <strong>Halaman Asal:</strong>
                  <a href="{{ $feedback->page_url }}" target="_blank" class="ml-1">
                    {{ $feedback->page_url }}
                    <i class="fas fa-external-link-alt"></i>
                  </a>
                </div>
              @endif

              @if($feedback->browser_info)
                <div class="mb-3">
                  <strong>Informasi Browser:</strong>
                  <div class="mt-2">
                    <small class="text-muted">
                      <strong>User Agent:</strong> {{ $feedback->browser_info['user_agent'] ?? '-' }}<br>
                      <strong>IP Address:</strong> {{ $feedback->browser_info['ip_address'] ?? '-' }}<br>
                      <strong>Timestamp:</strong> {{ $feedback->browser_info['timestamp'] ?? '-' }}
                    </small>
                  </div>
                </div>
              @endif

              @if($feedback->admin_response)
                <hr>
                <div class="mt-4">
                  <strong>Respons Admin:</strong>
                  <div class="mt-2 p-3 bg-success bg-opacity-10 border-left border-success rounded">
                    {!! nl2br(e($feedback->admin_response)) !!}
                  </div>
                  <small class="text-muted">
                    Direspons oleh {{ $feedback->respondedBy->name ?? 'Admin' }} 
                    pada {{ $feedback->responded_at->format('d F Y, H:i') }}
                  </small>
                </div>
              @endif
            </div>
          </div>

          <!-- Response Form -->
          @if(!$feedback->admin_response || $feedback->status !== 'closed')
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Respons Admin</h3>
              </div>
              <form action="{{ route('admin.feedback.update', $feedback->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                  
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                          <option value="open" {{ $feedback->status == 'open' ? 'selected' : '' }}>
                            Terbuka
                          </option>
                          <option value="in_progress" {{ $feedback->status == 'in_progress' ? 'selected' : '' }}>
                            Sedang Diproses
                          </option>
                          <option value="resolved" {{ $feedback->status == 'resolved' ? 'selected' : '' }}>
                            Selesai
                          </option>
                          <option value="closed" {{ $feedback->status == 'closed' ? 'selected' : '' }}>
                            Ditutup
                          </option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="priority">Prioritas</label>
                        <select class="form-control" id="priority" name="priority">
                          <option value="low" {{ $feedback->priority == 'low' ? 'selected' : '' }}>
                            Rendah
                          </option>
                          <option value="medium" {{ $feedback->priority == 'medium' ? 'selected' : '' }}>
                            Sedang
                          </option>
                          <option value="high" {{ $feedback->priority == 'high' ? 'selected' : '' }}>
                            Tinggi
                          </option>
                          <option value="urgent" {{ $feedback->priority == 'urgent' ? 'selected' : '' }}>
                            Mendesak
                          </option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="admin_response">Respons</label>
                    <textarea class="form-control" id="admin_response" name="admin_response" rows="5"
                              placeholder="Berikan respons untuk feedback ini...">{{ $feedback->admin_response }}</textarea>
                  </div>

                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Respons
                  </button>
                </div>
              </form>
            </div>
          @endif
        </div>

        <div class="col-md-4">
          <!-- User Info -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Informasi User</h3>
            </div>
            <div class="card-body">
              <div class="text-center mb-3">
                <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center" 
                     style="width: 60px; height: 60px;">
                  <i class="fas fa-user text-white fa-2x"></i>
                </div>
              </div>
              
              <table class="table table-borderless">
                <tr>
                  <td><strong>Nama:</strong></td>
                  <td>{{ $feedback->name ?: 'Anonymous' }}</td>
                </tr>
                <tr>
                  <td><strong>Email:</strong></td>
                  <td>{{ $feedback->email ?: '-' }}</td>
                </tr>
                <tr>
                  <td><strong>User ID:</strong></td>
                  <td>
                    @if($feedback->user)
                      <a href="#" class="text-primary">{{ $feedback->user->name }}</a>
                    @else
                      <span class="text-muted">Guest</span>
                    @endif
                  </td>
                </tr>
                <tr>
                  <td><strong>Tanggal Kirim:</strong></td>
                  <td>{{ $feedback->created_at->format('d/m/Y H:i') }}</td>
                </tr>
              </table>
            </div>
          </div>

          <!-- Quick Actions -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Aksi Cepat</h3>
            </div>
            <div class="card-body">
              <div class="d-grid gap-2">
                @if($feedback->status !== 'in_progress')
                  <form action="{{ route('admin.feedback.update', $feedback->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="in_progress">
                    <button type="submit" class="btn btn-info btn-block">
                      <i class="fas fa-play"></i> Mulai Proses
                    </button>
                  </form>
                @endif

                @if($feedback->status !== 'resolved')
                  <form action="{{ route('admin.feedback.update', $feedback->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="resolved">
                    <button type="submit" class="btn btn-success btn-block">
                      <i class="fas fa-check"></i> Tandai Selesai
                    </button>
                  </form>
                @endif

                @if($feedback->email)
                  <a href="mailto:{{ $feedback->email }}?subject=Re: {{ $feedback->subject }}" 
                     class="btn btn-outline-primary btn-block">
                    <i class="fas fa-envelope"></i> Balas via Email
                  </a>
                @endif

                <a href="{{ route('admin.feedback.index') }}" class="btn btn-outline-secondary btn-block">
                  <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                </a>
              </div>
            </div>
          </div>

          <!-- Related Stats -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Statistik</h3>
            </div>
            <div class="card-body">
              <small class="text-muted">
                <div class="mb-2">
                  <i class="fas fa-clock"></i>
                  Dibuat {{ $feedback->created_at->diffForHumans() }}
                </div>
                @if($feedback->responded_at)
                  <div class="mb-2">
                    <i class="fas fa-reply"></i>
                    Direspons {{ $feedback->responded_at->diffForHumans() }}
                  </div>
                @endif
                <div>
                  <i class="fas fa-eye"></i>
                  Terakhir diperbarui {{ $feedback->updated_at->diffForHumans() }}
                </div>
              </small>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>
@endsection
