const payment = {
    changeShippingMethod: function (id) {
        $.ajax({
            url: route("frontend.payment.index", {
                shippingMethodID: id,
            }),
            method: "GET",
            success: function (response) {
                const displayMethod = $("#shipping-methods");
                displayMethod.empty();

                const methods = response.methods;
                const currentMethod = response.currentMethod;

                methods.forEach((method) => {
                    let isChoose =
                        method.shipping_method_id ===
                        currentMethod.shipping_method_id;

                    const shippingCardTemplate = $(
                        "#shipping-card-template"
                    ).html();
                    const template = Handlebars.compile(shippingCardTemplate);
                    const shippingCardUpdateHtml = template({
                        method,
                        isChoose,
                        save:
                            method.shipping_price - method.shipping_sale_price,
                        type: "payment",
                    });

                    let render = `
                         <div class="col-lg-6 col-12">
                            ${shippingCardUpdateHtml}
                        </div>
                    `;
                    displayMethod.append(render);
                });

                payment.updateOrderSection(response);
            },
        });
    },

    updateOrderSection: function (response, couponPrice = 0) {
        const { getCart, currentMethod } = response;

        const orderSection = $("#order-section");
        orderSection.empty();

        // Check if the necessary properties are available
        const sumPrice = (getCart && getCart["sumPrice"]) || 0;
        const shippingSalePrice =
            (currentMethod && currentMethod["shipping_sale_price"]) || 0;

        const paymentOrderSummaryTemplate = $(
            "#payment-order-summary-template"
        ).html();
        console.log(sumPrice, shippingSalePrice, couponPrice);

        const template = Handlebars.compile(paymentOrderSummaryTemplate);
        const orderSummaryPayment = template({
            sumPrice,
            shippingSalePrice,
            couponPrice,
            total: sumPrice + shippingSalePrice - couponPrice,
            type: "payment",
        });

        orderSection.append(orderSummaryPayment);
    },

    applyCoupon: function (code) {
        $.ajax({
            url: route("frontend.payment.apply-coupon", {
                code: code,
            }),
            method: "POST",
            success: function (response) {
                const { coupon } = response;
                const couponNotice = $("#coupon-notice");
                couponNotice.text("");
                const getCoupon = coupon.coupon;

                if (getCoupon) {
                    couponNotice.text("Apply coupon successfully");
                    const getPercentPrice =
                        getCoupon.sale_price -
                        getCoupon.sale_price * getCoupon.sale_price_percent;
                    const getPrice =
                        getCoupon.sale_type === 0
                            ? getCoupon.sale_price
                            : getPercentPrice;

                    payment.updateOrderSection(response, getPrice);
                } else {
                    couponNotice.text(coupon.message);

                    payment.updateOrderSection(response, 0);
                }
            },
        });
    },

    addPayment: function () {
        $("#payment-add-order").prop("disabled", false);

        const userInfoForm = $("#user-infor-form");
        const disabledInputs = userInfoForm.find(":input:disabled");
        disabledInputs.prop("disabled", false);
        const serializedUserForm = userInfoForm.serialize();
        const paymentMethodForm = $(".step.middle.payments.b");
        const serializedPaymentMethodInfo = serializeForm(paymentMethodForm);
        const shippingMethodID = $(".shipping-card.choose").data("id");

        const subtotalPrice = $("#subtotal_price").data("value");
        const shippingPrice = $("#shipping_price").data("value");
        const couponPrice = $("#coupon_price").data("value");
        const totalPrice = $("#total_price").data("value");

        const data = {
            subtotal_price: subtotalPrice,
            shipping_price: shippingPrice,
            coupon_price: couponPrice,
            total_price: totalPrice,
            shipping_method_id: shippingMethodID,
        };

        $.ajax({
            url: route("frontend.payment.add-payment", [
                serializedUserForm,
                serializedPaymentMethodInfo,
            ]),
            method: "POST",
            data: {
                ...data,
            },
            success: function (response) {
                if (response.status === 400) {
                    sweet.sweetAlertDisplay(
                        "The product is out of stock",
                        response.messages,
                        "error",
                        3000
                    );
                } else {
                    window.location.href = response;
                }

                $("#payment-add-order").prop("disabled", false);
            },
            error: function (error) {
                $("#payment-add-order").prop("disabled", false);
            },
        });
    },
    changeBillingAddress: function (isChange) {
        $.ajax({
            url: route("frontend.payment.change-billing-address"),
            method: "PUT",
            data: {
                isChange,
            },
            success: function (response) {
                console.log("change billing address success");
            },
        });
    },
};

$(document).ready(function () {
    $("#coupon").on("change", function () {
        payment.applyCoupon($(this).val());
    });
    $("#payment-add-order").on("click", function () {
        payment.addPayment();
    });

    const checked = $("#is_billing_address").is(":checked");
    if (checked) {
        $("#other_addr_c").fadeOut("fast");
    } else {
        $("#other_addr_c").fadeIn("fast");
    }

    $("#is_billing_address").on("change", function () {
        if (this.checked) {
            $("#other_addr_c").fadeOut("fast");
            payment.changeBillingAddress(this.checked);
        } else {
            $("#other_addr_c").fadeIn("fast");
            payment.changeBillingAddress(this.checked);
        }
    });
});

function getMoneyFromPrice(money) {
    const withoutDollarSign = money.slice(1);
    const number = Number(withoutDollarSign);
    return number;
}
function serializeForm(form) {
    const formData = form.serializeArray();
    const serializedObject = {};

    formData.forEach((field) => {
        // Remove trailing "=" for unchecked checkboxes and radio buttons
        const value = field.value.endsWith("=")
            ? field.value.slice(0, -1)
            : field.value;
        serializedObject[field.name] = value;
    });

    return serializedObject;
}

function removeDollarAndDot(str) {
    return parseInt(str.replace(/[$.]/g, ""));
}
