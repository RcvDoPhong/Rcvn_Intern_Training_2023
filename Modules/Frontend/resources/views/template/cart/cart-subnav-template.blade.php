<script id="cart-subnavbar-template" type="text/x-handlebars-template">
    @{{#if product_link}}
    <li class=" mb-3 mt-1">
        <a href="@{{ product_link }}">
            <figure>
                <img src="/storage/@{{ product_thumbnail }}" alt="@{{ product_name }}" width="50" height="50" class="lazy">
            </figure>
            <strong><span>@{{ product_name }}</span></strong>
            <strong><span>Qty: @{{ product_quantity }}</span></strong>
            <strong><span>Total: $@{{formatNumber total_price}}</span></strong>
            <a style="cursor: pointer" onclick="cartDisplay.deleteProductCart(@{{ product_id }})" class="action"><i class="ti-trash"></i></a>
        </a>
    </li>
   @{{else}}
        <h5 class="text-center"> Nothing in cart 😁 </h5>
   @{{/if}}
</script>
