const pushMessagePwa = {
    push: function (data) {
        $.ajax({
            url: route("frontend.push.notify-user", data),
            method: "GET",
            success: function (response) {
                if (response === "success") {
                    sweet.sweetAlertDisplay(
                        "Pushed message successfully",
                        "Thank you for your push",
                        "success",
                        2000
                    );
                } else if (response === "User not found") {
                    sweet.sweetAlertDisplay(
                        "User not found",
                        "Please input correct user id",
                        "error",
                        2000
                    );
                    return;
                } else if (response === "danger") {
                    sweet.sweetAlertDisplay(
                        "Something went wrong",
                        "Please try again",
                        "error",
                        2000
                    );
                }
            },
        });
    },
};

$(document).ready(function () {
    const pushForm = $("#pushMessForm");
    pushForm.on("submit", function (e) {
        e.preventDefault();
        const serializeData = pushForm.serialize();
        pushMessagePwa.push(serializeData);
    });
});
