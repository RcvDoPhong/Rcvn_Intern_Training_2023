const cartSummary = {
    updateOrderRender: function (response) {
        let cartOrder = $("#cart-order");
        cartOrder.empty();

        const cartOrderSummaryTemplate = $(
            "#cart-order-summary-template"
        ).html();
        const template = Handlebars.compile(cartOrderSummaryTemplate);
        const orderSummaryHtml = template({
            ...response,
            total:
                response.sumPrice + response.currentMethod.shipping_sale_price,
        });
        cartOrder.append(orderSummaryHtml);
    },
};
$(document).ready(function () {
});
