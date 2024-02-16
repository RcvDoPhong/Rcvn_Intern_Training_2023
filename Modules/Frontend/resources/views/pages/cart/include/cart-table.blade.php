<div style="max-height: 400px; overflow-y: auto;">
    <table class="table table-striped cart-list">
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            {{-- ajax render table here --}}

        </tbody>
    </table>
</div>

<div class="row add_top_30 flex-sm-row-reverse cart_actions">
    <div class="col-sm-4 text-end">

        @if (count($data) > 0)
            <a href="{{ route('frontend.category.index') }}">

                <button type="button" class="btn_1 gray">Shopping more</button>
            </a>
        @endif
    </div>
    <div class="col-sm-8">

    </div>
</div>
