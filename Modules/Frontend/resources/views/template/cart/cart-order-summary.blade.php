<script id="cart-order-summary-template" type="text/x-handlebars-template">
    @{{log response}}
    <li>
                        <span>Subtotal</span>$@{{formatNumber sumPrice}}
        </li>
                <li>
                            <span>Shipping</span> $@{{formatNumber currentMethod.shipping_sale_price
                            }}
                    </li>
                          <li>
                             <span>Total</span>$@{{formatNumber
                                 total

                             }}
                        </li>
</script>
