@extends('layouts.public')

@section('title', 'Product Catalog')

@section('content')
<!-- Header Banner -->
<section class="bg-primary text-white py-5 text-center">
    <div class="container">
        <h1 class="display-5 fw-bold mb-2">Our Products & Packages</h1>
        <p class="lead text-white-50 mb-0">Browse our tested software products, cloud tools, and enterprise services.</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <!-- Search and Filter Controls -->
        <div class="card border-0 shadow-sm p-4 mb-4 bg-white rounded-3">
            <form action="{{ route('products.index') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-md-6 col-lg-5">
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Search products by title or keyword..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 col-lg-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        Filter
                    </button>
                    @if(request('search') || request('category'))
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary" title="Clear Filters">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Products Grid -->
        <div class="row g-4 mb-4">
            @forelse($products as $product)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 product-card border-0 shadow-sm rounded-3 overflow-hidden bg-white">
                        <div class="position-relative">
                            <img src="{{ $product->image_url }}" class="product-thumb" alt="{{ $product->name }}">
                            @if($product->is_featured)
                                <span class="position-absolute top-0 start-0 m-2 badge bg-warning text-dark fw-bold shadow-sm">
                                    <i class="bi bi-star-fill me-1"></i> Featured
                                </span>
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-primary-subtle text-primary">{{ $product->category }}</span>
                                <span class="fs-5 fw-bold text-dark">${{ number_format($product->price, 2) }}</span>
                            </div>
                            <h5 class="card-title fw-bold mb-2">
                                <a href="{{ route('products.show', $product) }}" class="text-decoration-none text-dark">
                                    {{ $product->name }}
                                </a>
                            </h5>
                            <p class="card-text text-secondary small flex-grow-1">
                                {{ $product->short_description ?? Str::limit($product->description, 110) }}
                            </p>
                            <div class="mt-3 pt-3 border-top d-flex justify-content-between align-items-center">
                                <span class="small text-muted">
                                    <i class="bi bi-check-circle text-success me-1"></i> Stock: {{ $product->stock }}
                                </span>
                                <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-primary">
                                    View Details <i class="bi bi-chevron-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card border-0 shadow-sm text-center py-5 bg-white rounded-4">
                        <div class="card-body">
                            <i class="bi bi-search fs-1 text-muted mb-3 d-block"></i>
                            <h4 class="fw-bold">No Products Found</h4>
                            <p class="text-muted">We couldn't find any products matching your search criteria.</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm">
                                Reset Filters & View All
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>
    </div>
</section>
@endsection
