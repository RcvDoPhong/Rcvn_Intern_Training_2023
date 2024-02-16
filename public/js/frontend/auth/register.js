$(document).ready(function () {
    function registerUser(data) {
        $.post(route("frontend.auth.store"), data, function (response) {
            console.log(response);
            removeError();
            if (response.status === 400) {
                if (response.errors.email) {
                    addError(
                        $("#email"),
                        $("#emailError"),
                        response.errors.email
                    );
                }
                if (response.errors.password) {
                    addError(
                        $("#password"),
                        $("#passwordError"),
                        response.errors.password
                    );
                }
                if (response.errors.name) {
                    addError($("#name"), $("#nameError"), response.errors.name);
                }
            } else if (response.status !== 200) {
                sweetAlertDisplay("Error", response.errors, "error");
            } else {
                window.location.replace(response.redirect);
            }
        });
    }

    function sweetAlertDisplay(title, message, icon, url = "") {
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
    }

    const getRegisterData = () => {
        return {
            email: $("#email").val(),
            password: $("#password").val(),
            name: $("#name").val(),
            password_confirmation: $("#password_confirmation").val(),
        };
    };

    const addError = (target, errorTarget, message = "") => {
        target.addClass("border border-danger");
        if (errorTarget.hasClass("d-none")) {
            errorTarget.removeClass("d-none");
            errorTarget.addClass("d-flex");
        }

        errorTarget.text(message[0]);
    };

    const removeError = () => {
        $("#email").removeClass("border border-danger");
        $("#name").removeClass("border border-danger");

        $("#password").removeClass("border border-danger");

        $("#emailError").addClass("d-none");
        $("#nameError").addClass("d-none");
        $("#passwordError").addClass("d-none");
    };

    $("#submit-register").on("click", function (e) {
        e.preventDefault();
        const data = getRegisterData();
        registerUser(data);
    });
});
