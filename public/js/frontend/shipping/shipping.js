const shipping = {
    changeCartMethod: function (id) {
        $.ajax({
            url: route("frontend.cart.index", {
                methodID: id,
                ajax: true,
            }),
            method: "GET",
            success: function (response) {
                const displayMethod = $("#shipping-methods");

                displayMethod.empty();
                const cartNotice = $("#cart-method-notice");

                const methods = response.methods;
                const user = response.user;
                if (methods.length == 0) {
                    displayMethod.append(`
                        <div class="col-lg-4 col-md-6 col-12 ">
                            <div class="shipping-card rounded">
                                <div class="d-flex align-items-center flex-column py-4 bg-light rounded">
                                    <h5 class="mb-2">No shipping methods</h5>
                                    <div class="d-flex fw-bold" style="gap: 0.2rem">`);
                }

                const proceedPaymentBtn = $("#proceed-payment");

                proceedPaymentBtn.prop(
                    "href",
                    route("frontend.payment.index", {
                        currentMethodCart:
                            response.currentMethod.shipping_method_id,
                    })
                );

                methods.forEach((method) => {
                    let isChoose =
                        method.shipping_method_id ===
                        response.currentMethod.shipping_method_id;

                    const shippingCardTemplate = $(
                        "#shipping-card-template"
                    ).html();

                    const template = Handlebars.compile(shippingCardTemplate);

                    const shippingCardUpdateHtml = template({
                        method,
                        isChoose,
                        save:
                            method.shipping_price - method.shipping_sale_price,
                        type: "cart",
                    });
                    let render = `
                        <div class="col-lg-4 col-md-6 col-12 ">

                            ${shippingCardUpdateHtml}
                        </div>
                    `;

                    displayMethod.append(render);
                });

                cartSummary.updateOrderRender(response);
                if (user.length === 0) {
                    cartNotice.text(
                        "  Please login to see correct shipping method"
                    );
                }

                if (!user.delivery_city_id) {
                    cartNotice.text(
                        " Please provide us your delivery city to have a correct shipping methods"
                    );
                } else {
                    cartNotice.text(
                        `Shipping to ${user["delivery_city"]["name"]}`
                    );
                }
            },
        });
    },

    select: function (id, type) {
        console.log(type);
        if (type === "cart") {
            shipping.changeCartMethod(id);
        }
        if (type === "payment") {
            payment.changeShippingMethod(id);
        }
    },
};

$(document).ready(function () {
    // Your document ready code goes here
});
