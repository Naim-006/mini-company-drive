@extends('layouts.admin')

@section('title', 'Customer Inquiries')
@section('page_title', 'Customer Inquiries')

@section('content')
<div class="card border-0 shadow-sm rounded-4 bg-white">
    <div class="card-body p-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <h5 class="fw-bold mb-0 text-dark">Received Messages</h5>
            <div class="btn-group btn-group-sm">
                <a href="{{ route('admin.messages.index') }}" class="btn {{ !request('status') ? 'btn-primary' : 'btn-outline-secondary' }}">All</a>
                <a href="{{ route('admin.messages.index', ['status' => 'unread']) }}" class="btn {{ request('status') === 'unread' ? 'btn-primary' : 'btn-outline-secondary' }}">Unread Only</a>
                <a href="{{ route('admin.messages.index', ['status' => 'read']) }}" class="btn {{ request('status') === 'read' ? 'btn-primary' : 'btn-outline-secondary' }}">Read Only</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Status</th>
                        <th>Sender Details</th>
                        <th>Subject</th>
                        <th>Message Content</th>
                        <th>Received</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $msg)
                        <tr class="{{ $msg->is_read ? 'text-muted' : 'table-active' }}">
                            <td>
                                @if($msg->is_read)
                                    <span class="badge bg-secondary-subtle text-secondary">Read</span>
                                @else
                                    <span class="badge bg-danger">New / Unread</span>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $msg->name }}</div>
                                <div class="small"><i class="bi bi-envelope me-1"></i>{{ $msg->email }}</div>
                                @if($msg->phone)
                                    <div class="small text-muted"><i class="bi bi-telephone me-1"></i>{{ $msg->phone }}</div>
                                @endif
                            </td>
                            <td class="fw-semibold text-dark">{{ $msg->subject }}</td>
                            <td style="max-width: 320px;">
                                <div class="small text-secondary" style="max-height: 80px; overflow-y: auto;">
                                    {{ $msg->message }}
                                </div>
                            </td>
                            <td class="small text-muted text-nowrap">
                                {{ $msg->created_at->format('M d, Y') }}<br>
                                <span class="small">{{ $msg->created_at->format('h:i A') }}</span>
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <form action="{{ route('admin.messages.toggle', $msg) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-secondary" title="{{ $msg->is_read ? 'Mark as Unread' : 'Mark as Read' }}">
                                            <i class="bi {{ $msg->is_read ? 'bi-envelope' : 'bi-envelope-check' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.messages.destroy', $msg) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this message?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-envelope-slash fs-1 d-block mb-2 text-muted"></i>
                                <h6 class="fw-bold">No Messages Found</h6>
                                <p class="small mb-0">Incoming customer submissions from the Contact form will be displayed here.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $messages->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
