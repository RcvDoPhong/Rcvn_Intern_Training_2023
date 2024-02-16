<script id="cart-table-template" type="text/x-handlebars-template">


    @{{#ifeq carts.length 0}}
        <tr>
            <td colspan="5" class="text-center">
                <h3>Your cart is empty 😁</h3>
            </td>
        </tr>
        <tr>
            <td colspan="5" class="text-center">
                <a href="{{ route("frontend.category.index") }}">
                    <button class="btn btn-primary">Shopping now</button>
                </a>
            </td>
        </tr>
   @{{else}}
        @{{#each carts}}
            <tr>
                <td>
                    <div class="thumb_cart">
                        <a href="@{{ product_link }}">
                            <img src="/storage/@{{ product_thumbnail }}" class="lazy" alt="@{{ product_name }}">
                        </a>
                    </div>
                    <span class="item_cart">
                        <a class="text-black" href="@{{ product_link }}">
                            @{{ product_name }}
                        </a>
                    </span>
                </td>
                <td><strong>$@{{ formatNumber display_price }}</strong></td>
                <td>
                    <div class="d-flex justify-content-center align-items-center" style="gap: 0.5rem">
                        <div
                        onclick="tableCart.descQuantity(@{{ product_id }})"
                        style="cursor: pointer; font-size: 20px">-</div>
                        <input
                        disabled
                        ="width: 50%" type="text"
                        value="@{{ product_quantity }}"
                        id="quantity_@{{ product_id }}"
                         name="quantity_@{{ product_id }}">
                        <div onclick="tableCart.incQuantity(@{{ product_id }}, @{{ stock }})" style="cursor: pointer; font-size: 20px">+</div>
                    </div>
                </td>
                <td><strong>$@{{ formatNumber total_price }}</strong></td>
                <td class="options">
                    <a href="#" onclick="tableCart.deleteProductCart(@{{ product_id }})"><i class="ti-trash"></i></a>
                </td>
            </tr>
        @{{/each}}
   @{{/ifeq}}
</script>
