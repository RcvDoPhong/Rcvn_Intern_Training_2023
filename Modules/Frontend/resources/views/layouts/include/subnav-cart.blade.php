<div class="dropdown dropdown-cart">
    <a href="{{ route('frontend.cart.index') }}" class="cart_bt"><strong id="cart-count">

            @if (Session::has('cart') && count(Session::get('cart')) > 0)
                {{ count(Session::get('cart')) }}
            @else
                0
            @endif

        </strong></a>
    <div class="dropdown-menu">
        <ul id="cart-list" style="height: 200px; overflow-y: auto; overflow-x: hidden">

            @if (!Session::has('cart') || count(Session::get('cart')) == 0)
                <h5 class="text-center"> Nothing in cart 😁
                </h5>
            @else
                @php
                    $carts = Session::get('cart');

                @endphp

                @foreach ($carts as $cart)
                    <li class=" mb-3 mt-1">
                        <a href="{{ $cart['product_link'] }}">
                            <figure>
                                <img src="{{ '/storage/' . $cart['product_thumbnail'] }}" alt="${cartItem.product_name}"
                                    width="50" height="50" class="lazy">
                            </figure>
                            <strong><span>{{ $cart['product_name'] }}</span></strong>
                            <strong><span>Qty: {{ $cart['product_quantity'] }}</span></strong>
                            <strong><span>Total:
                                    ${{ number_format($cart['total_price'], 0, ',', '.') }}</span></strong>
                            <a style="cursor: pointer"
                                onclick="cartDisplay.deleteProductCart({{ $cart['product_id'] }})" class="action"><i
                                    class="ti-trash"></i></a>
                        </a>


                        </a>
                    </li>
                @endforeach
            @endif


        </ul>
        <div class="total_drop">
            <div class="clearfix"><strong>Total</strong><span>$

                    <span id="sum-price">
                        @php
                            $sum = 0;
                            if (isset($carts) && !empty($cart)) {
                                $sum = array_sum(array_column($carts, 'total_price'));
                            }
                        @endphp

                        {{ number_format($sum, 0, ',', '.') }}
                    </span>

                </span></div>
            <a href="{{ route('frontend.cart.index') }}" class="btn_1 outline">View Cart</a>

            @auth
                <a href="{{ route('frontend.payment.index') }}" class="btn_1">Checkout</a>

            @endauth
        </div>
    </div>
</div>
