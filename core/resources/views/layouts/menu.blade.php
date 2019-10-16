<ul class="nav-main">
    <li>
        <a class="{{ Request::is('beranda') ? 'active' : null }}" href="{{ route('beranda') }}"><i class="si si-cup"></i><span class="sidebar-mini-hide">Beranda</span></a>
    </li>
    <li>
        <a class="{{ Request::is('jalan', 'jalan/*') ? 'active' : null }}" href="{{ route('jalan') }}"><i class="si si-pointer"></i><span class="sidebar-mini-hide">Data Jalan</span></a>
    </li>
    <li>
        <a class="{{ Request::is('penganggaran', 'penganggaran/*') ? 'active' : null }}" href="{{ route('penganggaran') }}"><i class="si si-briefcase"></i><span class="sidebar-mini-hide">Data Penganggaran</span></a>
    </li>
    <li>
        <a class="{{ Request::is('njop', 'njop/*') ? 'active' : null }}" href="{{ route('njop') }}"><i class="si si-wallet"></i><span class="sidebar-mini-hide">Data NJOP</span></a>
    </li>
    <li>
        <a class="{{ Request::is('pengguna', 'pengguna/*') ? 'active' : null }}" href="{{ route('pengguna') }}"><i class="si si-user"></i><span class="sidebar-mini-hide">Data Pengguna</span></a>
    </li>
</ul>
