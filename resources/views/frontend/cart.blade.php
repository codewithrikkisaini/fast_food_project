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
   <section style="padding: 80px 0;background:#faf7f2;min-height:600px;">
      <div class="container" id="cartContainer">
         <!-- Will be rendered dynamically via JavaScript -->
      </div>
   </section>

   <!-- CHECKOUT MODAL -->
   <div class="modal fade" id="checkoutModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header text-white p-4" style="background:linear-gradient(135deg, #e8281a, #ff6b35);">
               <h5 class="modal-title fw-bold" style="font-family:'Playfair Display',serif;">
                  <i class="fas fa-motorcycle me-2"></i>Express Delivery Checkout
               </h5>
               <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
               <form id="checkoutForm" onsubmit="handlePlaceOrder(event)">
                  <div class="mb-3">
                     <label class="form-label small fw-bold text-muted">Your Full Name *</label>
                     <input type="text" id="custName" class="form-control" placeholder="John Doe" required>
                  </div>
                  <div class="row g-3 mb-3">
                     <div class="col-sm-6">
                        <label class="form-label small fw-bold text-muted">Phone Number *</label>
                        <input type="tel" id="custPhone" class="form-control" placeholder="+1 (800) 000-0000" required>
                     </div>
                     <div class="col-sm-6">
                        <label class="form-label small fw-bold text-muted">Payment Method</label>
                        <select class="form-select" id="custPayment">
                           <option value="Cash on Delivery">Cash on Delivery</option>
                           <option value="Credit / Debit Card">Credit / Debit Card</option>
                           <option value="Apple Pay / Google Pay">Apple Pay / Google Pay</option>
                        </select>
                     </div>
                  </div>
                  <div class="mb-3">
                     <label class="form-label small fw-bold text-muted">Delivery Address *</label>
                     <textarea id="custAddress" class="form-control" rows="3" placeholder="Enter delivery street address, apt/suite, city" required></textarea>
                  </div>
                  <div class="p-3 rounded-3 mb-3" style="background:#f1f5f9;border:1px dashed #cbd5e1;">
                     <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Total Payable:</span>
                        <strong class="text-danger h5 mb-0" id="modalTotalPayable">$0.00</strong>
                     </div>
                  </div>
                  <button type="submit" class="btn-red w-100 justify-content-center py-3 fw-bold">
                     <i class="fas fa-check-circle me-2"></i>Confirm &amp; Place Order
                  </button>
               </form>
            </div>
         </div>
      </div>
   </div>
@endsection

@push('scripts')
<script>
   let promoDiscount = 0;
   let appliedPromoCode = '';

   function renderCartPage() {
      const container = document.getElementById('cartContainer');
      if (!container) return;

      const cart = window.getCart ? window.getCart() : [];

      if (!cart || cart.length === 0) {
         container.innerHTML = `
            <div class="text-center py-5 bg-white rounded-4 shadow-sm border p-5">
               <div style="width:90px;height:90px;border-radius:50%;background:rgba(232,40,26,0.1);display:inline-flex;align-items:center;justify-content:center;color:#e8281a;font-size:2.4rem;margin-bottom:20px;">
                  <i class="fas fa-shopping-bag"></i>
               </div>
               <h3 class="fw-bold mb-2" style="font-family:'Playfair Display',serif;">Your Cart is Empty</h3>
               <p class="text-muted mx-auto mb-4" style="max-width:440px;">
                  You haven't added any mouth-watering dishes to your cart yet. Explore our delicious burgers, artisan pizzas, and crispy chicken!
               </p>
               <a href="{{ route('menu') }}" class="btn-red px-4 py-3 d-inline-flex align-items-center gap-2">
                  <i class="fas fa-utensils"></i> Explore Menu &amp; Order
               </a>
            </div>
         `;
         return;
      }

      let subtotal = 0;
      let totalItemsCount = 0;

      let itemsHtml = cart.map((item, index) => {
         const price = parseFloat(item.price) || 0;
         const qty = parseInt(item.qty) || 1;
         const itemTotal = price * qty;
         subtotal += itemTotal;
         totalItemsCount += qty;

         // Resolve image path correctly
         let imgSrc = item.img || 'img/menu/1.jpg';
         if (!imgSrc.startsWith('http') && !imgSrc.startsWith('/')) {
            imgSrc = '{{ asset("") }}' + imgSrc;
         }

         return `
            <tr>
               <td>
                  <div class="d-flex align-items-center gap-3">
                     <img src="${imgSrc}" alt="${item.title}" style="width:65px;height:60px;object-fit:cover;border-radius:10px;"/>
                     <div>
                        <h6 class="mb-0 fw-bold" style="font-size:0.95rem;">${item.title}</h6>
                        <span class="badge bg-light text-muted border">${item.cat || 'Special'}</span>
                     </div>
                  </div>
               </td>
               <td class="fw-semibold">$${price.toFixed(2)}</td>
               <td>
                  <div class="d-flex align-items-center gap-2">
                     <button class="btn btn-sm btn-outline-secondary px-2 py-0" onclick="changeCartQty(${index}, -1)" title="Decrease">-</button>
                     <span class="fw-bold px-2">${qty}</span>
                     <button class="btn btn-sm btn-outline-secondary px-2 py-0" onclick="changeCartQty(${index}, 1)" title="Increase">+</button>
                  </div>
               </td>
               <td class="fw-bold text-danger">$${itemTotal.toFixed(2)}</td>
               <td>
                  <button class="btn btn-sm text-danger border-0 bg-transparent" onclick="removeCartItem(${index})" title="Remove item">
                     <i class="fas fa-trash-alt"></i>
                  </button>
               </td>
            </tr>
         `;
      }).join('');

      const tax = subtotal * 0.08;
      const deliveryFee = subtotal >= 25 ? 0 : 3.99;
      const discount = promoDiscount > 0 ? (promoDiscount > subtotal ? subtotal : promoDiscount) : 0;
      const grandTotal = Math.max(0, (subtotal + tax + deliveryFee) - discount);

      container.innerHTML = `
         <div class="row g-4">
            <!-- CART ITEMS LIST -->
            <div class="col-lg-8">
               <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                  <div class="d-flex justify-content-between align-items-center mb-4">
                     <h4 class="mb-0" style="font-family:'Playfair Display',serif;font-weight:700;">
                        Selected Dishes (<span id="cartCountHeader">${totalItemsCount}</span>)
                     </h4>
                     <button class="btn btn-outline-danger btn-sm" onclick="clearFullCart()">
                        <i class="fas fa-trash me-1"></i> Clear Cart
                     </button>
                  </div>
                  
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
                           ${itemsHtml}
                        </tbody>
                     </table>
                  </div>

                  <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top flex-wrap gap-2">
                     <a href="{{ route('menu') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Add More Items
                     </a>
                     <div class="d-flex gap-2">
                        <input type="text" id="promoInput" class="form-control form-control-sm" 
                           placeholder="Promo code (e.g. FAST30)" value="${appliedPromoCode}" style="max-width:180px;"/>
                        <button class="btn btn-sm btn-dark" onclick="applyPromoCode()">Apply</button>
                     </div>
                  </div>
                  ${promoDiscount > 0 ? `<div class="small text-success mt-2"><i class="fas fa-tag me-1"></i>Promo "${appliedPromoCode}" applied! ($${discount.toFixed(2)} discount)</div>` : ''}
               </div>
            </div>

            <!-- ORDER SUMMARY -->
            <div class="col-lg-4">
               <div class="bg-white p-4 rounded-4 shadow-sm border">
                  <h5 class="mb-3" style="font-family:'Playfair Display',serif;font-weight:700;">Order Summary</h5>
                  
                  <div class="d-flex justify-content-between mb-2">
                     <span class="text-muted">Subtotal</span>
                     <span class="fw-semibold">$${subtotal.toFixed(2)}</span>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                     <span class="text-muted">Estimated Tax (8%)</span>
                     <span class="fw-semibold">$${tax.toFixed(2)}</span>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                     <span class="text-muted">Delivery Fee</span>
                     <span class="${deliveryFee === 0 ? 'text-success fw-bold' : 'fw-semibold'}">
                        ${deliveryFee === 0 ? 'FREE' : '$' + deliveryFee.toFixed(2)}
                     </span>
                  </div>
                  ${discount > 0 ? `
                  <div class="d-flex justify-content-between mb-2">
                     <span class="text-muted">Promo Discount</span>
                     <span class="text-danger fw-semibold">-$${discount.toFixed(2)}</span>
                  </div>` : ''}
                  <hr/>
                  <div class="d-flex justify-content-between align-items-center mb-4">
                     <span class="h5 mb-0 fw-bold">Total Amount</span>
                     <span class="h4 mb-0 fw-bold text-danger">$${grandTotal.toFixed(2)}</span>
                  </div>

                  <button class="btn-red w-100 justify-content-center py-3 mb-3 fw-bold" onclick="openCheckoutModal(${grandTotal})">
                     <i class="fas fa-credit-card me-2"></i>Proceed to Checkout
                  </button>

                  <div class="p-3 rounded-3" style="background:#f8fafc;border:1px dashed #cbd5e1;font-size:0.8rem;color:#64748b;">
                     <div class="d-flex align-items-center gap-2 mb-1">
                        <i class="fas fa-shield-alt text-success"></i>
                        <strong class="text-dark">Safe &amp; Secure Checkout</strong>
                     </div>
                     <span>256-bit SSL encrypted. 100% satisfaction guarantee with hot delivery in 25 mins.</span>
                  </div>
               </div>
            </div>
         </div>
      `;
   }

   function changeCartQty(index, delta) {
      const cart = window.getCart();
      if (!cart[index]) return;

      cart[index].qty = (cart[index].qty || 1) + delta;
      if (cart[index].qty <= 0) {
         cart.splice(index, 1);
      }
      window.saveCart(cart);
      renderCartPage();
   }

   function removeCartItem(index) {
      const cart = window.getCart();
      cart.splice(index, 1);
      window.saveCart(cart);
      renderCartPage();
   }

   function clearFullCart() {
      if (confirm('Are you sure you want to remove all items from your cart?')) {
         window.saveCart([]);
         renderCartPage();
      }
   }

   function applyPromoCode() {
      const input = document.getElementById('promoInput');
      if (!input) return;
      const code = input.value.trim().toUpperCase();

      if (code === 'FAST30' || code === 'FASTFOOD') {
         promoDiscount = 5.00;
         appliedPromoCode = code;
         alert('Promo code applied successfully! $5.00 discount granted.');
      } else if (code === '') {
         promoDiscount = 0;
         appliedPromoCode = '';
      } else {
         alert('Invalid promo code. Try "FAST30"');
         promoDiscount = 0;
         appliedPromoCode = '';
      }
      renderCartPage();
   }

   function openCheckoutModal(total) {
      document.getElementById('modalTotalPayable').textContent = '$' + total.toFixed(2);
      const modal = new bootstrap.Modal(document.getElementById('checkoutModal'));
      modal.show();
   }

   function handlePlaceOrder(e) {
      e.preventDefault();
      const name = document.getElementById('custName').value.trim();
      const phone = document.getElementById('custPhone').value.trim();
      const address = document.getElementById('custAddress').value.trim();

      const modalEl = document.getElementById('checkoutModal');
      const modal = bootstrap.Modal.getInstance(modalEl);
      if (modal) modal.hide();

      // Clear Cart
      window.saveCart([]);

      // Confirmation notification
      alert(`🎉 Thank you, ${name}!\n\nYour order has been confirmed and our chefs are already preparing it.\n\nDelivery to: ${address}\nPhone: ${phone}\nEstimated Delivery Time: 25-30 minutes.`);

      renderCartPage();
   }

   window.addEventListener('DOMContentLoaded', function() {
      renderCartPage();
   });
</script>
@endpush
