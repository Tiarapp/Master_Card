<div class="modal fade" id="add_dt" tabindex="-1" role="dialog" aria-labelledby="addDtModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addDtModalLabel">
          <i class="fas fa-plus-circle mr-2"></i>
          Tambah DT & OPI
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="jquery-val-form" action="{{ route('kontrak.store_dt') }}" onsubmit="return validateForm()" method="post">
        {{csrf_field()}}
        <div class="modal-body">
          
            <input type="hidden" class="form-control" name="idkontrakm" id="idkontrakm" value="{{ $kontrak->kontrak_m_id }}">
            <input type="hidden" class="form-control" name="kode" id="kode" value="{{ $kontrak->kontrakm->kode }}">
            <input type="text" class="form-control" name="cust" id="cust" value="{{ $kontrak->kontrakm->customer_name }}" readonly>
            <div class="mb-3">
              <label for="recipient-name" class="col-form-label">Sisa Kontrak :</label>
              <input type="text" class="form-control" name="sisa" id="sisa" value="{{ $kontrak->pcsSisaKontrak }}" readonly>
            </div>
            <div class="mb-3">
              <label for="recipient-name" class="col-form-label">Tanggal:</label>
              <input type="date" class="form-control" name="tglKirim" id="tglKirim" required>
            </div>
            <div class="mb-3">
              <label for="message-text" class="col-form-label">Jumlah Kirim:</label>
              <input type="hidden" class="form-control" name="sisaKontrak" id="sisaKontrak" value="{{ $kontrak->pcsSisaKontrak }}">
              <input type="number" class="form-control" name="jumlahKirim" id="jumlahKirim" required>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <i class="fas fa-times mr-1"></i>
            Batal
          </button>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save mr-1"></i>
            Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>