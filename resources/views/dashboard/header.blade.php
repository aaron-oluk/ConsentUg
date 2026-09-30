<header class="dashboard-header">
    <div class="header-left">
        <button type="button" class="menu-toggle" @click="sidebarOpen = !sidebarOpen" aria-label="Toggle sidebar">
            <i class='bx bx-menu'></i>
        </button>
        <div class="header-title-wrap">
            <p class="header-eyebrow">Admin</p>
            <h1 class="header-title">{{ $headerTitle ?? ucfirst(request()->segment(1) ?: 'Dashboard') }}</h1>
        </div>
    </div>

    <div class="header-right" x-data="{ open: false }" @click.outside="open = false">
        <a href="{{ route('home') }}" class="view-site-link" target="_blank" rel="noopener">
            <i class='bx bx-link-external'></i>
            <span>View site</span>
        </a>

        <button type="button" class="profile-trigger" @click="open = !open" aria-expanded="false" :aria-expanded="open">
            <img
                src="{{ Auth::user()->profile_photo_url ?? asset('images/profile.png') }}"
                alt="{{ Auth::user()->name }}"
                class="profile-avatar"
            >
            <div class="profile-meta">
                <span class="profile-name">{{ \Illuminate\Support\Str::ucfirst(Auth::user()->name) }}</span>
                <span class="profile-role">{{ Auth::user()->role ?? 'Admin' }}</span>
            </div>
            <i class='bx bx-chevron-down'></i>
        </button>

        <div class="profile-dropdown" x-cloak x-show="open" x-transition>
            <div class="profile-dropdown-head">
                <img
                    src="{{ Auth::user()->profile_photo_url ?? asset('images/profile.png') }}"
                    alt="{{ Auth::user()->name }}"
                    class="profile-avatar"
                >
                <div>
                    <p class="profile-name">{{ \Illuminate\Support\Str::ucfirst(Auth::user()->name) }}</p>
                    <p class="profile-email">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <a href="{{ route('settings') }}" class="profile-dropdown-link">
                <i class='bx bx-cog'></i>
                Settings
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="profile-dropdown-link logout">
                    <i class='bx bx-log-out'></i>
                    Logout
                </button>
            </form>
        </div>
    </div>
</header>
