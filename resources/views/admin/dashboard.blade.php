@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page_title', 'Executive Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <!-- Stat 1: Total Products -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 bg-white p-3">
            <div class="d-flex align-items-center">
                <div class="p-3 bg-primary bg-opacity-10 text-primary rounded-3 me-3">
                    <i class="bi bi-box-seam fs-3"></i>
                </div>
                <div>
                    <div class="text-muted small fw-semibold">Total Products</div>
                    <h3 class="fw-bold mb-0 text-dark">{{ $stats['total_products'] }}</h3>
                </div>
            </div>
            <div class="mt-3 pt-2 border-top small text-muted d-flex justify-content-between">
                <span>Active: <strong>{{ $stats['active_products'] }}</strong></span>
                <span>Featured: <strong>{{ $stats['featured_products'] }}</strong></span>
            </div>
        </div>
    </div>

    <!-- Stat 2: Active Products -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 bg-white p-3">
            <div class="d-flex align-items-center">
                <div class="p-3 bg-success bg-opacity-10 text-success rounded-3 me-3">
                    <i class="bi bi-check2-circle fs-3"></i>
                </div>
                <div>
                    <div class="text-muted small fw-semibold">Catalog Status</div>
                    <h3 class="fw-bold mb-0 text-dark">{{ $stats['active_products'] }} <span class="fs-6 fw-normal text-muted">Online</span></h3>
                </div>
            </div>
            <div class="mt-3 pt-2 border-top small text-muted">
                <a href="{{ route('admin.products.index') }}" class="text-decoration-none">View catalog &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Stat 3: Total Inquiries -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 bg-white p-3">
            <div class="d-flex align-items-center">
                <div class="p-3 bg-info bg-opacity-10 text-info rounded-3 me-3">
                    <i class="bi bi-envelope-open fs-3"></i>
                </div>
                <div>
                    <div class="text-muted small fw-semibold">Total Inquiries</div>
                    <h3 class="fw-bold mb-0 text-dark">{{ $stats['total_inquiries'] }}</h3>
                </div>
            </div>
            <div class="mt-3 pt-2 border-top small text-muted">
                Unread Inquiries: <strong class="text-danger">{{ $stats['unread_inquiries'] }}</strong>
            </div>
        </div>
    </div>

    <!-- Stat 4: Quick Actions -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 bg-primary text-white p-3">
            <h6 class="fw-bold mb-2"><i class="bi bi-lightning-charge-fill me-1"></i> Quick Action</h6>
            <p class="small text-white-50 mb-3">Add a new product or manage company profile.</p>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.products.create') }}" class="btn btn-light btn-sm fw-semibold flex-grow-1">
                    <i class="bi bi-plus-lg"></i> Add Product
                </a>
                <a href="{{ route('admin.settings.edit') }}" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-gear"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Products Table -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark">Recent Products</h5>
                <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentProducts as $prod)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $prod->image_url }}" alt="{{ $prod->name }}" class="rounded me-2" style="width: 36px; height: 36px; object-fit: cover;">
                                            <div>
                                                <div class="fw-semibold text-dark">{{ $prod->name }}</div>
                                                <div class="text-muted small">Stock: {{ $prod->stock }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-secondary-subtle text-secondary">{{ $prod->category }}</span></td>
                                    <td class="fw-bold">${{ number_format($prod->price, 2) }}</td>
                                    <td>
                                        @if($prod->is_active)
                                            <span class="badge bg-success-subtle text-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary">Draft</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.products.edit', $prod) }}" class="btn btn-sm btn-outline-secondary py-0 px-2" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No products yet. <a href="{{ route('admin.products.create') }}">Create one</a>.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Inquiries -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark">Recent Inquiries</h5>
                <a href="{{ route('admin.messages.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-4">
                <div class="list-group list-group-flush">
                    @forelse($recentMessages as $msg)
                        <div class="list-group-item px-0 py-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-semibold text-dark">{{ $msg->name }}</span>
                                <span class="small text-muted">{{ $msg->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="text-primary small fw-semibold mb-1">{{ $msg->subject }}</div>
                            <p class="text-muted small mb-0">{{ Str::limit($msg->message, 80) }}</p>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">No customer inquiries yet.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
