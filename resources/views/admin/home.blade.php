@extends('admin.layouts.app')

@section('title', 'Home Section & Images Settings')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <h2 class="h3 fw-bold text-white mb-1">Home Section &amp; Hero Banner Manager</h2>
            <p class="text-secondary mb-0" style="font-size:0.9rem;">Change hero main heading, glowing highlight words,
                banner images, and promotional deals.</p>
        </div>
        <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-warning btn-sm">
            <i class="fas fa-external-link-alt me-1"></i> View Live Homepage
        </a>
    </div>

    <form action="{{ route('admin.home.update') }}" method="POST" enctype="multipart/form-data" id="homeForm">
        @csrf

        <!-- LIVE HEADER PREVIEW BOX -->
        <div class="admin-card mb-4"
            style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); border: 1px solid rgba(232, 40, 26, 0.35);">
            <div class="admin-card-header d-flex justify-content-between align-items-center mb-3">
                <h4 class="admin-card-title text-warning" style="font-size:1rem;"><i class="fas fa-tv me-2"></i>Live
                    Homepage Header Preview</h4>
                <span class="badge bg-danger">Real-time Preview</span>
            </div>
            <div class="row align-items-center g-4 p-3 rounded-3" style="background:#090d16;border:1px solid #1e293b;">
                <div class="col-lg-7">
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3"
                        style="background:rgba(232,40,26,0.15);border:1px solid rgba(232,40,26,0.3);color:#ff6b6b;font-size:0.8rem;font-weight:700;">
                        <i class="fas fa-star text-warning"></i>
                        <span id="previewBadge">{{ $home['hero_badge'] ?? '#1 Rated Fast Food in New York' }}</span>
                    </div>
                    <h1 id="previewHeading"
                        style="font-family:'Playfair Display',serif;font-size:2.4rem;font-weight:900;line-height:1.2;color:#fff;margin-bottom:14px;">
                        @php
                            $initTitle = $home['hero_title'] ?? 'Delicious Fast Food for Every Moment';
                            $initHigh = $home['hero_highlight'] ?? 'Fast Food';
                            if (!empty($initHigh) && str_contains($initTitle, $initHigh)) {
                                $initDisplay = str_replace($initHigh, '<span style="color:#e8281a;position:relative;">' . e($initHigh) . '</span>', e($initTitle));
                            } else {
                                $initDisplay = e($initTitle);
                            }
                        @endphp
                        {!! $initDisplay !!}
                    </h1>
                    <p id="previewDesc" style="color:#94a3b8;font-size:0.92rem;line-height:1.6;max-width:500px;">
                        {{ $home['hero_desc'] ?? 'Experience bold flavors crafted from premium ingredients. From crispy smashed burgers to gourmet pizzas - every bite is an adventure worth savoring.' }}
                    </p>
                    <div class="d-flex gap-2">
                        <span class="btn btn-sm text-white px-3 py-2 fw-bold"
                            style="background:#e8281a;border-radius:25px;"><i class="fas fa-utensils me-1"></i>Explore
                            Menu</span>
                        <span class="btn btn-sm btn-dark text-light border border-secondary px-3 py-2"
                            style="border-radius:25px;"><i class="fas fa-play me-1"></i>Watch Story</span>
                    </div>
                </div>
                <div class="col-lg-5 text-center">
                    <div
                        style="width:200px;height:200px;border-radius:50%;margin:0 auto;overflow:hidden;border:4px solid #e8281a;box-shadow:0 0 35px rgba(232,40,26,0.4);background:#111;">
                        <img id="previewHeroImg" src="{{ asset($home['hero_image'] ?? 'img/banner-img.jpg') }}"
                            alt="Hero Banner" style="width:100%;height:100%;object-fit:cover;" />
                    </div>
                    <small class="text-secondary d-block mt-2">Hero Main Banner Image</small>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- LEFT COLUMN: HEADINGS & TEXT SETTINGS -->
            <div class="col-lg-7">
                <!-- 1. MAIN HEADING CONFIGURATION -->
                <div class="admin-card mb-4">
                    <div class="admin-card-header">
                        <h3 class="admin-card-title"><i class="fas fa-heading text-danger"></i> Main Heading &amp; Highlight
                        </h3>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label-admin">Main Heading Title *</label>
                            <input type="text" name="hero_title" id="inputHeroTitle"
                                class="form-control form-control-admin fs-6"
                                value="{{ old('hero_title', $home['hero_title'] ?? 'Delicious Fast Food for Every Moment') }}"
                                oninput="updateLivePreview()" required />
                            <small class="text-secondary">This is the big main headline displayed on the front homepage
                                banner.</small>
                        </div>

                        <div class="col-12">
                            <label class="form-label-admin">Highlight / Glowing Word(s) in Heading</label>
                            <input type="text" name="hero_highlight" id="inputHeroHighlight"
                                class="form-control form-control-admin"
                                value="{{ old('hero_highlight', $home['hero_highlight'] ?? 'Fast Food') }}"
                                oninput="updateLivePreview()" placeholder="e.g. Fast Food" />
                            <small class="text-secondary">Type the exact word(s) from your heading that should be
                                highlighted with the red curve glow.</small>
                        </div>

                        <div class="col-12">
                            <label class="form-label-admin">Hero Top Badge Text</label>
                            <input type="text" name="hero_badge" id="inputHeroBadge" class="form-control form-control-admin"
                                value="{{ old('hero_badge', $home['hero_badge'] ?? '#1 Rated Fast Food in New York') }}"
                                oninput="updateLivePreview()" required />
                        </div>

                        <div class="col-12">
                            <label class="form-label-admin">Hero Subtitle / Description *</label>
                            <textarea name="hero_desc" id="inputHeroDesc" class="form-control form-control-admin" rows="3"
                                oninput="updateLivePreview()"
                                required>{{ old('hero_desc', $home['hero_desc'] ?? 'Experience bold flavors crafted from premium ingredients. From crispy smashed burgers to gourmet pizzas - every bite is an adventure worth savoring.') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- 2. SPECIAL DEAL OF THE DAY SETTINGS -->
                <div class="admin-card mb-4">
                    <div class="admin-card-header">
                        <h3 class="admin-card-title"><i class="fas fa-bolt text-warning"></i> Deal of the Day Banner</h3>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label-admin">Deal Section Title</label>
                            <input type="text" name="deal_title" class="form-control form-control-admin"
                                value="{{ old('deal_title', $home['deal_title'] ?? 'Get 30% Off Our Signature Burger Meal') }}" />
                        </div>
                        <div class="col-12">
                            <label class="form-label-admin">Deal Description</label>
                            <textarea name="deal_desc" class="form-control form-control-admin"
                                rows="2">{{ old('deal_desc', $home['deal_desc'] ?? 'Don\'t miss our weekend special - grab our award-winning signature burger combo with loaded fries and a premium shake.') }}</textarea>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label-admin">Special Promo Price</label>
                            <input type="text" name="deal_price" class="form-control form-control-admin"
                                value="{{ old('deal_price', $home['deal_price'] ?? '$17.49') }}" />
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label-admin">Old Strikethrough Price</label>
                            <input type="text" name="deal_old_price" class="form-control form-control-admin"
                                value="{{ old('deal_old_price', $home['deal_old_price'] ?? '$24.99') }}" />
                        </div>
                    </div>
                </div>

                <!-- 3. TOPBAR ANNOUNCEMENT & COUNTERS -->
                <div class="admin-card mb-4">
                    <div class="admin-card-header">
                        <h3 class="admin-card-title"><i class="fas fa-bullhorn text-info"></i> Top Bar &amp; Live Stats
                            Counters</h3>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label-admin">Top Announcement Ribbon</label>
                            <input type="text" name="announcement" class="form-control form-control-admin"
                                value="{{ old('announcement', $home['announcement'] ?? 'Free Delivery Today on Orders Over $25!') }}" />
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label-admin">Happy Diners Counter</label>
                            <input type="text" name="happy_customers" class="form-control form-control-admin"
                                value="{{ old('happy_customers', $home['happy_customers'] ?? '850+') }}" />
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label-admin">Menu Items Counter</label>
                            <input type="text" name="menu_count" class="form-control form-control-admin"
                                value="{{ old('menu_count', $home['menu_count'] ?? '120+') }}" />
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label-admin">Chefs Counter</label>
                            <input type="text" name="chefs_count" class="form-control form-control-admin"
                                value="{{ old('chefs_count', $home['chefs_count'] ?? '15+') }}" />
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label-admin">Experience Counter</label>
                            <input type="text" name="experience_years" class="form-control form-control-admin"
                                value="{{ old('experience_years', $home['experience_years'] ?? '12yr') }}" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: IMAGE MANAGEMENT & CONTACT DETAILS -->
            <div class="col-lg-5">
                <!-- 1. HERO BANNER IMAGE MANAGER -->
                <div class="admin-card mb-4">
                    <div class="admin-card-header">
                        <h3 class="admin-card-title"><i class="fas fa-image text-danger"></i> Hero Banner Image</h3>
                    </div>

                    <!-- Current Active Hero Image -->
                    <div class="text-center p-3 mb-3 rounded-3" style="background:#090d16;border:1px solid #1e293b;">
                        <div
                            style="width:140px;height:140px;border-radius:50%;margin:0 auto 10px;overflow:hidden;border:3px solid #e8281a;">
                            <img id="heroImageThumb" src="{{ asset($home['hero_image'] ?? 'img/banner-img.jpg') }}"
                                alt="Current Hero Image" style="width:100%;height:100%;object-fit:cover;" />
                        </div>
                        <span class="badge bg-dark border text-warning">Active Hero Image</span>
                    </div>

                    <!-- Upload New Image -->
                    <div class="mb-3">
                        <label class="form-label-admin"><i class="fas fa-upload me-1 text-danger"></i> Upload New Image From
                            Computer</label>
                        <input type="file" name="hero_image_file" class="form-control form-control-admin" accept="image/*"
                            onchange="previewUpload(this, 'heroImageThumb', 'previewHeroImg', 'heroImagePath')" />
                        <small class="text-secondary">JPG, PNG, WebP up to 5MB. Automatically optimized.</small>
                    </div>

                    <!-- Preserved Hidden Image Path -->
                    <input type="hidden" name="hero_image" id="heroImagePath"
                        value="{{ old('hero_image', $home['hero_image'] ?? 'img/banner-img.jpg') }}" />
                </div>

                <!-- SAVE BUTTON -->
                <div class="admin-card text-center p-4">
                    <button type="submit" class="btn-admin-primary w-100 justify-content-center py-3 fs-6">
                        <i class="fas fa-save me-2"></i> Save Home Changes Now
                    </button>
                    <small class="text-secondary d-block mt-2">Updates reflect on the live homepage instantly.</small>
                </div>
            </div>
        </div>
    </form>

    @push('admin-scripts')
        <script>
            // Live update text preview
            function updateLivePreview() {
                const title = document.getElementById('inputHeroTitle').value;
                const highlight = document.getElementById('inputHeroHighlight').value;
                const badge = document.getElementById('inputHeroBadge').value;
                const desc = document.getElementById('inputHeroDesc').value;

                document.getElementById('previewBadge').textContent = badge;
                document.getElementById('previewDesc').textContent = desc;

                let formatted = title;
                if (highlight && formatted.includes(highlight)) {
                    formatted = formatted.replace(highlight, '<span style="color:#e8281a;position:relative;">' + highlight + '</span>');
                }
                document.getElementById('previewHeading').innerHTML = formatted;
            }

            // Preview uploaded file
            function previewUpload(input, thumbId, previewId, pathInputId) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        if (document.getElementById(thumbId)) document.getElementById(thumbId).src = e.target.result;
                        if (previewId && document.getElementById(previewId)) document.getElementById(previewId).src = e.target.result;
                        if (pathInputId && document.getElementById(pathInputId)) document.getElementById(pathInputId).value = input.files[0].name;
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
    @endpush
@endsection