<aside class="sidebar" :class="{ 'collapsed': !sidebarOpen }">
    <div class="logo-details">
        <img src="{{ asset('images/logo.png') }}" alt="Consent Uganda" class="sidebar-logo">
        <div class="logo-text">
            <span class="logo_name">Consent</span>
            <span class="logo_sub">Uganda</span>
        </div>
    </div>

    <nav class="sidebar-menu">
        <p class="menu-label">Main</p>
        <ul class="nav-links">
            @php
                $mainRoutes = [
                    [route('dashboard'), 'bxs-dashboard', 'Dashboard', request()->routeIs('dashboard')],
                    [route('dashboard.blogs'), 'bx-edit', 'Blog Management', request()->routeIs('dashboard.blogs')],
                    [route('dashboard.complaints.index'), 'bx-message-square-detail', 'Complaints', request()->routeIs('dashboard.complaints.*')],
                    [route('users'), 'bx-user', 'Users', request()->routeIs('users')],
                    [route('dashboard.reports.index'), 'bx-file', 'Reports', request()->routeIs('dashboard.reports.*')],
                    [route('gallery.index'), 'bx-image', 'Gallery', request()->routeIs('gallery.*')],
                ];
            @endphp

            @foreach ($mainRoutes as [$url, $icon, $label, $active])
                <li data-tooltip="{{ $label }}">
                    <a href="{{ $url }}" class="{{ $active ? 'active' : '' }}">
                        <i class='bx {{ $icon }}'></i>
                        <span class="link_name">{{ $label }}</span>
                    </a>
                </li>
            @endforeach
        </ul>

        <p class="menu-label">Account</p>
        <ul class="nav-links">
            <li data-tooltip="Settings">
                <a href="{{ route('settings') }}" class="{{ request()->routeIs('settings') ? 'active' : '' }}">
                    <i class='bx bx-cog'></i>
                    <span class="link_name">Settings</span>
                </a>
            </li>
            <li data-tooltip="Log out">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class='bx bx-log-out'></i>
                        <span class="link_name">Log out</span>
                    </a>
                </form>
            </li>
        </ul>
    </nav>
</aside>
