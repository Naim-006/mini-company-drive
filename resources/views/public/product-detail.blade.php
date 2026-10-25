@extends('layouts.public')

@section('title', $product->name)

@section('content')
<!-- Breadcrumbs -->
<div class="bg-light py-3 border-bottom">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-decoration-none">Products</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Product Image -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                    <img src="{{ $product->image_url }}" class="img-fluid w-100" style="max-height: 440px; object-fit: cover;" alt="{{ $product->name }}">
                </div>
            </div>

            <!-- Product Info & Actions -->
            <div class="col-lg-6">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge bg-primary-subtle text-primary">{{ $product->category }}</span>
                    @if($product->is_featured)
                        <span class="badge bg-warning text-dark"><i class="bi bi-star-fill me-1"></i> Featured</span>
                    @endif
                </div>

                <h1 class="display-6 fw-bold mb-3">{{ $product->name }}</h1>

                <div class="d-flex align-items-baseline gap-3 mb-4">
                    <h2 class="text-primary fw-bold mb-0">${{ number_format($product->price, 2) }}</h2>
                    @if($product->stock > 0)
                        <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">
                            <i class="bi bi-check-circle-fill me-1"></i> In Stock ({{ $product->stock }} units)
                        </span>
                    @else
                        <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill">
                            <i class="bi bi-x-circle-fill me-1"></i> Out of Stock
                        </span>
                    @endif
                </div>

                @if($product->short_description)
                    <p class="lead text-secondary mb-4">{{ $product->short_description }}</p>
                @endif

                <div class="border-top border-bottom py-3 mb-4">
                    <div class="row g-3 small">
                        <div class="col-6">
                            <span class="text-muted d-block">SKU / Identifier</span>
                            <span class="fw-semibold text-dark">{{ $product->slug }}</span>
                        </div>
                        <div class="col-6">
                            <span class="text-muted d-block">Delivery / Deployment</span>
                            <span class="fw-semibold text-dark">Instant Digital Delivery / Managed</span>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-3 mb-4">
                    <a href="{{ route('contact') }}?subject={{ urlencode('Purchase inquiry: ' . $product->name) }}" class="btn btn-primary btn-lg px-4 shadow-sm">
                        <i class="bi bi-envelope-paper me-2"></i> Inquire About This Product
                    </a>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-lg px-4">
                        <i class="bi bi-arrow-left me-1"></i> Back to Catalog
                    </a>
                </div>

                <!-- Product Specifications Card -->
                <div class="card border-0 bg-light p-3 rounded-3">
                    <h6 class="fw-bold mb-2"><i class="bi bi-shield-check text-success me-2"></i> Quality Guarantee</h6>
                    <p class="small text-muted mb-0">Includes 30 days of setup assistance, comprehensive documentation, and direct email support from our engineering team.</p>
                </div>
            </div>
        </div>

        <!-- Full Product Description -->
        <div class="mt-5 pt-4 border-top">
            <h3 class="fw-bold mb-4">Product Details & Specifications</h3>
            <div class="card border-0 shadow-sm p-4 bg-white rounded-4">
                <div class="card-body">
                    @if($product->description)
                        <div class="text-secondary leading-relaxed" style="white-space: pre-line;">
                            {{ $product->description }}
                        </div>
                    @else
                        <p class="text-muted mb-0">No additional details have been provided for this product.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="mt-5 pt-4">
                <h3 class="fw-bold mb-4">Related in {{ $product->category }}</h3>
                <div class="row g-4">
                    @foreach($relatedProducts as $rel)
                        <div class="col-md-4">
                            <div class="card h-100 product-card border-0 shadow-sm rounded-3 overflow-hidden bg-white">
                                <img src="{{ $rel->image_url }}" class="product-thumb" alt="{{ $rel->name }}">
                                <div class="card-body">
                                    <h5 class="fw-bold mb-1">
                                        <a href="{{ route('products.show', $rel) }}" class="text-dark text-decoration-none">
                                            {{ $rel->name }}
                                        </a>
                                    </h5>
                                    <div class="text-primary fw-bold mb-2">${{ number_format($rel->price, 2) }}</div>
                                    <p class="text-muted small mb-0">{{ Str::limit($rel->short_description ?? $rel->description, 80) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
