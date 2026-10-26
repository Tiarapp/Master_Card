<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css" />

@extends('admin.templates.partials.default')

@section('content')
@php $isEditing = isset($mutasi); @endphp
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">{{ $isEditing ? 'Edit Palet Masuk' : 'Palet Masuk (dari Customer)' }}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('palet_mutasi') }}">Mutasi Palet</a></li>
            <li class="breadcrumb-item active">{{ $isEditing ? 'Edit' : 'Tambah' }}</li>
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

      <form action="{{ $isEditing ? route('palet_mutasi.update', $mutasi->id) : route('palet_mutasi.store') }}" method="POST">
        @csrf
        @if ($isEditing)
          @method('PUT')
        @endif
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">{{ $isEditing ? 'Edit Master Palet Masuk' : 'Master Palet Masuk' }}</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Customer</label>
                  <select name="namaCustomer" id="namaCustomer" class="form-control" required>
                    <option value="">-- Pilih Customer --</option>
                    @foreach ($customers as $customer)
                      <option value="{{ $customer->Nama }}" {{ old('namaCustomer', $isEditing ? $mutasi->namaCustomer : '') === $customer->Nama ? 'selected' : '' }}>
                        {{ $customer->Nama }}
                      </option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label>Tanggal Masuk</label>
                  <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $isEditing ? \Carbon\Carbon::parse($mutasi->tanggal)->format('Y-m-d') : now()->toDateString()) }}" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Kota</label>
                  <input type="text" name="noPolisi" class="form-control" value="{{ old('noPolisi', $isEditing ? $mutasi->noPolisi : '') }}" maxlength="100" required>
                </div>
                <div class="form-group">
                  <label>Jenis Palet</label>
                  <select name="jenisPalet" class="form-control" required>
                    <option value="">-- Pilih Jenis Palet --</option>
                    <option value="Kayu" {{ old('jenisPalet', $isEditing ? $mutasi->jenisPalet : '') === 'Kayu' ? 'selected' : '' }}>Kayu</option>
                    <option value="Plastik" {{ old('jenisPalet', $isEditing ? $mutasi->jenisPalet : '') === 'Plastik' ? 'selected' : '' }}>Plastik</option>
                  </select>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group mb-0">
                  <label>Keterangan</label>
                  <textarea name="keterangan" rows="2" class="form-control">{{ old('keterangan', $isEditing ? $mutasi->keterangan : '') }}</textarea>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Detail Palet Masuk</h3>
            @unless ($isEditing)
              <button type="button" class="btn btn-outline-primary btn-sm" id="addDetail">Tambah Baris</button>
            @endunless
          </div>
          <div class="card-body table-responsive">
            <table class="table table-bordered table-sm">
              <thead>
                <tr>
                  <th style="min-width: 340px;">Tipe Palet</th>
                  <th style="width: 140px;">Qty Bagus</th>
                  <th style="width: 140px;">Qty Jelek</th>
                  @unless ($isEditing)
                    <th style="width: 100px;">Aksi</th>
                  @endunless
                </tr>
              </thead>
              <tbody id="detailRows"></tbody>
            </table>
            <small class="text-muted">Pilih tipe palet dari master palet, lalu masukkan jumlah bagus dan jelek.</small>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-success">{{ $isEditing ? 'Simpan Perubahan' : 'Simpan' }}</button>
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
@php
  $previousDetails = old('details');
  if ($previousDetails === null && $isEditing) {
      $previousDetails = [[
          'item_palet_id' => old('item_palet_id', $mutasi->item_palet_id),
          'qty_bagus' => old('qty_bagus', $mutasi->qty_bagus ?? 0),
          'qty_jelek' => old('qty_jelek', $mutasi->qty_jelek ?? 0),
      ]];
  }
  $previousDetails = $previousDetails ?? [];
@endphp
<script>
  $(document).ready(function() {
    const palets = @json($palets);
    const isEditing = @json($isEditing);
    const previousDetails = @json($previousDetails);
    let nextIndex = 0;

    $('#namaCustomer').select2({ theme: 'bootstrap4', width: '100%' });

    function makeRow(detail) {
      const index = nextIndex++;
      const row = $('<tr>').attr('data-index', index);
      const paletName = isEditing ? 'item_palet_id' : 'details[' + index + '][item_palet_id]';
      const goodName = isEditing ? 'qty_bagus' : 'details[' + index + '][qty_bagus]';
      const badName = isEditing ? 'qty_jelek' : 'details[' + index + '][qty_jelek]';
      const paletSelect = $('<select class="form-control">').attr('name', paletName).prop('required', true)
        .append($('<option>').val('').text('-- Pilih Tipe Palet --'));
      const good = $('<input type="number" min="0" class="form-control qty-good" required>');
      const bad = $('<input type="number" min="0" class="form-control qty-bad" required>');

      row.append($('<td>').append(paletSelect));
      row.append($('<td>').append(good.attr('name', goodName)));
      row.append($('<td>').append(bad.attr('name', badName)));
      if (!isEditing) {
        row.append($('<td class="text-center">').append(
          $('<button type="button" class="btn btn-outline-danger btn-sm remove-detail">Hapus</button>')
        ));
      }
      $('#detailRows').append(row);

      palets.forEach(function(palet) {
        paletSelect.append($('<option>')
          .val(palet.id)
          .text(palet.nama + ' - ' + palet.ukuran));
      });

      if (detail) {
        paletSelect.val(detail.item_palet_id);
        good.val(detail.qty_bagus);
        bad.val(detail.qty_jelek);
      }
    }

    if (!isEditing) {
      $('#addDetail').on('click', function() {
        makeRow();
      });

      $('#detailRows').on('click', '.remove-detail', function() {
        const rows = $('#detailRows tr');
        if (rows.length === 1) {
          rows.find('select').val('');
          rows.find('.qty-good, .qty-bad').val('');
          return;
        }
        $(this).closest('tr').remove();
      });
    }

    if (previousDetails.length) {
      previousDetails.forEach(function(detail) { makeRow(detail); });
    } else {
      makeRow();
    }
  });
</script>
@endsection
