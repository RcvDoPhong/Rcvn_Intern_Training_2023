const productView = {
    changeProductView: function (viewName) {
        productView.currentView = viewName;
        const searchName = productView.getQueryParams("searchName");
        productView.queryProduct(
            productView.currentQueryResult,
            productView.currentSortValue,
            productView.currentPage,
            searchName
        );
    },
    currentView: "grid",
    currentQueryResult: {},
    currentSortValue: "",
    currentPage: 1,
    currentSearchName: "",
    makeProductView: function (view) {
        $("#product-list-container").html(view);
    },
    changePagination: function (view) {
        $("#pagination-category").html(view);
    },
    getQueryParams: function (name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    },

    queryProduct: function (result, sortName = null, page, searchName) {
        productView.removeError();
        $.get(
            route("frontend.category.query-product"),
            {
                ...result,
                sortName,
                searchName,
                page,
                currentView: productView.currentView,
            },
            (response) => {
                console.log(response);
                if (response.status === 400) {
                    if (response.errors.maxPrice) {
                        productView.showError(
                            "#max-price-error",
                            response.errors.maxPrice
                        );
                    }

                    if (response.errors.minPrice) {
                        productView.showError(
                            "#min-price-error",
                            response.errors.minPrice
                        );
                    }
                } else {
                    productView.makeProductView(response.view);
                    productView.changePagination(response.pagination);
                }
            }
        );
    },

    showError: function (target, message) {
        $(target).text(message);
    },

    removeError: function () {
        $("#min-price-error").text("");
        $("#max-price-error").text("");
    },
};

$(document).ready(function () {
    $("#category-form").on("submit", function (e) {
        e.preventDefault();
        const query = $("#category-form").serialize();
        const searchName = productView.getQueryParams("searchName");

        // Parse the query
        const params = new URLSearchParams(query);
        const result = {};
        for (const [key, value] of params.entries()) {
            if (result[key]) {
                result[key].push(value);
            } else {
                result[key] = [value];
            }
        }

        productView.currentQueryResult = result;
        productView.queryProduct(
            result,
            productView.currentSortValue,
            1,
            searchName
        );
    });

    $("#sort-category").on("change", function () {
        const sort = $("#sort-category").val();
        productView.currentSortValue = sort;
        const searchName = productView.getQueryParams("searchName");

        productView.queryProduct(
            productView.currentQueryResult,
            sort,
            1,
            searchName
        );
    });

    $(document).on("click", "#pagination-category a", function (e) {
        e.preventDefault();
        const page = $(this).attr("href").split("page=")[1];
        productView.currentPage = page;
        const searchName = productView.getQueryParams("searchName");

        productView.queryProduct(
            productView.currentQueryResult,
            productView.currentSortValue,
            page,
            searchName
        );
        $("html, body").animate({ scrollTop: 100 }, "fast");
    });

    $("#filter_btn").on("click", function () {
        $("html, body").animate({ scrollTop: 100 }, "fast");
    });
});
