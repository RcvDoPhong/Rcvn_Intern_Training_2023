 <div class="bg_gray">
     <div class="container margin_30">
         <div id="brands" class="owl-carousel owl-theme">
             @foreach ($brands as $brand)
                 <div class="item">
                     <a href="#0"><img width="40" height="50" src="{{ '/storage/' . $brand['brand_logo'] }}"
                             data-src="{{ '/storage/' . $brand['brand_logo'] }}" alt="" class="owl-lazy"></a>
                 </div><!-- /item -->
             @endforeach
         </div><!-- /carousel -->
     </div><!-- /container -->
 </div>
