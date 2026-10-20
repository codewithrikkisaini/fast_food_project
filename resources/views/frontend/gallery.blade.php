@extends('frontend.layouts.app')

@section('title', 'Food Gallery - ' . config('app.name', 'Fast Food'))

@section('content')
   <!-- PAGE BANNER -->
   <div class="page-banner">
      <div class="container">
         <h1>Food <span>Gallery</span></h1>
         <p>A visual showcase of our gourmet creations, fresh ingredients, and cozy restaurant atmosphere.</p>
         <div class="page-breadcrumb">
            <a href="{{ route('home') }}"><i class="fas fa-home me-1"></i>Home</a>
            <span>/</span>
            <span>Gallery</span>
         </div>
      </div>
   </div>

   <!-- GALLERY SHOWCASE -->
   <section id="gallery" style="padding: 85px 0;">
      <div class="container">
         <div class="text-center mb-5" data-aos="fade-up">
            <span class="slbl">Visual Journey</span>
            <h2 class="stitle">Our Signature <span>Dishes &amp; Moments</span></h2>
            <div class="sline"></div>
         </div>
         <div class="ggrid" data-aos="fade-up">
            @if(!empty($galleryItems) && count($galleryItems) > 0)
               @foreach($galleryItems as $index => $item)
                  <div class="gitem"
                     data-gi="{{ $index }}"
                     data-gimg="{{ asset($item['image']) }}"
                     data-gtitle="{{ $item['title'] }}"
                     data-gdesc="{{ $item['desc'] }}">
                     <img src="{{ asset($item['image']) }}" alt="{{ $item['title'] }}"/>
                     <div class="gover"><span><i class="fas fa-expand-alt"></i> {{ $item['category'] ?? $item['title'] }}</span></div>
                  </div>
               @endforeach
            @else
               <div class="gitem"
                  data-gi="0"
                  data-gimg="{{ asset('img/portfolio/work1.jpg') }}"
                  data-gtitle="Gourmet Smash Burgers"
                  data-gdesc="Double-smashed beef patties, melted aged cheddar, caramelized shallots, and house-made secret sauce on toasted brioche.">
                  <img src="{{ asset('img/portfolio/work1.jpg') }}" alt="Burgers"/>
                  <div class="gover"><span><i class="fas fa-expand-alt"></i> Gourmet Burgers</span></div>
               </div>
               <div class="gitem"
                  data-gi="1"
                  data-gimg="{{ asset('img/portfolio/work2.jpg') }}"
                  data-gtitle="Wood-Fired Truffle Pizza"
                  data-gdesc="Hand-stretched 48-hour fermented sourdough fired at 900deg F in our wood-burning stone oven.">
                  <img src="{{ asset('img/portfolio/work2.jpg') }}" alt="Pizza"/>
                  <div class="gover"><span><i class="fas fa-expand-alt"></i> Wood-Fired Pizza</span></div>
               </div>
               <div class="gitem"
                  data-gi="2"
                  data-gimg="{{ asset('img/portfolio/work3.jpg') }}"
                  data-gtitle="Nashville Hot Crispy Chicken"
                  data-gdesc="Double-brined, buttermilk battered golden fried chicken tossed in fiery cayenne-infused spices.">
                  <img src="{{ asset('img/portfolio/work3.jpg') }}" alt="Chicken"/>
                  <div class="gover"><span><i class="fas fa-expand-alt"></i> Crispy Fried Chicken</span></div>
               </div>
               <div class="gitem"
                  data-gi="3"
                  data-gimg="{{ asset('img/portfolio/work4.jpg') }}"
                  data-gtitle="Molten Nutella Lava Cake"
                  data-gdesc="Warm chocolate molten cake filled with decadent hazelnut cream, served with Madagascar vanilla ice cream.">
                  <img src="{{ asset('img/portfolio/work4.jpg') }}" alt="Desserts"/>
                  <div class="gover"><span><i class="fas fa-expand-alt"></i> Sweet Desserts</span></div>
               </div>
               <div class="gitem"
                  data-gi="4"
                  data-gimg="{{ asset('img/portfolio/work5.jpg') }}"
                  data-gtitle="Loaded Fajita Wraps"
                  data-gdesc="Fresh grilled chicken breast, roasted bell peppers, fresh guacamole and house-made salsa verde.">
                  <img src="{{ asset('img/portfolio/work5.jpg') }}" alt="Wraps"/>
                  <div class="gover"><span><i class="fas fa-expand-alt"></i> Fresh Wraps &amp; Rolls</span></div>
               </div>
            @endif
         </div>
      </div>
   </section>
@endsection
