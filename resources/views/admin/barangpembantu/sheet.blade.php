<!-- jQuery -->
<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>
@extends('admin.templates.partials.default')


@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Barang Sheet BP Converting</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Barang Sheet BP</li>
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

      <div class="card-body table-responsive p-0">
        <table class="table table-bordered table-hover mb-0">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Kode</th>
              <th scope="col">Nama</th>
              <th scope="col">Satuan Primer</th>
              <th scope="col">Satuan Sekunder</th>
              <th scope="col">Berat std</th>
              <th scope="col">Saldo Primer</th>
              <th scope="col">Saldo Sekunder</th>
              <th scope="col">Last Mutasi</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($barang as $index => $item)
              <tr>
                <td>{{ $barang->firstItem() + $index }}</td>
                <td>{{ $item->KodeBrg }}</td>
                <td>{{ $item->NamaBrg }}</td>
                <td>{{ $item->SatuanP }}</td>
                <td>{{ $item->SatuanS }}</td>
                <td>{{ number_format($item->NilaiKonversi, 2) }}</td>
                <td>{{ number_format($item->SaldoPrimer, 0) }}</td>
                <td>{{ number_format($item->SaldoSekunder, 2) }}</td>
                <td>{{ $lastMutasi[$item->KodeBrg] ?? '-' }}</td>
                <td>
                  <button type="button" class="btn btn-primary mutasi" data-toggle="modal" data-target="#mutasiModalBpSheet" value="{{ $item->KodeBrg }}">
                    Cek Mutasi
                  </button>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="10" class="text-center">Data tidak ditemukan.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="card-footer clearfix">
        {{ $barang->links('pagination::bootstrap-4') }}
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>

  <div class="modal fade" id="mutasiModalBpSheet" tabindex="-1" role="dialog" aria-labelledby="mutasiModalBpSheetLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="mutasiModalBpSheetLabel">Cek Mutasi</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('fb.bp.mutasi') }}" method="POST">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="periode">Periode</label>
              <input type="text" name="periode" id="periode" class="form-control" placeholder="mm/yyyy" required>
            </div>
            <input type="hidden" name="kodebarang" id="kodebarang">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Lihat Mutasi</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- /.content -->
  @endsection

@section('javascripts')
<script>
  $(document).on("click", '.mutasi', function() {
    document.getElementById("kodebarang").value = $(this).val();
  });
</script>
@endsection
