const sweet = {
    sweetAlertDisplay: function (title, text, icon, timer = 2000, url = "") {
        return Swal.fire({
            icon: icon,
            title: title,
            text: text,
            timer: timer,
        });
    },
};
