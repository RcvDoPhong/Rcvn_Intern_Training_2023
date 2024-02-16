const common = {
    enumCommonFieldNames: {
        'name': 'Name',
        'email': "Email",
        'birthday': 'Birthday',
        'gender': 'Gender',
        'isActive': 'Status',
        'createdAt': 'Created at',
        'adminName': 'Updated by'
    },
    returnCurrentRoute: function() {
        let url = window.location.href;
        url = url.replace('#', '');
        return url;
    },
    sweetAlertWithButton: function (target, event, title, message) {
        event.preventDefault();
        const form = $(target).closest("form");
        new swal({
            title: title,
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    data: form.serialize(),
                    url: form.attr('action')
                }).done(function (response) {
                    common.sweetAlertNoButton('Success!!', response.message, 'success', common.returnCurrentRoute())
                }).fail(function (error) {
                    common.sweetAlertNoButton('Oops!!', error.responseJSON.message, 'error')
                })
            }
        });
    },
    sweetAlertNoButton: function(title, message, icon, url = '') {
        Swal.fire({
            title: title,
            text: message,
            icon: icon,
            timer: 2000,
            showConfirmButton: false,
        }).then(function() {
            if (url !== '') {
                window.location.replace(url)
            }
        });
    },
    handleCreateUpdate: function(event, targetBtn, targetForm = '#handleFormInfo') {
        event.preventDefault();
        common.clearErrorInput(targetForm);
        const data = new FormData($(`form${targetForm}`)[0]);

        const url = $(`form${targetForm}`).attr('action');
        this.handleSubmitAjax(url, targetBtn, data);
    },
    handleSubmitAjax: function (url, target, data) {
        $(target).attr('disabled',true);

        $.ajax({
            url: url,
            type: 'post',
            data: data,
            processData: false,
            contentType: false,
            statusCode: {
                422: function (error) {
                    $.each(error.responseJSON.errors, function (key, value) {
                        $(`span[name="${key}"]`).text(value);
                        $(`input[name="${key}"]`).addClass('is-invalid');
                        $(`select[name="${key}"]`).addClass('is-invalid');
                    })
                },
                200: function (response) {
                    common.sweetAlertNoButton(response.title, response.message, 'success', response.redirect)
                }
            }
        }).fail(function (error) {
            if(error.status !== 422) {
                common.sweetAlertNoButton('Đã có lỗi xảy ra!', error.responseJSON.message, 'error')
            }
        }).always(function() {
            $(target).attr('disabled', false);
        });
    },
    clearErrorInput: function (targetForm) {
        $(`form${targetForm}`).find('input').removeClass('is-invalid');
        $(`form${targetForm}`).find('select.is-invalid').removeClass('is-invalid');
        $(`form${targetForm}`).find('span.invalid-feedback').text('');
        $(`form${targetForm}`).find('span.text-danger').text('');
    },
    clearSearchResult: function(url) {
        $('form#searchForm').find('input').val('')
        $('form#searchForm').find('select').val('')
        window.location.href = url
    },
    updateSalePricePercent: function(basePriceInputName, salePriceInputName, salePricePercentName) {
        const basePrice = parseInt($(`input[name="${basePriceInputName}"]`).val()) || 1;
        const salePrice = parseInt($(`input[name="${salePriceInputName}"]`).val()) || 0;
        let salePercent = salePrice / basePrice;
        if (salePercent > 0) {
            salePercent = 1 - salePercent;
        }
        $(`input[name="${salePricePercentName}"]`).val(salePercent.toFixed(2));
    },
    hideModal: function (target) {
        const modal = $(target).data('modal');
        $(modal).modal('hide')
    },
    formatDate: function (date) {
        return new Date(date).toLocaleDateString('en-AU', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit'
        });
    },
    getCommonEnumKey: function (key) {
        return common.enumCommonFieldNames[key] ?? key.charAt(0).toUpperCase() + key.slice(1);
    }
}