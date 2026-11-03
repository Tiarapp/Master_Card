<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>

@extends('admin.templates.partials.default')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Mutasi Palet</h1>
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
        <a href="{{ route('palet_mutasi.create') }}" class="btn btn-success">
          <i class="fas fa-arrow-down"></i> Catat Palet Masuk (dari Customer)
        </a>
        <a href="{{ route('palet_mutasi.internal.create') }}" class="btn btn-outline-primary ml-1">
          <i class="fas fa-exchange-alt"></i> Catat Mutasi Internal
        </a>
        <small class="text-muted ml-2">Palet keluar customer tercatat otomatis dari SJ Palet.</small>
      </div>

      <form method="GET" action="{{ route('palet_mutasi') }}" class="form-inline mb-3">
        <select name="kategori" class="form-control mr-2 mb-2">
          <option value="">Semua kategori</option>
          <option value="customer" {{ request('kategori') === 'customer' ? 'selected' : '' }}>Customer</option>
          <option value="internal" {{ request('kategori') === 'internal' ? 'selected' : '' }}>Internal</option>
        </select>
        <input type="text" name="customer" class="form-control mr-2 mb-2" placeholder="Cari customer / internal" value="{{ request('customer') }}">
        <select name="jenis" class="form-control mr-2 mb-2">
          <option value="">Semua jenis</option>
          <option value="keluar" {{ request('jenis') === 'keluar' ? 'selected' : '' }}>Keluar</option>
          <option value="masuk" {{ request('jenis') === 'masuk' ? 'selected' : '' }}>Masuk</option>
        </select>
        <input type="date" name="start_date" class="form-control mr-2 mb-2" value="{{ request('start_date') }}" title="Tanggal mulai">
        <input type="date" name="end_date" class="form-control mr-2 mb-2" value="{{ request('end_date') }}" title="Tanggal akhir">
        <button type="submit" class="btn btn-primary mr-2 mb-2">Cari</button>
        <a href="{{ route('palet_mutasi') }}" class="btn btn-outline-secondary mr-2 mb-2">Reset</a>
        <a href="{{ route('palet_mutasi.export', request()->only(['customer', 'start_date', 'end_date'])) }}" class="btn btn-outline-success mb-2">
          <i class="fas fa-file-excel"></i> Export Palet Masuk
        </a>
      </form>

      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h3 class="card-title">Rekap Mutasi Palet Bulanan</h3>
          <form method="GET" action="{{ route('palet_mutasi') }}" class="form-inline">
            @foreach (request()->only(['kategori', 'customer', 'jenis', 'start_date', 'end_date']) as $key => $value)
              <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
            <label for="bulan" class="mr-2">Bulan</label>
            <input type="month" name="bulan" id="bulan" class="form-control form-control-sm mr-2" value="{{ $bulan }}">
            <button type="submit" class="btn btn-primary btn-sm">Tampilkan</button>
          </form>
        </div>
        <div class="card-body">
          <p class="text-muted mb-2">
            Periode {{ \Carbon\Carbon::parse($tanggalMulai)->format('d-m-Y') }}
            s.d. {{ \Carbon\Carbon::parse($tanggalAkhir)->format('d-m-Y') }}.
            Saldo customer tidak termasuk saldo awal gudang.
          </p>
          @unless ($tanggalSaldoAwal)
            <div class="alert alert-warning">
              Saldo awal gudang belum dicatat. Catat transaksi <strong>Saldo Awal</strong> per tipe palet
              pada tanggal 1 bulan mulai perhitungan agar saldo akhir dapat dihitung dengan benar.
            </div>
          @endunless
          @if ($tanggalSaldoAwal && $tanggalSaldoAwal > $tanggalMulai)
            <div class="alert alert-warning">
              Saldo awal baru tercatat pada {{ \Carbon\Carbon::parse($tanggalSaldoAwal)->format('d-m-Y') }}.
              Rekap bulan ini belum dapat dihitung dari saldo awal tersebut.
            </div>
          @endif
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-bordered table-sm mb-0">
            <thead>
              <tr>
                <th>Palet</th>
                <th>Ukuran</th>
                <th class="text-right">Saldo Awal</th>
                <th class="text-right">Pembelian</th>
                <th class="text-right">Pengembalian dari Customer</th>
                <th class="text-right">Pemakaian</th>
                <th class="text-right">Pengeluaran ke Customer</th>
                <th class="text-right">Retur Pemakaian</th>
                <th class="text-right">Retur Beli</th>
                <th class="text-right">Saldo Akhir</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($saldoInternal as $row)
                <tr>
                  <td>{{ $row->palet }}</td>
                  <td>{{ $row->ukuran }}</td>
                  <td class="text-right">{{ number_format($row->saldo_awal) }}</td>
                  <td class="text-right">{{ number_format($row->pembelian) }}</td>
                  <td class="text-right">{{ number_format($row->pengembalian_customer) }}</td>
                  <td class="text-right">{{ number_format($row->pemakaian) }}</td>
                  <td class="text-right">{{ number_format($row->pengeluaran_customer) }}</td>
                  <td class="text-right">{{ number_format($row->retur_pemakaian) }}</td>
                  <td class="text-right">{{ number_format($row->retur_beli) }}</td>
                  <td class="text-right font-weight-bold {{ $row->saldo_akhir < 0 ? 'text-danger' : '' }}">{{ number_format($row->saldo_akhir) }}</td>
                </tr>
              @empty
                <tr><td colspan="10" class="text-center text-muted">Belum ada data palet.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

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
                <th>Kategori</th>
                <th>Transaksi</th>
                <th>Jenis</th>
                <th>Customer / Tujuan</th>
                <th>Jenis Palet</th>
                <th>Palet</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Bagus</th>
                <th class="text-right">Jelek</th>
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
                  <td>{{ $row->kategori === 'internal' ? 'Internal' : 'Customer' }}</td>
                  <td>
                    @switch($row->sumber)
                      @case('pembelian') Pembelian @break
                      @case('retur_pemakaian') Retur Pemakaian @break
                      @case('pemakaian') Pemakaian @break
                      @case('saldo_awal') Saldo Awal @break
                      @case('retur_beli') Retur Beli @break
                      @case('sj_palet') SJ Palet @break
                      @case('pengembalian_customer') Pengembalian dari Customer @break
                      @default -
                    @endswitch
                  </td>
                  <td>
                    <span class="badge {{ $row->jenis === 'keluar' ? 'badge-danger' : 'badge-success' }}">
                      {{ $row->jenis === 'keluar' ? 'Keluar' : 'Masuk' }}
                    </span>
                  </td>
                  <td>{{ $row->kategori === 'internal' ? 'Internal' : $row->namaCustomer }}</td>
                  <td>{{ $row->jenisPalet ?? '-' }}</td>
                  <td>{{ $row->palet }} {{ $row->ukuran }}</td>
                  <td class="text-right">{{ number_format($row->qty) }}</td>
                  <td class="text-right">{{ $row->qty_bagus !== null ? number_format($row->qty_bagus) : '-' }}</td>
                  <td class="text-right">{{ $row->qty_jelek !== null ? number_format($row->qty_jelek) : '-' }}</td>
                  <td>{{ $row->noDokumen }}</td>
                  <td>{{ $row->noPolisi }}</td>
                  <td>{{ $row->keterangan }}</td>
                  <td>{{ $row->createdBy }}</td>
                  <td>
                    @if ($row->internal_master_id)
                      <div class="d-flex">
                        <a href="{{ route('palet_mutasi.internal.edit', $row->internal_master_id) }}" class="btn btn-outline-primary btn-sm mr-1">Edit</a>
                        <form action="{{ route('palet_mutasi.internal.destroy', $row->internal_master_id) }}" method="POST" onsubmit="return confirm('Hapus catatan ini?')">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                        </form>
                      </div>
                    @elseif ($row->mutasi_id && $row->kategori === 'internal')
                      <span class="text-muted small">catatan internal lama</span>
                    @elseif ($row->mutasi_id)
                      <div class="d-flex">
                        <a href="{{ route('palet_mutasi.edit', $row->mutasi_id) }}" class="btn btn-outline-primary btn-sm mr-1">Edit</a>
                        <form action="{{ route('palet_mutasi.destroy', $row->mutasi_id) }}" method="POST" onsubmit="return confirm('Hapus catatan ini?')">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                        </form>
                      </div>
                    @else
                      <span class="text-muted small">dari SJ Palet</span>
                    @endif
                  </td>
                </tr>
              @empty
                <tr><td colspan="15" class="text-center text-muted">Belum ada catatan.</td></tr>
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
