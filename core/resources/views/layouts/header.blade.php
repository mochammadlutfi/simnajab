<header id="page-header" style="background-color:#fff;">
    <!-- Header Content -->
    <div class="content-header">
        <!-- Left Section -->
        <div class="content-header-section">
            <!-- Logo -->
            <div class="content-header-item">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('assets/img/logo_1.png') }}" width="200px">
                </a>
            </div>
            <!-- END Logo -->
        </div>
        <!-- END Left Section -->

        <!-- Middle Section -->
        <div class="content-header-section d-none d-lg-block text-primary-dark">
            <ul class="nav-main-header">
                <li>
                    <a class="{{ Request::is('beranda') ? 'active' : null }}" href="{{ route('beranda') }}"><i class="si si-cup"></i><span class="sidebar-mini-hide">Beranda</span></a>
                </li>
                <li>
                    <a class="{{ Request::is('jalan', 'jalan/*') ? 'active' : null }}" href="{{ route('jalan') }}"><i class="si si-pointer"></i><span class="sidebar-mini-hide">Data Jalan</span></a>
                </li>
                <li>
                    <a class="{{ Request::is('penganggaran', 'penganggaran/*') ? 'active' : null }}" href="{{ route('penganggaran') }}"><i class="si si-briefcase"></i><span class="sidebar-mini-hide">Data Penganggaran</span></a>
                </li>
            </ul>
            <!-- END Header Navigation -->
        </div>
        <!-- END Middle Section -->

        <!-- Right Section -->
        <div class="content-header-section">
            <!-- User Dropdown -->
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-rounded btn-alt-secondary" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-user d-sm-none"></i>
                    <span class="d-none d-sm-inline-block">{{ Auth::user()->nama }}</span>
                    <i class="fa fa-angle-down ml-5"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right min-width-200" aria-labelledby="page-header-user-dropdown">
                    <h5 class="h6 text-center py-10 mb-5 border-b text-uppercase">{{ ucwords(str_replace('-', ' ', Auth::user()->getRoleNames()->first())) }}</h5>

                    <a class="dropdown-item" href="{{ route('pengaturan') }}">
                        <i class="si si-wrench mr-5"></i> Pengaturan
                    </a>

                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="si si-logout mr-5"></i> Keluar

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </a>
                </div>
            </div>
            <!-- END User Dropdown -->
        </div>
        <!-- END Right Section -->
    </div>
    <!-- END Header Content -->

    <!-- Header Loader -->
    <!-- Please check out the Activity page under Elements category to see examples of showing/hiding it -->
    <div id="page-header-loader" class="overlay-header bg-primary">
        <div class="content-header content-header-fullrow text-center">
            <div class="content-header-item">
                <i class="fa fa-sun-o fa-spin text-white"></i>
            </div>
        </div>
    </div>
    <!-- END Header Loader -->
</header>
