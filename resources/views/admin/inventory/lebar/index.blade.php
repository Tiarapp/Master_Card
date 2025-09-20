@extends('admin.templates.partials.default')

<style>
.label {
  color: white;
}

.status {
  width: auto;
  height: auto;
  margin-top: 20px;
  text-align: center;
  padding: 8px;
  border-radius: 10%;
}

.success {background-color: #04AA6D;} /* Green */
.info {background-color: #2196F3;} /* Blue */
.warning {background-color: #ff9800;} /* Orange */
.danger {background-color: #f44336;} /* Red */
.other {background-color: #e7e7e7; color: black;} /* Gray */
</style>

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Master Lebar Roll</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('inventory.index') }}">Inventory</a></li>
            <li class="breadcrumb-item active">Lebar</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
          <strong>{{ $message }}</strong>
        </div>
      @endif

      <div class="row mb-4 align-items-center">
        <div class="col-auto d-flex align-items-center gap-3">
          <button type="button" class="btn btn-success d-flex align-items-center shadow-sm" data-toggle="modal" data-target="#addLebarModal" style="margin-bottom: 20px;">
            <i class="fas fa-plus-circle me-2"></i>
            <span>{{ __('Tambah Lebar') }}</span>
          </button>
        </div>
        <div class="col text-end">
          <form class="d-flex align-items-center justify-content-end gap-2" action="{{ route('lebar-roll.index') }}" method="GET" style="margin-bottom: 20px;">
            <div class="input-group" style="max-width: 350px;">
              <span class="input-group-text bg-white border-end-0" style="border-radius: 20px 0 0 20px; border-right: none;">
                <i class="fas fa-search text-muted"></i>
              </span>
              <input 
                type="text" 
                class="form-control border-start-0 shadow-none" 
                name="search" 
                placeholder="{{ __('Cari Lebar...') }}" 
                value="{{ request('search') }}" 
                style="border-radius: 0 20px 20px 0; border-left: none; min-width: 200px;"
                autocomplete="off"
              >
            </div>
            <button type="submit" class="btn btn-primary px-4 shadow-sm">
              <i class="fas fa-search me-1"></i> {{ __('Cari') }}
            </button>
            <a href="{{ route('lebar-roll.index') }}" class="btn btn-outline-secondary px-4 shadow-sm">
              <i class="fas fa-sync-alt me-1"></i> {{ __('Reset') }}
            </a>
          </form>
        </div>
      </div>

      <div class="table-responsive shadow rounded-3">
        <table class="table align-middle table-row-dashed table-row-bordered gy-5 gs-7 fs-6" style="background-color: #fff;">
            <thead>
                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                    <th class="min-w-50px">{{ __('No') }}</th>
                    <th class="min-w-200px">{{ __('Nama Lebar') }}</th>
                    <th class="min-w-100px">{{ __('Tanggal Dibuat') }}</th>
                    <th class="min-w-125px">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody class="text-gray-900 fw-semibold">
                @forelse ($lebar as $index => $item)
                    <tr>
                        <td class="text-gray-800 bold">{{ $lebar->firstItem() + $index }}</td>
                        <td class="text-gray-800 fw-semibold">{{ $item->name }}</td>
                        <td class="text-gray-800 fw-semibold">{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i') }}</td>
                        <td>
                            <button type="button" class="btn btn-outline-warning btn-sm d-flex align-items-center gap-1 shadow-sm mt-1" 
                                    onclick="editLebar({{ $item->id }}, '{{ $item->name }}')" title="Edit Lebar">
                                <i class="fas fa-edit"></i>
                                <span>Edit</span>
                            </button>
                            <form action="{{ route('lebar-roll.destroy', $item->id) }}" method="POST" class="d-inline" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm d-flex align-items-center gap-1 shadow-sm mt-1" 
                                        title="Hapus Lebar">
                                    <i class="fas fa-trash"></i>
                                    <span>Hapus</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <p>Tidak ada data lebar</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($lebar->hasPages())
        <div class="mt-3">
            {{ $lebar->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    @endif

      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>

<!-- Modal Tambah Lebar -->
<div class="modal fade" id="addLebarModal" tabindex="-1" role="dialog" aria-labelledby="addLebarModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLebarModalLabel">Tambah Data Lebar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('lebar-roll.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama Lebar <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Lebar -->
<div class="modal fade" id="editLebarModal" tabindex="-1" role="dialog" aria-labelledby="editLebarModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLebarModalLabel">Edit Data Lebar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editLebarForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_name">Nama Lebar <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('javascripts')
<script type="text/javascript">
    function editLebar(id, name) {
        $('#edit_name').val(name);
        $('#editLebarForm').attr('action', '/lebar-roll/' + id);
        $('#editLebarModal').modal('show');
    }
</script>
@endsection
