@extends('frontend.layouts.app')

@section('title', config('app.name', 'Fast Food') . ' - Fresh, Delicious Burgers & Restaurant')

@section('content')
   <!-- ============================================================
         HERO SECTION
         ============================================================ -->
   <section id="hero">
      <div class="hs hs1"></div>
      <div class="hs hs2"></div>
      <div class="hbgtxt">FOOD</div>
      <div class="container">
         <div class="row align-items-center g-5" style="min-height:88vh;">
            <div class="col-lg-6">
               <div class="hbadge">
                  <div class="hbi"><i class="{{ $homeSettings['hero_badge_icon'] ?? 'fas fa-star' }}"></i></div>
                  <span>{{ $homeSettings['hero_badge'] ?? '#1 Rated Fast Food in New York' }}</span>
               </div>
               <h1 class="htitle">
                  @php
                     $hTitle = $homeSettings['hero_title'] ?? 'Delicious Fast Food for Every Moment';
                     $hHighlight = $homeSettings['hero_highlight'] ?? '';
                     if (!empty($hHighlight) && str_contains($hTitle, $hHighlight)) {
                        $displayTitle = str_replace($hHighlight, '<span class="hl">' . e($hHighlight) . '</span>', e($hTitle));
                     } elseif (str_contains($hTitle, '<span class="hl">')) {
                        $displayTitle = $hTitle;
                     } else {
                        $displayTitle = e($hTitle);
                     }
                  @endphp
                  {!! nl2br($displayTitle) !!}
               </h1>
               <p class="hdesc">
                  {{ $homeSettings['hero_desc'] ?? 'Experience bold flavors crafted from premium ingredients. From crispy smashed burgers to gourmet pizzas - every bite is an adventure worth savoring.' }}
               </p>
               <div class="d-flex flex-wrap gap-3 mb-2">
                  <a href="{{ !empty($homeSettings['hero_btn1_url']) ? $homeSettings['hero_btn1_url'] : route('menu') }}" class="btn-red">
                     <i class="fas fa-utensils"></i>{{ $homeSettings['hero_btn1_text'] ?? 'Explore Menu' }}
                  </a>
                  <a href="{{ $homeSettings['hero_btn2_url'] ?? 'https://www.youtube.com/watch?v=RXv_uIN6e-Y' }}" class="magnific_popup btn-play popup-youtube">
                     <div class="pico"><i class="fas fa-play"></i></div>
                     <span>{{ $homeSettings['hero_btn2_text'] ?? 'Watch Our Story' }}</span>
                  </a>
               </div>
               <div class="hstats d-flex gap-3 flex-wrap mt-4">
                  <div class="hstat">
                     <span class="snum">{{ $homeSettings['happy_customers'] ?? '850+' }}</span>
                     <small>{{ $homeSettings['happy_customers_label'] ?? 'Happy Customers' }}</small>
                  </div>
                  <div class="sdiv"></div>
                  <div class="hstat">
                     <span class="snum">{{ $homeSettings['menu_count'] ?? '120+' }}</span>
                     <small>{{ $homeSettings['menu_count_label'] ?? 'Menu Items' }}</small>
                  </div>
                  <div class="sdiv"></div>
                  <div class="hstat">
                     <span class="snum">{{ $homeSettings['chefs_count'] ?? '15+' }}</span>
                     <small>{{ $homeSettings['chefs_count_label'] ?? 'Expert Chefs' }}</small>
                  </div>
                  <div class="sdiv"></div>
                  <div class="hstat">
                     <span class="snum">{{ $homeSettings['experience_years'] ?? '12yr' }}</span>
                     <small>{{ $homeSettings['experience_years_label'] ?? 'Experience' }}</small>
                  </div>
               </div>
            </div>
            <div class="col-lg-6">
               <div class="hero-image-wrap">
                  <div class="hcircle">
                     <img src="{{ asset($homeSettings['hero_image'] ?? 'img/banner-img.jpg') }}"
                        alt="{{ $homeSettings['hero_title'] ?? 'Fast Food' }}" />
                  </div>
                  <!-- Floating Card 1 (Top Left: Hot Deal) -->
                  <div class="hero-float-card hfc-1">
                     <div class="hfc-icon red"><i class="{{ $homeSettings['card1_icon'] ?? 'fas fa-fire' }}"></i></div>
                     <div class="hfc-content">
                        <span class="hfc-title">{{ $homeSettings['card1_title'] ?? 'Hot Deal' }}</span>
                        <span class="hfc-subtitle">{{ $homeSettings['card1_subtitle'] ?? '30% off today' }}</span>
                     </div>
                  </div>
                  <!-- Floating Card 2 (Center Right: Fast Delivery) -->
                  <div class="hero-float-card hfc-2">
                     <div class="hfc-icon green"><i class="{{ $homeSettings['card2_icon'] ?? 'fas fa-clock' }}"></i></div>
                     <div class="hfc-content">
                        <span class="hfc-title">{{ $homeSettings['card2_title'] ?? '20 min' }}</span>
                        <span class="hfc-subtitle">{{ $homeSettings['card2_subtitle'] ?? 'Fast delivery' }}</span>
                     </div>
                  </div>
                  <!-- Floating Card 3 (Bottom Left: Rating & Reviews) -->
                  <div class="hero-float-card hfc-3">
                     <div class="hfc-icon yellow"><i class="{{ $homeSettings['card3_icon'] ?? 'fas fa-star' }}"></i></div>
                     <div class="hfc-content">
                        <span class="hfc-title">{{ $homeSettings['card3_title'] ?? '4.9/5' }}</span>
                        <span class="hfc-subtitle">{{ $homeSettings['card3_subtitle'] ?? '2k+ reviews' }}</span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>

   <!-- MARQUEE -->
   <div class="mqsec">
      <div class="mqtrack">
         <div class="mqitem"><i class="fas fa-circle"></i>Crispy Fried Chicken</div>
         <div class="mqitem"><i class="fas fa-circle"></i>Gourmet Burgers</div>
         <div class="mqitem"><i class="fas fa-circle"></i>Artisan Pizzas</div>
         <div class="mqitem"><i class="fas fa-circle"></i>Fresh Wraps &amp; Rolls</div>
         <div class="mqitem"><i class="fas fa-circle"></i>Loaded Fries</div>
         <div class="mqitem"><i class="fas fa-circle"></i>Ice Cream Shakes</div>
         <div class="mqitem"><i class="fas fa-circle"></i>Grilled Sandwiches</div>
         <div class="mqitem"><i class="fas fa-circle"></i>Crispy Fried Chicken</div>
         <div class="mqitem"><i class="fas fa-circle"></i>Gourmet Burgers</div>
      </div>
   </div>

   <!-- CATEGORY -->
   <section id="category">
      <div class="container">
         <div class="text-center mb-5" data-aos="fade-up">
            <span class="slbl">What We Offer</span>
            <h2 class="stitle">Browse by <span>Category</span></h2>
            <div class="sline"></div>
            <p class="sdesc mx-auto" style="max-width:480px;">From sizzling burgers to exotic world cuisines - find your
               favourite in our menu</p>
         </div>
         @php
            $allCount = count($menuItems);
            $burgersCount = collect($menuItems)->where('category', 'burgers')->count();
            $pizzaCount = collect($menuItems)->where('category', 'pizza')->count();
            $chickenCount = collect($menuItems)->where('category', 'chicken')->count();
            $wrapsCount = collect($menuItems)->where('category', 'wraps')->count();
            $dessertsCount = collect($menuItems)->where('category', 'desserts')->count();
         @endphp
         <div class="row g-3 justify-content-center">
            <div class="col-6 col-sm-4 col-md-3 col-lg-2" data-aos="zoom-in" data-aos-delay="0">
               <div class="catcard active" data-filter="all">
                  <img class="catimg" src="{{ asset('img/category/1.jpg') }}" alt="" />
                  <div class="catnm">All Items</div>
                  <div class="catct">{{ $allCount }} items</div>
               </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2" data-aos="zoom-in" data-aos-delay="70">
               <div class="catcard" data-filter="burgers">
                  <img class="catimg" src="{{ asset('img/category/2.jpg') }}" alt="" />
                  <div class="catnm">Burgers</div>
                  <div class="catct">{{ $burgersCount }} items</div>
               </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2" data-aos="zoom-in" data-aos-delay="140">
               <div class="catcard" data-filter="pizza">
                  <img class="catimg" src="{{ asset('img/category/3.jpg') }}" alt="" />
                  <div class="catnm">Pizza</div>
                  <div class="catct">{{ $pizzaCount }} items</div>
               </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2" data-aos="zoom-in" data-aos-delay="210">
               <div class="catcard" data-filter="chicken">
                  <img class="catimg" src="{{ asset('img/category/4.jpg') }}" alt="" />
                  <div class="catnm">Fried Chicken</div>
                  <div class="catct">{{ $chickenCount }} items</div>
               </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2" data-aos="zoom-in" data-aos-delay="280">
               <div class="catcard" data-filter="wraps">
                  <img class="catimg" src="{{ asset('img/category/5.jpg') }}" alt="" />
                  <div class="catnm">Wraps</div>
                  <div class="catct">{{ $wrapsCount }} items</div>
               </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2" data-aos="zoom-in" data-aos-delay="350">
               <div class="catcard" data-filter="desserts">
                  <img class="catimg" src="{{ asset('img/category/6.jpg') }}" alt="" />
                  <div class="catnm">Desserts</div>
                  <div class="catct">{{ $dessertsCount }} items</div>
               </div>
            </div>
         </div>
      </div>
   </section>

   <!-- ABOUT -->
   <section id="about">
      <div class="container">
         <div class="row align-items-center g-5">
            <div class="col-lg-5" data-aos="fade-right">
               <div class="astack">
                  <div class="aexp"><span class="anum">{{ $aboutSettings['years_badge'] ?? '12+' }}</span><small>{!! nl2br(e($aboutSettings['years_badge_text'] ?? "Years of\nExcellence")) !!}</small></div>
                  <div class="amain"><img src="{{ asset($aboutSettings['image1'] ?? 'img/about1.jpg') }}" alt="Restaurant" /></div>
                  <div class="asm"><img src="{{ asset($aboutSettings['image2'] ?? 'img/about2.jpg') }}" alt="Quality Food" /></div>
               </div>
            </div>
            <div class="col-lg-7" data-aos="fade-left">
               <span class="slbl">{{ $aboutSettings['tagline'] ?? 'Our Story' }}</span>
               <h2 class="stitle text-start">
                  {!! nl2br(e($aboutSettings['title'] ?? "We Invite You to Visit\nOur Food Restaurant")) !!}</h2>
               <div class="sline lft"></div>
               <p class="sdesc mb-4">
                  {{ $aboutSettings['desc'] ?? "Founded in 2012, Fast Food began as a small corner joint with a big dream - to serve food that brings people together. Today we're proud to serve thousands of happy customers every week with the same passion that started it all." }}
               </p>
               <div class="mb-4">
                  @forelse($aboutSettings['points'] ?? [] as $point)
                     <div class="fti">
                        <div class="ftico {{ $point['color'] ?? 'r' }}"><i class="{{ $point['icon'] ?? 'fas fa-leaf' }}"></i></div>
                        <div>
                           <h6>{{ $point['title'] ?? '' }}</h6>
                           <p>{{ $point['desc'] ?? '' }}</p>
                        </div>
                     </div>
                  @empty
                     <div class="fti">
                        <div class="ftico r"><i class="fas fa-leaf"></i></div>
                        <div>
                           <h6>100% Fresh Farm Ingredients</h6>
                           <p>We source locally and sustainably. Every ingredient is hand-picked daily for maximum freshness and flavor integrity.</p>
                        </div>
                     </div>
                     <div class="fti">
                        <div class="ftico y"><i class="fas fa-award"></i></div>
                        <div>
                           <h6>Award-Winning Master Chefs</h6>
                           <p>Our kitchen is led by executive chefs whose signature recipes have earned national culinary recognition.</p>
                        </div>
                     </div>
                     <div class="fti">
                        <div class="ftico g"><i class="fas fa-shipping-fast"></i></div>
                        <div>
                           <h6>Fast &amp; Eco-Conscious Delivery</h6>
                           <p>Order online and enjoy piping hot, fresh comfort food delivered straight to your doorstep in under 35 minutes.</p>
                        </div>
                     </div>
                  @endforelse
               </div>
               <a href="{{ route('about') }}" class="btn-red"><i class="fas fa-book-open"></i>Read Our Story</a>
            </div>
         </div>
      </div>
   </section>

   <!-- ============================================================
         MENU SECTION
         ============================================================ -->
   <section id="menu">
      <div class="container">
         <div class="text-center mb-5" data-aos="fade-up">
            <span class="slbl">What's Cooking</span>
            <h2 class="stitle">Our Delicious <span>Menu</span></h2>
            <div class="sline"></div>
         </div>
         <!-- filter buttons -->
         @php
            $homeCatMap = [];
            foreach($menuItems as $m) {
               $c = $m['category'] ?? '';
               $cn = $m['category_name'] ?? ucfirst($c);
               if ($c && !isset($homeCatMap[$c])) {
                  $homeCatMap[$c] = $cn;
               }
            }
         @endphp
         <div class="text-center mb-4" data-aos="fade-up">
            <button class="filtbtn active" data-f="all">All ({{ count($menuItems) }})</button>
            @foreach($homeCatMap as $catSlug => $catLabel)
               <button class="filtbtn" data-f="{{ $catSlug }}">{{ $catLabel }}</button>
            @endforeach
         </div>
         <div class="row g-4" id="mgrid">
            @foreach($menuItems as $idx => $item)
               <div class="col-sm-6 col-lg-4 mwrap" data-c="{{ $item['category'] }}" data-aos="fade-up"
                  data-aos-delay="{{ ($idx % 3) * 80 }}">
                  <div class="mcard" data-img="{{ asset($item['image']) }}" data-title="{{ $item['title'] }}"
                     data-cat="{{ $item['category_name'] }}" data-price="${{ number_format($item['price'], 2) }}"
                     data-old="{{ !empty($item['old_price']) ? '$' . number_format($item['old_price'], 2) : '' }}"
                     data-rating="{{ $item['rating'] ?? '4.9' }}" data-reviews="{{ $item['reviews'] ?? '120' }}"
                     data-cal="{{ $item['cal'] ?? '550' }}" data-time="{{ $item['time'] ?? '15' }}"
                     data-desc="{{ $item['desc'] }}"
                     data-tags="{{ is_array($item['tags']) ? implode(',', $item['tags']) : $item['tags'] }}">
                     <div class="mimg">
                        <img src="{{ asset($item['image']) }}" alt="{{ $item['title'] }}" />
                        @if(!empty($item['badge']))
                           <div class="mbdg {{ $item['badge_class'] ?? 'hot' }}"><i class="fas fa-star"></i> {{ $item['badge'] }}
                           </div>
                        @endif
                        <div class="mhrt"><i class="far fa-heart"></i></div>
                     </div>
                     <div class="mbody">
                        <div class="mcat">{{ $item['category_name'] }}</div>
                        <div class="mtit">{{ $item['title'] }}</div>
                        <div class="mdesc">{{ Str::limit($item['desc'], 80) }}</div>
                        <div class="mfoot">
                           <div>
                              <div class="mprice">
                                 ${{ number_format($item['price'], 2) }}
                                 @if(!empty($item['old_price']))
                                    <small>${{ number_format($item['old_price'], 2) }}</small>
                                 @endif
                              </div>
                              <div class="mstars"><i class="fas fa-star text-warning"></i> <span
                                    style="color:#bbb;font-size:.7rem;">({{ $item['reviews'] ?? 95 }})</span></div>
                           </div>
                           <button class="madd" title="View Details"><i class="fas fa-plus"></i></button>
                        </div>
                     </div>
                  </div>
               </div>
            @endforeach
         </div>
         <div class="text-center mt-5">
            <a href="{{ route('menu') }}" class="btn-red"><i class="fas fa-th-large"></i>View Full Menu</a>
         </div>
      </div>
   </section>

   <!-- SPECIAL OFFER -->
   <section id="special">
      <div class="spbg"></div>
      <div class="container" style="position:relative;z-index:2;">
         <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
               <div class="sptag"><i class="fas fa-bolt me-1"></i>Limited Time Offer</div>
               <h2 class="sptitle">{{ $homeSettings['deal_title'] ?? 'Get 30% Off Our Signature Burger Meal' }}</h2>
               <p class="spdesc">
                  {{ $homeSettings['deal_desc'] ?? 'Don\'t miss our weekend special - grab our award-winning signature burger combo with loaded fries and a premium shake at an unbeatable price.' }}
               </p>
               <div class="cdwrap">
                  <div class="cditem"><span class="cdnum" id="cdH">08</span><span class="cdlbl">Hours</span></div>
                  <div class="cditem"><span class="cdnum" id="cdM">45</span><span class="cdlbl">Minutes</span></div>
                  <div class="cditem"><span class="cdnum" id="cdS">30</span><span class="cdlbl">Seconds</span></div>
               </div>
               <a href="{{ route('menu') }}" class="btn-red"><i class="fas fa-shopping-cart"></i>Grab the Deal</a>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
               <div class="spimgw">
                  <div class="spglow"></div>
                  <div class="sppbdg">
                     <span class="old">{{ $homeSettings['deal_old_price'] ?? '$24.99' }}</span>
                     <span class="np">{{ $homeSettings['deal_price'] ?? '$17.49' }}</span>
                  </div>
                  <img src="{{ asset($homeSettings['deal_image'] ?? 'img/off-img.jpg') }}"
                     alt="{{ $homeSettings['deal_title'] ?? 'Special Burger' }}" />
               </div>
            </div>
         </div>
      </div>
   </section>

   <!-- GALLERY -->
   <section id="gallery">
      <div class="container">
         <div class="text-center mb-5" data-aos="fade-up">
            <span class="slbl">Food Showcase</span>
            <h2 class="stitle">Let's See Our <span>Fast Food</span></h2>
            <div class="sline"></div>
         </div>
         <div class="ggrid" data-aos="fade-up">
            @if(!empty($galleryItems) && count($galleryItems) > 0)
               @foreach($galleryItems as $index => $item)
                  <div class="gitem" data-gi="{{ $index }}" data-gimg="{{ asset($item['image']) }}" data-gtitle="{{ $item['title'] }}"
                     data-gdesc="{{ $item['desc'] }}">
                     <img src="{{ asset($item['image']) }}" alt="{{ $item['title'] }}" />
                     <div class="gover"><span><i class="fas fa-expand-alt"></i> {{ $item['category'] ?? $item['title'] }}</span></div>
                  </div>
               @endforeach
            @else
               <div class="gitem" data-gi="0" data-gimg="{{ asset('img/portfolio/work1.jpg') }}" data-gtitle="Gourmet Burgers"
                  data-gdesc="Our award-winning smash burgers, hand-crafted with 100% premium beef, aged cheddar and house-made sauces.">
                  <img src="{{ asset('img/portfolio/work1.jpg') }}" alt="Burgers" />
                  <div class="gover"><span><i class="fas fa-expand-alt"></i> Gourmet Burgers</span></div>
               </div>
               <div class="gitem" data-gi="1" data-gimg="{{ asset('img/portfolio/work2.jpg') }}"
                  data-gtitle="Wood-Fired Pizza"
                  data-gdesc="Authentic Neapolitan-style pizzas fired at 900deg F in our wood-burning stone oven for the perfect char.">
                  <img src="{{ asset('img/portfolio/work2.jpg') }}" alt="Pizza" />
                  <div class="gover"><span><i class="fas fa-expand-alt"></i> Wood-Fired Pizza</span></div>
               </div>
            @endif
         </div>
      </div>
   </section>

   <!-- HISTORY TIMELINE -->
   <section id="history">
      <div class="container">
         <div class="text-center mb-5" data-aos="fade-up">
            <span class="slbl">Our Journey</span>
            <h2 class="stitle">A History of <span>Fast Food</span></h2>
            <div class="sline"></div>
            <p class="sdesc mx-auto" style="max-width:480px;">From humble beginnings to the city's most beloved restaurant
               - every chapter written with passion.</p>
         </div>
         <div class="timeline" data-aos="fade-up">
            <div class="tli">
               <div class="tl-left">
                  <div class="tlyear">2012</div>
                  <h5>Evolution of Fast Food</h5>
                  <p>Fast Food opens its first 20-seat diner on Flavor Street. Within 3 months, lines stretch around the
                     block every evening.</p>
               </div>
               <div class="tl-center">
                  <div class="tldot"></div>
               </div>
               <div class="tl-right">
                  <div class="tlyear">2012</div>
                  <h5>Evolution of Fast Food</h5>
                  <p>Fast Food opens its first 20-seat diner on Flavor Street. Lines stretch around the block every
                     evening.</p>
               </div>
            </div>
            <div class="tli">
               <div class="tl-left">
                  <div class="tlyear">2016</div>
                  <h5>Fine Dining &amp; Concept</h5>
                  <p>Expanding the vision - we introduced our signature tasting menu and hired our first Michelin-trained
                     master chef.</p>
               </div>
               <div class="tl-center">
                  <div class="tldot"></div>
               </div>
               <div class="tl-right">
                  <div class="tlyear">2016</div>
                  <h5>Fine Dining &amp; Concept</h5>
                  <p>Expanding the vision - we introduced our signature tasting menu elevating our craft.</p>
               </div>
            </div>
            <div class="tli">
               <div class="tl-left">
                  <div class="tlyear">2021</div>
                  <h5>Modern Fast Food Origins</h5>
                  <p>Launched our signature fast-food line, merging gourmet quality with speed and convenience. Won 3
                     culinary awards.</p>
               </div>
               <div class="tl-center">
                  <div class="tldot"></div>
               </div>
               <div class="tl-right">
                  <div class="tlyear">2021</div>
                  <h5>Modern Fast Food Origins</h5>
                  <p>Merged gourmet quality with speed and convenience. Won 3 culinary awards.</p>
               </div>
            </div>
            <div class="tli">
               <div class="tl-left">
                  <div class="tlyear">2026</div>
                  <h5>National Expansion</h5>
                  <p>Now operating across multiple locations with online delivery platforms handling 10,000+ orders weekly.
                  </p>
               </div>
               <div class="tl-center">
                  <div class="tldot"></div>
               </div>
               <div class="tl-right">
                  <div class="tlyear">2026</div>
                  <h5>National Expansion</h5>
                  <p>Handling 10,000+ orders weekly with award-winning speed and quality.</p>
               </div>
            </div>
         </div>
      </div>
   </section>

   <!-- CHEFS -->
   <section id="chefs">
      <div class="container">
         <div class="text-center mb-5" data-aos="fade-up">
            <span class="slbl">The Culinary Team</span>
            <h2 class="stitle">Meet Our Expert <span>Chefs</span></h2>
            <div class="sline"></div>
         </div>
         <div class="row g-4">
            @foreach($chefs as $idx => $chef)
               <div class="col-sm-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $idx * 80 }}">
                  <div class="chcard">
                     <div class="chimg">
                        <img src="{{ asset($chef['image']) }}" alt="{{ $chef['name'] }}" />
                        <div class="chsoc">
                           <a href="{{ !empty($chef['instagram']) ? $chef['instagram'] : '#' }}" target="{{ !empty($chef['instagram']) ? '_blank' : '_self' }}"><i class="fab fa-instagram"></i></a>
                           <a href="{{ !empty($chef['facebook']) ? $chef['facebook'] : '#' }}" target="{{ !empty($chef['facebook']) ? '_blank' : '_self' }}"><i class="fab fa-facebook-f"></i></a>
                           <a href="{{ !empty($chef['twitter']) ? $chef['twitter'] : '#' }}" target="{{ !empty($chef['twitter']) ? '_blank' : '_self' }}"><i class="fab fa-twitter"></i></a>
                        </div>
                     </div>
                     <div class="chbody">
                        <div class="chnm">{{ $chef['name'] }}</div>
                        <div class="chrole">{{ $chef['role'] }}</div>
                        <div class="chexp">{{ $chef['exp'] }}</div>
                     </div>
                  </div>
               </div>
            @endforeach
         </div>
      </div>
   </section>

   <!-- OPENING HOURS -->
   <section id="hours">
      <div class="hrsbg"></div>
      <div class="container" style="position:relative;z-index:2;">
         <div class="text-center mb-5" data-aos="fade-up">
            <span class="slbl" style="color:#a5d6bc;">Opening Hours</span>
            <h2 class="stitle" style="color:#fff;">We're Open <span style="color:var(--secondary);">For You</span></h2>
            <div class="sline"></div>
         </div>
         <div class="row g-4 align-items-start">
            <div class="col-lg-5" data-aos="fade-right">
               <div class="hrscard">
                  @if(!empty($siteSettings['hours']))
                     <div class="p-3 mb-3 rounded-3 text-center" style="background: rgba(255,255,255,0.08); border: 1px dashed rgba(255,255,255,0.25);">
                        <small class="text-uppercase tracking-wider d-block mb-1" style="color:var(--secondary);font-size:0.75rem;font-weight:600;"><i class="fas fa-clock me-1"></i>Current Working Schedule</small>
                        <strong class="text-white" style="font-size:1.05rem;">{{ $siteSettings['hours'] }}</strong>
                     </div>
                  @endif
                  <div class="hrsrow">
                     <span class="hrsday"><i class="fas fa-calendar-day me-2" style="color:var(--secondary);"></i>Monday -
                        Tuesday</span>
                     <div class="d-flex align-items-center gap-2">
                        <div class="hdot off"></div>
                        <span class="hrstime" style="color:#ff6b6b;">Closed</span>
                     </div>
                  </div>
                  <div class="hrsrow">
                     <span class="hrsday"><i class="fas fa-calendar-day me-2" style="color:var(--secondary);"></i>Wednesday
                        - Thursday</span>
                     <div class="d-flex align-items-center gap-2">
                        <div class="hdot on"></div>
                        <span class="hrstime">09:00 AM - 10:00 PM</span>
                     </div>
                  </div>
                  <div class="hrsrow">
                     <span class="hrsday"><i class="fas fa-calendar-day me-2"
                           style="color:var(--secondary);"></i>Friday</span>
                     <div class="d-flex align-items-center gap-2">
                        <div class="hdot on"></div>
                        <span class="hrstime">09:00 AM - 11:00 PM</span>
                     </div>
                  </div>
                  <div class="hrsrow">
                     <span class="hrsday"><i class="fas fa-calendar-day me-2"
                           style="color:var(--secondary);"></i>Saturday</span>
                     <div class="d-flex align-items-center gap-2">
                        <div class="hdot on"></div>
                        <span class="hrstime">10:00 AM - 11:30 PM</span>
                     </div>
                  </div>
                  <div class="hrsrow">
                     <span class="hrsday"><i class="fas fa-calendar-day me-2"
                           style="color:var(--secondary);"></i>Sunday</span>
                     <div class="d-flex align-items-center gap-2">
                        <div class="hdot on"></div>
                        <span class="hrstime">11:00 AM - 09:00 PM</span>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-3" data-aos="zoom-in">
               <div class="hrscta">
                  <i class="fas fa-truck-fast fa-2x mb-3" style="color:rgba(255,255,255,.8);"></i>
                  <h4>Order Online</h4>
                  <p>Get hot food delivered in 25 minutes</p>
                  <a href="{{ route('menu') }}" class="btnw">Order Now &rarr;</a>
               </div>
            </div>
            <div class="col-lg-4" data-aos="fade-left">
               <div class="hrscard">
                  <h5
                     style="color:#fff;margin-bottom:18px;font-family:'Poppins',sans-serif;font-size:.95rem;font-weight:700;">
                     <i class="fas fa-map-marker-alt me-2" style="color:var(--secondary);"></i>Find Us</h5>
                  <div class="hrsrow"><span class="hrsday"><i class="fas fa-location-dot me-2"
                           style="color:var(--secondary);"></i>Address</span><span class="hrstime"
                        style="font-size:.8rem;">{{ $siteSettings['address'] ?? '42 Flavor Street, Manhattan, NY 10001' }}</span></div>
                  <div class="hrsrow"><span class="hrsday"><i class="fas fa-phone me-2"
                           style="color:var(--secondary);"></i>Phone</span><span class="hrstime"
                        style="font-size:.8rem;"><a href="tel:{{ $siteSettings['phone'] ?? '+18001234567' }}" style="color:inherit;text-decoration:none;">{{ $siteSettings['phone'] ?? '+1 (800) 123-4567' }}</a></span></div>
                  <div class="hrsrow"><span class="hrsday"><i class="fas fa-envelope me-2"
                           style="color:var(--secondary);"></i>Email</span><span class="hrstime"
                        style="font-size:.8rem;"><a href="mailto:{{ $siteSettings['email'] ?? 'hello@fastfood.com' }}" style="color:inherit;text-decoration:none;">{{ $siteSettings['email'] ?? 'hello@fastfood.com' }}</a></span></div>
               </div>
            </div>
         </div>
      </div>
   </section>

   <!-- TESTIMONIALS -->
   <section id="testimonials">
      <div class="container">
         <div class="text-center mb-5" data-aos="fade-up">
            <span class="slbl">What People Say</span>
            <h2 class="stitle">Our Customers <span>Feedback</span></h2>
            <div class="sline"></div>
         </div>
         <div class="swiper tesSwiper" data-aos="fade-up">
            <div class="swiper-wrapper">
               @foreach($reviews as $review)
                  <div class="swiper-slide">
                     <div class="tescard">
                        <div class="tesq">"</div>
                        <div class="tess">
                           @for($i = 0; $i < ($review['rating'] ?? 5); $i++)
                              <i class="fas fa-star text-warning"></i>
                           @endfor
                        </div>
                        <p class="testxt">{{ $review['text'] }}</p>
                        <div class="tesauth">
                           <img src="{{ asset($review['image'] ?? 'img/testimonial/1.jpg') }}" alt="{{ $review['name'] }}" />
                           <div>
                              <div class="tesnm">{{ $review['name'] }}</div>
                              <div class="tesrl">{{ $review['role'] }}</div>
                           </div>
                        </div>
                     </div>
                  </div>
               @endforeach
            </div>
            <div class="swiper-pagination mt-4" style="position:static;"></div>
         </div>
      </div>
   </section>

   <!-- RESERVATION FORM -->
   <!-- <section id="reservation">
         <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
               <span class="slbl">Book a Table</span>
               <h2 class="stitle">Make a <span>Reservation</span></h2>
               <div class="sline"></div>
               <p class="sdesc mx-auto" style="max-width:480px;">Reserve your table for a memorable dining experience. We recommend booking 24 hours in advance for weekend evenings.</p>
            </div>
            <div class="row g-4 align-items-start">
               <div class="col-lg-4" data-aos="fade-right">
                  <div style="background:var(--dark);border-radius:18px;padding:36px;">
                     <h4 style="color:#fff;font-size:1.3rem;margin-bottom:8px;">Contact Info</h4>
                     <p style="color:rgba(255,255,255,.55);font-size:.85rem;margin-bottom:26px;">We're happy to help you plan the perfect dining experience.</p>
                     <div class="d-flex flex-column gap-3">
                        <div class="d-flex align-items-center gap-3">
                           <div style="width:46px;height:46px;border-radius:11px;background:rgba(232,40,26,.2);display:flex;align-items:center;justify-content:center;color:var(--primary);font-size:1.1rem;flex-shrink:0;"><i class="fas fa-clock"></i></div>
                           <div><strong style="display:block;color:#ccc;font-size:.78rem;text-transform:uppercase;letter-spacing:.8px;">Opening Hours</strong><span style="color:#fff;font-size:.87rem;">{{ $siteSettings['hours'] ?? 'Wed - Sun: 09 AM - 11 PM' }}</span></div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                           <div style="width:46px;height:46px;border-radius:11px;background:rgba(232,40,26,.2);display:flex;align-items:center;justify-content:center;color:var(--primary);font-size:1.1rem;flex-shrink:0;"><i class="fas fa-phone-alt"></i></div>
                           <div><strong style="display:block;color:#ccc;font-size:.78rem;text-transform:uppercase;letter-spacing:.8px;">Call for Booking</strong><span style="color:#fff;font-size:.87rem;"><a href="tel:{{ $siteSettings['phone'] ?? '+18001234567' }}" style="color:inherit;text-decoration:none;">{{ $siteSettings['phone'] ?? '+1 (800) 123-4567' }}</a></span></div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                           <div style="width:46px;height:46px;border-radius:11px;background:rgba(232,40,26,.2);display:flex;align-items:center;justify-content:center;color:var(--primary);font-size:1.1rem;flex-shrink:0;"><i class="fas fa-users"></i></div>
                           <div><strong style="display:block;color:#ccc;font-size:.78rem;text-transform:uppercase;letter-spacing:.8px;">Group Dining</strong><span style="color:#fff;font-size:.87rem;">Special menus for 10+ guests</span></div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                           <div style="width:46px;height:46px;border-radius:11px;background:rgba(232,40,26,.2);display:flex;align-items:center;justify-content:center;color:var(--primary);font-size:1.1rem;flex-shrink:0;"><i class="fas fa-map-marker-alt"></i></div>
                           <div><strong style="display:block;color:#ccc;font-size:.78rem;text-transform:uppercase;letter-spacing:.8px;">Location</strong><span style="color:#fff;font-size:.87rem;">{{ $siteSettings['address'] ?? '42 Flavor Street, Manhattan, NY 10001' }}</span></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-8" data-aos="fade-left">
                  <div class="fcard">
                     <form action="{{ route('reservation.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                           <div class="col-sm-6">
                              <label class="flbl">Full Name *</label>
                              <input type="text" name="name" class="fctrl" placeholder="John Doe" required value="{{ old('name') }}"/>
                           </div>
                           <div class="col-sm-6">
                              <label class="flbl">Phone Number *</label>
                              <input type="tel" name="phone" class="fctrl" placeholder="+1 (800) 000-0000" required value="{{ old('phone') }}"/>
                           </div>
                           <div class="col-sm-6">
                              <label class="flbl">Email Address *</label>
                              <input type="email" name="email" class="fctrl" placeholder="you@email.com" required value="{{ old('email') }}"/>
                           </div>
                           <div class="col-sm-6">
                              <label class="flbl">Number of Guests *</label>
                              <select name="guests" class="fctrl" required>
                                 <option value="1 Person">1 Person</option>
                                 <option value="2 People" selected>2 People</option>
                                 <option value="3 - 4 People">3 - 4 People</option>
                                 <option value="5 - 6 People">5 - 6 People</option>
                                 <option value="7 - 10 People">7 - 10 People</option>
                                 <option value="10+ People">10+ People</option>
                              </select>
                           </div>
                           <div class="col-sm-6">
                              <label class="flbl">Date *</label>
                              <input type="date" name="date" class="fctrl" required value="{{ old('date', date('Y-m-d')) }}"/>
                           </div>
                           <div class="col-sm-6">
                              <label class="flbl">Time *</label>
                              <select name="time" class="fctrl" required>
                                 <option value="11:00 AM">11:00 AM</option>
                                 <option value="12:00 PM">12:00 PM</option>
                                 <option value="01:00 PM">01:00 PM</option>
                                 <option value="02:00 PM">02:00 PM</option>
                                 <option value="06:00 PM">06:00 PM</option>
                                 <option value="07:00 PM" selected>07:00 PM</option>
                                 <option value="08:00 PM">08:00 PM</option>
                                 <option value="09:00 PM">09:00 PM</option>
                                 <option value="10:00 PM">10:00 PM</option>
                              </select>
                           </div>
                           <div class="col-12">
                              <label class="flbl">Special Requests</label>
                              <textarea name="special_requests" class="fctrl" rows="3" placeholder="Allergies, dietary needs, booth seating, special occasions...">{{ old('special_requests') }}</textarea>
                           </div>
                           <div class="col-12">
                              <button type="submit" class="btn-red w-100 justify-content-center">
                                 <i class="fas fa-calendar-check"></i>Confirm Reservation
                              </button>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </section> -->

   <!-- BLOG -->
   <section id="blog">
      <div class="container">
         <div class="text-center mb-5" data-aos="fade-up">
            <span class="slbl">News &amp; Updates</span>
            <h2 class="stitle">Our Latest <span>Blog</span> Posts</h2>
            <div class="sline"></div>
         </div>
         <div class="row g-4">
            @foreach($blogs as $idx => $blog)
               <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $idx * 80 }}">
                  <div class="blcard">
                     <div class="blimg">
                        <img src="{{ asset($blog['image']) }}" alt="{{ $blog['title'] }}" />
                        <div class="bldatebdg"><span class="bd">{{ $blog['day'] }}</span><span
                              class="bm">{{ $blog['month'] }}</span></div>
                     </div>
                     <div class="blbody">
                        <div class="bltag">{{ $blog['category'] }}</div>
                        <div class="bltit"><a href="{{ route('blog.detail', $blog['id']) }}">{{ $blog['title'] }}</a></div>
                        <div class="blmeta"><span><i class="fas fa-user"></i>{{ $blog['author'] }}</span><span><i
                                 class="fas fa-comment"></i>{{ $blog['comments'] }} Comments</span></div>
                        <a href="{{ route('blog.detail', $blog['id']) }}" class="blmore">Read More <i
                              class="fas fa-arrow-right"></i></a>
                     </div>
                  </div>
               </div>
            @endforeach
         </div>
      </div>
   </section>

   <!-- NEWSLETTER -->
   <section id="newsletter">
      <div class="nlbg"></div>
      <div class="container">
         <div class="nlw text-center" data-aos="zoom-in">
            <span class="slbl" style="color:rgba(255,255,255,.7);">Stay Connected</span>
            <h2 class="mb-3" style="color:#fff;">Subscribe &amp; Get Exclusive <span
                  style="color:var(--secondary);">Deals</span></h2>
            <p class="mb-4" style="color:rgba(255,255,255,.78);">Get 15% off your first order plus early access to new menu
               items</p>
            <div class="nl-form-wrap">
               <input class="nlinput" type="email" id="nlEmail" placeholder="Enter your email address..." />
               <button class="nlbtn" id="nlBtn"><i class="fas fa-paper-plane me-1"></i>Subscribe</button>
            </div>
            <p style="color:rgba(255,255,255,.45);font-size:.76rem;margin-top:11px;"><i class="fas fa-lock me-1"></i>No
               spam, unsubscribe anytime.</p>
         </div>
      </div>
   </section>

   <!-- CONTACT SECTION -->
   <section id="contact-section">
      <div class="container">
         <div class="text-center mb-5" data-aos="fade-up">
            <span class="slbl">Get In Touch</span>
            <h2 class="stitle">Contact <span>Us</span></h2>
            <div class="sline"></div>
            <p class="sdesc mx-auto" style="max-width:480px;">Have a question, feedback, or want to plan a special event?
               We'd love to hear from you.</p>
         </div>
         <div class="row g-4">
            <div class="col-lg-4" data-aos="fade-right">
               <div class="ctdark">
                  <h4>Let's Talk</h4>
                  <p class="ctsub">We typically respond within 2 hours during business hours.</p>
                  <div class="ctitem">
                     <div class="cticon"><i class="fas fa-map-marker-alt"></i></div>
                     <div class="ctinfo"><strong>Address</strong>{{ $siteSettings['address'] ?? '42 Flavor Street, Manhattan, NY 10001' }}</div>
                  </div>
                  <div class="ctitem">
                     <div class="cticon"><i class="fas fa-phone-alt"></i></div>
                     <div class="ctinfo"><strong>Phone</strong><a href="tel:{{ $siteSettings['phone'] ?? '+18001234567' }}" style="color:inherit;text-decoration:none;">{{ $siteSettings['phone'] ?? '+1 (800) 123-4567' }}</a></div>
                  </div>
                  <div class="ctitem">
                     <div class="cticon"><i class="fas fa-envelope"></i></div>
                     <div class="ctinfo"><strong>Email</strong><a href="mailto:{{ $siteSettings['email'] ?? 'hello@fastfood.com' }}" style="color:inherit;text-decoration:none;">{{ $siteSettings['email'] ?? 'hello@fastfood.com' }}</a></div>
                  </div>
                  <div class="ctitem">
                     <div class="cticon"><i class="fas fa-clock"></i></div>
                     <div class="ctinfo"><strong>Working Hours</strong>{{ $siteSettings['hours'] ?? 'Wed - Sun: 09 AM - 11 PM' }}</div>
                  </div>
                  <div class="ctsocrow">
                     <a href="{{ $siteSettings['facebook'] ?? '#' }}" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                     <a href="{{ $siteSettings['instagram'] ?? '#' }}" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
                     <a href="{{ $siteSettings['twitter'] ?? '#' }}" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a>
                     <a href="{{ $siteSettings['youtube'] ?? '#' }}" target="_blank" title="YouTube"><i class="fab fa-youtube"></i></a>
                     <a href="{{ $siteSettings['tiktok'] ?? '#' }}" target="_blank" title="TikTok"><i class="fab fa-tiktok"></i></a>
                  </div>
               </div>
            </div>
            <div class="col-lg-8" data-aos="fade-left">
               <div class="fcard">
                  @if(session('success'))
                     <div class="alert alert-success alert-dismissible fade show border-0 bg-success bg-opacity-25 text-success mb-4" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                     </div>
                  @endif

                  @if($errors->any())
                     <div class="alert alert-danger alert-dismissible fade show border-0 bg-danger bg-opacity-25 text-danger mb-4" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i> <strong>Please check the following errors:</strong>
                        <ul class="mb-0 mt-2 small">
                           @foreach($errors->all() as $error)
                              <li>{{ $error }}</li>
                           @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                     </div>
                  @endif

                  <form action="{{ route('contact.store') }}" method="POST">
                     @csrf
                     <div class="row g-3">
                        <div class="col-sm-6">
                           <label class="flbl">Your Name *</label>
                           <input type="text" name="name" class="fctrl" placeholder="John Doe" required
                              value="{{ old('name') }}" />
                        </div>
                        <div class="col-sm-6">
                           <label class="flbl">Email Address *</label>
                           <input type="email" name="email" class="fctrl" placeholder="you@email.com" required
                              value="{{ old('email') }}" />
                        </div>
                        <div class="col-sm-6">
                           <label class="flbl">Phone Number</label>
                           <input type="tel" name="phone" class="fctrl" placeholder="+1 (800) 000-0000"
                              value="{{ old('phone') }}" />
                        </div>
                        <div class="col-sm-6">
                           <label class="flbl">Subject *</label>
                           <select name="subject" class="fctrl" required>
                              <option value="General Inquiry">General Inquiry</option>
                              <option value="Catering & Events">Catering &amp; Events</option>
                              <option value="Feedback">Feedback</option>
                              <option value="Partnership">Partnership</option>
                              <option value="Media & Press">Media &amp; Press</option>
                           </select>
                        </div>
                        <div class="col-12">
                           <label class="flbl">Message *</label>
                           <textarea name="message" class="fctrl" rows="5" placeholder="Write your message here..."
                              required>{{ old('message') }}</textarea>
                        </div>
                        <div class="col-12">
                           <button type="submit" class="btn-red"><i class="fas fa-paper-plane"></i>Send Message</button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection