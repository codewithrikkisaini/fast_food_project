@extends('admin.layouts.app')

@section('title', 'Customer Reviews')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <h2 class="h3 fw-bold text-white mb-1">Customer Reviews &amp; Testimonials</h2>
            <p class="text-secondary mb-0" style="font-size:0.9rem;">Manage diner feedback, customize live satisfaction
                metrics, and add new customer testimonials.</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('reviews') }}" target="_blank"
                class="btn btn-outline-warning btn-sm d-inline-flex align-items-center gap-1">
                <i class="fas fa-external-link-alt"></i> View Live Reviews Page
            </a>
            @if(count($reviews) > 0)
                <form action="{{ route('admin.reviews.delete.all') }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to permanently delete ALL customer reviews? This action cannot be undone.')" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm d-inline-flex align-items-center gap-1">
                        <i class="fas fa-trash-alt"></i> Delete All Records
                    </button>
                </form>
            @endif
            <a href="#addReviewCard" class="btn-admin-primary">
                <i class="fas fa-plus-circle me-1"></i> Add New Review
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 bg-success bg-opacity-25 text-success mb-4"
            role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 bg-danger bg-opacity-25 text-danger mb-4"
            role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i> <strong>Please correct the following errors:</strong>
            <ul class="mb-0 mt-2 small">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- ========================================================
             1. LIVE OVERVIEW & SATISFACTION METRICS (BACKEND TO FRONTEND)
             ======================================================== -->
    <div class="admin-card mb-4">
        <div class="admin-card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h3 class="admin-card-title mb-0">
                <i class="fas fa-sliders-h text-warning me-2"></i>Live Satisfaction Bars &amp; Rating Banner
            </h3>
            <span class="badge bg-dark border text-warning px-3 py-1 small">
                Syncs to: http://127.0.0.1:8000/reviews
            </span>
        </div>

        <form action="{{ route('admin.reviews.settings.update') }}" method="POST" class="mt-3">
            @csrf
            <div class="row g-4">
                <!-- Left Side: Live Visual Preview Box -->
                <div class="col-lg-4">
                    <div class="p-3 rounded-4 h-100" style="background:#090d16;border:1px solid #334155;">
                        <div class="text-uppercase small fw-bold text-secondary mb-3"><i class="fas fa-eye me-1"></i>Live
                            Site Preview</div>

                        <div class="text-center p-3 rounded-3 mb-3"
                            style="background:#fff8f0;border:1px solid #fef0dc;color:#1e293b;">
                            <div style="font-size:3.2rem;font-weight:900;color:#e8281a;line-height:1;">
                                {{ $reviewSettings['overall_rating'] ?? '4.9' }}
                            </div>
                            <div class="text-warning my-2" style="font-size:1.15rem;">
                                @php
                                    $starCount = (int) round((float) ($reviewSettings['overall_rating'] ?? 5));
                                @endphp
                                @for($i = 0; $i < $starCount; $i++)
                                    <i class="fas fa-star"></i>
                                @endfor
                            </div>
                            <div class="text-muted small fw-semibold">
                                {{ $reviewSettings['rating_subtitle'] ?? 'Overall Diner Rating (850+ Reviews)' }}
                            </div>
                        </div>

                        <!-- Mini Bars Preview -->
                        <div class="p-3 bg-white rounded-3 shadow-sm border border-light"
                            style="color:#1e293b;font-size:0.8rem;">
                            <div class="d-flex justify-content-between mb-1 fw-bold">
                                <span>{{ $reviewSettings['metric1_label'] ?? 'Food Quality & Freshness' }}</span>
                                <span class="text-danger">{{ $reviewSettings['metric1_percent'] ?? 98 }}%</span>
                            </div>
                            <div class="progress mb-2" style="height:6px;">
                                <div class="progress-bar bg-danger"
                                    style="width: {{ $reviewSettings['metric1_percent'] ?? 98 }}%;"></div>
                            </div>

                            <div class="d-flex justify-content-between mb-1 fw-bold">
                                <span>{{ $reviewSettings['metric2_label'] ?? 'Delivery Speed (< 25 mins)' }}</span>
                                <span class="text-warning">{{ $reviewSettings['metric2_percent'] ?? 95 }}%</span>
                            </div>
                            <div class="progress mb-2" style="height:6px;">
                                <div class="progress-bar bg-warning"
                                    style="width: {{ $reviewSettings['metric2_percent'] ?? 95 }}%;"></div>
                            </div>

                            <div class="d-flex justify-content-between mb-1 fw-bold">
                                <span>{{ $reviewSettings['metric3_label'] ?? 'Friendly Customer Care' }}</span>
                                <span class="text-success">{{ $reviewSettings['metric3_percent'] ?? 99 }}%</span>
                            </div>
                            <div class="progress" style="height:6px;">
                                <div class="progress-bar bg-success"
                                    style="width: {{ $reviewSettings['metric3_percent'] ?? 99 }}%;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side: Edit Form Fields -->
                <div class="col-lg-8">
                    <div class="row g-3">
                        <div class="col-sm-4">
                            <label class="form-label-admin">Overall Rating Score *</label>
                            <input type="text" name="overall_rating" class="form-control form-control-admin"
                                value="{{ old('overall_rating', $reviewSettings['overall_rating'] ?? '4.9') }}" required
                                placeholder="e.g. 4.9" />
                            <small class="text-secondary" style="font-size:0.75rem;">Display score (e.g. 4.9 or 5.0)</small>
                        </div>

                        <div class="col-sm-8">
                            <label class="form-label-admin">Rating Subtitle Banner *</label>
                            <input type="text" name="rating_subtitle" class="form-control form-control-admin"
                                value="{{ old('rating_subtitle', $reviewSettings['rating_subtitle'] ?? 'Overall Diner Rating (850+ Reviews)') }}"
                                required placeholder="Overall Diner Rating (850+ Reviews)" />
                            <small class="text-secondary" style="font-size:0.75rem;">Subtitle displayed under stars</small>
                        </div>

                        <!-- Metric 1 -->
                        <div class="col-sm-8">
                            <label class="form-label-admin">Metric 1: Name *</label>
                            <input type="text" name="metric1_label" class="form-control form-control-admin"
                                value="{{ old('metric1_label', $reviewSettings['metric1_label'] ?? 'Food Quality & Freshness') }}"
                                required />
                        </div>
                        <div class="col-sm-4">
                            <label class="form-label-admin">Satisfaction % *</label>
                            <div class="input-group">
                                <input type="number" name="metric1_percent" min="0" max="100"
                                    class="form-control form-control-admin"
                                    value="{{ old('metric1_percent', $reviewSettings['metric1_percent'] ?? 98) }}"
                                    required />
                                <span class="input-group-text bg-dark text-light border-secondary">%</span>
                            </div>
                        </div>

                        <!-- Metric 2 -->
                        <div class="col-sm-8">
                            <label class="form-label-admin">Metric 2: Name *</label>
                            <input type="text" name="metric2_label" class="form-control form-control-admin"
                                value="{{ old('metric2_label', $reviewSettings['metric2_label'] ?? 'Delivery Speed (< 25 mins)') }}"
                                required />
                        </div>
                        <div class="col-sm-4">
                            <label class="form-label-admin">Satisfaction % *</label>
                            <div class="input-group">
                                <input type="number" name="metric2_percent" min="0" max="100"
                                    class="form-control form-control-admin"
                                    value="{{ old('metric2_percent', $reviewSettings['metric2_percent'] ?? 95) }}"
                                    required />
                                <span class="input-group-text bg-dark text-light border-secondary">%</span>
                            </div>
                        </div>

                        <!-- Metric 3 -->
                        <div class="col-sm-8">
                            <label class="form-label-admin">Metric 3: Name *</label>
                            <input type="text" name="metric3_label" class="form-control form-control-admin"
                                value="{{ old('metric3_label', $reviewSettings['metric3_label'] ?? 'Friendly Customer Care') }}"
                                required />
                        </div>
                        <div class="col-sm-4">
                            <label class="form-label-admin">Satisfaction % *</label>
                            <div class="input-group">
                                <input type="number" name="metric3_percent" min="0" max="100"
                                    class="form-control form-control-admin"
                                    value="{{ old('metric3_percent', $reviewSettings['metric3_percent'] ?? 99) }}"
                                    required />
                                <span class="input-group-text bg-dark text-light border-secondary">%</span>
                            </div>
                        </div>

                        <div class="col-12 pt-2">
                            <button type="submit" class="btn-admin-primary">
                                <i class="fas fa-save me-1"></i> Save Rating &amp; Satisfaction Settings
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- ========================================================
             2. ADD NEW CUSTOMER REVIEW FORM (BACKEND TO FRONTEND)
             ======================================================== -->
    <div class="admin-card mb-4" id="addReviewCard">
        <div class="admin-card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h3 class="admin-card-title mb-0">
                <i class="fas fa-plus-circle text-warning me-2"></i>Add Customer Review (Direct to Live Website)
            </h3>
            <span class="badge bg-dark border text-warning px-3 py-1 small">
                <i class="fas fa-broadcast-tower text-success me-1"></i>Publishes to: http://127.0.0.1:8000/reviews
            </span>
        </div>

        <form action="{{ route('admin.reviews.store') }}" method="POST" enctype="multipart/form-data" class="mt-3">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label-admin">Customer Name *</label>
                    <input type="text" name="name" class="form-control form-control-admin"
                        placeholder="e.g. Alex Morgan" required value="{{ old('name') }}" />
                </div>

                <div class="col-md-4">
                    <label class="form-label-admin">Role / Title</label>
                    <input type="text" name="role" class="form-control form-control-admin"
                        placeholder="e.g. Local Foodie, Regular Diner" value="{{ old('role', 'Verified Diner') }}" />
                </div>

                <div class="col-md-4">
                    <label class="form-label-admin">Rating (1 to 5 Stars) *</label>
                    <select name="rating" class="form-control form-control-admin" required>
                        <option value="5" selected>⭐⭐⭐⭐⭐ 5 Stars - Loved it!</option>
                        <option value="4">⭐⭐⭐⭐ 4 Stars - Very Good</option>
                        <option value="3">⭐⭐⭐ 3 Stars - Average</option>
                        <option value="2">⭐⭐ 2 Stars - Below Average</option>
                        <option value="1">⭐ 1 Star - Poor</option>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label-admin">Review Feedback / Message *</label>
                    <textarea name="text" class="form-control form-control-admin" rows="3"
                        placeholder="Enter the customer's review feedback..." required>{{ old('text') }}</textarea>
                </div>

                <div class="col-md-4">
                    <label class="form-label-admin">Preset Avatar</label>
                    <select name="image" class="form-control form-control-admin">
                        <option value="img/testimonial/1.jpg">Avatar 1 (Woman)</option>
                        <option value="img/testimonial/2.jpg">Avatar 2 (Man)</option>
                        <option value="img/testimonial/3.jpg">Avatar 3 (Woman Pro)</option>
                        <option value="img/testimonial/4.jpg">Avatar 4 (Man Executive)</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label-admin">Or Upload Custom Avatar</label>
                    <input type="file" name="image_file" class="form-control form-control-admin" accept="image/*" />
                </div>

                <div class="col-md-4">
                    <label class="form-label-admin">Visibility Status *</label>
                    <select name="status" class="form-control form-control-admin" required>
                        <option value="Approved" selected>Approved (Published on Website)</option>
                        <option value="Hidden">Hidden (Keep as Draft)</option>
                    </select>
                </div>

                <div class="col-12 pt-2">
                    <button type="submit" class="btn-admin-primary">
                        <i class="fas fa-check-circle me-1"></i> Add &amp; Publish Review
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- ========================================================
             3. CUSTOMER REVIEWS LIST & MODERATION
             ======================================================== -->
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
        <h4 class="h5 fw-bold text-white mb-0">
            <i class="fas fa-comments text-danger me-2"></i>Customer Reviews List
        </h4>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-dark border text-warning px-3 py-2 fs-6">
                <i class="fas fa-star text-warning me-1"></i> Total: {{ count($reviews) }} Reviews
            </span>
            @if(count($reviews) > 0)
                <form action="{{ route('admin.reviews.delete.all') }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete ALL customer reviews? This action cannot be undone.')" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger">
                        <i class="fas fa-trash-alt me-1"></i> Delete All Records
                    </button>
                </form>
            @endif
            <a href="#addReviewCard" class="btn btn-sm btn-outline-warning">
                <i class="fas fa-plus me-1"></i> Add Review
            </a>
        </div>
    </div>

    <div class="row g-4">
        @forelse($reviews as $review)
            <div class="col-md-6 col-xl-4">
                <div class="admin-card h-100 d-flex flex-column justify-content-between shadow-sm">
                    <div>
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ asset($review['image'] ?? 'img/testimonial/1.jpg') }}" alt="{{ $review['name'] }}"
                                    style="width:48px;height:48px;border-radius:50%;object-fit:cover;border:2px solid var(--admin-border);"
                                    onerror="this.src='{{ asset('img/testimonial/1.jpg') }}'" />
                                <div>
                                    <h6 class="text-white mb-0 fw-bold">{{ $review['name'] }}</h6>
                                    <small class="text-secondary">{{ $review['role'] ?? 'Verified Diner' }}</small>
                                </div>
                            </div>
                            <div>
                                @if(($review['status'] ?? 'Approved') === 'Approved')
                                    <span class="badge-confirmed"><i class="fas fa-check-circle me-1"></i>Published</span>
                                @else
                                    <span class="badge-pending"><i class="fas fa-eye-slash me-1"></i>Hidden</span>
                                @endif
                            </div>
                        </div>

                        <!-- Stars -->
                        <div class="text-warning mb-2" style="font-size:0.9rem;">
                            @for($i = 0; $i < ($review['rating'] ?? 5); $i++)
                                <i class="fas fa-star"></i>
                            @endfor
                            <span class="text-light ms-1 small">({{ $review['rating'] ?? 5 }}/5)</span>
                        </div>

                        <!-- Text -->
                        <p class="text-light small mb-3" style="line-height:1.6;font-size:0.88rem;">
                            "{{ $review['text'] ?? ($review['message'] ?? '') }}"
                        </p>
                    </div>

                    <!-- Footer Actions -->
                    <div
                        class="pt-3 border-top border-secondary border-opacity-50 d-flex justify-content-between align-items-center">
                        <small class="text-muted">{{ $review['created_at'] ?? 'Recent' }}</small>
                        <div class="d-flex gap-2">
                            <!-- Edit Button -->
                            <button type="button" class="btn btn-sm btn-dark border border-secondary text-warning"
                                data-bs-toggle="modal" data-bs-target="#editReviewModal{{ $review['id'] }}" title="Edit Review">
                                <i class="fas fa-edit"></i>
                            </button>

                            <!-- Toggle Visibility -->
                            <form action="{{ route('admin.reviews.status', $review['id']) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status"
                                    value="{{ ($review['status'] ?? 'Approved') === 'Approved' ? 'Hidden' : 'Approved' }}" />
                                <button type="submit" class="btn btn-sm btn-dark border border-secondary text-light"
                                    title="{{ ($review['status'] ?? 'Approved') === 'Approved' ? 'Hide from website' : 'Publish on website' }}">
                                    @if(($review['status'] ?? 'Approved') === 'Approved')
                                        <i class="fas fa-eye-slash me-1"></i> Hide
                                    @else
                                        <i class="fas fa-check me-1 text-success"></i> Publish
                                    @endif
                                </button>
                            </form>

                            <!-- Delete -->
                            <form action="{{ route('admin.reviews.delete', $review['id']) }}" method="POST"
                                onsubmit="return confirm('Delete this customer review?')">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Review">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========================================================
                             EDIT REVIEW MODAL
                             ======================================================== -->
            <div class="modal fade" id="editReviewModal{{ $review['id'] }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content bg-dark border-secondary text-light shadow-lg">
                        <div class="modal-header border-secondary">
                            <h5 class="modal-title text-white">
                                <i class="fas fa-edit text-warning me-2"></i>Edit Review: {{ $review['name'] }}
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('admin.reviews.update', $review['id']) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label-admin">Customer Name *</label>
                                    <input type="text" name="name" class="form-control form-control-admin"
                                        value="{{ $review['name'] }}" required />
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-sm-6">
                                        <label class="form-label-admin">Role / Title</label>
                                        <input type="text" name="role" class="form-control form-control-admin"
                                            value="{{ $review['role'] ?? 'Verified Diner' }}" placeholder="e.g. Food Lover" />
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label-admin">Rating (1 to 5 Stars) *</label>
                                        <select name="rating" class="form-control form-control-admin" required>
                                            <option value="5" {{ ($review['rating'] ?? 5) == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ 5 Stars
                                            </option>
                                            <option value="4" {{ ($review['rating'] ?? 5) == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ 4 Stars
                                            </option>
                                            <option value="3" {{ ($review['rating'] ?? 5) == 3 ? 'selected' : '' }}>⭐⭐⭐ 3 Stars
                                            </option>
                                            <option value="2" {{ ($review['rating'] ?? 5) == 2 ? 'selected' : '' }}>⭐⭐ 2 Stars
                                            </option>
                                            <option value="1" {{ ($review['rating'] ?? 5) == 1 ? 'selected' : '' }}>⭐ 1 Star
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label-admin">Review Message *</label>
                                    <textarea name="text" class="form-control form-control-admin" rows="4"
                                        required>{{ $review['text'] ?? ($review['message'] ?? '') }}</textarea>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-sm-6">
                                        <label class="form-label-admin">Avatar Preset Image</label>
                                        <select name="image" class="form-control form-control-admin">
                                            <option value="img/testimonial/1.jpg" {{ ($review['image'] ?? '') == 'img/testimonial/1.jpg' ? 'selected' : '' }}>Avatar 1 (Woman)</option>
                                            <option value="img/testimonial/2.jpg" {{ ($review['image'] ?? '') == 'img/testimonial/2.jpg' ? 'selected' : '' }}>Avatar 2 (Man)</option>
                                            <option value="img/testimonial/3.jpg" {{ ($review['image'] ?? '') == 'img/testimonial/3.jpg' ? 'selected' : '' }}>Avatar 3 (Woman Professional)
                                            </option>
                                            <option value="img/testimonial/4.jpg" {{ ($review['image'] ?? '') == 'img/testimonial/4.jpg' ? 'selected' : '' }}>Avatar 4 (Man Executive)
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label-admin">Or Upload Custom Avatar</label>
                                        <input type="file" name="image_file" class="form-control form-control-admin"
                                            accept="image/*" />
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <label class="form-label-admin">Visibility Status *</label>
                                    <select name="status" class="form-control form-control-admin" required>
                                        <option value="Approved" {{ ($review['status'] ?? 'Approved') === 'Approved' ? 'selected' : '' }}>Approved (Published on Website)</option>
                                        <option value="Hidden" {{ ($review['status'] ?? 'Approved') === 'Hidden' ? 'selected' : '' }}>Hidden (Not visible on website)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer border-secondary">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn-admin-primary">
                                    <i class="fas fa-save me-1"></i> Update Review
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="p-4 rounded-4" style="background:#090d16; border:1px dashed #334155; max-width:500px; margin:0 auto;">
                    <i class="fas fa-comment-slash fa-3x mb-3 text-secondary"></i>
                    <h5 class="text-white fw-bold mb-2">No Customer Reviews Found</h5>
                    <p class="text-secondary small mb-3">All review records have been deleted. You can create a new review anytime using the button below.</p>
                    <a href="#addReviewCard" class="btn btn-sm btn-warning">
                        <i class="fas fa-plus-circle me-1"></i> Add New Review
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- ========================================================
             ADD NEW REVIEW MODAL
             ======================================================== -->
    <div class="modal fade" id="addReviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark border-secondary text-light shadow-lg">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title text-white">
                        <i class="fas fa-plus-circle text-warning me-2"></i>Add Customer Review
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.reviews.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label-admin">Customer Name *</label>
                            <input type="text" name="name" class="form-control form-control-admin"
                                placeholder="e.g. Alex Morgan" required value="{{ old('name') }}" />
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-sm-6">
                                <label class="form-label-admin">Role / Title</label>
                                <input type="text" name="role" class="form-control form-control-admin"
                                    placeholder="e.g. Local Foodie, Diner" value="{{ old('role', 'Verified Diner') }}" />
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label-admin">Rating (1 to 5 Stars) *</label>
                                <select name="rating" class="form-control form-control-admin" required>
                                    <option value="5" selected>⭐⭐⭐⭐⭐ 5 Stars - Loved it!</option>
                                    <option value="4">⭐⭐⭐⭐ 4 Stars - Very Good</option>
                                    <option value="3">⭐⭐⭐ 3 Stars - Average</option>
                                    <option value="2">⭐⭐ 2 Stars - Below Average</option>
                                    <option value="1">⭐ 1 Star - Poor</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label-admin">Review Message *</label>
                            <textarea name="text" class="form-control form-control-admin" rows="4"
                                placeholder="Enter customer's review feedback..." required>{{ old('text') }}</textarea>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-sm-6">
                                <label class="form-label-admin">Preset Avatar</label>
                                <select name="image" class="form-control form-control-admin">
                                    <option value="img/testimonial/1.jpg">Avatar 1 (Woman)</option>
                                    <option value="img/testimonial/2.jpg">Avatar 2 (Man)</option>
                                    <option value="img/testimonial/3.jpg">Avatar 3 (Woman Pro)</option>
                                    <option value="img/testimonial/4.jpg">Avatar 4 (Man Executive)</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label-admin">Or Upload Photo</label>
                                <input type="file" name="image_file" class="form-control form-control-admin"
                                    accept="image/*" />
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label-admin">Status *</label>
                            <select name="status" class="form-control form-control-admin" required>
                                <option value="Approved" selected>Approved (Published on Website)</option>
                                <option value="Hidden">Hidden (Keep as Draft)</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-secondary">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn-admin-primary">
                            <i class="fas fa-check-circle me-1"></i> Save Review
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection