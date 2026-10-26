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
         <!-- STATS ROW (CONTROLLED FROM BACKEND / ADMIN) -->
         <div class="row g-4 mb-5 align-items-center">
            <div class="col-lg-4 text-center p-4 rounded-4" style="background:#fff8f0;border:1px solid #fef0dc;">
               <div style="font-size:3.5rem;font-weight:900;color:var(--primary);line-height:1;">
                  {{ $reviewSettings['overall_rating'] ?? '4.9' }}
               </div>
               <div class="text-warning my-2" style="font-size:1.3rem;">
                  @php
                     $stars = (int) round((float) ($reviewSettings['overall_rating'] ?? 5));
                  @endphp
                  @for($i = 0; $i < $stars; $i++)
                     <i class="fas fa-star"></i>
                  @endfor
               </div>
               <h6 class="mb-0 text-muted">
                  {{ $reviewSettings['rating_subtitle'] ?? 'Overall Diner Rating (850+ Reviews)' }}</h6>
            </div>
            <div class="col-lg-8">
               <div class="p-4 bg-white rounded-4 shadow-sm border border-light">
                  <div class="d-flex align-items-center justify-content-between mb-2">
                     <span class="fw-semibold">{{ $reviewSettings['metric1_label'] ?? 'Food Quality & Freshness' }}</span>
                     <span class="text-muted">{{ $reviewSettings['metric1_percent'] ?? 98 }}% Satisfied</span>
                  </div>
                  <div class="progress mb-3" style="height:8px;">
                     <div class="progress-bar bg-danger" style="width: {{ $reviewSettings['metric1_percent'] ?? 98 }}%">
                     </div>
                  </div>
                  <div class="d-flex align-items-center justify-content-between mb-2">
                     <span
                        class="fw-semibold">{{ $reviewSettings['metric2_label'] ?? 'Delivery Speed (< 25 mins)' }}</span>
                     <span class="text-muted">{{ $reviewSettings['metric2_percent'] ?? 95 }}% Satisfied</span>
                  </div>
                  <div class="progress mb-3" style="height:8px;">
                     <div class="progress-bar bg-warning" style="width: {{ $reviewSettings['metric2_percent'] ?? 95 }}%">
                     </div>
                  </div>
                  <div class="d-flex align-items-center justify-content-between mb-2">
                     <span class="fw-semibold">{{ $reviewSettings['metric3_label'] ?? 'Friendly Customer Care' }}</span>
                     <span class="text-muted">{{ $reviewSettings['metric3_percent'] ?? 99 }}% Satisfied</span>
                  </div>
                  <div class="progress" style="height:8px;">
                     <div class="progress-bar bg-success" style="width: {{ $reviewSettings['metric3_percent'] ?? 99 }}%">
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <!-- REVIEWS GRID -->
         <div class="row g-4 mb-5">
            @forelse($reviews as $review)
               @if(($review['status'] ?? 'Approved') === 'Approved')
                  <div class="col-md-6 col-lg-6">
                     <div class="tescard h-100 bg-white shadow-sm p-4 rounded-4 border">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                           <div class="tess">
                              @for($i = 0; $i < ($review['rating'] ?? 5); $i++)
                                 <i class="fas fa-star text-warning"></i>
                              @endfor
                           </div>
                           <span class="badge bg-light text-muted border" style="font-size:0.75rem;"><i
                                 class="fas fa-check-circle text-success me-1"></i>Verified Diner</span>
                        </div>
                        <p class="testxt mb-4" style="font-size:0.95rem;line-height:1.6;color:#555;">
                           {{ $review['text'] ?? ($review['message'] ?? '') }}</p>
                        <div class="tesauth">
                           <img src="{{ asset($review['image'] ?? 'img/testimonial/1.jpg') }}" alt="{{ $review['name'] }}"
                              onerror="this.src='{{ asset('img/testimonial/1.jpg') }}'" />
                           <div>
                              <div class="tesnm">{{ $review['name'] }}</div>
                              <div class="tesrl">{{ $review['role'] ?? 'Diner' }}</div>
                           </div>
                        </div>
                     </div>
                  </div>
               @endif
            @empty
               <div class="col-12 text-center py-4 text-muted">No customer reviews published yet. Be the first to share your
                  experience!</div>
            @endforelse
         </div>

         <!-- SUBMIT A REVIEW FORM -->
         <div class="row justify-content-center mt-5" id="submit-review">
            <div class="col-lg-8">
               <div class="review-submit-card">
                  <div class="text-center mb-4">
                     <span class="badge bg-warning text-dark px-3 py-2 fw-semibold mb-2">Share Your Experience</span>
                     <h3 class="fw-bold" style="font-family:'Playfair Display',serif;">Leave a Customer Review</h3>
                     <p class="text-muted small">Your feedback helps us continuously elevate our food quality and diner hospitality.</p>
                  </div>

                  @if(session('success'))
                     <div class="alert alert-success alert-dismissible fade show border-0 bg-success bg-opacity-25 text-success mb-4" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                     </div>
                  @endif

                  @if($errors->any())
                     <div class="alert alert-danger alert-dismissible fade show border-0 bg-danger bg-opacity-25 text-danger mb-4" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i> <strong>Please correct the following errors:</strong>
                        <ul class="mb-0 mt-2 small">
                           @foreach($errors->all() as $error)
                              <li>{{ $error }}</li>
                           @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                     </div>
                  @endif

                  <form action="{{ route('reviews.store') }}" method="POST">
                     @csrf
                     <div class="row g-3">
                        <div class="col-sm-6">
                           <label class="form-label small fw-bold text-muted">Your Name *</label>
                           <input type="text" name="name" class="form-control" placeholder="e.g. Sarah Jenkins" value="{{ old('name') }}" required>
                        </div>
                        <div class="col-sm-6">
                           <label class="form-label small fw-bold text-muted">Customer Title / Role</label>
                           <input type="text" name="role" class="form-control" placeholder="e.g. Verified Diner, Foodie" value="{{ old('role', 'Verified Diner') }}">
                        </div>
                        <div class="col-12">
                           <label class="form-label small fw-bold text-muted">Your Rating *</label>
                           <div class="review-star-picker" id="starPicker">
                              <input type="hidden" name="rating" id="ratingInput" value="{{ old('rating', 5) }}">
                              <span class="small fw-semibold text-muted me-2">Select Stars:</span>
                              <i class="fas fa-star active" data-rating="1"></i>
                              <i class="fas fa-star active" data-rating="2"></i>
                              <i class="fas fa-star active" data-rating="3"></i>
                              <i class="fas fa-star active" data-rating="4"></i>
                              <i class="fas fa-star active" data-rating="5"></i>
                              <span class="ms-2 fw-bold text-warning" id="ratingLabel">5 / 5 - Exceptional</span>
                           </div>
                        </div>
                        <div class="col-12">
                           <label class="form-label small fw-bold text-muted">Your Review &amp; Experience *</label>
                           <textarea name="message" class="form-control" rows="4" placeholder="Tell us what you loved about our dishes, taste, speed, or service..." required>{{ old('message') }}</textarea>
                        </div>
                        <div class="col-12 text-center mt-3">
                           <button type="submit" class="btn-red px-5 py-3">
                              <i class="fas fa-paper-plane me-2"></i>Submit Customer Review
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

@push('scripts')
<script>
   document.addEventListener('DOMContentLoaded', function () {
      const starPicker = document.getElementById('starPicker');
      if (!starPicker) return;
      const stars = starPicker.querySelectorAll('i[data-rating]');
      const ratingInput = document.getElementById('ratingInput');
      const ratingLabel = document.getElementById('ratingLabel');

      const labels = {
         1: '1 / 5 - Poor',
         2: '2 / 5 - Fair',
         3: '3 / 5 - Good',
         4: '4 / 5 - Very Good',
         5: '5 / 5 - Exceptional'
      };

      stars.forEach(star => {
         star.addEventListener('click', function () {
            const val = parseInt(this.getAttribute('data-rating'));
            ratingInput.value = val;
            ratingLabel.textContent = labels[val] || (val + ' / 5');

            stars.forEach(s => {
               const sVal = parseInt(s.getAttribute('data-rating'));
               if (sVal <= val) {
                  s.classList.add('active');
               } else {
                  s.classList.remove('active');
               }
            });
         });
      });
   });
</script>
@endpush