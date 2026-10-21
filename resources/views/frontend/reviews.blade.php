@extends('frontend.layouts.app')

@section('title', 'Customer Reviews - ' . config('app.name', 'Fast Food'))

@push('styles')
<style>
   .review-submit-card {
      position: relative !important;
      display: block !important;
      background: #ffffff;
      border-radius: 24px;
      padding: 42px 48px;
      box-shadow: 0 15px 45px rgba(0, 0, 0, 0.07);
      border: 1px solid #f0f3f6;
      margin-top: 20px;
      margin-bottom: 30px;
   }
   @media (max-width: 768px) {
      .review-submit-card {
         padding: 28px 22px;
      }
   }
   .review-star-picker {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 10px 16px;
      background: #fdfaf6;
      border: 1.5px solid #f7dfc5;
      border-radius: 12px;
   }
   .review-star-picker i {
      font-size: 1.4rem;
      color: #cbd5e1;
      cursor: pointer;
      transition: all 0.2s ease;
   }
   .review-star-picker i.active {
      color: #f59e0b;
      transform: scale(1.1);
   }
</style>
@endpush

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
   <section style="padding: 75px 0 110px; background: #fafbfc;">
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
               <div class="p-4 bg-white rounded-4 shadow-sm border border-light">
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
            <div class="col-lg-9 col-xl-8">
               <div class="review-submit-card">
                  <div class="text-center mb-4">
                     <span class="slbl"><i class="fas fa-comment-alt me-1"></i>Your Voice Matters</span>
                     <h3 style="font-size:1.85rem;font-weight:800;color:#1e293b;margin-top:4px;">Leave Us a Review</h3>
                     <p class="text-muted" style="font-size:0.92rem;max-width:520px;margin:0 auto;">Share your personal experience with our dishes and team. Your feedback helps us serve you better!</p>
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
                           <select name="rating" id="reviewRatingSelect" class="fctrl" required>
                              <option value="5" selected>⭐⭐⭐⭐⭐ 5 Stars - Outstanding, loved it!</option>
                              <option value="4">⭐⭐⭐⭐ 4 Stars - Great experience</option>
                              <option value="3">⭐⭐⭐ 3 Stars - Average</option>
                              <option value="2">⭐⭐ 2 Stars - Needs improvement</option>
                              <option value="1">⭐ 1 Star - Disappointed</option>
                           </select>
                        </div>
                        <div class="col-12">
                           <label class="flbl">Your Review &amp; Comments *</label>
                           <textarea name="message" class="fctrl" rows="4" placeholder="Tell us about the dishes you tried, the taste, and our service..." required>{{ old('message') }}</textarea>
                        </div>
                        <div class="col-12 text-center pt-2">
                           <button type="submit" class="btn-red px-5 py-3 shadow" style="font-size:1rem;border-radius:12px;">
                              <i class="fas fa-paper-plane me-2"></i>Submit Review
                           </button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection
