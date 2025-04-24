<div class="modal fade" id="detail_mod">
    <div class="modal-dialog modal-large">
        
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Barang</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body customer">
                <form id="detail_form">
                    <div class="card-body">
                        <div class="col-md-12" data-toggle="tooltip" data-placement="right">
                            <div class="form-group">
                                <div class="row" style="margin: 10px">
                                    <div class="col-md-4">
                                        <label>BC Date</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="date" class="form-control txt_line" name="bc_date" id="bc_date" value="{{ $date }}">
                                    </div>
                                </div>
                                <div class="row" style="margin: 10px">
                                    <div class="col-md-4">
                                        <label>Kode Barang</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control txt_line" name="kode_barang" id="kode_barang" required>
                                    </div>
                                </div>
                                <div class="row" style="margin: 10px">
                                    <div class="col-md-4">
                                        <label>Nama Barang</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control txt_line" name="nama_barang" id="nama_barang" readonly>
                                    </div>
                                </div>
                                <div class="row" style="margin: 10px">
                                    <div class="col-md-4">
                                        <label>Qty</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="number" class="qty form-control txt_line" name="qty" id="qty" required>
                                    </div>
                                </div>
                                <div class="row" style="margin: 10px">
                                    <div class="col-md-4">
                                        <label>Harga Jual</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="harga form-control txt_line" name="harga" id="harga" required>
                                    </div>
                                </div>
                                <div class="row" style="margin: 10px">
                                    <div class="col-md-4">
                                        <label>Subtotal</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control txt_line" name="subtotal" id="subtotal_awal" readonly>
                                        <input type="text" class="form-control txt_line" name="ppn" id="ppn" readonly>
                                        <input type="text" class="form-control txt_line" name="subtotal_akhir" id="subtotal_akhir" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="save_detail btn btn-default" data-dismiss="modal">Simpan</button>
            </div>
        </div>
        
    </div>
</div>