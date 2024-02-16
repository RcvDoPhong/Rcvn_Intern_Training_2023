const imageValidate = {
    brandImageDefault: window.location.origin + '/storage/brand_logo_placeholder.png',
    productImageDefault: window.location.origin + '/storage/product_logo_placeholder.png',
    displayImage: function (target) {
        let img = this.productImageDefault;
        if (target.files[0]) {
            img = window.URL.createObjectURL(target.files[0]);
        }
        $('img[name="preview"]').attr('src', img);
    },
    clearImage: function (nameInput, type) {
        $(`input[name="${nameInput}"]`).val('');
        const imageDefault = type === 'product' ? this.productImageDefault : this.brandImageDefault;
        $('img[name="preview"]').attr('src', imageDefault);
    },
}
