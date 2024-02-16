const orderReview = {
    addReview: function (formData, files) {
        $("#review-btn").prop("disabled", true);

        const formDataFiles = new FormData();
        for (const file of files) {
            formDataFiles.append("review-images[]", file);
        }
        $.ajax({
            url: route("frontend.order-history-detail.add-review", formData),
            type: "POST",
            data: formDataFiles,
            contentType: false,
            processData: false,
            success: function (response) {
                $("#review-btn").prop("disabled", false);

                sweet
                    .sweetAlertDisplay(
                        "Added review successfully",
                        "Thank you for your feedback",
                        "success",
                        1500
                    )
                    .then(() => {
                        window.location.href = route(
                            "frontend.order-history-detail.index",
                            { id: response }
                        );
                    });
            },
            error: function (xhr, status, error) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    // Display errors for each field
                    $.each(errors, function (field, messages) {
                        const errorElement = $("#" + "error" + "-" + field);
                        errorElement.text(messages.join(" "));
                    });

                    // Loop through each image error and display it
                    $.each(errors, function (field, messages) {
                        if (field.startsWith("review-images.")) {
                            const index = field.split(".")[1];
                            const errorElement = $("<p>").text(messages[0]);
                            $("#error-review-images-" + index).append(
                                errorElement
                            );
                        }
                    });
                } else {
                    console.error(xhr.responseText);
                }

                $("#review-btn").prop("disabled", false);
            },
        });
    },
};

$(document).ready(function () {
    $("#review-images").on("change", function () {
        // Clear existing image previews
        $("#image-preview-container").empty();

        for (const file of this.files) {
            const reader = new FileReader();

            reader.onload = function (e) {
                const imgElement = `<img width="140" height="140" src="${e.target.result}" alt="Preview" class="preview-image mx-3 my-2 rounded shadow-sm">`;
                $("#image-preview-container").append(imgElement);
            };

            reader.readAsDataURL(file);
        }
    });

    $("#review-form").on("submit", function (e) {
        e.preventDefault();
        const commentValue = $("#comment").val().trim();
        $("#comment").val(commentValue);
        let formData = $(this).serialize();
        console.log(formData);
        orderReview.addReview(formData, $("#review-images")[0].files);
    });
});
