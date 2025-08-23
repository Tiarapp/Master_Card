@extends('admin.templates.partials.default')

<!-- Select2 4.1.0-rc.0 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- DataTables -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

<style>
    .select2-container {
        width: 100% !important;
    }
    
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
    
    tr:nth-child(odd) {
        background-color:#bab9b9 !important;
        
    }
</style>


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
                                <table class="table table-bordered" id="data_b1">
                                  <thead>
                                    <tr>
                                      <th scope="col">Tanggal.</th>
                                      <th scope="col">Qty</th>
                                      <th scope="col">Sisa</th>
                                      <th scope="col">Status</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach ($b1 as $data)
                                      <tr>
                                        <td>{{ $data->tglKirimDt }}</td>
                                        <td>{{ $data->qty }}</td>
                                        <td>
                                            <?php 
                                                $sisa = 150000 - $data->qty;
                                                if ($sisa < 0) {
                                                    echo 0;
                                                } else {
                                                    echo $sisa;
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            @if ($data->qty <= 100000)
                                                Tersedia
                                            @elseif ($data->qty <=150000)
                                                Hampir Penuh
                                            @else
                                                Melebihi Batas
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
                                <table class="table table-bordered" id="data_dc">
                                  <thead>
                                    <tr>
                                      <th scope="col">Tanggal.</th>
                                      <th scope="col">Qty</th>
                                      <th scope="col">Sisa</th>
                                      <th scope="col">Status</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach ($dc as $data)
                                      <tr>
                                        <td>{{ $data->tglKirimDt }}</td>
                                        <td>{{ $data->qty }}</td>
                                        <td>
                                            <?php 
                                                $sisa = 54000 - $data->qty;
                                                if ($sisa < 0) {
                                                    echo 0;
                                                } else {
                                                    echo $sisa;
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            @if ($data->qty <= 40000)
                                                Tersedia
                                            @elseif ($data->qty <= 54000)
                                                Hampir Penuh
                                            @else
                                                Melebihi Batas
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
                            <table class="table table-bordered" id="detail_kontrak">
                            <thead>
                                <tr>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">OPI</th>
                                    <th scope="col">Running Meter</th>
                                    <th scope="col">Status</th>
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
                                    <td scope="col">{{ $o->tglKirimDt }}</td>
                                    <td scope="col">{{ $o->jumlahOrder }}</td>
                                    <td scope="col">{{ $o->nama }}</td>
                                    <td scope="col">{{ floor($rm) }}</td>
                                    <td scope="col">{{ $o->status_opi }}</td>
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

<script type="text/javascript">
    $(document).ready(function() {
    // Debug functions
    function testSelect2() {
        console.log('jQuery version:', $.fn.jquery);
        console.log('Select2 version:', $.fn.select2 ? 'Available' : 'Not available');
        console.log('Select2 elements found:', $('.js-example-basic-single').length);
    }

    function forceSelect2() {
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

    function reinitializeSelect2() {
        $('.js-example-basic-single').select2('destroy').select2({
            theme: 'bootstrap4',
            width: '100%',
            allowClear: true,
            placeholder: 'Pilih...'
        });
    }

    // Wait for jQuery to be ready
    function waitForJQuery() {
        if (typeof $ !== 'undefined' && $.fn.select2) {
            initializeComponents();
        } else {
            setTimeout(waitForJQuery, 100);
        }
    }

    function initializeComponents() {
        try {
            // Initialize Select2
            $('.js-example-basic-single').select2({
                theme: 'bootstrap4',
                width: '100%',
                allowClear: true,
                placeholder: 'Pilih...'
            });

            console.log('Select2 initialized successfully');
        } catch (error) {
            console.error('Error initializing Select2:', error);
            setTimeout(function() {
                try {
                    forceSelect2();
                } catch (e) {
                    console.error('Force initialization failed:', e);
                }
            }, 1000);
        }
    }

    $(document).ready(function() {
        waitForJQuery();
        testSelect2();
    });
    });

    $("#detail_kontrak").DataTable({
        "paging":   false,
        "ordering": false,
        "info":     false,
        "searching": false,
        // "scrollX": true,
        // "autoWidth": true, 
        "initComplete": function (settings, json) {  
            $("#detail_kontrak").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
        },
        // "scrollY": "400px",
        select: true,
    });

    // Ambil nomer OPI dari backend saat tombol diklik
    $('.opi').on('click', function() {
        var idkontrakm = "{{ $kontrak_M->id }}";
        $.ajax({
            url: "{{ route('nomer_opi') }}",
            type: "GET",
            success: function(response) {
                // response.nomer_opi diasumsikan dikirim dari backend
                console.log(response);
                
                $('#nomer_opi').val(response.nomer);
            },
            error: function() {
                alert('Gagal mengambil nomer OPI');
            }
        });

        // Set data lain jika diperlukan
        var kode = "{{ $kontrak_M->kode }}";
        var sisa = $('#sisa').val();
        var sisa_kirim = $('#sisa_kirim').val();
        $('#idkontrakm').val(idkontrakm);
        $('#kode').val(kode);
        $('#sisa').val(sisa);
        $('#sisa_kirim').val(sisa_kirim);
    });

    $("#data_b1").DataTable({
        "paging":   true,
        "ordering": true,
        "info":     false,
        "searching": true,
        // "scrollX": true,
        // "autoWidth": true, 
        // "scrollY": "400px",
        select: true,
    });

    $("#data_dc").DataTable({
        "paging":   true,
        "ordering": true,
        "info":     false,
        "searching": true,
        // "scrollX": true,
        // "autoWidth": true, 
        // "scrollY": "400px",
        select: true,
    });
    
    function validateForm() {
        sisa = document.getElementById("sisa").value;
        x = document.getElementById("jumlahKirim").value;
        sisa_kirim = document.getElementById("sisa_kirim").value;

        if (x > parseInt(sisa)) {
            if (x > parseInt(sisa_kirim)) {
                alert("Masukkan Jumlah dibawah : "+sisa_kirim);
                return false;
            } 
        } 
    }
                        
</script>

@endsection 