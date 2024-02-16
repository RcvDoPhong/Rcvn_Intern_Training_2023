const tableCart = {
    updateCartTable: function (methodID = 1) {
        $.ajax({
            url: route("frontend.cart.index", { id: methodID, ajax: true }),
            method: "GET",
            success: function (response) {
                console.log(response);
                tableCart.renderCartTable(response.data);
                cartSummary.updateOrderRender(response);
            },
        });
    },

    renderCartTable: function (carts) {
        let cartTableBody = $(".cart-list tbody");
        cartTableBody.empty();

        const tableTemplate = $("#cart-table-template").html();
        const template = Handlebars.compile(tableTemplate);
        const tableUpdateHtml = template({ carts: carts });
        cartTableBody.append(tableUpdateHtml);
    },

    descQuantity: function (productID) {
        const quantityInput = $(`#quantity_${productID}`);
        let currentValue = parseInt(quantityInput.val());
        const oldValue = currentValue;
        if (currentValue <= 1) {
            currentValue = 1;
        } else {
            currentValue -= 1;
        }

        tableCart.changeQuantityProduct(
            productID,
            oldValue - currentValue,
            "subtract"
        );
    },

    incQuantity: function (productID, productStock) {
        const quantityInput = $(`#quantity_${productID}`);
        let currentValue = parseInt(quantityInput.val());
        const oldValue = currentValue;
        if (currentValue >= productStock) {
            quantityInput.val(productStock);
            currentValue = productStock;
            sweet.sweetAlertDisplay(
                "No more product in stock",
                "Please try again",
                "error",
                2000
            );
        } else {
            currentValue += 1;
        }
        tableCart.changeQuantityProduct(
            productID,
            currentValue - oldValue,
            "add"
        );
    },

    changeQuantityProduct: function (productID, quantity, changeMode) {
        $.ajax({
            url: route("frontend.cart.update", productID),
            method: "PUT",
            data: {
                productQuantity: quantity,
                productMode: changeMode,
            },
            success: function (response) {
                const { data, sumPrice } = response;
                //for subnavbar
                cartDisplay.updateCartUI(data, sumPrice);

                tableCart.renderCartTable(data);
                // for main page cart
                cartSummary.updateOrderRender(response);
            },
            error: function (xhr, status, error) {
                // Handle error - maybe show an error message
                console.error(error);
            },
        });
    },

    deleteProductCart: function (productID) {
        $.ajax({
            url: route("frontend.cart.destroy", productID),
            method: "DELETE",
            success: function (response) {
                // Handle success - maybe show a success
                const { data, sumPrice } = response;

                //for subnavbar
                cartDisplay.updateCartUI(data, sumPrice);

                // for main page cart
                tableCart.updateCartTable();
                cartSummary.updateOrderRender(response);
            },
            error: function (xhr, status, error) {
                // Handle error - maybe show an error message
                console.error(error);
            },
        });
    },
};

$(document).ready(function () {

        tableCart.updateCartTable();

});
