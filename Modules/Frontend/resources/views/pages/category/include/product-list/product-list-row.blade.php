@foreach ($products as $product)
    @php

        $isSale = $product['is_sale'];

        $displayPrice = $product['base_price'];
        if ($isSale) {
            $displayPrice = $product['sale_type'] === 0 ? (float) $product['sale_price'] : $product['base_price'] - $product['base_price'] * $product['sale_price_percent'];
        }

        $getDisplayRibbon = $product['sale_type'] === 0 ? $product['base_price'] - $displayPrice : $product['sale_price_percent'] * 100;
        $displayRibbon = $product['sale_type'] === 0 ? $getDisplayRibbon . "$" : $getDisplayRibbon . '%';

        $product['display_price'] = $displayPrice;
        $product['product_quantity'] = 1;
        $product['product_link'] = route('frontend.product.index', ['id' => $product['product_id']]);
        //new off hot
        $isSoldout = $product['status'] === 2 || $product['stock'] <= 0;
        $ribbon = $product['sale_type'] === 0 ? 'hot' : 'new';
        $displayRibbon = $product['sale_type'] === 0 ? $getDisplayRibbon . "$" : $getDisplayRibbon . '%';
        $ribbonContent = $isSoldout ? 'Sold out' : '-' . $displayRibbon;

    @endphp
    <div class="row row_item {{ $isSoldout ? 'opacity-50' : '' }}">
        <div class="col-sm-3">
            <figure>
                @if ($isSale)
                    <span class="ribbon {{ $isSoldout ? 'off' : $ribbon }}">{{ $ribbonContent }}</span>
                @endif
                <a href="{{ route('frontend.product.index', ['id' => $product['product_id']]) }}">
                    <img class="img-fluid lazy" src="{{ asset('/storage/' . $product['product_thumbnail']) }}"
                        data-src="{{ asset('/storage/' . $product['product_thumbnail']) }}"
                        alt="{{ $product['product_name'] }}">
                </a>
                {{-- <div data-countdown="2019/05/15" class="countdown"></div> --}}
            </figure>
        </div>
        <div class="col-sm-8">

            @for ($i = 0; $i < 5; $i++)
                @if ($i < (int) $product['rating'])
                    <div class="rating"><i class="icon-star voted"></i></div>
                @else
                    <div class="rating"><i class="icon-star"></i></div>
                @endif
            @endfor
            <a href="{{ route('frontend.product.index', ['id' => $product['product_id']]) }}">
                <h3>{{ $product['product_name'] }}</h3>
            </a>
            <p>{{ $product['brief_description'] }}</p>
            <div class="price_box">
                <span class="new_price">{{ number_format($displayPrice, 0, ',', '.') }}$</span>
                @if ($isSale)
                    <span class="old_price">{{ number_format($product['base_price'], 0, ',', '.') }}$</span>
                @endif
            </div>
            <ul>
                @if ($product['status'] === 1)
                    <li><a href="#0" class="btn_1" onclick="cartDisplay.addCart({{ $product }})">Add
                            to cart</a></li>
                @endif

                <li><a href="#0" class="btn_1 gray tooltip-1" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="Add to favorites"><i class="ti-heart"></i><span>Add to favorites</span></a></li>

            </ul>
        </div>
    </div>
@endforeach

@if ($products->count() == 0)
    <h4 class="text-center">No Products Found</h4>
@endif


@include('frontend::pages.category.include.paginate-section')
