@extends('frontend.layouts.app')

@section('title', 'Meet Our Chefs - ' . config('app.name', 'Fast Food'))

@section('content')
   <!-- PAGE BANNER -->
   <div class="page-banner">
      <div class="container">
         <h1>Our Master <span>Chefs</span></h1>
         <p>Meet the award-winning culinary talent bringing passion, creativity, and craftsmanship to every single plate.
         </p>
         <div class="page-breadcrumb">
            <a href="{{ route('home') }}"><i class="fas fa-home me-1"></i>Home</a>
            <span>/</span>
            <span>Chefs</span>
         </div>
      </div>
   </div>

   <!-- CHEFS TEAM -->
   <section id="chefs" style="padding: 85px 0;">
      <div class="container">
         <div class="text-center mb-5" data-aos="fade-up">
            <span class="slbl">Masters of the Kitchen</span>
            <h2 class="stitle">Award-Winning <span>Culinary Team</span></h2>
            <div class="sline"></div>
         </div>
         <div class="row g-4">
            @foreach($chefs as $idx => $chef)
               <div class="col-sm-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $idx * 90 }}">
                  <div class="chcard shadow-sm">
                     <div class="chimg">
                        <img src="{{ asset($chef['image']) }}" alt="{{ $chef['name'] }}" />
                        <div class="chsoc">
                           <a href="{{ !empty($chef['instagram']) ? $chef['instagram'] : '#' }}"
                              target="{{ !empty($chef['instagram']) ? '_blank' : '_self' }}"><i
                                 class="fab fa-instagram"></i></a>
                           <a href="{{ !empty($chef['facebook']) ? $chef['facebook'] : '#' }}"
                              target="{{ !empty($chef['facebook']) ? '_blank' : '_self' }}"><i
                                 class="fab fa-facebook-f"></i></a>
                           <a href="{{ !empty($chef['twitter']) ? $chef['twitter'] : '#' }}"
                              target="{{ !empty($chef['twitter']) ? '_blank' : '_self' }}"><i class="fab fa-twitter"></i></a>
                        </div>
                     </div>
                     <div class="chbody">
                        <div class="chnm">{{ $chef['name'] }}</div>
                        <div class="chrole">{{ $chef['role'] }}</div>
                        <div class="chexp">{{ $chef['exp'] }}</div>
                        @if(!empty($chef['bio']))
                           <p class="text-muted mt-2 mb-0" style="font-size:0.8rem;line-height:1.4;">{{ $chef['bio'] }}</p>
                        @endif
                     </div>
                  </div>
               </div>
            @endforeach
         </div>

         <!-- JOIN THE TEAM CALLOUT -->
         <div class="mt-5 p-5 text-center rounded-4 shadow-sm"
            style="background: linear-gradient(135deg, #1e293b, #0f172a); color: #fff;" data-aos="zoom-in">
            <h3 class="text-white mb-2" style="font-family:'Playfair Display',serif;">Want to Cook With Us?</h3>
            <p class="text-light opacity-75 mb-4 mx-auto" style="max-width:550px;">We're always scouting for dynamic sous
               chefs, grill masters, and pastry artisans to join our fast-growing kitchen crew.</p>
            <a href="{{ route('contact') }}" class="btn-red"><i class="fas fa-paper-plane me-1"></i>Apply for Kitchen
               Careers</a>
         </div>
      </div>
   </section>
@endsection