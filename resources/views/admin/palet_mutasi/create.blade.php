<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css" />

@extends('admin.templates.partials.default')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Palet Masuk (dari Customer)</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('palet_mutasi') }}">Mutasi Palet</a></li>
            <li class="breadcrumb-item active">Tambah</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      @if ($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('palet_mutasi.store') }}" method="POST">
        @csrf
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Master Palet Masuk</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Customer</label>
                  <select name="namaCustomer" id="namaCustomer" class="form-control" required>
                    <option value="">-- Pilih Customer --</option>
                    @foreach ($customers as $customer)
                      <option value="{{ $customer->Nama }}" {{ old('namaCustomer') === $customer->Nama ? 'selected' : '' }}>
                        {{ $customer->Nama }}
                      </option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label>Tanggal Masuk</label>
                  <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', now()->toDateString()) }}" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>No. Polisi</label>
                  <input type="text" name="noPolisi" class="form-control" value="{{ old('noPolisi') }}" maxlength="100" required>
                </div>
                <div class="form-group">
                  <label>Jenis Palet</label>
                  <select name="jenisPalet" class="form-control" required>
                    <option value="">-- Pilih Jenis Palet --</option>
                    <option value="Kayu" {{ old('jenisPalet') === 'Kayu' ? 'selected' : '' }}>Kayu</option>
                    <option value="Plastik" {{ old('jenisPalet') === 'Plastik' ? 'selected' : '' }}>Plastik</option>
                  </select>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group mb-0">
                  <label>Keterangan</label>
                  <textarea name="keterangan" rows="2" class="form-control">{{ old('keterangan') }}</textarea>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Detail Palet Masuk</h3>
            <button type="button" class="btn btn-outline-primary btn-sm" id="addDetail">Tambah Baris</button>
          </div>
          <div class="card-body table-responsive">
            <table class="table table-bordered table-sm">
              <thead>
                <tr>
                  <th style="min-width: 340px;">Data Palet / SJ Keluar</th>
                  <th style="width: 140px;">Qty Bagus</th>
                  <th style="width: 140px;">Qty Jelek</th>
                  <th style="width: 100px;">Aksi</th>
                </tr>
              </thead>
              <tbody id="detailRows"></tbody>
            </table>
            <small class="text-muted">Jumlah bagus dan jelek tidak boleh melebihi sisa palet yang masih ada di customer.</small>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('palet_mutasi') }}" class="btn btn-outline-secondary">Batal</a>
          </div>
        </div>
      </form>
    </div>
  </section>
</div>
@endsection

@section('javascripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
  $(document).ready(function() {
    const optionsUrl = "{{ route('palet_mutasi.palet_options') }}";
    const previousDetails = @json(old('details', []));
    let availableItems = [];
    let nextIndex = 0;
    let optionsRequest = null;

    $('#namaCustomer').select2({ theme: 'bootstrap4', width: '100%' });

    function makeRow(detail) {
      const index = nextIndex++;
      const row = $('<tr>').attr('data-index', index);
      const source = $('<select class="form-control detail-source" required>')
        .append($('<option>').val('').text('-- Pilih Data Palet --'));
      const good = $('<input type="number" min="0" class="form-control qty-good" required>');
      const bad = $('<input type="number" min="0" class="form-control qty-bad" required>');

      row.append($('<td>').append(source)
        .append($('<input type="hidden" class="source-sj" name="details[' + index + '][sj_palet_m_id]">'))
        .append($('<input type="hidden" class="source-item" name="details[' + index + '][item_palet_id]">'))
        .append($('<small class="text-muted d-block source-balance">')));
      row.append($('<td>').append(good.attr('name', 'details[' + index + '][qty_bagus]')));
      row.append($('<td>').append(bad.attr('name', 'details[' + index + '][qty_jelek]')));
      row.append($('<td class="text-center">').append(
        $('<button type="button" class="btn btn-outline-danger btn-sm remove-detail">Hapus</button>')
      ));
      $('#detailRows').append(row);

      availableItems.forEach(function(item) {
        const value = item.sj_palet_m_id + '|' + item.item_palet_id;
        const label = item.noSuratJalan + ' (' + item.tanggal + ') - ' + item.nama + ' ' + item.ukuran +
          ' | Qty SJ: ' + item.qty + ' | Sisa: ' + item.sisa;
        source.append($('<option>').val(value).text(label).data('item', item));
      });

      if (detail) {
        const oldValue = detail.sj_palet_m_id + '|' + detail.item_palet_id;
        source.val(oldValue);
        good.val(detail.qty_bagus);
        bad.val(detail.qty_jelek);
        setSelectedSource(row, source.val());
      }
    }

    function setSelectedSource(row, value) {
      const selected = availableItems.find(function(item) {
        return value === item.sj_palet_m_id + '|' + item.item_palet_id;
      });
      row.find('.source-sj').val(selected ? selected.sj_palet_m_id : '');
      row.find('.source-item').val(selected ? selected.item_palet_id : '');
      row.find('.qty-good, .qty-bad').attr('max', selected ? selected.sisa : '');
      row.find('.source-balance').text(selected ? 'Sisa yang dapat diterima: ' + selected.sisa : '');
    }

    function loadPaletOptions(details) {
      $('#detailRows').empty();
      nextIndex = 0;
      availableItems = [];
      if (optionsRequest) {
        optionsRequest.abort();
      }
      if (!$('#namaCustomer').val()) {
        makeRow();
        return;
      }

      optionsRequest = $.getJSON(optionsUrl, { customer: $('#namaCustomer').val() })
        .done(function(items) {
          availableItems = items;
          if (details.length) {
            details.forEach(function(detail) { makeRow(detail); });
          } else {
            makeRow();
          }
        })
        .fail(function(xhr, status) {
          if (status === 'abort') {
            return;
          }
          $('#detailRows').empty();
          makeRow();
          window.alert('Data palet customer gagal dimuat. Silakan coba lagi.');
        });
    }

    $('#namaCustomer').on('change', function() {
      loadPaletOptions([]);
    });

    $('#addDetail').on('click', function() {
      makeRow();
    });

    $('#detailRows').on('change', '.detail-source', function() {
      setSelectedSource($(this).closest('tr'), $(this).val());
    });

    $('#detailRows').on('click', '.remove-detail', function() {
      const rows = $('#detailRows tr');
      if (rows.length === 1) {
        rows.find('select').val('');
        rows.find('.source-sj, .source-item, .qty-good, .qty-bad').val('');
        rows.find('.source-balance').text('');
        return;
      }
      $(this).closest('tr').remove();
    });

    if ($('#namaCustomer').val()) {
      loadPaletOptions(previousDetails);
    } else {
      makeRow();
    }
  });
</script>
@endsection
