@php
    $orderStatus = $orderHistory['orderStatus'];

    $order = $orderHistory['order'];

    $products = $order['products'];

    $user = $order['user'];
@endphp



<div id="collapseOne-{{ $order['order_id'] }}" class="accordion-collapse collapse" aria-labelledby="headingOne">
    <div class="d-md-flex align-items-center justify-content-between p-4">

        <h4 id="cancelTitle-{{ $orderHistory['order_history_id'] }}"
            class=" {{ $orderStatus['order_status_id'] === 4 ? 'text-success' : '' }}
             {{ $orderStatus['order_status_id'] === 5 ? 'text-danger' : '' }}">
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

            <!-- Modal -->
        @endif

    </div>



    @foreach ($products as $product)
        <div class="row row_item my-2 p-3">
            @component('frontend::components.order-history-product', [
                'product' => $product,
            ])
            @endcomponent
        </div>
    @endforeach




</div>
