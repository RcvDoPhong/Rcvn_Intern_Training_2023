@extends('frontend::layouts.master')

@section('content')
    <main class="bg_gray">
        <div class="container margin_30">

            @include('frontend::layouts.breadcum', [
                'pageActive' => 'Cart Detail',
                'title' => 'Your Cart',
            ])

            @include('frontend::pages.cart.include.cart-table')
        </div>


        <div class="box_cart">
            <div class="container">
                <div class="row  gx-5">
                    @include('frontend::pages.cart.include.cart-shipping-method')
                    @include('frontend::pages.cart.include.cart-summary')

                </div>
            </div>
        </div>


        @include('frontend::pages.cart.include.cart-recently-viewed-product')
    </main>
@endsection


@section('js')
    <script src="{{ asset('js/frontend/cart/cart-update-table.js') }}"></script>
    <script src="{{ asset('js/frontend/cart/cart-order-summary.js') }}"></script>
    <script src="{{ asset('js/frontend/shipping/shipping.js') }}"></script>

    @include('frontend::template.cart.cart-index-template')
    @include('frontend::template.shipping.shipping-card-template')
@endsection
