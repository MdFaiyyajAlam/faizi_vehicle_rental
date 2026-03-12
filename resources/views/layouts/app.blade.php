<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Figtree', sans-serif;
                background: #f1f5f9;
            }

            .admin-shell {
                min-height: calc(100vh - 56px);
            }

            .admin-sidebar {
                width: 260px;
                background: #0f172a;
                color: #cbd5e1;
                transition: width .2s ease;
            }

            .admin-sidebar .nav-link {
                color: #cbd5e1;
                border-radius: .6rem;
                margin-bottom: .25rem;
            }

            .admin-sidebar .nav-link:hover,
            .admin-sidebar .nav-link.active {
                background: #1e293b;
                color: #fff;
            }

            .admin-main {
                flex: 1;
                min-width: 0;
            }

            .sidebar-collapsed .admin-sidebar {
                width: 88px;
            }

            .sidebar-collapsed .sidebar-label,
            .sidebar-collapsed .sidebar-heading {
                display: none;
            }

            .sidebar-collapsed .admin-sidebar .nav-link {
                text-align: center;
            }

            @media (max-width: 991.98px) {
                .admin-sidebar {
                    display: none;
                }
            }
        </style>
    </head>
    <body>
        @include('layouts.navigation')

        <div id="adminWrapper" class="admin-shell d-flex">
            <aside class="admin-sidebar p-3 border-end border-secondary-subtle">
                <div class="sidebar-heading text-uppercase small fw-semibold text-secondary mb-3 px-2">Modules</div>

                <nav class="nav flex-column">
                    <a href="{{ route('dashboard') }}" class="nav-link px-3 py-2 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2 me-2"></i><span class="sidebar-label">Dashboard</span>
                    </a>

                    @can('view_users')
                        <a href="{{ route('users.index') }}" class="nav-link px-3 py-2 {{ request()->routeIs('users.*') ? 'active' : '' }}">
                            <i class="bi bi-people me-2"></i><span class="sidebar-label">Users</span>
                        </a>
                    @endcan

                    @can('view_vehicles')
                        <a href="{{ route('vehicles.index') }}" class="nav-link px-3 py-2 {{ request()->routeIs('vehicles.*') ? 'active' : '' }}">
                            <i class="bi bi-truck me-2"></i><span class="sidebar-label">Vehicles</span>
                        </a>
                    @endcan

                    @can('view_categories')
                        <a href="{{ route('vehicle-categories.index') }}" class="nav-link px-3 py-2 {{ request()->routeIs('vehicle-categories.*') ? 'active' : '' }}">
                            <i class="bi bi-grid me-2"></i><span class="sidebar-label">Vehicle Categories</span>
                        </a>
                    @endcan

                    @can('view_availabilities')
                        <a href="{{ route('vehicle-availabilities.index') }}" class="nav-link px-3 py-2 {{ request()->routeIs('vehicle-availabilities.*') ? 'active' : '' }}">
                            <i class="bi bi-calendar2-check me-2"></i><span class="sidebar-label">Vehicle Availability</span>
                        </a>
                    @endcan

                    @can('view_bookings')
                        <a href="{{ route('bookings.index') }}" class="nav-link px-3 py-2 {{ request()->routeIs('bookings.*') ? 'active' : '' }}">
                            <i class="bi bi-journal-check me-2"></i><span class="sidebar-label">Bookings</span>
                        </a>
                    @endcan

                    <a href="{{ route('profile.edit') }}" class="nav-link px-3 py-2 {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                        <i class="bi bi-person-gear me-2"></i><span class="sidebar-label">Profile Settings</span>
                    </a>
                </nav>
            </aside>

            <div class="admin-main">
                @isset($header)
                    <div class="bg-white border-bottom px-4 py-3">
                        {{ $header }}
                    </div>
                @endisset

                <main class="p-4 p-lg-5">
                    {{ $slot }}
                </main>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const toggleBtn = document.getElementById('sidebarToggleBtn');
                const wrapper = document.getElementById('adminWrapper');

                if (toggleBtn && wrapper) {
                    toggleBtn.addEventListener('click', function () {
                        wrapper.classList.toggle('sidebar-collapsed');
                    });
                }
            });
        </script>
    </body>
</html>
