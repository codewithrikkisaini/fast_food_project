@extends('admin.layouts.app')

@section('title', 'Contact Inquiries')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div>
        <h2 class="h3 fw-bold text-white mb-1">Customer Contact Inquiries</h2>
        <p class="text-secondary mb-0" style="font-size:0.9rem;">Review messages sent by visitors through the contact form, catering inquiries, and feedback.</p>
    </div>
    <span class="badge bg-dark border text-info px-3 py-2 fs-6">
        <i class="fas fa-inbox me-1"></i> Total: {{ count($contacts) }} Messages
    </span>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show border-0 bg-success bg-opacity-25 text-success mb-4" role="alert">
    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show border-0 bg-danger bg-opacity-25 text-danger mb-4" role="alert">
    <i class="fas fa-exclamation-triangle me-2"></i> <strong>Please correct the following errors:</strong>
    <ul class="mb-0 mt-2 small">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title"><i class="fas fa-envelope-open text-danger"></i> Inquiries Inbox</h3>
    </div>

    <div class="table-responsive">
        <table class="table-admin">
            <thead>
                <tr>
                    <th>Sender Information</th>
                    <th>Subject</th>
                    <th>Message Preview</th>
                    <th>Received At</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contacts as $msg)
                    <tr>
                        <td>
                            <div class="fw-bold text-white">{{ $msg['name'] }}</div>
                            <div class="small text-secondary"><i class="fas fa-envelope me-1"></i>{{ $msg['email'] }}</div>
                            @if(!empty($msg['phone']))
                                <div class="small text-secondary"><i class="fas fa-phone me-1"></i>{{ $msg['phone'] }}</div>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-dark border text-warning">{{ $msg['subject'] }}</span>
                        </td>
                        <td>
                            <div class="text-light small" style="max-width:280px;line-height:1.4;">
                                {{ Str::limit($msg['message'], 90) }}
                            </div>
                        </td>
                        <td>
                            <small class="text-secondary">{{ $msg['created_at'] ?? 'Recent' }}</small>
                        </td>
                        <td>
                            @if(empty($msg['is_read']))
                                <span class="badge bg-danger" style="font-size:0.75rem;">NEW / UNREAD</span>
                            @else
                                <span class="badge bg-secondary" style="font-size:0.75rem;">READ</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-1">
                                <!-- VIEW MESSAGE MODAL TRIGGER -->
                                <button class="btn btn-sm btn-dark border border-secondary text-light" data-bs-toggle="modal" data-bs-target="#msgModal{{ $msg['id'] }}" title="View Message">
                                    <i class="fas fa-eye"></i>
                                </button>

                                @if(empty($msg['is_read']))
                                    <form action="{{ route('admin.contact.read', $msg['id']) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-success" title="Mark as Read">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('admin.contact.delete', $msg['id']) }}" method="POST" onsubmit="return confirm('Delete this message?')">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <!-- VIEW MESSAGE MODAL -->
                    <div class="modal fade" id="msgModal{{ $msg['id'] }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content bg-dark border-secondary text-light">
                                <div class="modal-header border-secondary">
                                    <h5 class="modal-title"><i class="fas fa-envelope text-warning me-2"></i>{{ $msg['subject'] }}</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="p-3 mb-3 rounded-3" style="background:var(--admin-surface-light);border:1px solid var(--admin-border);">
                                        <div class="row g-2 small">
                                            <div class="col-sm-6"><strong>From:</strong> {{ $msg['name'] }}</div>
                                            <div class="col-sm-6"><strong>Email:</strong> <a href="mailto:{{ $msg['email'] }}" class="text-info">{{ $msg['email'] }}</a></div>
                                            @if(!empty($msg['phone']))
                                                <div class="col-sm-6"><strong>Phone:</strong> {{ $msg['phone'] }}</div>
                                            @endif
                                            <div class="col-sm-6"><strong>Date:</strong> {{ $msg['created_at'] ?? 'Today' }}</div>
                                        </div>
                                    </div>
                                    <h6 class="text-secondary small text-uppercase">Full Message Content:</h6>
                                    <p class="text-white p-3 rounded-3" style="background:#0b1120;border:1px solid #334155;line-height:1.7;">
                                        {{ $msg['message'] }}
                                    </p>
                                </div>
                                <div class="modal-footer border-secondary">
                                    <a href="mailto:{{ $msg['email'] }}?subject=Re: {{ urlencode($msg['subject']) }}" class="btn-admin-primary">
                                        <i class="fas fa-reply me-1"></i> Reply via Email
                                    </a>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">No contact inquiries received yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
