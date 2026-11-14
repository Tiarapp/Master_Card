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

      @if ($errors->any())
        <div class="alert alert-danger">
          @foreach ($errors->all() as $error)<div>{{ $error }}</div>@endforeach
        </div>
      @endif
      <form method="GET" action="{{ route('fb.list.bp_sheet') }}" id="sheet-filter-form" class="mb-3">
        <div class="form-row align-items-end">
          @foreach (['nama' => 'Nama', 'saldo_primer' => 'Saldo Primer', 'saldo_sekunder' => 'Saldo Sekunder'] as $filterKey => $filterLabel)
            <div class="form-group col-md-3">
              <label for="sheet-search-{{ $filterKey }}">{{ $filterLabel }}</label>
              @if ($filterKey === 'saldo_primer')
                <select class="form-control sheet-search mb-1" name="search[saldo_primer_operator]" id="sheet-primer-operator" aria-label="Operator Saldo Primer">
                  @foreach (['contains' => 'Mengandung', 'eq' => 'Sama dengan (=)', 'ne' => 'Tidak sama dengan (≠)', 'gt' => 'Lebih besar dari (>)', 'gte' => 'Lebih besar atau sama dengan (≥)', 'lt' => 'Lebih kecil dari (<)', 'lte' => 'Lebih kecil atau sama dengan (≤)'] as $operator => $label)
                    <option value="{{ $operator }}" {{ ($searches['saldo_primer_operator'] ?? 'contains') === $operator ? 'selected' : '' }}>{{ $label }}</option>
                  @endforeach
                </select>
              @endif
              <input type="search" class="form-control sheet-search" id="sheet-search-{{ $filterKey }}"
                     name="search[{{ $filterKey }}]" maxlength="200" value="{{ $searches[$filterKey] ?? '' }}"
                     placeholder="Cari {{ $filterLabel }}">
            </div>
          @endforeach
          <div class="form-group col-md-3">
            <button type="submit" class="btn btn-primary">Cari</button>
            <a href="{{ route('fb.list.bp_sheet') }}" class="btn btn-outline-secondary">Reset</a>
          </div>
        </div>
        <small class="form-text text-muted">Tabel diperbarui saat mengetik atau setelah menekan Cari.</small>
        <small class="form-text text-muted">Perbandingan Saldo Primer menggunakan angka yang ditampilkan (dibulatkan). Masukkan angka tanpa pemisah ribuan.</small>
        <div class="alert alert-danger d-none" id="sheet-filter-error" role="alert"></div>
        <div class="small text-muted" id="sheet-search-status" aria-live="polite"></div>
      </form>
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
          <tbody id="sheet-results">
            @forelse($barang as $index => $item)
              <tr>
                <td>{{ $barang->firstItem() + $index }}</td>
                <td>{{ $item->KodeBrg }}</td>
                <td>{{ $item->NamaBrg }}</td>
                <td>{{ $item->SatuanP }}</td>
                <td>{{ $item->SatuanS }}</td>
                <td>{{ number_format($item->NilaiKonversi, 2) }}</td>
                <td>{{ $item->SaldoPrimer === null ? '(Kosong)' : number_format($item->SaldoPrimer, 0) }}</td>
                <td>{{ $item->SaldoSekunder === null ? '(Kosong)' : number_format($item->SaldoSekunder, 2) }}</td>
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

      <div class="card-footer clearfix" id="sheet-pagination">
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
  $(function () {
    var searchTimer;
    var searchRequest;
    var searchVersion = 0;
    function validatePrimer() {
      var value = $('#sheet-search-saldo_primer').val();
      var invalid = $('#sheet-primer-operator').val() !== 'contains' && value !== '' && !/^-?\d+(\.\d+)?$/.test(value);
      $('#sheet-search-saldo_primer')[0].setCustomValidity(invalid ? 'Masukkan angka tanpa pemisah ribuan; gunakan titik untuk desimal.' : '');
      return !invalid;
    }
    $('.sheet-search').on('input change', function () {
      clearTimeout(searchTimer);
      if (searchRequest) searchRequest.abort();
      var version = ++searchVersion;
      $('#sheet-filter-error').addClass('d-none').text('');
      if (!validatePrimer()) {
        $('#sheet-search-status').text('');
        $('#sheet-filter-error').text('Masukkan Saldo Primer berupa angka tanpa pemisah ribuan; gunakan titik untuk desimal.').removeClass('d-none');
        return;
      }
      $('#sheet-search-status').text('Mencari data...');
      searchTimer = setTimeout(function () {
        var params = new URLSearchParams();
        $('.sheet-search').each(function () {
          if (this.value !== '') params.set(this.name, this.value);
        });
        var query = params.toString();
        var url = $('#sheet-filter-form').attr('action') + (query ? '?' + query : '');
        searchRequest = $.ajax({ url: url, method: 'GET', dataType: 'html' })
          .done(function (html) {
            if (version !== searchVersion) return;
            var doc = new DOMParser().parseFromString(html, 'text/html');
            var results = doc.querySelector('#sheet-results');
            var pagination = doc.querySelector('#sheet-pagination');
            if (!results || !pagination) {
              $('#sheet-search-status').text('');
              $('#sheet-filter-error').text('Data tidak dapat diperbarui. Periksa sesi Anda dan coba lagi.').removeClass('d-none');
              return;
            }
            $('#sheet-results').html(results.innerHTML);
            $('#sheet-pagination').html(pagination.innerHTML);
            window.history.replaceState(null, '', url);
            $('#sheet-search-status').text('');
          })
          .fail(function (xhr, status) {
            if (status === 'abort' || version !== searchVersion) return;
            $('#sheet-search-status').text('');
            $('#sheet-filter-error').text('Pencarian gagal. Periksa koneksi dan coba lagi.').removeClass('d-none');
          });
      }, 400);
    });
    $('#sheet-filter-form').on('submit', function () {
      clearTimeout(searchTimer);
      searchVersion++;
      if (searchRequest) searchRequest.abort();
    });
  });
  $(document).on("click", '.mutasi', function() {
    document.getElementById("kodebarang").value = $(this).val();
  });
</script>
@endsection
