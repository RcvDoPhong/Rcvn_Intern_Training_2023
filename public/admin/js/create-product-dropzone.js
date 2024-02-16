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
        this.on("sendingmultiple", function (data, xhr, formData) {
            formData.append('product_id', $('div#imageDropzone').data('id'));
            formData.append('create_status', true);
        });
        this.on('successmultiple', function(file, response) {
            $('button#saveButton').attr('disabled', false);
            common.sweetAlertNoButton(response.title, response.message, 'success', response.redirect)
        });
    },
}