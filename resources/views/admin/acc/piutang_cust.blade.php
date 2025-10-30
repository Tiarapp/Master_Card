
<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>
@extends('admin.templates.partials.default')

@section('content')
<div class="content-wrapper">
    <h2>Detail Piutang Customer</h2>
    <div class="card mb-4">
        <div class="card-header">
            <strong>Informasi Customer</strong>
        </div>
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $cust->Nama }}</p>
            <p id="kode"><strong>Kode Customer:</strong> {{ $cust->Kode }}  </p>
            <p><strong>Alamat:</strong> {{ $cust->AlamatKantor }} </p>
            <p><strong>No. Telepon:</strong> {{ $cust->TelpKantor }} </p>
            <p><strong>Term of Payment:</strong> {{ $cust->WAKTUBAYAR }} </p>
            <p><strong>Limit Piutang:</strong> {{ number_format($cust->Plafond, 2, '.', ',') }} </p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <strong>Daftar Piutang</strong>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="data_faktur">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>No. Ref</th>
                        <th>No. Faktur</th>
                        <th>Jatuh Tempo</th>
                        <th>Total Bayar</th>
                        <th>Total Terima</th>
                        <th>Sisa Piutang</th>
                        <th>Belum Jatuh Tempo</th>
                        <th>0-15 Hari</th>
                        <th>16-30 Hari</th>
                        <th>31-45 Hari</th>
                        <th>46-60 Hari</th>
                        <th>61-90 Hari</th>
                        <th>91-120 Hari</th>
                        <th>>120 Hari</th>
                        <th>Selisih hari</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($piutang as $data)
                    <tr>
                        <td>{{ date('Y-m-d', strtotime($data->Tanggal)) }}</td>
                        <td>{{ $data->NoRef }}</td>
                        <td>{{ $data->NoBukti }}</td>
                        <td>{{ date('Y-m-d', strtotime($data->TglJT)) }}</td>
                        <td>{{ number_format($data->TotalRp, 2, '.', ',') }}</td>
                        <td>{{ number_format($data->TotalTerima, 2, '.', ',') }}</td>
                        <td>{{ number_format($data->sisa_piutang, 2, '.', ',') }}</td>
                        <td>{{ $data->selisih_hari < 0 ? number_format($data->sisa_piutang, 2, '.', ',') : '-' }}</td>
                        <td>{{ ($data->selisih_hari >= 0 && $data->selisih_hari <= 15) ? number_format($data->sisa_piutang, 2, '.', ',') : '-' }}</td>
                        <td>{{ ($data->selisih_hari >= 16 && $data->selisih_hari <= 30) ? number_format($data->sisa_piutang, 2, '.', ',') : '-' }}</td>
                        <td>{{ ($data->selisih_hari >= 31 && $data->selisih_hari <= 45) ? number_format($data->sisa_piutang, 2, '.', ',') : '-' }}</td>
                        <td>{{ ($data->selisih_hari >= 46 && $data->selisih_hari <= 60) ? number_format($data->sisa_piutang, 2, '.', ',') : '-' }}</td>
                        <td>{{ ($data->selisih_hari >= 61 && $data->selisih_hari <= 90) ? number_format($data->sisa_piutang, 2, '.', ',') : '-' }}</td>
                        <td>{{ ($data->selisih_hari >= 91 && $data->selisih_hari <= 120) ? number_format($data->sisa_piutang, 2, '.', ',') : '-' }}</td>
                        <td>{{ $data->selisih_hari >= 121 ? number_format($data->sisa_piutang, 2, '.', ',') : '-' }}</td>
                        <td>{{ $data->selisih_hari }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" style="text-align:left">TOTAL</th>
                        <th>
                            {{ number_format($piutang->sum('TotalRp'), 2, '.', ',') }}
                        </th>
                        <th>
                            {{ number_format($piutang->sum('TotalTerima'), 2, '.', ',') }}
                        </th>
                        <th>
                            {{ number_format($piutang->sum('sisa_piutang'), 2, '.', ',') }}
                        </th>
                        <th>
                            {{ number_format($piutang->filter(fn($d) => $d->selisih_hari < 0)->sum('sisa_piutang'), 2, '.', ',') }}
                        </th>
                        <th>
                            {{ number_format($piutang->filter(fn($d) => $d->selisih_hari >= 0 && $d->selisih_hari <= 15)->sum('sisa_piutang'), 2, '.', ',') }}
                        </th>
                        <th>
                            {{ number_format($piutang->filter(fn($d) => $d->selisih_hari >= 16 && $d->selisih_hari <= 30)->sum('sisa_piutang'), 2, '.', ',') }}
                        </th>
                        <th>
                            {{ number_format($piutang->filter(fn($d) => $d->selisih_hari >= 31 && $d->selisih_hari <= 45)->sum('sisa_piutang'), 2, '.', ',') }}
                        </th>
                        <th>
                            {{ number_format($piutang->filter(fn($d) => $d->selisih_hari >= 46 && $d->selisih_hari <= 60)->sum('sisa_piutang'), 2, '.', ',') }}
                        </th>
                        <th>
                            {{ number_format($piutang->filter(fn($d) => $d->selisih_hari >= 61 && $d->selisih_hari <= 90)->sum('sisa_piutang'), 2, '.', ',') }}
                        </th>
                        <th>
                            {{ number_format($piutang->filter(fn($d) => $d->selisih_hari >= 91 && $d->selisih_hari <= 120)->sum('sisa_piutang'), 2, '.', ',') }}
                        </th>
                        <th>
                            {{ number_format($piutang->filter(fn($d) => $d->selisih_hari >= 121)->sum('sisa_piutang'), 2, '.', ',') }}
                        </th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(document).ready(function() {
        var table = $('#data_faktur').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy',
                'csv',
                {
                    extend: 'excelHtml5',
                    text: 'Excel',
                    title: 'Daftar Piutang Customer - {{ $cust->Nama }}',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                'pdf',
                'colvis',
                {
                    extend: 'print',
                    text: 'Print',
                    exportOption: {
                        modifier: {
                            selected: null
                        }
                    }
                }
            ],
            "pageLength": 25,
            "lengthMenu": [ 25, 50, 75, 100 ],
            "order": [ 0, "asc" ],
            select: true
        });
    })
    });
</script>
@endsection