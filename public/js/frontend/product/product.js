const product = {
    changeOptionProduct: function (option_id) {
        const convertOptionId = parseInt(option_id, 10);
        $.get(
            route("frontend.product.index", {
                id: convertOptionId,
            }),
            {},
            (response) => {
                window.location.href = route("frontend.product.index", {
                    id: convertOptionId,
                });
            }
        );
    },

    changeReviewPage: function (productID, page) {
        console.log(productID, page);
        $.get(
            route("frontend.product.index", {
                id: productID,
                page: Number(page),
            }),
            (response) => {
                $("#review-section").html(response.view);
                $("#review-pagination").html(response.pagination);

                $("#review-pagination .pagination li").on(
                    "click",
                    function (e) {
                        e.preventDefault();
                        const page = $(this)
                            .children("a")
                            .attr("href")
                            .split("page=")[1];
                        product.changeReviewPage(
                            product.getIDFromPathName(),
                            page
                        );
                    }
                );
            }
        );
    },

    getIDFromPathName: function () {
        const pathName = window.location.pathname;
        const id = pathName.split("/").pop();
        return id;
    },

    changePagination: function (view) {
        $("#review-pagination").html(view);
    },

    changeReviewView: function (view) {
        $("#product-detail-page").html(view);
    },

    assignOnlickPagination: function () {},
};

$(document).ready(function () {
    $("#select-option-product").on("change", function (e) {
        e.preventDefault();
        product.changeOptionProduct($(this).val());
    });

    $("#add_quantity").on("change", function (e) {
        e.preventDefault();
        const currentValue = $(this).val();
        if (currentValue === 0) {
            $("#add_to_cart").prop("disabled", true);
        } else {
            $("#add_to_cart").prop("disabled", false);
        }
    });

    $(".dec.button_inc").on("click", function () {
        let currentValue = Number($("#add_quantity").val());
        if (currentValue <= 0) {
            $("#add_quantity").val(1);
        }
    });

    $(".button_inc.inc").on("click", function () {
        let currentValue = Number($("#add_quantity").val());
        let currentStock = Number($("#product_stock").text());

        if (currentValue > currentStock) {
            $("#add_quantity").val(currentStock);
        }
    });

    $("#review-pagination .pagination li").on("click", function (e) {
        e.preventDefault();
        const page = $(this).children("a").attr("href").split("page=")[1];
        product.changeReviewPage(product.getIDFromPathName(), page);
    });
});
