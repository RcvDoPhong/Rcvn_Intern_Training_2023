const orders = {
    changeOrderStatus: function (target) {
        const orderId = $(target).data('id');
        $.ajax({
            url: route('admin.orders.status', $(target).data('id')),
            type: 'POST',
            data: {
                _method: "PUT",
                id: orderId,
                status: $(target).val()
            }
        }).done(function (response) {
            common.sweetAlertNoButton('Update successfully!', response.message, 'success', common.returnCurrentRoute())
        }).fail(function (error) {
            common.sweetAlertNoButton('Oops!', error.responseJSON.message, 'error', common.returnCurrentRoute())
        })
    },
    renderModal: function (target, id) {
        $(target).addClass('pe-none');
        let orderContentBody = $('div#orderContentBody');
        if (orderContentBody.length === 0) {
            orderContentBody = $(`<div id="orderContentBody" class="row"></div>`);
            $('div#content').append(orderContentBody);
        }

        if ($('h5#productListTitle').length === 0) {
            $('div#content').append(`
                <hr class="dropdown-divider mt-3">
                <h5 class="modal-title" id="productListTitle">
                    Order detail
                </h5>
            `);
        }

        let orderProductListBody = $('div#orderProductListBody');

        if (orderProductListBody.length === 0) {
            orderProductListBody = $(`<div id="orderProductListBody" class="vstack overflow-auto"></div>`);
            $('div#content').append(orderProductListBody);
        }

        let orderStatusSelect = $('div#orderStatus');
        if (orderStatusSelect.length === 0) {
            orderStatusSelect = $(`<div class="form-group" id="orderStatus"></div>`);
            $('div.modal-footer').append(orderStatusSelect);
        }

        $.get(route('admin.orders.show', id), function (response) {

            orderContentBody.empty();
            orderProductListBody.empty();
            $('div#orderStatus').empty();

            $('h5#modalTitle').text(`${response.data.orderUid.title}: ${response.data.orderUid.value}`);

            orders.formatOrderInfo(orderContentBody, response.data);
            orders.formatOrderProductsList(orderProductListBody, response.products);
            if ($('input#changeStatus').val()) {
                orders.formatOrderStatusFooter('div#orderStatus', response.orderStatusList, response.orderStatus, id)
            }

            const modal = $(target).data('modal');
            $(modal).modal('show');
        }).fail(function (error) {
            console.log(error);
        }).always(function () {
            $(target).removeClass('pe-none');
        })
    },
    formatOrderInfo: function (orderContentBody, orderInfo) {
        const deliveryAddressBody = $('<div class="col-6 pr-lg-15 mt-3"></div>')
        deliveryAddressBody.append(`<span class="fw-bold mb-2">Delivery Address</span>`)
        $.each(orderInfo.deliveryAddress, function (index, data) {
            deliveryAddressBody.append(`
                    <div class="row justify-content-between">
                        <div class="col-auto">
                            <span>${data.title}</span>
                        </div>
                        <div class="col-auto">
                            <span>${data.value}</span>
                        </div>
                    </div>
                `)
        });

        const deliveryInfo = $('<div class="col-3 vstack"></div>');
        $.each(orderInfo.deliveryInfo, function (index, data) {
            const body = $(`<div class="mt-3" id="${index}"></div>`);
            body.append(`
                    <span class="fw-bold">${data.title}</span>
                    <div>
                        <span>${data.value}</span>
                    </div>
                `)
            if (data.subValue) {
                body.append(`
                    <div class="fs-6">
                        <span>
                            ${data.subValue}
                        </span>
                    </div>`)
            }
            deliveryInfo.append(body);
        });

        const orderSummary = $('<div class="col-3 mt-3"></div>');
        orderSummary.append('<span class="fw-bold mb-2">Order Summary</span>')
        $.each(orderInfo.orderSummary, function (index, data) {
            if (data.subValue) {
                orderSummary.append('<hr class="dropdown-divider mt-3">');
            }
            orderSummary.append(`
                    <div class="row justify-content-between ${data.subValue ? 'fw-bold' : ''}">
                        <div class='col-auto'>
                            ${data.title}
                        </div>
                        <div class="col-auto">
                            ${data.value}
                        </div>
                    </div>
                `)
        })
        orderContentBody.append([
            deliveryAddressBody,
            deliveryInfo,
            orderSummary
        ])
    },
    formatOrderProductsList: function (orderProductListBody, orderProduct) {
        $.each(orderProduct, function (index, value) {
            const media = $('<div class="media mt-3"></div>');
            const mediaContent = $('<div class="media-body mt-3"></div>');

            media.append(`
                <img class="mr-3 rounded-lg" style="width: 10%"
                    src="${value.productThumbnail}">
            `);

            $.each(value.productInfo, function (index, data) {
                mediaContent.append(`<div class="mt-0"><strong>${data.title}:</strong> ${data.value}</div>`)
            })

            media.append(mediaContent);
            orderProductListBody.append(media);
        })
    },
    formatOrderStatusFooter: function (target, orderStatus, status, id) {
        const select = $(`
            <select id="orderStatus" class="custom-select" data-id=${id}
                onchange="orders.changeOrderStatus(this)"></select>
        `);
        $.each(orderStatus, function (index, value) {
            select.append(`
                <option value="${value.order_status_id}"
                    ${value.order_status_id === status ? 'selected' : ''}>
                    ${value.name.charAt(0).toUpperCase() + value.name.slice(1)}
                </option>
            `)
        })
        $(target).append(select);
    }
}