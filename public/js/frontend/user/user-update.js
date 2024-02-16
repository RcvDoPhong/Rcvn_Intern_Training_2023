const userInfo = {
    updateUser: function (data) {
        $.ajax({
            url: route("frontend.user.update"),
            method: "POST",
            data: data,
            success: function (response) {
                // Handle success - maybe show a success
                const { view } = response;

                $("body").html(view);
                const successMessage =
                    '<div class="alert alert-success" role="alert">User updated successfully</div>';
                $("#user-notice").html(successMessage);

                setTimeout(function () {
                    $("#user-notice").html("");
                }, 2500);
                $("html, body").animate({ scrollTop: 0 }, "fast");
            },
            error: function (xhr, status, error) {
                // Handle validation errors
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    // Display errors for each field
                    $.each(errors, function (field, messages) {
                        // Assuming the field name matches the ID of the error element
                        const errorElement = $("#" + "error" + "-" + field);
                        errorElement.text(messages.join(" "));
                        $("html, body").animate({ scrollTop: 0 }, "fast");
                    });
                } else {
                    console.error(xhr.responseText);
                    $("html, body").animate({ scrollTop: 0 }, "fast");
                }
            },
        });
    },

    renderDistrict: function (cityID, districtTarget, wardTarget) {
        const districtSelect = $(districtTarget);
        const wardSelect = $(wardTarget);
        districtSelect.prop("disabled", !cityID);

        // Clear existing options
        districtSelect.empty();
        wardSelect.empty();
        $.ajax({
            url: route("frontend.place.district", {
                id: cityID,
            }), // Replace with your endpoint
            method: "GET",
            success: function (data) {
                // Populate options based on the response data
                data.forEach(function (district, index) {
                    if (index === 0) {
                        userInfo.renderWard(
                            district["district_id"],
                            wardTarget
                        );
                    }

                    districtSelect.append(
                        $("<option>", {
                            value: district["district_id"],
                            text: district.name,
                        })
                    );
                });
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            },
        });
    },

    renderWard: function (districtID, target) {
        const wardSelect = $(target);
        wardSelect.prop("disabled", !districtID);
        wardSelect.empty();
        $.ajax({
            url: route("frontend.place.ward", {
                id: districtID,
            }), // Replace with your endpoint
            method: "GET",
            success: function (data) {
                // Populate options based on the response data
                data.forEach(function (ward) {
                    wardSelect.append(
                        $("<option>", {
                            value: ward["ward_id"],
                            text: ward.name,
                        })
                    );
                });
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            },
        });
    },
};

$(document).ready(function () {
    $("#user-info-form").on("submit", function (e) {
        e.preventDefault();
        userInfo.updateUser($("#user-info-form").serialize());
    });

    // Function to enable/disable district based on the selected city for billing address
    $("#billing-city").on("change", function () {
        const selectedCity = $(this).val();

        if (selectedCity) {
            userInfo.renderDistrict(
                selectedCity,
                "#billing-district",
                "#billing-ward"
            );
        }
    });

    // Function to enable/disable ward based on the selected district for billing address
    $("#billing-district").on("change", function () {
        const selectedDistrict = $(this).val();
        if (selectedDistrict) {
            userInfo.renderWard(selectedDistrict, "#billing-ward");
        }
    });

    // Similar functions for delivery address
    $("#delivery-city").on("change", function () {
        const selectedCity = $(this).val();

        if (selectedCity) {
            userInfo.renderDistrict(
                selectedCity,
                "#delivery-district",
                "#delivery-ward"
            );
        }
    });

    $("#delivery-district").on("change", function () {
        const selectedDistrict = $(this).val();
        if (selectedDistrict) {
            userInfo.renderWard(selectedDistrict, "#delivery-ward");
        }
    });
});
