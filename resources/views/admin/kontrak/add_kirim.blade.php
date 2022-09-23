<div class="modal fade" id="add_kirim" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah DT & OPI</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="jquery-val-form" action="{{ route('kontrak.store_realisasi') }}" onsubmit="return validateForm()" method="post">
        {{csrf_field()}}
        <div class="modal-body">
          
            <input type="hidden" class="form-control" name="idkontrakm" id="idkontrakm" value="{{ $kontrak_D->kontrakm->id }}">
            
            <div class="mb-3">
              <label for="recipient-name" class="col-form-label">Tanggal Kirim:</label>
              <input type="date" class="form-control" name="tglKirim" id="tglKirim" required>
            </div>
            <div class="mb-3">
              <label for="message-text" class="col-form-label">Jumlah Kirim:</label>
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