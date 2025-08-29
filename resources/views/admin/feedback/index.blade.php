@extends('admin.templates.partials.default')

@section('content')
<div class="content-wrapper">
  <!-- Content Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Feedback Management</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Feedback</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      
      <!-- Statistics Cards -->
      <div class="row mb-4">
        <div class="col-lg-3 col-6">
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{ $feedbacks->where('status', 'open')->count() }}</h3>
              <p>Feedback Terbuka</p>
            </div>
            <div class="icon">
              <i class="fas fa-exclamation-circle"></i>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{ $feedbacks->where('status', 'in_progress')->count() }}</h3>
              <p>Sedang Diproses</p>
            </div>
            <div class="icon">
              <i class="fas fa-cog"></i>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box bg-success">
            <div class="inner">
              <h3>{{ $feedbacks->where('status', 'resolved')->count() }}</h3>
              <p>Selesai</p>
            </div>
            <div class="icon">
              <i class="fas fa-check-circle"></i>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box bg-secondary">
            <div class="inner">
              <h3>{{ $feedbacks->total() }}</h3>
              <p>Total Feedback</p>
            </div>
            <div class="icon">
              <i class="fas fa-comments"></i>
            </div>
          </div>
        </div>
      </div>

      <!-- Filter Card -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Filter Feedback</h3>
        </div>
        <div class="card-body">
          <form method="GET" action="{{ route('admin.feedback.index') }}">
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label>Tipe</label>
                  <select name="type" class="form-control">
                    <option value="">Semua Tipe</option>
                    @foreach($types as $key => $label)
                      <option value="{{ $key }}" {{ request('type') == $key ? 'selected' : '' }}>
                        {{ $label }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Status</label>
                  <select name="status" class="form-control">
                    <option value="">Semua Status</option>
                    @foreach($statuses as $key => $label)
                      <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                        {{ $label }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Kategori</label>
                  <select name="category" class="form-control">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $key => $label)
                      <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>
                        {{ $label }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Prioritas</label>
                  <select name="priority" class="form-control">
                    <option value="">Semua Prioritas</option>
                    @foreach($priorities as $key => $label)
                      <option value="{{ $key }}" {{ request('priority') == $key ? 'selected' : '' }}>
                        {{ $label }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Pencarian</label>
                  <input type="text" name="search" class="form-control" 
                         placeholder="Cari feedback..." value="{{ request('search') }}">
                </div>
              </div>
              <div class="col-md-1">
                <div class="form-group">
                  <label>&nbsp;</label>
                  <button type="submit" class="btn btn-primary btn-block">Filter</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Feedback List -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Daftar Feedback</h3>
          <div class="card-tools">
            <a href="{{ route('admin.feedback.create') }}" class="btn btn-primary btn-sm">
              <i class="fas fa-plus"></i> Tambah Feedback
            </a>
          </div>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-hover text-nowrap">
            <thead>
              <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Nama/Email</th>
                <th>Tipe</th>
                <th>Kategori</th>
                <th>Subject</th>
                <th>Prioritas</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($feedbacks as $feedback)
                <tr>
                  <td>{{ $feedback->id }}</td>
                  <td>{{ $feedback->created_at->format('d/m/Y H:i') }}</td>
                  <td>
                    <div>{{ $feedback->name ?: 'Anonymous' }}</div>
                    <small class="text-muted">{{ $feedback->email ?: '-' }}</small>
                  </td>
                  <td>
                    <span class="badge badge-info">{{ $feedback->getTypeLabel() }}</span>
                  </td>
                  <td>
                    <span class="badge badge-secondary">{{ $feedback->getCategoryLabel() ?: '-' }}</span>
                  </td>
                  <td>
                    <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis;">
                      {{ $feedback->subject }}
                    </div>
                  </td>
                  <td>
                    <span class="badge badge-{{ $feedback->getPriorityColor() }}">
                      {{ $feedback->getPriorityLabel() }}
                    </span>
                  </td>
                  <td>
                    <span class="badge badge-{{ $feedback->getStatusColor() }}">
                      {{ $feedback->getStatusLabel() }}
                    </span>
                  </td>
                  <td>
                    <a href="{{ route('admin.feedback.show', $feedback->id) }}" 
                       class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                      <i class="fas fa-eye"></i>
                    </a>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="9" class="text-center py-4">
                    <div class="text-muted">
                      <i class="fas fa-inbox fa-3x mb-3"></i>
                      <p>Belum ada feedback</p>
                    </div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        @if($feedbacks->hasPages())
          <div class="card-footer">
            {{ $feedbacks->appends(request()->query())->links() }}
          </div>
        @endif
      </div>

    </div>
  </section>
</div>
@endsection
