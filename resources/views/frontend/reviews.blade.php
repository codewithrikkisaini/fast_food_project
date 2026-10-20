@extends('frontend.layouts.app')

@section('title', 'Customer Reviews - ' . config('app.name', 'Fast Food'))

@section('content')
   <!-- PAGE BANNER -->
   <div class="page-banner">
      <div class="container">
         <h1>Customer <span>Reviews</span></h1>
         <p>Read what our diners say about our food, ambiance, and service. We strive for excellence in every order.</p>
         <div class="page-breadcrumb">
            <a href="{{ route('home') }}"><i class="fas fa-home me-1"></i>Home</a>
            <span>/</span>
            <span>Reviews</span>
         </div>
      </div>
   </div>

   <!-- REVIEWS OVERVIEW & LIST -->
   <section style="padding: 85px 0;">
      <div class="container">
         <!-- STATS ROW -->
         <div class="row g-4 mb-5 align-items-center">
            <div class="col-lg-4 text-center p-4 rounded-4" style="background:#fff8f0;border:1px solid #fef0dc;">
               <div style="font-size:3.5rem;font-weight:900;color:var(--primary);line-height:1;">4.9</div>
               <div class="text-warning my-2" style="font-size:1.3rem;">
                  <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
               </div>
               <h6 class="mb-0 text-muted">Overall Diner Rating (850+ Reviews)</h6>
            </div>
            <div class="col-lg-8">
               <div class="p-4 bg-white rounded-4 shadow-sm">
                  <div class="d-flex align-items-center justify-content-between mb-2">
                     <span class="fw-semibold">Food Quality &amp; Freshness</span>
                     <span class="text-muted">98% Satisfied</span>
                  </div>
                  <div class="progress mb-3" style="height:8px;">
                     <div class="progress-bar bg-danger" style="width: 98%"></div>
                  </div>
                  <div class="d-flex align-items-center justify-content-between mb-2">
                     <span class="fw-semibold">Delivery Speed (&lt; 25 mins)</span>
                     <span class="text-muted">95% Satisfied</span>
                  </div>
                  <div class="progress mb-3" style="height:8px;">
                     <div class="progress-bar bg-warning" style="width: 95%"></div>
                  </div>
                  <div class="d-flex align-items-center justify-content-between mb-2">
                     <span class="fw-semibold">Friendly Customer Care</span>
                     <span class="text-muted">99% Satisfied</span>
                  </div>
                  <div class="progress" style="height:8px;">
                     <div class="progress-bar bg-success" style="width: 99%"></div>
                  </div>
               </div>
            </div>
         </div>

         <!-- REVIEWS GRID -->
         <div class="row g-4 mb-5">
            @foreach($reviews as $review)
               <div class="col-md-6 col-lg-6">
                  <div class="tescard h-100 bg-white shadow-sm p-4 rounded-4 border">
                     <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="tess">
                           @for($i = 0; $i < ($review['rating'] ?? 5); $i++)
                              <i class="fas fa-star text-warning"></i>
                           @endfor
                        </div>
                        <span class="badge bg-light text-muted border" style="font-size:0.75rem;"><i class="fas fa-check-circle text-success me-1"></i>Verified Diner</span>
                     </div>
                     <p class="testxt mb-4" style="font-size:0.95rem;line-height:1.6;color:#555;">{{ $review['text'] }}</p>
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

         <!-- SUBMIT REVIEW FORM -->
         <div class="row justify-content-center">
            <div class="col-lg-8">
               <div class="fcard shadow-sm p-4 p-md-5">
                  <div class="text-center mb-4">
                     <span class="slbl">Your Voice Matters</span>
                     <h3 style="font-size:1.8rem;font-weight:700;">Leave Us a Review</h3>
                     <p class="text-muted" style="font-size:0.9rem;">Share your experience with our dishes and team</p>
                  </div>
                  <form action="{{ route('reviews.store') }}" method="POST">
                     @csrf
                     <div class="row g-3">
                        <div class="col-sm-6">
                           <label class="flbl">Your Name *</label>
                           <input type="text" name="name" class="fctrl" placeholder="Alex Morgan" required value="{{ old('name') }}"/>
                        </div>
                        <div class="col-sm-6">
                           <label class="flbl">Role / Title (e.g. Food Lover, Local Diner)</label>
                           <input type="text" name="role" class="fctrl" placeholder="Local Foodie" value="{{ old('role') }}"/>
                        </div>
                        <div class="col-12">
                           <label class="flbl">Rating (1 to 5 Stars) *</label>
                           <select name="rating" class="fctrl" required>
                              <option value="5" selected>5 Stars - Outstanding, loved it!</option>
                              <option value="4">4 Stars - Great experience</option>
                              <option value="3">3 Stars - Average</option>
                              <option value="2">2 Stars - Needs improvement</option>
                              <option value="1">1 Star - Disappointed</option>
                           </select>
                        </div>
                        <div class="col-12">
                           <label class="flbl">Your Review &amp; Comments *</label>
                           <textarea name="message" class="fctrl" rows="4" placeholder="Tell us about the dishes you tried, the taste, and our service..." required>{{ old('message') }}</textarea>
                        </div>
                        <div class="col-12 text-center">
                           <button type="submit" class="btn-red px-5"><i class="fas fa-star me-1"></i>Submit Review</button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection
