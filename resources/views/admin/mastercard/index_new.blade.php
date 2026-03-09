@extends('admin.templates.partials.default')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Mastercard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Mastercard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            
            <!-- Action Buttons -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <a href="{{ route('mastercard.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Tambah Mastercard
                    </a>
                </div>
                <div class="col-md-6">
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('mastercard.index_new') }}" class="d-flex">
                        <input type="text" name="search" class="form-control" placeholder="Cari kode, nama barang, kode barang, atau customer..." 
                               value="{{ request('search') }}">
                        <button type="submit" class="btn btn-outline-secondary ml-2">
                            <i class="fas fa-search"></i>
                        </button>
                        @if(request('search'))
                            <a href="{{ route('mastercard.index_new') }}" class="btn btn-outline-danger ml-2">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Data Table Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Mastercard</h3>
                    <div class="card-tools">
                        <span class="badge badge-info">{{ $mastercards->total() }} Total Records</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($mastercards->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Kode</th>
                                        <th>Revisi</th>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Tipe Box</th>
                                        <th>Gram</th>
                                        <th>Panjang Sheet</th>
                                        <th>Lebar Sheet</th>
                                        <th>Customer</th>
                                        <th>Keterangan</th>
                                        <th>Tanggal Dibuat</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($mastercards as $mastercard)
                                        <tr @if($mastercard->status == 5) style="color:#4842f5;" @endif>
                                            <td>{{ $mastercard->id }}</td>
                                            <td>{{ $mastercard->kode }}</td>
                                            <td>
                                                @if($mastercard->revisi && $mastercard->revisi !== 'R0')
                                                    <span class="badge badge-warning">{{ $mastercard->revisi }}</span>
                                                @else
                                                    <span class="badge badge-success">Original</span>
                                                @endif
                                            </td>
                                            <td>{{ $mastercard->kodeBarang }}</td>
                                            <td>{{ $mastercard->namaBarang }}</td>
                                            <td>
                                                <span class="badge badge-secondary">{{ $mastercard->tipeBox ?? 'N/A' }}</span>
                                            </td>
                                            <td>{{ $mastercard->gramSheetBoxKontrak }}</td>
                                            <td>{{ $mastercard->panjangSheet ?? '' }}</td>
                                            <td>{{ $mastercard->lebarSheet ?? '' }}</td>
                                            <td>{{ $mastercard->customer }}</td>
                                            <td>{{ $mastercard->keterangan ?? '' }}</td>
                                            <td>{{ $mastercard->created_at ? $mastercard->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('mastercard.pdfb1', $mastercard->id) }}" 
                                                       class="btn btn-sm btn-danger" 
                                                       title="Print PDF">
                                                        <i class="fas fa-print"></i>
                                                    </a>
                                                    <a href="{{ route('mastercard.edit', $mastercard->id) }}" 
                                                       class="btn btn-sm btn-primary" 
                                                       title="Revisi">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="{{ route('mastercard.revisi', $mastercard->id) }}" 
                                                       class="btn btn-sm btn-warning" 
                                                       title="Edit">
                                                        <i class="fas fa-cog"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Tidak ada data mastercard ditemukan</h5>
                            @if(request('search'))
                                <p class="text-muted">untuk pencarian: "{{ request('search') }}"</p>
                                <a href="{{ route('mastercard.index_new') }}" class="btn btn-primary">
                                    Lihat Semua Data
                                </a>
                            @else
                                <a href="{{ route('mastercard.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Buat Mastercard Pertama
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
                
                @if($mastercards->count() > 0)
                    <div class="card-footer">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <p class="text-muted mb-0">
                                    Menampilkan {{ $mastercards->firstItem() }} - {{ $mastercards->lastItem() }} 
                                    dari {{ $mastercards->total() }} hasil
                                </p>
                            </div>
                            <div class="col-md-6">
                                {{ $mastercards->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </section>
    <!-- /.content -->
</div>
@endsection

@section('javascripts')
<script>
$(document).ready(function() {
    // Auto-focus search input if there's a search term
    @if(request('search'))
        $('input[name="search"]').focus();
    @endif
    
    // Add loading state to buttons
    $('.btn-group a').click(function() {
        $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
    });
    
    // Tooltip for action buttons
    $('[title]').tooltip();
});
</script>
@endsection