
<div id="detail">
    <div class="col-md-8">
        <h2>Data Tabel</h2>
        <table id="detail_data" class="table table-bordered" id="data_mod" style="width: 100%">
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama</th>
                    <th>Crt</th>
                    <th>Ecr</th>
                    <th>Harga</th>
                    <th>Disc</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data akan diisi di sini melalui AJAX -->
            </tbody>
        </table>
    </div>

    <div class="nilai col-md-8">
        <div class="row">
            <div class="col-md-8">

            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-2">
                            <label>Gross</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control txt_line" name="gross" id="gross" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label>Potongan</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control txt_line" name="potongan" id="potongan" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label>Netto</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control txt_line" name="netto" id="netto" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label>PPN</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control txt_line" name="master_ppn" id="master_ppn" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label>PPH</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control txt_line" name="master_pph" id="master_pph" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label>Total</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control txt_line" name="total" id="total" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>