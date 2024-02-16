   @php
       $isSale = $product['is_sale'];

       $displayPrice = $product['base_price'];
       if ($isSale) {
           $displayPrice = $product['sale_type'] === 0
           ? (float) $product['sale_price']
           : $product['base_price'] - $product['base_price'] * $product['sale_price_percent'];
       }

       $getDisplayRibbon = $product['sale_type'] === 0
       ? $product['base_price'] - $displayPrice
       : $product['sale_price_percent'] * 100;

       $product['display_price'] = $displayPrice;
       $product['product_quantity'] = 1;
       $product['product_link'] = route('frontend.product.index', ['id' => $product['product_id']]);
       //new off hot

       $isSoldout = $product['status'] === 2 || $product['stock'] <= 0;
       $ribbon = $product['sale_type'] === 0 ? 'hot' : 'new';
       $displayRibbon = $product['sale_type'] === 0 ? "$" . $getDisplayRibbon : '%' . $getDisplayRibbon;
       $ribbonContent = $isSoldout ? 'Sold out' : '-' . $displayRibbon;

       $ratingNumber = $product['rating'] ?? $product['reviews_avg_rating'];

   @endphp


   <div class="grid_item">
       <figure style="border: 1px solid gray; border-radius: 5px;" class="{{ $isSoldout ? 'opacity-50' : '' }}">
           @if ($isSale)
               <span class="ribbon {{ $isSoldout ? 'off' : $ribbon }}">{{ $ribbonContent }}</span>
           @endif
           <a href="{{ route('frontend.product.index', ['id' => $product['product_id']]) }}">
               <img width="200" height="180" class="p-2" src="{{ asset('/storage/' . $product['product_thumbnail']) }}"
                   data-src="{{ asset('/storage/' . $product['product_thumbnail']) }}"
                   alt="{{ $product['product_name'] }}">

           </a>

           {{-- @if ($dateCount)
               <div data-countdown="{{ $dateCount }}" class="countdown"></div>
           @endif --}}
       </figure>

       <div class="rating">
           @for ($i = 0; $i < 5; $i++)
               @if ($i < (int) $ratingNumber ?? 0)
                   <i class="icon-star voted"></i>
               @else
                   <i class="icon-star"></i>
               @endif
           @endfor

       </div>


       <a href="{{ route('frontend.product.index', ['id' => $product['product_id']]) }}">
           <h3>{{ $product['product_name'] }}</h3>
       </a>
       <div class="price_box">
           <span class="new_price">${{ number_format($displayPrice, 0, ',', '.') }}</span>
           @if ($isSale)
               <span class="old_price">${{ number_format($product['base_price'], 0, ',', '.') }}</span>
           @endif
       </div>
       <ul>
           <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="left"
                   title="Add to favorites"><i class="ti-heart"></i><span>Add to favorite</span></a>
           </li>
           <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="left"
                   title="Add to compare"><i class="ti-control-shuffle"></i><span>Add to compare</span></a>
           </li>
           @if ($product['status'] === 1 && $product['stock'] > 0)
               <li>
                   <a href="#" onclick="cartDisplay.addCart({{ $product }})" class="tooltip-1"
                       data-bs-toggle="tooltip" data-bs-placement="left" title="Add to cart"><i
                           class="ti-shopping-cart"></i><span>Add to cart</span></a>
               </li>
           @endif

       </ul>
   </div>
