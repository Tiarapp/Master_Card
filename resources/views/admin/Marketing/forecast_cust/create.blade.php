<!-- jQuery -->
<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>
@extends('admin.templates.partials.default')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Tambah Forecast Tonase Customer</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Marketing</a></li>
              <li class="breadcrumb-item"><a href="{{ route('forecast.tonase.index') }}">Forecast Tonase</a></li>
              <li class="breadcrumb-item active">Tambah</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Error!</strong> Ada beberapa masalah dengan input Anda:
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Forecast Tonase</h3>
                </div>
                <form action="{{ route('forecast.tonase.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="customer_name">Customer <span class="text-danger">*</span></label>
                                    <input type="text" name="customer_name" id="customer_name" class="form-control" 
                                           value="{{ old('customer_name', $preCustomer ?? '') }}" placeholder="Masukkan nama customer" required>
                                    @error('customer_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sales_id">Sales <span class="text-danger">*</span></label>
                                    <select name="sales_id" id="sales_id" class="form-control select2" required>
                                        <option value="">Pilih Sales</option>
                                        @if(isset($sales))
                                            @foreach($sales as $sale)
                                                <option value="{{ $sale->id }}" 
                                                    {{ (old('sales_id', $preSalesId ?? '') == $sale->id) ? 'selected' : '' }}>
                                                    {{ $sale->nama }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('sales_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bulan">Bulan <span class="text-danger">*</span></label>
                                    <select name="bulan" id="bulan" class="form-control" required>
                                        <option value="">Pilih Bulan</option>
                                        <option value="1" {{ old('bulan') == '1' ? 'selected' : '' }}>Januari</option>
                                        <option value="2" {{ old('bulan') == '2' ? 'selected' : '' }}>Februari</option>
                                        <option value="3" {{ old('bulan') == '3' ? 'selected' : '' }}>Maret</option>
                                        <option value="4" {{ old('bulan') == '4' ? 'selected' : '' }}>April</option>
                                        <option value="5" {{ old('bulan') == '5' ? 'selected' : '' }}>Mei</option>
                                        <option value="6" {{ old('bulan') == '6' ? 'selected' : '' }}>Juni</option>
                                        <option value="7" {{ old('bulan') == '7' ? 'selected' : '' }}>Juli</option>
                                        <option value="8" {{ old('bulan') == '8' ? 'selected' : '' }}>Agustus</option>
                                        <option value="9" {{ old('bulan') == '9' ? 'selected' : '' }}>September</option>
                                        <option value="10" {{ old('bulan') == '10' ? 'selected' : '' }}>Oktober</option>
                                        <option value="11" {{ old('bulan') == '11' ? 'selected' : '' }}>November</option>
                                        <option value="12" {{ old('bulan') == '12' ? 'selected' : '' }}>Desember</option>
                                    </select>
                                    @error('bulan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tahun">Tahun <span class="text-danger">*</span></label>
                                    <select name="tahun" id="tahun" class="form-control" required>
                                        <option value="">Pilih Tahun</option>
                                        @for($year = date('Y'); $year <= date('Y') + 5; $year++)
                                            <option value="{{ $year }}" {{ old('tahun') == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endfor
                                    </select>
                                    @error('tahun')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="target_tonase">Target Tonase (Ton) <span class="text-danger">*</span></label>
                                    <input type="number" name="target_tonase" id="target_tonase" class="form-control" 
                                           value="{{ old('target_tonase') }}" step="0.01" min="0" required>
                                    @error('target_tonase')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" class="form-control" rows="3" 
                                              placeholder="Masukkan keterangan atau catatan tambahan...">{{ old('keterangan') }}</textarea>
                                    @error('keterangan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                                <a href="{{ route('forecast.tonase.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<!-- Select2 CSS -->
<link rel="stylesheet" href="{{ asset('asset/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

<!-- Select2 JS -->
<script src="{{ asset('asset/plugins/select2/js/select2.full.min.js') }}"></script>

<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({
        theme: 'bootstrap4',
        placeholder: 'Pilih Customer',
        allowClear: true
    });

    // Auto-populate month and year from periode input
    $('#periode').on('change', function() {
        let periode = $(this).val();
        if (periode) {
            let [year, month] = periode.split('-');
            $('#tahun').val(year);
            $('#bulan').val(parseInt(month));
        }
    });

    // Auto-populate periode from month and year
    $('#bulan, #tahun').on('change', function() {
        let bulan = $('#bulan').val();
        let tahun = $('#tahun').val();
        
        if (bulan && tahun) {
            let periode = tahun + '-' + String(bulan).padStart(2, '0');
            $('#periode').val(periode);
        }
    });

    // Calculate percentage on realisasi change
    $('#realisasi, #target_tonase').on('input', function() {
        let target = parseFloat($('#target_tonase').val()) || 0;
        let realisasi = parseFloat($('#realisasi').val()) || 0;
        
        if (target > 0) {
            let percentage = ((realisasi / target) * 100).toFixed(2);
            console.log('Percentage: ' + percentage + '%');
        }
    });

    // Form validation
    $('form').on('submit', function(e) {
        let isValid = true;
        let errors = [];

        // Validate customer
        if (!$('#customer_id').val()) {
            errors.push('Customer harus dipilih');
            isValid = false;
        }

        // Validate target tonase
        let targetTonase = parseFloat($('#target_tonase').val());
        if (!targetTonase || targetTonase <= 0) {
            errors.push('Target tonase harus lebih dari 0');
            isValid = false;
        }

        // Validate realisasi not greater than target if specified
        let realisasi = parseFloat($('#realisasi').val()) || 0;
        if (realisasi > targetTonase) {
            if (!confirm('Realisasi melebihi target tonase. Apakah Anda yakin ingin melanjutkan?')) {
                e.preventDefault();
                return false;
            }
        }

        if (!isValid) {
            e.preventDefault();
            alert('Error:\n' + errors.join('\n'));
        }
    });
});
</script>

@endsection