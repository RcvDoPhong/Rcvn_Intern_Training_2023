const authUserLogin = {
    login: function () {
        const data = {
            email: $("#email").val(),
            password: $("#password").val(),
            remember: $("#remember").is(":checked"),
        };

        $.post(route("frontend.auth.login"), data, (response) => {
            console.log(response);
            this.removeError();
            if (response.status === 400) {
                if (response.errors.email) {
                    this.addError(
                        $("#email"),
                        $("#emailError"),
                        response.errors.email
                    );
                }
                if (response.errors.password) {
                    this.addError(
                        $("#password"),
                        $("#passwordError"),
                        response.errors.password
                    );
                }
            } else if (response.status !== 200) {
                authUserLogin.sweetAlertDisplay(
                    "Error",
                    response.message,
                    "error"
                );
            } else {
                window.location.replace(response.redirect);
            }
        });
    },
    logout: function () {
        $.post(route("frontend.auth.logout"), {}, (response) => {
            if (response.status === 200) {
                window.location.replace(response.redirect);
            }
        });
    },
    sweetAlertDisplay: function (title, message, icon, url = "") {
        new swal({
            title: title,
            text: message,
            icon: icon,
            timer: 1500,
            buttons: false,
            willClose: () => {
                $(".swal2-container").remove();
            },
        }).then(function () {
            if (icon === "success") {
                window.location.replace(url);
            }
        });
    },

    addError: (target, errorTarget, message = "") => {
        target.addClass("border border-danger");
        if (errorTarget.hasClass("d-none")) {
            errorTarget.removeClass("d-none");
            errorTarget.addClass("d-flex");
        }

        errorTarget.text(message[0]);
    },

    removeError: () => {
        $("#email").removeClass("border border-danger");
        $("#name").removeClass("border border-danger");

        $("#password").removeClass("border border-danger");

        $("#emailError").addClass("d-none");
        $("#nameError").addClass("d-none");
        $("#passwordError").addClass("d-none");
    },
};
