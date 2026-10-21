<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>

@extends('admin.templates.partials.default')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Mutasi Palet Customer</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Mutasi Palet</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>{{ $message }}</strong>
        </div>
      @endif

      <div class="mb-3">
        <a href="{{ route('palet_mutasi.create', ['jenis' => 'keluar']) }}" class="btn btn-danger">
          <i class="fas fa-arrow-up"></i> Palet Keluar (ke Customer)
        </a>
        <a href="{{ route('palet_mutasi.create', ['jenis' => 'masuk']) }}" class="btn btn-success">
          <i class="fas fa-arrow-down"></i> Palet Masuk (dari Customer)
        </a>
      </div>

      <form method="GET" action="{{ route('palet_mutasi') }}" class="form-inline mb-3">
        <input type="text" name="customer" class="form-control mr-2 mb-2" placeholder="Cari customer" value="{{ request('customer') }}">
        <select name="jenis" class="form-control mr-2 mb-2">
          <option value="">Semua jenis</option>
          <option value="keluar" {{ request('jenis') === 'keluar' ? 'selected' : '' }}>Keluar</option>
          <option value="masuk" {{ request('jenis') === 'masuk' ? 'selected' : '' }}>Masuk</option>
        </select>
        <input type="date" name="start_date" class="form-control mr-2 mb-2" value="{{ request('start_date') }}" title="Tanggal mulai">
        <input type="date" name="end_date" class="form-control mr-2 mb-2" value="{{ request('end_date') }}" title="Tanggal akhir">
        <button type="submit" class="btn btn-primary mr-2 mb-2">Cari</button>
        <a href="{{ route('palet_mutasi') }}" class="btn btn-outline-secondary mb-2">Reset</a>
      </form>

      <div class="card">
        <div class="card-header"><h3 class="card-title">Saldo Palet di Customer</h3></div>
        <div class="card-body table-responsive p-0">
          <table class="table table-bordered table-sm mb-0">
            <thead>
              <tr>
                <th>Customer</th>
                <th>Palet</th>
                <th>Ukuran</th>
                <th class="text-right">Keluar</th>
                <th class="text-right">Masuk</th>
                <th class="text-right">Saldo (di customer)</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($saldo as $row)
                @php $sisa = $row->total_keluar - $row->total_masuk; @endphp
                <tr>
                  <td>{{ $row->namaCustomer }}</td>
                  <td>{{ $row->palet }}</td>
                  <td>{{ $row->ukuran }}</td>
                  <td class="text-right">{{ number_format($row->total_keluar) }}</td>
                  <td class="text-right">{{ number_format($row->total_masuk) }}</td>
                  <td class="text-right font-weight-bold {{ $sisa < 0 ? 'text-danger' : '' }}">{{ number_format($sisa) }}</td>
                </tr>
              @empty
                <tr><td colspan="6" class="text-center text-muted">Belum ada data.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <div class="card">
        <div class="card-header"><h3 class="card-title">Riwayat Mutasi</h3></div>
        <div class="card-body table-responsive p-0">
          <table class="table table-bordered table-sm mb-0">
            <thead>
              <tr>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Customer</th>
                <th>Palet</th>
                <th class="text-right">Qty</th>
                <th>No Dokumen</th>
                <th>No Polisi</th>
                <th>Keterangan</th>
                <th>Dicatat Oleh</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($mutasi as $row)
                <tr>
                  <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }}</td>
                  <td>
                    <span class="badge {{ $row->jenis === 'keluar' ? 'badge-danger' : 'badge-success' }}">
                      {{ $row->jenis === 'keluar' ? 'Keluar' : 'Masuk' }}
                    </span>
                  </td>
                  <td>{{ $row->namaCustomer }}</td>
                  <td>{{ optional($row->palet)->nama }} {{ optional($row->palet)->ukuran }}</td>
                  <td class="text-right">{{ number_format($row->qty) }}</td>
                  <td>{{ $row->noDokumen }}</td>
                  <td>{{ $row->noPolisi }}</td>
                  <td>{{ $row->keterangan }}</td>
                  <td>{{ $row->createdBy }}</td>
                  <td>
                    <form action="{{ route('palet_mutasi.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Hapus catatan ini?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                    </form>
                  </td>
                </tr>
              @empty
                <tr><td colspan="10" class="text-center text-muted">Belum ada catatan.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      {{ $mutasi->links('pagination::bootstrap-4') }}
    </div>
  </section>
</div>
@endsection
