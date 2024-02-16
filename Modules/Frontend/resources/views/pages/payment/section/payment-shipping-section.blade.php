<h6 class="pb-2">Shipping Method</h6>


<ul class="row gx-2 gy-2" id="shipping-methods" style="overflow-y: auto; height: 220px">

    @forelse ($methods  as $method)
        <div class="col-lg-6 col-12  ">
            @component('frontend::components.shipping-card', [
                'method' => $method,
                'choose' => $currentMethod->shipping_method_id,
                'type' => 'payment',
            ])
            @endcomponent
        </div>
    @empty
        <h5 class="text-center">

            There is no shipping method display
        </h5>
    @endforelse



</ul>


@auth
    @if (!$user['delivery_city_id'])
        <div class="text-left text-info">
            Please provide us your delivery city to have a correct shipping methods
        </div>
    @else
        <div class="text-left text-info">
            Shipping to {{ $user['deliveryCity']['name'] }}
        </div>
    @endif

@endauth
