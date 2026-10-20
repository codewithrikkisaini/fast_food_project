@extends('frontend.layouts.app')

@section('title', 'Your Order & Cart - ' . config('app.name', 'Fast Food'))

@section('content')
   <!-- PAGE BANNER -->
   <div class="page-banner">
      <div class="container">
         <h1>Your <span>Order</span> Cart</h1>
         <p>Review your selected dishes, customize portion quantities, and proceed to lightning-fast checkout.</p>
         <div class="page-breadcrumb">
            <a href="{{ route('home') }}"><i class="fas fa-home me-1"></i>Home</a>
            <span>/</span>
            <span>Cart</span>
         </div>
      </div>
   </div>

   <!-- CART DETAILS -->
   <section style="padding: 80px 0;background:#faf7f2;">
      <div class="container">
         <div class="row g-4">
            <!-- CART ITEMS LIST -->
            <div class="col-lg-8">
               <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                  <h4 class="mb-4" style="font-family:'Playfair Display',serif;font-weight:700;">Selected Items (3)</h4>
                  
                  <div class="table-responsive">
                     <table class="table align-middle">
                        <thead class="table-light">
                           <tr>
                              <th>Dish</th>
                              <th>Price</th>
                              <th>Quantity</th>
                              <th>Subtotal</th>
                              <th></th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach(array_slice($menuItems, 0, 3) as $cItem)
                              <tr>
                                 <td>
                                    <div class="d-flex align-items-center gap-3">
                                       <img src="{{ asset($cItem['image']) }}" alt="{{ $cItem['title'] }}" style="width:65px;height:60px;object-fit:cover;border-radius:10px;"/>
                                       <div>
                                          <h6 class="mb-0 fw-bold" style="font-size:0.95rem;">{{ $cItem['title'] }}</h6>
                                          <span class="badge bg-light text-muted border">{{ $cItem['category_name'] }}</span>
                                       </div>
                                    </div>
                                 </td>
                                 <td class="fw-semibold">${{ number_format($cItem['price'], 2) }}</td>
                                 <td>
                                    <div class="d-flex align-items-center gap-2">
                                       <button class="btn btn-sm btn-outline-secondary px-2 py-0">-</button>
                                       <span class="fw-bold px-2">1</span>
                                       <button class="btn btn-sm btn-outline-secondary px-2 py-0">+</button>
                                    </div>
                                 </td>
                                 <td class="fw-bold text-danger">${{ number_format($cItem['price'], 2) }}</td>
                                 <td>
                                    <button class="btn btn-sm text-danger" title="Remove"><i class="fas fa-trash-alt"></i></button>
                                 </td>
                              </tr>
                           @endforeach
                        </tbody>
                     </table>
                  </div>

                  <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top flex-wrap gap-2">
                     <a href="{{ route('menu') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Add More Items</a>
                     <div class="d-flex gap-2">
                        <input type="text" class="form-control form-control-sm" placeholder="Promo code: FAST30" style="max-width:180px;"/>
                        <button class="btn btn-sm btn-dark">Apply</button>
                     </div>
                  </div>
               </div>
            </div>

            <!-- ORDER SUMMARY -->
            <div class="col-lg-4">
               <div class="bg-white p-4 rounded-4 shadow-sm border">
                  <h5 class="mb-3" style="font-family:'Playfair Display',serif;font-weight:700;">Order Summary</h5>
                  
                  <div class="d-flex justify-content-between mb-2">
                     <span class="text-muted">Subtotal</span>
                     <span class="fw-semibold">$47.97</span>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                     <span class="text-muted">Estimated Tax (8%)</span>
                     <span class="fw-semibold">$3.84</span>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                     <span class="text-muted">Delivery Fee</span>
                     <span class="text-success fw-semibold">FREE</span>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                     <span class="text-muted">Promo Discount</span>
                     <span class="text-danger fw-semibold">-$5.00</span>
                  </div>
                  <hr/>
                  <div class="d-flex justify-content-between align-items-center mb-4">
                     <span class="h5 mb-0 fw-bold">Total Amount</span>
                     <span class="h4 mb-0 fw-bold text-danger">$46.81</span>
                  </div>

                  <button class="btn-red w-100 justify-content-center py-3 mb-3" onclick="alert('Thank you! Online ordering checkout simulated successfully.')">
                     <i class="fas fa-credit-card me-2"></i>Proceed to Checkout
                  </button>

                  <div class="p-3 rounded-3" style="background:#f8fafc;border:1px dashed #cbd5e1;font-size:0.8rem;color:#64748b;">
                     <div class="d-flex align-items-center gap-2 mb-1">
                        <i class="fas fa-shield-alt text-success"></i>
                        <strong class="text-dark">Safe &amp; Secure Checkout</strong>
                     </div>
                     <span>256-bit SSL encrypted. 100% satisfaction guarantee or instant refund.</span>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection
