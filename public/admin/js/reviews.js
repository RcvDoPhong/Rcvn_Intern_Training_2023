const reviews = {
    updateStatus: function (select) {
        const statusCode = $(select).val();
        const reviewId = $(select).data('id');
        const url = route('admin.reviews.update', reviewId);

        $.ajax({
            data: {
                _method: 'PUT',
                status: statusCode,
            },
            url: url,
            type: 'POST',
        }).done(function (response) {
            common.sweetAlertNoButton('Update successfully!', response.message, 'success', common.returnCurrentRoute())
        }).fail(function (error) {
            common.sweetAlertNoButton('Oops', error.responseJSON.message, 'error', common.returnCurrentRoute())
        })
    },
    renderModal: function (reviewLinkTarget) {
        $(reviewLinkTarget).addClass('pe-none');

        $('div#content').empty();
        $('div#additionalButtons').empty()
        const modal = $(reviewLinkTarget).data('modal');
        const reviewId = $(reviewLinkTarget).data('id');

        const reviewHeader = $('<div id="reviewHeader" class="ml-3"></div>');
        const reviewContent = $('<div id="reviewContent" class="mt-5 ml-3"></div>');
        const reviewImages = $('<div id="reviewImages" class="dropzone rounded-3 border-0"></div>');
        $('div#content').append(reviewHeader);
        $('div#content').append(reviewContent);
        $('div#content').append(reviewImages);

        $.ajax({
            url: route('admin.reviews.show', reviewId),
            type: 'get',
        }).done(function (response) {
            if (response.imagesCount > 0) {
                $(reviewImages).dropzone({
                    url: route('admin.reviews.images', response.review.review_id),
                    uploadMultiple: true,
                    parallelUploads: 5,
                    clickable: false,
                    autoProcessQueue: false,
                    init: function () {
                        let imageDropzone = this;
                        $.ajax({
                            url: route('admin.reviews.images', response.review.review_id),
                            type: 'get',
                            success: function (response) {
                                $.each(response.data, function (index, value) {
                                    let file = {
                                        name: value.name,
                                        size: value.size,
                                        dataURL: value.path,
                                    }
                                    // file.previewElement.id = value.product_image_id
                                    imageDropzone.displayExistingFile(file, value.path);
                                });
                            }
                        });
                    }
                })
            }

            $('h5#modalTitle').text(`Tiêu đề: ${response.review.title}`);
            reviews.formatReview(reviewHeader, reviewContent, response);
            reviews.formatReviewStatusFooter(
                'div#additionalButtons',
                response.statusList,
                response.review.is_approved,
                response.review.review_id
            )

            $(modal).modal('show');
        }).always(function () {
            $(reviewLinkTarget).removeClass('pe-none')
        });

    },
    renderModalUser: function (userLinkTarget) {
        $(userLinkTarget).addClass('pe-none');
        $('div#content').empty();
        $('div#additionalButtons').empty();
        const modal = $(userLinkTarget).data('modal');
        const userId = $(userLinkTarget).data('id');

        if ($('a#updateUser').length === 0) {
            $('div#additionalButtons').append(`
                <a href="${route('admin.users.edit', userId)}" id="updateUser" class="btn btn-success">Update</a>
            `);
        } else {
            $('a#updateUser').attr('href', route('admin.users.edit', userId));
        }

        $.ajax({
            url: route('admin.users.show', userId),
            type: 'get',
        }).done(function (response) {
            $('h5#modalTitle').text("Customer's info");
            $.each(response.user, function(index, value) {
                $('div#content').append(`
                    <div class="mb-2">
                        <strong class="mr-2">${common.getCommonEnumKey(index)}:</strong>
                        <span>${value}</span>
                    </div>
                `);
            })
            $(modal).modal('show');
        }).always(function () {
            $(userLinkTarget).removeClass('pe-none');
        })

    },
    formatReview: function (reviewHeader, reviewContent, response) {
        let rating = '';
        for (let i = 0; i < response.review.rating; i++) {
            rating += '<i class="fas fa-star checked"></i>';
        }
        for (let i = 0; i < (5 - response.review.rating); i++) {
            rating += '<i class="fas fa-star"></i>';
        }

        reviewHeader.append(`
            <span class="fs-5 fw-bold mr-2">${response.review.title}</span>
            <span>${rating}</span>
            <div class="fs-5">Product name: ${response.productName}</div>
            <div class="fs-6">Creator: ${response.userName}</div>
            <div class="fs-6">Create date: ${common.formatDate(response.review.updated_at)}</div>
        `)

        reviewContent.append(`
            <p class="fs-5">${response.review.comment ?? ''}</p>
        `)
    },
    formatReviewStatusFooter: function (target, statuses, status, id) {
        const select = $(`
            <select id="reviewStatus" class="custom-select" data-id=${id}
                onchange="reviews.updateStatus(this)"></select>
        `);
        $.each(statuses, function (index, value) {
            select.append(`
                <option value="${value.id}"
                    ${value.id === status ? 'selected' : ''}>
                    ${value.name.charAt(0).toUpperCase() + value.name.slice(1)}
                </option>
            `)
        })
        $(target).append(select);
    },
}

Dropzone.autoDiscover = false;