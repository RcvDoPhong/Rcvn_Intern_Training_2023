@php
    if (!empty($product)) {
        $isSale = $product['is_sale'];
        $displayPrice = $product['base_price'];
        if ($isSale) {
            $displayPrice = $product['sale_type'] === 0 ? (int) $product['sale_price'] : $product['base_price'] - $product['base_price'] * $product['sale_price_percent'];
        }

        $getDisplayDiscount = $product['sale_type'] === 0 ? $product['base_price'] - $displayPrice : $product['sale_price_percent'] * 100;
        $displayDiscount = $product['sale_type'] === 0 ? $getDisplayDiscount . "$" : $getDisplayDiscount . '%';

        $product['display_price'] = $displayPrice;
        $product['product_link'] = route('frontend.product.index', ['id' => $product['product_id']]);

        $isDisableProduct = $product['status'] === 2 || $product['status'] === 0 || $product['stock'] === 0;
    }

@endphp
<div class="col-md-6">
    @include('frontend::layouts.breadcum', [
        'pageActive' => 'Product Detail',
    ])

    @if (!empty($product))






        <div class="prod_info">
            <h1>{{ $product['product_name'] }}</h1>
            <span class="rating">
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= $product['rating'])
                        <i class="icon-star voted"></i>
                    @else
                        <i class="icon-star"></i>
                    @endif
                @endfor <em>{{ $reviews->total() }}
                    reviews</em>
            </span>
            <p><small>{{ $product['brand']['brand_name'] }}:
                    {{ $product['category']['category_name'] }}</small><br>{{ $product['brief_description'] }}.</p>


            <div class="prod_options">
                @isset($options)
                    @if ($options->count() > 1)
                        <div class="row">
                            <label class="col-xl-5 col-lg-5 col-md-6 col-6"><strong>OPTIONS</strong> <a href="#0"
                                    data-bs-toggle="modal" data-bs-target="#size-modal"><i
                                        class="ti-help-alt"></i></a></label>
                            <div class="col-xl-12 col-12 row m-2 mb-4 " style="gap:0.8rem">

                                @foreach ($options as $option)
                                    <a class="col-xl-3 col-md-4 col-6 p-2 bg-white product-option rounded  {{ $option['product_id'] === $product['product_id'] ? 'selected' : '' }}"
                                        href="{{ route('frontend.product.index', ['id' => $option['product_id']]) }}">
                                        <div class="   d-flex align-items-center  " style="gap:0.6rem">
                                            <img width="42" height="38"
                                                src="{{ '/storage/' . $option['product_thumbnail'] }}"
                                                alt="product thumbnail">
                                            <div>
                                                <em>

                                                    {{ $option['option_name'] }}
                                                </em>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach

                            </div>
                        </div>
                    @endif
                @endisset




                <div class="row">
                    <label class="col-xl-5 col-lg-5  col-md-6 col-6"><strong>Quantity</strong></label>
                    <div class="col-xl-4 col-lg-5 col-md-6 col-6">
                        <div class="numbers-row">
                            <input type="text" id="add_quantity" value="1" class="qty2" name="quantity_1">

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 col-md-6">
                    <div class="price_main"><span
                            class="new_price">${{ number_format($displayPrice, 0, ',', '.') }}</span>
                        @if ($isSale)
                            <span class="percentage">-{{ $displayDiscount }}</span>
                            <span class="old_price">${{ number_format($product['base_price'], 0, ',', '.') }}</span>
                        @endif

                    </div>
                </div>
                <div class="col-lg-4 col-md-6" id="add_to_cart_render">
                    @if ($isDisableProduct)
                        <div class="d-flex justify-content-center flex-column">
                            <button class="btn btn-danger" disabled>
                                Sold out 😔
                            </button>
                            <i class="fw-bold text-center text-secondary mt-2">
                                Please purchase other product
                            </i>
                        </div>
                    @else
                        <button style="border: none; background: none" id="add_to_cart"
                            onclick="cartDisplay.addCart({{ $product }})" class="btn_add_to_cart"><a
                                href="#0" class="btn_1 ">Add to Cart</a></button>
                    @endif
                </div>
            </div>
        </div>
        <!-- /prod_info -->
        <div class="product_actions">
            <ul>
                <li>
                    <a href="#"><i class="ti-heart"></i><span>Add to Wishlist</span></a>
                </li>
                <li>
                    <a href="#"><i class="ti-control-shuffle"></i><span>Add to Compare</span></a>
                </li>
            </ul>
        </div>
        <!-- /product_actions -->
    @else
        <div>
            No product found
        </div>
    @endif


</div>
