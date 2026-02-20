 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="{{ asset('asset/image/logo.jpg') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8; height: 30px; width: 30px">
    <span class="brand-text font-weight-light">{{ getCurrentCompanyName() }}</span>
  </a>
  
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ asset('asset/dist/img/profile.png') }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="{{ route('profile.index') }}" class="d-block">{{ Auth::user()->name }}</a>
        <small class="text-muted">
          <a href="{{ route('profile.change-password') }}" class="text-sm">
            <i class="fas fa-key fa-xs"></i> Ubah Password
          </a>
        </small>
        @if(Auth::user()->company)
          <small class="text-info d-block">{{ Auth::user()->company->name }}</small>
        @endif
      </div>
    </div>
    
    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>
    
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
          with font-awesome or any other icon font library -->
          
          {{-- Shared Menu: Barang - accessible by multiple divisions and companies --}}
          @if ((hasMenuAccess('barang') && getDivisiMenuAccess([2, 3, 5, 6, 13])) || (!Auth::user()->company_id && getDivisiMenuAccess([2, 3, 5, 6, 13])))
            <li class="nav-item">
              <a href="{{ route('barang.indexnew') }}" class="nav-link">
                <i class="fa-solid fa-boxes-stacked nav-icon"></i>
                <p>Data Barang</p>
              </a>
            </li>
          @endif

          {{-- Shared Menu: OPI - accessible by multiple divisions and companies --}}
          @if ((hasMenuAccess('opi') && getDivisiMenuAccess([2, 3, 5, 9, 13])) || (!Auth::user()->company_id && getDivisiMenuAccess([2, 3, 5, 9, 13])))
            <li class="nav-item">
              <a href="{{ route('opinew') }}" class="nav-link">
                <i class="fa-solid fa-clipboard-check nav-icon"></i>
                <p>OPI</p>
              </a>
            </li>
          @endif

          {{-- Shared Menu: Master Card - accessible by multiple divisions and companies --}}
          @if ((hasMenuAccess('mastercard') && getDivisiMenuAccess([2, 3, 5, 13])) || (!Auth::user()->company_id && getDivisiMenuAccess([2, 3, 5, 13])))
            <li class="nav-item">
              <a href="{{ route('mastercard.b1') }}" class="nav-link">
                <i class="fa-solid fa-file-invoice nav-icon"></i>
                <p>Master Card</p>
              </a>
            </li>
          @endif
          
          {{-- Accounting --}}
          @if ((hasMenuAccess('accounting') && getDivisiMenuAccess([2, 1])) || (!Auth::user()->company_id && getDivisiMenuAccess([2, 1])))
            <li class="nav-item {{ request()->routeIs('acc.*') ? 'menu-open' : '' }}">
              <a href="#" class="nav-link {{ request()->routeIs('acc.*') ? 'active' : '' }}">
                <i class="fa-solid fa-calculator nav-icon"></i>
                <p>
                  Accounting
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('acc.cust') }}" class="nav-link {{ request()->routeIs('acc.cust') ? 'active' : '' }}">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Data Customer</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('acc.vendortt') }}" class="nav-link {{ request()->routeIs('acc.vendortt') ? 'active' : '' }}">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Data Vendor TT</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('acc.piutang') }}" class="nav-link {{ request()->routeIs('acc.piutang') ? 'active' : '' }}">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Data Piutang</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('acc.kontrak.index') }}" class="nav-link {{ request()->routeIs('acc.kontrak.*') ? 'active' : '' }}">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Export Kontrak</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('data.alamat') }}" class="nav-link {{ request()->routeIs('data.alamat') ? 'active' : '' }}">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Print Alamat</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('finance') }}" class="nav-link {{ request()->routeIs('finance') ? 'active' : '' }}">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Import JU</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('acc.mod.index') }}" class="nav-link {{ request()->routeIs('acc.mod.*') ? 'active' : '' }}">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Approve MOD</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('acc.opi') }}" class="nav-link {{ request()->routeIs('acc.opi*') ? 'active' : '' }}">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Approve OPI</p>
                  </a>
                </li>
              </ul>
            </li>
          @endif

          @if ((hasMenuAccess('logistik') && getDivisiMenuAccess([2, 6])) || (!Auth::user()->company_id && getDivisiMenuAccess([2, 6])))
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fa-solid fa-warehouse nav-icon"></i>
              <p>
                Logistik
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview"> 
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="fa-solid fa-toilet-paper nav-icon"></i>
                  <p>
                    Barang Jadi                    
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('barang.retur') }}" class="nav-link">
                      <i class="fas fa-circle nav-icon"></i>
                      <p>Retur Penjualan</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="{{ route('fb.list.bp') }}" class="nav-link">
                  <i class="fas fa-circle nav-icon"></i>
                  <p>BP Baru</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('fb.list.bp_lama') }}" class="nav-link">
                  <i class="fas fa-circle nav-icon"></i>
                  <p>BP Lama</p>
                </a>
              </li>
            </ul>
          </li>
          @endif

          {{-- Inventory Management --}}
          @if ((hasMenuAccess('inventory') && getDivisiMenuAccess([2, 6])) || (!Auth::user()->company_id && getDivisiMenuAccess([2, 6])))
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="fa-solid fa-warehouse nav-icon"></i>
                <p>
                  Inventory Management
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('supplier-roll.index') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Supplier</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('inventory.index') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Inventory</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('bbk-roll.index') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>BBK Roll</p>
                  </a>
                </li>
                {{-- <li class="nav-item">
                  <a href="{{ route('potongan.index') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Potongan</p>
                  </a>
                </li> --}}
              </ul>
            </li>
          @endif

          {{-- Master --}}
          @if ((hasMenuAccess('master') && getDivisiMenuAccess([2, 3, 13])) || (!Auth::user()->company_id && getDivisiMenuAccess([2, 3, 13])))
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Master
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('divisi') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Divisi</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href={{ route('flute') }} class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Flute</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('jenisgram') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Jenis Gram</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('joint') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Joint</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('koli') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Koli</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('matauang') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Mata Uang</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('sales') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Sales</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('satuan') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Satuan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('sheet') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Sheet</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('supplier') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Supplier</p>
                  </a>
                </li>
              </ul>
            </li>
            {{-- Marketing --}}
            @if ((hasMenuAccess('marketing') && getDivisiMenuAccess([2, 3, 13])) || (!Auth::user()->company_id && getDivisiMenuAccess([2, 3, 13])))
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="fa-solid fa-comment-dollar nav-icon"></i>
                <p>
                  Marketing
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview"> 
                <li class="nav-item">
                  <a href="{{ route('boxtype') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Tipe Box</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('substance') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Substance</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('box') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Box</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('warna') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Warna</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('colorcombine') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Color Combine</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('kontraknew') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Kontrak</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('dt') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Delivery Time</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('opi.plan_kirim') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Plan Kirim</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('opi.intake') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Export Intake</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('karet.index') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Alokasi Karet</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('forecast.tonase.index') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Target Customer</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="fa-solid fa-user-pen nav-icon"></i>
                <p>
                  Adm Marketing
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview"> 
                <li class="nav-item">
                  <a href="{{ route('mkt.list.formpermintaan') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Form Permintaan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('mkt.list.formmc') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Form Mastercard</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('mkt.index.mod') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>MOD</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('mod.by.tanggal') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>List MOD by Tanggal</p>
                  </a>
                </li>
              </ul>
            </li>
            @endif
          @endif

          {{-- PPIC --}}
          @if ((hasMenuAccess('ppic') && getDivisiMenuAccess([5,2])) || (!Auth::user()->company_id && getDivisiMenuAccess([5,2])))
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="fa-solid fa-users-gear nav-icon"></i>
                <p>
                  PPIC
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview"> 
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="fa-solid fa-toilet-paper nav-icon"></i>
                    <p>
                      PPIC - ROLL                    
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="{{ route('roll') }}" class="nav-link">
                        <i class="fas fa-circle nav-icon"></i>
                        <p>Persediaan Roll</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="{{ route('roll.bbm') }}" class="nav-link">
                        <i class="fas fa-circle nav-icon"></i>
                        <p>BBM Roll</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="fas fa-circle nav-icon"></i>
                        <p>BBK Roll</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="fas fa-circle nav-icon"></i>
                        <p>Retur Roll</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item">
                  <a href="{{ route('warna') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Warna</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('admin.corrplan.index') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Plan Corrugating</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('conv') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Plan Converting</p>
                  </a>
                </li>
                {{-- <li class="nav-item">
                  <a href="{{ route('hasilcorr') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Control</p>
                  </a> --}}
                </li>
                <li class="nav-item">
                  <a href="{{ route('ppic.karet') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Karet</p>
                  </a>
                </li>
              </ul>
            </li>
          @endif
          @if ((hasMenuAccess('produksi') && getDivisiMenuAccess([5,2])) || (!Auth::user()->company_id && getDivisiMenuAccess([5,2])))
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="fa-solid fa-screwdriver-wrench nav-icon"></i>
                <p>
                  PRODUKSI
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview"> 
                <li class="nav-item">
                  <a href="{{ route('conv.hasilflexo') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Hasil Produksi</p>
                  </a>
                </li> 
                <li class="nav-item">
                  <a href="{{ route('lap.produksi') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Laporan Produksi</p>
                  </a>
                </li>
              </ul>
            </li>
          @endif
          @if ((hasMenuAccess('palet') && getDivisiMenuAccess([10,2])) || (!Auth::user()->company_id && getDivisiMenuAccess([10,2])))
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="fa-solid fa-chess-board nav-icon"></i>
                <p>
                  Palet
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('sj_palet') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Surat Jalan Palet</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('palet') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Palet</p>
                  </a>
                </li>
              </ul>
            </li>
          @endif
          @if ((hasMenuAccess('qc') && getDivisiMenuAccess([12,2])) || (!Auth::user()->company_id && getDivisiMenuAccess([12,2])))
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="fa-solid fa-medal nav-icon"></i>
                <p>
                  QC
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('qc.index') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>COA</p>
                  </a>
                </li>
              </ul>
            </li>
          @endif
          @if ((hasMenuAccess('teknik') && getDivisiMenuAccess([8,2])) || (!Auth::user()->company_id && getDivisiMenuAccess([8,2])))
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="fa-solid fa-wrench nav-icon"></i>
                <p>
                  Teknik
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('fb.list.teknik') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>List Barang</p>
                  </a>
                </li>
              </ul>
            </li>
          @endif
          @if ((hasMenuAccess('hrd_ga') && getDivisiMenuAccess([9,2])) || (!Auth::user()->company_id && getDivisiMenuAccess([9,2])))
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="fa-solid fa-user-pen nav-icon"></i>
                <p>
                  HRD/GA
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('stationary.barang') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Stationary</p>
                  </a>
                </li>
              </ul>
            </li>
          @endif
          @if ((hasMenuAccess('reports') && getDivisiMenuAccess([2,14])) || (!Auth::user()->company_id && getDivisiMenuAccess([2,14])))
            <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-chart-bar nav-icon"></i>
              <p>
                Reports
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.report.deadstock') }}" class="nav-link">
                  <i class="fas fa-warehouse nav-icon"></i>
                  <p>Deadstock Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.report.kapasitas') }}" class="nav-link">
                  <i class="fas fa-warehouse nav-icon"></i>
                  <p>Kapasitas Gudang</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.report.in_out_bound') }}" class="nav-link">
                  <i class="fas fa-exchange-alt nav-icon"></i>
                  <p>In/Out Bound</p>
                </a>
              </li>
            </ul>
          </li>
          @endif

          {{-- Feedback Menu - accessible by all users --}}
          @if ((hasMenuAccess('it_admin') && getDivisiMenuAccess([2])) || (!Auth::user()->company_id && getDivisiMenuAccess([2])))
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-comment-dots nav-icon"></i>
              <p>
                Feedback
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.feedback.create') }}" class="nav-link">
                  <i class="fas fa-plus nav-icon"></i>
                  <p>Kirim Feedback</p>
                </a>
              </li>
              {{-- @if ((hasMenuAccess('feedback_manage') && getDivisiMenuAccess([2])) || (!Auth::user()->company_id && getDivisiMenuAccess([2]))) Admin/IT only --}}
                <li class="nav-item">
                  <a href="{{ route('admin.feedback.index') }}" class="nav-link">
                    <i class="fas fa-list nav-icon"></i>
                    <p>Kelola Feedback</p>
                  </a>
                </li>
              {{-- @endif --}}
            </ul>
          </li>
          {{-- Hardware Management - Only for IT Division (divisi_id = 2) --}}
            <li class="nav-item">
              <a href="{{ route('hardware.index') }}" class="nav-link">
                <i class="fas fa-desktop nav-icon"></i>
                <p>Hardware Management</p>
              </a>
            </li>
            {{-- Company Management (Demo) - Only for IT Division --}}
            <li class="nav-item">
              <a href="{{ route('company.index') }}" class="nav-link">
                <i class="fas fa-building nav-icon"></i>
                <p>Company Management</p>
              </a>
            </li>
          @endif

          {{-- Menu Stellar --}}
          @if ((hasMenuAccess('stellar') && getDivisiMenuAccess([2])) || (!Auth::user()->company_id && getDivisiMenuAccess([2])))
            <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-comment-dots nav-icon"></i>
              <p>
                Bahan Pembantu
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('stellar.bp.index') }}" class="nav-link">
                  <i class="fas fa-plus nav-icon"></i>
                  <p>PHP</p>
                </a>
              </li>
            </ul>
          </li>
          @endif
        </ul>
        
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>