<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
      <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-store"></i>
      </div>
      <div class="sidebar-brand-text mx-3">TOKO <sup>ADRIAN</sup></div>
    </a>

    <!-- Divider -->
    {{-- <hr class="sidebar-divider my-0"> --}}

    <!-- Nav Item - Dashboard -->
    {{-- <li class="nav-item">
      <a class="nav-link" href="javascript:void(0)">
        <img class="img-profile rounded-circle" src="{{ asset('uploads') }}/moderator_images/{{ Auth::user()->image }}">
        <span>{{ Auth::user()->name }}</span></a>
    </li> --}}
    
    <!-- Divider -->
    {{-- <hr class="sidebar-divider"> --}}
    <hr class="sidebar-divider my-0">

    <!-- Heading -->
    <li class="nav-item {{ $activePage == '/' ? ' active' : '' }}">
      <a class="nav-link" href="/">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
    </li>
    <hr class="sidebar-divider">
    
    @if (auth()->user()->hasPermission('read_kategori') || auth()->user()->hasPermission('read_produk'))
    <div class="sidebar-heading">
      Inventori
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    @if (auth()->user()->hasPermission('read_kategori'))
    <li class="nav-item {{ ($activePage == 'kategori' || $activePage == 'kategori-edit') ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('kategori.index') }}">
          <i class="fas fa-list"></i>
          <span>Kategori</span>
        </a>
    </li>
    @endif
    @if (auth()->user()->hasPermission('read_produk'))
    <li class="nav-item {{ ($activePage == 'produk' || $activePage == 'produk-create' || $activePage == 'produk-edit') ? ' active' : '' }}">
      <a class="nav-link" href="{{ route('produk.index') }}">
        <i class="fas fa-box"></i>
        <span>Produk</span>
      </a>
    </li>
    @endif

    <!-- Nav Item - Utilities Collapse Menu -->
    

    <!-- Divider -->
    <hr class="sidebar-divider">
    @endif

    <!-- Heading -->
    @if (auth()->user()->hasPermission('read_penjualan') || auth()->user()->hasPermission('read_pembelian') 
    || auth()->user()->hasPermission('read_pemasok') || auth()->user()->hasPermission('read_klien') 
    || auth()->user()->hasPermission('read_pengeluaran') || auth()->user()->hasPermission('read_kotakuang'))
    <div class="sidebar-heading">
      Titik Penjualan
    </div>

    @if (auth()->user()->hasPermission('read_penjualan'))
    <li class="nav-item {{ ($activePage == 'penjualan') ? ' active' : '' }}">
      <a class="nav-link" href="{{ route('penjualan.index') }}">
        <i class="fas fa-cart-plus"></i>
        <span>Penjualan</span>
      </a>
    </li>
    @endif

    @if (auth()->user()->hasPermission('read_pembelian'))
    <li class="nav-item {{ ($activePage == 'pembelian') ? ' active' : '' }}">
      <a class="nav-link" href="{{ route('pembelian.index') }}">
        <i class="fas fa-cart-arrow-down"></i>
        <span>Pembelian</span>
      </a>
    </li>
    @endif
    @if (auth()->user()->hasPermission('read_pemasok'))
    <li class="nav-item {{ ($activePage == 'pemasok' || $activePage == 'pemasok-create' || $activePage == 'pemasok-edit') ? ' active' : '' }}">
      <a class="nav-link" href="{{ route('pemasok.index') }}">
        <i class="fas fa-truck"></i>
        <span>Pemasok</span>
      </a>
    </li>
    @endif
    @if (auth()->user()->hasPermission('read_klien'))
    <li class="nav-item {{ ($activePage == 'klien' || $activePage == 'klien-create' || $activePage == 'klien-edit') ? ' active' : '' }}">
      <a class="nav-link" href="{{ route('klien.index') }}">
        <i class="fas fa-users"></i>
        <span>Klien</span>
      </a>
    </li>
    @endif
    @if (auth()->user()->hasPermission('read_pengeluaran'))
    <li class="nav-item {{ ($activePage == 'pengeluaran') ? ' active' : '' }}">
      <a class="nav-link" href="{{ route('pengeluaran.index') }}">
        <i class="fas fa-money-check-alt"></i>
        <span>Pengeluaran</span>
      </a>
    </li>
    @endif
    @if (auth()->user()->hasPermission('read_kotakuang'))
    <li class="nav-item {{ ($activePage == 'kotakuang') ? ' active' : '' }}">
      <a class="nav-link" href="{{ route('kotakuang.index') }}">
        <i class="fas fa-cash-register"></i>
        <span>Kotak Uang</span>
      </a>
    </li>
    @endif


    <hr class="sidebar-divider">
    @endif

    @if (auth()->user()->hasPermission('read_users') || auth()->user()->hasPermission('read_pengaturan'))
    <div class="sidebar-heading">
      Kendali
    </div>

    @if (auth()->user()->hasPermission('read_users'))
    <li class="nav-item {{ ($activePage == 'karyawan' || $activePage == 'karyawan-profile') ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('karyawan.index') }}">
          <i class="fas fa-user-cog"></i>
          <span>Karyawan</span>
        </a>
    </li>
    @endif
    @if (auth()->user()->hasPermission('read_pengaturan'))
    <li class="nav-item {{ ($activePage == 'pengaturan') ? ' active' : '' }}">
      <a class="nav-link" href="{{ route('pengaturan.index') }}">
        <i class="fas fa-cog"></i>
        <span>Pengaturan</span>
      </a>
    </li>
    @endif
    <!-- Divider -->
    <hr class="sidebar-divider">
    @endif

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

  </ul>