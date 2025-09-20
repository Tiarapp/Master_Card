<div class="modal fade" id="add_dt" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah DT & OPI</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="jquery-val-form" action="{{ route('kontrak.store_dt') }}" onsubmit="return validateForm()" method="post">
        {{csrf_field()}}
        <div class="modal-body">
          
            <input type="hidden" class="form-control" name="idkontrakm" id="idkontrakm" value="{{ $kontrak->kontrak_m_id }}">
            <input type="hidden" class="form-control" name="kode" id="kode" value="{{ $kontrak->kontrakm->kode }}">
            <div class="mb-3">
              <label for="recipient-name" class="col-form-label">No OPI</label>
              <input type="text" class="form-control" name="nomer_opi" id="nomer_opi" readonly required>
            </div>
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
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" >Save</button>
        </div>
      </form>
    </div>
  </div>
</div>