<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
      <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Search -->
    <a href="@yield('kembali')" title="" data-toggle="tooltip" data-placement="bottom"
                class="btn btn-warning btn-flat pull-left m-8 hidden-xs btn-sm mt-10" data-original-title="Dashboard">
                <strong><i class="fas fa-arrow-left"></i> {{ __('Kembali') }}</strong>
            </a>
            &nbsp;
    <a href="{{ route('dashboard') }}" title="" data-toggle="tooltip" data-placement="bottom"
                class="btn btn-primary btn-flat pull-left m-8 hidden-xs btn-sm mt-10" data-original-title="Dashboard">
                <strong><i class="fas fa-undo"></i> {{ __('Dashboard') }}</strong>
            </a>
    <span id='date-part' class="mr-2 d-none d-lg-inline text-gray-600 small" style="margin-right:0.5rem; padding: 5px;"></span>
    <span id='time-part' class="mr-2 d-none d-lg-inline text-gray-600 small"></span>
          
    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

      <!-- Nav Item - Search Dropdown (Visible Only XS) -->
      <li class="nav-item dropdown no-arrow d-sm-none">
        
        <!-- Dropdown - Messages -->
        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
          <form class="form-inline mr-auto w-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <!-- Nav Item - Alerts -->
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-bell fa-fw"></i>
          <!-- Counter - Alerts -->
          <span class="badge badge-danger badge-counter">{{ $sumalert_stock }}</span>
        </a>
        <!-- Dropdown - Alerts -->
        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
          <h6 class="dropdown-header">
            Pusat Pemberitahuan
          </h6>
          @if ($sumalert_stock == 0)
            <a class="dropdown-item d-flex align-items-center" href="javascript:void(0)">
              Tidak ada data yang tersedia.
            </a>
          @else
            @foreach ($alert_stock as $item)
              <a class="dropdown-item d-flex align-items-center" href="javascript:void(0)">
                <div class="mr-3">
                  <div class="icon-circle bg-danger">
                    <i class="fas fa-exclamation-triangle text-white"></i>
                  </div>
                </div>
                <div>
                  <div class="small text-gray-500">{{ $item->updated_at }}</div>
                  Pemberitahuan Stok Produk: <b>{{ $item->nama_produk }}</b>.
                </div>
              </a>
            @endforeach
          @endif
        </div>
      </li>

      <!-- Nav Item - Messages -->
      

      <div class="topbar-divider d-none d-sm-block"></div>

      <!-- Nav Item - User Information -->
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
          <img class="img-profile rounded-circle" src="{{ asset('uploads') }}/moderator_images/{{ Auth::user()->image }}">
        </a>
        <!-- Dropdown - User Information -->
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="#">
            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
            Profile
          </a>
          <a class="dropdown-item" href="#">
            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
            Settings
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            Logout
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </div>
      </li>

    </ul>

  </nav>