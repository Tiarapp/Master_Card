<!-- jQuery -->
<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>
@extends('admin.templates.partials.default')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

@section('content')


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <style>
        .hidden {
            display: hidden
        }

    </style>
    <div class="content-header">
        <div class="row" id="form_list_mc">
            <div class="col-md-8">
                <h4 class="modal-title">Tambah Form Mastercard</h4>
                <hr>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Error!</strong> 
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                <form action="{{ route('mkt.store.formmc') }}" method="POST" class="inputSheet">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Pilih Tipe Box">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>Tujuan</label>
                                        </div>
                                        <div class="col-md-8">
                                            <select class="js-example-basic-single col-md-12" name="tujuan" id="tujuan">
                                                <option value="">Pilih Tujuan</option>
                                                <option value="LOKAL">LOKAL</option>
                                                <option value="EKSPOR">EKSPOR</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input Flute">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>Kode</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control txt_line" name="kode" id="kode" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input Flute">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>Tanggal</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="date" class="form-control txt_line" name="tanggal" id="tanggal" value="{{ $date }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Pilih Tipe Box">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>Order</label>
                                        </div>
                                        <div class="col-md-8">
                                            <select class="js-example-basic-single col-md-12" name="order" id="order">
                                                <option value="">Pilih Order</option>
                                                <option value="SAMPLE">SAMPLE</option>
                                                <option value="BONUS">BONUS</option>
                                                <option value="JUAL">JUAL</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input Flute">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>Customer</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control txt_line" name="KodeCust" id="KodeCust">
                                            <input type="text" class="form-control txt_line" name="NamaCust" id="NamaCust">
                                        </div>
                                        <div class="col-md-1">
                                            <div class="modal fade" id="Customer">
                                                <div class="modal-dialog modal-xl">
                                                    
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">List Customer</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body customer">
                                                            <div class="card-body">
                                                                <table class="table table-bordered" id="data_customer">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">Kode</th>
                                                                            <th scope="col">Nama Customer</th>
                                                                            <th scope="col">Alamat Kantor</th>
                                                                            <th scope="col">Kota Kantor</th>
                                                                            <th scope="col">Alamat Kirim</th>
                                                                            <th scope="col">Kota Kirim</th>
                                                                            <th scope="col">TOP</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                        foreach ($cust as $data) { ?>
                                                                            <tr>
                                                                                <td scope="row">{{ $data->Kode }}</td>
                                                                                <td>{{ $data->Nama }}</td>
                                                                                <td>{{ $data->AlamatKantor }}</td>
                                                                                <td>{{ $data->KotaKantor }}</td>
                                                                                <td>{{ $data->AlamatKirim }}</td>
                                                                                <td>{{ $data->KotaKirim }}</td>
                                                                                <td>{{ $data->WAKTUBAYAR }}</td>
                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Simpan</button>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <button type="button" data-toggle="modal" data-target="#Customer">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input Alamat">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>Alamat</label>
                                        </div>
                                        <div class="col-md-8">
                                            <textarea name="AlamatKantor" id="AlamatKantor" cols="35" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input Kontrak">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>No Kontrak</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control txt_line" name="nokontrak" id="nokontrak" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input PO">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>No PO</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control txt_line" name="nopo" id="nopo" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" class="form-control txt_line" name="createdBy" id="createdBy" value="{{ Auth::user()->name }}">
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input Flute">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>Tanggal Kirim</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="date" class="form-control txt_line" name="tgl_kirim" id="tgl_kirim" value="{{ $date }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input Alamat Kirim">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>Alamat Kirim</label>
                                        </div>
                                        <div class="col-md-8">
                                            <textarea name="AlamatKirim" id="AlamatKirim" cols="40" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input Pajak">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>Pajak</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control txt_line" name="pajak" id="pajak" value="EXCLUDE" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Pilih Mata Uang">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>Mata Uang</label>
                                        </div>
                                        <div class="col-md-4">
                                            <select class="js-example-basic-single col-md-12" name="mata_uang" id="mata_uang">
                                                <option value="">Pilih Uang</option>
                                                @foreach ($uang as $item)
                                                    <option value="{{ $item->MataUang }}">{{ $item->MataUang }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input kurs">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>Kurs Rp</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" name="kurs_rp" id="kurs_rp" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input kurs">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>Kurs USD</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" name="kurs_usd" id="kurs_usd" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" data-toggle="tooltip" data-placement="right" title="Input top">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>Pembayaran</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control txt_line" name="top" id="top">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="save_master" class="btn_master btn btn-primary" style="display: inline; margin-left: 20px">
                        Save
                    </button>
                </form>
                
                <button type="button" id="cari_barang" class="btn btn-primary" style="display:none; margin-left: 20px"  data-toggle="modal" data-target="#detail_mod">
                    Cari Barang
                </button>

                @include('admin.Marketing.mod.add_detail')
            </div>
        </div>
        @include('admin.Marketing.mod.detail_mod')
    </div>    
</div>

<script type="text/javascript"> 
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".Customer").ready(function(){
        var table = $("#data_customer").DataTable({
            select: true,
        });
        
        $('#data_customer tbody').on( 'click', 'td', function () {
            var cust = (table.row(this).data());
            cust_name = cust[1]
            name = cust_name.replace('&amp;', '&')
            $("#KodeCust").val(cust[0]);
            $("#NamaCust").val(cust_name);
            $("#AlamatKantor").val(cust[2] + '\n' + cust[3]);
            $("#AlamatKirim").val(cust_name + '\n' + cust[4] + '\n' + cust[5]);
            $("#top").val(cust[6]);


            // document.getElementById("Customer").modal(hide);
        } );
    });

    document.getElementById('tujuan').addEventListener('change', function(){
        const route = "{{ route('mod.get_kode', ['tujuan' => ':tujuan']) }}"
        tujuan = $(this).val();

        const finalRoute = route.replace(':tujuan', tujuan)

        fetch(finalRoute)
            .then(response => {
                if (response.ok) {
                    return response.json()
                }
            })
            .then(data => {
                $("#kode").val(data['kode'])
            })
            .catch(error => {
                console.error("Ada error saat mengambil dari API", error)
            })
    })

    document.getElementById('kode_barang').addEventListener('change', function() {
        const route = "{{ route('get_barang', ['kode' => ':kode']) }}"
        kode = $(this).val()

        const finalRoute = route.replace(':kode', kode)

        fetch(finalRoute)
            .then(response => {
                if (response.ok) {
                    return response.json()
                } else {
                    $('#nama_barang').val('')
                    alert("Barang tidak ditemukan")
                }
            })
            .then(data => {
                $('#nama_barang').val(data['nama'])
            })
            .catch(error => {
                console.error("Ada error saat mengambil dari API", error)
            })
    })

    document.getElementById('mata_uang').addEventListener('change', function(){
        const route = "{{ route('mod.get_uang', ['kode' => ':kode']) }}"
        kode = $(this).val();

        const finalRoute = route.replace(':kode', kode)

        fetch(finalRoute)
            .then(response => {
                if (response.ok) {
                    return response.json()
                }
            })
            .then(data => {
                $("#kurs_rp").val(data['nilai']);
                $("#kurs_usd").val(data['usd']);
            })
            .catch(error => {
                console.error("Ada error saat mengambil API", error)
            })
    })

    $('.harga').on('keyup', function() {
        
        harga = $(this).val()
        qty = $('#qty').val()

        subtotal = harga * qty
        ppn = subtotal * 11/100
        subtotal_akhir = subtotal + ppn

        document.getElementById('subtotal_awal').value = subtotal
        document.getElementById('ppn').value = ppn
        document.getElementById('subtotal_akhir').value = subtotal_akhir
        
    })

    function loadData()
    {
        kode = $('#kode').val()
        if (kode) {
            const route = "{{ route('detail_mod', ['kode' => ':kode']) }}"
            const finalRoute = route.replace(':kode', kode)

            $.ajax({
                url: finalRoute,
                method: 'GET',
                success: function (response) {
                    let rows = ''
                    
                    response['detail'].forEach(data => {
                        const Quantity = new Intl.NumberFormat().format(data.Quantity);
                        const HargaAwal = new Intl.NumberFormat().format(data.HargaAwal);
                        const SubTotalAwal = new Intl.NumberFormat().format(data.SubTotalAwal);
                        rows += `
                            <tr>
                                <td>${data.kode_barang}</td>
                                <td>${data.NamaBrg}</td>
                                <td>0</td>
                                <td>${Quantity}</td>
                                <td>${HargaAwal}</td>
                                <td>0</td>
                                <td>${SubTotalAwal}</td>
                                <td>
                                    <button type='button' class='btn btn-danger'>Hapus</button>
                                </td>
                            </tr>
                        `
                    })
                    $('#data_mod tbody').html(rows);
                        const gross = new Intl.NumberFormat().format(response['master'].TotalAwal);
                        const master_ppn = new Intl.NumberFormat().format(response['master'].PPN);
                        const total = new Intl.NumberFormat().format(response['master'].TotalAkhir);
                    $('#gross').val(gross);
                    $('#potongan').val(0.00);
                    $('#netto').val(gross);
                    $('#master_ppn').val(master_ppn);
                    $('#master_pph').val(0.00);
                    $('#total').val(total);
                }
            })
        }
    }

    $('#save_master').on('click', function () {
        const masterData = {
            tujuan: $('#tujuan').val(),
            kode: $('#kode').val(),
            tanggal: $('#tanggal').val(),
            order: $('#order').val(),
            KodeCust: $('#KodeCust').val(),
            NamaCust: $('#NamaCust').val(),
            AlamatKantor: $('#AlamatKantor').val(),
            nokontrak: $('#nokontrak').val(),
            nopo: $('#nopo').val(),
            user: $('#createdBy').val(),
            tanggal_kirim: $('#tgl_kirim').val(),
            AlamatKirim: $('#AlamatKirim').val(),
            pajak: $('#pajak').val(),
            matauang: $('#mata_uang').val(),
            kurs_rp: $('#kurs_rp').val(),
            kurs_usd: $('#kurs_usd').val(),
            top: $('#top').val(),
        }
        
        $.ajax({
            url: "{{ route('mod.save_master') }}",
            method: 'POST',
            data: masterData,
            success: function (response) {
                if (response.success) {
                    document.getElementById('detail').style.display = "block";
                    document.getElementById('cari_barang').style.display = "block";
                    document.getElementById('save_master').style.display = "none";
                    alert('Data berhasil disimpan')
                }
            },
            error: function (response) {
                alert('Gagal menyimpan data!!')
            }
        })        
    })

    $('.save_detail').on('click', function() {
        const detailData = {
            nomod: $('#kode').val(),
            kode_barang: $('#kode_barang').val(),
            qty: $('#qty').val(),
            harga: $('#harga').val(),
            total_awal: $('#subtotal_awal').val(),
            ppn: $('#ppn').val(),
            total_akhir: $('#subtotal_akhir').val(),
            bc_date: $('#bc_date').val()
        }

        $.ajax({
            url: "{{ route('mod.save_detail') }}",
            method: 'POST',
            data: detailData,
            success: function (response) {
                if (response.success) {
                    alert('Data berhasil disimpan');
                    $('#detail_form')[0].reset()
                    loadData();
                }
            },
            error: function (response) {
                alert('Gagal menyimpan data!')
            }
        })
    })

    loadData();
</script>
    
@endsection