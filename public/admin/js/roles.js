const roles = {
    // pagePermissions: [
    //     'Admins',
    //     'Roles',
    //     'Brands',
    //     'Categories',
    //     'Products',
    //     'Vendors',
    //     'Orders',
    //     'Customers',
    //     'Reviews'
    // ],
    displayRolePermission: function (targetElement) {
        const roleId = $(targetElement).data('id');

        $(targetElement).addClass('pe-none');

        $.ajax({
            type: "get",
            url: route('admin.roles.permissions', roleId),
            success: function (response) {
                $('form#formPermissionList').find('input:checked').prop('checked', false);

                $.each(response.data, function (index, value) {
                    let inputId = value.rawName;
                    inputId = inputId.replace('.', '_');
                    const permission = $(`input#${inputId}`);
                    permission.prop('checked', value.checked);
                });

                $('div#roleList').removeClass('col-12');
                $('div#roleList').addClass('col-6');

                $('div#routeList').removeClass('d-none');
                $('button#routeListBtn').data('id', roleId);
            }
        }).fail(function (error) {
            common.sweetAlertNoButton('Oops!!', error.responseJSON.message, 'error')
        }).always(function () {
            $(targetElement).removeClass('pe-none');
        });

    },
    hideRouteList: function (target) {
        Swal.fire({
            title: "Are you sure?",
            text: "Make sure to save before closing!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes! close it"
        }).then((result) => {
            const hideRouteList = $(target).data('hide');
            $('div#roleList').addClass('col-12');
            $('div#roleList').removeClass('col-6');

            $(`div${hideRouteList}`).addClass('d-none');
            $('button#routeListBtn').data('id', '');
        });
    },
    savePermission: function (targetBtn) {
        $(targetBtn).attr('disabled', true);

        const roleId = $(targetBtn).data('id');
        const inputs = $('form#formPermissionList').find('input');
        let data = {};
        data['_method'] = 'PUT';
        $.each(inputs, function (index, value) {
            const input = $(value);
            data[input.data('id')] = {
                allow: input.is(':checked') ? 1 : 0
            };
        })
        $.ajax({
            type: "POST",
            url: route('admin.roles.updatePermission', roleId),
            data: data,
        }).done(function (response) {
            $(`td#updated_by_${roleId}`).text(response.updatedBy);
            common.sweetAlertNoButton(response.title, response.message, 'success');
        }).fail(function (error) {
            common.sweetAlertNoButton('Oops!!', error.responseJSON.message, 'error')
        }).always(function () {
            $(targetBtn).attr('disabled', false);
        });
    },
    displayRoleName: function (targetElement) {
        $(targetElement).addClass('pe-none');
        const roleId = $(targetElement).data('id');

        $.ajax({
            type: 'get',
            url: route('admin.roles.show', roleId),
        }).done(function (response) {
            const content = $('div#content');
            const title = $('h5#modalTitle');
            const additionalButtons = $('div#additionalButtons');

            $('div.modal-dialog').removeClass('modal-xl');
            additionalButtons.empty();
            content.empty();
            title.text('');

            title.text('Update role name');

            content.append(`
                <form id="updateRole" action="" method="POST">
                    <input type="hidden" value="PUT" name="_method"/>
                    <label class="mt-2 d-flex ml-1" for="role_name">Role name</label>
                    <input id="role_name" name="role_name" type="text" class="form-control d-flex"
                        value="${response.data.role_name}"
                        placeholder="Type role name"/>
                    <span name="role_name" class="error invalid-feedback d-flex"></span>
                </form>
            `)

            $('form#updateRole').attr('action', route('admin.roles.update', roleId));

            additionalButtons.append(`
                <button class="btn btn-primary" data-id="${roleId}"
                    onclick="roles.updateRole(event, this, '#updateRole')">Update</button>
            `)

            $('div#modalGlobal').modal('show');
        }).fail(function (error) {
            common.sweetAlertNoButton('Oops!!', error.responseJSON.message, 'error');
        }).always(function () {
            $(targetElement).removeClass('pe-none');
        })
    },
    updateRole: function (event, targetButton, targetForm) {
        event.preventDefault();
        roles.clearErrorInput();
        $(targetButton).addClass('pe-none');
        const form = $(`form${targetForm}`);
        const roleId = $(targetButton).data('id');

        const action = form.attr('action');
        const data = form.serialize();
        const newRoleName = form.find('input[name="role_name"]').val();

        $.ajax({
            type: "POST",
            url: action,
            data: data,
            statusCode: {
                422: function (error) {
                    $('input#role_name').addClass('is-invalid');
                    $('span.invalid-feedback').text(error.responseJSON.message)
                }
            }
        }).done(function (response) {
            $(`a#role_name_${roleId}`).text(newRoleName);
            $(`td#updated_by_${roleId}`).text(response.updatedBy);
            common.sweetAlertNoButton(response.title, response.message, 'success');
        }).fail(function (error) {
            if (error.status !== 422) {
                common.sweetAlertNoButton('Oops!!', error.responseJSON.message, 'error')
            }
        }).always(function () {
            $(targetButton).removeClass('pe-none');
        })
    },
    clearErrorInput: function () {
        $('input#role_name').removeClass('is-invalid');
        $('span.invalid-feedback').empty();
    }
}

$('#modalGlobal').on('shown.bs.modal', function () {
    $('input#role_name').focus();
})