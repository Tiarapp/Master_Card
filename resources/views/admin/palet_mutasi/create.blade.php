<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css" />

@extends('admin.templates.partials.default')

@section('content')
@php $isKeluar = $jenis === 'keluar'; @endphp
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">{{ $isKeluar ? 'Palet Keluar (ke Customer)' : 'Palet Masuk (dari Customer)' }}</h1>
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
        <input type="hidden" name="jenis" value="{{ $jenis }}">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Tanggal</label>
                  <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', now()->toDateString()) }}" required>
                </div>
                <div class="form-group">
                  <label>Customer</label>
                  <select name="namaCustomer" id="namaCustomer" class="form-control" required>
                    <option value="">-- Pilih Customer --</option>
                    @foreach ($customer as $nama)
                      <option value="{{ $nama }}" {{ old('namaCustomer') === $nama ? 'selected' : '' }}>{{ $nama }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label>Palet</label>
                  <select name="item_palet_id" class="form-control" required>
                    <option value="">-- Pilih Palet --</option>
                    @foreach ($palet as $item)
                      <option value="{{ $item->id }}" {{ (string) old('item_palet_id') === (string) $item->id ? 'selected' : '' }}>{{ $item->nama }} - {{ $item->ukuran }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label>Qty</label>
                  <input type="number" name="qty" min="1" class="form-control" value="{{ old('qty') }}" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>{{ $isKeluar ? 'No Surat Jalan / Dokumen' : 'No Dokumen Penerimaan' }}</label>
                  <input type="text" name="noDokumen" class="form-control" value="{{ old('noDokumen') }}">
                </div>
                <div class="form-group">
                  <label>No Polisi</label>
                  <input type="text" name="noPolisi" class="form-control" value="{{ old('noPolisi') }}">
                </div>
                <div class="form-group">
                  <label>Keterangan</label>
                  <textarea name="keterangan" rows="4" class="form-control">{{ old('keterangan') }}</textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn {{ $isKeluar ? 'btn-danger' : 'btn-success' }}">Simpan</button>
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
    $('#namaCustomer').select2({ theme: 'bootstrap4', width: '100%' });
  });
</script>
@endsection
