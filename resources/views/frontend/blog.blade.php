@extends('frontend.layouts.app')

@section('title', 'Blog & Food Stories - ' . config('app.name', 'Fast Food'))

@section('content')
   <!-- PAGE BANNER -->
   <div class="page-banner">
      <div class="container">
         <h1>Kitchen <span>Stories</span> &amp; News</h1>
         <p>Culinary tips, recipes, food culture, and the latest happenings from the Fast Food kitchen.</p>
         <div class="page-breadcrumb">
            <a href="{{ route('home') }}"><i class="fas fa-home me-1"></i>Home</a>
            <span>/</span>
            <span>Blog</span>
         </div>
      </div>
   </div>

   <!-- BLOG GRID -->
   <section id="blog" style="padding: 85px 0;">
      <div class="container">
         <div class="row g-4">
            @foreach($blogs as $idx => $blog)
               <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $idx * 90 }}">
                  <div class="blcard shadow-sm h-100">
                     <div class="blimg">
                        <img src="{{ asset($blog['image']) }}" alt="{{ $blog['title'] }}"/>
                        <div class="bldatebdg"><span class="bd">{{ $blog['day'] }}</span><span class="bm">{{ $blog['month'] }}</span></div>
                     </div>
                     <div class="blbody d-flex flex-column justify-content-between">
                        <div>
                           <div class="bltag">{{ $blog['category'] }}</div>
                           <div class="bltit"><a href="{{ route('blog.detail', $blog['id']) }}">{{ $blog['title'] }}</a></div>
                           <p class="text-muted" style="font-size:0.88rem;line-height:1.5;">{{ $blog['excerpt'] }}</p>
                        </div>
                        <div>
                           <div class="blmeta mb-2">
                              <span><i class="fas fa-user"></i>{{ $blog['author'] }}</span>
                              <span><i class="fas fa-comment"></i>{{ $blog['comments'] }} Comments</span>
                           </div>
                           <a href="{{ route('blog.detail', $blog['id']) }}" class="blmore">Read Full Story <i class="fas fa-arrow-right"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
            @endforeach
         </div>
      </div>
   </section>
@endsection
