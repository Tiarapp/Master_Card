<div class="modal fade" id="generateFirebirdModal" tabindex="-1" role="dialog" aria-labelledby="generateFirebirdTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="generateFirebirdTitle">Generate Barang ke Firebird</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" id="generate-firebird-form">
                @csrf
                <input type="hidden" name="generate_mastercard_id" id="generate-mastercard-id">
                <input type="hidden" name="confirmed_kode" id="generate-confirmed-kode">
                <input type="hidden" name="confirmed_nama" id="generate-confirmed-nama">
                <div class="modal-body">
                    <p>Kode: <strong id="generate-kode"></strong><br>Nama: <strong id="generate-nama"></strong></p>
                    <p class="text-muted">Komponen barang diambil dari kode Mastercard dan diperiksa terhadap master Firebird. Barang yang sudah ada tidak diubah.</p>
                    <div class="form-group">
                        <label for="generate-satuan">Satuan</label>
                        <select name="satuan" id="generate-satuan" class="form-control" required>
                            <option value="">Pilih satuan</option>
                            @foreach(['PCS', 'KG', 'SET', 'ROLL', 'BDL', 'CRT', 'SACK'] as $satuan)
                                <option value="{{ $satuan }}" {{ old('satuan') === $satuan ? 'selected' : '' }}>{{ $satuan }}</option>
                            @endforeach
                        </select>
                    </div>
                    @foreach(['isi' => 'Isi per Karton', 'berat' => 'Berat Standar', 'beratcrt' => 'Berat per CRT', 'hargajual' => 'Harga Jual Rupiah', 'hargausd' => 'Harga Jual USD'] as $field => $label)
                        <div class="form-group">
                            <label for="generate-{{ $field }}">{{ $label }}</label>
                            <input class="form-control" type="number" step="any" min="0" required
                                   name="{{ $field }}" id="generate-{{ $field }}" value="{{ old($field) }}">
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Generate Barang</button>
                </div>
            </form>
        </div>
    </div>
</div>
