<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') | {{ $settings->company_name ?? config('app.name', 'Mini Company Manager') }}</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f1f5f9;
            min-height: 100vh;
        }
        .admin-sidebar {
            width: 260px;
            min-height: 100vh;
            background-color: #0f172a;
        }
        .sidebar-link {
            color: #94a3b8;
            border-radius: 0.375rem;
            padding: 0.65rem 1rem;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.2s ease;
            font-weight: 500;
        }
        .sidebar-link:hover, .sidebar-link.active {
            color: #ffffff;
            background-color: #1e293b;
        }
        .sidebar-link.active {
            background-color: #2563eb;
        }
        .main-wrapper {
            flex: 1;
            min-width: 0;
        }
        .admin-header {
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar for Desktop -->
        <aside class="admin-sidebar d-none d-lg-flex flex-column p-3 text-white flex-shrink-0">
            <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center mb-4 text-white text-decoration-none px-2 pt-2">
                <i class="bi bi-shield-check fs-4 text-primary me-2"></i>
                <span class="fs-5 fw-bold">Admin Portal</span>
            </a>
            <ul class="nav nav-pills flex-column mb-auto gap-1">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.products.index') }}" class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <i class="bi bi-box-seam me-2"></i> Products
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.messages.index') }}" class="sidebar-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                        <i class="bi bi-envelope me-2"></i> Inquiries
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.settings.edit') }}" class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <i class="bi bi-gear me-2"></i> Company Settings
                    </a>
                </li>
                <li class="nav-item mt-3 pt-3 border-top border-secondary">
                    <a href="{{ route('home') }}" class="sidebar-link" target="_blank">
                        <i class="bi bi-box-arrow-up-right me-2 text-info"></i> View Public Site
                    </a>
                </li>
            </ul>
            <div class="border-top border-secondary pt-3 mt-auto">
                <div class="d-flex align-items-center justify-content-between px-2">
                    <div>
                        <div class="small fw-semibold text-white">{{ auth()->user()->name ?? 'Admin' }}</div>
                        <div class="text-muted small" style="font-size: 0.75rem;">{{ auth()->user()->email ?? '' }}</div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm p-1 px-2" title="Logout">
                            <i class="bi bi-power"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="main-wrapper d-flex flex-column min-vh-100">
            <!-- Header -->
            <header class="admin-header py-3 px-4 d-flex justify-content-between align-items-center shadow-sm">
                <div class="d-flex align-items-center gap-2">
                    <!-- Mobile Hamburger -->
                    <button class="btn btn-outline-secondary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminMobileSidebar" aria-controls="adminMobileSidebar">
                        <i class="bi bi-list"></i>
                    </button>
                    <h5 class="mb-0 fw-bold text-dark">@yield('page_title', 'Dashboard')</h5>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('home') }}" class="btn btn-outline-primary btn-sm d-none d-sm-inline-flex align-items-center">
                        <i class="bi bi-globe me-1"></i> Public Site
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </button>
                    </form>
                </div>
            </header>

            <!-- Mobile Offcanvas Sidebar -->
            <div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="adminMobileSidebar" aria-labelledby="adminMobileSidebarLabel">
                <div class="offcanvas-header border-bottom border-secondary">
                    <h5 class="offcanvas-title fw-bold" id="adminMobileSidebarLabel">Admin Portal</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body d-flex flex-column">
                    <ul class="nav nav-pills flex-column gap-1 mb-auto">
                        <li><a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
                        <li><a href="{{ route('admin.products.index') }}" class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"><i class="bi bi-box-seam me-2"></i> Products</a></li>
                        <li><a href="{{ route('admin.messages.index') }}" class="sidebar-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}"><i class="bi bi-envelope me-2"></i> Inquiries</a></li>
                        <li><a href="{{ route('admin.settings.edit') }}" class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}"><i class="bi bi-gear me-2"></i> Company Settings</a></li>
                        <li class="mt-3 pt-3 border-top border-secondary"><a href="{{ route('home') }}" class="sidebar-link"><i class="bi bi-globe me-2"></i> View Public Site</a></li>
                    </ul>
                </div>
            </div>

            <!-- Page Body -->
            <main class="p-4 flex-grow-1">
                <!-- Notifications -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('status'))
                    <div class="alert alert-info alert-dismissible fade show shadow-sm" role="alert">
                        <i class="bi bi-info-circle-fill me-2"></i> {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                        <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> Form Errors:</div>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </main>

            <!-- Admin Footer -->
            <footer class="text-center py-3 text-muted small bg-white border-top">
                &copy; {{ date('Y') }} {{ $settings->company_name ?? 'Mini Company' }} &bull; Mini Company Manager
            </footer>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
