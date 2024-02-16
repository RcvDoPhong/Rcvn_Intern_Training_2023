@extends('frontend::layouts.master')

@php

    $deliveryAddress = $user['delivery_fullname'] . ' - ' . $user['delivery_address'] . ' - ' . $user['deliveryWard']['name'] . ' - ' . $user['deliveryDistrict']['name'] . ' - ' . $user['deliveryCity']['name'];

    $billingAddress = $user['billing_phone_number'] . ' - ' . $user['billing_fullname'] . ' - ' . $user['billing_address'] . ' - ' . $user['billingWard']['name'] . ' - ' . $user['billingDistrict']['name'] . ' - ' . $user['billingCity']['name'];

@endphp

@section('content')
    <div class="container margin_30">
        @include('frontend::layouts.breadcum', [
            'pageActive' => 'Payment',
            'title' => 'Payment Page',
        ])

        <main class="bg_gray">
            <div class="row">
                @include('frontend::pages.payment.include.payment-user-infor')
                @include('frontend::pages.payment.include.payment-shipping')
                @include('frontend::pages.payment.include.payment-order-summary')
            </div>
        </main>
    </div>
@endsection


@section('js')
   
    <script src="{{ asset('js/frontend/shipping/shipping.js') }}"></script>
    <script src="{{ asset('js/frontend/payment/payment.js') }}"></script>
    @include('frontend::template.shipping.shipping-card-template')
    @include('frontend::template.payment.payment-order-summary-template')
@endsection
