Dropzone.options.imageDropzone = {
    url: route('admin.products.storeImages'),
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    paramName: 'product_images',
    uploadMultiple: true,
    parallelUploads: 5,
    autoProcessQueue: false,
    addRemoveLinks: true,
    acceptedFiles: "image/jpeg,image/png",
    init: function () {
        let imageDropzone = this;
        $.ajax({
            url: route('admin.products.getImages', $('div#imageDropzone').data('id')),
            type: 'get',
            success: function (response) {
                $.each(response.data, function (index, value) {
                    let file = {
                        imageId: value.imageId,
                        name: value.name,
                        size: value.size,
                        dataURL: value.path,
                    }

                    imageDropzone.displayExistingFile(file, value.path);
                    // imageDropzone.files.push(file);
                });
            }
        });
        this.on("sendingmultiple", function (data, xhr, formData) {
            formData.append('product_id', $('div#imageDropzone').data('id'));
        });
        this.on('successmultiple', function (file, response) {
            $('button#saveButton').attr('disabled', false);
            common.sweetAlertNoButton(response.title, response.message, 'success', response.redirect);
        });
        this.on("removedfile", function (file) {
            if (file.imageId) {
                $.ajax({
                    url: route('admin.product.removeImage'),
                    type: 'POST',
                    data: {
                        _method: "DELETE",
                        fileName: file.name,
                        imageId: file.imageId
                    }
                }).done(function (response) {
                    common.sweetAlertNoButton(response.title, response.message, 'success');
                }).fail(function (error) {
                    common.sweetAlertNoButton('Something went wrong!', error.responseJSON.message, 'error')
                });
            }

            if ($('div#imageDropzone').find('div.dz-complete').length > 0) {
                if (!$('div.dz-message').hasClass('d-none')) {
                    $('div.dz-message').addClass('d-none')
                }
            } else {
                $('div.dz-message').removeClass('d-none')
            }
        });
    },
}


const updateProduct = {
    handleSelectedOptions: function () {
        const selects = $('div#parent_option_products').find('select');
        const parentFlag = parseInt($('select#parent_flag').val());

        if (parentFlag === 1) {
            $.each(selects, function (index, value) {
                const currentValue = $(value).val();

                $(value).data('prev', currentValue);

                let cloneSelects = selects;
                cloneSelects = cloneSelects.filter(function (index, element) {

                    return $(value).attr('id') !== $(element).attr('id');
                });

                $.each(cloneSelects, function (index, element) {
                    $(element).find(`option#${currentValue}`).addClass('d-none');
                });
            })
        }
    }
}

updateProduct.handleSelectedOptions();