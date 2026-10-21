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
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Referensi SJ Palet</label>
                  <select name="sj_palet_m_id" id="sj_palet_m_id" class="form-control" required>
                    <option value="">-- Pilih SJ Palet --</option>
                    @foreach ($sjList as $sj)
                      <option value="{{ $sj->id }}" {{ (string) old('sj_palet_m_id') === (string) $sj->id ? 'selected' : '' }}>
                        {{ $sj->noSuratJalan }} - {{ $sj->namaCustomer }} ({{ \Carbon\Carbon::parse($sj->tanggal)->format('d-m-Y') }})
                      </option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label>Tanggal Masuk</label>
                  <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', now()->toDateString()) }}" required>
                </div>
                <div class="form-group">
                  <label>Customer</label>
                  <input type="text" id="namaCustomer" class="form-control" readonly>
                </div>

                <div class="form-group">
                  <label>Palet</label>
                  <select name="item_palet_id" id="item_palet_id" class="form-control" required>
                    <option value="">-- Pilih SJ terlebih dahulu --</option>
                  </select>
                  <small class="text-muted" id="infoSisa"></small>
                </div>
                <div class="form-group">
                  <label>Qty Masuk</label>
                  <input type="number" name="qty" min="1" class="form-control" value="{{ old('qty') }}" required>
                </div>

                <div class="form-group">
                  <label>Keterangan</label>
                  <textarea name="keterangan" rows="3" class="form-control">{{ old('keterangan') }}</textarea>
                </div>
              </div>
            </div>
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
    const oldItem = "{{ old('item_palet_id') }}";
    const detailUrl = "{{ url('/admin/palet_mutasi/sj') }}/";
    let items = [];

    $('#sj_palet_m_id').select2({ theme: 'bootstrap4', width: '100%' });

    function loadSj(id) {
      $('#namaCustomer').val('');
      if (!id) { return; }

      $.getJSON(detailUrl + id, function(sj) {
        items = sj.items;
        $('#namaCustomer').val(sj.namaCustomer || '');

        const select = $('#item_palet_id').empty().append('<option value="">-- Pilih Palet --</option>');
        items.forEach(function(i) {
          select.append($('<option>').val(i.item_palet_id).text(i.nama + ' - ' + i.ukuran + ' (SJ: ' + i.qty + ')'));
        });
        if (oldItem) { select.val(oldItem); }
        showSisa();
      });
    }

    function showSisa() {
      const item = items.find(function(i) { return String(i.item_palet_id) === $('#item_palet_id').val(); });
      $('#infoSisa').text(item ? 'Qty SJ: ' + item.qty + ' | Sudah dikembalikan: ' + item.dikembalikan + ' | Sisa: ' + (item.qty - item.dikembalikan) : '');
    }

    $('#sj_palet_m_id').on('change', function() { loadSj($(this).val()); });
    $('#item_palet_id').on('change', showSisa);

    if ($('#sj_palet_m_id').val()) { loadSj($('#sj_palet_m_id').val()); }
  });
</script>
@endsection
