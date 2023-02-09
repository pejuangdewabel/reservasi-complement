<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-heading">Main Menu</li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('index') ? '' : 'collapsed' }}" href="{{ route('dashboard-user') }}">
                <i class="bi bi-calendar-check-fill"></i>
                <span>Generate Tiket</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('index/riwayat') ? '' : 'collapsed' }}"
                href="{{ route('history-transaction-user') }}">
                <i class="bi bi-clock-history"></i>
                <span>Riwayat Generate Tiket</span>
            </a>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link collapsed" href="index.html">
                <i class="bi bi-file-earmark-text-fill"></i>
                <span>Riwayat Reservasi</span>
            </a>
        </li> --}}
        <li class="nav-heading">Setting</li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('profile-user') }}">
                <i class="bi bi-person-circle"></i>
                <span>Ubah Password</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('logout') }}">
                <i class="bi bi-arrow-left-circle-fill"></i>
                <span>Keluar</span>
            </a>
        </li>
    </ul>
</aside>
