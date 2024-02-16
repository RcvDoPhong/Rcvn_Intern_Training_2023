const productsIndex = {
    imagePath: window.location.origin + '/storage/',
    clearImages: function () {
        $('div#productImageContainer').remove();
    },
    renderModal: function (target, id) {
        $(target).addClass('pe-none');
        $.get(route('admin.products.show', id), function (response) {
            if (!response) {
                common.sweetAlertNoButton('Oops!', 'Product not found', 'error');
                return;
            }
            $('img#product_thumbnail').attr('src', productsIndex.imagePath + response.data.product_thumbnail)
            $('img#product_thumbnail').parent().addClass('active');
            $.each(response.imagesList, function (index, value) {
                $('div#productImagesList').append(`
                    <div class="carousel-item">
                        <img class="d-block w-100 img-thumbnail mb-2"
                            src="${productsIndex.imagePath + value}" alt="Second slide">
                    </div>`)
            })

            $('h2#product_name').text(response.data.product_name);
            $('span#updated_by').text(response.updatedBy);

            const bodyContent = $('div#bodyContent').find('span.user-select-auto');
            $.each(bodyContent, function(index, value) {
                const id = $(value).attr('id');
                $(value).text(response.data[id])
            })

            const salePricePercent = $('span#sale_price_percent').text() * 100;
            $('span#sale_price_percent').text(`${salePricePercent}%`);
            $('span#description').html(response.data.product_description);
            $('a#update_product').attr('href', route('admin.products.edit', id));

            $('#modal_product').modal('show');
        }).always(function() {
            $(target).removeClass('pe-none');
        })
    },
    hideModal: function () {
        $('#modal_product').modal('hide')
    }
}

$('#modal_product').on('hidden.bs.modal', function (e) {
    productsIndex.clearImages();
})