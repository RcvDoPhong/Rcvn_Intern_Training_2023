const search = {
    timeInterval: null,
    loopTime: 500,
    searchNavbar: function (searchInput) {
        clearInterval(search.timeInterval);
        search.timeInterval = setInterval(function () {
            const keyword = $(searchInput).val();
            search.clearSearchInput();

            if (keyword) {
                $.ajax({
                    url: route('frontend.home.searchList'),
                    data: {
                        searchName: keyword
                    },
                    type: 'POST'
                }).done(function (response) {
                    const divChild = $('div#search-suggest');

                    if (Object.keys(response.products).length) {
                        divChild.removeClass('d-none');
                        $.each(response.products, function (index, value) {
                            divChild.append(`
                                <ul class="mt-2 md-2">
                                    <li>
                                        <a href="${value.url}">${value.product_name}</a>
                                    </li>
                                </ul>
                            `)
                            // console.log(value.url, value.product_name)
                        })
                    }

                    // console.log(response.url);
                })
            }

            clearInterval(search.timeInterval);
        }, search.loopTime);
    },
    searchElastic: function (searchInput, event) {
        event.preventDefault();
        const form = $('form#searchInput');
        form.attr('action', route('frontend.home.searchElastic'));
        form.submit();
    },
    searchSQL: function (searchInput, event) {
        event.preventDefault();
        const form = $('form#searchInput');
        form.attr('action', route('frontend.home.searchSQL'));
        form.submit();
    },
    clearSearchInput: function () {
        $('div#search-suggest').addClass('d-none');
        $('div#search-suggest').empty();
    }
}

$('input[name="searchName"]').focusout(function () {
    search.clearSearchInput();
})