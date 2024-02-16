@extends('frontend::layouts.master')

@section('content')
    <div class="container margin_30">
        @include('frontend::layouts.breadcum', [
            'pageActive' => 'Order History',
            'title' => 'Order History Page',
        ])

        <main class="bg_white">


            @forelse ($ordersHistory as $orderHistory)
                <div class="mt-3">
                    @include('frontend::pages.order.order-history.include.order-history-header')
                    @include('frontend::pages.order.order-history.include.order-history-item', [
                        'orderHistory' => $orderHistory,
                    ])
                </div>

            @empty
                <div class="alert alert-info">
                    There is no order here.

                </div>
                <a href="{{ route('frontend.category.index') }}" class="d-flex  justify-content-center">
                    <button type="button" class="btn btn-primary">Shopping Now</button>

                </a>
            @endforelse
            <div class="mt-4 d-flex w-100 justify-content-center">
                {{ $ordersHistory->links() }}

            </div>
        </main>
    </div>
@endsection



@section('js')
    <script src="{{ asset('js/frontend/order-history/order-history.js') }}"></script>
@endsection
