<aside class="sidebar" :class="{ 'collapsed': !sidebarOpen }">
    <div class="logo-details">
        <img src="{{ asset('images/logo.png') }}" alt="Consent Uganda" class="sidebar-logo">
        <div class="logo-text">
            <span class="logo_name">Consent</span>
            <span class="logo_sub">Uganda</span>
        </div>
    </div>

    <nav class="sidebar-menu">
        @php
            $user = auth()->user();

            $mainRoutes = collect([
                [
                    'url' => route('dashboard'),
                    'icon' => 'bxs-dashboard',
                    'label' => 'Dashboard',
                    'active' => request()->routeIs('dashboard'),
                    'allowed' => $user->canAccessDashboard(),
                ],
                [
                    'url' => route('dashboard.blogs'),
                    'icon' => 'bx-edit',
                    'label' => 'Blog Management',
                    'active' => request()->routeIs('dashboard.blogs'),
                    'allowed' => $user->canManageContent(),
                ],
                [
                    'url' => route('dashboard.complaints.index'),
                    'icon' => 'bx-message-square-detail',
                    'label' => 'Complaints',
                    'active' => request()->routeIs('dashboard.complaints.*'),
                    'allowed' => $user->canManageComplaints(),
                ],
                [
                    'url' => route('users'),
                    'icon' => 'bx-user',
                    'label' => 'Users',
                    'active' => request()->routeIs('users'),
                    'allowed' => $user->canManageUsers(),
                ],
                [
                    'url' => route('dashboard.reports.index'),
                    'icon' => 'bx-file',
                    'label' => 'Reports',
                    'active' => request()->routeIs('dashboard.reports.*'),
                    'allowed' => $user->canManageContent(),
                ],
                [
                    'url' => route('gallery.index'),
                    'icon' => 'bx-image',
                    'label' => 'Gallery',
                    'active' => request()->routeIs('gallery.*'),
                    'allowed' => $user->canManageContent(),
                ],
            ])->where('allowed', true)->values();
        @endphp

        @if ($mainRoutes->isNotEmpty())
            <p class="menu-label">Main</p>
            <ul class="nav-links">
                @foreach ($mainRoutes as $item)
                    <li data-tooltip="{{ $item['label'] }}">
                        <a href="{{ $item['url'] }}" class="{{ $item['active'] ? 'active' : '' }}">
                            <i class='bx {{ $item['icon'] }}'></i>
                            <span class="link_name">{{ $item['label'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif

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
