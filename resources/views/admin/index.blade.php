<!-- jQuery -->
<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>
@extends('admin.templates.partials.default')

@section('content')

<?php
  $periode = '';
  $hasil = '';

  for ($i=0; $i < count($all_periode) ; $i++) {
    if ($periode == '') {
      $periode = $all_periode[$i];
    } else {
      $periode = $periode.'/'.$all_periode[$i];
    }
  }
  for ($i=0; $i < count($data) ; $i++) {
    if ($hasil == '') {
      $hasil = $data[$i]->kirim;
    } else {
      $hasil = $hasil.'/'.$data[$i]->kirim;
    }
  }
?>

<style>
  .mobile-dashboard-menu {
    display: none;
  }

  .mobile-menu-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 0.75rem;
    margin-bottom: 1.25rem;
  }

  .mobile-menu-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 108px;
    padding: 0.7rem 0.35rem;
    border-radius: 14px;
    border: 1px solid rgba(148, 163, 184, 0.25);
    background: linear-gradient(180deg, var(--card-bg) 0%, rgba(255,255,255,0.98) 100%);
    box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
    color: #0f172a;
    text-decoration: none;
    text-align: center;
    transition: all 0.2s ease;
  }

  .mobile-menu-card:hover {
    text-decoration: none;
    transform: translateY(-2px);
    box-shadow: 0 10px 22px rgba(15, 23, 42, 0.12);
    color: #0f172a;
  }

  .mobile-menu-icon {
    width: 42px;
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    background: rgba(255,255,255,0.7);
    color: var(--card-accent);
    font-size: 1.15rem;
    margin-bottom: 0.45rem;
    box-shadow: inset 0 0 0 1px rgba(255,255,255,0.35);
  }

  .mobile-menu-label {
    font-size: 0.6rem;
    font-weight: 800;
    line-height: 1.2;
    letter-spacing: 0.01em;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    word-break: break-word;
  }

  .mobile-menu-group {
    margin-bottom: 0.9rem;
  }

  .mobile-menu-group-title {
    font-size: 0.68rem;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: #64748b;
    margin: 0 0 0.45rem 0.15rem;
    font-weight: 800;
  }

  @media (max-width: 767.98px) {
    .mobile-dashboard-menu {
      display: block;
    }

    .mobile-menu-grid {
      grid-template-columns: repeat(4, minmax(0, 1fr));
      gap: 0.45rem;
    }

    .mobile-menu-card {
      min-height: 88px;
      padding: 0.5rem 0.25rem;
      border-radius: 11px;
    }

    .mobile-menu-icon {
      width: 34px;
      height: 34px;
      font-size: 0.95rem;
      border-radius: 10px;
      margin-bottom: 0.35rem;
    }

    .mobile-menu-label {
      font-size: 0.56rem;
      line-height: 1.15;
    }

    .mobile-menu-group-title {
      font-size: 0.62rem;
      margin-bottom: 0.3rem;
    }
  }

</style>

@php
    $dashboardGroups = [
        [
            'group' => 'barang',
            'label' => 'Barang',
            'items' => [
                ['label' => 'Data Barang', 'key' => 'barang', 'icon' => 'fa-boxes-stacked', 'route' => route('barang.indexnew'), 'accent' => '#2563eb', 'bg' => '#e0ecff'],
            ],
        ],
        [
            'group' => 'opi',
            'label' => 'OPI',
            'items' => [
                ['label' => 'OPI', 'key' => 'opi', 'icon' => 'fa-clipboard-check', 'route' => route('opinew'), 'accent' => '#0f766e', 'bg' => '#dff9f6'],
            ],
        ],
        [
            'group' => 'mastercard',
            'label' => 'Master Card',
            'items' => [
                ['label' => 'Master Card', 'key' => 'mastercard', 'icon' => 'fa-file-invoice', 'route' => route('mastercard.index_new'), 'accent' => '#dc2626', 'bg' => '#ffe3e3'],
            ],
        ],
        [
            'group' => 'accounting',
            'label' => 'Accounting',
            'items' => [
                ['label' => 'Data Customer', 'key' => 'accounting.cust', 'icon' => 'fa-user', 'route' => route('acc.cust'), 'accent' => '#7c3aed', 'bg' => '#efe7ff'],
                ['label' => 'Data Vendor TT', 'key' => 'accounting.vendortt', 'icon' => 'fa-building-columns', 'route' => route('acc.vendortt'), 'accent' => '#7c3aed', 'bg' => '#efe7ff'],
                ['label' => 'Data Piutang', 'key' => 'accounting.piutang', 'icon' => 'fa-wallet', 'route' => route('acc.piutang'), 'accent' => '#7c3aed', 'bg' => '#efe7ff'],
                ['label' => 'Export Kontrak', 'key' => 'accounting.kontrak', 'icon' => 'fa-file-export', 'route' => route('acc.kontrak.index'), 'accent' => '#7c3aed', 'bg' => '#efe7ff'],
                ['label' => 'Print Alamat', 'key' => 'accounting.alamat', 'icon' => 'fa-map-location-dot', 'route' => route('data.alamat'), 'accent' => '#7c3aed', 'bg' => '#efe7ff'],
                ['label' => 'Import JU', 'key' => 'accounting.finance', 'icon' => 'fa-file-import', 'route' => route('finance'), 'accent' => '#7c3aed', 'bg' => '#efe7ff'],
                ['label' => 'Approve MOD', 'key' => 'accounting.mod', 'icon' => 'fa-check-to-slot', 'route' => route('acc.mod.index'), 'accent' => '#7c3aed', 'bg' => '#efe7ff'],
                ['label' => 'Approve OPI', 'key' => 'accounting.opi', 'icon' => 'fa-clipboard-check', 'route' => route('acc.opi'), 'accent' => '#7c3aed', 'bg' => '#efe7ff'],
            ],
        ],
        [
            'group' => 'inventory',
            'label' => 'Inventory',
            'items' => [
                ['label' => 'Retur Penjualan', 'key' => 'logistik.retur', 'icon' => 'fa-rotate-left', 'route' => route('barang.retur'), 'accent' => '#f59e0b', 'bg' => '#fff3d6'],
                ['label' => 'BP Baru', 'key' => 'logistik.bp_baru', 'icon' => 'fa-cube', 'route' => route('fb.list.bp'), 'accent' => '#f59e0b', 'bg' => '#fff3d6'],
                ['label' => 'BP Sheet', 'key' => 'logistik.bp_sheet', 'icon' => 'fa-sheet-plastic', 'route' => route('fb.list.bp_sheet'), 'accent' => '#f59e0b', 'bg' => '#fff3d6'],
                ['label' => 'BP Lama', 'key' => 'logistik.bp_lama', 'icon' => 'fa-box-archive', 'route' => route('fb.list.bp_lama'), 'accent' => '#f59e0b', 'bg' => '#fff3d6'],
                ['label' => 'Supplier', 'key' => 'inventory.supplier', 'icon' => 'fa-truck-field', 'route' => route('supplier-roll.index'), 'accent' => '#f97316', 'bg' => '#ffedd5'],
                ['label' => 'Inventory', 'key' => 'inventory.inventory', 'icon' => 'fa-box-open', 'route' => route('inventory.index'), 'accent' => '#f97316', 'bg' => '#ffedd5'],
                ['label' => 'BBK Roll', 'key' => 'inventory.bbk_roll', 'icon' => 'fa-clipboard-list', 'route' => route('bbk-roll.index'), 'accent' => '#f97316', 'bg' => '#ffedd5'],
            ],
        ],
        [
            'group' => 'master',
            'label' => 'Master',
            'items' => [
                ['label' => 'Divisi', 'key' => 'master.divisi', 'icon' => 'fa-sitemap', 'route' => route('divisi'), 'accent' => '#14b8a6', 'bg' => '#dffcf8'],
                ['label' => 'Flute', 'key' => 'master.flute', 'icon' => 'fa-cubes', 'route' => route('flute'), 'accent' => '#14b8a6', 'bg' => '#dffcf8'],
                ['label' => 'Jenis Gram', 'key' => 'master.jenisgram', 'icon' => 'fa-ruler-combined', 'route' => route('jenisgram'), 'accent' => '#14b8a6', 'bg' => '#dffcf8'],
                ['label' => 'Joint', 'key' => 'master.joint', 'icon' => 'fa-link', 'route' => route('joint'), 'accent' => '#14b8a6', 'bg' => '#dffcf8'],
                ['label' => 'Koli', 'key' => 'master.koli', 'icon' => 'fa-box', 'route' => route('koli'), 'accent' => '#14b8a6', 'bg' => '#dffcf8'],
                ['label' => 'Mata Uang', 'key' => 'master.matauang', 'icon' => 'fa-money-bill-wave', 'route' => route('matauang'), 'accent' => '#14b8a6', 'bg' => '#dffcf8'],
                ['label' => 'Sales', 'key' => 'master.sales', 'icon' => 'fa-user-tie', 'route' => route('sales'), 'accent' => '#14b8a6', 'bg' => '#dffcf8'],
                ['label' => 'Satuan', 'key' => 'master.satuan', 'icon' => 'fa-balance-scale', 'route' => route('satuan'), 'accent' => '#14b8a6', 'bg' => '#dffcf8'],
                ['label' => 'Sheet', 'key' => 'master.sheet', 'icon' => 'fa-table-cells-large', 'route' => route('sheet'), 'accent' => '#14b8a6', 'bg' => '#dffcf8'],
                ['label' => 'Supplier', 'key' => 'master.supplier', 'icon' => 'fa-truck', 'route' => route('supplier'), 'accent' => '#14b8a6', 'bg' => '#dffcf8'],
            ],
        ],
        [
            'group' => 'marketing',
            'label' => 'Marketing',
            'items' => [
                ['label' => 'Tipe Box', 'key' => 'marketing.boxtype', 'icon' => 'fa-boxes', 'route' => route('boxtype'), 'accent' => '#ec4899', 'bg' => '#ffe3f3'],
                ['label' => 'Substance', 'key' => 'marketing.substance', 'icon' => 'fa-flask', 'route' => route('substance'), 'accent' => '#ec4899', 'bg' => '#ffe3f3'],
                ['label' => 'Box', 'key' => 'marketing.box', 'icon' => 'fa-cube', 'route' => route('box'), 'accent' => '#ec4899', 'bg' => '#ffe3f3'],
                ['label' => 'Warna', 'key' => 'marketing.warna', 'icon' => 'fa-palette', 'route' => route('warna'), 'accent' => '#ec4899', 'bg' => '#ffe3f3'],
                ['label' => 'Color Combine', 'key' => 'marketing.colorcombine', 'icon' => 'fa-paintbrush', 'route' => route('colorcombine'), 'accent' => '#ec4899', 'bg' => '#ffe3f3'],
                ['label' => 'Kontrak', 'key' => 'marketing.kontrak', 'icon' => 'fa-file-contract', 'route' => route('kontraknew'), 'accent' => '#ec4899', 'bg' => '#ffe3f3'],
                ['label' => 'Delivery Time', 'key' => 'marketing.dt', 'icon' => 'fa-clock', 'route' => route('dt'), 'accent' => '#ec4899', 'bg' => '#ffe3f3'],
                ['label' => 'Plan Kirim', 'key' => 'marketing.plan_kirim', 'icon' => 'fa-truck-fast', 'route' => route('opi.plan_kirim'), 'accent' => '#ec4899', 'bg' => '#ffe3f3'],
                ['label' => 'Export Intake', 'key' => 'marketing.intake', 'icon' => 'fa-file-arrow-up', 'route' => route('opi.intake'), 'accent' => '#ec4899', 'bg' => '#ffe3f3'],
                ['label' => 'Alokasi Karet', 'key' => 'marketing.karet', 'icon' => 'fa-clipboard-list', 'route' => route('karet.index'), 'accent' => '#ec4899', 'bg' => '#ffe3f3'],
                ['label' => 'Target Customer', 'key' => 'marketing.forecast', 'icon' => 'fa-chart-line', 'route' => route('forecast.tonase.index'), 'accent' => '#ec4899', 'bg' => '#ffe3f3'],
                ['label' => 'Form Permintaan', 'key' => 'marketing.formpermintaan', 'icon' => 'fa-pen-to-square', 'route' => route('mkt.list.formpermintaan'), 'accent' => '#ec4899', 'bg' => '#ffe3f3'],
                ['label' => 'Form Mastercard', 'key' => 'marketing.formmc', 'icon' => 'fa-file-invoice', 'route' => route('mkt.list.formmc'), 'accent' => '#ec4899', 'bg' => '#ffe3f3'],
                ['label' => 'MOD', 'key' => 'marketing.mod', 'icon' => 'fa-folder-open', 'route' => route('mkt.index.mod'), 'accent' => '#ec4899', 'bg' => '#ffe3f3'],
                ['label' => 'List MOD by Tanggal', 'key' => 'marketing.mod_tanggal', 'icon' => 'fa-calendar-days', 'route' => route('mod.by.tanggal'), 'accent' => '#ec4899', 'bg' => '#ffe3f3'],
            ],
        ],
        [
            'group' => 'ppic',
            'label' => 'PPIC',
            'items' => [
                ['label' => 'Persediaan Roll', 'key' => 'ppic.roll', 'icon' => 'fa-clipboard-list', 'route' => route('roll'), 'accent' => '#3b82f6', 'bg' => '#dfeeff'],
                ['label' => 'BBM Roll', 'key' => 'ppic.bbm_roll', 'icon' => 'fa-truck', 'route' => route('roll.bbm'), 'accent' => '#3b82f6', 'bg' => '#dfeeff'],
                ['label' => 'BBK Roll', 'key' => 'ppic.bbk_roll', 'icon' => 'fa-boxes-stacked', 'route' => route('bbk-roll.index'), 'accent' => '#3b82f6', 'bg' => '#dfeeff'],
                // ['label' => 'Retur Roll', 'key' => 'ppic.retur_roll', 'icon' => 'fa-rotate-left', 'route' => route('retur_roll'), 'accent' => '#3b82f6', 'bg' => '#dfeeff'],
                ['label' => 'Warna', 'key' => 'ppic.warna', 'icon' => 'fa-palette', 'route' => route('warna'), 'accent' => '#3b82f6', 'bg' => '#dfeeff'],
                ['label' => 'Plan Corrugating', 'key' => 'ppic.corrplan', 'icon' => 'fa-clipboard-check', 'route' => route('admin.corrplan.index'), 'accent' => '#3b82f6', 'bg' => '#dfeeff'],
                ['label' => 'Plan Converting', 'key' => 'ppic.conv', 'icon' => 'fa-industry', 'route' => route('conv'), 'accent' => '#3b82f6', 'bg' => '#dfeeff'],
                ['label' => 'Karet', 'key' => 'ppic.karet', 'icon' => 'fa-ribbon', 'route' => route('ppic.karet'), 'accent' => '#3b82f6', 'bg' => '#dfeeff'],
            ],
        ],
        [
            'group' => 'produksi',
            'label' => 'Produksi',
            'items' => [
                ['label' => 'Hasil Produksi', 'key' => 'produksi.hasil', 'icon' => 'fa-industry', 'route' => route('conv.hasilflexo'), 'accent' => '#059669', 'bg' => '#dffcf1'],
                ['label' => 'Laporan Produksi', 'key' => 'produksi.laporan', 'icon' => 'fa-chart-column', 'route' => route('lap.produksi'), 'accent' => '#059669', 'bg' => '#dffcf1'],
            ],
        ],
        [
            'group' => 'palet',
            'label' => 'Palet',
            'items' => [
                ['label' => 'Surat Jalan Palet', 'key' => 'palet.sj', 'icon' => 'fa-truck-ramp-box', 'route' => route('sj_palet'), 'accent' => '#0ea5e9', 'bg' => '#dff6ff'],
                ['label' => 'Palet', 'key' => 'palet.palet', 'icon' => 'fa-boxes', 'route' => route('palet'), 'accent' => '#0ea5e9', 'bg' => '#dff6ff'],
            ],
        ],
        [
            'group' => 'qc',
            'label' => 'QC',
            'items' => [
                ['label' => 'COA', 'key' => 'qc.coa', 'icon' => 'fa-shield-check', 'route' => route('qc.index'), 'accent' => '#22c55e', 'bg' => '#dcfce7'],
            ],
        ],
        [
            'group' => 'teknik',
            'label' => 'Teknik',
            'items' => [
                ['label' => 'List Barang', 'key' => 'teknik.barang', 'icon' => 'fa-screwdriver-wrench', 'route' => route('fb.list.teknik'), 'accent' => '#475569', 'bg' => '#e2e8f0'],
            ],
        ],
        [
            'group' => 'hrd_ga',
            'label' => 'HRD & GA',
            'items' => [
                ['label' => 'Stationary', 'key' => 'hrd_ga.stationary', 'icon' => 'fa-user-tie', 'route' => route('stationary.barang'), 'accent' => '#a855f7', 'bg' => '#f3e8ff'],
            ],
        ],
        [
            'group' => 'vehicle.list',
            'label' => 'Vehicle',
            'items' => [
                ['label' => 'Vehicle List', 'key' => 'vehicle.list', 'icon' => 'fa-truck', 'route' => route('vehicle.index'), 'accent' => '#0891b2', 'bg' => '#cffafe'],
            ],
        ],
        [
            'group' => 'reports',
            'label' => 'Reports',
            'items' => [
                ['label' => 'Deadstock Report', 'key' => 'reports.deadstock', 'icon' => 'fa-chart-column', 'route' => route('admin.report.deadstock'), 'accent' => '#ef4444', 'bg' => '#fee2e2'],
                ['label' => 'Kapasitas Gudang', 'key' => 'reports.kapasitas', 'icon' => 'fa-warehouse', 'route' => route('admin.report.kapasitas'), 'accent' => '#ef4444', 'bg' => '#fee2e2'],
                ['label' => 'In/Out Bound', 'key' => 'reports.in_out_bound', 'icon' => 'fa-arrows-left-right', 'route' => route('admin.report.in_out_bound'), 'accent' => '#ef4444', 'bg' => '#fee2e2'],
            ],
        ],
    ];

    $visibleDashboardMenus = [];
    foreach ($dashboardGroups as $group) {
        $items = collect($group['items'])->filter(function ($item) {
            return hasMenuAccess($item['key']);
        })->values()->all();

        if (!empty($items)) {
            $visibleDashboardMenus[] = [
                'group' => $group['label'],
                'items' => $items,
            ];
        }
    }
@endphp

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      @if(!empty($visibleDashboardMenus))
        <div class="mb-3 mobile-dashboard-menu">
          @foreach($visibleDashboardMenus as $menuGroup)
            <div class="mobile-menu-group">
              <h6 class="mobile-menu-group-title">{{ $menuGroup['group'] }}</h6>
              <div class="mobile-menu-grid">
                @foreach($menuGroup['items'] as $menu)
                  @if(hasMenuAccess($menu['key']))
                    <a href="{{ $menu['route'] }}" class="mobile-menu-card" style="--card-accent: {{ $menu['accent'] }}; --card-bg: {{ $menu['bg'] }};">
                      <div class="mobile-menu-icon">
                        <i class="fa-solid {{ $menu['icon'] }}"></i>
                      </div>
                      <div class="mobile-menu-label">{{ $menu['label'] }}</div>
                    </a>
                  @endif
                @endforeach
              </div>
            </div>
          @endforeach
        </div>
      @endif

      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{ $jumlah_kontrak }}</h3>

              <p>Kontrak Baru {{ date('m-Y') }}</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3>{{ number_format($tonase,2,',','.') }}<sup style="font-size: 20px">   Kg</sup></h3>

              <p>Estimasi Tonase {{ date('m-Y') }}</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{ number_format($realisasi,2,',','.') }}<sup style="font-size: 20px">   Kg</sup></h3>

              <p>Tonase Pengiriman {{ date('m-Y') }}</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>65</h3>

              <p>Unique Visitors</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      @if (Auth::user()->divisi_id == 3 || Auth::user()->divisi_id == 2)

      <div class="col-md-6">
          <!-- LINE CHART -->
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Chart Penjualan</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body" >
              <div class="chart">
                <input type="hidden" id="periode" value="{{ $periode }}">
                <input type="hidden" id="tonase" value="{{ $hasil }}">
                <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
      </div>
      @endif
      @if (Auth::user()->divisi_id == 13)
        <div class="col-md-6 p-3 text-left  border bg-gray-300">
          <h5 class="mb-0">Terdapat {{ count($kontrak_open) }} Kontrak yang berstatus OPEN. <a href="{{ route('kontrak.opened') }}"> click to see Details</a></h5>

        </div>
      @endif
      @if (Auth::user()->divisi_id == 5 || Auth::user()->divisi_id == 2)
        <div class="col-md-12 mt-3">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-history mr-1"></i> Activity Tracking
              </h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body p-0" style="max-height: 600px; overflow-y: auto;">
              @if(isset($tracking_updates) && $tracking_updates->count() > 0)
                <div class="table-responsive">
                  <table class="table table-sm table-hover table-striped mb-0">
                    <thead class="thead-light">
                      <tr>
                        <th style="width: 40px;">#</th>
                        <th>User</th>
                        <th>Tipe</th>
                        <th>Event</th>
                        <th>Sebelum Perubahan</th>
                        <th>Setelah Perubahan</th>
                        <th style="white-space: nowrap;">Waktu</th>
                      </tr>
                    </thead>
                    <tbody id="tracking-tbody">
                      @foreach($tracking_updates as $i => $track)
                        @php
                          $beforeDecoded = json_decode($track->before, true);
                          $afterDecoded  = json_decode($track->after, true);
                          $tipeColorMap = [
                              'Kontrak'         => 'badge-success',
                              'OPI'             => 'badge-warning',
                              'Mastercard'      => 'badge-danger',
                              'Box'             => 'badge-info',
                              'Realisasi Kirim' => 'badge-secondary',
                              'Color Combine'   => 'badge-light',
                              'Form MC'         => 'badge-dark',
                              'Form Permintaan' => 'badge-primary',
                              'Plan Produksi'   => 'badge-warning',
                              'Profile'         => 'badge-secondary',
                          ];
                          $tipeColor = isset($tipeColorMap[$track->tipe]) ? $tipeColorMap[$track->tipe] : 'badge-secondary';

                          // Hanya ambil field yang berubah
                          $changedKeys = [];
                          if ($beforeDecoded && is_array($beforeDecoded) && $afterDecoded && is_array($afterDecoded)) {
                              foreach ($afterDecoded as $k => $v) {
                                  $oldVal = isset($beforeDecoded[$k]) ? $beforeDecoded[$k] : null;
                                  if ((string)$oldVal !== (string)$v) {
                                      $changedKeys[] = $k;
                                  }
                              }
                          }
                        @endphp
                        <tr>
                          <td class="text-muted">{{ $i + 1 }}</td>
                          <td>
                            <span class="badge badge-primary">{{ $track->user }}</span>
                          </td>
                          <td style="white-space: nowrap;">
                            <span class="badge {{ $tipeColor }}">{{ $track->tipe ?? '-' }}</span>
                          </td>
                          <td>{{ $track->event }}</td>
                          <td style="font-size: 0.82em; max-width: 220px;">
                            @if($beforeDecoded && is_array($beforeDecoded) && count($changedKeys) > 0)
                              @foreach($changedKeys as $key)
                                @if(isset($beforeDecoded[$key]))
                                  <div><span class="text-muted">{{ $key }}:</span> {{ $beforeDecoded[$key] ?? '-' }}</div>
                                @endif
                              @endforeach
                            @elseif(!$beforeDecoded || !is_array($beforeDecoded))
                              <span class="text-muted">{{ $track->before ?? '-' }}</span>
                            @else
                              <span class="text-muted">-</span>
                            @endif
                          </td>
                          <td style="font-size: 0.82em; max-width: 220px;">
                            @if($afterDecoded && is_array($afterDecoded) && count($changedKeys) > 0)
                              @foreach($changedKeys as $key)
                                @if(isset($afterDecoded[$key]))
                                  <div class="font-weight-bold text-success">
                                    <span class="text-muted">{{ $key }}:</span> {{ $afterDecoded[$key] ?? '-' }}
                                  </div>
                                @endif
                              @endforeach
                            @elseif(!$afterDecoded || !is_array($afterDecoded))
                              <span class="text-muted">{{ $track->after ?? '-' }}</span>
                            @else
                              <span class="text-success">-</span>
                            @endif
                          </td>
                          <td class="text-muted" style="white-space: nowrap; font-size: 0.85em;">
                            {{ \Carbon\Carbon::parse($track->created_at)->format('d/m/Y H:i') }}
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              @else
                <div class="text-center text-muted p-4">
                  <i class="fas fa-inbox fa-2x mb-2"></i>
                  <p class="mb-0">Belum ada aktivitas terbaru.</p>
                </div>
              @endif
            </div>
          </div>
        </div>
      @endif
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>

<script>
  $(function () {

    var all_periode = document.getElementById('periode').value;
    var tonase = document.getElementById('tonase').value;
    var periode = all_periode.split("/")
    var data = tonase.split("/")

    // var per

    var areaChartData = {
      labels  : periode,
      datasets: [
        // {
        //   label               : 'Digital Goods',
        //   backgroundColor     : 'rgba(60,141,188,0.9)',
        //   borderColor         : 'rgba(60,141,188,0.8)',
        //   pointRadius          : false,
        //   pointColor          : '#3b8bba',
        //   pointStrokeColor    : 'rgba(60,141,188,1)',
        //   pointHighlightFill  : '#fff',
        //   pointHighlightStroke: 'rgba(60,141,188,1)',
        //   data                : [28, 48, 40, 19, 86, 27, 90]
        // },
        {
          label               : 'Penjualan',
          barPercentage       : 0.8,
          backgroundColor     : 'rgba(255, 0, 0, 0.8)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : true,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#000',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : data
        },
      ]
    }

    // var areaChartOptions = {
    //   maintainAspectRatio : false,
    //   responsive : true,
    //   legend: {
    //     display: true
    //   },
    //   scales: {
    //     xAxes: [{
    //       gridLines : {
    //         display : true,
    //       }
    //     }],
    //     yAxes: [{
    //       gridLines : {
    //         display : true,
    //       }
    //     }]
    //   }
    // }
    // //-------------
    // //- LINE CHART -
    // //--------------
    // var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
    // var lineChartOptions = $.extend(true, {}, areaChartOptions)
    // var lineChartData = $.extend(true, {}, areaChartData)
    // lineChartData.datasets[0].fill = false;
    // // lineChartData.datasets[1].fill = false;
    // lineChartOptions.datasetFill = false

    // var lineChart = new Chart(lineChartCanvas, {
    //   type: 'line',
    //   data: lineChartData,
    //   options: lineChartOptions
    // })

    var barChartCanvas = $('#lineChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[0] = temp0

    var barChartOptions = {
      locale  : 'en-US',
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })
  })
</script>

<script>
(function($) {
    if (!$('#tracking-tbody').length) return;

    var tipeColorMap = {
        'Kontrak': 'badge-success', 'OPI': 'badge-warning', 'Mastercard': 'badge-danger',
        'Box': 'badge-info', 'Realisasi Kirim': 'badge-secondary', 'Color Combine': 'badge-light',
        'Form MC': 'badge-dark', 'Form Permintaan': 'badge-primary',
        'Plan Produksi': 'badge-warning', 'Profile': 'badge-secondary'
    };

    function esc(v) {
        if (v === null || v === undefined) return '-';
        return String(v).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    }

    function fmtDate(s) {
        var d = new Date(s);
        return [String(d.getDate()).padStart(2,'0'), String(d.getMonth()+1).padStart(2,'0'), d.getFullYear()].join('/')
            + ' ' + [String(d.getHours()).padStart(2,'0'), String(d.getMinutes()).padStart(2,'0')].join(':');
    }

    function buildRows(data) {
        if (!data.length) return '<tr><td colspan="7" class="text-center text-muted p-3">Belum ada aktivitas terbaru.</td></tr>';
        return data.map(function(t, i) {
            var bef = null, aft = null;
            try { bef = t.before ? JSON.parse(t.before) : null; } catch(e) {}
            try { aft = t.after  ? JSON.parse(t.after)  : null; } catch(e) {}

            var changed = [];
            if (bef && typeof bef === 'object' && aft && typeof aft === 'object') {
                Object.keys(aft).forEach(function(k) {
                    if (String(bef[k] !== undefined ? bef[k] : null) !== String(aft[k])) changed.push(k);
                });
            }

            var befHtml = '', aftHtml = '';
            if (changed.length && bef && typeof bef === 'object') {
                changed.forEach(function(k) { if (bef[k] !== undefined) befHtml += '<div><span class="text-muted">'+esc(k)+':</span> '+esc(bef[k])+'</div>'; });
                changed.forEach(function(k) { if (aft[k] !== undefined) aftHtml += '<div class="font-weight-bold text-success"><span class="text-muted">'+esc(k)+':</span> '+esc(aft[k])+'</div>'; });
            } else if (!bef || typeof bef !== 'object') {
                befHtml = '<span class="text-muted">'+esc(t.before)+'</span>';
                aftHtml = '<span class="text-muted">'+esc(t.after)+'</span>';
            } else {
                befHtml = aftHtml = '<span class="text-muted">-</span>';
            }

            return '<tr><td class="text-muted">'+(i+1)+'</td>'
                +'<td><span class="badge badge-primary">'+esc(t.user)+'</span></td>'
                +'<td style="white-space:nowrap;"><span class="badge '+(tipeColorMap[t.tipe]||'badge-secondary')+'">'+esc(t.tipe)+'</span></td>'
                +'<td>'+esc(t.event)+'</td>'
                +'<td style="font-size:0.82em;max-width:220px;">'+befHtml+'</td>'
                +'<td style="font-size:0.82em;max-width:220px;">'+aftHtml+'</td>'
                +'<td class="text-muted" style="white-space:nowrap;font-size:0.85em;">'+fmtDate(t.created_at)+'</td></tr>';
        }).join('');
    }

    function refreshTracking() {
        $.getJSON('{{ route("admin.tracking.json") }}', function(data) {
            $('#tracking-tbody').html(buildRows(data));
        });
    }

    // Auto-refresh setiap 1 menit
    setInterval(refreshTracking, 1 * 60 * 1000);
})(jQuery);
</script>
@endsection
