@extends('admin.layouts.app')

@section('title', 'Customer Reviews')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div>
        <h2 class="h3 fw-bold text-white mb-1">Customer Reviews &amp; Testimonials</h2>
        <p class="text-secondary mb-0" style="font-size:0.9rem;">Moderate diner feedback, toggle public visibility on the website, and manage ratings.</p>
    </div>
    <span class="badge bg-dark border text-warning px-3 py-2 fs-6">
        <i class="fas fa-star text-warning me-1"></i> Total: {{ count($reviews) }} Reviews
    </span>
</div>

<div class="row g-4">
    @forelse($reviews as $review)
        <div class="col-md-6 col-xl-4">
            <div class="admin-card h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <img src="{{ asset($review['image'] ?? 'img/testimonial/1.jpg') }}" alt="{{ $review['name'] }}" style="width:44px;height:44px;border-radius:50%;object-fit:cover;"/>
                            <div>
                                <h6 class="text-white mb-0 fw-bold">{{ $review['name'] }}</h6>
                                <small class="text-secondary">{{ $review['role'] }}</small>
                            </div>
                        </div>
                        <div>
                            @if(($review['status'] ?? 'Approved') === 'Approved')
                                <span class="badge-confirmed">Published</span>
                            @else
                                <span class="badge-pending">Hidden</span>
                            @endif
                        </div>
                    </div>
                    <div class="text-warning mb-2" style="font-size:0.85rem;">
                        @for($i = 0; $i < ($review['rating'] ?? 5); $i++)
                            <i class="fas fa-star"></i>
                        @endfor
                        <span class="text-light ms-1">({{ $review['rating'] }}/5)</span>
                    </div>
                    <p class="text-light small mb-3" style="line-height:1.6;">"{{ $review['text'] }}"</p>
                </div>
                <div class="pt-3 border-top border-secondary d-flex justify-content-between align-items-center">
                    <small class="text-muted">{{ $review['created_at'] ?? 'Recent' }}</small>
                    <div class="d-flex gap-2">
                        <form action="{{ route('admin.reviews.status', $review['id']) }}" method="POST">
                            @csrf
                            <input type="hidden" name="status" value="{{ ($review['status'] ?? 'Approved') === 'Approved' ? 'Hidden' : 'Approved' }}"/>
                            <button type="submit" class="btn btn-sm btn-dark border border-secondary text-light">
                                {{ ($review['status'] ?? 'Approved') === 'Approved' ? 'Hide' : 'Approve' }}
                            </button>
                        </form>
                        <form action="{{ route('admin.reviews.delete', $review['id']) }}" method="POST" onsubmit="return confirm('Delete this customer review?')">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5 text-muted">No customer reviews yet.</div>
    @endforelse
</div>
@endsection
