@extends('frontend.layouts.app')

@section('title', 'About Us - ' . config('app.name', 'Fast Food'))

@section('content')
   <!-- PAGE BANNER -->
   <div class="page-banner">
      <div class="container">
         <h1>Our <span>Story</span> &amp; Heritage</h1>
         <p>Crafting unforgettable fast-food moments with authentic flavors, local produce, and culinary perfection since 2012.</p>
         <div class="page-breadcrumb">
            <a href="{{ route('home') }}"><i class="fas fa-home me-1"></i>Home</a>
            <span>/</span>
            <span>About Us</span>
         </div>
      </div>
   </div>

   <!-- ABOUT STORY -->
   <section id="about" style="padding: 90px 0;">
      <div class="container">
         <div class="row align-items-center g-5">
            <div class="col-lg-5" data-aos="fade-right">
               <div class="astack">
                  <div class="aexp"><span class="anum">{{ $aboutSettings['years_badge'] ?? '12+' }}</span><small>Years of<br/>Excellence</small></div>
                  <div class="amain"><img src="{{ asset('img/about1.jpg') }}" alt="Restaurant Story"/></div>
                  <div class="asm"><img src="{{ asset('img/about2.jpg') }}" alt="Quality Food"/></div>
               </div>
            </div>
            <div class="col-lg-7" data-aos="fade-left">
               <span class="slbl">{{ $aboutSettings['tagline'] ?? 'Our Heritage' }}</span>
               <h2 class="stitle text-start">{!! nl2br(e($aboutSettings['title'] ?? "We Invite You to Visit\nOur Food Restaurant")) !!}</h2>
               <div class="sline lft"></div>
               <p class="sdesc mb-4">{{ $aboutSettings['desc'] ?? "Founded in 2012, Fast Food began as a small corner joint with a big dream - to serve food that brings people together. Today we're proud to serve thousands of happy customers every week with the same passion that started it all." }}</p>
               <div class="mb-4">
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
                        <p>Order online and enjoy piping hot, fresh comfort food delivered straight to your doorstep in under 25 minutes.</p>
                     </div>
                  </div>
               </div>
               <div class="d-flex gap-3 flex-wrap">
                  <a href="{{ route('menu') }}" class="btn-red"><i class="fas fa-utensils"></i>Explore Our Menu</a>
                  <a href="{{ route('reservation') }}" class="btnw" style="border:1px solid #ddd;color:#333;"><i class="fas fa-calendar-check me-1"></i>Book a Table</a>
               </div>
            </div>
         </div>
      </div>
   </section>

   <!-- CHEFS SECTION -->
   <section id="chefs" style="background:#faf7f2;padding:90px 0;">
      <div class="container">
         <div class="text-center mb-5" data-aos="fade-up">
            <span class="slbl">The Culinary Team</span>
            <h2 class="stitle">Meet Our Expert <span>Chefs</span></h2>
            <div class="sline"></div>
            <p class="sdesc mx-auto" style="max-width:500px;">The passionate culinary artists behind every smashed burger and stone-baked pizza.</p>
         </div>
         <div class="row g-4">
            @foreach($chefs as $idx => $chef)
               <div class="col-sm-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $idx * 80 }}">
                  <div class="chcard bg-white shadow-sm">
                     <div class="chimg">
                        <img src="{{ asset($chef['image']) }}" alt="{{ $chef['name'] }}"/>
                        <div class="chsoc">
                           <a href="#"><i class="fab fa-instagram"></i></a>
                           <a href="#"><i class="fab fa-facebook-f"></i></a>
                           <a href="#"><i class="fab fa-twitter"></i></a>
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

   <!-- REVIEWS SLIDER -->
   @if(!empty($reviews))
   <section id="testimonials" style="padding:90px 0;">
      <div class="container">
         <div class="text-center mb-5" data-aos="fade-up">
            <span class="slbl">What Diners Say</span>
            <h2 class="stitle">Customer <span>Endorsements</span></h2>
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
                           <img src="{{ asset($review['image'] ?? 'img/testimonial/1.jpg') }}" alt="{{ $review['name'] }}"/>
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
   @endif
@endsection
