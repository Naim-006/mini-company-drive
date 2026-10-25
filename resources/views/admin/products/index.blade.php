@extends('layouts.admin')

@section('title', 'Manage Products')
@section('page_title', 'Product Management')

@section('content')
<div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
    <div class="card-body p-4">
        <!-- Top bar with Add button & Search form -->
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <h5 class="fw-bold mb-0 text-dark">All Catalog Products</h5>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary shadow-sm">
                <i class="bi bi-plus-circle me-1"></i> Add New Product
            </a>
        </div>

        <!-- Filter Form -->
        <form action="{{ route('admin.products.index') }}" method="GET" class="row g-2 align-items-center mb-4">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search by name or description..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Draft / Inactive</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-secondary flex-grow-1">Filter</button>
                @if(request('search') || request('category') || request('status'))
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary" title="Clear Filters">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </div>
        </form>

        <!-- Product Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Image</th>
                        <th>Product Details</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td style="width: 70px;">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="rounded shadow-sm" style="width: 50px; height: 50px; object-fit: cover;">
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $product->name }}</div>
                                <div class="text-muted small">Slug: <code>{{ $product->slug }}</code></div>
                                @if($product->is_featured)
                                    <span class="badge bg-warning text-dark small mt-1"><i class="bi bi-star-fill me-1"></i> Featured</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-primary-subtle text-primary">{{ $product->category }}</span>
                            </td>
                            <td class="fw-bold text-dark">
                                ${{ number_format($product->price, 2) }}
                            </td>
                            <td>
                                @if($product->stock > 0)
                                    <span class="badge bg-success-subtle text-success">{{ $product->stock }} in stock</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger">Out of stock</span>
                                @endif
                            </td>
                            <td>
                                @if($product->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Draft</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('products.show', $product) }}" target="_blank" class="btn btn-outline-info" title="Preview on public site">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $product->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>

                                <!-- Delete Confirmation Modal -->
                                <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $product->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered text-start">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $product->id }}">
                                                    <i class="bi bi-exclamation-triangle me-2"></i> Confirm Deletion
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <p>Are you sure you want to permanently delete the product <strong>"{{ $product->name }}"</strong>?</p>
                                                <p class="small text-muted mb-0">This will remove the product and its uploaded images from storage.</p>
                                            </div>
                                            <div class="modal-footer bg-light">
                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Yes, Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                <h6 class="fw-bold">No Products Found</h6>
                                <p class="text-muted small mb-3">You have not added any products yet or no products match your filter.</p>
                                <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">Create First Product</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4 d-flex justify-content-center">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
