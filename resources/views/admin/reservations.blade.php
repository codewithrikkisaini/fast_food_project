@extends('admin.layouts.app')

@section('title', 'Table Reservations')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div>
        <h2 class="h3 fw-bold text-white mb-1">Table Reservations &amp; Bookings</h2>
        <p class="text-secondary mb-0" style="font-size:0.9rem;">Manage live diner reservations, table statuses, guest headcount, and special dining requests.</p>
    </div>
    <div class="d-flex gap-2">
        <span class="badge bg-dark border text-warning px-3 py-2 fs-6">
            <i class="fas fa-users me-1"></i> Total: {{ count($reservations) }} Bookings
        </span>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title"><i class="fas fa-calendar-check text-warning"></i> Reservation Records</h3>
    </div>

    <div class="table-responsive">
        <table class="table-admin">
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Guest Information</th>
                    <th>Party Size</th>
                    <th>Reservation Date &amp; Time</th>
                    <th>Special Requests</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $r)
                    <tr>
                        <td><span class="fw-bold text-secondary">#{{ $r['id'] }}</span></td>
                        <td>
                            <div class="fw-bold text-white">{{ $r['name'] }}</div>
                            <div class="small text-secondary"><i class="fas fa-envelope me-1"></i>{{ $r['email'] }}</div>
                            <div class="small text-secondary"><i class="fas fa-phone me-1"></i>{{ $r['phone'] }}</div>
                        </td>
                        <td>
                            <span class="badge bg-dark border text-light"><i class="fas fa-user-friends me-1"></i>{{ $r['guests'] }}</span>
                        </td>
                        <td>
                            <div class="fw-semibold text-white"><i class="fas fa-calendar-day text-danger me-1"></i>{{ $r['date'] }}</div>
                            <small class="text-secondary"><i class="fas fa-clock text-warning me-1"></i>{{ $r['time'] }}</small>
                        </td>
                        <td>
                            <div class="small text-light" style="max-width:220px;">
                                {{ $r['special_requests'] ?? 'No special requests' }}
                            </div>
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
                            <div class="d-flex justify-content-end gap-1">
                                @if(($r['status'] ?? '') !== 'Confirmed')
                                    <form action="{{ route('admin.reservations.status', $r['id']) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="Confirmed"/>
                                        <button type="submit" class="btn btn-sm btn-outline-success" title="Confirm Table">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif

                                @if(($r['status'] ?? '') !== 'Cancelled')
                                    <form action="{{ route('admin.reservations.status', $r['id']) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="Cancelled"/>
                                        <button type="submit" class="btn btn-sm btn-outline-warning" title="Cancel Table">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('admin.reservations.delete', $r['id']) }}" method="POST" onsubmit="return confirm('Delete this reservation record?')">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No reservations booked yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
