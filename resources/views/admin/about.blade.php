@extends('admin.layouts.app')

@section('title', 'About Section Settings')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div>
        <h2 class="h3 fw-bold text-white mb-1">About Us Section Settings</h2>
        <p class="text-secondary mb-0" style="font-size:0.9rem;">Manage the restaurant's background story, culinary heritage, and key pillars.</p>
    </div>
    <a href="{{ route('about') }}" target="_blank" class="btn btn-outline-warning btn-sm">
        <i class="fas fa-eye me-1"></i> Preview Live About Page
    </a>
</div>

<form action="{{ route('admin.about.update') }}" method="POST">
    @csrf
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="admin-card mb-4">
                <div class="admin-card-header">
                    <h3 class="admin-card-title"><i class="fas fa-book-open text-danger"></i> Story Content</h3>
                </div>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label class="form-label-admin">Small Subtitle Tagline</label>
                        <input type="text" name="tagline" class="form-control form-control-admin" value="{{ old('tagline', $about['tagline'] ?? 'Our Story & Heritage') }}" required/>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label-admin">Experience Badge Text</label>
                        <input type="text" name="years_badge" class="form-control form-control-admin" value="{{ old('years_badge', $about['years_badge'] ?? '12+') }}"/>
                    </div>
                    <div class="col-12">
                        <label class="form-label-admin">Main Headline Title</label>
                        <input type="text" name="title" class="form-control form-control-admin" value="{{ old('title', $about['title'] ?? 'We Invite You to Visit Our Food Restaurant') }}" required/>
                    </div>
                    <div class="col-12">
                        <label class="form-label-admin">Detailed Story &amp; Philosophy</label>
                        <textarea name="desc" class="form-control form-control-admin" rows="6" required>{{ old('desc', $about['desc'] ?? "Founded in 2012, Fast Food began as a small corner joint with a big dream - to serve food that brings people together. Today we're proud to serve thousands of happy customers every week with the same passion that started it all.") }}</textarea>
                    </div>
                </div>
            </div>

            <!-- CORE PILLARS OVERVIEW -->
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3 class="admin-card-title"><i class="fas fa-award text-warning"></i> Quality Pillars</h3>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="p-3 rounded-3" style="background:var(--admin-surface-light);border:1px solid var(--admin-border);">
                            <div class="text-danger fw-bold mb-1"><i class="fas fa-leaf me-1"></i> 100% Fresh</div>
                            <small class="text-secondary">Locally sourced produce and artisanal bread baked every morning.</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-3" style="background:var(--admin-surface-light);border:1px solid var(--admin-border);">
                            <div class="text-warning fw-bold mb-1"><i class="fas fa-award me-1"></i> Award Winning</div>
                            <small class="text-secondary">Consecutive culinary awards for our signature crispy smash burgers.</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-3" style="background:var(--admin-surface-light);border:1px solid var(--admin-border);">
                            <div class="text-success fw-bold mb-1"><i class="fas fa-shipping-fast me-1"></i> 25-Min Delivery</div>
                            <small class="text-secondary">Fast, temperature-controlled delivery guaranteed to keep food hot.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="admin-card text-center p-4">
                <i class="fas fa-info-circle fa-3x text-warning mb-3"></i>
                <h5 class="text-white mb-2">Publish Changes</h5>
                <p class="text-secondary small mb-4">Updating your story will immediately sync across both the Homepage About section and the dedicated /about page.</p>
                <button type="submit" class="btn-admin-primary w-100 justify-content-center py-3 fs-6">
                    <i class="fas fa-save me-2"></i> Save About Settings
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
