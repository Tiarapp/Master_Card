<div class="modal fade" id="edit_opi" tabindex="-1" role="dialog" aria-labelledby="editOpiModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-warning text-white">
        <h5 class="modal-title" id="editOpiModalLabel">
          <i class="fas fa-edit mr-2"></i>
          Edit Data OPI & DT
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="edit-opi-form" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="row">
            <!-- OPI Information -->
            <div class="col-md-6">
              <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                  <h6 class="mb-0">
                    <i class="fas fa-file-alt mr-1"></i>
                    Informasi OPI
                  </h6>
                </div>
                <div class="card-body">
                  <div class="form-group">
                    <label for="edit_noopi" class="form-label">
                      <i class="fas fa-hashtag mr-1"></i>
                      No OPI
                    </label>
                    <input type="text" class="form-control" id="edit_noopi" name="NoOPI" readonly>
                  </div>
                  
                  <div class="form-group">
                    <label for="edit_customer" class="form-label">
                      <i class="fas fa-building mr-1"></i>
                      Customer
                    </label>
                    <input type="text" class="form-control" id="edit_customer" readonly>
                  </div>
                  
                  <div class="form-group">
                    <label for="edit_namabarang" class="form-label">
                      <i class="fas fa-box mr-1"></i>
                      Nama Barang
                    </label>
                    <input type="text" class="form-control" id="edit_namabarang" readonly>
                  </div>
                  
                  <div class="form-group">
                    <label for="edit_jumlahorder" class="form-label">
                      <i class="fas fa-sort-numeric-up mr-1"></i>
                      Jumlah Order (Pcs) <span class="text-danger">*</span>
                    </label>
                    <input type="number" class="form-control" id="edit_jumlahorder" name="jumlahOrder" required min="1">
                    <small class="form-text text-muted">Masukkan jumlah order dalam pieces</small>
                  </div>
                  
                  <div class="form-group">
                    
                  </div>
                </div>
              </div>
            </div>
            
            <!-- DT Information -->
            <div class="col-md-6">
              <div class="card border-success">
                <div class="card-header bg-success text-white">
                  <h6 class="mb-0">
                    <i class="fas fa-truck mr-1"></i>
                    Informasi Delivery Time
                  </h6>
                </div>
                <div class="card-body">
                  <div class="form-group">
                    <label for="edit_tglkirim" class="form-label">
                      <i class="fas fa-calendar-alt mr-1"></i>
                      Tanggal Kirim <span class="text-danger">*</span>
                    </label>
                    <input type="date" class="form-control" id="edit_tglkirim" name="tglKirimDt" required>
                    <small class="form-text text-muted">Pilih tanggal pengiriman yang diinginkan</small>
                  </div>
                  
                  <div class="form-group">
                    <label for="edit_pcsdt" class="form-label">
                      <i class="fas fa-boxes mr-1"></i>
                      Quantity DT (Pcs) <span class="text-danger">*</span>
                    </label>
                    <input type="number" class="form-control" id="edit_pcsdt" name="pcsDt" required min="1">
                    <small class="form-text text-muted">Biasanya sama dengan jumlah order OPI</small>
                  </div>
                  
                  <div class="form-group">
                    <label class="form-label">
                      <i class="fas fa-info-circle mr-1"></i>
                      Status OPI
                    </label>
                    <input type="text" class="form-control" id="edit_status" readonly>
                  </div>

                  <div class="form-group">
                    <label for="edit_keterangan_opi" class="form-label">
                      <i class="fas fa-comment mr-1"></i>
                      Keterangan OPI
                    </label>
                    <textarea class="form-control" id="edit_keterangan_opi" name="keterangan" rows="3" placeholder="Tambahkan keterangan untuk OPI ini..."></textarea>
                  </div>
                  
                  <!-- Calculated Weight Display -->
                  <div class="alert alert-info">
                    <i class="fas fa-calculator mr-2"></i>
                    <strong>Info Kalkulasi:</strong>
                    <div class="mt-2">
                      <small>
                        <strong>Berat (Kg):</strong> <span id="calculated_weight">-</span><br>
                        <strong>Running Meter:</strong> <span id="calculated_rm">-</span>
                      </small>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Warning Alert -->
          <div class="alert alert-warning mt-3">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            <strong>Perhatian:</strong> 
            Pastikan data yang Anda ubah sudah benar. Perubahan akan mempengaruhi laporan dan kalkulasi terkait.
          </div>
        </div>
        
        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <i class="fas fa-times mr-1"></i>
            Batal
          </button>
          <button type="submit" class="btn btn-warning">
            <i class="fas fa-save mr-1"></i>
            Update Data
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
// Auto-sync quantity fields
document.addEventListener('DOMContentLoaded', function() {
    const jumlahOrderInput = document.getElementById('edit_jumlahorder');
    const pcsDtInput = document.getElementById('edit_pcsdt');
    
    // Sync PCS DT with Jumlah Order when changed
    jumlahOrderInput.addEventListener('input', function() {
        pcsDtInput.value = this.value;
        calculateWeight();
    });
    
    pcsDtInput.addEventListener('input', function() {
        calculateWeight();
    });
    
    function calculateWeight() {
        // This will be implemented with actual calculation logic
        // For now, just placeholder
        const qty = parseInt(jumlahOrderInput.value) || 0;
        document.getElementById('calculated_weight').textContent = (qty * 0.5).toFixed(2) + ' kg';
        document.getElementById('calculated_rm').textContent = (qty * 0.1).toFixed(2) + ' m';
    }
});
</script>