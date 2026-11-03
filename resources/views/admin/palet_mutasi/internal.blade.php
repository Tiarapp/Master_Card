<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>

@extends('admin.templates.partials.default')

@section('content')
@php
  $isEditing = isset($mutasi);
  $previousDetails = old('details');
  if ($previousDetails === null) {
      $previousDetails = $details->map(function ($detail) {
          return [
              'item_palet_id' => $detail->item_palet_id,
              'qty' => $detail->qty,
          ];
      })->all();
  }
@endphp
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">{{ $isEditing ? 'Edit Mutasi Palet Internal' : 'Catat Mutasi Palet Internal' }}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('palet_mutasi') }}">Mutasi Palet</a></li>
            <li class="breadcrumb-item active">{{ $isEditing ? 'Edit Internal' : 'Tambah Internal' }}</li>
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

      <form action="{{ $isEditing ? route('palet_mutasi.internal.update', $mutasi->id) : route('palet_mutasi.internal.store') }}" method="POST">
        @csrf
        @if ($isEditing)
          @method('PUT')
        @endif
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Master Mutasi Internal</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Tanggal</label>
                  <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $isEditing ? \Carbon\Carbon::parse($mutasi->tanggal)->format('Y-m-d') : now()->toDateString()) }}" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Jenis Transaksi</label>
                  <select name="sumber" class="form-control" required>
                    <option value="">-- Pilih Transaksi --</option>
                    <option value="saldo_awal" {{ old('sumber', $isEditing ? $mutasi->sumber : '') === 'saldo_awal' ? 'selected' : '' }}>Saldo Awal (stok gudang)</option>
                    <option value="pembelian" {{ old('sumber', $isEditing ? $mutasi->sumber : '') === 'pembelian' ? 'selected' : '' }}>Pembelian (barang masuk)</option>
                    <option value="retur_pemakaian" {{ old('sumber', $isEditing ? $mutasi->sumber : '') === 'retur_pemakaian' ? 'selected' : '' }}>Retur Pemakaian (barang masuk)</option>
                    <option value="pemakaian" {{ old('sumber', $isEditing ? $mutasi->sumber : '') === 'pemakaian' ? 'selected' : '' }}>Pemakaian (barang keluar)</option>
                    <option value="retur_beli" {{ old('sumber', $isEditing ? $mutasi->sumber : '') === 'retur_beli' ? 'selected' : '' }}>Retur Beli (barang keluar)</option>
                  </select>
                  <small class="form-text text-muted">
                    Saldo awal dicatat satu kali, tanggal 1 bulan mulai perhitungan, untuk stok fisik gudang saja (tidak termasuk palet di customer).
                  </small>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Detail Mutasi</h3>
            <button type="button" class="btn btn-outline-primary btn-sm" id="addDetail">Tambah Baris</button>
          </div>
          <div class="card-body table-responsive">
            <table class="table table-bordered table-sm">
              <thead>
                <tr>
                  <th style="min-width: 340px;">Tipe Palet</th>
                  <th style="width: 180px;">Qty</th>
                  <th style="width: 100px;">Aksi</th>
                </tr>
              </thead>
              <tbody id="detailRows"></tbody>
            </table>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-success">{{ $isEditing ? 'Simpan Perubahan' : 'Simpan Mutasi' }}</button>
            <a href="{{ route('palet_mutasi') }}" class="btn btn-outline-secondary">Batal</a>
          </div>
        </div>
      </form>
    </div>
  </section>
</div>
@endsection

@section('javascripts')
<script>
  $(document).ready(function() {
    const palets = @json($palets);
    const previousDetails = @json($previousDetails);
    let nextIndex = 0;

    function makeRow(detail) {
      const index = nextIndex++;
      const row = $('<tr>');
      const paletSelect = $('<select class="form-control" required>')
        .attr('name', 'details[' + index + '][item_palet_id]')
        .append($('<option>').val('').text('-- Pilih Tipe Palet --'));
      const qty = $('<input type="number" min="1" class="form-control" required>')
        .attr('name', 'details[' + index + '][qty]');

      palets.forEach(function(palet) {
        paletSelect.append($('<option>')
          .val(palet.id)
          .text(palet.nama + ' - ' + palet.ukuran));
      });

      row.append($('<td>').append(paletSelect));
      row.append($('<td>').append(qty));
      row.append($('<td class="text-center">').append(
        $('<button type="button" class="btn btn-outline-danger btn-sm remove-detail">Hapus</button>')
      ));
      $('#detailRows').append(row);

      if (detail) {
        paletSelect.val(detail.item_palet_id);
        qty.val(detail.qty);
      }
    }

    $('#addDetail').on('click', function() {
      makeRow();
    });

    $('#detailRows').on('click', '.remove-detail', function() {
      if ($('#detailRows tr').length === 1) {
        const row = $(this).closest('tr');
        row.find('select').val('');
        row.find('input').val('');
        return;
      }
      $(this).closest('tr').remove();
    });

    if (previousDetails.length) {
      previousDetails.forEach(function(detail) { makeRow(detail); });
    } else {
      makeRow();
    }
  });
</script>
@endsection
