<script id="payment-order-summary-template" type="text/x-handlebars-template">
    <ul>
        <li class="clearfix"><em><strong>Subtotal</strong></em> <span data-value="@{{sumPrice}}" id="subtotal_price">$@{{formatNumber sumPrice}} </span></li>
        <li class="clearfix"><em><strong>Shipping</strong></em> <span data-value="@{{shippingSalePrice}}" id="shipping_price">$@{{formatNumber shippingSalePrice}} </span></li>
        <li class="clearfix"><em><strong>Apply Coupon</strong></em> <span data-value="@{{couponPrice}}" id="coupon_price">$@{{formatNumber couponPrice}}</span></li>
    </ul>
    <div class="total clearfix">TOTAL <span data-value="@{{total}}" id="total_price">$@{{formatNumber total}}</span></div>
</script>
