@php
    $orderStatus = $orderHistory['orderStatus'];

    $order = $orderHistory['order'];

    $products = $order['products'];
    $shippingMethod = $order['shippingMethod'];

    $user = $order['user'];
@endphp



<div aria-labelledby="headingOne">


    <div class="d-md-flex align-items-center justify-content-between p-4">

        <h4 id="cancelTitle-{{ $orderHistory['order_history_id'] }}"
            class=" {{ $orderStatus['order_status_id'] === 5 ? 'text-danger' : '' }}">
            Order status: {{ $orderStatus['name'] }}
        </h4>

        @if ($orderHistory['order_status_id'] === 1 || $orderHistory['order_status_id'] === 2)
            <button type="button" class="btn btn-danger triggerCancelBtn"
                id="trigger-cancelBtn-{{ $orderHistory['order_history_id'] }}"
                data-id="{{ $orderHistory['order_history_id'] }}" data-bs-toggle="modal"
                data-bs-target="#modal-{{ $orderHistory['order_history_id'] }}">
                Request Cancellation
            </button>

            @section('modal')
                @include('frontend::pages.order.order-history.include.order-history-modal', [
                    'orderHistory' => $orderHistory,
                ])
            @endsection
        @endif

    </div>



    @foreach ($products as $product)
        <div class="row row_item my-2  p-3">
            @component('frontend::components.order-history-product', [
                'product' => $product,
            ])
            @endcomponent
            <div class="col-sm-2 flex-column justify-content-between">
                @if ($orderHistory['order_status_id'] === 4)
                    @if (in_array($user['user_id'], $product['reviews']->pluck('user_id')->toArray()))
                        <button disabled class="btn btn-success btn-sm">Reviewed</button>
                    @else
                        <a
                            href="{{ route('frontend.order-history-detail.review-page', [
                                'orderHistoryID' => $orderHistory['order_history_id'],
                                'productID' => $product['product_id'],
                            ]) }}">

                            <button class="btn btn-primary btn-sm">Review This Product</button>
                        </a>
                    @endif
                @endif

                <a href="{{ route('frontend.product.index', ['id' => $product['product_id']]) }}">
                    <button class="mt-3 btn btn-secondary btn-sm">Product Page</button>

                </a>
            </div>
        </div>
    @endforeach




</div>
