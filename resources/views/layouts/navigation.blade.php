<nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm sticky-top" style="height:56px;">
    <div class="container-fluid px-3 px-lg-4">
        <div class="d-flex align-items-center gap-2">
            <button id="sidebarToggleBtn" class="btn btn-outline-secondary btn-sm d-none d-lg-inline-flex" type="button">
                <i class="bi bi-layout-sidebar-inset"></i>
            </button>

            <a class="navbar-brand d-flex align-items-center fw-semibold mb-0" href="{{ route('dashboard') }}">
                <x-application-logo class="d-inline-block" style="height: 28px; width: auto;" />
                <span class="ms-2">Admin Dashboard</span>
            </a>
        </div>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topbarMenu" aria-controls="topbarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="topbarMenu">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                <li class="nav-item d-lg-none">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                </li>
                <li class="nav-item d-lg-none">
                    <a href="{{ route('vehicle-categories.index') }}" class="nav-link {{ request()->routeIs('vehicle-categories.*') ? 'active' : '' }}">Vehicle Categories</a>
                </li>
                <li class="nav-item d-lg-none">
                    <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">Profile</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Log Out</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
