<div class="container margin_60_35">
    <div class="main_title">
        <h2>Top Selling</h2>
        <span>Products</span>
        <p>Cum doctus civibus efficiantur in imperdiet deterruisset</p>
    </div>
    <div class="row small-gutters">
        @foreach ($topSellingProducts as $product)

            <div class="col-6 col-md-4 col-xl-3">

                @component('frontend::components.product', [
                    'product' => $product,
                    'dateCount' => '2019/05/15',
                ])
                @endcomponent

            </div>
        @endforeach

    </div>
    <!-- /row -->
</div>
<!-- /container -->
