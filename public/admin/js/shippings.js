
const shippings = {
    options: {
        style: 'decimal',  // Other options: 'currency', 'percent', etc.
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    },
    displayAreaShipping: function (target) {
        const shippingType = parseInt($(target).val());
        if (shippingType) {
            $('div#city_id').removeClass('d-none');
        } else {
            $('div#city_id').addClass('d-none');
        }
    },
    handleSalePercentInput: function () {
        common.updateSalePricePercent('shipping_price', 'shipping_sale_price', 'shipping_sale_price_percent')
    },
    handleCreateUpdate: function (event, targetBtn) {
        event.preventDefault();
        common.clearErrorInput();
        const data = new FormData($('form#handleFormInfo')[0]);

        if (!$('input[name="shipping_sale_price"]').val()) {
            data.set('shipping_sale_price', $('input[name="shipping_price"]').val())
        }

        if (!parseInt($('select[name="shipping_type"]').val())) {
            data.delete('city_id[]');
        }

        const url = $('form#handleFormInfo').attr('action');
        common.handleSubmitAjax(url, targetBtn, data);
    }
}

$(document).ready(function () {
    $('select#city_id').select2();
});