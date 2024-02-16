 @php
     $isChoose = $choose === $method->shipping_method_id;
 @endphp

 <div class="shipping-card {{ $isChoose ? 'choose' : '' }} rounded" data-id={{ $method->shipping_method_id }}
     onclick="shipping.select({{ $method->shipping_method_id }}, '{{ $type }}')">

     @if ($isChoose)
         <span class="shipping-ribbon  ">
             choose
         </span>
     @endif

     <div class="d-flex align-items-center flex-column  py-4 {{ $isChoose ? 'selected bg-info' : 'bg-light' }}  rounded">

         <h5 class="mb-2 text-center">

             {{ $method->shipping_method_name }}

         </h5>

         <div class="d-flex fw-bold" style="gap: 0.2rem">
             <div>
                 {{ $method->shipping_sale_price }} USD

             </div>
             <div class="fst-italic mb-1 " style="font-size: 12px; margin-top: 3px">
                 Save: {{ $method->shipping_price - $method->shipping_sale_price }} USD
             </div>
         </div>

         <div class="text-decoration-line-through">
             {{ $method->shipping_price }} USD
         </div>
         <div class="fw-medium">
             Estimate: {{ $method->estimate_shipping_days }}
             day{{ $method->estimate_shipping_days > 1 ? 's' : '' }}
         </div>
     </div>
 </div>
