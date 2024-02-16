const orderHistory = {
    cancelOrder: function (orderHistoryID) {
        $.post(
            route("frontend.order-history.cancel-order", {
                orderHistoryID: orderHistoryID,
            }),
            {},
            (response) => {
                const cancelBtn = $(`#trigger-cancelBtn-${orderHistoryID}`);
                const title = $(`#cancelTitle-${orderHistoryID}`);
                title.text("Canceled");
                title.addClass("text-danger");
                cancelBtn.addClass("d-none");
                $(".modal .fade .show").remove();
            }
        );
    },

};

$(document).ready(function () {
});
