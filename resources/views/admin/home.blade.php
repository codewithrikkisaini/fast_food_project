@extends('admin.layouts.app')

@section('title', 'Home Section & Images Settings')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <h2 class="h3 fw-bold text-white mb-1">Home Section &amp; Hero Banner Manager</h2>
            <p class="text-secondary mb-0" style="font-size:0.9rem;">Change hero main heading, glowing highlight words,
                action buttons, floating badges, banner images, and promotional deals.</p>
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
                        <i id="previewBadgeIcon" class="{{ $home['hero_badge_icon'] ?? 'fas fa-star' }} text-warning"></i>
                        <span id="previewBadge">{{ $home['hero_badge'] ?? '#1 Rated Fast Food in New York' }}</span>
                    </div>
                    <h1 id="previewHeading"
                        style="font-family:'Playfair Display',serif;font-size:2.3rem;font-weight:900;line-height:1.2;color:#fff;margin-bottom:14px;">
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
                    <div class="d-flex gap-2 flex-wrap mb-3">
                        <span id="previewBtn1" class="btn btn-sm text-white px-3 py-2 fw-bold"
                            style="background:#e8281a;border-radius:25px;"><i
                                class="fas fa-utensils me-1"></i>{{ $home['hero_btn1_text'] ?? 'Explore Menu' }}</span>
                        <span id="previewBtn2" class="btn btn-sm btn-dark text-light border border-secondary px-3 py-2"
                            style="border-radius:25px;"><i
                                class="fas fa-play me-1"></i>{{ $home['hero_btn2_text'] ?? 'Watch Our Story' }}</span>
                    </div>

                    <!-- Live Stats in Preview -->
                    <div class="d-flex gap-3 flex-wrap pt-3 border-top border-secondary">
                        <div>
                            <span id="previewStat1Val"
                                class="text-white fw-bold d-block fs-6">{{ $home['happy_customers'] ?? '850+' }}</span>
                            <small id="previewStat1Lbl" class="text-secondary"
                                style="font-size:0.7rem;">{{ $home['happy_customers_label'] ?? 'Happy Customers' }}</small>
                        </div>
                        <div style="width:1px;background:#334155;height:28px;"></div>
                        <div>
                            <span id="previewStat2Val"
                                class="text-white fw-bold d-block fs-6">{{ $home['menu_count'] ?? '120+' }}</span>
                            <small id="previewStat2Lbl" class="text-secondary"
                                style="font-size:0.7rem;">{{ $home['menu_count_label'] ?? 'Menu Items' }}</small>
                        </div>
                        <div style="width:1px;background:#334155;height:28px;"></div>
                        <div>
                            <span id="previewStat3Val"
                                class="text-white fw-bold d-block fs-6">{{ $home['chefs_count'] ?? '15+' }}</span>
                            <small id="previewStat3Lbl" class="text-secondary"
                                style="font-size:0.7rem;">{{ $home['chefs_count_label'] ?? 'Expert Chefs' }}</small>
                        </div>
                        <div style="width:1px;background:#334155;height:28px;"></div>
                        <div>
                            <span id="previewStat4Val"
                                class="text-white fw-bold d-block fs-6">{{ $home['experience_years'] ?? '12yr' }}</span>
                            <small id="previewStat4Lbl" class="text-secondary"
                                style="font-size:0.7rem;">{{ $home['experience_years_label'] ?? 'Experience' }}</small>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 text-center">
                    <div style="position:relative;display:inline-block;padding:25px;">
                        <!-- Mini Preview Circle -->
                        <div
                            style="width:180px;height:180px;border-radius:50%;margin:0 auto;overflow:hidden;border:4px solid #e8281a;box-shadow:0 0 35px rgba(232,40,26,0.4);background:#111;">
                            <img id="previewHeroImg" src="{{ asset($home['hero_image'] ?? 'img/banner-img.jpg') }}"
                                alt="Hero Banner" style="width:100%;height:100%;object-fit:cover;" />
                        </div>

                        <!-- Mini Floating Badge 1 (Top Left) -->
                        <div id="previewCard1"
                            style="position:absolute;top:10px;left:0;background:#fff;border-radius:20px;padding:4px 10px;display:flex;align-items:center;gap:6px;box-shadow:0 4px 15px rgba(0,0,0,0.3);font-size:0.72rem;color:#111;text-align:left;white-space:nowrap;">
                            <i id="previewCard1Icon" class="{{ $home['card1_icon'] ?? 'fas fa-fire' }}"
                                style="color:#e8281a;font-size:0.85rem;"></i>
                            <div>
                                <strong id="previewCard1Title" class="d-block text-dark"
                                    style="font-size:0.72rem;line-height:1;">{{ $home['card1_title'] ?? 'Hot Deal' }}</strong>
                                <small id="previewCard1Sub"
                                    style="color:#666;font-size:0.6rem;">{{ $home['card1_subtitle'] ?? '30% off today' }}</small>
                            </div>
                        </div>

                        <!-- Mini Floating Badge 2 (Center Right) -->
                        <div id="previewCard2"
                            style="position:absolute;top:45%;right:0;background:#fff;border-radius:20px;padding:4px 10px;display:flex;align-items:center;gap:6px;box-shadow:0 4px 15px rgba(0,0,0,0.3);font-size:0.72rem;color:#111;text-align:left;white-space:nowrap;">
                            <i id="previewCard2Icon" class="{{ $home['card2_icon'] ?? 'fas fa-clock' }}"
                                style="color:#2d6a4f;font-size:0.85rem;"></i>
                            <div>
                                <strong id="previewCard2Title" class="d-block text-dark"
                                    style="font-size:0.72rem;line-height:1;">{{ $home['card2_title'] ?? '20 min' }}</strong>
                                <small id="previewCard2Sub"
                                    style="color:#666;font-size:0.6rem;">{{ $home['card2_subtitle'] ?? 'Fast delivery' }}</small>
                            </div>
                        </div>

                        <!-- Mini Floating Badge 3 (Bottom Left) -->
                        <div id="previewCard3"
                            style="position:absolute;bottom:10px;left:5px;background:#fff;border-radius:20px;padding:4px 10px;display:flex;align-items:center;gap:6px;box-shadow:0 4px 15px rgba(0,0,0,0.3);font-size:0.72rem;color:#111;text-align:left;white-space:nowrap;">
                            <i id="previewCard3Icon" class="{{ $home['card3_icon'] ?? 'fas fa-star' }}"
                                style="color:#f6a623;font-size:0.85rem;"></i>
                            <div>
                                <strong id="previewCard3Title" class="d-block text-dark"
                                    style="font-size:0.72rem;line-height:1;">{{ $home['card3_title'] ?? '4.9/5' }}</strong>
                                <small id="previewCard3Sub"
                                    style="color:#666;font-size:0.6rem;">{{ $home['card3_subtitle'] ?? '2k+ reviews' }}</small>
                            </div>
                        </div>
                    </div>
                    <small class="text-secondary d-block mt-2">Active Hero Circle &amp; Floating Badges</small>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- LEFT COLUMN: HEADINGS, BUTTONS & CARDS -->
            <div class="col-lg-7">
                <!-- 1. MAIN HEADING CONFIGURATION -->
                <div class="admin-card mb-4">
                    <div class="admin-card-header">
                        <h3 class="admin-card-title"><i class="fas fa-heading text-danger"></i> Main Heading, Highlight
                            &amp; Badge</h3>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label-admin">Main Heading Title *</label>
                            <input type="text" name="hero_title" id="inputHeroTitle"
                                class="form-control form-control-admin fs-6"
                                value="{{ old('hero_title', $home['hero_title'] ?? 'Delicious Fast Food for Every Moment') }}"
                                oninput="updateLivePreview()" required />
                            <small class="text-secondary">This is the main large headline on the homepage hero
                                banner.</small>
                        </div>

                        <div class="col-12">
                            <label class="form-label-admin">Highlight / Glowing Word(s) in Heading</label>
                            <input type="text" name="hero_highlight" id="inputHeroHighlight"
                                class="form-control form-control-admin"
                                value="{{ old('hero_highlight', $home['hero_highlight'] ?? 'Fast Food') }}"
                                oninput="updateLivePreview()" placeholder="e.g. Fast Food" />
                            <small class="text-secondary">Word(s) in your title that will be styled with the glowing curve
                                effect.</small>
                        </div>

                        <div class="col-sm-8">
                            <label class="form-label-admin">Hero Top Pill Badge Text</label>
                            <input type="text" name="hero_badge" id="inputHeroBadge" class="form-control form-control-admin"
                                value="{{ old('hero_badge', $home['hero_badge'] ?? '#1 Rated Fast Food in New York') }}"
                                oninput="updateLivePreview()" required />
                        </div>

                        <div class="col-sm-4">
                            <label class="form-label-admin">Badge Icon</label>
                            <input type="text" name="hero_badge_icon" id="inputHeroBadgeIcon"
                                class="form-control form-control-admin"
                                value="{{ old('hero_badge_icon', $home['hero_badge_icon'] ?? 'fas fa-star') }}"
                                oninput="updateLivePreview()" placeholder="fas fa-star" />
                        </div>

                        <div class="col-12">
                            <label class="form-label-admin">Hero Description *</label>
                            <textarea name="hero_desc" id="inputHeroDesc" class="form-control form-control-admin" rows="3"
                                oninput="updateLivePreview()"
                                required>{{ old('hero_desc', $home['hero_desc'] ?? 'Experience bold flavors crafted from premium ingredients. From crispy smashed burgers to gourmet pizzas - every bite is an adventure worth savoring.') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- 2. HERO ACTION BUTTONS -->
                <div class="admin-card mb-4">
                    <div class="admin-card-header">
                        <h3 class="admin-card-title"><i class="fas fa-mouse-pointer text-danger"></i> Hero Action Buttons
                        </h3>
                    </div>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label class="form-label-admin">Button 1 Text (Explore Menu)</label>
                            <input type="text" name="hero_btn1_text" id="inputHeroBtn1Text"
                                class="form-control form-control-admin"
                                value="{{ old('hero_btn1_text', $home['hero_btn1_text'] ?? 'Explore Menu') }}"
                                oninput="updateLivePreview()" placeholder="Explore Menu" />
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label-admin">Button 1 Link (Optional)</label>
                            <input type="text" name="hero_btn1_url" class="form-control form-control-admin"
                                value="{{ old('hero_btn1_url', $home['hero_btn1_url'] ?? '') }}"
                                placeholder="Leave empty for /menu" />
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label-admin">Button 2 Text (Watch Story)</label>
                            <input type="text" name="hero_btn2_text" id="inputHeroBtn2Text"
                                class="form-control form-control-admin"
                                value="{{ old('hero_btn2_text', $home['hero_btn2_text'] ?? 'Watch Our Story') }}"
                                oninput="updateLivePreview()" placeholder="Watch Our Story" />
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label-admin">Button 2 YouTube Video URL</label>
                            <input type="text" name="hero_btn2_url" class="form-control form-control-admin"
                                value="{{ old('hero_btn2_url', $home['hero_btn2_url'] ?? 'https://www.youtube.com/watch?v=RXv_uIN6e-Y') }}"
                                placeholder="https://www.youtube.com/watch?v=..." />
                        </div>
                    </div>
                </div>

                <!-- 3. HERO FLOATING BADGES / CARDS (AROUND HERO CIRCLE) -->
                <div class="admin-card mb-4">
                    <div class="admin-card-header d-flex justify-content-between align-items-center">
                        <h3 class="admin-card-title"><i class="fas fa-layer-group text-danger"></i> Hero Floating Badges (3
                            Cards)</h3>
                        <span class="badge bg-danger">Dynamic Floating Cards</span>
                    </div>
                    <p class="text-secondary mb-3" style="font-size:0.88rem;">Customize the 3 interactive floating badges
                        that appear around the circular banner image on the homepage.</p>

                    <div class="row g-3">
                        <!-- Card 1 (Top Left) -->
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 h-100"
                                style="background:#090d16; border:1px solid rgba(232,40,26,0.35);">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge"
                                        style="background:rgba(232,40,26,0.2); color:#ff6b6b; font-size:0.75rem;"><i
                                            class="fas fa-fire me-1"></i> Card 1 (Top Left)</span>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label-admin fs-7 mb-1">Title</label>
                                    <input type="text" name="card1_title" id="inputCard1Title"
                                        class="form-control form-control-admin"
                                        value="{{ old('card1_title', $home['card1_title'] ?? 'Hot Deal') }}"
                                        oninput="updateLivePreview()" placeholder="Hot Deal" />
                                </div>
                                <div class="mb-2">
                                    <label class="form-label-admin fs-7 mb-1">Subtitle</label>
                                    <input type="text" name="card1_subtitle" id="inputCard1Subtitle"
                                        class="form-control form-control-admin"
                                        value="{{ old('card1_subtitle', $home['card1_subtitle'] ?? '30% off today') }}"
                                        oninput="updateLivePreview()" placeholder="30% off today" />
                                </div>
                                <div>
                                    <label class="form-label-admin fs-7 mb-1">Icon (FontAwesome)</label>
                                    <input type="text" name="card1_icon" id="inputCard1Icon"
                                        class="form-control form-control-admin"
                                        value="{{ old('card1_icon', $home['card1_icon'] ?? 'fas fa-fire') }}"
                                        oninput="updateLivePreview()" placeholder="fas fa-fire" />
                                </div>
                            </div>
                        </div>

                        <!-- Card 2 (Center Right) -->
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 h-100"
                                style="background:#090d16; border:1px solid rgba(45,106,79,0.35);">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge"
                                        style="background:rgba(45,106,79,0.2); color:#4ade80; font-size:0.75rem;"><i
                                            class="fas fa-clock me-1"></i> Card 2 (Center Right)</span>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label-admin fs-7 mb-1">Title</label>
                                    <input type="text" name="card2_title" id="inputCard2Title"
                                        class="form-control form-control-admin"
                                        value="{{ old('card2_title', $home['card2_title'] ?? '20 min') }}"
                                        oninput="updateLivePreview()" placeholder="20 min" />
                                </div>
                                <div class="mb-2">
                                    <label class="form-label-admin fs-7 mb-1">Subtitle</label>
                                    <input type="text" name="card2_subtitle" id="inputCard2Subtitle"
                                        class="form-control form-control-admin"
                                        value="{{ old('card2_subtitle', $home['card2_subtitle'] ?? 'Fast delivery') }}"
                                        oninput="updateLivePreview()" placeholder="Fast delivery" />
                                </div>
                                <div>
                                    <label class="form-label-admin fs-7 mb-1">Icon (FontAwesome)</label>
                                    <input type="text" name="card2_icon" id="inputCard2Icon"
                                        class="form-control form-control-admin"
                                        value="{{ old('card2_icon', $home['card2_icon'] ?? 'fas fa-clock') }}"
                                        oninput="updateLivePreview()" placeholder="fas fa-clock" />
                                </div>
                            </div>
                        </div>

                        <!-- Card 3 (Bottom Left) -->
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 h-100"
                                style="background:#090d16; border:1px solid rgba(246,166,35,0.35);">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge"
                                        style="background:rgba(246,166,35,0.2); color:#fbbf24; font-size:0.75rem;"><i
                                            class="fas fa-star me-1"></i> Card 3 (Bottom Left)</span>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label-admin fs-7 mb-1">Title</label>
                                    <input type="text" name="card3_title" id="inputCard3Title"
                                        class="form-control form-control-admin"
                                        value="{{ old('card3_title', $home['card3_title'] ?? '4.9/5') }}"
                                        oninput="updateLivePreview()" placeholder="4.9/5" />
                                </div>
                                <div class="mb-2">
                                    <label class="form-label-admin fs-7 mb-1">Subtitle</label>
                                    <input type="text" name="card3_subtitle" id="inputCard3Subtitle"
                                        class="form-control form-control-admin"
                                        value="{{ old('card3_subtitle', $home['card3_subtitle'] ?? '2k+ reviews') }}"
                                        oninput="updateLivePreview()" placeholder="2k+ reviews" />
                                </div>
                                <div>
                                    <label class="form-label-admin fs-7 mb-1">Icon (FontAwesome)</label>
                                    <input type="text" name="card3_icon" id="inputCard3Icon"
                                        class="form-control form-control-admin"
                                        value="{{ old('card3_icon', $home['card3_icon'] ?? 'fas fa-star') }}"
                                        oninput="updateLivePreview()" placeholder="fas fa-star" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4. LIVE STATS COUNTERS & LABELS -->
                <div class="admin-card mb-4">
                    <div class="admin-card-header">
                        <h3 class="admin-card-title"><i class="fas fa-calculator text-info"></i> Hero Live Stats Counters
                            &amp; Custom Labels</h3>
                    </div>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label class="form-label-admin">Stat 1 Value</label>
                            <input type="text" name="happy_customers" id="inputStat1Val"
                                class="form-control form-control-admin"
                                value="{{ old('happy_customers', $home['happy_customers'] ?? '850+') }}"
                                oninput="updateLivePreview()" />
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label-admin">Stat 1 Label</label>
                            <input type="text" name="happy_customers_label" id="inputStat1Lbl"
                                class="form-control form-control-admin"
                                value="{{ old('happy_customers_label', $home['happy_customers_label'] ?? 'Happy Customers') }}"
                                oninput="updateLivePreview()" />
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label-admin">Stat 2 Value</label>
                            <input type="text" name="menu_count" id="inputStat2Val" class="form-control form-control-admin"
                                value="{{ old('menu_count', $home['menu_count'] ?? '120+') }}"
                                oninput="updateLivePreview()" />
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label-admin">Stat 2 Label</label>
                            <input type="text" name="menu_count_label" id="inputStat2Lbl"
                                class="form-control form-control-admin"
                                value="{{ old('menu_count_label', $home['menu_count_label'] ?? 'Menu Items') }}"
                                oninput="updateLivePreview()" />
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label-admin">Stat 3 Value</label>
                            <input type="text" name="chefs_count" id="inputStat3Val" class="form-control form-control-admin"
                                value="{{ old('chefs_count', $home['chefs_count'] ?? '15+') }}"
                                oninput="updateLivePreview()" />
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label-admin">Stat 3 Label</label>
                            <input type="text" name="chefs_count_label" id="inputStat3Lbl"
                                class="form-control form-control-admin"
                                value="{{ old('chefs_count_label', $home['chefs_count_label'] ?? 'Expert Chefs') }}"
                                oninput="updateLivePreview()" />
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label-admin">Stat 4 Value</label>
                            <input type="text" name="experience_years" id="inputStat4Val"
                                class="form-control form-control-admin"
                                value="{{ old('experience_years', $home['experience_years'] ?? '12yr') }}"
                                oninput="updateLivePreview()" />
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label-admin">Stat 4 Label</label>
                            <input type="text" name="experience_years_label" id="inputStat4Lbl"
                                class="form-control form-control-admin"
                                value="{{ old('experience_years_label', $home['experience_years_label'] ?? 'Experience') }}"
                                oninput="updateLivePreview()" />
                        </div>
                    </div>
                </div>

                <!-- 5. SPECIAL DEAL OF THE DAY SETTINGS -->
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

                <!-- 6. TOPBAR ANNOUNCEMENT -->
                <div class="admin-card mb-4">
                    <div class="admin-card-header">
                        <h3 class="admin-card-title"><i class="fas fa-bullhorn text-info"></i> Top Bar Announcement</h3>
                    </div>
                    <div>
                        <label class="form-label-admin">Top Announcement Ribbon</label>
                        <input type="text" name="announcement" class="form-control form-control-admin"
                            value="{{ old('announcement', $home['announcement'] ?? 'Free Delivery Today on Orders Over $25!') }}" />
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: IMAGE MANAGEMENT & SAVE -->
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
                const title = document.getElementById('inputHeroTitle')?.value || '';
                const highlight = document.getElementById('inputHeroHighlight')?.value || '';
                const badge = document.getElementById('inputHeroBadge')?.value || '';
                const badgeIcon = document.getElementById('inputHeroBadgeIcon')?.value || 'fas fa-star';
                const desc = document.getElementById('inputHeroDesc')?.value || '';

                if (document.getElementById('previewBadge')) document.getElementById('previewBadge').textContent = badge;
                if (document.getElementById('previewBadgeIcon')) document.getElementById('previewBadgeIcon').className = badgeIcon + ' text-warning';
                if (document.getElementById('previewDesc')) document.getElementById('previewDesc').textContent = desc;

                // Buttons
                const btn1Text = document.getElementById('inputHeroBtn1Text')?.value || 'Explore Menu';
                const btn2Text = document.getElementById('inputHeroBtn2Text')?.value || 'Watch Our Story';
                if (document.getElementById('previewBtn1')) document.getElementById('previewBtn1').innerHTML = '<i class="fas fa-utensils me-1"></i>' + btn1Text;
                if (document.getElementById('previewBtn2')) document.getElementById('previewBtn2').innerHTML = '<i class="fas fa-play me-1"></i>' + btn2Text;

                // Stats
                if (document.getElementById('previewStat1Val')) document.getElementById('previewStat1Val').textContent = document.getElementById('inputStat1Val')?.value || '';
                if (document.getElementById('previewStat1Lbl')) document.getElementById('previewStat1Lbl').textContent = document.getElementById('inputStat1Lbl')?.value || '';
                if (document.getElementById('previewStat2Val')) document.getElementById('previewStat2Val').textContent = document.getElementById('inputStat2Val')?.value || '';
                if (document.getElementById('previewStat2Lbl')) document.getElementById('previewStat2Lbl').textContent = document.getElementById('inputStat2Lbl')?.value || '';
                if (document.getElementById('previewStat3Val')) document.getElementById('previewStat3Val').textContent = document.getElementById('inputStat3Val')?.value || '';
                if (document.getElementById('previewStat3Lbl')) document.getElementById('previewStat3Lbl').textContent = document.getElementById('inputStat3Lbl')?.value || '';
                if (document.getElementById('previewStat4Val')) document.getElementById('previewStat4Val').textContent = document.getElementById('inputStat4Val')?.value || '';
                if (document.getElementById('previewStat4Lbl')) document.getElementById('previewStat4Lbl').textContent = document.getElementById('inputStat4Lbl')?.value || '';

                // Floating Cards
                const card1Title = document.getElementById('inputCard1Title')?.value || 'Hot Deal';
                const card1Sub = document.getElementById('inputCard1Subtitle')?.value || '30% off today';
                const card1Icon = document.getElementById('inputCard1Icon')?.value || 'fas fa-fire';

                const card2Title = document.getElementById('inputCard2Title')?.value || '20 min';
                const card2Sub = document.getElementById('inputCard2Subtitle')?.value || 'Fast delivery';
                const card2Icon = document.getElementById('inputCard2Icon')?.value || 'fas fa-clock';

                const card3Title = document.getElementById('inputCard3Title')?.value || '4.9/5';
                const card3Sub = document.getElementById('inputCard3Subtitle')?.value || '2k+ reviews';
                const card3Icon = document.getElementById('inputCard3Icon')?.value || 'fas fa-star';

                if (document.getElementById('previewCard1Title')) document.getElementById('previewCard1Title').textContent = card1Title;
                if (document.getElementById('previewCard1Sub')) document.getElementById('previewCard1Sub').textContent = card1Sub;
                if (document.getElementById('previewCard1Icon')) document.getElementById('previewCard1Icon').className = card1Icon;

                if (document.getElementById('previewCard2Title')) document.getElementById('previewCard2Title').textContent = card2Title;
                if (document.getElementById('previewCard2Sub')) document.getElementById('previewCard2Sub').textContent = card2Sub;
                if (document.getElementById('previewCard2Icon')) document.getElementById('previewCard2Icon').className = card2Icon;

                if (document.getElementById('previewCard3Title')) document.getElementById('previewCard3Title').textContent = card3Title;
                if (document.getElementById('previewCard3Sub')) document.getElementById('previewCard3Sub').textContent = card3Sub;
                if (document.getElementById('previewCard3Icon')) document.getElementById('previewCard3Icon').className = card3Icon;

                // Title highlight
                let formatted = title;
                if (highlight && formatted.includes(highlight)) {
                    formatted = formatted.replace(highlight, '<span style="color:#e8281a;position:relative;">' + highlight + '</span>');
                }
                if (document.getElementById('previewHeading')) document.getElementById('previewHeading').innerHTML = formatted;
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