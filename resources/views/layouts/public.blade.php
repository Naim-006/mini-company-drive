<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Welcome') | {{ $settings->company_name ?? config('app.name', 'Mini Company Manager') }}</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        main {
            flex: 1 0 auto;
        }
        .hero-section {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: #ffffff;
            padding: 4.5rem 0;
        }
        .product-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.08);
        }
        .product-thumb {
            height: 220px;
            object-fit: cover;
            width: 100%;
        }
        .footer-dark {
            background-color: #111827;
            color: #9ca3af;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('home') }}">
                <i class="bi bi-building me-2 text-primary"></i>
                {{ $settings->company_name ?? 'Mini Company' }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#publicNavbar" aria-controls="publicNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="publicNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active fw-semibold' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active fw-semibold' : '' }}" href="{{ route('about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('services') ? 'active fw-semibold' : '' }}" href="{{ route('services') }}">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products.*') ? 'active fw-semibold' : '' }}" href="{{ route('products.index') }}">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active fw-semibold' : '' }}" href="{{ route('contact') }}">Contact</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-2">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-speedometer2 me-1"></i> Admin Dashboard
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-box-arrow-right me-1"></i> Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-person-lock me-1"></i> Admin Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Alert Messages -->
    <div class="container mt-3">
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
                <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> Please check the form errors:</div>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer-dark pt-5 pb-4 mt-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <h5 class="text-white fw-bold mb-3">
                        <i class="bi bi-building text-primary me-2"></i>{{ $settings->company_name ?? 'Mini Company' }}
                    </h5>
                    <p class="small text-muted mb-3">{{ $settings->tagline ?? 'Smart business solutions built for growth.' }}</p>
                    <p class="small mb-1"><i class="bi bi-geo-alt me-2 text-primary"></i>{{ $settings->address ?? 'Corporate Headquarters' }}</p>
                    <p class="small mb-1"><i class="bi bi-telephone me-2 text-primary"></i>{{ $settings->phone ?? '+1 000 000 0000' }}</p>
                    <p class="small mb-1"><i class="bi bi-envelope me-2 text-primary"></i>{{ $settings->email ?? 'info@minicompany.test' }}</p>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h6 class="text-white fw-semibold mb-3">Quick Links</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a></li>
                        <li class="mb-2"><a href="{{ route('about') }}" class="text-decoration-none text-muted">About Us</a></li>
                        <li class="mb-2"><a href="{{ route('services') }}" class="text-decoration-none text-muted">Services</a></li>
                        <li class="mb-2"><a href="{{ route('products.index') }}" class="text-decoration-none text-muted">Products</a></li>
                        <li class="mb-2"><a href="{{ route('contact') }}" class="text-decoration-none text-muted">Contact Us</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h6 class="text-white fw-semibold mb-3">Business Hours</h6>
                    <p class="small text-muted mb-2">{{ $settings->opening_hours ?? 'Mon - Fri: 9:00 AM - 6:00 PM' }}</p>
                    <p class="small text-muted">Our customer support and engineering teams are ready to assist you during working hours.</p>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h6 class="text-white fw-semibold mb-3">Admin Portal</h6>
                    <p class="small text-muted">Staff members can log in to manage inventory, catalog listings, and company configurations.</p>
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-shield-lock me-1"></i> Admin Access
                    </a>
                </div>
            </div>
            <hr class="border-secondary mt-4 mb-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center small text-muted">
                <span>&copy; {{ date('Y') }} {{ $settings->company_name ?? 'Mini Company' }}. All rights reserved.</span>
                <span>Powered by Laravel & Bootstrap</span>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
