<div class="bg_white">
    <div class="container margin_60_35">
        <div class="main_title">
            <h2>Recently</h2>
            <span>Product</span>
            <p>viewed product</p>
        </div>
        <div class="owl-carousel owl-theme products_carousel">

            @if (!$recentlyViewProduct)
                <h5 class="text-center w-100 d-flex justify-content-center">
                    <div>
                        No Recently Viewd Product
                    </div>
                </h5>
            @else
                @foreach ($recentlyViewProduct as $product)
                    @component('frontend::components.product', [
                        'product' => (object) $product,
                        'dateCount' => '2019/05/15',
                    ])
                    @endcomponent
                @endforeach


            @endif



        </div>
        <!-- /products_carousel -->
    </div>
    <!-- /container -->
</div>
<!-- /bg_white -->
