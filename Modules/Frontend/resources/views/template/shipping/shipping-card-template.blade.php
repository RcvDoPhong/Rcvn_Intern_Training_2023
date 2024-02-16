<script id="shipping-card-template" type="text/x-handlebars-template">
       @{{#if isChoose}}
                <div class="shipping-card rounded selected choose bg-info" data-id="@{{method.shipping_method_id}}" onclick="shipping.select(@{{method.shipping_method_id}}, @{{type}})">
                    <span class="shipping-ribbon">choose</span>
                    <div class="d-flex align-items-center flex-column py-4 rounded">
                        <h5 class="mb-2 text-center">@{{method.shipping_method_name}}</h5>
                        <div class="d-flex fw-bold" style="gap: 0.2rem">
                            <div>@{{method.shipping_sale_price}} USD</div>
                            <div class="fst-italic mb-1" style="font-size: 12px; margin-top: 3px">
                                Save: @{{save}} USD
                            </div>
                        </div>
                        <div class="text-decoration-line-through">@{{method.shipping_price}} USD</div>
                        <div class="fw-medium">
                            Estimate: @{{method.estimate_shipping_days}} day@{{#if (gt method.estimate_shipping_days 1)}}s@{{/if}}
                        </div>
                    </div>
                </div>
       @{{else}}
                <div class="shipping-card rounded bg-light" data-id="@{{method.shipping_method_id}}" onclick="shipping.select(@{{method.shipping_method_id}}, '@{{type}}')">
                    <div class="d-flex align-items-center flex-column py-4 rounded">
                        <h5 class="mb-2 text-center">@{{method.shipping_method_name}}</h5>
                        <div class="d-flex fw-bold" style="gap: 0.2rem">
                            <div>@{{method.shipping_sale_price}} USD</div>
                            <div class="fst-italic mb-1" style="font-size: 12px; margin-top: 3px">
                                Save: @{{save}} USD
                            </div>
                        </div>
                        <div class="text-decoration-line-through">@{{method.shipping_price}} USD</div>
                        <div class="fw-medium">
                            Estimate: @{{method.estimate_shipping_days}} day@{{#if (gt method.estimate_shipping_days 1)}}s@{{/if}}
                        </div>
                    </div>
                </div>
@{{/if}}
</script>
