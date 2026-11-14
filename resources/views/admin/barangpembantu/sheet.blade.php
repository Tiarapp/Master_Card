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
      <form method="GET" action="{{ route('fb.list.bp_sheet') }}" id="sheet-filter-form">
        <div class="mb-2">
          <button type="submit" class="btn btn-primary btn-sm" disabled>Terapkan Filter</button>
          <a href="{{ route('fb.list.bp_sheet') }}" class="btn btn-outline-secondary btn-sm">Hapus Semua Filter</a>
        </div>
        <div class="alert alert-danger d-none" id="sheet-filter-error" role="alert"></div>
        <div class="small text-muted" id="sheet-search-status" aria-live="polite"></div>
        <noscript><div class="alert alert-warning">Aktifkan JavaScript untuk menggunakan filter.</div></noscript>
      </form>
      <div class="card-body table-responsive p-0">
        <table class="table table-bordered table-hover mb-0">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Kode</th>
              @foreach (['nama' => 'Nama', 'saldo_primer' => 'Saldo Primer', 'saldo_sekunder' => 'Saldo Sekunder'] as $filterKey => $filterLabel)
                @if ($filterKey === 'saldo_primer')
                  <th scope="col">Satuan Primer</th>
                  <th scope="col">Satuan Sekunder</th>
                  <th scope="col">Berat std</th>
                @endif
                <th scope="col">
                  {{ $filterLabel }}
                  <div class="dropdown d-inline-block sheet-filter" data-filter="{{ $filterKey }}">
                    <button class="btn btn-sm {{ isset($filters[$filterKey]) || isset($searches[$filterKey]) ? 'btn-primary' : 'btn-outline-secondary' }} dropdown-toggle"
                            type="button" data-toggle="dropdown" aria-label="Filter {{ $filterLabel }}" aria-expanded="false">
                      <i class="fas fa-filter"></i>
                    </button>
                    <div class="dropdown-menu p-2" style="min-width: 260px; max-width: 350px;">
                      <input type="search" class="form-control form-control-sm mb-2 filter-search" name="search[{{ $filterKey }}]" form="sheet-filter-form" maxlength="200" value="{{ $searches[$filterKey] ?? '' }}" placeholder="Cari nilai..." aria-label="Cari nilai {{ $filterLabel }}">
                      <small class="text-muted d-block mb-2">Pencarian langsung memperbarui tabel.</small>
                      <label class="d-block mb-1"><input type="checkbox" class="filter-all"> Pilih semua nilai yang terlihat</label>
                      <div class="filter-options" style="max-height: 240px; overflow-y: auto;">
                        @foreach ($filterOptions[$filterKey] as $option)
                          @php
                            $value = $option === null ? null : (string) $option;
                            $filter = $filters[$filterKey] ?? null;
                            $selected = $filter === null || (($filter['mode'] === 'include') === in_array($value, $filter['values'], true));
                          @endphp
                          <label class="d-block filter-option">
                            <input type="checkbox" class="filter-value" value="{{ json_encode($value) }}" {{ $selected ? 'checked' : '' }}>
                            <span>{{ $value === null ? '(Kosong)' : ($filterKey === 'nama' ? $value : number_format((float) $value, $filterKey === 'saldo_primer' ? 0 : 2)) }}</span>
                          </label>
                        @endforeach
                      </div>
                    </div>
                  </div>
                </th>
              @endforeach
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
    var originalFilters = @json($filters);
    var searchTimer;
    var searchRequest;
    var searchVersion = 0;
    $('#sheet-filter-form button[type=submit]').prop('disabled', false);
    $('.sheet-filter .dropdown-menu').on('click', function (event) {
      event.stopPropagation();
    });

    function updateSelectAll(filter) {
      var visible = filter.find('.filter-option:visible .filter-value');
      var checked = visible.filter(':checked').length;
      filter.find('.filter-all').prop('checked', visible.length > 0 && checked === visible.length)
        .prop('indeterminate', checked > 0 && checked < visible.length);
    }

    $('.sheet-filter').each(function () {
      updateSelectAll($(this));
    }).on('shown.bs.dropdown', function () {
      updateSelectAll($(this));
    });
    function filterOptions(input) {
      var filter = input.closest('.sheet-filter');
      var text = input.val().toLocaleLowerCase();
      filter.find('.filter-option').each(function () {
        $(this).toggle($(this).find('span').text().toLocaleLowerCase().indexOf(text) !== -1);
      });
      updateSelectAll(filter);
    }

    $('.filter-search').each(function () {
      filterOptions($(this));
    }).on('input', function () {
      filterOptions($(this));
      clearTimeout(searchTimer);
      if (searchRequest) searchRequest.abort();
      var version = ++searchVersion;
      $('#sheet-filter-error').addClass('d-none').text('');
      $('#sheet-search-status').text('Mencari data...');
      searchTimer = setTimeout(function () {
        var params = new URLSearchParams(window.location.search);
        params.delete('page');
        $('.filter-search').each(function () {
          var name = this.name;
          params.delete(name);
          if (this.value !== '') params.set(name, this.value);
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
            $('.sheet-filter').each(function () {
              var active = Boolean(originalFilters[$(this).attr('data-filter')]) || $(this).find('.filter-search').val() !== '';
              $(this).find('button.dropdown-toggle').toggleClass('btn-primary', active).toggleClass('btn-outline-secondary', !active);
            });
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
    $('.filter-all').on('change', function () {
      var filter = $(this).closest('.sheet-filter');
      filter.attr('data-dirty', '1');
      filter.find('.filter-option:visible .filter-value').prop('checked', this.checked);
      updateSelectAll(filter);
    });
    $('.filter-value').on('change', function () {
      var filter = $(this).closest('.sheet-filter').attr('data-dirty', '1');
      updateSelectAll(filter);
    });
    $('#sheet-filter-form').on('submit', function (event) {
      var form = $(this);
      clearTimeout(searchTimer);
      searchVersion++;
      if (searchRequest) searchRequest.abort();
      form.find('.generated-filter').remove();
      $('.sheet-filter').each(function () {
        var key = $(this).attr('data-filter');
        if ($(this).attr('data-dirty') !== '1') {
          var original = originalFilters[key];
          if (original) {
            $('<input>', { type: 'hidden', name: 'filters[' + key + '][mode]', value: original.mode, class: 'generated-filter' }).appendTo(form);
            original.values.forEach(function (value) {
              $('<input>', { type: 'hidden', name: 'filters[' + key + '][values][]', value: JSON.stringify(value), class: 'generated-filter' }).appendTo(form);
            });
          }
          return;
        }
        var options = $(this).find('.filter-value');
        var unchecked = options.not(':checked');
        if (!unchecked.length) return;
        var checked = options.filter(':checked');
        var useInclude = checked.length <= unchecked.length;
        $('<input>', { type: 'hidden', name: 'filters[' + key + '][mode]', value: useInclude ? 'include' : 'exclude', class: 'generated-filter' }).appendTo(form);
        (useInclude ? checked : unchecked).each(function () {
          $('<input>', { type: 'hidden', name: 'filters[' + key + '][values][]', value: this.value, class: 'generated-filter' }).appendTo(form);
        });
      });
      if (form.find('.generated-filter').length > 900 || form.serialize().length > 6000) {
        event.preventDefault();
        $('#sheet-filter-error').text('Terlalu banyak nilai dipilih untuk dikirim. Kurangi pilihan filter atau gunakan filter lain terlebih dahulu.').removeClass('d-none');
      }
    });
  });
  $(document).on("click", '.mutasi', function() {
    document.getElementById("kodebarang").value = $(this).val();
  });
</script>
@endsection
