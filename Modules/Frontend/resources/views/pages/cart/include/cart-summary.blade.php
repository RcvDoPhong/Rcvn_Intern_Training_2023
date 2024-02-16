<div class=" col-lg-6  col-md-12 mt-5 mt-md-0 mt-2">
    <ul id='cart-order'>

    </ul>

    @if (count($data) > 0)
        @auth
            @if (empty($user['billing_fullname']) && empty($user['delivery_fullname']))
                <a id="proceed-payment" href="{{ route('frontend.user.index') }}" class="btn_1 full-width cart">Please update
                    your profile for payment</a>
            @else
                <a id="proceed-payment" href="{{ route('frontend.payment.index', ['currentMethodCart' => $currentMethod]) }}"
                    class="btn_1 full-width cart">Proceed to Checkout</a>
            @endif



        @endauth
        @guest

            <a href="{{ route('frontend.auth.index') }}" class="btn_1 full-width cart">Proceed to Checkout</a>

        @endguest
    @endif

</div>
