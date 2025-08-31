@extends('admin.templates.partials.default')

@section('styles')
<!-- Load CSS secara async untuk mengurangi blocking -->
<link rel="preload" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
<link rel="preload" href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
<link rel="preload" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">

<style>
    .select2-container { width: 100% !important; }
    .select2-container--bootstrap4 .select2-selection--single {
        height: calc(2.25rem + 2px) !important;
        border: 1px solid #ced4da !important;
    }
    .select2-container--bootstrap4 .select2-selection__rendered {
        line-height: calc(2.25rem + 2px) !important;
        padding-left: 12px !important;
    }
    .select2-container--bootstrap4 .select2-selection__arrow {
        height: calc(2.25rem + 2px) !important;
        right: 12px !important;
    }
    tr:nth-child(odd) { background-color:#bab9b9 !important; }
    
    /* Loading state untuk mengurangi FOUC */
    .table-loading { opacity: 0.6; pointer-events: none; }
    .btn-loading { opacity: 0.65; cursor: not-allowed; pointer-events: none; }
</style>
@endsection


@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row" id="form_list_mc">
            <div class="col-md-12">
                <h4 class="modal-title">Input Delivery Time</h4>
                <hr>
                
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>{{ $message }}</strong>
                    </div>
                @elseif ($message = Session::get('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                <form action="{{ route('kontrak.store_dt') }}" method="POST"  >
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card-body">
                                <h3>Kapasitas B1 yang Sudah Ada</h3>
                                <table class="table table-bordered table-sm" id="data_b1">
                                  <thead>
                                    <tr>
                                      <th>Tanggal</th>
                                      <th>Qty</th>
                                      <th>Sisa</th>
                                      <th>Status</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach ($b1 as $data)
                                      <tr>
                                        <td>{{ $data->tglKirimDt }}</td>
                                        <td>{{ number_format($data->qty) }}</td>
                                        <td>{{ number_format(max(0, 150000 - $data->qty)) }}</td>
                                        <td>
                                            @if ($data->qty <= 100000)
                                                <span class="badge badge-success">Tersedia</span>
                                            @elseif ($data->qty <= 150000)
                                                <span class="badge badge-warning">Hampir Penuh</span>
                                            @else
                                                <span class="badge badge-danger">Melebihi Batas</span>
                                            @endif
                                        </td>
                                      </tr>
                                    @endforeach
                                  </tbody>
                                </table>
                              </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-body">
                                <h3>Kapasitas DC yang Sudah Ada</h3>
                                <table class="table table-bordered table-sm" id="data_dc">
                                  <thead>
                                    <tr>
                                      <th>Tanggal</th>
                                      <th>Qty</th>
                                      <th>Sisa</th>
                                      <th>Status</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach ($dc as $data)
                                      <tr>
                                        <td>{{ $data->tglKirimDt }}</td>
                                        <td>{{ number_format($data->qty) }}</td>
                                        <td>{{ number_format(max(0, 54000 - $data->qty)) }}</td>
                                        <td>
                                            @if ($data->qty <= 40000)
                                                <span class="badge badge-success">Tersedia</span>
                                            @elseif ($data->qty <= 54000)
                                                <span class="badge badge-warning">Hampir Penuh</span>
                                            @else
                                                <span class="badge badge-danger">Melebihi Batas</span>
                                            @endif
                                        </td>
                                      </tr>
                                    @endforeach
                                  </tbody>
                                </table>
                              </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>NO KONTRAK</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control txt_line" name="kodekontrak" id="kodekontrak" value="{{ $kontrak_M->kode }}">
                                                {{-- <input type="hidden" class="form-control txt_line" name="idkontrakm" id="idkontrakm" value="{{ $kontrak_M->id }}"> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Tanggal</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="date" class="form-control txt_line" name="tanggal" id="tanggal" value="{{ $kontrak_M->tglKontrak }}" autofocus >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Pilih Customer</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control txt_line col-md-11" name="namaCust" id="namaCust" value="{{ $kontrak_M->customer_name }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Alamat Kirim</label>
                                            </div>
                                            <div class="col-md-6">
                                                {{-- <input type="text" class="form-control txt_line" name="alamatKirim" id="alamatKirim"> --}}
                                                <textarea name="alamatKirim" id="alamatKirim" cols="30" rows="4" value="">{{ $kontrak_M->alamatKirim }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Jumlah Order</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control txt_line" name="telp" id="telp" value="{{ $kontrak_D->pcsKontrak }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Sisa Order</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control txt_line" name="sisa" id="sisa" value="{{ $kontrak_D->pcsSisaKontrak }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Sisa Kirim</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control txt_line" name="sisa_kirim" id="sisa_kirim" value="{{ $kontrak_D->pcsSisaKirim }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Tipe Box</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control txt_line" name="tipebox" id="tipebox" value="{{ $kontrak_D->tipebox }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Berat Box</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control txt_line" name="berat" id="berat" value="{{ $kontrak_D->berat }}">
                                                <input type="hidden" class="form-control txt_line" name="outconv" id="outconv" value="{{ $kontrak_D->outConv }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h3>Tanggal Kirim DT dan OPI </h3>
                            <table class="table table-bordered table-sm" id="detail_kontrak">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jumlah</th>
                                    <th>OPI</th>
                                    <th>Running Meter</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($opi as $o)
                                @php
                                    $qty = ($o->jumlahOrder) / $o->outConv ; 
                                    $outCorr = floor(2500/$o->lebarSheet);
                                    $cop = $qty / $outCorr;
                                    $rm = ($o->panjangSheet * $cop) / 1000;
                                @endphp
                                <tr>
                                    <td>{{ $o->tglKirimDt }}</td>
                                    <td>{{ number_format($o->jumlahOrder) }}</td>
                                    <td>{{ $o->nama }}</td>
                                    <td>{{ number_format(floor($rm)) }}</td>
                                    <td>
                                        @if($o->status_opi == 'Selesai')
                                            <span class="badge badge-success">{{ $o->status_opi }}</span>
                                        @elseif($o->status_opi == 'Proses')
                                            <span class="badge badge-info">{{ $o->status_opi }}</span>
                                        @else
                                            <span class="badge badge-secondary">{{ $o->status_opi }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            </table>
                            @include('admin.kontrak.adddt')
                            <br>
                            
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <button type="button" class="btn btn-primary opi" data-toggle="modal" data-target="#add_dt">Tambah DT & OPI</button>
                                {{-- <button type="submit" class="btn btn-primary" >Tambah DT & OPI</button> --}}
                            </div>
                        </div>
                    </div>
                </form>
                <div class="col-md-6">
                    <a href="{{ route('kontrak.recall',$kontrak_M->id) }}" type="button" class="btn btn-primary">Recall</a>
                </div>
                </div>
            </div>
        </div>    
    </div>
    
@endsection

@section('javascripts')
<!-- Load JavaScript secara async/defer untuk mengurangi blocking -->
<script defer src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script defer src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script defer src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {
    // Fungsi untuk lazy load DataTables hanya saat diperlukan
    function initDataTables() {
        const tableConfigs = {
            '#detail_kontrak': {
                paging: false,
                ordering: false,
                info: false,
                searching: false,
                select: true
            },
            '#data_b1': {
                paging: true,
                pageLength: 10,
                ordering: true,
                info: false,
                searching: true,
                select: true,
                language: { search: "Cari B1:" }
            },
            '#data_dc': {
                paging: true,
                pageLength: 10,
                ordering: true,
                info: false,
                searching: true,
                select: true,
                language: { search: "Cari DC:" }
            }
        };

        // Initialize tables with delay untuk mengurangi beban CPU
        Object.keys(tableConfigs).forEach((selector, index) => {
            setTimeout(() => {
                if ($(selector).length && !$.fn.DataTable.isDataTable(selector)) {
                    $(selector).DataTable(tableConfigs[selector]);
                }
            }, index * 100); // Delay 100ms antar table
        });
    }

    // Initialize Select2 dengan lazy loading
    function initSelect2() {
        if (typeof $.fn.select2 !== 'undefined') {
            $('.js-example-basic-single').each(function() {
                if (!$(this).hasClass('select2-hidden-accessible')) {
                    $(this).select2({
                        theme: 'bootstrap4',
                        width: '100%',
                        allowClear: true,
                        placeholder: 'Pilih...'
                    });
                }
            });
        }
    }

    // Event handler untuk modal OPI dengan optimasi
    $('.opi').on('click', function() {
        const btn = $(this);
        btn.addClass('btn-loading');
        
        $.ajax({
            url: "{{ route('nomer_opi') }}",
            type: "GET",
            timeout: 5000, // 5 detik timeout
            success: function(response) {
                $('#nomer_opi').val(response.nomer);
                
                // Set data lain
                $('#idkontrakm').val("{{ $kontrak_M->id }}");
                $('#kode').val("{{ $kontrak_M->kode }}");
                $('#sisa').val($('#sisa').val());
                $('#sisa_kirim').val($('#sisa_kirim').val());
            },
            error: function() {
                alert('Gagal mengambil nomer OPI. Silakan coba lagi.');
            },
            complete: function() {
                btn.removeClass('btn-loading');
            }
        });
    });

    // Validation function yang dioptimasi
    window.validateForm = function() {
        const sisa = parseInt(document.getElementById("sisa").value) || 0;
        const x = parseInt(document.getElementById("jumlahKirim").value) || 0;
        const sisaKirim = parseInt(document.getElementById("sisa_kirim").value) || 0;

        if (x > sisa || x > sisaKirim) {
            alert("Masukkan Jumlah dibawah : " + Math.min(sisa, sisaKirim));
            return false;
        }
        return true;
    };

    // Lazy initialization dengan timeout untuk memastikan semua library loaded
    setTimeout(() => {
        initSelect2();
        initDataTables();
    }, 300);
});
</script>
@endsection 