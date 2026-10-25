@extends('layouts.public')

@section('title', 'Home')

@section('content')
<!-- Hero Section -->
<section class="hero-section text-center text-lg-start">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <span class="badge bg-light text-primary px-3 py-2 rounded-pill fw-bold text-uppercase mb-3">Enterprise Solutions</span>
                <h1 class="display-4 fw-bold mb-3 text-white">Driving Growth Through Modern Technology</h1>
                <p class="lead mb-4 text-white-50">
                    {{ $settings->about_summary ?? 'We deliver tailored digital products, high-availability cloud systems, and strategic technology consulting to help forward-thinking companies excel.' }}
                </p>
                <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start">
                    <a href="{{ route('products.index') }}" class="btn btn-warning btn-lg fw-semibold px-4 shadow-sm">
                        <i class="bi bi-box-seam me-2"></i> Explore Products
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg px-4">
                        <i class="bi bi-chat-dots me-2"></i> Get in Touch
                    </a>
                </div>
            </div>
            <div class="col-lg-5 text-center">
                <div class="bg-white p-4 rounded-4 shadow-lg text-dark">
                    <div class="p-3 bg-primary bg-opacity-10 text-primary rounded-3 d-inline-block mb-3">
                        <i class="bi bi-rocket-takeoff fs-1"></i>
                    </div>
                    <h4 class="fw-bold mb-2">Why Partner With Us?</h4>
                    <p class="text-muted small mb-4">Proven track record in high-availability deployments, security-first architecture, and round-the-clock reliability.</p>
                    <div class="row text-center g-3 border-top pt-3">
                        <div class="col-6 border-end">
                            <h3 class="fw-bold text-primary mb-0">99.9%</h3>
                            <span class="small text-muted">Uptime Target</span>
                        </div>
                        <div class="col-6">
                            <h3 class="fw-bold text-primary mb-0">24/7</h3>
                            <span class="small text-muted">Dedicated Support</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Company Services Preview -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="text-primary fw-bold text-uppercase">What We Do</h6>
            <h2 class="fw-bold">Our Core Specializations</h2>
            <p class="text-muted">End-to-end technology solutions crafted to scale with your enterprise.</p>
        </div>
        <div class="row g-4">
            @foreach($services as $service)
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm p-3">
                        <div class="card-body">
                            <div class="p-3 bg-primary bg-opacity-10 text-primary rounded-3 d-inline-block mb-3">
                                <i class="bi {{ $service['icon'] }} fs-3"></i>
                            </div>
                            <h5 class="fw-bold mb-2">{{ $service['title'] }}</h5>
                            <p class="text-muted small mb-3">{{ $service['summary'] }}</p>
                            <ul class="list-unstyled small text-secondary mb-0">
                                @foreach($service['features'] as $feature)
                                    <li class="mb-1"><i class="bi bi-check2 text-success me-1"></i>{{ $feature }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('services') }}" class="btn btn-outline-primary px-4">
                View All Services <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-end mb-4">
            <div>
                <h6 class="text-primary fw-bold text-uppercase">Featured Catalog</h6>
                <h2 class="fw-bold mb-1">Highlighted Products</h2>
                <p class="text-muted mb-0">Check out some of our top-rated enterprise tools and packages.</p>
            </div>
            <a href="{{ route('products.index') }}" class="btn btn-primary">
                View All Products <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            @forelse($featuredProducts as $product)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 product-card border-0 shadow-sm overflow-hidden">
                        <img src="{{ $product->image_url }}" class="product-thumb" alt="{{ $product->name }}">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-secondary-subtle text-secondary">{{ $product->category }}</span>
                                <span class="fw-bold text-primary fs-5">${{ number_format($product->price, 2) }}</span>
                            </div>
                            <h5 class="card-title fw-bold mb-2">
                                <a href="{{ route('products.show', $product) }}" class="text-dark text-decoration-none">
                                    {{ $product->name }}
                                </a>
                            </h5>
                            <p class="card-text text-muted small flex-grow-1">
                                {{ $product->short_description ?? Str::limit($product->description, 100) }}
                            </p>
                            <div class="mt-3 pt-3 border-top d-flex justify-content-between align-items-center">
                                <span class="small text-muted">
                                    <i class="bi bi-box me-1"></i> Stock: {{ $product->stock }}
                                </span>
                                <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-primary">
                                    Learn More <i class="bi bi-chevron-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center py-4">
                        No featured products currently available. Please visit our full <a href="{{ route('products.index') }}">product catalog</a>.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Call to Action Banner -->
<section class="py-5 bg-dark text-white text-center">
    <div class="container py-3">
        <h2 class="fw-bold mb-3">Ready to accelerate your business?</h2>
        <p class="lead text-white-50 mb-4 max-w-700 mx-auto">
            Contact our engineering and sales specialists today for custom solutions, demonstrations, or consultations.
        </p>
        <a href="{{ route('contact') }}" class="btn btn-primary btn-lg px-5 shadow">
            <i class="bi bi-envelope me-2"></i> Contact Us Today
        </a>
    </div>
</section>
@endsection
