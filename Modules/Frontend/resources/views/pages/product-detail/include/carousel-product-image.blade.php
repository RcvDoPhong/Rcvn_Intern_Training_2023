 <div class="row justify-content-center">
     <div class="col-lg-8">
         <div class="owl-carousel owl-theme prod_pics magnific-gallery">

             @if (count($images) == 0)
                 <div class="item">
                     <a href="{{ asset('image/default-img-product.png') }}" title="Photo title"
                         data-effect="mfp-zoom-in"><img width="600" height="380"
                             src="{{ asset('image/default-img-product.png') }}"
                             data-src="{{ asset('image/default-img-product.png') }}" alt=""
                             class="owl-lazy"></a>
                 </div>
             @endif

             @foreach ($images as $image)
                 <div class="item">
                     <a href="{{ '/storage/' . $image['image_path'] }}" title="Photo title"
                         data-effect="mfp-zoom-in"><img width="600" height="380"
                             src="{{ '/storage/' . $image['image_path'] }}"
                             data-src="{{ '/storage/' . $image['image_path'] }}" alt="" class="owl-lazy"></a>
                 </div>
             @endforeach

             <!-- /item -->

             <!-- /item -->
         </div>
         <!-- /carousel -->
     </div>
 </div>
