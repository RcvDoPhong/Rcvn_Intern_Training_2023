const changePassword = {
    change: function (data) {
        console.log(data);
        $.ajax({
            url: route("frontend.user.change-password"),
            method: "POST",
            data: data,
            success: function (response) {
                if (response === "success") {
                    sweet
                        .sweetAlertDisplay(
                            "Success",
                            "Password changed successfully",
                            "success"
                        )
                        .then(() => {
                            window.location.href = route("frontend.user.index");
                        });
                } else {
                    sweet.sweetAlertDisplay(
                        "Error",
                        "Current password is not correct",
                        "error"
                    );
                }
            },
            error: function (xhr, status, error) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    // Display errors for each field
                    $.each(errors, function (field, messages) {
                        // Assuming the field name matches the ID of the error element
                        const errorElement = $("#" + "error" + "-" + field);
                        errorElement.text(messages.join(" "));
                    });
                } else {
                    console.error(xhr.responseText);
                }
            },
        });
    },
};

$(document).ready(function () {
    $("#change-pass-form").on("submit", function (e) {
        e.preventDefault();
        const serializeData = $(this).serialize();
        changePassword.change(serializeData);
    });
});
