const brands = {
    imagePath: window.location.origin + '/storage/',
    brandsEnumField: {
        'founded': 'Founded',
        'productCounts': 'Total product',
        'updatedBy': 'Updated by'
    },
    clearImages: function () {
        $('div#productImageContainer').remove();
    },
    renderModal: function (target, id) {
        $(target).addClass('pe-none');
        $.get(route('admin.brands.show', id), function (response) {
            if (!response) {
                common.sweetAlertNoButton('Oops', 'Product not found', 'error');
                return;
            }

            $('div.modal-dialog').removeClass('modal-xl');

            $('div#content').empty();
            $('div#additionalButtons').empty();

            const brandInfo = $(`<div id="brandInfo"></div>`);

            $('div#content').append(`
                <div class="text-center">
                    <img src="${brands.imagePath + response.brandLogo}"
                        class="rounded img-fluid mb-2" id="logo" style="height:300px"
                        alt="logoBrand">
                </div>
            `);
            $('div#content').append(`
                <h2 class="fw-bold" id="brand_name">
                    ${response.brandName}
                </h2>
            `);

            $.each(response.data, function (index, value) {
                brandInfo.append(`
                    <div>
                         <span>
                            <strong>${brands.getFieldNameEnum(index)}:</strong>
                            <span class="ml-2" id="founded">${value}</span>
                        </span>
                    </div>
                `);
            })
            $('div#content').append(brandInfo);

            $('div#additionalButtons').append(`
                <a href="${route('admin.brands.edit', id)}"
                    id="edit_brand" class="btn btn-success">
                    Update
                </a>
            `);

            const modal = $(target).data('modal');
            $(modal).modal('show');
        }).fail(function (error) {
            common.sweetAlertNoButton(
                error.responseJSON.title,
                error.responseJSON.message,
                'error',
                route('admin.brands.index')
            );
        }).always(function () {
            $(target).removeClass('pe-none');
        })
    },
    getFieldNameEnum: function (key) {
        return brands.brandsEnumField[key] ?? key.charAt(0).toUpperCase() + key.slice(1);
    }
}
