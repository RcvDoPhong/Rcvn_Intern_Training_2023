   <h2 class="text-center main-title mt-3">
       Top Brands
   </h2>


   @foreach ($topBrandWithProduct as $brandProduct)
       <div class="container margin_60_35" style="padding: 0.5rem !important">
           <div class="d-flex align-items-center mb-3 rounded shadow p-2 bg-white" style="gap:0.8rem; ">
               <img height="40" width="40" src="{{ '/storage/' . $brandProduct['brand']['brand_logo'] }}"
                   alt="">
               <h4 class="mt-2">{{ $brandProduct['brand']['brand_name'] }}</h4>
           </div>

           <div class="owl-carousel owl-theme products_carousel">


               @foreach ($brandProduct['products'] as $product)
                   <div class="item">
                       @component('frontend::components.product', [
                           'product' => $product,
                           'dateCount' => '2019/05/15',
                       ])
                       @endcomponent
                   </div>
               @endforeach



           </div>
       </div>
   @endforeach
