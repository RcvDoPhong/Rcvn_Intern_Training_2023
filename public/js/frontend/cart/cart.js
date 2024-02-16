const cartDisplay = {
    addCart: function (product) {
        const getProductQuantity = $("#add_quantity").val();
        if (getProductQuantity) {
            product.product_quantity = Number(getProductQuantity);
        }

        $.ajax({
            url: route("frontend.cart.store"), // Replace with your actual route
            method: "POST",
            data: {
                product,
            },
            success: function (response) {
                if (response.data.status === 400) {
                    sweet.sweetAlertDisplay(
                        "The product is out of stock",
                        response.error,
                        "error",
                        3000
                    );
                } else {
                    // Handle success - maybe show a success message
                    if (!$("#add_quantity").val()) {
                        sweet.sweetAlertDisplay(
                            "Product added to cart",
                            "add successfully",
                            "success",
                            1000
                        );
                    }
                    const { data, sumPrice } = response;
                    cartDisplay.updateCartUI(data, sumPrice);
                    if (window.location.pathname === "/frontend/cart") {
                        tableCart.updateCartTable();
                    }
                }
            },
            error: function (xhr, status, error) {
                // Handle error - maybe show an error message
                console.error(error);
            },
        });
    },

    updateCartUI: function (cartItems, sumPrice = 0) {
        const cartList = $("#cart-list");
        const cartCount = $("#cart-count");
        const sumPriceElement = $("#sum-price");

        cartList.empty();

        cartCount.text(cartItems.length ?? 0);

        sumPriceElement.text(sumPrice);

        if (Array.isArray(cartItems) && cartItems.length > 0) {
            const templateContent = $("#cart-subnavbar-template").html();

            const template = Handlebars.compile(templateContent);

            cartItems.forEach(function (cartItem) {
                // Render the template with actual values
                const listItemHtml = template(cartItem);
                cartList.append(listItemHtml);
            });
        } else {
            // Display a message if the cart is empty
            const emptyMessage = $(
                "<h5 class='text-center'>Nothing in cart 😁</h5>"
            );
            cartList.append(emptyMessage);
        }
    },

    deleteProductCart: function (productID) {
        $.ajax({
            url: route("frontend.cart.destroy", productID),
            method: "DELETE",
            success: function (response) {
                const { data, sumPrice } = response;
                cartDisplay.updateCartUI(data, sumPrice);

                tableCart.updateCartTable();
            },
            error: function (xhr, status, error) {
                // Handle error - maybe show an error message
                console.error(error);
            },
        });
    },
};

$(document).ready(function () {});
