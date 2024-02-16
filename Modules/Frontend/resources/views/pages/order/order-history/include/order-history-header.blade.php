@php
    $orderStatus = $orderHistory['orderStatus'];

    $order = $orderHistory['order'];

    $products = $order['products'];

    $user = $order['user'];
@endphp


<div class=" bg-light accordion border w-100 rounded ">
    <button class="accordion-button w-100 p-4 collapsed w-100 p-4" type="button" data-bs-toggle="collapse"
        data-bs-target="#collapseOne-{{ $order['order_id'] }}" aria-expanded="false"
        aria-controls="collapseOne-{{ $order['order_id'] }}">

        <div class="d-md-flex align-items-center" style="gap: 1rem">
            <div>
                <strong>
                    Order date:
                </strong>
                {{ $order['created_at']->toDateString() }}
            </div>
            <div>
                <strong>
                    Total Amount:
                </strong>
                ${{ number_format($order['total_price'], 0, ',', '.') }}
            </div>
            <div>
                <strong>
                    Ship to:
                </strong>
                {{ $user['delivery_fullname'] }}
            </div>

            <div>
                <strong>
                    Order Number:
                </strong>
                {{ explode('.', $order['order_uid'])[0] }}
            </div>
            <div>
                <a
                    href="{{ route('frontend.order-history-detail.index', [
                        'id' => $orderHistory['order_history_id'],
                    ]) }}">
                    <h5 class="text-success mt-1 ms-3">

                        Order detail
                    </h5>
                </a>
            </div>
        </div>



        <div>

        </div>
    </button>
</div>
