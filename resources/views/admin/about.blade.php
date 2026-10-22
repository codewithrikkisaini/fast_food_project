@extends('admin.layouts.app')

@section('title', 'About Section Settings')

@push('admin-styles')
<style>
   .pillar-card {
      background: var(--admin-surface-light, #1e293b);
      border: 1px solid var(--admin-border, #334155);
      border-radius: 12px;
      padding: 18px;
      margin-bottom: 16px;
      transition: all 0.25s ease;
      position: relative;
   }
   .pillar-card:hover {
      border-color: rgba(232, 40, 26, 0.4);
      box-shadow: 0 4px 20px rgba(0,0,0,0.25);
   }
   .pillar-badge-r { background: rgba(232, 40, 26, 0.15); color: #ff6b6b; border: 1px solid rgba(232, 40, 26, 0.3); }
   .pillar-badge-y { background: rgba(245, 158, 11, 0.15); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.3); }
   .pillar-badge-g { background: rgba(16, 185, 129, 0.15); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.3); }
   .pillar-badge-b { background: rgba(6, 182, 212, 0.15); color: #06b6d4; border: 1px solid rgba(6, 182, 212, 0.3); }

   .icon-btn-choice {
      padding: 4px 10px;
      font-size: 0.78rem;
      border-radius: 6px;
      background: #0f172a;
      border: 1px solid #334155;
      color: #cbd5e1;
      cursor: pointer;
      transition: 0.2s;
   }
   .icon-btn-choice:hover {
      background: #e8281a;
      color: #fff;
      border-color: #e8281a;
   }

   /* Live Preview Box */
   .preview-about-box {
      background: #090d16;
      border: 1px solid #1e293b;
      border-radius: 14px;
      padding: 24px;
   }
   .preview-fti {
      display: flex;
      align-items: flex-start;
      gap: 12px;
      margin-bottom: 14px;
   }
   .preview-ftico {
      width: 42px;
      height: 42px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.1rem;
      flex-shrink: 0;
   }
   .preview-ftico.r { background: rgba(232, 40, 26, 0.15); color: #ff6b6b; }
   .preview-ftico.y { background: rgba(245, 158, 11, 0.18); color: #f59e0b; }
   .preview-ftico.g { background: rgba(16, 185, 129, 0.15); color: #10b981; }
   .preview-ftico.b { background: rgba(6, 182, 212, 0.15); color: #06b6d4; }
</style>
@endpush

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div>
        <h2 class="h3 fw-bold text-white mb-1">About Us Section &amp; Quality Pillars</h2>
        <p class="text-secondary mb-0" style="font-size:0.9rem;">Manage restaurant background story, heritage badges, quality highlight pillars, images, and action buttons.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('about') }}" target="_blank" class="btn btn-outline-warning btn-sm">
            <i class="fas fa-eye me-1"></i> View Live About Page
        </a>
        <a href="{{ route('home') }}#about" target="_blank" class="btn btn-outline-light btn-sm">
            <i class="fas fa-home me-1"></i> View on Homepage
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show border-0 bg-success bg-opacity-25 text-success mb-4" role="alert">
    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show border-0 bg-danger bg-opacity-25 text-danger mb-4" role="alert">
    <i class="fas fa-exclamation-triangle me-2"></i> Please check the form errors below.
    <ul class="mb-0 mt-2 small">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- LIVE REAL-TIME PREVIEW ACCORDION -->
<div class="admin-card mb-4" style="border: 1px solid rgba(232, 40, 26, 0.35); background: linear-gradient(135deg, #0f172a 0%, #172033 100%);">
    <div class="admin-card-header d-flex justify-content-between align-items-center mb-3">
        <h4 class="admin-card-title text-warning mb-0" style="font-size:1.05rem;">
            <i class="fas fa-tv me-2"></i> Live About Section Preview
        </h4>
        <span class="badge bg-danger">Real-time Preview</span>
    </div>
    <div class="preview-about-box">
        <div class="row align-items-center g-4">
            <div class="col-lg-5 text-center">
                <div style="position:relative;display:inline-block;max-width:320px;width:100%;">
                    <div style="width:100%;height:220px;border-radius:14px;overflow:hidden;border:2px solid #334155;background:#1e293b;">
                        <img id="previewImage1" src="{{ asset($about['image1'] ?? 'img/about1.jpg') }}" alt="Story Preview" style="width:100%;height:100%;object-fit:cover;" onerror="this.src='{{ asset('img/about1.jpg') }}'"/>
                    </div>
                    <div style="position:absolute;bottom:-15px;right:-10px;width:110px;height:110px;border-radius:12px;overflow:hidden;border:3px solid #e8281a;box-shadow:0 8px 25px rgba(0,0,0,0.5);background:#1e293b;">
                        <img id="previewImage2" src="{{ asset($about['image2'] ?? 'img/about2.jpg') }}" alt="Food Preview" style="width:100%;height:100%;object-fit:cover;" onerror="this.src='{{ asset('img/about2.jpg') }}'"/>
                    </div>
                    <div style="position:absolute;top:-12px;left:-10px;background:#e8281a;color:#fff;padding:8px 14px;border-radius:10px;box-shadow:0 4px 15px rgba(232,40,26,0.4);text-align:center;">
                        <span id="previewBadgeNum" style="font-size:1.2rem;font-weight:900;display:block;line-height:1;">{{ $about['years_badge'] ?? '12+' }}</span>
                        <small id="previewBadgeText" style="font-size:0.65rem;text-transform:uppercase;letter-spacing:0.5px;line-height:1.1;display:block;">{{ str_replace("\n", ' ', $about['years_badge_text'] ?? 'Years of Excellence') }}</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <span id="previewTagline" class="text-danger fw-bold text-uppercase" style="font-size:0.8rem;letter-spacing:1px;display:block;margin-bottom:6px;">
                    {{ $about['tagline'] ?? 'Our Story & Heritage' }}
                </span>
                <h3 id="previewTitle" class="text-white fw-bold mb-2" style="font-size:1.5rem;font-family:'Playfair Display',serif;">
                    {!! nl2br(e($about['title'] ?? 'We Invite You to Visit Our Food Restaurant')) !!}
                </h3>
                <div style="width:50px;height:3px;background:#e8281a;margin-bottom:12px;border-radius:2px;"></div>
                <p id="previewDesc" class="text-secondary small mb-3" style="line-height:1.6;">
                    {{ $about['desc'] ?? "Founded in 2012, Fast Food began as a small corner joint with a big dream - to serve food that brings people together." }}
                </p>

                <!-- Live Pillars in Preview -->
                <div id="previewPillarsContainer">
                    @php
                        $previewPoints = $about['points'] ?? [
                            ['icon' => 'fas fa-leaf', 'color' => 'r', 'title' => '100% Fresh Farm Ingredients', 'desc' => 'We source locally and sustainably. Every ingredient is hand-picked daily.'],
                            ['icon' => 'fas fa-award', 'color' => 'y', 'title' => 'Award-Winning Master Chefs', 'desc' => 'Our kitchen is led by executive chefs whose signature recipes have earned national culinary recognition.'],
                            ['icon' => 'fas fa-shipping-fast', 'color' => 'g', 'title' => 'Fast & Eco-Conscious Delivery', 'desc' => 'Order online and enjoy piping hot comfort food in under 35 minutes.']
                        ];
                    @endphp
                    @foreach($previewPoints as $idx => $pt)
                        <div class="preview-fti" id="previewPillar_{{ $idx }}">
                            <div class="preview-ftico {{ $pt['color'] ?? 'r' }}">
                                <i class="{{ $pt['icon'] ?? 'fas fa-check-circle' }}"></i>
                            </div>
                            <div>
                                <h6 class="text-white mb-0" style="font-size:0.88rem;font-weight:700;">{{ $pt['title'] ?? '' }}</h6>
                                <p class="text-secondary mb-0" style="font-size:0.78rem;">{{ $pt['desc'] ?? '' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex gap-2 flex-wrap mt-3 pt-2 border-top border-secondary border-opacity-25">
                    <span id="previewBtn1" class="btn btn-sm btn-danger px-3 py-1 fw-bold rounded-pill" style="font-size:0.8rem;">
                        <i class="fas fa-utensils me-1"></i>{{ $about['btn1_text'] ?? 'Explore Our Menu' }}
                    </span>
                    <span id="previewBtn2" class="btn btn-sm btn-outline-light px-3 py-1 rounded-pill" style="font-size:0.8rem;">
                        <i class="fas fa-calendar-check me-1"></i>{{ $about['btn2_text'] ?? 'Book a Table' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data" id="aboutForm">
    @csrf
    <div class="row g-4">
        <div class="col-lg-8">
            <!-- STORY CONTENT -->
            <div class="admin-card mb-4">
                <div class="admin-card-header">
                    <h3 class="admin-card-title"><i class="fas fa-book-open text-danger me-2"></i> Story &amp; Brand Narrative</h3>
                </div>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label class="form-label-admin">Small Subtitle Tagline</label>
                        <input type="text" name="tagline" id="inputTagline" class="form-control form-control-admin" value="{{ old('tagline', $about['tagline'] ?? 'Our Story & Heritage') }}" required placeholder="e.g. Our Heritage"/>
                    </div>
                    <div class="col-sm-3">
                        <label class="form-label-admin">Experience Badge Number</label>
                        <input type="text" name="years_badge" id="inputBadgeNum" class="form-control form-control-admin" value="{{ old('years_badge', $about['years_badge'] ?? '12+') }}" placeholder="e.g. 12+"/>
                    </div>
                    <div class="col-sm-3">
                        <label class="form-label-admin">Experience Subtext</label>
                        <input type="text" name="years_badge_text" id="inputBadgeText" class="form-control form-control-admin" value="{{ old('years_badge_text', $about['years_badge_text'] ?? "Years of\nExcellence") }}" placeholder="Years of Excellence"/>
                    </div>
                    <div class="col-12">
                        <label class="form-label-admin">Main Headline Title</label>
                        <input type="text" name="title" id="inputTitle" class="form-control form-control-admin" value="{{ old('title', $about['title'] ?? 'We Invite You to Visit Our Food Restaurant') }}" required placeholder="e.g. We Invite You to Visit Our Food Restaurant"/>
                    </div>
                    <div class="col-12">
                        <label class="form-label-admin">Detailed Story &amp; Philosophy</label>
                        <textarea name="desc" id="inputDesc" class="form-control form-control-admin" rows="5" required placeholder="Describe your restaurant's story...">{{ old('desc', $about['desc'] ?? "Founded in 2012, Fast Food began as a small corner joint with a big dream - to serve food that brings people together. Today we're proud to serve thousands of happy customers every week with the same passion that started it all.") }}</textarea>
                    </div>
                </div>
            </div>

            <!-- QUALITY PILLARS & FEATURE HIGHLIGHTS (THE RED BOX SECTION) -->
            <div class="admin-card mb-4" style="border: 1px solid rgba(245, 158, 11, 0.35);">
                <div class="admin-card-header d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h3 class="admin-card-title text-warning mb-1">
                            <i class="fas fa-gem text-warning me-2"></i> Quality Pillars &amp; Key Highlights
                        </h3>
                        <small class="text-secondary">These feature highlights appear with icons and descriptions in the About section on both the About page and Homepage.</small>
                    </div>
                    <button type="button" class="btn btn-outline-warning btn-sm" onclick="addNewPillar()">
                        <i class="fas fa-plus me-1"></i> Add Feature Pillar
                    </button>
                </div>

                <div id="pillarsList">
                    @php
                        $pillars = old('points', $about['points'] ?? [
                            [
                                'icon' => 'fas fa-leaf',
                                'color' => 'r',
                                'title' => '100% Fresh Farm Ingredients',
                                'desc' => 'We source locally and sustainably. Every ingredient is hand-picked daily for maximum freshness and flavor integrity.'
                            ],
                            [
                                'icon' => 'fas fa-award',
                                'color' => 'y',
                                'title' => 'Award-Winning Master Chefs',
                                'desc' => 'Our kitchen is led by executive chefs whose signature recipes have earned national culinary recognition.'
                            ],
                            [
                                'icon' => 'fas fa-shipping-fast',
                                'color' => 'g',
                                'title' => 'Fast & Eco-Conscious Delivery',
                                'desc' => 'Order online and enjoy piping hot, fresh comfort food delivered straight to your doorstep in under 35 minutes.'
                            ]
                        ]);
                    @endphp

                    @foreach($pillars as $index => $pillar)
                        <div class="pillar-card" id="pillarRow_{{ $index }}">
                            <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2" style="border-color: rgba(51, 65, 85, 0.6) !important;">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge pillar-badge-{{ $pillar['color'] ?? 'r' }}" id="pillarBadgeLabel_{{ $index }}">
                                        <i class="{{ $pillar['icon'] ?? 'fas fa-check-circle' }} me-1" id="pillarIconPreview_{{ $index }}"></i>
                                        Pillar #<span class="pillar-idx-num">{{ $index + 1 }}</span>
                                    </span>
                                    <span class="text-white fw-bold small" id="pillarTitlePreview_{{ $index }}">{{ $pillar['title'] ?? 'Feature Title' }}</span>
                                </div>
                                <button type="button" class="btn btn-outline-danger btn-sm py-0 px-2" onclick="removePillar({{ $index }})" title="Remove this pillar">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-7">
                                    <label class="form-label-admin">Feature Title</label>
                                    <input type="text" name="points[{{ $index }}][title]" class="form-control form-control-admin pillar-title-input" value="{{ $pillar['title'] ?? '' }}" placeholder="e.g. 100% Fresh Farm Ingredients" required oninput="updateLivePreview()"/>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label-admin">Color Badge Theme</label>
                                    <select name="points[{{ $index }}][color]" class="form-select form-control-admin pillar-color-select" onchange="updatePillarColor({{ $index }}, this.value); updateLivePreview();">
                                        <option value="r" {{ ($pillar['color'] ?? 'r') === 'r' ? 'selected' : '' }}>🔴 Red / Primary (ftico r)</option>
                                        <option value="y" {{ ($pillar['color'] ?? 'r') === 'y' ? 'selected' : '' }}>🟡 Yellow / Gold (ftico y)</option>
                                        <option value="g" {{ ($pillar['color'] ?? 'r') === 'g' ? 'selected' : '' }}>🟢 Green / Fresh (ftico g)</option>
                                        <option value="b" {{ ($pillar['color'] ?? 'r') === 'b' ? 'selected' : '' }}>🔵 Cyan / Cool (ftico b)</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label-admin">Icon Class (FontAwesome)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-dark border-secondary text-warning" id="iconInputAddon_{{ $index }}">
                                            <i class="{{ $pillar['icon'] ?? 'fas fa-leaf' }}"></i>
                                        </span>
                                        <input type="text" name="points[{{ $index }}][icon]" id="pillarIconInput_{{ $index }}" class="form-control form-control-admin pillar-icon-input" value="{{ $pillar['icon'] ?? 'fas fa-leaf' }}" placeholder="e.g. fas fa-leaf" required oninput="updatePillarIcon({{ $index }}, this.value); updateLivePreview();"/>
                                    </div>
                                    <!-- Preset Icon Buttons -->
                                    <div class="d-flex gap-1 flex-wrap mt-2">
                                        <span class="text-secondary me-1" style="font-size:0.75rem;">Presets:</span>
                                        <button type="button" class="icon-btn-choice" onclick="selectPresetIcon({{ $index }}, 'fas fa-leaf')"><i class="fas fa-leaf me-1"></i>Leaf</button>
                                        <button type="button" class="icon-btn-choice" onclick="selectPresetIcon({{ $index }}, 'fas fa-award')"><i class="fas fa-award me-1"></i>Award</button>
                                        <button type="button" class="icon-btn-choice" onclick="selectPresetIcon({{ $index }}, 'fas fa-shipping-fast')"><i class="fas fa-shipping-fast me-1"></i>Delivery</button>
                                        <button type="button" class="icon-btn-choice" onclick="selectPresetIcon({{ $index }}, 'fas fa-utensils')"><i class="fas fa-utensils me-1"></i>Utensils</button>
                                        <button type="button" class="icon-btn-choice" onclick="selectPresetIcon({{ $index }}, 'fas fa-heart')"><i class="fas fa-heart me-1"></i>Heart</button>
                                        <button type="button" class="icon-btn-choice" onclick="selectPresetIcon({{ $index }}, 'fas fa-star')"><i class="fas fa-star me-1"></i>Star</button>
                                        <button type="button" class="icon-btn-choice" onclick="selectPresetIcon({{ $index }}, 'fas fa-fire')"><i class="fas fa-fire me-1"></i>Fire</button>
                                        <button type="button" class="icon-btn-choice" onclick="selectPresetIcon({{ $index }}, 'fas fa-clock')"><i class="fas fa-clock me-1"></i>Clock</button>
                                        <button type="button" class="icon-btn-choice" onclick="selectPresetIcon({{ $index }}, 'fas fa-shield-alt')"><i class="fas fa-shield-alt me-1"></i>Quality</button>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label-admin">Feature Description</label>
                                    <textarea name="points[{{ $index }}][desc]" class="form-control form-control-admin pillar-desc-input" rows="2" placeholder="Briefly describe this highlight..." required oninput="updateLivePreview()">{{ $pillar['desc'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button type="button" class="btn btn-outline-warning w-100 py-2 mt-2" onclick="addNewPillar()">
                    <i class="fas fa-plus-circle me-1"></i> Add Another Quality Pillar
                </button>
            </div>

            <!-- IMAGES & MEDIA -->
            <div class="admin-card mb-4">
                <div class="admin-card-header">
                    <h3 class="admin-card-title"><i class="fas fa-images text-info me-2"></i> Section Imagery</h3>
                </div>
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label-admin">Main Story Image (Large)</label>
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <div style="width:70px;height:70px;border-radius:10px;overflow:hidden;border:1px solid #334155;background:#1e293b;flex-shrink:0;">
                                <img id="thumbImage1" src="{{ asset($about['image1'] ?? 'img/about1.jpg') }}" alt="Main Story" style="width:100%;height:100%;object-fit:cover;" onerror="this.src='{{ asset('img/about1.jpg') }}'"/>
                            </div>
                            <div class="flex-grow-1">
                                <input type="file" name="image1_file" class="form-control form-control-admin mb-1" accept="image/*" onchange="previewUpload(this, 'thumbImage1', 'previewImage1')"/>
                                <small class="text-secondary" style="font-size:0.75rem;">Upload new photo (JPG, PNG, WebP &le; 5MB)</small>
                            </div>
                        </div>
                        <input type="text" name="image1" id="inputImage1Path" class="form-control form-control-admin" value="{{ old('image1', $about['image1'] ?? 'img/about1.jpg') }}" placeholder="img/about1.jpg" oninput="document.getElementById('previewImage1').src='{{ asset('') }}' + this.value; document.getElementById('thumbImage1').src='{{ asset('') }}' + this.value;"/>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-admin">Secondary Floating Image (Small)</label>
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <div style="width:70px;height:70px;border-radius:10px;overflow:hidden;border:1px solid #334155;background:#1e293b;flex-shrink:0;">
                                <img id="thumbImage2" src="{{ asset($about['image2'] ?? 'img/about2.jpg') }}" alt="Secondary Dish" style="width:100%;height:100%;object-fit:cover;" onerror="this.src='{{ asset('img/about2.jpg') }}'"/>
                            </div>
                            <div class="flex-grow-1">
                                <input type="file" name="image2_file" class="form-control form-control-admin mb-1" accept="image/*" onchange="previewUpload(this, 'thumbImage2', 'previewImage2')"/>
                                <small class="text-secondary" style="font-size:0.75rem;">Upload new photo (JPG, PNG, WebP &le; 5MB)</small>
                            </div>
                        </div>
                        <input type="text" name="image2" id="inputImage2Path" class="form-control form-control-admin" value="{{ old('image2', $about['image2'] ?? 'img/about2.jpg') }}" placeholder="img/about2.jpg" oninput="document.getElementById('previewImage2').src='{{ asset('') }}' + this.value; document.getElementById('thumbImage2').src='{{ asset('') }}' + this.value;"/>
                    </div>
                </div>
            </div>

            <!-- ACTION BUTTONS -->
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3 class="admin-card-title"><i class="fas fa-mouse-pointer text-success me-2"></i> Call to Action Buttons</h3>
                </div>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label class="form-label-admin">Button 1 Label</label>
                        <input type="text" name="btn1_text" id="inputBtn1Text" class="form-control form-control-admin" value="{{ old('btn1_text', $about['btn1_text'] ?? 'Explore Our Menu') }}" placeholder="Explore Our Menu"/>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label-admin">Button 1 Custom URL (Leave blank for /menu)</label>
                        <input type="text" name="btn1_url" class="form-control form-control-admin" value="{{ old('btn1_url', $about['btn1_url'] ?? '') }}" placeholder="e.g. /menu or https://..."/>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label-admin">Button 2 Label</label>
                        <input type="text" name="btn2_text" id="inputBtn2Text" class="form-control form-control-admin" value="{{ old('btn2_text', $about['btn2_text'] ?? 'Book a Table') }}" placeholder="Book a Table"/>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label-admin">Button 2 Custom URL (Leave blank for /reservation)</label>
                        <input type="text" name="btn2_url" class="form-control form-control-admin" value="{{ old('btn2_url', $about['btn2_url'] ?? '') }}" placeholder="e.g. /reservation or https://..."/>
                    </div>
                </div>
            </div>
        </div>

        <!-- SIDEBAR SAVE ACTION -->
        <div class="col-lg-4">
            <div class="admin-card text-center p-4 sticky-top" style="top: 20px;">
                <div class="mb-3">
                    <span class="d-inline-flex align-items-center justify-content-center" style="width:64px;height:64px;border-radius:50%;background:rgba(232,40,26,0.15);color:#e8281a;font-size:1.8rem;">
                        <i class="fas fa-save"></i>
                    </span>
                </div>
                <h5 class="text-white mb-2">Publish Changes</h5>
                <p class="text-secondary small mb-4">
                    Updating your story and quality pillars will immediately sync in real-time across both the Homepage About section and the dedicated /about page.
                </p>
                <button type="submit" class="btn-admin-primary w-100 justify-content-center py-3 fs-6 fw-bold">
                    <i class="fas fa-check-circle me-2"></i> Save About Settings
                </button>
                <div class="mt-4 pt-3 border-top border-secondary border-opacity-25 text-start">
                    <div class="small text-secondary mb-2"><i class="fas fa-info-circle text-warning me-1"></i> <strong>Pro-Tip:</strong></div>
                    <p class="text-secondary small mb-2" style="font-size:0.8rem;">
                        You can customize up to 3 or more Quality Pillars. Each pillar features a custom FontAwesome icon and a color badge theme:
                    </p>
                    <ul class="text-secondary small ps-3 mb-0" style="font-size:0.78rem;">
                        <li><span class="text-danger fw-bold">Red (r)</span>: Farm produce, hot deals, signature items.</li>
                        <li><span class="text-warning fw-bold">Yellow (y)</span>: Awards, master chefs, recipes.</li>
                        <li><span class="text-success fw-bold">Green (g)</span>: Express delivery, fresh veggies, organic.</li>
                        <li><span class="text-info fw-bold">Cyan (b)</span>: Drinks, cool specialties, hygiene.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('admin-scripts')
<script>
    let pillarCounter = {{ count($pillars) }};

    function updatePillarColor(index, color) {
        const badge = document.getElementById('pillarBadgeLabel_' + index);
        if (badge) {
            badge.className = 'badge pillar-badge-' + color;
        }
    }

    function updatePillarIcon(index, iconClass) {
        const addon = document.getElementById('iconInputAddon_' + index);
        const preview = document.getElementById('pillarIconPreview_' + index);
        if (addon) addon.innerHTML = '<i class="' + iconClass + '"></i>';
        if (preview) preview.className = iconClass + ' me-1';
    }

    function selectPresetIcon(index, iconClass) {
        const input = document.getElementById('pillarIconInput_' + index);
        if (input) {
            input.value = iconClass;
            updatePillarIcon(index, iconClass);
            updateLivePreview();
        }
    }

    function removePillar(index) {
        const row = document.getElementById('pillarRow_' + index);
        if (row) {
            row.remove();
            renumberPillars();
            updateLivePreview();
        }
    }

    function renumberPillars() {
        const rows = document.querySelectorAll('#pillarsList .pillar-card');
        rows.forEach((row, i) => {
            const idxSpan = row.querySelector('.pillar-idx-num');
            if (idxSpan) idxSpan.textContent = (i + 1);
        });
    }

    function addNewPillar() {
        const idx = pillarCounter++;
        const template = `
            <div class="pillar-card" id="pillarRow_${idx}">
                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2" style="border-color: rgba(51, 65, 85, 0.6) !important;">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge pillar-badge-r" id="pillarBadgeLabel_${idx}">
                            <i class="fas fa-check-circle me-1" id="pillarIconPreview_${idx}"></i>
                            Pillar #<span class="pillar-idx-num"></span>
                        </span>
                        <span class="text-white fw-bold small" id="pillarTitlePreview_${idx}">New Pillar</span>
                    </div>
                    <button type="button" class="btn btn-outline-danger btn-sm py-0 px-2" onclick="removePillar(${idx})" title="Remove this pillar">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
                <div class="row g-3">
                    <div class="col-md-7">
                        <label class="form-label-admin">Feature Title</label>
                        <input type="text" name="points[${idx}][title]" class="form-control form-control-admin pillar-title-input" placeholder="e.g. 100% Fresh Farm Ingredients" required oninput="updateLivePreview()"/>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label-admin">Color Badge Theme</label>
                        <select name="points[${idx}][color]" class="form-select form-control-admin pillar-color-select" onchange="updatePillarColor(${idx}, this.value); updateLivePreview();">
                            <option value="r">🔴 Red / Primary (ftico r)</option>
                            <option value="y">🟡 Yellow / Gold (ftico y)</option>
                            <option value="g">🟢 Green / Fresh (ftico g)</option>
                            <option value="b">🔵 Cyan / Cool (ftico b)</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label-admin">Icon Class (FontAwesome)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-warning" id="iconInputAddon_${idx}">
                                <i class="fas fa-leaf"></i>
                            </span>
                            <input type="text" name="points[${idx}][icon]" id="pillarIconInput_${idx}" class="form-control form-control-admin pillar-icon-input" value="fas fa-leaf" placeholder="e.g. fas fa-leaf" required oninput="updatePillarIcon(${idx}, this.value); updateLivePreview();"/>
                        </div>
                        <div class="d-flex gap-1 flex-wrap mt-2">
                            <span class="text-secondary me-1" style="font-size:0.75rem;">Presets:</span>
                            <button type="button" class="icon-btn-choice" onclick="selectPresetIcon(${idx}, 'fas fa-leaf')"><i class="fas fa-leaf me-1"></i>Leaf</button>
                            <button type="button" class="icon-btn-choice" onclick="selectPresetIcon(${idx}, 'fas fa-award')"><i class="fas fa-award me-1"></i>Award</button>
                            <button type="button" class="icon-btn-choice" onclick="selectPresetIcon(${idx}, 'fas fa-shipping-fast')"><i class="fas fa-shipping-fast me-1"></i>Delivery</button>
                            <button type="button" class="icon-btn-choice" onclick="selectPresetIcon(${idx}, 'fas fa-utensils')"><i class="fas fa-utensils me-1"></i>Utensils</button>
                            <button type="button" class="icon-btn-choice" onclick="selectPresetIcon(${idx}, 'fas fa-heart')"><i class="fas fa-heart me-1"></i>Heart</button>
                            <button type="button" class="icon-btn-choice" onclick="selectPresetIcon(${idx}, 'fas fa-star')"><i class="fas fa-star me-1"></i>Star</button>
                            <button type="button" class="icon-btn-choice" onclick="selectPresetIcon(${idx}, 'fas fa-fire')"><i class="fas fa-fire me-1"></i>Fire</button>
                            <button type="button" class="icon-btn-choice" onclick="selectPresetIcon(${idx}, 'fas fa-clock')"><i class="fas fa-clock me-1"></i>Clock</button>
                            <button type="button" class="icon-btn-choice" onclick="selectPresetIcon(${idx}, 'fas fa-shield-alt')"><i class="fas fa-shield-alt me-1"></i>Quality</button>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label-admin">Feature Description</label>
                        <textarea name="points[${idx}][desc]" class="form-control form-control-admin pillar-desc-input" rows="2" placeholder="Briefly describe this highlight..." required oninput="updateLivePreview()"></textarea>
                    </div>
                </div>
            </div>
        `;
        document.getElementById('pillarsList').insertAdjacentHTML('beforeend', template);
        renumberPillars();
        updateLivePreview();
    }

    function previewUpload(input, thumbId, previewId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const thumb = document.getElementById(thumbId);
                const prev = document.getElementById(previewId);
                if (thumb) thumb.src = e.target.result;
                if (prev) prev.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function updateLivePreview() {
        const tagline = document.getElementById('inputTagline');
        const title = document.getElementById('inputTitle');
        const desc = document.getElementById('inputDesc');
        const badgeNum = document.getElementById('inputBadgeNum');
        const badgeText = document.getElementById('inputBadgeText');
        const btn1 = document.getElementById('inputBtn1Text');
        const btn2 = document.getElementById('inputBtn2Text');

        if (tagline) document.getElementById('previewTagline').textContent = tagline.value || 'Our Heritage';
        if (title) document.getElementById('previewTitle').textContent = title.value || 'We Invite You to Visit Our Food Restaurant';
        if (desc) document.getElementById('previewDesc').textContent = desc.value || '';
        if (badgeNum) document.getElementById('previewBadgeNum').textContent = badgeNum.value || '12+';
        if (badgeText) document.getElementById('previewBadgeText').textContent = (badgeText.value || 'Years of Excellence').replace('\n', ' ');
        if (btn1) document.getElementById('previewBtn1').innerHTML = '<i class="fas fa-utensils me-1"></i>' + (btn1.value || 'Explore Our Menu');
        if (btn2) document.getElementById('previewBtn2').innerHTML = '<i class="fas fa-calendar-check me-1"></i>' + (btn2.value || 'Book a Table');

        // Update pillars in preview
        const container = document.getElementById('previewPillarsContainer');
        const cards = document.querySelectorAll('#pillarsList .pillar-card');
        let html = '';

        cards.forEach((card, i) => {
            const tInput = card.querySelector('.pillar-title-input');
            const dInput = card.querySelector('.pillar-desc-input');
            const cSelect = card.querySelector('.pillar-color-select');
            const iInput = card.querySelector('.pillar-icon-input');

            const t = tInput ? tInput.value : '';
            const d = dInput ? dInput.value : '';
            const c = cSelect ? cSelect.value : 'r';
            const ico = iInput ? iInput.value : 'fas fa-check-circle';

            // Also update card's preview title
            const cardTitlePrev = card.querySelector('[id^="pillarTitlePreview_"]');
            if (cardTitlePrev) cardTitlePrev.textContent = t || 'Feature Pillar';

            html += `
                <div class="preview-fti">
                    <div class="preview-ftico ${c}">
                        <i class="${ico}"></i>
                    </div>
                    <div>
                        <h6 class="text-white mb-0" style="font-size:0.88rem;font-weight:700;">${escapeHtml(t)}</h6>
                        <p class="text-secondary mb-0" style="font-size:0.78rem;">${escapeHtml(d)}</p>
                    </div>
                </div>
            `;
        });

        if (container) container.innerHTML = html;
    }

    function escapeHtml(str) {
        if (!str) return '';
        return str
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    // Attach real-time listeners
    document.addEventListener('DOMContentLoaded', function() {
        ['inputTagline', 'inputTitle', 'inputDesc', 'inputBadgeNum', 'inputBadgeText', 'inputBtn1Text', 'inputBtn2Text'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.addEventListener('input', updateLivePreview);
        });
        renumberPillars();
    });
</script>
@endpush
