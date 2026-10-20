@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div>
        <h2 class="h3 fw-bold text-white mb-1">Restaurant Management Dashboard</h2>
        <p class="text-secondary mb-0" style="font-size:0.9rem;">Overview of table bookings, active menu dishes, and customer communications.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.menu') }}" class="btn-admin-primary">
            <i class="fas fa-plus"></i> Add Menu Item
        </a>
        <a href="{{ route('admin.reservations') }}" class="btn btn-dark border border-secondary text-light rounded-3 px-3">
            <i class="fas fa-calendar-alt me-1"></i> View All Bookings
        </a>
    </div>
</div>

<!-- STATS CARDS -->
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(232,40,26,0.15);color:#ef4444;">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-val">{{ $stats['estimated_revenue'] ?? '$24,850' }}</div>
            <div class="stat-lbl">Estimated Monthly Revenue</div>
            <div class="mt-2 text-success" style="font-size:0.75rem;"><i class="fas fa-arrow-up me-1"></i>+12.4% from last month</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(245,158,11,0.15);color:#f59e0b;">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-val">{{ $stats['total_reservations'] ?? 0 }}</div>
            <div class="stat-lbl">Table Reservations ({{ $stats['pending_reservations'] ?? 0 }} Pending)</div>
            <div class="mt-2 text-warning" style="font-size:0.75rem;"><i class="fas fa-clock me-1"></i>Needs Manager Confirmation</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(16,185,129,0.15);color:#10b981;">
                <i class="fas fa-hamburger"></i>
            </div>
            <div class="stat-val">{{ $stats['total_menu_items'] ?? 0 }}</div>
            <div class="stat-lbl">Active Menu Dishes</div>
            <div class="mt-2 text-info" style="font-size:0.75rem;"><i class="fas fa-layer-group me-1"></i>Across 6 Categories</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(6,182,212,0.15);color:#06b6d4;">
                <i class="fas fa-envelope-open-text"></i>
            </div>
            <div class="stat-val">{{ $stats['total_contacts'] ?? 0 }}</div>
            <div class="stat-lbl">Customer Inquiries ({{ $stats['unread_contacts'] ?? 0 }} Unread)</div>
            <div class="mt-2 text-danger" style="font-size:0.75rem;"><i class="fas fa-bell me-1"></i>Fast 2-hr SLA Response</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- RECENT TABLE RESERVATIONS -->
    <div class="col-lg-8">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <h3 class="admin-card-title"><i class="fas fa-calendar-alt text-danger"></i> Recent Table Reservations</h3>
                <a href="{{ route('admin.reservations') }}" class="btn btn-sm btn-dark text-warning border-0">View All &rarr;</a>
            </div>

            <div class="table-responsive">
                <table class="table-admin">
                    <thead>
                        <tr>
                            <th>Guest Name</th>
                            <th>Party Size</th>
                            <th>Date &amp; Time</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentReservations as $r)
                            <tr>
                                <td>
                                    <div class="fw-bold text-white">{{ $r['name'] }}</div>
                                    <small class="text-secondary">{{ $r['phone'] }}</small>
                                </td>
                                <td><span class="badge bg-dark border text-light">{{ $r['guests'] }}</span></td>
                                <td>
                                    <div>{{ $r['date'] }}</div>
                                    <small class="text-secondary">{{ $r['time'] }}</small>
                                </td>
                                <td>
                                    @if(($r['status'] ?? 'Pending') === 'Confirmed')
                                        <span class="badge-confirmed"><i class="fas fa-check-circle me-1"></i>Confirmed</span>
                                    @elseif(($r['status'] ?? 'Pending') === 'Cancelled')
                                        <span class="badge-cancelled"><i class="fas fa-times-circle me-1"></i>Cancelled</span>
                                    @else
                                        <span class="badge-pending"><i class="fas fa-clock me-1"></i>Pending</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-dark border border-secondary text-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            Action
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow">
                                            <li>
                                                <form action="{{ route('admin.reservations.status', $r['id']) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="Confirmed"/>
                                                    <button type="submit" class="dropdown-item text-success"><i class="fas fa-check me-2"></i>Confirm Booking</button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.reservations.status', $r['id']) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="Cancelled"/>
                                                    <button type="submit" class="dropdown-item text-danger"><i class="fas fa-times me-2"></i>Cancel</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No reservations found yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- RECENT CUSTOMER INQUIRIES -->
    <div class="col-lg-4">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <h3 class="admin-card-title"><i class="fas fa-inbox text-warning"></i> Recent Inquiries</h3>
                <a href="{{ route('admin.contact') }}" class="btn btn-sm btn-dark text-warning border-0">Inbox &rarr;</a>
            </div>

            <div class="d-flex flex-column gap-3">
                @forelse($recentContacts as $msg)
                    <div class="p-3 rounded-3" style="background:var(--admin-surface-light);border:1px solid var(--admin-border);">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <strong class="text-white" style="font-size:0.88rem;">{{ $msg['name'] }}</strong>
                            @if(empty($msg['is_read']))
                                <span class="badge bg-danger" style="font-size:0.65rem;">NEW</span>
                            @else
                                <span class="badge bg-secondary" style="font-size:0.65rem;">READ</span>
                            @endif
                        </div>
                        <div class="text-warning small mb-1"><i class="fas fa-tag me-1"></i>{{ $msg['subject'] }}</div>
                        <p class="text-secondary small mb-2" style="line-height:1.4;">{{ Str::limit($msg['message'], 75) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">{{ $msg['created_at'] ?? 'Today' }}</small>
                            <a href="{{ route('admin.contact') }}" class="text-light small text-decoration-none">Open &rarr;</a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted">No inquiries received yet.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- POPULAR MENU ITEMS SECTION -->
<div class="mt-4">
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title"><i class="fas fa-fire text-danger"></i> Signature Menu Showcase</h3>
            <a href="{{ route('admin.menu') }}" class="btn btn-sm btn-outline-warning">Manage All Dishes &rarr;</a>
        </div>
        <div class="row g-3">
            @foreach(array_slice($menuItems, 0, 4) as $mItem)
                <div class="col-sm-6 col-lg-3">
                    <div class="p-3 rounded-3 h-100" style="background:var(--admin-surface-light);border:1px solid var(--admin-border);">
                        <img src="{{ asset($mItem['image']) }}" class="w-100 rounded-3 mb-2" style="height:140px;object-fit:cover;" alt="{{ $mItem['title'] }}"/>
                        <span class="badge bg-dark text-warning border mb-1">{{ $mItem['category_name'] }}</span>
                        <h6 class="text-white mb-1 fw-bold">{{ $mItem['title'] }}</h6>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span class="text-danger fw-bold fs-6">${{ number_format($mItem['price'], 2) }}</span>
                            <span class="text-warning small"><i class="fas fa-star"></i> {{ $mItem['rating'] }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
