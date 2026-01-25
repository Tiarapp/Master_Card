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
            <h1 class="m-0">Import Forecast Tonase Customer</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Marketing</a></li>
              <li class="breadcrumb-item"><a href="{{ route('forecast.tonase.index') }}">Forecast Tonase</a></li>
              <li class="breadcrumb-item active">Import</li>
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
                    <strong>Error!</strong> Ada beberapa masalah:
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <!-- Import Card -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-upload"></i> Import Data Forecast
                            </h3>
                        </div>
                        <form action="{{ route('forecast.tonase.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="file">Pilih File Excel <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="file" class="custom-file-input" id="file" accept=".xlsx,.xls,.csv" required>
                                            <label class="custom-file-label" for="file">Pilih file...</label>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">
                                        Format yang didukung: .xlsx, .xls, .csv (Maksimal 2MB)
                                    </small>
                                </div>

                                <div class="alert alert-info">
                                    <h5><i class="icon fas fa-info"></i> Petunjuk Import:</h5>
                                    <ul class="mb-0">
                                        <li>File harus menggunakan template yang telah disediakan</li>
                                        <li>Pastikan format kolom sesuai dengan template</li>
                                        <li>Data yang sudah ada akan diupdate jika customer, bulan, dan tahun sama</li>
                                        <li>Sales name harus sesuai dengan data yang ada di sistem</li>
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-upload"></i> Import Data
                                </button>
                                <a href="{{ route('forecast.tonase.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Template Card -->
                <div class="col-md-4">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-download"></i> Download Template
                            </h3>
                        </div>
                        <div class="card-body">
                            <p>Download template Excel untuk memudahkan proses import data forecast tonase.</p>
                            
                            <div class="mb-3">
                                <strong>Template berisi:</strong>
                                <ul class="small">
                                    <li>customer_name</li>
                                    <li>sales_name</li>
                                    <li>bulan (1-12)</li>
                                    <li>tahun</li>
                                    <li>target_tonase</li>
                                    <li>keterangan</li>
                                </ul>
                            </div>

                            <a href="{{ route('forecast.tonase.template') }}" class="btn btn-success btn-block">
                                <i class="fas fa-file-excel"></i> Download Template Excel
                            </a>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">
                                Template sudah berisi contoh data yang dapat Anda gunakan sebagai referensi.
                            </small>
                        </div>
                    </div>

                    <!-- Preview Card -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-eye"></i> Format Template
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>customer_name</th>
                                            <th>sales_name</th>
                                            <th>bulan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>PT ABC</td>
                                            <td>John Doe</td>
                                            <td>1</td>
                                        </tr>
                                        <tr>
                                            <td>CV Platinum</td>
                                            <td>Jane Smith</td>
                                            <td>2</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <small class="text-muted">Contoh format data dalam template Excel</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
$(document).ready(function() {
    // Update file input label when file is selected
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
    });

    // Form validation
    $('form').on('submit', function(e) {
        let file = $('#file')[0].files[0];
        
        if (!file) {
            e.preventDefault();
            alert('Silakan pilih file terlebih dahulu');
            return false;
        }

        // Check file size (2MB = 2 * 1024 * 1024 bytes)
        if (file.size > 2 * 1024 * 1024) {
            e.preventDefault();
            alert('Ukuran file terlalu besar. Maksimal 2MB.');
            return false;
        }

        // Check file extension
        let allowedExtensions = ['xlsx', 'xls', 'csv'];
        let fileExtension = file.name.split('.').pop().toLowerCase();
        
        if (!allowedExtensions.includes(fileExtension)) {
            e.preventDefault();
            alert('Format file tidak didukung. Gunakan file .xlsx, .xls, atau .csv');
            return false;
        }

        // Show loading
        $(this).find('button[type="submit"]').html('<i class="fas fa-spinner fa-spin"></i> Importing...').prop('disabled', true);
    });
});
</script>

@endsection