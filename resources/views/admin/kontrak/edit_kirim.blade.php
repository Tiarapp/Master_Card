<div class="modal fade" id="edit_kirim{{ $o->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Realisasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="jquery-val-form" action="{{ route('kontrak.edit_kirim', $o->id) }}" method="post">
        {{csrf_field()}}
        {{ method_field('PUT') }}
        <div class="modal-body">
          
            <input type="hidden" class="form-control" name="id" id="id" value="{{ $kontrak_D->kontrakm->id }}">
            
            <div class="mb-3">
              <label for="recipient-name" class="col-form-label">Tanggal Kirim:</label>
              <input type="date" class="form-control" name="tglKirim" id="tglKirim" value="{{ $o->tanggal_kirim }}" required>
            </div>
            <div class="mb-3">
              <label for="message-text" class="col-form-label">Jumlah Kirim:</label>
              <input type="number" class="form-control" name="jumlahKirim" id="jumlahKirim" value="{{ $o->qty_kirim }}" required>
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