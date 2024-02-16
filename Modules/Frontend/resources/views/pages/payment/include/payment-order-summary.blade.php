 @php
     $carts = $getCart['carts'];
     $sumPrice = $getCart['sumPrice'];

 @endphp

 <div class="col-lg-4 col-md-6">
     <div class="step last">
         <h3>3. Order Summary</h3>
         <div class="box_general summary">
             <h6 class="mb-2">

                 <a href="{{ route('frontend.cart.index') }}">

                     Go to Cart
                 </a>
             </h6>
             <ul style="overflow: auto; height: 220px">
                 @if (!Session::has('cart') || count(Session::get('cart')) == 0)
                     <h5 class="text-center"> Nothing in cart 😁
                     </h5>
                 @else
                     @foreach ($carts as $cart)
                         <li>
                             <a class="d-flex align-items-center text-secondary  " href="{{ $cart['product_link'] }}">

                                 <img src="{{ asset('/storage/' . $cart['product_thumbnail']) }}"
                                     alt="{{ $cart['product_name'] }}" width="50" height="50" class="lazy">

                                 <div class="d-flex flex-column  ms-3">
                                     <div>
                                         {{ $cart['product_name'] }}
                                     </div>
                                     <div class="d-flex align-items-center mt-1 " style="gap: 0.8rem">
                                         <div>

                                             ${{ number_format($cart['total_price'], 0, ',', '.') }}

                                         </div>
                                         <div>
                                             Qty:{{ $cart['product_quantity'] }}
                                         </div>
                                     </div>

                                 </div>



                             </a>

                         </li>
                     @endforeach
                 @endif


             </ul>


             <div id="order-section">
                 <ul>
                     <li class="clearfix"><em><strong>Subtotal</strong></em> <span
                             data-value="{{ $getCart['sumPrice'] }}" id="subtotal_price">
                             ${{ number_format($getCart['sumPrice'], 0, ',', '.') }}
                         </span>
                     </li>
                     <li class="clearfix"><em><strong>Shipping</strong></em>
                         <span data-value="{{ $currentMethod->shipping_sale_price }}" id="shipping_price">
                             ${{ number_format($currentMethod->shipping_sale_price, 0, ',', '.') }}
                         </span>
                     </li>
                     <li class="clearfix"><em><strong>Apply Coupon</strong></em>
                         <span data-value="0" id="coupon_price">$0</span>
                     </li>

                 </ul>
                 <div class="total clearfix">TOTAL
                     <span data-value="{{ $getCart['sumPrice'] + $currentMethod->shipping_sale_price }}"
                         id="total_price">
                         ${{ number_format($getCart['sumPrice'] + $currentMethod->shipping_sale_price, 0, ',', '.') }}
                     </span>
                 </div>
             </div>


             @if (empty($deliveryAddress) || empty($user['delivery_phone_number']))
                 <a href="{{ route('frontend.user.index') }}" class="btn_1 full-width">Please add address for
                     payment</a>
             @elseif (count($carts) === 0)
                 <a href="{{ route('frontend.category.index') }}" class="btn_1 full-width">Please some product to
                     cart</a>
             @else
                 <div id="payment-add-order" class="btn_1 full-width">
                     Confirm and Pay</div>
             @endif
         </div>
         <!-- /box_general -->
     </div>
     <!-- /step -->
 </div>
