 @if (!empty($relatedProducts))

     <div class="bg_white">
         <div class="container margin_60_35">
             <div class="main_title">
                 <h2>Related</h2>
                 <span>Products</span>
                 <p>Cum doctus civibus efficiantur in imperdiet deterruisset.</p>
             </div>

             @if ($relatedProducts->count() == 0)
                 <h4 class="text-center">No Products Found</h4>
             @else
                 <div class="owl-carousel owl-theme products_carousel">
                     @foreach ($relatedProducts as $product)
                         <div class="item">
                             @component('frontend::components.product', [
                                 'product' => $product,
                                 'dateCount' => '2019/05/15',
                             ])
                             @endcomponent
                         </div>
                     @endforeach


                 </div>
                 <!-- /products_carousel -->

             @endif
         </div>
         <!-- /container -->
     </div>
     <!-- /bg_white -->
 @endif
