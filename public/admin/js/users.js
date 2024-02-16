var users = {
    renderModal: function (targetElement) {
        const userId = $(targetElement).data('id');

        const modal = $(targetElement).data('modal');
        $('div.modal-dialog').removeClass("modal-xl");

        $('div#content').empty();
        $('div#content').append(`
            <form id="updatePassword">
                <input name="_method" type="hidden" value="PUT" />
                <div class="form-group">
                    <label class="mt-2 d-flex">New password</label>
                    <input name="new_password" type="password" class="form-control" value=""
                        placeholder="Type new password">
                    <span name="new_password" class="error invalid-feedback"></span>
                </div>
                <div class="form-group">
                    <label class="mt-2 d-flex">Confirm new password</label>
                    <input name="confirm_new_password" type="password" class="form-control" value=""
                        placeholder="Type confirm new password">
                    <span name="confirm_new_password" class="error invalid-feedback"></span>
                </div>
            </form>
        `)

        $('div#additionalButtons').append(`
            <button class="btn btn-primary" data-id="${userId}" data-modal="#modalGlobal"
                onclick="users.handleUpdatePassword(this)">Update</button>
        `)

        $(modal).modal('show');
    },
    handleUpdatePassword: function (targetElement) {
        $('form#updatePassword').find('span.invalid-feedback').text('');
        $('form#updatePassword').find('input.is-invalid').removeClass('is-invalid');
        $(targetElement).addClass('pe-none');
        const data = $('form#updatePassword').serialize();
        const userId = $(targetElement).data('id');
        const url = route('admin.users.updatePassword', userId);

        $.ajax({
            type: "post",
            url: url,
            data: data,
            statusCode: {
                422: function (error) {
                    $.each(error.responseJSON.errors, function (key, value) {
                        $(`span[name="${key}"]`).text(value);
                        $(`input[name="${key}"]`).addClass('is-invalid')
                    });
                }
            }
        }).done(function (response) {
            common.sweetAlertNoButton(response.title, response.message, 'success', response.redirect);
        }).fail(function (error) {
            if (error.status !== 422) {
                common.sweetAlertNoButton('Something went wrong!', error.responseJSON.message, 'error')
            }
        }).always(function () {
            $(targetElement).removeClass('pe-none');
        });
    },
    displayDistrictsWardsList: function (parentElement, targetElement, type) {
        const id = $(parentElement).val();
        let url = '';
        let elementTag = '';
        let message = '';
        if (type === 'district') {
            url = route('admin.districts.show', id);
            elementTag = 'district_id';
            message = "Select district";
        } else {
            url = route('admin.wards.show', id);
            elementTag = 'ward_id';
            message = "Select ward";
        }
        const select = $(`select#${targetElement}_${elementTag}`);
        select.empty();
        select.append(`<option value="">${message}</option>`)
        if (id !== '') {
            $.get(url, function (response) {
                let options = '';
                $.each(response.data, function (index, value) {
                    options += `
                    <option value="${value.id}">${value.name}</options>
                `;
                });
                select.append(options);
            });
        }

    },
}