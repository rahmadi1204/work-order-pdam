<nav class="main-header navbar navbar-expand-md navbar-dark navbar-blue">
    <div class="container">
        <a href="{{ asset('/assets') }}/index3.html" class="navbar-brand">
            <img src="{{ asset('/images/logo-pdam.png') }}" alt="Logo" class="brand-image img-circle elevation-3"
                style="opacity: .8">
            <span class="brand-text font-weight-light">SISPEKA <small>PDAM KOTA MADIUN</small></span>
        </a>

        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        @auth
            <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link">Halaman Utama</a>
                    </li>
                    @if (auth()->user()->role == 'super admin' || auth()->user()->role == 'admin')
                        <li class="nav-item dropdown">
                            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" class="nav-link dropdown-toggle">Data</a>
                            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                                <li><a href="{{ url('/areas') }}" class="dropdown-item">Data Area</a></li>
                                <li><a href="{{ url('/staffs') }}" class="dropdown-item">Data Karyawan</a></li>
                                <li><a href="{{ url('/clients') }}" class="dropdown-item">Data Pelanggan</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" class="nav-link dropdown-toggle">Jenis</a>
                            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                                <li><a href="{{ url('/types/work-order') }}" class="dropdown-item">Jenis SPK</a></li>
                                {{-- <li><a href="{{ url('/types/document') }}" class="dropdown-item text-danger">Jenis
                                        Dokumen</a></li> --}}
                            </ul>
                        </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" class="nav-link dropdown-toggle">SPK</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            @if (auth()->user()->role == 'super admin' || auth()->user()->role == 'admin')
                                <li><a href="{{ url('/work-order') }}" class="dropdown-item">Lihat</a></li>
                            @else
                                <li><a href="{{ url('/work-order/request') }}" class="dropdown-item">Permintaan</a></li>
                                <li><a href="{{ url('/work-order/response') }}" class="dropdown-item">Tanggapan</a></li>
                                <li><a href="{{ url('/work-order/realization') }}" class="dropdown-item">Realisasi</a></li>
                            @endif
                        </ul>
                    </li>
                    @if (auth()->user()->role == 'super admin' || auth()->user()->role == 'admin')
                        <li class="nav-item dropdown">
                            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" class="nav-link dropdown-toggle text-danger">Laporan</a>
                            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                                <li><a href="{{ url('report/work-order') }}" class="dropdown-item text-danger">Rekap
                                        SPK</a>
                                </li>
                                <li><a href="{{ url('report/staff-spk') }}" class="dropdown-item text-danger">SPK Tiap
                                        Petugas</a></li>
                            </ul>
                        </li>
                    @endif
                    @if (auth()->user()->role == 'super admin')
                        <li class="nav-item dropdown">
                            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" class="nav-link dropdown-toggle">Administrator</a>
                            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                                <li><a href="{{ url('admin/whatsapps') }}" class="dropdown-item">Koneksi WA</a>
                                </li>
                                <li><a href="{{ url('admin/users') }}" class="dropdown-item">Data Admin</a></li>
                                <li><a href="{{ url('admin/imports') }}" class="dropdown-item">Import Data</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
            <!-- Right navbar links -->
            <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                <!-- Messages Dropdown Menu -->
                {{-- <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="{{ asset('/assets') }}/dist/img/user1-128x128.jpg" alt="User Avatar"
                                    class="img-size-50 mr-3 img-circle">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Brad Diesel
                                        <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">Call me whenever you can...</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago
                                    </p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="{{ asset('/assets') }}/dist/img/user8-128x128.jpg" alt="User Avatar"
                                    class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        John Pierce
                                        <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">I got your message bro</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago
                                    </p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="{{ asset('/assets') }}/dist/img/user3-128x128.jpg" alt="User Avatar"
                                    class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Nora Silvester
                                        <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">The subject goes here</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago
                                    </p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                    </div>
                </li> --}}
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-user"></i>
                        {{ auth()->user()->name ?? '' }}
                        <i class="fas fa-caret-down"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                        <a href="#" class="dropdown-item" id="btn-logout">
                            <i class="fas fa-power-off text-danger"></i> &nbsp; Logout
                        </a>
                    </div>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li> --}}
            </ul>
        @endauth

    </div>
</nav>
