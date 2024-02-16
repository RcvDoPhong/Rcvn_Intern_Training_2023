@php
    if (empty(!$product)) {
        $displayPrice = $product['sale_type'] === 0 ? (int) $product['sale_price'] : $product['base_price'] - $product['base_price'] * $product['sale_price_percent'];

        $getDisplayDiscount = $product['sale_type'] === 0 ? $product['base_price'] - $displayPrice : $product['sale_price_percent'] * 100;
        $displayDiscount = $product['sale_type'] === 0 ? $getDisplayDiscount . "$" : $getDisplayDiscount . '%';
    }

@endphp
@if (!empty($product))
    <div class="top_panel">
        <div class="container header_panel">
            <a href="#0" class="btn_close_top_panel"><i class="ti-close"></i></a>
            <label>Product added to cart successfully</label>
        </div>
        <!-- /header_panel -->
        <div class="item">
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <div class="item_panel">
                            <figure>
                                <img src="{{ asset('/storage/' . $product['product_thumbnail']) }}"
                                    data-src="{{ asset('/storage/' . $product['product_thumbnail']) }}" class="lazy"
                                    alt="">
                            </figure>
                            <h4>{{ $product['product_name'] }}</h4>
                            <div class="price_panel"><span class="new_price">{{ $displayPrice }}</span><span
                                    class="percentage">-{{ $displayDiscount }}</span> <span
                                    class="old_price">{{ $product['base_price'] }}</span></div>
                        </div>
                    </div>
                    <div class="col-md-5 btn_panel">
                        <a href="{{ route('frontend.cart.index') }}" class="btn_1 outline">View cart</a>

                        @auth

                            <a href="{{ route('frontend.payment.index') }}" class="btn_1">Checkout</a>

                        @endauth
                    </div>
                </div>
            </div>
        </div>


    </div>


    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="size-modal" id="size-modal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Option guide</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    Options mean: to show other options that related to this product
                </div>
            </div>
        </div>
    </div>
@endif
