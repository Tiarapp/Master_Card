<!-- MC Export Button Example -->
<!-- Add this to any mastercard view where you want to show export functionality -->

<div class="export-section mb-3">
    <form method="GET" action="{{ route('mastercard.export') }}" class="d-inline-block">
        <div class="row">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Search by kode/nama barang..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <input type="text" name="customer" class="form-control" placeholder="Customer..." value="{{ request('customer') }}">
            </div>
            <div class="col-md-3">
                <select name="tipeMc" class="form-control">
                    <option value="">Semua Tipe MC</option>
                    <option value="DC" {{ request('tipeMc') == 'DC' ? 'selected' : '' }}>DC</option>
                    <option value="B1" {{ request('tipeMc') == 'B1' ? 'selected' : '' }}>B1</option>
                    <option value="B3" {{ request('tipeMc') == 'B3' ? 'selected' : '' }}>B3</option>
                    <option value="SHEET" {{ request('tipeMc') == 'SHEET' ? 'selected' : '' }}>SHEET</option>
                    <option value="LAYER" {{ request('tipeMc') == 'LAYER' ? 'selected' : '' }}>LAYER</option>
                    <option value="SINGLEFACE" {{ request('tipeMc') == 'SINGLEFACE' ? 'selected' : '' }}>SINGLEFACE</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-file-excel"></i> Export Excel
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Simple Export Button (without filters) -->
<!-- <a href="{{ route('mastercard.export') }}" class="btn btn-success mb-3">
    <i class="fas fa-file-excel"></i> Export All MC Data
</a> -->