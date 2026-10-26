@extends('admin.layouts.app')

@section('title', 'Restaurant & Contact Settings')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <h2 class="h3 fw-bold text-white mb-1"><i class="fas fa-sliders-h text-danger me-2"></i>Restaurant Settings</h2>
            <p class="text-secondary mb-0" style="font-size:0.9rem;">
                Manage store address, contact numbers, official email, opening hours, and social media channels.
            </p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-warning btn-sm">
                <i class="fas fa-external-link-alt me-1"></i> View Live Website
            </a>
            <button type="submit" form="settingsForm" class="btn btn-admin-primary btn-sm px-3">
                <i class="fas fa-save me-1"></i> Save All Changes
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 bg-success bg-opacity-25 text-success mb-4" role="alert" style="border-radius:12px;">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 bg-danger bg-opacity-25 text-danger mb-4" role="alert" style="border-radius:12px;">
            <i class="fas fa-exclamation-triangle me-2"></i> <strong>Please correct the following errors:</strong>
            <ul class="mb-0 mt-2 small ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- ========================================================
         REAL-TIME LIVE PREVIEW CARD
         ======================================================== -->
    <div class="admin-card mb-4" style="background: linear-gradient(135deg, #0b1120 0%, #151e32 100%); border: 1px solid rgba(232, 40, 26, 0.35);">
        <div class="admin-card-header d-flex justify-content-between align-items-center mb-3">
            <h4 class="admin-card-title text-warning" style="font-size:1rem;">
                <i class="fas fa-tv me-2"></i>Live Frontend Preview (Contact &amp; Social Links)
            </h4>
            <span class="badge bg-danger">Real-time Preview</span>
        </div>

        <!-- Announcement Topbar Preview -->
        <div class="p-2 px-3 rounded-3 mb-3 d-flex justify-content-between align-items-center flex-wrap gap-2" style="background:#1e293b;border:1px solid #334155;">
            <div class="small text-white d-flex align-items-center gap-2">
                <span class="badge bg-danger" style="font-size:0.68rem;">TOPBAR NOTICE</span>
                <span id="previewAnnouncement" style="color:#fbbf24;font-weight:600;">
                    <i class="fas fa-fire me-1"></i>{{ $settings['announcement'] ?? 'Free Delivery Today on Orders Over $25!' }}
                </span>
            </div>
            <div class="small text-secondary d-none d-md-flex align-items-center gap-3">
                <span><i class="fas fa-phone-alt me-1 text-danger"></i><span id="previewTopbarPhone">{{ $settings['phone'] ?? '+1 (800) 123-4567' }}</span></span>
                <span><i class="fas fa-envelope me-1 text-danger"></i><span id="previewTopbarEmail">{{ $settings['email'] ?? 'hello@fastfood.com' }}</span></span>
            </div>
        </div>

        <div class="row g-4 align-items-stretch">
            <!-- PREVIEW CARD: Contact Info Widget -->
            <div class="col-lg-7">
                <div class="p-4 rounded-3 h-100" style="background:#090d16; border:1px solid #1e293b;">
                    <span class="badge bg-secondary mb-2" style="font-size:0.7rem;letter-spacing:0.5px;">CONTACT &amp; STORE CARD</span>
                    <h5 id="previewRestaurantName" class="text-white fw-bold mb-3">
                        {{ $settings['restaurant_name'] ?? 'Fast Food' }}
                    </h5>

                    <div class="d-flex flex-column gap-3 mb-4">
                        <div class="d-flex align-items-start gap-3">
                            <div style="width:38px;height:38px;border-radius:10px;background:rgba(232,40,26,0.18);display:flex;align-items:center;justify-content:center;color:#ff6b6b;flex-shrink:0;">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <small class="text-secondary text-uppercase fw-bold" style="font-size:0.72rem;">Address</small>
                                <div id="previewAddress" class="text-white fw-semibold" style="font-size:0.92rem;">
                                    {{ $settings['address'] ?? '42 Flavor Street, Manhattan, NY 10001' }}
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-3">
                            <div style="width:38px;height:38px;border-radius:10px;background:rgba(245,158,11,0.18);display:flex;align-items:center;justify-content:center;color:#fbbf24;flex-shrink:0;">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div>
                                <small class="text-secondary text-uppercase fw-bold" style="font-size:0.72rem;">Phone</small>
                                <div id="previewPhone" class="text-white fw-semibold" style="font-size:0.92rem;">
                                    {{ $settings['phone'] ?? '+1 (800) 123-4567' }}
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-3">
                            <div style="width:38px;height:38px;border-radius:10px;background:rgba(16,185,129,0.18);display:flex;align-items:center;justify-content:center;color:#34d399;flex-shrink:0;">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <small class="text-secondary text-uppercase fw-bold" style="font-size:0.72rem;">Email</small>
                                <div id="previewEmail" class="text-white fw-semibold" style="font-size:0.92rem;">
                                    {{ $settings['email'] ?? 'hello@fastfood.com' }}
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-3">
                            <div style="width:38px;height:38px;border-radius:10px;background:rgba(59,130,246,0.18);display:flex;align-items:center;justify-content:center;color:#60a5fa;flex-shrink:0;">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <small class="text-secondary text-uppercase fw-bold" style="font-size:0.72rem;">Working Hours</small>
                                <div id="previewHours" class="text-white fw-semibold" style="font-size:0.92rem;">
                                    {{ $settings['hours'] ?? 'Wed - Sun: 09 AM - 11 PM' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PREVIEW CARD: Social Media Icons Bar (Matches User Screenshot) -->
            <div class="col-lg-5">
                <div class="p-4 rounded-3 h-100 d-flex flex-column justify-content-between" style="background:#090d16; border:1px solid #1e293b;">
                    <div>
                        <span class="badge bg-secondary mb-2" style="font-size:0.7rem;letter-spacing:0.5px;">SOCIAL CHANNELS (LIVE PREVIEW)</span>
                        <h6 class="text-white fw-bold mb-3">Connect With Us</h6>
                        <p class="text-secondary small mb-4" style="line-height:1.5;">
                            Styled with signature dark rounded icons and glowing hover effects, matching your live store design.
                        </p>

                        <!-- Social Media Icon Row Matching Screenshot -->
                        <div class="d-flex align-items-center gap-2 p-3 rounded-3" style="background:#0f172a;border:1px solid #334155;width:fit-content;">
                            <a id="previewSocialFb" href="{{ $settings['facebook'] ?? '#' }}" target="_blank" class="social-preview-btn" title="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a id="previewSocialIg" href="{{ $settings['instagram'] ?? '#' }}" target="_blank" class="social-preview-btn" title="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a id="previewSocialTw" href="{{ $settings['twitter'] ?? '#' }}" target="_blank" class="social-preview-btn" title="Twitter / X">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a id="previewSocialYt" href="{{ $settings['youtube'] ?? '#' }}" target="_blank" class="social-preview-btn" title="YouTube">
                                <i class="fab fa-youtube"></i>
                            </a>
                            <a id="previewSocialTk" href="{{ $settings['tiktok'] ?? '#' }}" target="_blank" class="social-preview-btn" title="TikTok">
                                <i class="fab fa-tiktok"></i>
                            </a>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top border-secondary">
                        <small class="text-secondary d-block mb-1">Footer About Blurb Preview:</small>
                        <p id="previewFooterDesc" class="small text-light mb-0" style="font-style:italic;line-height:1.4;">
                            "{{ $settings['footer_desc'] ?? "We bring the world's finest flavors together in a fast, friendly, and affordable experience. Every meal crafted with love." }}"
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================================
         MAIN SETTINGS FORM
         ======================================================== -->
    <form action="{{ route('admin.settings.update') }}" method="POST" id="settingsForm">
        @csrf

        <div class="row g-4">
            <!-- SECTION 1: CONTACT & STORE LOCATION -->
            <div class="col-lg-6">
                <div class="admin-card h-100">
                    <div class="admin-card-header">
                        <h4 class="admin-card-title text-white">
                            <i class="fas fa-map-marker-alt text-danger"></i> Contact &amp; Business Address
                        </h4>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-white small fw-bold">
                            <i class="fas fa-map-marked-alt text-danger me-1"></i> Full Restaurant Address *
                        </label>
                        <input type="text" name="address" id="inputAddress" class="form-control bg-dark border-secondary text-white"
                            placeholder="e.g. 42 Flavor Street, Manhattan, NY 10001"
                            value="{{ old('address', $settings['address'] ?? '42 Flavor Street, Manhattan, NY 10001') }}" required>
                        <small class="text-secondary" style="font-size:0.75rem;">Displayed in header topbar, contact page, reservation card, and footer.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-white small fw-bold">
                            <i class="fas fa-phone-alt text-warning me-1"></i> Customer Support Phone *
                        </label>
                        <input type="text" name="phone" id="inputPhone" class="form-control bg-dark border-secondary text-white"
                            placeholder="e.g. +1 (800) 123-4567"
                            value="{{ old('phone', $settings['phone'] ?? '+1 (800) 123-4567') }}" required>
                        <small class="text-secondary" style="font-size:0.75rem;">Main phone number for inquiries, bookings, and calls.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-white small fw-bold">
                            <i class="fas fa-envelope text-info me-1"></i> Official Email Address *
                        </label>
                        <input type="email" name="email" id="inputEmail" class="form-control bg-dark border-secondary text-white"
                            placeholder="e.g. hello@fastfood.com"
                            value="{{ old('email', $settings['email'] ?? 'hello@fastfood.com') }}" required>
                        <small class="text-secondary" style="font-size:0.75rem;">Official email address displayed for customer communications.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-white small fw-bold">
                            <i class="fas fa-clock text-success me-1"></i> Operating / Working Hours *
                        </label>
                        <input type="text" name="hours" id="inputHours" class="form-control bg-dark border-secondary text-white"
                            placeholder="e.g. Wed - Sun: 09 AM - 11 PM"
                            value="{{ old('hours', $settings['hours'] ?? 'Wed - Sun: 09 AM - 11 PM') }}" required>
                        <small class="text-secondary" style="font-size:0.75rem;">Business days and opening/closing hours.</small>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: SOCIAL MEDIA CHANNELS (FROM USER SCREENSHOT) -->
            <div class="col-lg-6">
                <div class="admin-card h-100">
                    <div class="admin-card-header">
                        <h4 class="admin-card-title text-white">
                            <i class="fas fa-share-alt text-warning"></i> Social Media Profiles
                        </h4>
                    </div>

                    <p class="text-secondary small mb-3">
                        Configure direct links to your social media platforms. Leave blank or enter <code>#</code> if not in use.
                    </p>

                    <!-- Facebook -->
                    <div class="mb-3">
                        <label class="form-label text-white small fw-bold d-flex align-items-center justify-content-between">
                            <span><i class="fab fa-facebook-f text-primary me-2"></i> Facebook URL</span>
                            <span class="badge bg-dark border border-secondary text-secondary" style="font-size:0.68rem;">facebook.com</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-primary"><i class="fab fa-facebook-f"></i></span>
                            <input type="url" name="facebook" id="inputFb" class="form-control bg-dark border-secondary text-white"
                                placeholder="https://facebook.com/your-restaurant"
                                value="{{ old('facebook', $settings['facebook'] ?? 'https://facebook.com') }}">
                            <a id="linkTestFb" href="{{ $settings['facebook'] ?? 'https://facebook.com' }}" target="_blank" class="btn btn-outline-secondary" title="Test Link">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Instagram -->
                    <div class="mb-3">
                        <label class="form-label text-white small fw-bold d-flex align-items-center justify-content-between">
                            <span><i class="fab fa-instagram text-danger me-2"></i> Instagram URL</span>
                            <span class="badge bg-dark border border-secondary text-secondary" style="font-size:0.68rem;">instagram.com</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-danger"><i class="fab fa-instagram"></i></span>
                            <input type="url" name="instagram" id="inputIg" class="form-control bg-dark border-secondary text-white"
                                placeholder="https://instagram.com/your-restaurant"
                                value="{{ old('instagram', $settings['instagram'] ?? 'https://instagram.com') }}">
                            <a id="linkTestIg" href="{{ $settings['instagram'] ?? 'https://instagram.com' }}" target="_blank" class="btn btn-outline-secondary" title="Test Link">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Twitter / X -->
                    <div class="mb-3">
                        <label class="form-label text-white small fw-bold d-flex align-items-center justify-content-between">
                            <span><i class="fab fa-twitter text-info me-2"></i> Twitter / X URL</span>
                            <span class="badge bg-dark border border-secondary text-secondary" style="font-size:0.68rem;">x.com / twitter.com</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-info"><i class="fab fa-twitter"></i></span>
                            <input type="url" name="twitter" id="inputTw" class="form-control bg-dark border-secondary text-white"
                                placeholder="https://twitter.com/your-restaurant"
                                value="{{ old('twitter', $settings['twitter'] ?? 'https://twitter.com') }}">
                            <a id="linkTestTw" href="{{ $settings['twitter'] ?? 'https://twitter.com' }}" target="_blank" class="btn btn-outline-secondary" title="Test Link">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        </div>
                    </div>

                    <!-- YouTube -->
                    <div class="mb-3">
                        <label class="form-label text-white small fw-bold d-flex align-items-center justify-content-between">
                            <span><i class="fab fa-youtube text-danger me-2"></i> YouTube Channel URL</span>
                            <span class="badge bg-dark border border-secondary text-secondary" style="font-size:0.68rem;">youtube.com</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-danger"><i class="fab fa-youtube"></i></span>
                            <input type="url" name="youtube" id="inputYt" class="form-control bg-dark border-secondary text-white"
                                placeholder="https://youtube.com/@your-channel"
                                value="{{ old('youtube', $settings['youtube'] ?? 'https://youtube.com') }}">
                            <a id="linkTestYt" href="{{ $settings['youtube'] ?? 'https://youtube.com' }}" target="_blank" class="btn btn-outline-secondary" title="Test Link">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        </div>
                    </div>

                    <!-- TikTok -->
                    <div class="mb-3">
                        <label class="form-label text-white small fw-bold d-flex align-items-center justify-content-between">
                            <span><i class="fab fa-tiktok text-light me-2"></i> TikTok Profile URL</span>
                            <span class="badge bg-dark border border-secondary text-secondary" style="font-size:0.68rem;">tiktok.com</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-light"><i class="fab fa-tiktok"></i></span>
                            <input type="url" name="tiktok" id="inputTk" class="form-control bg-dark border-secondary text-white"
                                placeholder="https://tiktok.com/@your-profile"
                                value="{{ old('tiktok', $settings['tiktok'] ?? 'https://tiktok.com') }}">
                            <a id="linkTestTk" href="{{ $settings['tiktok'] ?? 'https://tiktok.com' }}" target="_blank" class="btn btn-outline-secondary" title="Test Link">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 3: BRANDING, ANNOUNCEMENT & FOOTER BIO -->
            <div class="col-12">
                <div class="admin-card">
                    <div class="admin-card-header">
                        <h4 class="admin-card-title text-white">
                            <i class="fas fa-bullhorn text-info"></i> Branding, Top Announcement &amp; Footer Info
                        </h4>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-white small fw-bold">Restaurant Brand Name</label>
                            <input type="text" name="restaurant_name" id="inputRestaurantName" class="form-control bg-dark border-secondary text-white"
                                placeholder="Fast Food"
                                value="{{ old('restaurant_name', $settings['restaurant_name'] ?? 'Fast Food') }}">
                            <small class="text-secondary" style="font-size:0.75rem;">Website name used across header, footer copyright, and titles.</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-white small fw-bold">Top Announcement Banner Text</label>
                            <input type="text" name="announcement" id="inputAnnouncement" class="form-control bg-dark border-secondary text-white"
                                placeholder="Free Delivery Today on Orders Over $25!"
                                value="{{ old('announcement', $settings['announcement'] ?? 'Free Delivery Today on Orders Over $25!') }}">
                            <small class="text-secondary" style="font-size:0.75rem;">Shown at the very top of the website with flame icon.</small>
                        </div>

                        <div class="col-12">
                            <label class="form-label text-white small fw-bold">Footer About / Bio Description</label>
                            <textarea name="footer_desc" id="inputFooterDesc" rows="3" class="form-control bg-dark border-secondary text-white"
                                placeholder="Short paragraph summarizing your restaurant mission in the footer...">{{ old('footer_desc', $settings['footer_desc'] ?? "We bring the world's finest flavors together in a fast, friendly, and affordable experience. Every meal crafted with love.") }}</textarea>
                            <small class="text-secondary" style="font-size:0.75rem;">Appears in the first column of the website footer.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- STICKY ACTION FOOTER BAR -->
        <div class="p-3 mt-4 rounded-3 d-flex align-items-center justify-content-between flex-wrap gap-3"
            style="background: #0f172a; border: 1px solid #334155; position: sticky; bottom: 20px; z-index: 100; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-info-circle text-warning"></i>
                <span class="text-secondary small">Changes take effect immediately across all frontend pages upon saving.</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button type="reset" class="btn btn-outline-secondary btn-sm px-3">
                    <i class="fas fa-undo me-1"></i> Reset
                </button>
                <button type="submit" class="btn btn-admin-primary px-4 fw-bold">
                    <i class="fas fa-check-circle me-1"></i> Save Restaurant Settings
                </button>
            </div>
        </div>
    </form>
@endsection

@push('styles')
<style>
    /* Matches user screenshot of rounded social pills */
    .social-preview-btn {
        width: 38px;
        height: 38px;
        border-radius: 9px;
        background: rgba(255, 255, 255, 0.08);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        font-size: 0.95rem;
        text-decoration: none;
        transition: all 0.25s ease;
        border: 1px solid rgba(255, 255, 255, 0.05);
    }
    .social-preview-btn:hover {
        background: #e8281a;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(232, 40, 26, 0.4);
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Real-time Live Preview Binding
        function bindInputToText(inputId, previewId, defaultText) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            if (!input || !preview) return;

            input.addEventListener('input', function () {
                preview.textContent = this.value.trim() ? this.value : defaultText;
            });
        }

        bindInputToText('inputAddress', 'previewAddress', '42 Flavor Street, Manhattan, NY 10001');
        bindInputToText('inputPhone', 'previewPhone', '+1 (800) 123-4567');
        bindInputToText('inputPhone', 'previewTopbarPhone', '+1 (800) 123-4567');
        bindInputToText('inputEmail', 'previewEmail', 'hello@fastfood.com');
        bindInputToText('inputEmail', 'previewTopbarEmail', 'hello@fastfood.com');
        bindInputToText('inputHours', 'previewHours', 'Wed - Sun: 09 AM - 11 PM');
        bindInputToText('inputRestaurantName', 'previewRestaurantName', 'Fast Food');

        const inputAnnouncement = document.getElementById('inputAnnouncement');
        const previewAnnouncement = document.getElementById('previewAnnouncement');
        if (inputAnnouncement && previewAnnouncement) {
            inputAnnouncement.addEventListener('input', function () {
                previewAnnouncement.innerHTML = '<i class="fas fa-fire me-1"></i>' + (this.value.trim() ? this.value : 'Free Delivery Today on Orders Over $25!');
            });
        }

        const inputFooterDesc = document.getElementById('inputFooterDesc');
        const previewFooterDesc = document.getElementById('previewFooterDesc');
        if (inputFooterDesc && previewFooterDesc) {
            inputFooterDesc.addEventListener('input', function () {
                previewFooterDesc.textContent = '"' + (this.value.trim() ? this.value : 'We bring the world\'s finest flavors together...') + '"';
            });
        }

        // Real-time Social Link URL Updating
        function bindSocialLink(inputId, previewBtnId, testLinkId) {
            const input = document.getElementById(inputId);
            const previewBtn = document.getElementById(previewBtnId);
            const testLink = document.getElementById(testLinkId);
            if (!input) return;

            input.addEventListener('input', function () {
                const url = this.value.trim() || '#';
                if (previewBtn) previewBtn.setAttribute('href', url);
                if (testLink) testLink.setAttribute('href', url);
            });
        }

        bindSocialLink('inputFb', 'previewSocialFb', 'linkTestFb');
        bindSocialLink('inputIg', 'previewSocialIg', 'linkTestIg');
        bindSocialLink('inputTw', 'previewSocialTw', 'linkTestTw');
        bindSocialLink('inputYt', 'previewSocialYt', 'linkTestYt');
        bindSocialLink('inputTk', 'previewSocialTk', 'linkTestTk');
    });
</script>
@endpush
