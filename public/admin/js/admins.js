const admins = {
    switchInputState: function(checkBox, targetForm, targetBtnDiv) {
        const isChecked = $(checkBox).is(':checked');
        const form = $(`form${targetForm}`);
        const inputs = form.find('input');
        const selects = form.find('select');

        const arrInputSelect = $.merge(inputs, selects);

        $.each(arrInputSelect, function (index, inputs) {
            $(inputs).attr('disabled', !isChecked);
        })

        if (!isChecked) {
            $(targetBtnDiv).addClass('d-none');
        } else {
            $(targetBtnDiv).removeClass('d-none');
        }
    }
}