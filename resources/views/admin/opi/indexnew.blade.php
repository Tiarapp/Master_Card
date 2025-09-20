<!-- jQuery -->
<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>

@extends('admin.templates.partials.default')


<style>
.label {
  color: white;
}

.status {
  width: auto;
  height: auto;
  margin-top: 20px;
  text-align: center;
  padding: 8px;
  border-radius: 10%;
}

.success {background-color: #04AA6D;} /* Green */
.info {background-color: #2196F3;} /* Blue */
.warning {background-color: #ff9800;} /* Orange */
.danger {background-color: #f44336;} /* Red */
.other {background-color: #e7e7e7; color: black;} /* Gray */
</style>

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">OPI</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">OPI</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
          <strong>{{ $message }}</strong>
        </div>
      @endif
      <!-- Small boxes (Stat box) -->

      <div class="row mb-4 align-items-center">
        <div class="col-auto d-flex align-items-center gap-3">
          <a href="{{ url('/opi/export?page=' . request()->get('page', 1) . (request()->has('search') ? '&search=' . urlencode(request('search')) : '')) }}" class="btn btn-success mb-3">
        Export Halaman Ini
          </a>
        </div>
        <div class="col text-end">
          <form class="d-flex align-items-center justify-content-end gap-2" action="{{ route('opinew') }}" method="GET" style="margin-bottom: 20px;">
            <div class="input-group" style="max-width: 350px;">
              <span class="input-group-text bg-white border-end-0" style="border-radius: 20px 0 0 20px; border-right: none;">
                <i class="fas fa-search text-muted"></i>
              </span>
              <input 
                type="text" 
                class="form-control border-start-0 shadow-none" 
                name="search" 
                placeholder="{{ __('Cari OPI...') }}" 
                value="{{ request('search') }}" 
                style="border-radius: 0 20px 20px 0; border-left: none; min-width: 200px;"
                autocomplete="off"
              >
            </div>
            <button type="submit" class="btn btn-primary px-4 shadow-sm">
              <i class="fas fa-search me-1"></i> {{ __('Cari') }}
            </button>
            <a href="{{ route('opinew') }}" class="btn btn-outline-secondary px-4 shadow-sm">
              <i class="fas fa-sync-alt me-1"></i> {{ __('Reset') }}
            </a>
          </form>
        </div>
      </div>

      <div class="table-responsive shadow rounded-3">
        <table class="table align-middle table-row-dashed table-row-bordered gy-5 gs-7 fs-6" style="background-color: #fff;">
            <thead>
                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                    <th class="min-w-125px">{{ __('ID') }}</th>
                    <th class="min-w-125px">{{ __('No OPI') }}</th>
                    <th class="min-w-125px">{{ __('Action') }}</th>
                    <th class="min-w-125px">{{ __('Kontrak') }}</th>
                    <th class="min-w-125px">{{ __('OPI ke') }}</th>
                    <th class="min-w-125px">{{ __('DT') }}</th>
                    <th class="min-w-125px">{{ __('QTY Kirim') }}</th>
                    <th class="min-w-125px">{{ __('Customer') }}</th>
                    <th class="min-w-125px">{{ __('Item') }}</th>
                    <th class="min-w-125px">{{ __('Qty Order') }}</th>
                    <th class="min-w-125px">{{ __('Sisa Qty Order') }}</th>
                    <th class="min-w-125px">{{ __('Keterangan OPI') }}</th>
                    <th class="min-w-125px">{{ __('Opi') }}</th>
                    <th class="min-w-125px">{{ __('PO Customer') }}</th>
                    <th class="min-w-125px">{{ __('No MC') }}</th>
                    <th class="min-w-125px">{{ __('Hari') }}</th>
                    <th class="min-w-125px">{{ __('Flute') }}</th>
                    <th class="min-w-125px">{{ __('Bentuk') }}</th>
                    <th class="min-w-125px">{{ __('Sheet P') }}</th>
                    <th class="min-w-125px">{{ __('Sheet L') }}</th>
                    <th class="min-w-125px">{{ __('Out') }}</th>
                    <th class="min-w-125px">{{ __('UK Roll') }}</th>
                    <th class="min-w-125px">{{ __('Tipe Order') }}</th>
                    <th class="min-w-125px">{{ __('Warna') }}</th>
                    <th class="min-w-125px">{{ __('Finishing') }}</th>
                    <th class="min-w-125px">{{ __('Kualitas Produksi K/M Atas') }}</th>
                    <th class="min-w-125px">{{ __('Kualitas Produksi I1') }}</th>
                    <th class="min-w-125px">{{ __('Kualitas Produksi I2') }}</th>
                    <th class="min-w-125px">{{ __('Kualitas Produksi I3') }}</th>
                    <th class="min-w-125px">{{ __('Kualitas Produksi I4') }}</th>
                    <th class="min-w-125px">{{ __('Kualitas Produksi I5') }}</th>
                    <th class="min-w-125px">{{ __('Kualitas Produksi K/M Bawah') }}</th>
                    <th class="min-w-125px">{{ __('Wax') }}</th>
                    <th class="min-w-125px">{{ __('Gram') }}</th>
                    <th class="min-w-125px">{{ __('Tanggal Order') }}</th>
                    <th class="min-w-125px">{{ __('Alamat') }}</th>
                    <th class="min-w-125px">{{ __('Toleransi (lebih/kurang)') }}</th>
                    <th class="min-w-125px">{{ __('Box P') }}</th>
                    <th class="min-w-125px">{{ __('Box L') }}</th>
                    <th class="min-w-125px">{{ __('Box T') }}</th>
                    <th class="min-w-125px">{{ __('Koli') }}</th>
                    <th class="min-w-125px">{{ __('DT Perubahan') }}</th>
                    <th class="min-w-125px">{{ __('Harga (kg)') }}</th>
                    <th class="min-w-125px">{{ __('Real Kirim') }}</th>
                    <th class="min-w-125px">{{ __('Sisa DT') }}</th>
                    <th class="min-w-125px">{{ __('Status') }}</th>
                    <th class="min-w-125px">{{ __('No Kontrak + Urut') }}</th>
                    <th class="min-w-125px">{{ __('TGL Kontrak') }}</th>
                    <th class="min-w-125px">{{ __('Kualitas Kontrak K/M Atas') }}</th>
                    <th class="min-w-125px">{{ __('Kualitas Kontrak I1') }}</th>
                    <th class="min-w-125px">{{ __('Kualitas Kontrak I2') }}</th>
                    <th class="min-w-125px">{{ __('Kualitas Kontrak I3') }}</th>
                    <th class="min-w-125px">{{ __('Kualitas Kontrak I4') }}</th>
                    <th class="min-w-125px">{{ __('Kualitas Kontrak I5') }}</th>
                    <th class="min-w-125px">{{ __('Kualitas Kontrak K/M Bawah') }}</th>
                    <th class="min-w-125px"></th>
                    <th class="min-w-125px">{{ __('Kode Barang') }}</th>
                    <th class="min-w-125px">{{ __('Tipe Crease') }}</th>
                    <th class="min-w-125px">{{ __('Bungkus') }}</th>
                    <th class="min-w-125px">{{ __('Lain-Lain') }}</th>
                </tr>
            </thead>
            <tbody class="text-gray-900 fw-semibold">
                @foreach ($productions as $production)
                    <tr>
                        <td class="text-gray-800 bold">{{ $production->id }}</td>
                        <td class="text-gray-800 bold">{{ $production->NoOPI }}</td>
                        <td>
                            <div class="d-flex gap-2">
                              <a href="{{ route('opi.print', $production->id) }}" class="btn btn-outline-info btn-sm" title="Print">
                                <i class="fas fa-print"></i>
                                <span>Print</span>
                              </a>
                              @if (Auth::user()->divisi_id == 3 || Auth::user()->divisi_id == 2)
                                <a href="{{ route('opi.cancel', $production->id) }}" class="btn btn-outline-primary btn-sm" title="Edit">
                                  <i class="fas fa-edit"></i>
                                  <span>Cancel</span>
                                </a>
                              @endif
                            </div>
                        </td>
                        <td class="text-gray-800 bold">{{ $production->kontrakm->kode }}</td>
                        <td class="text-gray-800 bold">{{ $production->created_at }}</td>
                        <td class="text-gray-800 bold">{{ $production->dt_id ? $production->dt->tglKirimDt : '' }}</td>
                        <td class="text-gray-800 bold">{{ $production->jumlahOrder }}</td>
                        <td class="text-gray-800 bold">{{ $production->kontrakm->customer_name }}</td>
                        <td class="text-gray-800 bold">{{ $production->kontrakd->mc->namaBarang }}</td>
                        <td class="text-gray-800 bold">{{ $production->jumlahOrder }}</td>
                        <td class="text-gray-800 bold">{{ $production->jumlahOrder }}</td>
                        <td class="text-gray-800 bold">{{ $production->kontrakm->keterangan }}</td>
                        <td class="text-gray-800 bold">{{ $production->NoOPI }}</td>
                        <td class="text-gray-800 bold">{{ $production->kontrakm->poCustomer }}</td>
                        <td class="text-gray-800 bold">
                            {{ $production->mc->kode . ($production->mc->revisi == 'R0' ? '' : '-' . $production->mc->revisi) }}
                        </td>
                        <td class="text-gray-800 bold">
                          @php
                            $hari = $production->dt_id && $production->dt->tglKirimDt
                              ? \Carbon\Carbon::parse($production->dt->tglKirimDt)->translatedFormat('l')
                              : '';
                          @endphp
                          {{ $hari }}
                        </td>
                        <td class="text-gray-800 bold">{{ $production->mc->flute }}</td>
                        <td class="text-gray-800 bold">{{ $production->mc->tipeBox }}</td>
                        <td class="text-gray-800 bold">{{ $production->mc->panjangSheet }}</td>
                        <td class="text-gray-800 bold">{{ $production->mc->lebarSheet }}</td>
                        <td class="text-gray-800 bold">{{ $production->mc->outConv }}</td>
                        <td class="text-gray-800 bold"> - </td>
                        <td class="text-gray-800 bold">{{ $production->kontrakm->tipeOrder }}</td>
                        <td class="text-gray-800 bold">{{ $production->mc->colorcombine->nama }}</td>
                        <td class="text-gray-800 bold">{{ $production->mc->joint }}</td>
                        <td class="text-gray-800 bold">
                          @if ($production->mc->substanceproduksi->lineratas)
                            {{ $production->mc->substanceproduksi->lineratas->jenisKertasMc == "BK" ? "K" : $production->mc->substanceproduksi->lineratas->jenisKertasMc }}
                          @else
                            -
                          @endif
                        </td>
                        <td class="text-gray-800 bold">{{ $production->mc->substanceproduksi->lineratas->gramKertas ?? ''}}</td>
                        <td class="text-gray-800 bold">{{ $production->mc->substanceproduksi->flute1->gramKertas ?? ''}}</td>
                        <td class="text-gray-800 bold">{{ $production->mc->substanceproduksi->linertengah->gramKertas ?? '' }}</td>
                        <td class="text-gray-800 bold">{{ $production->mc->substanceproduksi->flute2->gramKertas ?? '' }}</td>
                        <td class="text-gray-800 bold">{{ $production->mc->substanceproduksi->linerbawah->gramKertas ?? ''}}</td>
                        <td class="text-gray-800 bold">{{ $production->mc->substanceproduksi->linerbawah->jenisKertasMc == "BK" ? "K" : $production->mc->substanceproduksi->linerbawah->jenisKertasMc }} </td>
                        <td class="text-gray-800 bold">{{ $production->mc->wax ?? '' }}</td>
                        <td class="text-gray-800 bold">
                          @if (Auth::user()->divisi_id == 3)
                            {{ $production->mc->gramSheetBoxKontrak }}
                          @else
                            {{ $production->mc->gramSheetBoxProduksi }}
                          @endif
                        </td>
                        <td class="text-gray-800 bold">{{ $production->kontrakm->tglKontrak }}</td>
                        <td class="text-gray-800 bold">{{ $production->kontrakm->alamatKirim }}</td>
                        <td class="text-gray-800 bold">{{ $production->kontrakd->pctToleransiKurangKontrak.'% '.$production->kontrakd->pctToleransiLebihKontrak.'%' }}</td>
                        <td class="text-gray-800 bold">{{ $production->mc->box->panjangDalamBox }}</td>
                        <td class="text-gray-800 bold">{{ $production->mc->box->lebarDalamBox }}</td>
                        <td class="text-gray-800 bold">{{ $production->mc->box->tinggiDalamBox }}</td>
                        <td class="text-gray-800 bold">{{ $production->mc->koli }}</td>
                        <td class="text-gray-800 bold">{{ $production->dt_id ? $production->dt->tglKirimDt : '' }}</td>
                        <td class="text-gray-800 bold">{{ $production->kontrakd->harga_kg }}</td>
                        <td class="text-gray-800 bold">-</td>
                        <td class="text-gray-800 bold">-</td>
                        <td class="text-gray-800 bold">
                            
                        </td>
                        <td class="text-gray-800 bold">{{ $production->kontrakm->kode }}</td>
                        <td class="text-gray-800 bold">{{ $production->kontrakm->tglKontrak }}</td>
                        <td class="text-gray-800 bold">
                          @if ($production->mc->substancekontrak->lineratas)
                            {{ $production->mc->substancekontrak->lineratas->jenisKertasMc == "BK" ? "K" : $production->mc->substancekontrak->lineratas->jenisKertasMc }}
                          @else
                            -
                          @endif
                        </td>
                        <td class="text-gray-800 bold">{{ $production->mc->substancekontrak->lineratas->gramKertas ?? '' }}</td>
                        <td class="text-gray-800 bold">{{ $production->mc->substancekontrak->flute1->gramKertas ?? ''}}</td>
                        <td class="text-gray-800 bold">{{ $production->mc->substancekontrak->linertengah->gramKertas ?? '' }}</td>
                        <td class="text-gray-800 bold">{{ $production->mc->substancekontrak->flute2->gramKertas ?? '' }}</td>
                        <td class="text-gray-800 bold">{{ $production->mc->substancekontrak->linerbawah->gramKertas ?? ''}}</td>
                        <td class="text-gray-800 bold">{{ $production->mc->substancekontrak->linerbawah->jenisKertasMc == "BK" ? "K" : $production->mc->substancekontrak->linerbawah->jenisKertasMc }} </td>
                        <td></td>
                        <td class="text-gray-800 bold">{{ $production->mc->kodeBarang }}</td>
                        <td class="text-gray-800 bold">{{ $production->mc->box->tipeCreasCorr }}</td>
                        <td class="text-gray-800 bold">{{ $production->mc->bungkus }}</td>
                        <td class="text-gray-800 bold">{{ $production->mc->lain }}</td>
                        
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $productions->appends(request()->query())->links('pagination::bootstrap-4') }}
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
  @endsection