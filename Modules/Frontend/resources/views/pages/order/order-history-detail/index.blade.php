@extends('frontend::layouts.master')

@php
    $orderStatus = $orderHistory['orderStatus'];

    $order = $orderHistory['order'];

    $products = $order['products'];
    $shippingMethod = $order['shippingMethod'];

    $user = $order['user'];
@endphp

@section('content')
    <div class="container margin_30">
        @include('frontend::layouts.breadcum', [
            'pageActive' => 'Order History Detail',
            'title' => 'Order History Detail Page',
        ])

        <main class="bg_white">

            @include('frontend::pages.order.order-history-detail.include.orrder-history-detail-header', [
                'orderHistory' => $orderHistory,
                'order' => $order,
                'user' => $user,
                'shippingMethod' => $shippingMethod,
            ])
            @include('frontend::pages.order.order-history-detail.include.order-history-detail-display', [
                'orderHistory' => $orderHistory,
            ])

        </main>
    </div>
@endsection



@section('js')
    <script src="{{ asset('js/frontend/order-history/order-history.js') }}"></script>
@endsection
