const rolesCreate = {
    createNew: function (event, targetElement) {
        event.preventDefault();
        rolesCreate.clearErrorInput()
        // $(targetElement).attr('disabled', true);

        const inputs = $('div#permissionList').find('input');
        const action = $('form#handleFormInfo').attr('action');

        let permissions = {};
        $.each(inputs, function (index, value) {
            const input = $(value);
            permissions[input.data('id')] = {
                allow: input.is(':checked') ? 1 : 0
            };
        })
        $.ajax({
            type: "post",
            url: action,
            data: {
                role_name: $('input#role_name').val(),
                permissions: permissions,
            },
            statusCode: {
                422: function (error) {
                    $('input#role_name').addClass('is-invalid');
                    $('span.invalid-feedback').text(error.responseJSON.message)
                }
            }
        }).done(function (response) {
            common.sweetAlertNoButton(response.title, response.message, 'success', response.redirect);
        }).fail(function (error) {
            if (error.status !== 422) {
                common.sweetAlertNoButton('Oops!!', error.responseJSON.message, 'error')
            }
        }).always(function () {
            $(targetElement).attr('disabled', false);
        })
    },
    customPermissions: function (targetElement) {
        const isChecked = $(targetElement).is(':checked');
        const permissionList = $('div#permissionList');
        const inputs = permissionList.find('input');

        if (!isChecked) {
            permissionList.addClass('d-none');
            $.each(inputs, function (index, input) {
                $(input).prop("checked", true);;
            })
        } else {
            permissionList.removeClass('d-none');
        }
        inputs.attr('disabled', !isChecked);
    },
    clearErrorInput: function () {
        $('input#role_name').removeClass('is-invalid');
        $('span.invalid-feedback').empty();
    }
}