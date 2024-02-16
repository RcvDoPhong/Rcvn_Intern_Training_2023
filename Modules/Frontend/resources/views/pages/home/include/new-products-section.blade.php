<div class="container margin_60_35">
    <div class="main_title">
        <h2>New Products</h2>
        <span>Products</span>
        <p>Cum doctus civibus efficiantur in imperdiet deterruisset</p>
    </div>
    <div class="owl-carousel owl-theme products_carousel">





        @foreach ($newestProducts as $product)
        
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
</div>
<!-- /container -->
