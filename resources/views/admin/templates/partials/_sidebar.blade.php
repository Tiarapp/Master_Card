 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="{{ asset('asset/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">PT. SPA</span>
  </a>
  
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ asset('asset/dist/img/profile.png') }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
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
          {{-- Accounting --}}
          @if (Auth::user()->divisi_id == 2 || Auth::user()->divisi_id == 1)
            <li class="nav-item">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Accounting
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('acc.kontrak.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                      <p>Export Kontrak</p>
                  </a>
                </li>
              </ul>
            </li>
          @endif
          {{-- Marketing --}}
          @if (Auth::user()->divisi_id == 2 || Auth::user()->divisi_id == 3)
            <li class="nav-item">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Master
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('barang') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Barang</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('divisi') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Divisi</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href={{ route('flute') }} class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Flute</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('jenisgram') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Jenis Gram</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('joint') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Joint</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('koli') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Koli</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('matauang') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Mata Uang</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('sales') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Sales</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('satuan') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Satuan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('sheet') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Sheet</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('supplier') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Supplier</p>
                  </a>
                </li>
                {{-- <li class="nav-item">
                  <a href="{{ route('data.cust') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Customer</p>
                  </a>
                </li> --}}
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Marketing
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview"> 
                <li class="nav-item">
                  <a href="{{ route('boxtype') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Tipe Box</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('substance') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Substance</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('box') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Box</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('warna') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Warna</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('colorcombine') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Color Combine</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('mastercard.b1') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Master Card</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('kontrak') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Kontrak</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('dt') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Delivery Time</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('opi') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>OPI</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('ppic.opi.approve') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Rekap OPI</p>
                  </a>
                </li>
              </ul>
            </li>
          @endif
          {{-- PPIC --}}
          @if (Auth::user()->divisi_id == 5 || Auth::user()->divisi_id == 2)
            <li class="nav-item">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  PPIC
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview"> 
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>PPIC - ROLL</p>
                  </a><ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="{{ route('roll') }}" class="nav-link">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Persediaan Roll</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="{{ route('roll.bbm') }}" class="nav-link">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>BBM Roll</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>BBK Roll</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Retur Roll</p>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
              <ul class="nav nav-treeview"> 
                <li class="nav-item">
                  <a href="{{ route('mastercard.b1') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Master Card</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('warna') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Warna</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('indexcorr') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Plan Corrugating</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('conv') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Plan Converting</p>
                  </a>
                </li>
                {{-- <li class="nav-item">
                  <a href="{{ route('ppic.opi') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>OPI</p>
                  </a>
                </li> --}}
                <li class="nav-item">
                  <a href="{{ route('opi') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>OPI</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('hasilcorr') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Control</p>
                  </a>
                </li>
              </ul>
            </li>
          @endif
          @if (Auth::user()->divisi_id == 5 || Auth::user()->divisi_id == 2)
            <li class="nav-item">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  PRODUKSI
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview"> 
                <li class="nav-item">
                  <a href="{{ route('conv.hasilflexo') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Hasil Produksi</p>
                  </a>
                </li> 
                <li class="nav-item">
                  <a href="{{ route('lap.produksi') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Laporan Produksi</p>
                  </a>
                </li>
              </ul>
            </li>
          @endif
          @if (Auth::user()->divisi_id == 10 || Auth::user()->divisi_id == 2)
            <li class="nav-item">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Palet
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('sj_palet') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Surat Jalan Palet</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('palet') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Palet</p>
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