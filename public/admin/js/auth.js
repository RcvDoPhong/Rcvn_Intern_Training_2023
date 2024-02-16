var authAdmin = {
    login: function () {
        const data = {
            _token: $('input[name="_token"]').val(),
            email: $('input[name="email"]').val(),
            password: $('input[name="password"]').val(),
            remember: $('#remember').val()
        }
        $.post(route('admin.auth.process'), data, function (response) {
            if (response.status === 422) {
                if (response.errors.email) {
                    authAdmin.handleDrawBorderInputErrors($('input[name="email"]'))
                    authAdmin.handleErrorMessage($('#errorEmail'), response.errors.email)
                }
                if (response.errors.password) {
                    authAdmin.handleDrawBorderInputErrors($('input[name="password"]'))
                    authAdmin.handleErrorMessage($('#errorPassword'), response.errors.password)
                }
            }
            else if (response.status !== 200) {
                authAdmin.clearError();
                authAdmin.sweetAlertDisplay('Error', response.errors, 'error')
            }
            else {
                authAdmin.clearError();
                authAdmin.sweetAlertDisplay('Success', response.message, 'success', response.redirect)
            }

        })
    },
    handleDrawBorderInputErrors: function (targetBorder) {
        if (!targetBorder.hasClass('border border-danger')) {
            targetBorder.addClass('border border-danger');
        }
    },
    handleErrorMessage: function (target, message) {
        if (!target.hasClass('d-flex')) {
            target.addClass('d-flex');
        }
        target.text(message);
    },
    sweetAlertDisplay: function (title, message, icon, url = '') {
        swal({
            title: title,
            text: message,
            icon: icon,
            timer: 2000,
            buttons: false,
        }).then(function () {
            if (icon === "success") {
                window.location.replace(url);
            }
        });
    },
    clearError: function () {
        $('input[name="email"]').removeClass('border border-danger');
        $('input[name="password"]').removeClass('border border-danger');
        $('#errorEmail').removeClass('d-flex');
        $('#errorPassword').removeClass('d-flex');
    }
}