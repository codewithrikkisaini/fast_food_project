<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <meta name="author" content="{{ config('app.name', 'Fast Food') }}">
      <meta name="description" content="Fast Food - Fresh, Delicious Burgers, Pizza, Crispy Chicken & More">
      <title>@yield('title', config('app.name', 'Fast Food') . ' - Premium Fast Food & Restaurant')</title>
      
      <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Poppins:wght@300;400;500;600;700&family=Dancing+Script:wght@700&display=swap" rel="stylesheet"/>
      
      <!-- Bootstrap 5.3 -->
      <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet"/>
      <!-- AOS Animate on Scroll -->
      <link href="{{ asset('css/aos.css') }}" rel="stylesheet"/>
      <!-- Swiper -->
      <link href="{{ asset('css/swiper-bundle.min.css') }}" rel="stylesheet"/>
      <!-- all min css (FontAwesome) -->
      <link rel="stylesheet" href="{{ asset('css/all.min.css') }}"/>
      <!-- magnific CSS -->
      <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}"/>
      <!-- Style CSS -->
      <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
      @stack('styles')
      <style>
         .admin-quick-badge {
            background: linear-gradient(135deg, #1e293b, #0f172a);
            color: #f6a623 !important;
            border: 1px solid rgba(246, 166, 35, 0.4);
            border-radius: 20px;
            padding: 4px 12px;
            font-size: 0.78rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.25s ease;
         }
         .admin-quick-badge:hover {
            background: #e8281a;
            color: #fff !important;
            border-color: #e8281a;
            transform: translateY(-1px);
         }
         .page-banner {
            background: linear-gradient(135deg, #111827 0%, #1f2937 100%);
            padding: 90px 0 70px;
            position: relative;
            text-align: center;
            color: #fff;
         }
         .page-banner::after {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 50% 50%, rgba(232, 40, 26, 0.15), transparent 70%);
         }
         .page-banner h1 {
            color: #fff;
            font-size: 2.8rem;
            font-weight: 800;
            margin-bottom: 12px;
            position: relative;
            z-index: 2;
         }
         .page-banner h1 span {
            color: var(--secondary);
         }
         .page-banner p {
            color: rgba(255, 255, 255, 0.75);
            max-width: 600px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
         }
         .page-breadcrumb {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.6);
            margin-top: 15px;
            position: relative;
            z-index: 2;
         }
         .page-breadcrumb a {
            color: var(--secondary);
         }
      </style>
   </head>
   <body>
      <!-- ============================================================
         TOP BAR
         ============================================================ -->
      <div id="topbar">
         <div class="container">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
               <div class="top-contact d-flex flex-wrap">
                  <span><i class="fas fa-phone-alt"></i>+1 (800) 123-4567</span>
                  <span><i class="fas fa-envelope"></i>hello@fastfood.com</span>
                  <span><i class="fas fa-map-marker-alt"></i>42 Flavor Street, NY</span>
               </div>
               <div class="d-flex align-items-center gap-3">
                  <span class="ttag"><i class="fas fa-fire me-1"></i>Free Delivery on Orders $25+</span>
                  <a href="{{ route('admin.dashboard') }}" class="admin-quick-badge">
                     <i class="fas fa-shield-alt"></i> Foodie Admin
                  </a>
                  <div class="tsoc d-none d-sm-flex">
                     <a href="#"><i class="fab fa-facebook-f"></i></a>
                     <a href="#"><i class="fab fa-instagram"></i></a>
                     <a href="#"><i class="fab fa-tiktok"></i></a>
                     <a href="#"><i class="fab fa-youtube"></i></a>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <!-- ============================================================
         NAVBAR
         ============================================================ -->
      <nav class="navbar navbar-expand-lg" id="nav">
         <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
               <div class="blogo">
                  <div class="bico"><i class="fas fa-utensils"></i></div>
                  <div>
                     <div class="bname">Fast<span>Food</span></div>
                     <div class="bsub">Delicious &amp; Quality Bites</div>
                  </div>
               </div>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
               <i class="fas fa-bars" style="color:var(--primary);font-size:1.35rem;"></i>
            </button>
            <div class="collapse navbar-collapse" id="navmenu">
               <ul class="navbar-nav mx-auto">
                  <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a></li>
                  <li class="nav-item"><a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a></li>
                  <li class="nav-item"><a class="nav-link {{ request()->routeIs('menu') ? 'active' : '' }}" href="{{ route('menu') }}">Menu</a></li>
                  <li class="nav-item"><a class="nav-link {{ request()->routeIs('chefs') ? 'active' : '' }}" href="{{ route('chefs') }}">Chefs</a></li>
                  <li class="nav-item"><a class="nav-link {{ request()->routeIs('gallery') ? 'active' : '' }}" href="{{ route('gallery') }}">Gallery</a></li>
                  <li class="nav-item"><a class="nav-link {{ request()->routeIs('reservation') ? 'active' : '' }}" href="{{ route('reservation') }}">Reservation</a></li>
                  <li class="nav-item"><a class="nav-link {{ request()->routeIs('reviews') ? 'active' : '' }}" href="{{ route('reviews') }}">Reviews</a></li>
                  <li class="nav-item"><a class="nav-link {{ request()->routeIs('blog*') ? 'active' : '' }}" href="{{ route('blog') }}">Blog</a></li>
                  <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a></li>
               </ul>
               <div class="d-flex align-items-center gap-2">
                  <button id="navSearchBtn" title="Search"><i class="fas fa-search"></i></button>
                  <a href="{{ route('cart') }}" class="nav-link nav-cta position-relative" title="Cart">
                     <i class="fas fa-shopping-bag me-1"></i>Cart
                     <span id="cartCount" class="badge rounded-pill bg-warning text-dark ms-1" style="font-size:0.75rem;">3</span>
                  </a>
               </div>
            </div>
         </div>
      </nav>

      <!-- FLASH NOTIFICATIONS -->
      @if(session('success'))
         <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center shadow-sm" role="alert" style="border-radius:12px;border-left:5px solid #10b981;">
               <i class="fas fa-check-circle fa-lg me-3 text-success"></i>
               <div>
                  <strong>Success!</strong> {{ session('success') }}
               </div>
               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
         </div>
      @endif

      @if($errors->any())
         <div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert" style="border-radius:12px;border-left:5px solid #ef4444;">
               <div class="d-flex align-items-center mb-1">
                  <i class="fas fa-exclamation-triangle fa-lg me-2 text-danger"></i>
                  <strong>Please correct the following errors:</strong>
               </div>
               <ul class="mb-0 ps-4">
                  @foreach($errors->all() as $error)
                     <li>{{ $error }}</li>
                  @endforeach
               </ul>
               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
         </div>
      @endif

      <!-- ============================================================
         SEARCH OVERLAY POPUP
         ============================================================ -->
      <div id="searchOv">
         <button class="sovclose" id="searchClose"><i class="fas fa-times"></i></button>
         <div class="sovbox">
            <h4>What are you craving today?</h4>
            <div class="sovinput">
               <input type="text" id="searchInput" placeholder="Search burgers, pizza, chicken..." autocomplete="off"/>
               <button><i class="fas fa-search"></i></button>
            </div>
            <!-- Categories inside search box -->
            <div class="sovcats">
               <div class="sovcat active" data-cat="all">
                  <img src="{{ asset('img/menu/1.jpg') }}" alt=""/>All Items
               </div>
               <div class="sovcat" data-cat="burgers">
                  <img src="{{ asset('img/menu/1.jpg') }}" alt=""/>Burgers
               </div>
               <div class="sovcat" data-cat="pizza">
                  <img src="{{ asset('img/menu/2.jpg') }}" alt=""/>Pizza
               </div>
               <div class="sovcat" data-cat="chicken">
                  <img src="{{ asset('img/menu/3.jpg') }}" alt=""/>Chicken
               </div>
               <div class="sovcat" data-cat="wraps">
                  <img src="{{ asset('img/menu/4.jpg') }}" alt=""/>Wraps
               </div>
               <div class="sovcat" data-cat="pasta">
                  <img src="{{ asset('img/menu/5.jpg') }}" alt=""/>Pasta
               </div>
               <div class="sovcat" data-cat="desserts">
                  <img src="{{ asset('img/menu/6.jpg') }}" alt=""/>Desserts
               </div>
            </div>
            <div class="sovtrend">
               <p><i class="fas fa-fire me-1" style="color:var(--secondary);"></i>Trending Searches</p>
               <span class="ttag">Smash Burger</span>
               <span class="ttag">Nashville Chicken</span>
               <span class="ttag">Truffle Pizza</span>
               <span class="ttag">Lava Cake</span>
               <span class="ttag">Loaded Fries</span>
            </div>
         </div>
      </div>

      <!-- MAIN CONTENT -->
      <main>
         @yield('content')
      </main>

      <!-- MENU DETAIL POPUP MODAL -->
      <div id="menuPop">
         <div class="mpbox">
            <button class="mpclose" id="mpClose"><i class="fas fa-times"></i></button>
            <div class="mpimg"><img id="mpImg" src="{{ asset('img/menu/1.jpg') }}" alt=""/></div>
            <div class="mpbody">
               <div id="mpCat">Burgers</div>
               <div id="mpTitle">Classic Smash Burger</div>
               <div id="mpStars"></div>
               <div id="mpDesc"></div>
               <div id="mpPrice"></div>
               <div class="mpmeta" id="mpMeta"></div>
               <div class="mpqty">
                  <button class="mpqbtn" id="mpMinus">-</button>
                  <span class="mpqnum" id="mpQnum">1</span>
                  <button class="mpqbtn" id="mpPlus">+</button>
                  <span style="font-size:.82rem;color:#aaa;margin-left:9px;">portion</span>
               </div>
               <div class="mptags" id="mpTags"></div>
               <button class="mpaddcart" id="mpAddCart"><i class="fas fa-shopping-cart"></i>Add to Cart</button>
            </div>
         </div>
      </div>

      <!-- GALLERY POPUP -->
      <div id="galPop">
         <div class="gpbox">
            <button class="gpclose" id="gpClose"><i class="fas fa-times"></i></button>
            <img id="gpImg" src="{{ asset('img/portfolio/work1.jpg') }}" alt=""/>
            <div class="gpcap">
               <h5 id="gpTitle">Gourmet Burgers</h5>
               <p id="gpDesc"></p>
            </div>
            <div class="gpnav">
               <button id="gpPrev"><i class="fas fa-chevron-left me-1"></i>Prev</button>
               <button id="gpNext">Next <i class="fas fa-chevron-right ms-1"></i></button>
            </div>
         </div>
      </div>

      <!-- FOOTER -->
      <footer>
         <div class="container">
            <div class="row g-5">
               <div class="col-lg-4">
                  <div class="fnm">Fast<span>Food</span></div>
                  <p class="fdesc">We bring the world's finest flavors together in a fast, friendly, and affordable experience. Every meal crafted with love.</p>
                  <div class="fsoc">
                     <a href="#"><i class="fab fa-facebook-f"></i></a>
                     <a href="#"><i class="fab fa-instagram"></i></a>
                     <a href="#"><i class="fab fa-twitter"></i></a>
                     <a href="#"><i class="fab fa-youtube"></i></a>
                     <a href="#"><i class="fab fa-tiktok"></i></a>
                  </div>
               </div>
               <div class="col-sm-6 col-lg-2">
                  <div class="ftit">Quick Links</div>
                  <ul class="flinks ps-0">
                     <li><a href="{{ route('home') }}"><i class="fas fa-chevron-right"></i>Home</a></li>
                     <li><a href="{{ route('about') }}"><i class="fas fa-chevron-right"></i>About Us</a></li>
                     <li><a href="{{ route('menu') }}"><i class="fas fa-chevron-right"></i>Our Menu</a></li>
                     <li><a href="{{ route('chefs') }}"><i class="fas fa-chevron-right"></i>Chefs</a></li>
                     <li><a href="{{ route('reservation') }}"><i class="fas fa-chevron-right"></i>Reservation</a></li>
                     <li><a href="{{ route('blog') }}"><i class="fas fa-chevron-right"></i>Blog</a></li>
                     <li><a href="{{ route('contact') }}"><i class="fas fa-chevron-right"></i>Contact</a></li>
                  </ul>
               </div>
               <div class="col-sm-6 col-lg-2">
                  <div class="ftit">Our Menu</div>
                  <ul class="flinks ps-0">
                     <li><a href="{{ route('menu') }}"><i class="fas fa-chevron-right"></i>Burgers</a></li>
                     <li><a href="{{ route('menu') }}"><i class="fas fa-chevron-right"></i>Pizza</a></li>
                     <li><a href="{{ route('menu') }}"><i class="fas fa-chevron-right"></i>Fried Chicken</a></li>
                     <li><a href="{{ route('menu') }}"><i class="fas fa-chevron-right"></i>Wraps &amp; Rolls</a></li>
                     <li><a href="{{ route('menu') }}"><i class="fas fa-chevron-right"></i>Pasta</a></li>
                     <li><a href="{{ route('menu') }}"><i class="fas fa-chevron-right"></i>Desserts</a></li>
                  </ul>
               </div>
               <div class="col-lg-4">
                  <div class="ftit">Get In Touch</div>
                  <div class="fci">
                     <div class="fciico"><i class="fas fa-map-marker-alt"></i></div>
                     <div class="fciinfo"><strong>Address</strong>42 Flavor Street, Manhattan, NY 10001</div>
                  </div>
                  <div class="fci">
                     <div class="fciico"><i class="fas fa-phone-alt"></i></div>
                     <div class="fciinfo"><strong>Phone</strong>+1 (800) 123-4567</div>
                  </div>
                  <div class="fci">
                     <div class="fciico"><i class="fas fa-envelope"></i></div>
                     <div class="fciinfo"><strong>Email</strong>hello@fastfood.com</div>
                  </div>
                  <div class="fci">
                     <div class="fciico"><i class="fas fa-clock"></i></div>
                     <div class="fciinfo"><strong>Hours</strong>Wed - Sun: 09 AM - 11 PM</div>
                  </div>
               </div>
            </div>
         </div>
         <div class="fbot">
            <div class="container">
               <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                  <p>&copy; {{ date('Y') }} <span>Fast Food</span>. All Rights Reserved.</p>
                  <div>
                     <a href="{{ route('admin.dashboard') }}" class="text-warning me-3"><i class="fas fa-cog me-1"></i>Foodie Admin Portal</a>
                     <a href="#">Privacy Policy</a>
                     <a href="#">Terms</a>
                  </div>
               </div>
            </div>
         </div>
      </footer>

      <!-- Back to top -->
      <button id="btt" onclick="window.scrollTo({top:0,behavior:'smooth'})"><i class="fas fa-chevron-up"></i></button>
    
      <!-- jQuery -->
      <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
      <!-- Bootstrap 5 -->
      <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
      <!-- AOS -->
      <script src="{{ asset('js/aos.js') }}"></script>
      <!-- Swiper -->
      <script src="{{ asset('js/swiper-bundle.min.js') }}"></script>
      <!-- Magnific Popup -->
      <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
      <!-- Main js -->
      <script src="{{ asset('js/main.js') }}"></script>
      @stack('scripts')
   </body>
</html>
