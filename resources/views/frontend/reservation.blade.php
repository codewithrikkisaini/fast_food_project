@extends('frontend.layouts.app')

@section('title', 'Table Reservation - ' . config('app.name', 'Fast Food'))

@section('content')
   <!-- PAGE BANNER -->
   <div class="page-banner">
      <div class="container">
         <h1>Book a <span>Table</span></h1>
         <p>Experience fast-casual dining at its best. Reserve your spot for dinner, celebration, or business gatherings.</p>
         <div class="page-breadcrumb">
            <a href="{{ route('home') }}"><i class="fas fa-home me-1"></i>Home</a>
            <span>/</span>
            <span>Reservation</span>
         </div>
      </div>
   </div>

   <!-- RESERVATION SECTION -->
   <section id="reservation" style="padding: 80px 0 110px; background: #fafbfc;">
      <div class="container">
         <div class="row g-4 align-items-start">
            <div class="col-lg-4" data-aos="fade-right">
               <div style="background:var(--dark);border-radius:18px;padding:36px;">
                  <h4 style="color:#fff;font-size:1.3rem;margin-bottom:8px;">Booking Assistance</h4>
                  <p style="color:rgba(255,255,255,.55);font-size:.85rem;margin-bottom:26px;">Questions regarding party sizes or private bookings? Reach out anytime.</p>
                  <div class="d-flex flex-column gap-3">
                     <div class="d-flex align-items-center gap-3">
                        <div style="width:46px;height:46px;border-radius:11px;background:rgba(232,40,26,.2);display:flex;align-items:center;justify-content:center;color:var(--primary);font-size:1.1rem;flex-shrink:0;"><i class="fas fa-clock"></i></div>
                        <div><strong style="display:block;color:#ccc;font-size:.78rem;text-transform:uppercase;letter-spacing:.8px;">Opening Hours</strong><span style="color:#fff;font-size:.87rem;">Wed - Sun, 9 AM - 11 PM</span></div>
                     </div>
                     <div class="d-flex align-items-center gap-3">
                        <div style="width:46px;height:46px;border-radius:11px;background:rgba(232,40,26,.2);display:flex;align-items:center;justify-content:center;color:var(--primary);font-size:1.1rem;flex-shrink:0;"><i class="fas fa-phone-alt"></i></div>
                        <div><strong style="display:block;color:#ccc;font-size:.78rem;text-transform:uppercase;letter-spacing:.8px;">VIP Concierge</strong><span style="color:#fff;font-size:.87rem;">+1 (800) 123-4567</span></div>
                     </div>
                     <div class="d-flex align-items-center gap-3">
                        <div style="width:46px;height:46px;border-radius:11px;background:rgba(232,40,26,.2);display:flex;align-items:center;justify-content:center;color:var(--primary);font-size:1.1rem;flex-shrink:0;"><i class="fas fa-users"></i></div>
                        <div><strong style="display:block;color:#ccc;font-size:.78rem;text-transform:uppercase;letter-spacing:.8px;">Group Events</strong><span style="color:#fff;font-size:.87rem;">Private lounge for 15+ guests</span></div>
                     </div>
                     <div class="d-flex align-items-center gap-3">
                        <div style="width:46px;height:46px;border-radius:11px;background:rgba(232,40,26,.2);display:flex;align-items:center;justify-content:center;color:var(--primary);font-size:1.1rem;flex-shrink:0;"><i class="fas fa-map-marker-alt"></i></div>
                        <div><strong style="display:block;color:#ccc;font-size:.78rem;text-transform:uppercase;letter-spacing:.8px;">Location</strong><span style="color:#fff;font-size:.87rem;">42 Flavor Street, NY</span></div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-8" data-aos="fade-left">
               <div class="fcard shadow-sm">
                  <div class="mb-4">
                     <span class="slbl">Instant Booking</span>
                     <h3 style="font-size:1.6rem;font-weight:700;">Reserve Your Table Now</h3>
                     <p class="text-muted" style="font-size:0.88rem;">We confirm all table reservations within 15 minutes via SMS &amp; email.</p>
                  </div>
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
                           <textarea name="special_requests" class="fctrl" rows="3" placeholder="Allergies, high-chair needs, booth preference, birthdays, dietary restrictions...">{{ old('special_requests') }}</textarea>
                        </div>
                        <div class="col-12">
                           <button type="submit" class="btn-red w-100 justify-content-center">
                              <i class="fas fa-calendar-check me-2"></i>Confirm Table Reservation
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
