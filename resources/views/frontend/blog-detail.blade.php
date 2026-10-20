@extends('frontend.layouts.app')

@section('title', ($post['title'] ?? 'Blog Article') . ' - ' . config('app.name', 'Fast Food'))

@section('content')
   <!-- PAGE BANNER -->
   <div class="page-banner">
      <div class="container">
         <span class="badge bg-warning text-dark mb-2 px-3 py-2 fw-semibold">{{ $post['category'] ?? 'Culinary Science' }}</span>
         <h1 style="font-size:2.2rem;max-width:800px;margin:0 auto 10px;">{{ $post['title'] ?? 'Food Story' }}</h1>
         <div class="page-breadcrumb">
            <a href="{{ route('home') }}"><i class="fas fa-home me-1"></i>Home</a>
            <span>/</span>
            <a href="{{ route('blog') }}">Blog</a>
            <span>/</span>
            <span>Article</span>
         </div>
      </div>
   </div>

   <!-- BLOG CONTENT -->
   <section style="padding: 80px 0;">
      <div class="container">
         <div class="row g-5">
            <!-- MAIN ARTICLE -->
            <div class="col-lg-8">
               <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border">
                  <div class="mb-4 rounded-4 overflow-hidden shadow-sm">
                     <img src="{{ asset($post['image'] ?? 'img/blog/1.jpg') }}" class="w-100" style="max-height:420px;object-fit:cover;" alt="{{ $post['title'] ?? '' }}"/>
                  </div>
                  <div class="d-flex align-items-center gap-3 text-muted mb-4 pb-3 border-bottom" style="font-size:0.85rem;">
                     <span><i class="fas fa-user text-danger me-1"></i>By {{ $post['author'] ?? 'Chef Master' }}</span>
                     <span><i class="fas fa-calendar-alt text-warning me-1"></i>{{ ($post['day'] ?? '15') . ' ' . ($post['month'] ?? 'March') . ' ' . date('Y') }}</span>
                     <span><i class="fas fa-comments text-primary me-1"></i>{{ $post['comments'] ?? 24 }} Comments</span>
                     <span><i class="fas fa-clock text-success me-1"></i>5 min read</span>
                  </div>

                  <div class="article-body" style="font-size:1.05rem;line-height:1.8;color:#444;">
                     <p class="lead fw-semibold text-dark">{{ $post['excerpt'] ?? '' }}</p>
                     
                     <p>{{ $post['content'] ?? 'Food is not just sustenance; it is a universal language that bridges generations and cultures. When crafting our recipes, our chefs prioritize uncompromised flavor alongside nutritional balance.' }}</p>
                     
                     <blockquote class="p-4 my-4 rounded-3" style="background:#fff8f0;border-left:4px solid var(--primary);font-style:italic;color:#333;">
                        "Great cooking is about passion, precision, and respecting each individual ingredient's natural profile."
                     </blockquote>

                     <h4 class="mt-4 mb-3" style="font-family:'Playfair Display',serif;">The Philosophy of Real Flavor</h4>
                     <p>From the caramelization of locally grown sweet onions to the temperature balance of our hand-kneaded brioche buns, subtle nuances make extraordinary bites. We never compromise on butterfat percentages or shorten the brining times of our Nashville chicken cuts.</p>

                     <div class="row g-3 my-4">
                        <div class="col-sm-6">
                           <div class="p-3 rounded-3" style="background:#f8fafc;border:1px solid #e2e8f0;">
                              <h6 class="text-danger mb-1"><i class="fas fa-check-circle me-1"></i>Farm to Counter</h6>
                              <p class="small text-muted mb-0">Delivered daily from local family-owned farms within 50 miles.</p>
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="p-3 rounded-3" style="background:#f8fafc;border:1px solid #e2e8f0;">
                              <h6 class="text-warning mb-1"><i class="fas fa-fire me-1"></i>High-Heat Searing</h6>
                              <p class="small text-muted mb-0">Locks in natural juices creating the coveted crispy crust.</p>
                           </div>
                        </div>
                     </div>

                     <p>We invite you to taste the difference yourself. Stop by our diner or order your favorite meal for fast home delivery today!</p>
                  </div>

                  <div class="mt-5 pt-4 border-top d-flex justify-content-between align-items-center flex-wrap gap-3">
                     <div class="d-flex align-items-center gap-2">
                        <span class="fw-semibold text-dark">Share:</span>
                        <a href="#" class="btn btn-sm btn-outline-danger rounded-circle"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-warning rounded-circle"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-info rounded-circle"><i class="fab fa-linkedin-in"></i></a>
                     </div>
                     <a href="{{ route('blog') }}" class="btn btn-sm btn-secondary"><i class="fas fa-arrow-left me-1"></i>Back to All Posts</a>
                  </div>
               </div>
            </div>

            <!-- SIDEBAR -->
            <div class="col-lg-4">
               <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                  <h5 class="mb-3" style="font-family:'Playfair Display',serif;font-weight:700;">Recent Stories</h5>
                  <div class="d-flex flex-column gap-3">
                     @foreach($recentPosts as $rPost)
                        <div class="d-flex gap-3 align-items-center">
                           <img src="{{ asset($rPost['image'] ?? 'img/blog/1.jpg') }}" alt="{{ $rPost['title'] }}" style="width:75px;height:70px;object-fit:cover;border-radius:10px;"/>
                           <div>
                              <span class="badge bg-light text-muted" style="font-size:0.7rem;">{{ $rPost['category'] }}</span>
                              <h6 class="mb-1" style="font-size:0.88rem;line-height:1.3;">
                                 <a href="{{ route('blog.detail', $rPost['id']) }}" class="text-dark">{{ Str::limit($rPost['title'], 45) }}</a>
                              </h6>
                              <small class="text-muted"><i class="fas fa-calendar-alt me-1"></i>{{ ($rPost['day'] ?? '') . ' ' . ($rPost['month'] ?? '') }}</small>
                           </div>
                        </div>
                     @endforeach
                  </div>
               </div>

               <!-- PROMO BANNER -->
               <div class="p-4 rounded-4 text-center text-white" style="background: linear-gradient(135deg, #e8281a, #c02013);">
                  <i class="fas fa-hamburger fa-3x mb-3 text-warning"></i>
                  <h4 class="text-white mb-2" style="font-family:'Playfair Display',serif;">Hungry Right Now?</h4>
                  <p class="small text-white-50 mb-4">Order our signature smash burgers with 30% discount today!</p>
                  <a href="{{ route('menu') }}" class="btn btn-light fw-bold px-4 py-2 text-danger rounded-pill">Order Online</a>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection
