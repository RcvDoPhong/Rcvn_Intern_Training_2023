 <div class=" col-lg-6 col-md-12">
     <div class="d-flex justify-content-start">
         <h4 class="text-left mb-4">
             Shipping methods
         </h4>

     </div>
     <div class="row gy-4 gx-4" id="shipping-methods" style="overflow-y: auto; height: 300px">
         @forelse ($methods  as $method)
             <div class="col-lg-4 col-md-6 col-12 ">
                 @component('frontend::components.shipping-card', [
                     'method' => $method,
                     'choose' => $currentMethod->shipping_method_id,
                     'type' => 'cart',
                 ])
                 @endcomponent
             </div>
         @empty
             <h5 class="text-center">

                 There is no shipping method display
             </h5>
         @endforelse


         @guest
             <div class="text-center text-info">
                 Please login to see correct shipping methods
             </div>
         @endguest
         @auth
             @if (!Auth::user()->delivery_city_id)
                 <div class="text-center text-info">
                     Please provide us your delivery city to have a correct shipping methods
                 </div>
             @else
                 <div class="text-center text-info">
                     Shipping to {{ $user['deliveryCity']['name'] }}
                 </div>
             @endif
         @endauth






     </div>
     <div id="cart-method-notice" class="text-center text-info mt-3">

     </div>
 </div>
