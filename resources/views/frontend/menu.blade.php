@extends('frontend.layouts.app')

@section('title', 'Our Menu - ' . config('app.name', 'Fast Food'))

@section('content')
   <!-- PAGE BANNER -->
   <div class="page-banner">
      <div class="container">
         <h1>Our Delicious <span>Menu</span></h1>
         <p>Freshly prepared burgers, wood-fired artisan pizzas, crispy chicken, and mouth-watering desserts.</p>
         <div class="page-breadcrumb">
            <a href="{{ route('home') }}"><i class="fas fa-home me-1"></i>Home</a>
            <span>/</span>
            <span>Menu</span>
         </div>
      </div>
   </div>

   <!-- MENU SECTION -->
   <section id="menu" style="padding: 80px 0;">
      <div class="container">
         <div class="text-center mb-5" data-aos="fade-up">
            <span class="slbl">Fresh &amp; Flavorful</span>
            <h2 class="stitle">Explore By <span>Category</span></h2>
            <div class="sline"></div>
         </div>
         <!-- filter buttons -->
         <div class="text-center mb-5" data-aos="fade-up">
            <button class="filtbtn active" data-f="all">All Items</button>
            <button class="filtbtn" data-f="burgers">Burgers</button>
            <button class="filtbtn" data-f="pizza">Pizza</button>
            <button class="filtbtn" data-f="chicken">Chicken</button>
            <button class="filtbtn" data-f="wraps">Wraps</button>
            <button class="filtbtn" data-f="desserts">Desserts</button>
            <button class="filtbtn" data-f="pasta">Pasta</button>
         </div>

         <div class="row g-4" id="mgrid">
            @foreach($menuItems as $idx => $item)
               <div class="col-sm-6 col-lg-4 mwrap" data-c="{{ $item['category'] }}" data-aos="fade-up" data-aos-delay="{{ ($idx % 3) * 80 }}">
                  <div class="mcard"
                     data-img="{{ asset($item['image']) }}"
                     data-title="{{ $item['title'] }}"
                     data-cat="{{ $item['category_name'] }}"
                     data-price="${{ number_format($item['price'], 2) }}" 
                     data-old="{{ !empty($item['old_price']) ? '$' . number_format($item['old_price'], 2) : '' }}"
                     data-rating="{{ $item['rating'] ?? '4.9' }}" 
                     data-reviews="{{ $item['reviews'] ?? '120' }}"
                     data-cal="{{ $item['cal'] ?? '550' }}" 
                     data-time="{{ $item['time'] ?? '15' }}"
                     data-desc="{{ $item['desc'] }}"
                     data-tags="{{ is_array($item['tags']) ? implode(',', $item['tags']) : $item['tags'] }}">
                     <div class="mimg">
                        <img src="{{ asset($item['image']) }}" alt="{{ $item['title'] }}"/>
                        @if(!empty($item['badge']))
                           <div class="mbdg {{ $item['badge_class'] ?? 'hot' }}"><i class="fas fa-star"></i> {{ $item['badge'] }}</div>
                        @endif
                        <div class="mhrt"><i class="far fa-heart"></i></div>
                     </div>
                     <div class="mbody">
                        <div class="mcat">{{ $item['category_name'] }}</div>
                        <div class="mtit">{{ $item['title'] }}</div>
                        <div class="mdesc">{{ Str::limit($item['desc'], 85) }}</div>
                        <div class="mfoot">
                           <div>
                              <div class="mprice">
                                 ${{ number_format($item['price'], 2) }} 
                                 @if(!empty($item['old_price']))
                                    <small>${{ number_format($item['old_price'], 2) }}</small>
                                 @endif
                              </div>
                              <div class="mstars"><i class="fas fa-star text-warning"></i> <span style="color:#bbb;font-size:.7rem;">({{ $item['reviews'] ?? 95 }})</span></div>
                           </div>
                           <button class="madd" title="View Details"><i class="fas fa-plus"></i></button>
                        </div>
                     </div>
                  </div>
               </div>
            @endforeach
         </div>
      </div>
   </section>
@endsection
