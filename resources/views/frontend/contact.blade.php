@extends('frontend.layouts.app')

@section('title', 'Contact Us - ' . config('app.name', 'Fast Food'))

@section('content')
   <!-- PAGE BANNER -->
   <div class="page-banner">
      <div class="container">
         <h1>Contact <span>Us</span></h1>
         <p>Have questions, catering requests, or feedback? Get in touch with our team today.</p>
         <div class="page-breadcrumb">
            <a href="{{ route('home') }}"><i class="fas fa-home me-1"></i>Home</a>
            <span>/</span>
            <span>Contact</span>
         </div>
      </div>
   </div>

   <!-- CONTACT SECTION -->
   <section id="contact-section" style="padding: 80px 0 110px; background: #fafbfc;">
      <div class="container">
         <div class="row g-4">
            <div class="col-lg-4" data-aos="fade-right">
               <div class="ctdark shadow-sm">
                  <h4>Let's Talk</h4>
                  <p class="ctsub">We typically respond within 2 hours during normal business hours.</p>
                  <div class="ctitem">
                     <div class="cticon"><i class="fas fa-map-marker-alt"></i></div>
                     <div class="ctinfo"><strong>Address</strong>42 Flavor Street, Manhattan,<br/>New York, NY 10001</div>
                  </div>
                  <div class="ctitem">
                     <div class="cticon"><i class="fas fa-phone-alt"></i></div>
                     <div class="ctinfo"><strong>Phone</strong>+1 (800) 123-4567</div>
                  </div>
                  <div class="ctitem">
                     <div class="cticon"><i class="fas fa-envelope"></i></div>
                     <div class="ctinfo"><strong>Email</strong>hello@fastfood.com</div>
                  </div>
                  <div class="ctitem">
                     <div class="cticon"><i class="fas fa-clock"></i></div>
                     <div class="ctinfo"><strong>Working Hours</strong>Wed - Sun: 9 AM - 11 PM</div>
                  </div>
                  <div class="ctsocrow">
                     <a href="#"><i class="fab fa-facebook-f"></i></a>
                     <a href="#"><i class="fab fa-instagram"></i></a>
                     <a href="#"><i class="fab fa-twitter"></i></a>
                     <a href="#"><i class="fab fa-youtube"></i></a>
                  </div>
               </div>
            </div>
            <div class="col-lg-8" data-aos="fade-left">
               <div class="fcard shadow-sm p-4 p-md-5">
                  <div class="mb-4">
                     <span class="slbl">Send a Message</span>
                     <h3 style="font-size:1.6rem;font-weight:700;">We'd Love to Hear From You</h3>
                     <p class="text-muted" style="font-size:0.88rem;">Fill in the form below and our manager will contact you promptly.</p>
                  </div>

                  @if(session('success'))
                     <div class="alert alert-success alert-dismissible fade show border-0 bg-success bg-opacity-25 text-success mb-4" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                     </div>
                  @endif

                  @if($errors->any())
                     <div class="alert alert-danger alert-dismissible fade show border-0 bg-danger bg-opacity-25 text-danger mb-4" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i> <strong>Please check the following errors:</strong>
                        <ul class="mb-0 mt-2 small">
                           @foreach($errors->all() as $error)
                              <li>{{ $error }}</li>
                           @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                     </div>
                  @endif

                  <form action="{{ route('contact.store') }}" method="POST">
                     @csrf
                     <div class="row g-3">
                        <div class="col-sm-6">
                           <label class="flbl">Your Name *</label>
                           <input type="text" name="name" class="fctrl" placeholder="John Doe" required value="{{ old('name') }}"/>
                        </div>
                        <div class="col-sm-6">
                           <label class="flbl">Email Address *</label>
                           <input type="email" name="email" class="fctrl" placeholder="you@email.com" required value="{{ old('email') }}"/>
                        </div>
                        <div class="col-sm-6">
                           <label class="flbl">Phone Number</label>
                           <input type="tel" name="phone" class="fctrl" placeholder="+1 (800) 000-0000" value="{{ old('phone') }}"/>
                        </div>
                        <div class="col-sm-6">
                           <label class="flbl">Subject *</label>
                           <select name="subject" class="fctrl" required>
                              <option value="General Inquiry">General Inquiry</option>
                              <option value="Catering & Events">Catering &amp; Events</option>
                              <option value="Feedback">Feedback</option>
                              <option value="Partnership">Partnership</option>
                              <option value="Media & Press">Media &amp; Press</option>
                           </select>
                        </div>
                        <div class="col-12">
                           <label class="flbl">Message *</label>
                           <textarea name="message" class="fctrl" rows="5" placeholder="Write your message or inquiry here..." required>{{ old('message') }}</textarea>
                        </div>
                        <div class="col-12">
                           <button type="submit" class="btn-red"><i class="fas fa-paper-plane me-2"></i>Send Message</button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection
