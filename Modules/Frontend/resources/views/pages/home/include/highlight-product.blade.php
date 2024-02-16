@php
    $bestProduct = $topRatedProducts[0];

    $displayPrice = $bestProduct['sale_type'] === 0 ? (float) $bestProduct['sale_price'] : $bestProduct['base_price'] - $bestProduct['base_price'] * $bestProduct['sale_price_percent'];
@endphp

<div class="featured lazy" data-bg="url({{ '/storage/' . $bestProduct['product_thumbnail'] }})">
    <div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0.5)">
        <div class="container margin_60">
            <div class="row justify-content-center justify-content-md-start">
                <div class="col-lg-6 wow" data-wow-offset="150">
                    <h3>{{ $bestProduct['product_name'] }}</h3>
                    <p>{{ $bestProduct['brief_description'] }}</p>
                    <div class="feat_text_block">
                        <div class="price_box">
                            <span class="new_price">${{ number_format($displayPrice, 0, ',', '.') }}</span>
                            <span
                                class="old_price">${{ number_format($bestProduct['base_price'], 0, ',', '.') }}</span>
                        </div>
                        <a class="btn_1"
                            href="{{ route('frontend.product.index', ['id' => $bestProduct['product_id']]) }}"
                            role="button">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /featured -->
